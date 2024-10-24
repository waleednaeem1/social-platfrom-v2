<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserProfileDetails;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'vt_notifications';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    
    protected $primaryKey = 'id';

    protected $fillable = ['user_id','feed_id','notification_type','subject','message','email_sent','viewed','mobile_navigation','created_at','updated_at'];

    public function getUser(){
        return $this->belongsTo(User::class, 'friend_id')->select('id','avatar_location', 'username', 'first_name', 'last_name')->where( 'soft_delete', '!=', 1);
    }
    public function getOtherUser(){
        return $this->belongsTo(User::class, 'user_id')->select('id','avatar_location', 'username', 'first_name', 'last_name')->where( 'soft_delete', '!=', 1);
    }
    
    
    
    public static function sendNotification($notificationUserid, $notificationFriendid, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    { 
        $instance = new self();
        $notify = $instance->notificationCheckEnable($notificationUserid);
        if($notify == false)
            return;

        $uerNotification = new Notifications;
        $uerNotification->user_id = $notificationUserid ;
        $uerNotification->friend_id = $notificationFriendid ;
        $uerNotification->subject = $notificationSubject ;
        $uerNotification->notification_type = $notificationType ;
        $uerNotification->message = $notificationMessage ;
        $uerNotification->notification_badge_read = 0 ;
        $uerNotification->url = $notificationUrl;
        $uerNotification->mobile_navigation = 'profile';
        $uerNotification->save();
    }
    

    public static function CancelrequestNotification($user)
    { 
        $cancelFriendRequest = Notifications::where(['user_id' => $user->id , 'notification_type'=> 'friend_request'])->first();
        $cancelFriendRequest->delete();
    }

    public static function sendFeedNotification($notificationUserid, $notificationFriendid, $userFeedId, $feedCommentId, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    { 
        $instance = new self();
        $notify = $instance->notificationCheckEnable($notificationUserid);
        if($notify == false)
            return;

        $newsFeed = new Notifications;
        $newsFeed->user_id = $notificationUserid ;
        $newsFeed->friend_id = $notificationFriendid ;
        $newsFeed->feed_id = $userFeedId;
        $newsFeed->comment_id = $feedCommentId;
        $newsFeed->subject = $notificationSubject ;
        $newsFeed->notification_type = $notificationType ;
        $newsFeed->message = $notificationMessage ;
        $newsFeed->notification_badge_read = 0 ;
        $newsFeed->url = $notificationUrl;
        $newsFeed->mobile_navigation = 'feed';
        $newsFeed->save();
    }

    public static function sendFeedCommentsLikeNotification($notificationUserid, $notificationFriendid, $userFeedId, $userFeedCommentsLike, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    { 
        $instance = new self();
        $notify = $instance->notificationCheckEnable($notificationUserid);
        if($notify == false)
            return;

        $newsFeed = new Notifications;
        $newsFeed->user_id = $notificationUserid ;
        $newsFeed->friend_id = $notificationFriendid ;
        $newsFeed->feed_id = $userFeedId ;
        $newsFeed->feed_comment_id = $userFeedCommentsLike ;
        $newsFeed->subject = $notificationSubject ;
        $newsFeed->notification_type = $notificationType ;
        $newsFeed->message = $notificationMessage ;
        $newsFeed->notification_badge_read = 0 ;
        $newsFeed->url = $notificationUrl;
        $newsFeed->mobile_navigation = 'feed';
        $newsFeed->save();
    }

    public static function sendGroupFeedNotification($notificationUserid, $notificationFriendid, $userGroupFeedId, $userFeedId, $GroupFeedComment, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    { 
        $instance = new self();
        $notify = $instance->notificationCheckEnable($notificationUserid);
        if($notify == false)
            return;

        $groupFeed = new Notifications;
        $groupFeed->user_id = $notificationUserid ;
        $groupFeed->friend_id = $notificationFriendid ;
        $groupFeed->group_id = $userGroupFeedId ;
        $groupFeed->feed_id = $userFeedId ;
        $groupFeed->comment_id = $GroupFeedComment ;
        $groupFeed->subject = $notificationSubject ;
        $groupFeed->notification_type = $notificationType ;
        $groupFeed->message = $notificationMessage ;
        $groupFeed->notification_badge_read = 0 ;
        $groupFeed->url = $notificationUrl;
        $groupFeed->mobile_navigation = 'group';
        $groupFeed->save();
    }

    public static function sendPrivateGroupJoinNotification($notificationUserid, $notificationFriendid, $userGroupId, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    { 
        $instance = new self();
        $notify = $instance->notificationCheckEnable($notificationUserid);
        if($notify == false)
            return;

        $groupFeed = new Notifications;
        $groupFeed->user_id = $notificationUserid ;
        $groupFeed->friend_id = $notificationFriendid ;
        $groupFeed->group_id = $userGroupId ;
        $groupFeed->subject = $notificationSubject ;
        $groupFeed->notification_type = $notificationType ;
        $groupFeed->message = $notificationMessage ;
        $groupFeed->notification_badge_read = 0 ;
        $groupFeed->url = $notificationUrl;
        $groupFeed->mobile_navigation = 'group';
        $groupFeed->save();
    }

    public static function sendLikePageNotification($notificationUserid, $notificationFriendid, $userPageId, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    { 
        $instance = new self();
        $notify = $instance->notificationCheckEnable($notificationUserid);
        if($notify == false)
            return;

        $pageFeed = new Notifications;
        $pageFeed->user_id = $notificationUserid ;
        $pageFeed->friend_id = $notificationFriendid ;
        $pageFeed->page_id = $userPageId ;
        $pageFeed->subject = $notificationSubject ;
        $pageFeed->notification_type = $notificationType ;
        $pageFeed->message = $notificationMessage ;
        $pageFeed->notification_badge_read = 0 ;
        $pageFeed->url = $notificationUrl;
        $pageFeed->mobile_navigation = 'page';
        $pageFeed->save();
    }
    public static function sendPrivatepageNotification($notificationUserid, $notificationFriendid, $userPageId, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    { 
        $instance = new self();
        $notify = $instance->notificationCheckEnable($notificationUserid);
        if($notify == false)
            return;

        $groupFeed = new Notifications;
        $groupFeed->user_id = $notificationUserid ;
        $groupFeed->friend_id = $notificationFriendid ;
        $groupFeed->page_id = $userPageId ;
        $groupFeed->subject = $notificationSubject ;
        $groupFeed->notification_type = $notificationType ;
        $groupFeed->message = $notificationMessage ;
        $groupFeed->notification_badge_read = 0 ;
        $groupFeed->url = $notificationUrl;
        $groupFeed->mobile_navigation = 'page';
        $groupFeed->save();
    }

    public static function sendPageFeedCommentNotification($notificationUserid, $notificationFriendid, $userPageFeedId, $userFeedId, $pageFeedCommentId, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    { 
        $instance = new self();
        $notify = $instance->notificationCheckEnable($notificationUserid);
        if($notify == false)
            return;

        $pageFeed = new Notifications;
        $pageFeed->user_id = $notificationUserid ;
        $pageFeed->friend_id = $notificationFriendid ;
        $pageFeed->page_id = $userPageFeedId ;
        $pageFeed->feed_id = $userFeedId ;
        $pageFeed->comment_id = $pageFeedCommentId ;
        $pageFeed->subject = $notificationSubject ;
        $pageFeed->notification_type = $notificationType ;
        $pageFeed->message = $notificationMessage ;
        $pageFeed->notification_badge_read = 0 ;
        $pageFeed->url = $notificationUrl;
        $pageFeed->mobile_navigation = 'page';
        $pageFeed->save();
    }

    public static function sendGroupFeedCommentlikeNotification($notificationUserid, $notificationFriendid, $userGroupFeedId, $userFeedId, $groupFeedCommentLike, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    { 
        $instance = new self();
        $notify = $instance->notificationCheckEnable($notificationUserid);
        if($notify == false)
            return;

        $groupFeedComment = new Notifications;
        $groupFeedComment->user_id = $notificationUserid ;
        $groupFeedComment->friend_id = $notificationFriendid ;
        $groupFeedComment->group_id = $userGroupFeedId ;
        $groupFeedComment->feed_id = $userFeedId ;
        $groupFeedComment->comment_id = $groupFeedCommentLike ;
        $groupFeedComment->subject = $notificationSubject ;
        $groupFeedComment->notification_type = $notificationType ;
        $groupFeedComment->message = $notificationMessage ;
        $groupFeedComment->notification_badge_read = 0 ;
        $groupFeedComment->url = $notificationUrl;
        $groupFeedComment->mobile_navigation = 'group';
        $groupFeedComment->save();
    }

    public static function sendPageFeedCommentlikeNotification($notificationUserid, $notificationFriendid, $userPageFeedId, $pageFeedId, $userCommentId, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    { 
        $instance = new self();
        $notify = $instance->notificationCheckEnable($notificationUserid);
        if($notify == false)
            return;

        $pageFeedComment = new Notifications;
        $pageFeedComment->user_id = $notificationUserid ;
        $pageFeedComment->friend_id = $notificationFriendid ;
        $pageFeedComment->page_id = $userPageFeedId ;
        $pageFeedComment->feed_id = $pageFeedId ;
        $pageFeedComment->comment_id = $userCommentId ;
        $pageFeedComment->subject = $notificationSubject ;
        $pageFeedComment->notification_type = $notificationType ;
        $pageFeedComment->message = $notificationMessage ;
        $pageFeedComment->notification_badge_read = 0 ;
        $pageFeedComment->url = $notificationUrl;
        $pageFeedComment->mobile_navigation = 'page';
        $pageFeedComment->save();
    }
    public static function sendPageFeedNotification($notificationUserid, $notificationFriendid, $userPageFeedId, $userFeedId, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    { 
        $instance = new self();
        $notify = $instance->notificationCheckEnable($notificationUserid);
        if($notify == false)
            return;

        $groupFeed = new Notifications;
        $groupFeed->user_id = $notificationUserid ;
        $groupFeed->friend_id = $notificationFriendid ;
        $groupFeed->page_id = $userPageFeedId ;
        $groupFeed->feed_id = $userFeedId ;
        $groupFeed->subject = $notificationSubject ;
        $groupFeed->notification_type = $notificationType ;
        $groupFeed->message = $notificationMessage ;
        $groupFeed->notification_badge_read = 0 ;
        $groupFeed->url = $notificationUrl;
        $groupFeed->mobile_navigation = 'page';
        $groupFeed->save();
    }

    public static function sendFeedReportNotification($feedUserId, $reportingUserId, $feedId, $notificationUrl, $notificationSubject, $notificationType, $notificationMessage)
    {
        $instance = new self();
        $notify = $instance->notificationCheckEnable($feedUserId);
        if($notify == false)
            return;
            
        $userNotification = new Notifications;
        $userNotification->user_id = $feedUserId;
        $userNotification->friend_id = $reportingUserId;
        $userNotification->feed_id = $feedId;
        $userNotification->subject = $notificationSubject;
        $userNotification->notification_type = $notificationType;
        $userNotification->message = $notificationMessage;
        $userNotification->notification_badge_read = 0;
        $userNotification->url = $notificationUrl;
        $userNotification->mobile_navigation = 'feed';
        $userNotification->save();
    }
    
    public function notificationCheckEnable($userId){
        $notification = UserProfileDetails::where('user_id', $userId)->first();
        if(isset($notification) && $notification->content_notification == 'disable'){
            $notification = false;
            return $notification;
        }else{
            $notification = true;
            return $notification;
        }
    }

    public function groupDetails(){
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function pageDetails(){
        return $this->belongsTo(Page::class, 'page_id');
    }
}