<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupsFeed;
use App\Models\GroupFeedComment;
use App\Models\GroupFeedCommentLikes;
use App\Models\GroupFeedLike;
use App\Models\Notifications;

class GroupFeedsController extends Controller
{
    public function likeGroupPost(Request $request)
    {
        //check for exisiting same like type
        $check = GroupFeedLike::where(['user_id' =>  $request->userId, 'groups_feed_id' => $request->feedId, 'like_type' =>$request->type])->first();
        $feed = GroupsFeed::find($request->feedId);
        $checkNotifications = Notifications::where(['user_id' =>  $feed->user_id, 'friend_id' => $request->userId, 'feed_id' => $request->feedId, 'notification_type' => 'group_feed_like'])->get();
        if($check){
            if(isset($feed) ){
                $check->delete();
                if($checkNotifications){
                    $checkNotifications->each->delete();
                }
                if($feed->likes_count  > 0) {
                    $feed->likes_count = $feed->likes_count-1;
                    $feed->save();
                    $feed = GroupsFeed::find($request->feedId);
                    return response()->json(['success' => true, 'feed' => $feed, 'message' => 'Like removed successfully'], 200);
                }
            }
        }

        $feed = GroupsFeed::find($request->feedId);
        $totalFeedLikes = $feed->likes_count + 1;
        GroupsFeed::where('id', $request->feedId)->update(['likes_count' => $totalFeedLikes]);

        $feedLikes = new GroupFeedLike;
        $feedLikes->groups_feed_id = $request->feedId;
        $feedLikes->user_id = $request->userId;
        $feedLikes->like_type = $request->type;
        $feedLikes->status = 'Y';
        $feedLikes->save();

        $groupFeedLikes = GroupFeedLike::where(['groups_feed_id' => $request->feedId, 'user_id' => $request->userId, 'like_type' => $request->type, 'status' => 'Y'])->orderBy('id','DESC')->first();

        if(auth()->user()->id !== $feed->user_id){
            $notificationMessage = ' liked your post. ';
            $likeGroupFeedNotification = Notifications::sendGroupFeedNotification($feed->user_id, auth()->user()->id, $feed->group_id, $request->feedId, $groupFeedLikes->id, 'notificationDetails/'.'group_feed_like'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$request->feedId.'/'.$feed->group_id, 'User Like Group Feed', 'group_feed_like', $notificationMessage);
        }
        $feed = GroupsFeed::find($request->feedId);
        return ['status' => 0, 'type' => $request->type, 'feed' => $feed, 'message' => 'Like Add successfully'];

        // $feed = GroupsFeed::where(['user_id' => $request->userId, 'id' => $request->feedId])->get();
        // $totalFeedLikes = $feed[0]->likes_count + 1;
        // GroupsFeed::where('id', $request->feedId)->update(['likes_count' => $totalFeedLikes]);
        // return redirect()->route('groupdetail',  ['id' => $feed[0]->group_id]);
    }

    public function storeGroupComments(Request $request)
    {
        $feedComment = new GroupFeedComment;
        $feedComment->user_id = $request->userId;
        $feedComment->groups_feed_id = $request->feedId;
        $feedComment->parent_id = 0;
        $feedComment->comment = $request->comment;
        $feedComment->status = 'Y';
        $feedComment->save();
        return redirect()->route('groupdetail',  ['id' => $request->groupId]);
    }

    public function groupCommentsStore(Request $request)
    {
        $feedComment = new GroupFeedComment;
        $feedComment->user_id = $request->userId;
        $feedComment->groups_feed_id = $request->feedId;
        $feedComment->parent_id = 0;
        $feedComment->comment = $request->comment;
        $feedComment->status = 'Y';
        $feedComment->save();

        $feed = GroupsFeed::find($request->feedId);
        $feed->comments_count = $feed->comments_count + 1;
        $feed->save();

        if(auth()->user()->id !== $feed->user_id){
            $notificationMessage = ' commented on your post. ';
            $getGroupFeedComment = GroupFeedComment::where(['user_id' => $request->userId, 'groups_feed_id' => $request->feedId, 'parent_id' => 0, 'comment' => $request->comment, 'status'=> 'Y'])->orderby('id', 'DESC')->first();
            $likeGroupFeedNotification = Notifications::sendGroupFeedNotification($feed->user_id, auth()->user()->id, $feed->group_id, $request->feedId, $getGroupFeedComment->id,'notificationDetails/'.'group_feed_comment'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$request->feedId.'/'.$feed->group_id, 'User Comment Group Feed', 'group_feed_comment', $notificationMessage);
        }

        $FeedCommentData = GroupFeedComment::with('getUserData:id,first_name,last_name,avatar_location,cover_image,username')->where('id', $feedComment->id)->get();
        $feed = GroupsFeed::where('id', $request->feedId)->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->first();
        $userAuthId = auth()->user()->id;

        return ['success' => true,  'status' => 0, 'feedComment' => $FeedCommentData, 'feed' => $feed, 'userAuthId' => $userAuthId];
    }

