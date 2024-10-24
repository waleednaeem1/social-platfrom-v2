<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfileDetails;
use App\Models\Page;
use App\Models\PagesFeed;
use App\Models\PageMembers;
use App\Models\Group;
use App\Models\GroupMembers;
use App\Models\GroupsFeed;
use App\Models\GroupRequests;
use App\Models\FriendRequest;
use App\Models\Feed;
use App\Models\Chat;
use App\Models\Notifications;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function notificationDetails( $id)
    {
        $decryptedId = base64_decode($id);
        $idData = explode("-", $decryptedId);
        $varriables = $idData;
        $data['shareFeed'] = 'true';
        if(isset($varriables['0']) && in_array($varriables['0'], ['feed_like', 'feed_comment', 'feed_comment_like'])){
            $data['feeds'] = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location,first_name,last_name')->with('comments.commentLikes')->with('likes.getUserData:id,username,first_name,last_name')->with('getFavFeed:id,feed_id,user_id')->where(['id' => $varriables['3'], 'type' => 'feed', 'status' => 'Y', 'is_deleted' => 0, 'hide_from_timeline' => 0])->get();
            $data['newsFeeds'] = 'true';
            return view('dashboards.notificationsdetails', compact('data'));
        }
        if(isset($varriables['0']) && in_array($varriables['0'], ['group_feed_comment', 'group_feed_like', 'group_feed_comment_like'])){
            $user = auth()->user();
            $data['feeds'] = GroupsFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,first_name,last_name,name,avatar_location,username')->with('comments.getReplies.getUserData:id,first_name,last_name,name,username,avatar_location')->with('comments.commentLikes')->with('likes.getUserData:id,first_name,last_name,name,username')->where(['status' => 'Y', 'group_id' => $varriables['4'], 'id' => $varriables['3']])->get();
            $data['groupDetail'] = Group::with('groupMembers')->where(['status' => 'Y', 'id' => $varriables['4']])->get();
            $data['groupMemberCount'] = GroupMembers::where(['group_id'=>$varriables['4']])->count();
            $data['allRequests'] = GroupRequests::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->where(['group_id'=> $varriables['4'], 'status' => 'pending'])->get();
            $data['allMembers'] = GroupMembers::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->where(['group_id'=> $varriables['4']])->get();
            $data['checkMember'] = GroupMembers::where(['user_id'=> $user->id,'group_id' => $varriables['4']])->first();
            $checkGroupMember = count(GroupMembers::where(['group_id' => $data['groupDetail'][0]->id, 'user_id' => $user->id])->get());
            $data['groupFeeds'] = 'true';
            return view('dashboards.notificationsdetails', compact('data','checkGroupMember'));
        }
        if(isset($varriables['0']) && in_array($varriables['0'], ['page_feed_like', 'page_feed_comment', 'page_feed_comment_like'])){
            $user = auth()->user();
            $data['pageDetail'] = Page::with('pageMembers')->where(['status' => 'Y', 'id' => $varriables['4']])->get();
            $data['feeds'] = PagesFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData')->with('comments.getReplies.getUserData')->with('comments.commentLikes')->with('likes.getUserData')->where(['status' => 'Y', 'page_id' => $varriables['4'], 'id'=> $varriables['3'] ])->get();
            $checkPageMember = count(PageMembers::where(['page_id' => $varriables['4'], 'user_id' => $user->id])->get());
            $data['pageFeeds'] = 'true';
            return view('dashboards.notificationsdetails', compact('data','checkPageMember'));
        }
        // dd('none');
    }
    
    
    public function shareFeed( $id)
    {
        $decryptedId = base64_decode($id);
        $idData = explode("_", $decryptedId);
        $varriables = $idData;

        // $varriables['0'] define Feed
        // $varriables['1'] define Feed Type
        // $varriables['2'] define Feed ID

        $data['shareFeed'] = 'true';
        if(isset($varriables['1']) && $varriables['1'] == '-group-'){
            $user = auth()->user();
            $data['feeds'] = GroupsFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,first_name,last_name,name,avatar_location,username')->with('comments.getReplies.getUserData:id,first_name,last_name,name,username,avatar_location')->with('comments.commentLikes')->with('likes.getUserData:id,first_name,last_name,name,username')->where(['status' => 'Y', 'id' => $varriables['2']])->get();
            $data['groupDetail'] = Group::with('groupMembers')->where(['status' => 'Y', 'id' => $data['feeds'][0]->group_id])->get();
            $data['groupMemberCount'] = GroupMembers::where(['group_id'=>$data['groupDetail'][0]->id])->count();
            $data['allRequests'] = GroupRequests::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->where(['group_id'=> $data['groupDetail'][0]->id, 'status' => 'pending'])->get();
            $data['allMembers'] = GroupMembers::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->where(['group_id'=> $data['groupDetail'][0]->id])->get();
            $data['checkMember'] = GroupMembers::where(['user_id'=> $user->id,'group_id' => $data['groupDetail'][0]->id])->first();
            $checkGroupMember = count(GroupMembers::where(['group_id' => $data['groupDetail'][0]->id, 'user_id' => $user->id])->get());
            $data['groupFeeds'] = 'true';
            return view('dashboards.shareFeed', compact('data','checkGroupMember'));
        }
        if(isset($varriables['1']) && $varriables['1'] == '-page-'){
            $user = auth()->user();
            $data['feeds'] = PagesFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData')->with('comments.getReplies.getUserData')->with('comments.commentLikes')->with('likes.getUserData')->where(['status' => 'Y', 'id'=> $varriables['2'] ])->get();
            $data['pageDetail'] = Page::with('pageMembers')->where(['status' => 'Y', 'id' => $data['feeds'][0]->page_id])->get();
            $checkPageMember = count(PageMembers::where(['page_id' => $data['feeds'][0]->page_id, 'user_id' => $user->id])->get());
            $data['pageFeeds'] = 'true';
            return view('dashboards.shareFeed', compact('data','checkPageMember'));
        }
        if(isset($varriables['1']) && $varriables['1'] == ''){
            $data['feeds'] = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location,first_name,last_name')->with('comments.commentLikes')->with('likes.getUserData:id,username,first_name,last_name')->with('getFavFeed:id,feed_id,user_id')->where(['id' => $varriables['2'], 'type' => 'feed', 'status' => 'Y', 'is_deleted' => 0, 'hide_from_timeline' => 0])->get();
            $data['newsFeeds'] = 'true';
            return view('dashboards.shareFeed', compact('data'));
        }

        return back();
    }

    public function deleteNotification($id){
        $user = auth()->user();
        $notificationDelete = Notifications::where(['user_id' => $user->id])->where('id', $id)->first();
        if($notificationDelete){
            $notificationDelete->delete();
            return response()->json(['message' => $notificationDelete, 'Success'], 200);
        }else{
            return response()->json(['message' => $notificationDelete, 'Error'], 500);
        }
    }

    public function notificationreadbadge(Request $request)
    {
        $check = Notifications::where(['user_id' => auth()->user()->id,'notification_badge_read' => 0])->get();
        if (isset($check))
            {
                foreach($check as $checkSingle){
                    $checkSingle->notification_badge_read = 1;
                    $checkSingle->save();
                }
            }
    }

    public function getBadgeDataBodyheader(){
        $user = auth()->user();

        $userOnline = User::find($user->id);
        
        $userOnline->update(['last_online_at' => Carbon::now()]);

        $lastSixWeeks = Carbon::now()->subWeeks(6);
        $getNotificationBadge = Notifications::where(['user_id' => $user->id,'notification_badge_read'=> 0])->where('created_at', '>=', $lastSixWeeks)->count();
        $getFriendRequest = FriendRequest::with('getRequestSender')->where(['friend_id' => $user->id])->where(['status' => 'pending', 'uncheck_request' => '0'])->count();
        $getChats = Chat::getChatsNewCount();

        return response()->json(['notifications' => $getNotificationBadge,'chats' => $getChats,'friendRequest' => $getFriendRequest, 'Success'], 200);
    }

    public function readNotification($id)
    {
        $check = Notifications::where(['user_id' => auth()->user()->id,'viewed' => 0, 'id' => $id])->first();
        if (isset($check))
        {
            $check->viewed = 1;
            $check->save();
        }
    }

    public function notification(Request $request)
    {
        $user = auth()->user();
        if($user)
        {
            $userProfileDetails = UserProfileDetails::firstOrCreate([
                'user_id' => $user->id,
            ]);


            $userNotificationBadgeRead = Notifications::where(['user_id' => $user->id,'notification_badge_read'=> 0])->count();
            $lastSixWeeks = Carbon::now()->subWeeks(6);
            $data['userNotificationsCount'] = Notifications::where(['user_id' => $user->id,'viewed'=> 0])->where('created_at', '>=', $lastSixWeeks)->count();
            if($userProfileDetails->content_notification == 'disable'){
                $selectedNotifications = ['friend_request', 'user_followed', 'accept_friend_request'];
                $userNotification = Notifications::with('getUser:id,avatar_location')->whereIn('notification_type', $selectedNotifications)->where(['user_id' => $user->id])->where('created_at', '>=', $lastSixWeeks)->orderBy('created_at','desc')->get();
            }else{
                $userNotification = Notifications::with('getUser:id,avatar_location')->where(['user_id' => $user->id])->where('created_at', '>=', $lastSixWeeks)->orderBy('created_at','desc')->get();
            }
            $data['userNotifications'] = $userNotification;
        }
        return view('dashboards.notification', compact('data'));
    }
}
