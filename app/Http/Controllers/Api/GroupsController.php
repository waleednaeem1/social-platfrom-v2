<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockedUser;
use App\Models\Group;
use App\Models\GroupFollow;
use App\Models\GroupMembers;
use App\Models\GroupRequests;
use App\Models\GroupsFeed;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function groupListing($userId = null)
    {
        $groups = Group::where(['status' => 'Y'])->get();

        //checking joined record against the parameter id
        foreach($groups as $group){
            $groupMembers = GroupMembers::where(['user_id' => $userId, 'group_id' => $group->id])->first();
            $group->joined = $groupMembers ? true : false;
        }
        return response()->json(array('groups' => $groups),200);
    }

    public function createGroup(Request $request)
    {
        if(!$request->group_name){
            return response()->json(array('success' => false, 'message' => 'Group name is required.'),201);
        }
        if(!$request->user_id){
            return response()->json(array('success' => false, 'message' => 'User id is required.'),201);
        }
        try{
            $group = new Group();
            $group->group_name = $request->group_name;
            $group->group_type = $request->group_type;
            $group->short_description = $request->short_description;
            $group->profile_image = @$_FILES["profile_image"]["name"];
            $group->cover_image = @$_FILES["cover_image"]["name"] ? 'cover-'.@$_FILES["cover_image"]["name"] : "";
            $group->admin_user_id = $request->user_id;
            $group->total_members = 1;
            $group->save();

            //Assign the group to the person who created the group
            $groupMembers = new GroupMembers();
            $groupMembers->group_id = $group->id;
            $groupMembers->user_id = $request->user_id;
            $groupMembers->status = 'Y';
            $groupMembers->save();

            $target_dir = dirname(getcwd()) .'/storage/app/public/images/group-img/'.$group->id;

            if(!is_dir($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }

            if(isset($_FILES["cover_image"])){
                $coverImage = $target_dir.'/'.'cover-'.$_FILES["cover_image"]["name"];
                move_uploaded_file($_FILES["cover_image"]["tmp_name"], $coverImage);
            }
            if(isset($_FILES["profile_image"])){
                $profileImage = $target_dir.'/'.$_FILES["profile_image"]["name"];
                move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profileImage);
            }

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 201);
        }

        return response()->json(array('success' => true, 'message' => 'Group created successfully','group' => $group),200);
    }

    public function groupDetails($groupId , $userId = null)
    {
        $data['groupDetail'] = Group::with('groupMembers')->where(['status' => 'Y', 'id' => $groupId])->first();
        $data['feeds'] = [];
        if($data['groupDetail']){
            $data['success'] = true;
            if($userId  != null){
                $groupMembers = GroupMembers::where(['user_id' => $userId, 'group_id' =>$data['groupDetail']->id])->first();
                $data['groupDetail']->joined = $groupMembers ? true : false;
                            //check is user is admin
                $data['groupDetail']->is_admin = false;
                if($userId == $data['groupDetail']->admin_user_id){
                    $data['groupDetail']->is_admin = true;
                }
            $data['checkRequest'] = GroupRequests::where(['group_id'=> $data['groupDetail']->id, 'user_id' => $userId])->first();
            }
            // $data['feeds'] = GroupsFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,first_name,last_name,name,avatar_location,username')->with('likes.getUserData:id,first_name,last_name,name,username')->where(['approve_feed' => 'Y', 'status' => 'Y', 'group_id' => $groupId])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->get();
            if($userId){
                $blockusers = BlockedUser::where('user_id', $userId)->pluck('blocked_user_id')->toArray();
            }else {
                $blockusers = [];
            }
            $data['feeds'] = GroupsFeed::with([
                'getUser:id,first_name,last_name,avatar_location,cover_image,username',
                'attachments',
                'comments' => function ($query) use ($blockusers) {
                    $query->whereNotIn('user_id', $blockusers);
                },
                'comments.getUserData:id,first_name,last_name,name,avatar_location,username', 
                'likes' => function ($query) use ($blockusers) {
                    $query->whereNotIn('user_id', $blockusers);
                },
                'likes.getUserData:id,first_name,last_name,name,username',
            ])
            ->where(['approve_feed' => 'Y', 'status' => 'Y', 'group_id' => $groupId])
            ->orderBy('created_at', 'DESC')
            ->where('is_deleted','!=' , '1')
            ->get();

            // $data['pendingFeeds'] = GroupsFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,first_name,last_name,name,avatar_location,username')->with('likes.getUserData:id,first_name,last_name,name,username')->where(['approve_feed' => 'N', 'status' => 'Y', 'group_id' => $groupId])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->get();
            $data['pendingFeeds'] = GroupsFeed::with([
                'getUser:id,first_name,last_name,avatar_location,cover_image,username',
                'attachments',
                'comments' => function ($query) use ($blockusers) {
                    $query->whereNotIn('user_id', $blockusers);
                },
                'comments.getUserData:id,first_name,last_name,name,avatar_location,username', 
                'likes' => function ($query) use ($blockusers) {
                    $query->whereNotIn('user_id', $blockusers);
                },
                'likes.getUserData:id,first_name,last_name,name,username',
            ])
            ->where(['approve_feed' => 'N', 'status' => 'Y', 'group_id' => $groupId])
            ->orderBy('created_at', 'DESC')
            ->where('is_deleted','!=' , '1')
            ->get();
            if(isset($data['feeds']) && count($data['feeds']) > 0){
                foreach ($data['feeds'] as $feed) {
                    $feed->time = $feed->created_at->diffForHumans();
                    $Class = optional($feed->pageDetails)->id ? '-page-' : (optional($feed->groupDetails)->id ? '-group-' : '');
                    $feed->url = route('feedDetail', ['id' => base64_encode('feed_' . $Class . '_' . $feed->id)]);
                    $feed['userLike'] = false;
                    foreach($feed->likes as $like){
                        if($like->user_id == $userId){
                            $feed['userLike'] = true;
                        }
                    }
                }
            }

            if(isset($data['pendingFeeds']) && count($data['pendingFeeds']) > 0){
                foreach ($data['pendingFeeds'] as $feed) {
                    $feed->time = $feed->created_at->diffForHumans();
                }
            }

            $data['groupDetail']->creation_time = date('m-d-Y h:i A', strtotime($data['groupDetail']->created_at));
            $data['groupDetail']->total_group_memebers = $data['groupDetail']->groupMembers->count();

            //getting admin details
            $data['groupDetail']['admin_details'] = User::find($data['groupDetail']->admin_user_id, ['id','first_name','last_name','avatar_location','cover_image','username','bio']);
            //getting private group request senders
            if(isset($userId) && $userId == $data['groupDetail']->admin_user_id){
                $data['groupDetail']->groupJoinRequests = GroupRequests::where(['group_id' => $data['groupDetail']->id, 'status' => 'pending' ,'admin_user_id' => $data['groupDetail']->admin_user_id])->get();
            }
            if(isset($data['groupDetail']->groupJoinRequests)){
                foreach($data['groupDetail']->groupJoinRequests as $request) {
                    $request->userDetails = User::find($request->user_id, ['first_name', 'last_name', 'username', 'name', 'avatar_location']);
                }
            }

        }else{
            $data['success'] = false;
            $data['message'] = 'Group not found.';
        }
        return response()->json($data);
    }
    public function joinGroup (Request $request)
    {
        $group = Group::find($request->group_id);
        if(!$group){
            return response()->json(array('success' => false, 'message' => 'Group does not exists.'),200);
        }
        $user = User::find($request->user_id);
        if(!$user){
            return response()->json(array('success' => false, 'message' => 'User does not exists.'),200);
        }
        // check for already existing group joined entry
        $AlreadyGroupMember = GroupMembers::where(['group_id' => $request->group_id, 'user_id'  => $request->user_id])->first();
        if($AlreadyGroupMember){
            $AlreadyGroupMember->delete();
            return response()->json(array('success' => true, 'joined' => false, 'message' => 'Group left successfully.'),200);
        }
        $getGroupDetail = Group::find($request->group_id);
        if($getGroupDetail->group_type == 'Private'){
            $groupRequestsData = GroupRequests::where(['user_id'=> $request->user_id,'group_id'=> $request->group_id])->first();
            if($groupRequestsData){
                $groupRequestsData->delete();
                return response()->json(['success' => true ,'message' => 'Request removed successfully','alreadyJoined' => 0,'Private' => 1], 200);
            }else{

                $data = [
                    'user_id' => $request->user_id,
                    'admin_user_id' => $getGroupDetail->admin_user_id,
                    'group_id' => $request->group_id,
                    'status' => 'pending',
                ];
                $groupRequestsData = GroupRequests::create($data);
                $user = User::find($request->user_id);
                $notificationMessage =' join request for the '.$getGroupDetail->name.' group. ';
                Notifications::sendPrivateGroupJoinNotification($getGroupDetail->admin_user_id, $user ->id, $request->group_id, 'groupdetail/'.$request->group_id, 'Join Group Private Request', 'join_group_private_request', $notificationMessage);
                return response()->json(['success' => true ,'message' => 'Request Sent. You will be added as a member when admin will approve it.','alreadyJoined' => 0,'Private' => 1], 200);
            }
        }elseif($getGroupDetail->group_type == 'Public'){
            $groupMember = new GroupMembers();
            $groupMember->user_id = $request->user_id;
            $groupMember->group_id = $request->group_id;
            $groupMember->status = 'Y';
            $groupMember->save();

            //follwing the group
            $groupFollow = new GroupFollow();
            $groupFollow->user_id = $request->user_id;
            $groupFollow->group_id = $request->group_id;
            $groupFollow->save();
            $notificationMessage =' joined the '.$getGroupDetail->name.' group. ';
            Notifications::sendPrivateGroupJoinNotification($getGroupDetail->admin_user_id, $user ->id, $request->group_id, 'groupdetail/'.$request->group_id, 'Join Group', 'join_group', $notificationMessage);
            return response()->json(array('success' => true, 'joined' => true, 'message' => 'Group joined successfully.'),200);
        }

    }

    public function deleteGroup($id, $userId){
        $group = Group::find($id);
        if(isset($group) && $group->admin_user_id !=$userId){
            return response()->json(array('success' => false, 'message' => 'Only admin can delete the group.'),201);
        }
        if($group){
            $feeds = GroupsFeed::where('group_id', $id)->get();
            if($feeds){
                foreach($feeds as $feed){
                    $feed->is_deleted = 1;
                    $feed->save();
                }
            }
            $group->status= 'N';
            $group->save();
            return response()->json(array('success' => true, 'joined' => true, 'message' => 'Group deleted successfully.'),200);
        }else{
            return response()->json(array('success' => false, 'message' => 'Group does not exists.'),201);
        }
    }

    public function uploadGroupMainImages(Request $request){
        {
            if(!$request->group_id){
                return response()->json(array('success' => false, 'message' => 'Group id is required.'),201);
            }
            $group =  Group::find($request->group_id);
            if(!$group){
                return response()->json(array('success' => false, 'message' => 'Group does not exists.'),201);
            }
            try{
                if(isset($_FILES["cover_image"])){
                    $ext = explode('.', $_FILES['cover_image']['name']);
                    $ext = end($ext);
                    $imagePath = $request->group_id .'-'.time(). '.' . $ext;
                    $imageDir = dirname(getcwd()) .'/storage/app/public/images/group-img/'. $request->group_id.'/'.'cover';
                    if(!is_dir($imageDir))
                    {
                        mkdir($imageDir, 0777, true);
                    }
                    $path = dirname(getcwd()) .'/storage/app/public/images/group-img/'. $request->group_id.'/'.'cover'.'/'.$imagePath;
                    move_uploaded_file($_FILES['cover_image']['tmp_name'], $path); // image uploading

                    Group::where('id', $request->group_id)->update(['cover_image' => $imagePath]);


                    $target_dir = dirname(getcwd()) .'/storage/app/public/images/group-img/'.$group->id;
                }
                if(isset($_FILES["profile_image"])){
                    $profileImage = $target_dir.'/'.$_FILES["profile_image"]["name"];
                    move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profileImage);
                    $group->profile_image = @$_FILES["profile_image"]["name"];
                }

                $group->save();

            } catch (\Throwable $th) {
                return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 201);
            }

            return response()->json(array('success' => true, 'message' => 'Group image uploaded successfully','group' => $group),200);
        }

    }

    public function leaveGroup(Request $request)
    {
        $groupMemberRecord = GroupMembers::where(['group_id'=> $request->group_id, 'user_id'=> $request->user_id])->first();
        $groupFollowRecord = GroupFollow::where(['group_id'=> $request->group_id, 'user_id'=> $request->user_id])->first();
        if ($groupMemberRecord) {
            $groupMemberRecord->delete();
        }else{
            return response()->json(['message' => 'Group record not found', 'success' => false], 201);
        }
        if($groupFollowRecord){
            $groupFollowRecord->delete();
            $group = Group::find($request->group_id);
            $group->total_members = $group->total_members -1;
            $group->save();
        }
        return response()->json(['message' => 'Group left successfully',  'success' => true], 200);
    }

    public function UserJoinedGroups($userId){

        $groups = Group::whereHas('groupMembersData' , function ($q) use ($userId){
            $q->where('user_id', $userId);
        })->where(['status' => 'Y'])->get();

        return response()->json(array('groups' => $groups),200);

    }

    public function addGroupParticipant($groupId, $adminUserId, $userId){
        $group = Group::find($groupId);
        if(!$group){
            return response()->json(array('success' => false, 'message' => 'Group does not exists.'),200);
        }
        $user = User::find($userId);
        if(!$user){
            return response()->json(array('success' => false, 'message' => 'User does not exists.'),200);
        }
        if($group->admin_user_id != $adminUserId){
            return response()->json(array('success' => false, 'message' => 'Only admin can add participants.'),200);
        }
        // check for already group member
        $AlreadyGroupMember = GroupMembers::where(['group_id' => $groupId, 'user_id'  => $userId])->first();
        if($AlreadyGroupMember){
            return response()->json(array('success' => true, 'joined' => false, 'message' => 'This User is already member of selected group.'),200);
        }
        $groupMember = new GroupMembers();
        $groupMember->user_id = $userId;
        $groupMember->group_id = $groupId;
        $groupMember->status = 'Y';
        $groupMember->save();

        //adding member count in group table
        $group->total_members = $group->total_members + 1;
        $group->save();
        return response()->json(array('success' => true, 'joined' => true, 'message' => 'Group member added successfully.'),200);
    }
    public function removeGroupParticipant($groupId, $adminUserId, $userId){
        $group = Group::find($groupId);
        if(!$group){
            return response()->json(array('success' => false, 'message' => 'Group does not exists.'),200);
        }
        $user = User::find($userId);
        if(!$user){
            return response()->json(array('success' => false, 'message' => 'User does not exists.'),200);
        }
        if($group->admin_user_id != $adminUserId){
            return response()->json(array('success' => false, 'message' => 'Only admin can remove participants.'),200);
        }

        $groupMember = GroupMembers::where(['group_id' => $groupId, 'user_id' => $userId])->first();
        if(isset($groupMember)){
            $groupMember->delete();
        }
        $groupFollowRecord = GroupFollow::where(['group_id'=> $groupId, 'user_id'=> $userId])->first();
        if(isset($groupFollowRecord)){
            $groupFollowRecord->delete();
        }
        //removing member count in group table
        if($group->total_members > 0){
            $group->total_members = $group->total_members - 1;
            $group->save();
        }
        return response()->json(array('success' => true, 'joined' => true, 'message' => 'Group member removed successfully.'),200);
    }
    public function viewGroupParticipant($groupId){
        $group = Group::with('groupMembers')->where('id', $groupId)->where(['status' => 'Y'])->first();
        foreach($group->groupMembers as $member){
            $member->isAdmin = false;
            if($group->admin_user_id == $member->user_id){
                $member->isAdmin = true;
            }
        }
        return response()->json(array('group' => $group),200);
    }

    public function unFollowGroup (Request $request){
        $groupFollowRecord = GroupMembers::where(['group_id'=> $request->group_id, 'user_id'=> $request->user_id])->first();
        if(isset($groupFollowRecord)){
            if($groupFollowRecord->follow == 1){
                $groupFollowRecord->update(['follow' => '0']);
                return response()->json(array('success' => true, 'followed' => false, 'message' => 'Group unfollowed successfully.'),200);
            }else{
                $groupFollowRecord->update(['follow' => '1']);
                return response()->json(array('success' => true, 'followed' => true, 'message' => 'Group followed successfully.'),200);
            }
        }
        return response()->json(array('success' => false, 'message' => 'Group follow record does not exists.'),200);
    }

    public function respondGroupRequest(request $request){

        if($request->type =='accepted'){
            GroupRequests::where(['user_id' => $request->user_id, 'admin_user_id' => $request->admin_user_id, 'group_id' => $request->group_id])->update(['status' => 'accepted']);
            $data = [
                'group_id' => $request->group_id,
                'user_id' => $request->user_id,
                'status' => 'Y'
            ];
            $groupRequestsData = GroupMembers::create($data);
            return response()->json(['message' => 'Group request accepted successfully', 'user_id' => $request->user_id], 200);
        }elseif($request->type == 'rejected'){
            GroupRequests::where(['user_id' => $request->user_id, 'admin_user_id' => $request->admin_user_id, 'group_id' => $request->group_id])->update(['status' => 'rejected']);
            $checkMember = GroupMembers::where(['group_id' => $request->group_id,'user_id' => $request->user_id, 'status' => 'Y'])->first();
            if($checkMember){
                $checkMember->delete();
            }
            return response()->json(['message' => 'Group request rejected successfully', 'user_id' => $request->user_id], 200);
        }


    }

    public function updateGroupDetails(Request $request){
        $group = Group::find($request->id);
        if(!$group){
            return response()->json(array('success' => false, 'message' => 'Group does not exists.'),201);
        }
        $user = User::find($request->user_id);
        if($user->id == $group->admin_user_id){
            $group->group_type  = $request->group_type;
            $group->group_name  = $request->group_name;
            $group->save();
            return response()->json(array('success' => true, 'message' => 'Group details updated sucessfully.'),201);
        }else{
            return response()->json(array('success' => false, 'message' => 'Only admins can update group details.'),201);
        }
    }

    public function suggestedGroups($userId){
        $user = User::find($userId);
        if(!$user){
            return response()->json(['message' =>'User does not exists', 'success' => false], 201);
        }

        $data['groups'] = Group::whereDoesntHave('groupMembersData', function($query) use ($user){
            $query->where('user_id', $user->id);
        })->where([['status', 'Y'],['admin_user_id', '!=', $user->id]])->limit(3)->get();

        //checking group request against each group
        foreach ($data['groups'] as $group){
            $group->groupRequest = GroupRequests::where(['group_id' => $group->id, 'user_id' => $userId])->select('id','admin_user_id', 'status')->first();
        }
        //checking joined record against the parameter id
        foreach($data['groups'] as $group){
            $groupMembers = GroupMembers::where(['user_id' => $userId, 'group_id' => $group->id])->first();
            $group->joined = $groupMembers ? true : false;
            $group->total_group_memebers = $group->groupMembers()->count();
        }

        return response()->json(['success' => true, 'groups' => $data['groups'] ], 200);
    }

    public function rejectGroupRequest(Request $request)
    {
        GroupRequests::where(['user_id' => $request->user_id, 'group_id' => $request->group_id])->update(['status' => 'rejected']);
        $checkMember = GroupMembers::where(['group_id' => $request->group_id,'user_id' => $request->user_id, 'status' => 'Y'])->first();
        if($checkMember){
            $checkMember->delete();
        }
        return response()->json(['message' => 'Group Request Rejected'], 200);
    }

    public function approveGroupRequest(Request $request)
    {
        GroupRequests::where(['user_id' => $request->user_id, 'group_id' => $request->group_id])->update(['status' => 'accepted']);
        $data = [
            'group_id' => $request->group_id,
            'user_id' => $request->user_id,
            'status' => 'Y'
        ];
        GroupMembers::create($data);
        return response()->json(['message' => 'Group Request Accept Successfully', 'data' => $data], 200);
    }

    public function removeMember(Request $request)
    {
        GroupRequests::where(['user_id' => $request->user_id, 'group_id' => $request->group_id])->update(['status' => 'removed']);
        $checkMember = GroupMembers::where(['group_id' => $request->group_id,'user_id' => $request->user_id, 'status' => 'Y'])->first();
        if($checkMember){
            $checkMember->delete();
        }
        return response()->json(['message' => 'Group Member Removed Successfully'], 200);
    }

}