    public function saveGroupCommentLike(Request $request)
    {
        //check for exisiting like
        $check = GroupFeedCommentLikes::where(['user_id' =>  $request->userId, 'comment_id' => $request->commentId])->first();
        $feed = GroupFeedComment::find($request->commentId);
        $checkNotifications = Notifications::where(['user_id' =>  $feed->user_id, 'friend_id' => $request->userId, 'group_id'=>$request->groupId, 'feed_id' => $request->feedId, 'comment_id'=>$request->commentId,'notification_type' => 'group_feed_comment_like'])->get();
        if($check){
            if(isset($feed) ){
                $check->delete();
                if($checkNotifications){
                    $checkNotifications->each->delete();
                }
                if($feed->likes_count  > 0) {
                    $feed->likes_count = $feed->likes_count - 1;
                    $feed->save();

                    $comment = GroupFeedComment::find($request->commentId);
                    $feed = GroupsFeed::find($comment->groups_feed_id);
                    return response()->json(['success' => true,'comment'=>$comment, 'feed'=>$feed, 'message' => 'Comment UnLike successfully'], 200);
                }
            }
        }

        $GroupFeedComment = GroupFeedComment::where(['groups_feed_id' => $request->feedId, 'id' => $request->commentId])->get();
        $totalFeedLikes = $GroupFeedComment[0]->likes_count + 1;
        GroupFeedComment::where(['groups_feed_id' => $request->feedId, 'id' => $request->commentId])->update(['likes_count' => $totalFeedLikes]);

        $GroupFeedCommentLikes = new GroupFeedCommentLikes;
        $GroupFeedCommentLikes->comment_id = $request->commentId;
        $GroupFeedCommentLikes->user_id = $request->userId;
        $GroupFeedCommentLikes->like_type = 'like';
        $GroupFeedCommentLikes->status = 'Y';
        $GroupFeedCommentLikes->save();

        if(auth()->user()->id !== $feed->user_id){
            $notificationMessage = ' liked your comment. ';
            $likeGroupFeedNotification = Notifications::sendGroupFeedCommentlikeNotification($feed->user_id, auth()->user()->id, $request->groupId, $request->feedId, $request->commentId, 'notificationDetails/'.'group_feed_comment_like'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$request->feedId.'/'.$request->groupId.'/'.$request->commentId, 'User Like Group Feed', 'group_feed_comment_like', $notificationMessage);
        }

        $comment = GroupFeedComment::find($request->commentId);
        $feed = GroupsFeed::find($comment->groups_feed_id);
        return response()->json(['success' => true,'comment'=>$comment, 'feed'=>$feed, 'message' => 'Comment Like Added successfully'], 200);
    }

    public function likeGroupPostComment(Request $request)
    {
        $groupFeedCommentLike = new GroupFeedCommentLikes;
        $groupFeedCommentLike->user_id = $request->userId;
        $groupFeedCommentLike->group_feed_id = $request->feedId;
        $groupFeedCommentLike->like_type = $request->type;
        $groupFeedCommentLike->comment_id = $request->commentId;
        $groupFeedCommentLike->status = 'Y';
        $groupFeedCommentLike->save();

        $feedComment = GroupFeedComment::where(['id' => $request->commentId, 'groups_feed_id' => $request->feedId])->get();
        $totalCommentLikes = $feedComment[0]->likes_count + 1;
        GroupFeedComment::where('id', $request->commentId)->update(['likes_count' => $totalCommentLikes]);
        return redirect()->route('groupdetail',  ['id' => $request->groupId]);
    }

    public function imageCropGroupPost(Request $request)
    {
        $user = Group::find($request->groupId, 'admin_user_id');
        if($request->type == 'Profile_image'){
            $data = $request->image;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);
            $image_name = $user->admin_user_id .'-'.time() . '.png';

            $path = dirname(getcwd()) .'/storage/app/public/images/group-img/'. $request->groupId.'/'. $image_name;

            $imageDir = dirname(getcwd()) .'/storage/app/public/images/group-img/'. $request->groupId;

            if(!is_dir($imageDir))
            {
                mkdir($imageDir, 0777, true);
            }
            file_put_contents($path, $data); // image uploading
            Group::where('id', $request->groupId)->update(['profile_image' => $image_name]);

            return redirect()->route('groupdetail',  ['id' => $request->groupId]);
        }
        if($request->type == 'Cover_image'){
            $data = $request->image;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);
            $image_name = $user->admin_user_id .'-'.time() . '.png';

            $path = dirname(getcwd()) .'/storage/app/public/images/group-img/'. $request->groupId.'/'.'cover'.'/'.$image_name;

            $imageDir = dirname(getcwd()) .'/storage/app/public/images/group-img/'. $request->groupId.'/'.'cover';
            if(!is_dir($imageDir))
            {
                mkdir($imageDir, 0777, true);
            }

            file_put_contents($path, $data); // image uploading
            Group::where('id', $request->groupId)->update(['cover_image' => $image_name]);
            return redirect()->route('groupdetail',  ['id' => $request->groupId]);
        }
    }

    public function approveFeed(Request $request){
        $feed = GroupsFeed::find($request->feedId);
        $feed->approve_feed = 'Y';
        $feed->save();
        $getGroupDetail = Group::find($feed->group_id);
        
        $feedsApproveCount = GroupsFeed::where(['approve_feed' => 'N', 'group_id' =>  $feed->group_id, 'is_deleted' => 0])->count();
        if($feedsApproveCount <= 0)
            $feed->feedEnd = true;
        
        $notificationMessage = 'An admin approved your post in '.$getGroupDetail->group_name;
        Notifications::sendGroupFeedNotification($feed->user_id, auth()->user()->id, $feed->group_id, $feed->id, null, 'notificationDetails/'.'group_feed_like'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$feed->id.'/'.$feed->group_id, 'User Approve Group Feed', 'group_feed_like', $notificationMessage);
        return response()->json(['success' => true, 'feed' => $feed, 'message' => 'Approve successfully'], 200);
    }

}
