<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\GroupMembers;
use App\Models\GroupsFeed;
use App\Models\GroupRequests;
use App\Models\GroupFeedAttachment;
use App\Models\BlockedUser;
use App\Models\Notifications;

class GroupsController extends Controller
{
    public function group()
    {
        $user = auth()->user();
        $data['groups'] = Group::with('groupMembers')->where(['status' => 'Y'])->get();
        return view('dashboards.group',compact('data'));
    }
    public function groupdetail(Request $request)
    {
        $user = auth()->user();
        $blockedFriends = BlockedUser::Where('user_id', $user->id)->pluck( 'blocked_user_id')->toArray();
        $blockedOtherFriends = BlockedUser::Where('blocked_user_id', $user->id)->pluck( 'user_id')->toArray();
        $data['groupDetail'] = Group::with(['groupMembers' => function ($query) use ($blockedFriends, $blockedOtherFriends) {
            $query->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends));
        }])->where(['status' => 'Y', 'id' => $request->id])->get();
        if( !isset($data['groupDetail'][0])){
            return view('pages.error',compact('data'));
        }
        $data['checkMember'] = GroupMembers::where(['user_id'=> $user->id,'group_id'=>$request->id])->first();
        $data['groupMemberCount'] = GroupMembers::where(['group_id'=>$request->id])->count();
        $data['allMembers'] = GroupMembers::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->where(['group_id'=> $request->id])->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends))->get();
        $data['checkRequest'] = GroupRequests::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->where(['group_id'=> $request->id, 'user_id' => auth()->user()->id])->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends))->first();
        $data['groupAdmin'] = User::find($data['groupDetail'][0]->admin_user_id);
        $index = 0;
        $data['allRequestsAll'] = GroupRequests::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->where(['group_id'=> $request->id, 'status' => 'pending'])->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends))->get();
        $data['allRequests'] = [];
        foreach($data['allRequestsAll'] as $key => $allRequests){
            if(isset($allRequests['getUser']->username) ){
                $data['allRequests'][] = $allRequests;
            }
        }

        $data['feeds'] = GroupsFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,first_name,last_name,name,avatar_location,username')->with('comments.getReplies.getUserData:id,first_name,last_name,name,username,avatar_location')->with('comments.commentLikes')->with('likes.getUserData:id,first_name,last_name,name,username')->where(['approve_feed' => 'Y','status' => 'Y', 'group_id' => $request->id, 'is_deleted' => 0])->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends))->orderBy('created_at', 'DESC')->get();
        // dd($data['feeds'][0]);
        $data['pendingFeedApprove'] = GroupsFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,first_name,last_name,name,avatar_location,username')->with('comments.getReplies.getUserData:id,first_name,last_name,name,username,avatar_location')->with('comments.commentLikes')->with('likes.getUserData:id,first_name,last_name,name,username')->where(['approve_feed' => 'N','status' => 'Y', 'group_id' => $request->id, 'is_deleted' => 0])->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends))->orderBy('created_at', 'DESC')->get();
        $data['pendingFeedApproveUser'] = GroupsFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,first_name,last_name,name,avatar_location,username')->with('comments.getReplies.getUserData:id,first_name,last_name,name,username,avatar_location')->with('comments.commentLikes')->with('likes.getUserData:id,first_name,last_name,name,username')->where(['approve_feed' => 'N','status' => 'Y', 'group_id' => $request->id, 'is_deleted' => 0, 'user_id' => auth()->user()->id])->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends))->orderBy('created_at', 'DESC')->get();

        $data['pageName'] = 'groupDetail';
        return view('dashboards.groupdetail',compact('data'));
    }

    public function updateGroupProfilePicture(Request $request)
    {
        $user = auth()->user();
        $uploadOk = 1;

        // Check file size
        if ($_FILES["profileImage"]["size"] > 1000000) {
            return redirect()->route('groupdetail',  ['id' => $request->groupId])->withFlashSuccess(__('Image size is too large.'));
            $uploadOk = 0;
        }
        if (isset($_FILES["profileImage"]["name"])) {
            $ext = explode('.', $_FILES['profileImage']['name']);
            $ext = end($ext);
            $imagePath = $request->groupId .'-'.time(). '.' . $ext;
            if($request->type == 'profile')
            {
                $path = dirname(getcwd()) .'/storage/app/public/images/group-img/'. $request->groupId.'/'. $imagePath;

                $imageDir = dirname(getcwd()) .'/storage/app/public/images/group-img/'. $request->groupId;

                if(!is_dir($imageDir))
                {
                    mkdir($imageDir, 0777, true);
                }
                move_uploaded_file($_FILES['profileImage']['tmp_name'], $path); // image uploading
                Group::where('id', $request->groupId)->update(['profile_image' => $imagePath]);
            }
            else {

                $imageDir = dirname(getcwd()) .'/storage/app/public/images/group-img/'. $request->groupId.'/'.'cover';
                if(!is_dir($imageDir))
                {
                    mkdir($imageDir, 0777, true);
                }
                $path = dirname(getcwd()) .'/storage/app/public/images/group-img/'. $request->groupId.'/'.'cover'.'/'.$imagePath;
                $uploaded = move_uploaded_file($_FILES['profileImage']['tmp_name'], $path); // image uploading
                if($uploaded)
                {
                    echo $uploaded;
                    Group::where('id', $request->groupId)->update(['cover_image' => $imagePath]);
                }
                else{
                    echo "not uploaded";
                }
            }
        }
        return redirect()->route('groupdetail',  ['id' => $request->groupId]);
    }

    public function approveGroupRequest(Request $request)
    {
        GroupRequests::where(['user_id' => $request->requestedUserId, 'admin_user_id' => $request->adminUserId, 'group_id' => $request->groupId])->update(['status' => 'accepted']);
        $data = [
            'group_id' => $request->groupId,
            'user_id' => $request->requestedUserId,
            'status' => 'Y'
        ];
        $groupRequestsData = GroupMembers::create($data);
        $getGroupDetail = Group::find($request->groupId);
        $notificationMessage = 'Welcome to '.$getGroupDetail->group_name.'. Admins have approved your request to join.';
        Notifications::sendPrivateGroupJoinNotification( $request->requestedUserId, auth()->user()->id, $request->groupId, 'groupdetail/'.$request->groupId, 'Join Group Private Request', 'join_group_private_request', $notificationMessage);
        return response()->json(['message' => 'Group Request Accept Successfully', 'requestedUserId' => $request->requestedUserId], 200);
    }

    public function rejectGroupRequest(Request $request)
    {
        GroupRequests::where(['user_id' => $request->requestedUserId, 'admin_user_id' => $request->adminUserId, 'group_id' => $request->groupId])->update(['status' => 'rejected']);
        $checkMember = GroupMembers::where(['group_id' => $request->groupId,'user_id' => $request->requestedUserId, 'status' => 'Y'])->first();
        if($checkMember){
            $checkMember->delete();
        }
        return response()->json(['message' => 'Group Request Rejected', 'requestedUserId' => $request->requestedUserId], 200);
    }
    public function removeMember(Request $request)
    {
        GroupRequests::where(['user_id' => $request->requestedUserId, 'admin_user_id' => $request->adminUserId, 'group_id' => $request->groupId])->update(['status' => 'removed']);
        $checkMember = GroupMembers::where(['group_id' => $request->groupId,'user_id' => $request->requestedUserId, 'status' => 'Y'])->first();
        if($checkMember){
            $checkMember->delete();
        }
        return response()->json(['message' => 'Group Member Removed Successfully', 'requestedUserId' => $request->requestedUserId], 200);
    }

    public function joinGroup(Request $request)
    {
        $getGroupDetail = Group::find($request->groupId);
        $check = GroupMembers::where(['group_id'=> $request->groupId,'user_id'=> $request->userId])->first();
        $checkRequest = GroupRequests::where(['user_id'=> $request->userId,'group_id'=> $request->groupId])->first();
        if($check || $checkRequest){
            if($getGroupDetail->group_type == 'Private'){
                $checkRequest->update(['status' => 'pending']);
                $notificationMessage = ' join request for the '.$getGroupDetail->group_name.' group. ';
                $sendPrivateGroupJoinNotification = Notifications::sendPrivateGroupJoinNotification($getGroupDetail->admin_user_id, auth()->user()->id, $request->groupId, 'groupdetail/'.$request->groupId, 'Join Group Private Request', 'join_group_private_request', $notificationMessage);
            }else{
                $checkRequest->update(['status' => 'accepted']);
                $groupMembers = new GroupMembers;
                $groupMembers->group_id = $request->groupId;
                $groupMembers->user_id = $request->userId;
                $groupMembers->status = 'Y';
                $groupMembers->follow = 1;
                $groupMembers->save();
            }
            return response()->json(['message' => ' Group Joined.','alreadyJoined' => 1], 200);
        }
        else{
            if($getGroupDetail->group_type == 'Private'){
                $groupRequestsData = GroupRequests::where(['user_id'=> $request->userId,'group_id'=> $request->groupId])->first();
                if($groupRequestsData){
                    $notificationMessage = ' join request for the '.$getGroupDetail->group_name.' group. ';
                    $sendPrivateGroupJoinNotification = Notifications::sendPrivateGroupJoinNotification($getGroupDetail->admin_user_id, auth()->user()->id, $request->groupId, 'groupdetail/'.$request->groupId, 'Join Group Private Request', 'join_group_private_request', $notificationMessage);
                    return response()->json(['message' => 'Request Sent. You will be added as a member when admin will approve it.','alreadyJoined' => 0,'Private' => 1], 200);
                }else{

                    $data = [
                        'user_id' => $request->userId,
                        'admin_user_id' => $getGroupDetail->admin_user_id,
                        'group_id' => $request->groupId,
                        'status' => 'pending',
                    ];
                    $groupRequestsData = GroupRequests::create($data);

                    $notificationMessage = ' join request for the '.$getGroupDetail->group_name.' group. ';
                    $sendPrivateGroupJoinNotification = Notifications::sendPrivateGroupJoinNotification($getGroupDetail->admin_user_id, auth()->user()->id, $request->groupId, 'groupdetail/'.$request->groupId, 'Join Group Private Request', 'join_group_private_request', $notificationMessage);
                    return response()->json(['message' => 'Request Sent. You will be added as a member when admin will approve it.','alreadyJoined' => 0,'Private' => 1], 200);
                }
            }
            else{
                $data = [
                    'user_id' => $request->userId,
                    'admin_user_id' => $getGroupDetail->admin_user_id,
                    'group_id' => $request->groupId,
                    'status' => 'accepted',
                ];
                $groupRequestsData = GroupRequests::create($data);
                $groupMembers = new GroupMembers;
                $groupMembers->group_id = $request->groupId;
                $groupMembers->user_id = $request->userId;
                $groupMembers->status = 'Y';
                $groupMembers->follow = 1;
                $groupMembers->save();

                $notificationMessage = ' joined the '.$getGroupDetail->group_name.' group. ';
                $sendGroupJoinNotification = Notifications::sendPrivateGroupJoinNotification($getGroupDetail->admin_user_id, auth()->user()->id, $request->groupId, 'groupdetail/'.$request->groupId, 'Join Group', 'join_group', $notificationMessage);

                return response()->json(['message' => 'Join Group successfully.','alreadyJoined' => 0,'Private' => 0], 200);
            }
        }
    }

    public function leave_group(Request $request)
    {
        $getGroupDetail = Group::find($request->groupId);
        $check = GroupMembers::where(['user_id'=> $request->userId,'group_id'=> $request->groupId])->first();
        if($check && $getGroupDetail->group_type !== 'Private'){
            $check->delete();
            return response()->json(['message' => ' Leaved Group.','alreadyJoined' => 0,'Private' => 0], 200);
        }
        else{
            if($getGroupDetail->group_type == 'Private'){
                $groupRequestsData = GroupRequests::where(['user_id'=> $request->userId,'group_id'=> $request->groupId])->delete();
                Notifications::where(['friend_id' => $request->userId, 'group_id' => $request->groupId])->delete();
                return response()->json(['message' => 'Request Cancel','alreadyJoined' => 0,'Private' => 1], 200);
            }
        }
    }

    public function leaveGroup(Request $request)
    {
        $groupMember = GroupMembers::where(['user_id'=> $request->userId, 'group_id'=> $request->groupId])->first();
        $checkRequest = GroupRequests::where(['group_id'=> $request->groupId])->where(['user_id'=> $request->userId])->first();
        if ($groupMember || $checkRequest) {

            if($groupMember)
                $memberDelete =  $groupMember->delete();

            if($checkRequest)
                $checkRequest->delete();
        }
        return response()->json(['memberDeleted' => $groupMember], 200);
    }

    public function unfollowGroupMember(Request $request)
    {
        $groupMember = GroupMembers::where(['user_id'=> $request->userId,'group_id'=> $request->groupId])->first();
        if ($groupMember) {
            $groupMember->update(['follow' => 0]);
            return response()->json(['Message' => 'unfollow Done.'], 200);
        }
    }
    public function followGroupMember(Request $request)
    {
        $groupMember = GroupMembers::where(['user_id'=> $request->userId,'group_id'=> $request->groupId])->first();
        if ($groupMember) {
            $groupMember->update(['follow' => 1]);
            return response()->json(['Message' => 'unfollow Done.'], 200);
        }
        else{
            return response()->json(['Message' => 'Join Group First'], 200);
        }
    }

    public function createGroup(Request $request)
    {
        // dd($request->all());
        $group = [
            'admin_user_id' => auth()->user()->id,
            'group_name' => $request->groupName,
            'short_description' => $request->shortDescription,
            'group_type' => $request->groupType,
        ];
        $newGroup = Group::create($group);
        $newGroupId = Group::orderBy('id', 'desc')->first();

        $groupMember = [
            'group_id' => $newGroup->id,
            'user_id' => auth()->user()->id,
            'status' => 'Y',
        ];
        $member = GroupMembers::create($groupMember);
        return response()->json(['message' => 'Group Created!', 'groupId' => $newGroupId->id], 200);
        // return redirect()->route('groupdetail',['id' => $newGroup->id])->withFlashSuccess(__('Group Created Successfully.'));
    }

    public function deleteGroup($id)
    {
        $groupFeeds = GroupsFeed::where('group_id', $id)->get();
        if(isset($groupFeeds)){
            $feedIds = $groupFeeds->pluck('id')->toArray();
            $feedAttachments = GroupFeedAttachment::whereIn('groups_feed_id', $feedIds)->delete();
            $groupFeeds = GroupsFeed::whereIn('id', $feedIds)->delete();
        }
        Notifications::where(['group_id'=> $id])->whereIn('notification_type', ['group_feed_like', 'group_feed_comment', 'group_feed_comment_like', 'join_group_private_request', 'join_group'])->delete();
        $group = Group::find($id)->delete();
        return redirect()->route('home')->withFlashSuccess(__('Group Deleted Successfully.'));
    }
}
