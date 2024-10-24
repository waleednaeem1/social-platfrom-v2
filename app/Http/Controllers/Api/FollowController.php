<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockedUser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\FollowRequest;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\Notifications;
use App\Models\UserFollow;


class FollowController extends Controller
{

    public function userFollowingList($customer_id)
    {
        $user = User::find($customer_id);
        if(!$user || $user == null){
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $following = UserFollow::with('getUserDetails:id,first_name,last_name,name,username,avatar_location')->where('user_id', $customer_id)->get();
        $followers = UserFollow::with('getUserDetails:id,first_name,last_name,name,username,avatar_location')->where('following_user_id', $customer_id)->get();
        
        foreach($following as $follwing){
            //getting friends and followings record
            if($follwing->getUserDetails){
                $friendRecord = Friend::where(['user_id' => $customer_id, 'friend_id' => $follwing->getUserDetails->id])->first();
                $otherFriendRecord = Friend::where(['friend_id' => $customer_id, 'user_id' => $follwing->getUserDetails->id])->first();
                if($friendRecord || $otherFriendRecord){
                    $follwing->getUserDetails->friend = true;
                    $follwing->friend = true;
                }else{
                    $follwing->getUserDetails->friend = false;
                    $follwing->friend = false;
                }

                $friendReqRecord = FriendRequest::where(['user_id' => $customer_id, 'friend_id' => $follwing->getUserDetails->id, 'status' => 'pending'])->first();
                $otherReqFriendRecord = FriendRequest::where(['friend_id' => $customer_id, 'user_id' => $follwing->getUserDetails->id, 'status' => 'pending'])->first();

                if($friendReqRecord || $otherReqFriendRecord){
                    $follwing->getUserDetails->friendRequest = $friendReqRecord ? $friendReqRecord->user_id : $otherReqFriendRecord->user_id;
                    $follwing->friendRequest = $friendReqRecord ? $friendReqRecord->user_id : $otherReqFriendRecord->user_id;
                }else{
                    $follwing->getUserDetails->friendRequest = false;
                    $follwing->friendRequest = false;
                }
            }
        }
        foreach($followers as $follower){
            //getting friends and followings record
            if($follower->getUserDetailsFollowers){
                $friendRecord = Friend::where(['user_id' => $customer_id, 'friend_id' => $follower->getUserDetailsFollowers->id])->first();
                $otherFriendRecord = Friend::where(['friend_id' => $customer_id, 'user_id' => $follower->getUserDetailsFollowers->id])->first();
                if($friendRecord || $otherFriendRecord){
                    $follower->getUserDetailsFollowers->friend = true;
                    $follower->friend = true;
                }else{
                    $follower->getUserDetailsFollowers->friend = false;
                    $follower->friend = false;
                }
                
                $friendReqRecord = FriendRequest::where(['user_id' => $customer_id, 'friend_id' => $follower->getUserDetailsFollowers->id, 'status' => 'pending'])->first();
                $otherReqFriendRecord = FriendRequest::where(['friend_id' => $customer_id, 'user_id' => $follower->getUserDetailsFollowers->id, 'status' => 'pending'])->first();
    
                if($friendReqRecord || $otherReqFriendRecord){
                    $follower->getUserDetailsFollowers->friendRequest = $friendReqRecord ? $friendReqRecord->user_id : $otherReqFriendRecord->user_id;
                    $follower->friendRequest = $friendReqRecord ? $friendReqRecord->user_id : $otherReqFriendRecord->user_id;
                }else{
                    $follower->getUserDetailsFollowers->friendRequest = false;
                    $follower->friendRequest = false;
                }
                unset($follower->getUserDetailsFollowers);
            }

        }
        return response()->json(['following' => $following , 'followers' =>  $followers,'success' => true], 200);
    }

    public function followUser(Request $request)
    {   
        $user = User::find($request->user_id);
        if(!$user || $user == null){
            return response()->json(['success' => false, 'message' => 'User not found'], 201);
        }

        $following_user = User::find($request->following_user_id);
        $follow = UserFollow::where([['user_id', $request->user_id], ['following_user_id', $request->following_user_id]])->first();
        if ($follow) {
            $follow->delete();
            $following = UserFollow::with('getUserDetails:id,first_name,last_name,name,username,avatar_location')->where('user_id', $request->user_id)->get();
            $followers = UserFollow::with('getUserDetails:id,first_name,last_name,name,username,avatar_location')->where('following_user_id', $request->user_id)->get();
            
            $notification = Notifications::where(['friend_id' => $user->id, 'user_id' => $following_user->id, 'notification_type' => 'user_followed'])->orderBy('id', 'desc')->first();
            if($notification){
                $notification->delete();
            }
            return response()->json(['type' => 'Unfollow', 'message' => 'You are Unfollowing ' . @$following_user->name, 'following' => $following , 'followers' =>  $followers,'success' => true], 200);
            
        } else {

            $follow = new UserFollow();
            $follow->user_id = $request->user_id;
            $follow->following_user_id = $request->following_user_id;
            $follow->created_at = date('Y-m-d H:i:s');
            $follow->save();

            //notification
            $notificationMessage =' followed you.';
            Notifications::sendNotification( $following_user->id, $user->id, 'profile/'.$user->username, 'User Followed', 'user_followed', $notificationMessage );

        }

        $following = UserFollow::with('getUserDetails:id,first_name,last_name,name,username,avatar_location')->where('user_id', $request->user_id)->get();
        $followers = UserFollow::with('getUserDetails:id,first_name,last_name,name,username,avatar_location')->where('following_user_id', $request->user_id)->get();
        return response()->json(['type' => 'Follow', 'message' => 'You are following ' . @$following_user->name, 'following' => $following , 'followers' =>  $followers,'success' => true], 200);


        // $follow = FollowRequest::where([['user_id', $request->user_id], ['following_user_id', $request->following_user_id]])->first();
        // if ($follow) {
        //     $follow->delete();
        //     $following = FollowRequest::with('getUserDetails:id,first_name,last_name,name,username,avatar_location')->where('user_id', $request->user_id)->get();
        //     $followers = FollowRequest::with('getUserDetails:id,first_name,last_name,name,username,avatar_location')->where('following_user_id', $request->user_id)->get();
        //     return response()->json(['type' => 'Unfollow', 'message' => 'Follow request removed' , 'following' => $following , 'followers' =>  $followers,'success' => true], 200);
        // } else {
        //     $follow = new FollowRequest();
        //     $follow->user_id = $request->user_id;
        //     $follow->following_user_id = $request->following_user_id;
        //     $follow->status = 'pending';
        //     $follow->created_at = date('Y-m-d H:i:s');
        //     $follow->save();
        // }

        // $following = UserFollow::with('getUserDetails:id,first_name,last_name,name,username,avatar_location')->where('user_id', $request->user_id)->get();
        // $followers = UserFollow::with('getUserDetails:id,first_name,last_name,name,username,avatar_location')->where('following_user_id', $request->user_id)->get();
        // return response()->json(['type' => 'Follow', 'message' => 'Follow request sent to ' . @$following_user->name, 'following' => $following , 'followers' =>  $followers,'success' => true], 200);
    }

    public function getFollowRequests($userId){
        $user = User::find($userId);
        if(!$user || $user == null){
            return response()->json(['success' => false, 'message' => 'User not found'], 201);
        }

        $friendRequests  = FollowRequest::with('getRequestSender:id,first_name,last_name,username,avatar_location')->where(['user_id'=> $userId, 'status' => 'pending'])->get();
        if($friendRequests){
            return response()->json(['success' => true,'FriendRequests' => $friendRequests], 200);
        }else{
            $friendRequests = [];
            return response()->json(['success' => false,'FriendRequests' => $friendRequests], 201);
        }

    }


    public function submitFollowRequest(Request $request){
        $friendReq = FollowRequest::find($request->follow_request_id);
        if(!$friendReq){
            return response()->json(['success' => false,'message' => 'Request does not exists'], 201);
        }
        //check for already apporved or disapproved
        $check = FollowRequest::where(['id' => $request->follow_request_id, 'status' =>$request->type])->first();
        if ($check) {
            return response()->json(['success' => false,'message' => 'Request already '.$request->type], 200);
        }else{
            $requestData =FollowRequest::find($request->follow_request_id);
            $requestData->status = $request->type;
            $requestData->save();
        }
        UserFollow::firstOrCreate([
            'user_id' => $requestData->user_id,
            'following_user_id' => $requestData->following_user_id
        ]);

        if($request->type == 'approved'){
            return response()->json(['success' => true,'message' => 'Request '.$request->type.' successfully'], 200);
        }elseif($request->type == 'disapproved'){
            return response()->json(['success' => true,'message' => 'Request '.$request->type.' successfully'], 200);
        }
    }

    public function removeFollowingUser(Request $request){
        $user = Customer::find($request->user_id);
        $followingUser = Customer::find($request->following_user_id);
        if(!$user){
            return response()->json(['success' => false, 'message'=> 'User does not exists'],201);
        }

        if(!$followingUser){
            return response()->json(['success' => false, 'message'=> 'Following user does not exists'],201);
        }
        $userFollowedRecord = UserFollow::where(['user_id'=> $request->user_id, 'following_user_id'=> $request->following_user_id])->first();
        if($userFollowedRecord){
            $userFollowedRecord->delete();
            return response()->json(['success' => true, 'message'=> 'You are no longer following '.$followingUser->first_name .' '. $followingUser->last_name],200);
        }else{
            return response()->json(['success' => false, 'message'=> 'Following record not found'],201);
        }
    }

    public function removeFollowerUser(Request $request){
        $user = Customer::find($request->user_id);
        $follower = Customer::find($request->following_user_id);
        if(!$user){
            return response()->json(['success' => false, 'message'=> 'User does not exists'],201);
        }

        if(!$follower){
            return response()->json(['success' => false, 'message'=> 'Follower user does not exists'],201);
        }
        $userFollowedRecord = UserFollow::where(['following_user_id'=> $request->user_id, 'user_id'=> $request->following_user_id])->first();
        if($userFollowedRecord){
            $userFollowedRecord->delete();
            return response()->json(['success' => true, 'message'=> 'Follower removed successfully'],200);
        }else{
            return response()->json(['success' => false, 'message'=> 'Following record not found'],201);
        }
    }

    public function getFollowers($profileUserId, $otherUserId = null){
        $user = Customer::find($profileUserId);
        if(!$user || $user == null){
            
            return response()->json(['success' => false, 'message' => 'User not found'], 201);
        }
        if($otherUserId){
            $blockusers = BlockedUser::where('user_id', $otherUserId)->pluck('blocked_user_id')->toArray();
        }else {
            $blockusers = [];
        }
        $followers = UserFollow::with('getFollowerDetails:id,first_name,last_name,name,username,avatar_location')->whereHas('getFollowerDetails')->where('following_user_id', $profileUserId)->whereNotIn('user_id', $blockusers)->get();
        if(count($followers) > 0) {
            foreach($followers as $follower){
                //getting friends and followings record
                if(isset($follower->getFollowerDetails)){
                    $friendRecord = Friend::where(['user_id' => $otherUserId, 'friend_id' => $follower->getFollowerDetails->id])->first();
                    $otherFriendRecord = Friend::where(['friend_id' => $otherUserId, 'user_id' => $follower->getFollowerDetails->id])->first();
                    if($friendRecord || $otherFriendRecord){
                        $follower->friend = true;
                        $follower->getFollowerDetails->friend = true;
                        $follower->friend = true;
                    }else{
                        $follower->getFollowerDetails->friend = false;
                        $follower->friend = false;
                        $follower->friend = false;
                    }
                    
                    $friendReqRecord = FriendRequest::where(['user_id' => $otherUserId, 'friend_id' => $follower->getFollowerDetails->id, 'status' => 'pending'])->first();
                    $otherReqFriendRecord = FriendRequest::where(['friend_id' => $otherUserId, 'user_id' => $follower->getFollowerDetails->id, 'status' => 'pending'])->first();
        
                    if($friendReqRecord){
                        $follower->getFollowerDetails->friendRequest =  $friendReqRecord->user_id;
                        $follower->friendRequest = $friendReqRecord->user_id;
                        $follower->friendRequestId = $friendReqRecord->id;
                    }else{
                        $follower->getFollowerDetails->friendRequest = false;
                        $follower->friendRequest = false;
                        $follower->friendRequestId = false;
                    }
                    if($otherReqFriendRecord){
                        $follower->getFollowerDetails->otherFriendRequest =  $otherReqFriendRecord->user_id;
                        $follower->otherFriendRequest =  $otherReqFriendRecord->user_id;
                        $follower->friendRequest  = $otherReqFriendRecord->id;
                    }else{
                        $follower->getFollowerDetails->otherFriendRequest = false;
                        $follower->otherFriendRequest = false;
                        $follower->friendRequestId = false;
                    }
                }

            }
        }
        return response()->json(['followers' =>  $followers,'success' => true], 200);
    }

    public function getFollowings($profileUserId , $otherUserId = null){
        $user = Customer::find($profileUserId);
        if(!$user || $user == null){
            return response()->json(['success' => false, 'message' => 'User not found'], 201);
        }
        if($otherUserId){
            $blockusers = BlockedUser::where('user_id', $otherUserId)->pluck('blocked_user_id')->toArray();
        }else {
            $blockusers = [];
        }
        $followings = UserFollow::with('getUserDetails:id,first_name,last_name,name,username,avatar_location')->whereHas('getUserDetails')->where('user_id', $profileUserId)->whereNotIn('following_user_id', $blockusers)->get();
        if(count($followings) > 0) {
            foreach($followings as $following){
                //getting friends and followings record
                if(isset($following->getUserDetails)){
                    $friendRecord = Friend::where(['user_id' => $otherUserId, 'friend_id' => $following->getUserDetails->id])->first();
                    $otherFriendRecord = Friend::where(['friend_id' => $otherUserId, 'user_id' => $following->getUserDetails->id])->first();
                    if($friendRecord || $otherFriendRecord){
                        $following->getUserDetails->friend = true;
                        $following->friend = true;
                    }else{
                        $following->getUserDetails->friend = false;
                        $following->friend = false;
                    }

                    $friendReqRecord = FriendRequest::where(['user_id' => $otherUserId, 'friend_id' => $following->getUserDetails->id, 'status' => 'pending'])->first();
                    $otherReqFriendRecord = FriendRequest::where(['friend_id' => $otherUserId, 'user_id' => $following->getUserDetails->id, 'status' => 'pending'])->first();

                    if($friendReqRecord){
                        $following->getUserDetails->friendRequest = $friendReqRecord->user_id;
                        $following->friendRequest =  $friendReqRecord->user_id;
                        $following->friendRequestId = $friendReqRecord->id;
                    }else{
                        $following->getUserDetails->friendRequest = false;
                        $following->friendRequest = false;
                        $following->friendRequestId = false;
                    }
                    if($otherReqFriendRecord){
                        $following->getUserDetails->otherFriendRequest =  $otherReqFriendRecord->user_id;
                        $following->otherFriendRequest = $otherReqFriendRecord->user_id;
                        $following->friendRequestId = $otherReqFriendRecord->id;
                    }else{
                        $following->getUserDetails->otherFriendRequest = false;
                        $following->otherFriendRequest = false;
                        $following->friendRequestId = false;
                    }
                }
            }
        }
        return response()->json(['followings' => $followings ,'success' => true], 200);
    }
}
