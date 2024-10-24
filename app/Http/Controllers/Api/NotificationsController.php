<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockedUser;
use App\Models\Feed;
use App\Models\FriendRequest;
use App\Models\Group;
use App\Models\GroupsFeed;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notifications;
use App\Models\Page;
use App\Models\PagesFeed;
use App\Models\UserProfileDetails;
use Carbon\Carbon;
class NotificationsController extends Controller
{
    public function getUserNotifications($userId){

		$user =  User::find($userId);
		if(isset($user))
		{
			$lastSixWeeks = Carbon::now()->subWeeks(6);
			$blockedFriends = BlockedUser::Where('user_id', $user->id)->pluck( 'blocked_user_id')->toArray();
			$blockedOtherFriends = BlockedUser::Where('blocked_user_id', $user->id)->pluck( 'user_id')->toArray();
			$blockedIds = array_merge($blockedFriends, $blockedOtherFriends);
			$notifications = Notifications::with('getUser:id,avatar_location,first_name,last_name')->where(['user_id' => $userId])->where('notification_delete' ,'!=', '1')->whereNotIn('friend_id', $blockedIds)->where('created_at', '>=', $lastSixWeeks)->orderBy('created_at','desc')->get();
		}
		$uncheckNotificationsCount = 0;
		foreach($notifications as $notification) {
			if($notification->viewed == 0){
				$uncheckNotificationsCount++;
			}

			if($notification->group_id){
				$feed = GroupsFeed::find($notification->feed_id);
			}
			elseif($notification->page_id){
				$feed = PagesFeed::find($notification->feed_id);
			}
			else{
				$feed = Feed::find($notification->feed_id);
			}

			if($feed){
				$notification->feed_user = $feed->getFeedUser;
				if($notification->group_id != null){
					$notification->group_details = Group::where(['status' => 'Y', 'id' => $notification->group_id])->first();
				}
				if($notification->page_id != null){
					$notification->page_details = Page::where(['status' => 'Y', 'id' => $notification->page_id])->first();
				}
			}
		}
		foreach($notifications as $notification){
			$notification->time = $notification->created_at->diffForHumans();
		}

		return response()->json([ 'uncheck_notifications_count' => $uncheckNotificationsCount,'notifications' => $notifications],200);
    }

	public function setNotificationViewed(Request $request){
		$notificationIds = $request->notificationIds;
		if(count($notificationIds) > 0){
			foreach($notificationIds as $notificationId){
				$notification = Notifications::find($notificationId);
				if($notification){
					$notification->viewed = 1;
					$notification->save();
				}
			}
			return response()->json(['success' => true, 'message'=> 'Notification viewed successfully'],200);
		}else{
			return response()->json([ 'success' => false, 'message'=> 'Array is empty'],201);
		}
	}

	public function getSpecificFeedForNotification($feedId,$feedType,$userId){
		if($feedType == 'timeline_feeds'){
			// $feed = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location')->with('likes.getUserData:id,name')->with('shareFeed.shareFeedData', 'shareFeed.shareFeedData.attachments', 'shareFeed.shareFeedData.getUser')->where(['id' => $feedId, 'type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->first();
			if($userId){
				$blockusers = BlockedUser::where('user_id', $userId)->pluck('blocked_user_id')->toArray();
			}else {
				$blockusers = [];
			}
			$feed = Feed::with([
				'getUser:id,first_name,last_name,avatar_location,cover_image,username',
				'attachments',
				'comments' => function ($query) use ($blockusers) {
					$query->whereNotIn('user_id', $blockusers);
				},
				'comments.getUserData:id,name,username,avatar_location', 
				'likes' => function ($query) use ($blockusers) {
					$query->whereNotIn('user_id', $blockusers);
				},
				'likes.getUserData:id,name',
				'shareFeed.shareFeedData',
				'shareFeed.shareFeedData.attachments',
				'shareFeed.shareFeedData.getUser',
			])
			->where(['id' => $feedId, 'type' => 'feed', 'status' => 'Y'])
			->orderBy('created_at', 'DESC')
			->where('is_deleted', '!=' , '1')
			->first();
		}elseif($feedType == 'group_feeds'){
			$feed = GroupsFeed::with('groupDetails')->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getReplies')->with('likes.getUserData:id,name')->with('shareFeed.shareFeedData', 'shareFeed.shareFeedData.attachments', 'shareFeed.shareFeedData.getUser')->where('id' ,$feedId )->where(['type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->first();
		}elseif($feedType == 'page_feeds'){
			$feed = PagesFeed::with('pageDetails')->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getReplies')->with('likes.getUserData:id,name')->with('shareFeed.shareFeedData', 'shareFeed.shareFeedData.attachments', 'shareFeed.shareFeedData.getUser')->where('id' ,$feedId )->where(['type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->first();
		}
		if($feed){
            $Class = optional($feed->pageDetails)->id ? '-page-' : (optional($feed->groupDetails)->id ? '-group-' : '');
            $feed->url = route('feedDetail', ['id' => base64_encode('feed_' . $Class . '_' . $feed->id)]);
			$feed->time = $feed->created_at->diffForHumans();

			foreach($feed->likes as $like){
                if($like->user_id == $userId){
                    $feed['userLike'] = true;
                }else{
                    $feed['userLike'] = false;
                }
            }

			return response()->json(['feed' => $feed, 'success' => true],200);
		}else{
			return response()->json(['feed' => $feed, 'success' => false, 'message'=> 'Feed not found'],201);
		}
	}

	public function removeNotification($id){
		$notification = Notifications::find($id);
		if($notification){
			$notification->notification_delete = 1;
			$notification->save();
			return response()->json(['success' => true, 'message'=> 'Notification removed successfully'],200);
		}else{
			return response()->json([ 'success' => false, 'message'=> 'Notification not found'],201);
		}
	}

    public function readNotificationAll($user_id)
    {
        $check = Notifications::where(['user_id' => $user_id,'notification_badge_read' => 0])->get();
        if (isset($check))
        {
            foreach($check as $checkSingle){
                $checkSingle->notification_badge_read = 1;
                $checkSingle->save();
            }

            return response()->json(['success' => true, 'message'=> 'All Notification read Successfully'],200);
        }else{
            return response()->json([ 'success' => false, 'message'=> 'No new Notification founds'],201);
        }
    }
}
