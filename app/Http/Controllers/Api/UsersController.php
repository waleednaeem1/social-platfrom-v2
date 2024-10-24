<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockedUser;
use App\Models\Customer;
use App\Models\Feed;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\Group;
use App\Models\Notifications;
use App\Models\Page;
use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function searchUsers(Request $request){
        $filter = (array) array_merge(['keywords' => @$request->search_input], $request->except('search_input'));
        $users = $this->getUsers($filter);
        return response()->json($users, 200);
    }

    public function getUsers(array $filter = []){
        if(isset($filter['user_id'])){
            $blockedFriendIds= BlockedUser::Where('user_id', $filter['user_id'])->pluck( 'blocked_user_id')->toArray();
            $otherBlockedFriendIds= BlockedUser::Where('blocked_user_id', $filter['user_id'])->pluck( 'user_id')->toArray();
        }
        $query = Customer::where('soft_delete', '!=' , 1)->where([ 'allow_on_vt_friend' => 1])->select('id', 'name', 'first_name', 'last_name','username', 'email', 'address', 'phone', 'gender', 'dob', 'country_id', 'avatar_location', 'type');
        $group = Group::with('groupAdminUser')->where('status','Y')->select('id','group_name','short_description','profile_image', 'cover_image','admin_user_id');
        $page = Page::with('pageAdminUser')->where('status','Y')->select('id','page_name','bio','profile_image','admin_user_id');
        if (isset($filter['keywords'])) {
            $keywords = $filter['keywords'];
            $singular = Str::singular($keywords);
            $plural = Str::plural($keywords);
            $search = [];
            array_push($search, $keywords);
            if ($singular != $keywords)
                array_push($search, $singular);
            if ($plural != $keywords)
                array_push($search, $plural);

            $query->where(function ($query) use ($search) {
                foreach ($search as $keyword) {
                    $query->orWhere('first_name', 'like', $keyword . '%')->orWhere('first_name', 'like', '%'.$keyword . '%');
                    $query->orWhere('last_name', 'like', $keyword . '%')->orWhere('last_name', 'like', '%'. $keyword . '%');
                    $query->orWhere('username', 'like', $keyword . '%')->orWhere('username', 'like', '%'. $keyword . '%');
                    $query->orWhere('name', 'like', $keyword . '%')->orWhere('name', 'like', '%'. $keyword . '%');
                    $query->orWhere('email', 'like', $keyword . '%');
                    $query->orWhere(DB::raw("CONCAT(users.first_name,' ',users.last_name)"), 'like', $keyword . '%');
                }
            });
            $group->where(function ($group) use ($search) {
                foreach ($search as $keyword) {
                    $group->orWhere('group_name', 'like', $keyword . '%')->orWhere('group_name', 'like', '%'.$keyword . '%');
                    $group->orWhere('short_description', 'like', $keyword . '%')->orWhere('short_description', 'like', '%'. $keyword . '%');
                }
            });
            $page->where(function ($page) use ($search) {
                foreach ($search as $keyword) {
                    $page->orWhere('page_name', 'like', $keyword . '%')->orWhere('page_name', 'like', '%'.$keyword . '%');
                    $page->orWhere('bio', 'like', $keyword . '%')->orWhere('bio', 'like', '%'. $keyword . '%');
                }
            });
            $groups = $group->get();
            foreach($groups as $group){
                $group->type = 'group';
                $group->username = $group->group_name;
            }
            $pages = $page->get();
            foreach($pages as $page){
                $page->type = 'page';
                $page->username = $page->page_name;
            }

            if(isset($filter['user_id'])){
                $users = $query->whereNotIn('id',$blockedFriendIds )->whereNotIn('id',$otherBlockedFriendIds )->get();
            }else{
                $users =  $query->where([ 'allow_on_vt_friend' => 1])->where([ 'allow_on_vt_friend' => 1])->select('id', 'name', 'first_name','username', 'last_name', 'email', 'address', 'phone', 'gender', 'dob', 'country_id', 'avatar_location', 'type')->get();
            }
            foreach($users as $user){
                $user->type = 'user';
            }
        }
        $data = $users->merge($groups)->merge($pages);
        //Check for friend true or not and friend request sent or not
        if(isset($filter['user_id'])){
            foreach ($users as $user) {
                $user->followersCount = count($user->followers);
                unset($user->followers);
                $user->friend = false;
                $user->requestSent = false;
                $user->requestReceived = false;
                $checkForFriend = Friend::where(['user_id' => $filter['user_id'], 'friend_id' => $user->id])->first() ? true : false;
                $checkForOtherFriend = Friend::where(['friend_id' => $filter['user_id'], 'user_id' => $user->id])->first() ? true : false;

                $checkForRequest = FriendRequest::where(['user_id' => $filter['user_id'], 'friend_id' => $user->id])->first() ? true : false;
                $checkForOtherRequest = FriendRequest::where(['friend_id' => $filter['user_id'], 'user_id' => $user->id])->first() ? true : false;

                if($checkForFriend || $checkForOtherFriend ){
                    $user->friend = true;
                }

                if($checkForRequest){
                    $user->requestSent = true;
                }elseif($checkForOtherRequest){
                    $user->requestReceived = true;
                }
            }
        }

        return $data;
    }

    public function getFriendRequests($userId){
        $friendRequests  = FriendRequest::with('getRequestSender:id,first_name,last_name,username,avatar_location')->where(['friend_id'=> $userId, 'status' => 'pending'])->get();
        $uncheckRequestCount = 0;
        foreach($friendRequests as $request){
            $request->time = $request->updated_at->diffForHumans();
            $request->viewed = true;
            if($request->uncheck_request == 1){
                $uncheckRequestCount ++;
                $request->viewed = false;
            }
        }
        return response()->json(['success' => true, 'uncheckRequestCount' =>  $uncheckRequestCount,'FriendRequests' => $friendRequests], 200);

    }

    public function sendFriendRequest(Request $request){
        $data = $request->all();
        $receiver = Customer::find($request->receiver_id);
        $sender = Customer::find($request->sender_id);
        if(!$receiver){
            return response()->json(['success' => false, 'error'=> 'receiver user does not exists'],201);
        }

        if(!$sender){
            return response()->json(['success' => false, 'error'=> 'sender user does not exists'],201);
        }

        //check for already request sent
        // FriendRequest::whereIn('user_id', [$request->receiver_id, $request->sender_id])->whereIn('friend_id', [$request->receiver_id, $request->sender_id])->whereIn('status', ['rejected', 'unfriend'])->delete();
        $FriendRequestMultiple = FriendRequest::whereIn('user_id', [$request->receiver_id, $request->sender_id])->whereIn('friend_id', [$request->receiver_id, $request->sender_id])->get();
        if($FriendRequestMultiple->count() > 1){
            foreach($FriendRequestMultiple as $key => $FriendRequestSingle){
                if($key != 0 ){
                    $FriendRequestSingle->delete();
                }
            }
        }


        // $reverseCheck = FriendRequest::where(['user_id' => $request->receiver_id, 'friend_id' => $request->sender_id])->first();
        // //check if other user has also sent the friend reuqest to current user
        // $check = FriendRequest::where(['friend_id' => $request->receiver_id, 'user_id' => $request->sender_id])->first();
        // if($check){
        //     if($check->status == 'unfriend' || $check->status == 'rejected'){
        //         FriendRequest::where(['friend_id' => $request->receiver_id, 'user_id' => $request->sender_id])->update(['status' => 'pending']);
        //         $notificationMessage =' sent you friend request.';
        //         $notification = Notifications::sendNotification( $receiver->id, $sender->id, 'profile/'.$sender->username, 'User Friend Request', 'friend_request', $notificationMessage );
        //         return response()->json(['success' => true,'message' => 'Request updated successfully', 'receiver' => $receiver], 200);

        //     }else{
        //         $check->delete();
        //     }
        //     $notification = Notifications::whereIn('user_id', [$request->receiver_id, $request->sender_id])->whereIn('friend_id', [$request->receiver_id, $request->sender_id])->where(['notification_type' => 'friend_request'])->orderBy('id', 'desc')->first();
        //     if($notification){
        //         $notification->delete();
        //     }
        //     return response()->json(['success' => true,'message' => 'Request removed successfully'], 200);
        // }elseif($reverseCheck){
        //     // if($reverseCheck->status == 'unfriend' || $reverseCheck->status == 'rejected'){
        //     //     FriendRequest::where(['user_id' => $request->receiver_id, 'friend_id' => $request->sender_id])->update(['user_id' => $request->sender_id, 'friend_id' => $request->receiver_id, 'status' => 'pending']);
        //     //     $notificationMessage =' sent you friend request.';
        //     //     $notification = Notifications::sendNotification( $receiver->id, $sender->id, 'profile/'.$sender->username, 'User Friend Request', 'friend_request', $notificationMessage );
        //     //     return response()->json(['success' => true,'message' => 'Request updated successfully', 'receiver' => $receiver], 200);

        //     // }else{
        //     //     $reverseCheck->delete();
        //     // }
        //     // $notification = Notifications::whereIn('user_id', [$request->receiver_id, $request->sender_id])->whereIn('friend_id', [$request->receiver_id, $request->sender_id])->where(['notification_type' => 'friend_request'])->orderBy('id', 'desc')->first();
        //     // if($notification){
        //     //     $notification->delete();
        //     // }
        //     // return response()->json(['success' => true,'message' => 'Request removed successfully'], 200);
        //     return response()->json(['success' => true,'message' => 'Request already sent by other user'], 200);
        // }
        $checkFriendRequest = FriendRequest::where('friend_id', $request->receiver_id)->where('user_id', $request->sender_id)->first();
        $checkFriendRequestHave = FriendRequest::where('friend_id', $request->sender_id)->where('user_id', $request->receiver_id)->first();
        if($checkFriendRequest || $checkFriendRequestHave){
            if(isset($checkFriendRequestHave->friend_id) == $request->sender_id){
                if($checkFriendRequestHave->status == 'pending'){
                    return response()->json(['success' => true,'message' => 'Request already sent by other user'], 200);
                }
                $checkFriendRequestHave->friend_id = $request->receiver_id;
                $checkFriendRequestHave->user_id = $request->sender_id;
                $checkFriendRequestHave->status = 'pending';
                $checkFriendRequestHave->uncheck_request = '1';
                $checkFriendRequestHave->save();

                $checkFollow = UserFollow::where(['following_user_id' => $request->receiver_id ,'user_id' => $request->sender_id])->first();
                if(empty($checkFollow))
                {
                    $addToFollow = new UserFollow;
                    $addToFollow->user_id = $request->sender_id;
                    $addToFollow->following_user_id = $request->receiver_id;
                    $addToFollow->save();

                    $notificationMessage = ' followed you.';
                    $requestSendNotify = Notifications::sendNotification( $request->receiver_id, $request->sender_id, 'profile/'.$request->sender_id, 'User Followed', 'user_followed', $notificationMessage );
                }
                $addToFriend = $checkFriendRequestHave->refresh();
            }else{
                if($checkFriendRequest->status == 'pending'){
                    Notifications::where(['friend_id' => $checkFriendRequest->user_id, 'user_id' => $checkFriendRequest->friend_id])->whereIn('notification_type', ['friend_request'])->delete();
                    $checkFriendRequest->delete();
                    return response()->json(['success' => true,'message' => 'Request removed successfully'], 200);
                }
                $checkFriendRequest->status = 'pending';
                $checkFriendRequest->uncheck_request = '1';
                $checkFriendRequest->save();

                $checkFollow = UserFollow::where(['following_user_id' => $request->receiver_id ,'user_id' => $request->sender_id])->first();
                if(empty($checkFollow))
                {
                    $addToFollow = new UserFollow;
                    $addToFollow->user_id = $request->sender_id;
                    $addToFollow->following_user_id = $request->receiver_id;
                    $addToFollow->save();

                    $notificationMessage = ' followed you.';
                    $requestSendNotify = Notifications::sendNotification( $request->receiver_id, $request->sender_id, 'profile/'.$request->sender_id, 'User Followed', 'user_followed', $notificationMessage );
                }
                $addToFriend = $checkFriendRequest->refresh();
            }
            if($request->sender_id !== $request->receiver_id){
                $notificationMessage = ' sent you friend request.';
                $requestSendNotify = Notifications::sendNotification( $request->receiver_id, $request->sender_id, 'profile/'.$request->sender_id, 'User Friend Request', 'friend_request', $notificationMessage );
            }
            return response()->json(['success' => true,'message' => 'Request update successfully', 'receiver' => $receiver], 200);
        }
        else{
            FriendRequest::firstOrCreate([
                'user_id' => $request->sender_id,
                'friend_id' => $request->receiver_id,
                'status' => 'pending',
                'uncheck_request' => '1'
            ]);
            //follow the user
            $followRecord = UserFollow::where(['user_id' => $request->sender_id, 'following_user_id' =>$request->receiver_id ])->first();
            if(!$followRecord){
                $follow = new UserFollow();
                $follow->user_id = $request->sender_id;
                $follow->following_user_id = $request->receiver_id;
                $follow->created_at = date('Y-m-d H:i:s');
                $follow->save();

                //notification
                $user = User::find($request->sender_id);
                $following_user = User::find($request->receiver_id);
                $notificationMessage =' followed you.';
                Notifications::sendNotification( $following_user->id, $user->id, 'profile/'.$user->username, 'User Followed', 'user_followed', $notificationMessage );
            }
            $receiver->friend = Friend::where(['user_id'=> $receiver->id , 'friend_id'=> $sender->id])->first() ? true : false;
            $friendRequestData = FriendRequest::where(['friend_id' => $sender->id, 'user_id' => $receiver->id, 'status' => 'pending'])->first();
            $receiver->friendRequest = $friendRequestData ? true : false;
            if ($friendRequestData !=null  && $receiver->friendRequest == true) {
                $receiver->friend_request_status =  $friendRequestData->status;
            }
            $receiver->follow = UserFollow::where(['user_id'=> $sender , 'following_user_id'=> $receiver->id])->first() ? true : false;
            $receiver->followBack = UserFollow::where(['following_user_id'=> $sender , 'user_id'=> $receiver->id])->first() ? true : false;

            $receiver->total_followings = UserFollow::where('user_id', $receiver->id)->count();
            $receiver->total_followers = UserFollow::where('following_user_id', $receiver->id)->count();
            $receiver->total_posts_count = Feed::where(['user_id' => $receiver->id, 'type' => 'feed'])->count();

            //notification for reuqest
            $notificationMessage =' sent you friend request.';
            $notification = Notifications::sendNotification( $receiver->id, $sender->id, 'profile/'.$sender->username, 'User Friend Request', 'friend_request', $notificationMessage );
            return response()->json(['success' => true,'message' => 'Request sent successfully', 'receiver' => $receiver], 200);
        }
    }

    public function submitFriendRequest(Request $request){
        $friendReq = FriendRequest::find($request->request_id);
        if(!$friendReq){
            return response()->json(['success' => false,'message' => 'Request does not exists'], 201);
        }
        //check for already apporved or disapproved
        $check = FriendRequest::where(['id' => $request->request_id, 'status' =>$request->type])->first();
        if($check ){
            return response()->json(['success' => false,'message' => 'Request already '.$request->type], 200);
        }

        $user = Customer::find($friendReq->friend_id);
        $accepter = Customer::find($friendReq->user_id);
        if($request->type == 'approved'){
            $notificationMessage =' accepted your friend request.';
            Notifications::sendNotification($friendReq->user_id, $friendReq->friend_id, 'profile/'.$user->id, 'User Accept Friend Request', 'accept_friend_request', $notificationMessage);
            $friendReq->status ='accepted';
            $friendReq->save();

            //creating friend
            Friend::firstOrCreate([
                'user_id' => $friendReq->user_id,
                'friend_id' => $friendReq->friend_id
            ]);

            //creating the following record
            // $followRecord = UserFollow::where(['user_id' => $accepter->id, 'following_user_id' =>$user->id ])->first();
            // if(!$followRecord){
            //     $follow = new UserFollow();
            //     $follow->user_id = $accepter->id;
            //     $follow->following_user_id = $user->id;
            //     $follow->created_at = date('Y-m-d H:i:s');
            //     $follow->save();
            // }

            return response()->json(['success' => true,'message' => 'Request '.$request->type.' successfully, You are now friend with '.$accepter->first_name.''.$accepter->last_name], 200);
        }elseif($request->type == 'disapproved'){
            $friendReq->status ='rejected';
            Notifications::where(['friend_id' => $friendReq->user_id, 'user_id' => $friendReq->friend_id])->whereIn('notification_type', ['friend_request'])->delete();
            $friendReq->save();
            return response()->json(['success' => true,'message' => 'Request '.$request->type.' successfully'], 200);
        }
    }

    public function getAllFriends($userId){
        $user = Customer::find($userId);
        if(!$user || $user == null){
            return response()->json(['success' => false, 'message' => 'User not found'], 201);
        }
        $friendsList=[];
        $friendsList = Friend::where('user_id',$userId)->orWhere('friend_id',$userId)->get();
        if($friendsList){

            foreach ($friendsList as $friend){
               $friend->getUserDataSelectedColumns;
            }
            return response()->json(['success' => true,'friendsList' => $friendsList], 200);
        }else{
            return response()->json(['success' => true,'friendsList' => $friendsList], 200);
        }
    }

    public function removeFriend(Request $request){
        $user = Customer::find($request->user_id);
        $friend = Customer::find($request->friend_id);
        if(!$user){
            return response()->json(['success' => false, 'message'=> 'User does not exists'],201);
        }

        if(!$friend){
            return response()->json(['success' => false, 'message'=> 'Friend user does not exists'],201);
        }

        $friendRecord = Friend::where(['user_id' => $request->user_id, 'friend_id' => $request->friend_id])->first();
        $otherFriendRecord =Friend::where(['friend_id' => $request->user_id, 'user_id' => $request->friend_id])->first();

        // $friendReqRecord = FriendRequest::where(['user_id' => $request->user_id, 'friend_id' => $request->friend_id])->first();
        // $otherFriendReqRecord =FriendRequest::where(['friend_id' => $request->user_id, 'user_id' => $request->friend_id])->first();
        if($friendRecord)
            $friendRecord->delete();
        if($otherFriendRecord)
            $otherFriendRecord->delete();

        $friendRequestUpdateStatus = FriendRequest::whereIn('user_id', [$request->user_id, $request->friend_id])->whereIn('friend_id', [$request->user_id, $request->friend_id])->update(['status' => 'unfriend']);

        return response()->json(['success' => true,'message' => 'You are no longer friend with '.$friend->first_name.' '. $friend->last_name ], 200);
    }

    public function searchFriends(Request $request){
        $filter = (array) array_merge(['keywords' => @$request->search], $request->except('search'));
        $users = $this->getFriends($request->search,$request->user_id);
        return response()->json($users, 200);
    }

    public function getFriends($filter, $userId){
        $friendIds= Friend::where([ 'user_id' => $userId])->pluck('friend_id' )->toArray();
        $otherFriendIds= Friend::Where('friend_id', $userId)->pluck( 'user_id')->toArray();
        $allfriends = [...$friendIds,...$otherFriendIds];
        if(isset($allfriends)){
            $query = Customer::whereIn('id',$allfriends)->where([ 'type' => 'customer'])->where([ 'soft_delete', '!=', 1])->select('id', 'name', 'first_name', 'last_name','username', 'email', 'address', 'phone', 'gender', 'dob', 'country_id', 'avatar_location', 'type');

            $query->where(function ($query) use ($filter) {

                $query->orWhere('first_name', 'like', '%' . $filter . '%');
                $query->orWhere('last_name', 'like', '%' . $filter . '%');
                $query->orWhere('name', 'like', '%' . $filter . '%');
                $query->orWhere('email', 'like', '%' . $filter . '%');
                $query->orWhere('username', 'like', '%' . $filter . '%');

            });
            $users = $query->get();
        }
        else
        {
            $users = Customer::where(['type' => 'customer'])->where([ 'soft_delete', '!=', 1])->select('id', 'name', 'first_name','username', 'last_name', 'email', 'address', 'phone', 'gender', 'dob', 'country_id', 'avatar_location', 'type')->get();

        }


        return $users;
    }

    public function blockedUsersList($userId){
        $user = Customer::find($userId);
        if(!$user){
            return response()->json(['success' => false, 'message'=> 'User does not exists.'],201);
        }
        $blockedUsersList =BlockedUser::with('getUserDataSelectedColumns')->where('user_id',$userId)->get();
        return response()->json(['success' => true, 'blockedUsersList' => $blockedUsersList],200);
    }

    public function allowUser($email){
        $user = User::where('email',$email)->first();
        if( $user->allow_on_vt_friend == 1){
            return response()->json([ 'success' => false,'error' => 'Already registered on Devsinc.'], 201);
        }
        $user->allow_on_vt_friend = 1;
        $user->save();
        if($user->email_verified_at == null) {
            (new User())->verificationEmail($user);
            return response()->json([ 'success' => true,'error' => 'Registered on Devsinc successfully. Please check your email and verify before sign in.'], 200);
        }
        return response()->json(['success' => true,'message' => 'Registered on Devsinc successfully. Please enter your credentials to sign in'],200);
    }

    public function blockuser(Request $request){

        $user = Customer::find($request->user_id);
        $blocked_user = Customer::find($request->blocked_user_id);
        if(!$user){
            return response()->json(['success' => false, 'message'=> 'User does not exists.'],201);
        }

        if(!$blocked_user){
            return response()->json(['success' => false, 'message'=> 'Blocked user does not exists.'],201);
        }

        if($request->type == 'block'){
            BlockedUser::create([
                'user_id' => $request->user_id,
                'blocked_user_id' => $request->blocked_user_id,
            ]);
            $friendRecord = Friend::where(['user_id' => $request->user_id, 'friend_id' => $request->blocked_user_id])->first();
            $otherFriendRecord = Friend::where(['friend_id' => $request->user_id, 'user_id' => $request->blocked_user_id])->first();
            if(isset($friendRecord))
                $friendRecord->delete();
            if($otherFriendRecord )
                $otherFriendRecord->delete();

            $followerRecord = UserFollow::where(['user_id' => $request->user_id, 'following_user_id' => $request->blocked_user_id])->first();
            $followingRecord = UserFollow::where(['user_id' => $request->blocked_user_id, 'following_user_id' => $request->user_id])->first();
            if(isset($followerRecord))
                $followerRecord->delete();
            if(isset($followingRecord))
                $followingRecord->delete();

            return response()->json(['block' => true,'success' => true, 'message'=> 'User blocked successfully.'],200);
        }elseif($request->type == 'unblock'){

            $record = BlockedUser::where(['user_id' => $request->user_id,'blocked_user_id' => $request->blocked_user_id])->first();
            if($record){
                $record->delete();

                return response()->json(['block' => false, 'success' => true, 'message'=> 'User unblocked successfully.'],200);
            }else{
                return response()->json(['block' => false, 'success' => false, 'message'=> 'Record not found.'],200);
            }
        }else{
            return response()->json(['success' => false, 'message'=> 'Typo mistake: Request type should be \'block\' or \'unblock\'.'],200);
        }

    }

    public function removeRequests($userId){
        //sent requests
        $requests = FriendRequest::where('user_id', $userId)->get();
        //received requests
        $receivedRequests = FriendRequest::where('friend_id', $userId)->get();
        if(isset($requests) && count($requests) > 0){
            $requests->each->delete();
            return response()->json(['success' => true, 'message'=> 'Requests removed successfully.'],200);
        }
        elseif(isset($receivedRequests) && count($receivedRequests) > 0){
            $receivedRequests->each->delete();
            return response()->json(['success' => true, 'message'=> 'Requests removed successfully.'],200);
        }else{
            return response()->json(['success' => false, 'message'=> 'Record not found.'],200);
        }
    }

    public function getFriendsList($user_id, $otherUserId = null)
    {
        $user = User::find($user_id);
        if(isset($user)){

            $data['users'] = $user->getAllFriends(['user_id' => $user_id]);
            //friend and friendrequest record
            if($otherUserId){
                $blockusers = BlockedUser::where('user_id', $otherUserId)->pluck('blocked_user_id')->toArray();
            }else {
                $blockusers = [];
            }
            $data['users'] = $data['users']->whereNotIn('id', $blockusers);
            $data['users'] = $data['users']->values()->all();

            foreach($data['users'] as $user) {
                $friend = Friend::getfriendRecord($otherUserId, $user->id);
                $otherFriend = Friend::getfriendRecord($user->id, $otherUserId);
                if($friend || $otherFriend){
                    $user->friend = true;
                }else{
                    $user->friend = false;
                }
            }

            foreach($data['users'] as $user) {
                $friendReqRecord = FriendRequest::where(['user_id' => $otherUserId, 'friend_id' => $user->id, 'status' => 'pending'])->first();
                $otherReqFriendRecord = FriendRequest::where(['friend_id' => $otherUserId, 'user_id' => $user->id, 'status' => 'pending'])->first();

                if($friendReqRecord){
                    $user->friendRequest = $friendReqRecord->user_id;
                    $user->friendRequestId = $friendReqRecord->id;
                }else{
                    $user->friendRequest = false;
                    $user->friendRequest = false;
                    $user->friendRequestId = false;
                }
                if($otherReqFriendRecord){
                    $user->otherFriendRequest =  $otherReqFriendRecord->user_id;
                    $user->friendRequest  = $otherReqFriendRecord->id;
                }else{
                    $user->otherFriendRequest = false;
                    $user->friendRequestId = false;
                }
            }

            return response()->json($data['users'], 200);
        }
    }

    public function getFriendRequest($user_id)
    {
        $data['users'] = User::with('getfriendrequest.getuser')->where('id', $user_id)->get('id');
        return response()->json(array([ 'users' => $data['users'] ]), 200);
    }

    public function checkUsernameEmail($slug, $type)
    {
        if($type == 'username'){
            $users = User::where('username', $slug)->first();

            if(isset($users))
                return response()->json(['message', 'Username already exist'], 200);

            return response()->json(['message', 'Username not exist'], 200);
        }else{
            $users = User::where('email', $slug)->first();

            if(isset($users))
                return response()->json(['message', 'User email already exist'], 200);

            return response()->json(['message', 'User email not exist'], 200);
        }
    }
}
