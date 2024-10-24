<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\Group;
use App\Models\GroupFeedAttachment;
use App\Models\GroupFeedComment;
use App\Models\GroupFeedCommentLikes;
use App\Models\GroupFeedLike;
use App\Models\GroupMembers;
use App\Models\GroupsFeed;
use App\Models\Notifications;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class GroupFeedsController extends Controller
{
    public function createGroupPost(Request $request)
    {   
        $groupData = Group::find($request->group_id);
        if(!$groupData){
            return response()->json(array('success' => false, 'message' => 'Group does not exists.'),201);
        }
        if(!$request->group_id){
            return response()->json(array('success' => false, 'message' => 'Group id is required.'),201);
        }
        if(!$request->user_id){
            return response()->json(array('success' => false, 'message' => 'User id is required.'),201);
        }
        if($request->approvePost){
            $feed = GroupsFeed::find($request->feed_id)->update(['approve_feed' => 'Y']);
            return response()->json(['success' => true,  'message' => 'Post approved successfully','group_id' =>$request->group_id, 'feed_id' => $request->feed_id], 200);
        }

        $feed = new GroupsFeed;
        $feed->group_id = $request->group_id;
        $feed->user_id = $request->user_id;
        $feed->post = $request->post_data;
        $feed->type = 'feed';
        $feed->status = 'Y';
        if($groupData->group_type == 'Private' && $groupData->admin_user_id != $request->user_id)
            $feed->approve_feed = 'N';
        $feed->save();
        //saving slug for the post
        $feed->slug = $feed->type . '-' . $feed->id;
        $feed->save();

        //saving group post count
        $group = Group::find($feed->group_id);
        $group->total_post = $group->total_post + 1;
        $group->save();
        try{

            if (isset($_FILES['attachment'])) {
                $file = $request->file('attachment');
                $ext = $file->getClientOriginalExtension();
                $fileName = time() . '-' . $file->getClientOriginalName();

                $videoType = ['mp4', 'mov', 'wmv', 'avi', 'mkv'];
                if (in_array($ext, $videoType)) {
                    $attachment_type = 'video';
                }else{
                    $attachment_type = 'image';
                }
                $file->move(public_path('/storage/images/group-img/'.$request->group_id.'/'), $fileName);
                $attachmentData = GroupFeedAttachment::create([
                    'groups_feed_id' => $feed->id,
                    'user_id' => $feed->user_id,
                    'attachment_type' => @$attachment_type? $attachment_type: 'image',
                    'attachment' =>  time() . '-' . $_FILES['attachment']['name']
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 201);
        }
        
        return response()->json(['success' => true,  'message' => 'Post created successfully','group_id' =>$request->group_id, 'feed_id' =>$feed->id], 200);
    }

    public function uploadGroupFeedImages(Request $request)
    {
        //saving attachments of the feed
        try{
            if (isset($_FILES['attachment'])) {
                $file = $request->file('attachment');
                $ext = $file->getClientOriginalExtension();
                $fileName = time() . '-' . $file->getClientOriginalName();

                $videoType = ['mp4', 'mov', 'wmv', 'avi', 'mkv'];
                if (in_array($ext, $videoType)) {
                    $attachment_type = 'video';
                }else{
                    $attachment_type = 'image';
                }
                $file->move(public_path('/storage/images/group-img/'.$request->group_id.'/'), $fileName);
                $feed = GroupsFeed::find($request->group_feed_id);

                if (isset($feed) && $feed !=null) {

                    $attachmentData = GroupFeedAttachment::create([
                        'groups_feed_id' => $request->group_feed_id,
                        'user_id' => $feed->user_id,
                        'attachment_type' => @$attachment_type?  $attachment_type : 'image' ,
                        'attachment' =>  time() . '-' . $_FILES['attachment']['name']
                    ]);
                }else{
                    return response()->json(['success' => false,  'message' => 'Feed does not exists'], 200);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 201);
        }
        
        return response()->json(['success' => true,  'message' => 'Post created successfully', 'group_id' =>$request->group_id, 'groups_feed_id' =>$request->group_feed_id], 200);
    }

    public function getAllGroupFeeds($group_id, $user_id = null){
        $group = Group::find($group_id);
        if(!$group){
            return response()->json(['success' => false, 'error'=> 'Group does not exists'],201);
        }

        $data['group_feeds'] = GroupsFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location')->with('likes.getUserData:id,name')->where(['group_id' => $group_id, 'type' => 'feed', 'status' => 'Y'])->where('is_deleted','!=' , '1')->orderBy('created_at', 'DESC')->get();
        foreach ($data['group_feeds'] as $feed) {
            if($feed->likes_count  < 1) {
                $feed->likes_count = 0;
                $feed->save();
            }
            $feed->time = $feed->created_at->diffForHumans();
            $feed->like = GroupFeedLike::where(['groups_feed_id' => $feed->id, 'user_id' => $user_id])->first() ? true : false;
  
            foreach($feed->comments as $comment){
                $comment->time = $comment->created_at->diffForHumans();
                foreach($comment->getReplies as $reply){
                    $reply->time = $reply->created_at->diffForHumans();
                }
            }

        }
        return response()->json(array('success' => true, 'group_feeds' => $data['group_feeds'] ),200);
    }

    public function likeGroupPost(Request $request)
    {
        $feed = GroupsFeed::find($request->group_feed_id);
        $check = GroupFeedLike::where(['user_id' =>  $request->user_id, 'groups_feed_id' => $request->group_feed_id, 'like_type' =>$request->like_type])->first();
        $checkNotifications = Notifications::where(['user_id' =>  $feed->user_id, 'friend_id' => $request->user_id, 'feed_id' => $request->group_feed_id, 'notification_type' => 'group_feed_like'])->get();
        if($check){
            if(isset($feed)){
                $check->delete();
                if($checkNotifications){
                    $checkNotifications->each->delete();
                }
                if($feed->likes_count  > 0) {
                    $feed->likes_count = $feed->likes_count-1;
                    $feed->save();
                }
            }
            return response()->json(['success' => true, 'message' => 'Like removed successfully'], 200);
        }else{
            $likeUser = User::find($request->user_id);
            $feed = GroupsFeed::find($request->group_feed_id);
            $feedUser = User::find($feed->user_id);
            $totalFeedLikes = $feed->likes_count + 1;
            GroupsFeed::where('id', $request->group_feed_id)->update(['likes_count' => $totalFeedLikes]);
    
            $feedLikes = new GroupFeedLike;
            $feedLikes->groups_feed_id = $request->group_feed_id;
            $feedLikes->user_id = $request->user_id;
            $feedLikes->like_type = $request->like_type;
            $feedLikes->status = 'Y';
            $feedLikes->save();
            
            $groupFeedLikes = GroupFeedLike::where(['groups_feed_id' => $request->group_feed_id, 'user_id' => $request->user_id, 'like_type' => $request->like_type, 'status' => 'Y'])->orderBy('id','DESC')->first();
    
            //notification for like
            if($feed->user_id != $request->user_id){
                $notificationMessage =' like your post. ';
                Notifications::sendGroupFeedNotification($feed->user_id,$likeUser->id, $feed->group_id, $feed->id, $groupFeedLikes->id, 'notificationDetails/'.'group_feed_like'.'/'.$feed->user_id.'/'.$likeUser->id.'/'.$request->feedId.'/'.$feed->group_id, 'User Like Group Feed', 'group_feed_like', $notificationMessage);
            }
            
            return response()->json(['success' => true, 'type' => $request->like_type, 'feedId' => $request->group_feed_id, 'message' => 'Like submitted successfully']);
        }
        
    }

    public function commentGroupPost(Request $request){

        $feedComment = new GroupFeedComment();
        $feedComment->user_id = $request->user_id;
        $feedComment->groups_feed_id = $request->group_feed_id;
        $feedComment->parent_id = $request->parent_id;
        $feedComment->comment = $request->comment;
        $feedComment->status = 'Y';
        $feedComment->save();
        
        $getGroupFeedComment = GroupFeedComment::where(['user_id' => $request->user_id, 'groups_feed_id' => $request->group_feed_id, 'parent_id' => $request->parent_id, 'comment' => $request->comment, 'status'=> 'Y'])->orderBy('id', 'DESC')->first();

        
        $feed = GroupsFeed::find($request->group_feed_id);
        $feed->comments_count = $feed->comments_count + 1;
        $feed->save();

        if(isset($request->parent_id) && $request->parent_id != 0){
            $notificationMessage =' replied on your comment.';
            $FeedComment = GroupFeedComment::find($request->parent_id);
            $feed->user_id = $FeedComment->user_id;
        }
        //notification for comment
        if($feed->user_id != $request->user_id || isset($request->parent_id) && $request->parent_id != 0 && $FeedComment->user_id != $request->user_id){

            if($request->parent_id == 0)
                $notificationMessage =' commented on your post. ';
            
            Notifications::sendGroupFeedNotification($feed->user_id, $request->user_id, $feed->group_id, $request->group_feed_id, $getGroupFeedComment->id, 'mobile_notification', 'User Comment Group Feed', 'group_feed_comment', $notificationMessage);
        }

        return response()->json(['success' => true, 'feedId' => $request->group_feed_id, 'message' => 'Comment posted successfully']);
        
    }

    public function likeGroupPostComment(Request $request){
        $comment = GroupFeedComment::find($request->comment_id);
        if(!$comment){
            return response()->json(['success' => false, 'message' => 'Comment does not exists'], 200);
        }
        $check = GroupFeedCommentLikes::where(['comment_id' =>  $request->comment_id, 'user_id' => $request->user_id, 'like_type' =>$request->like_type])->first();

        if($check){
            if(isset($comment)){
                $check->delete();
                if($comment->likes_count  > 0) {
                    $comment->likes_count = $comment->likes_count-1;
                    $comment->save();
                    return response()->json(['success' => true, 'message' => 'Like removed successfully'], 200);
                }
            }
        }
        //check for diffrenret like type
        $check = GroupFeedCommentLikes::where(['user_id' =>  $request->user_id, 'comment_id' => $request->comment_id ])->where('like_type' ,'!=' ,$request->like_type)->first();
        if($check){
            if(isset($comment)){
                $check->like_type = $request->like_type;
                $check->save();
                return response()->json(['success' => true, 'message' => 'Like updated successfully'], 200);
            }
        }
        $groupFeedCommentLike = new GroupFeedCommentLikes();
        $groupFeedCommentLike->user_id = $request->user_id;
        $groupFeedCommentLike->like_type = $request->like_type;
        $groupFeedCommentLike->comment_id = $request->comment_id;
        $groupFeedCommentLike->status = 'Y';
        $groupFeedCommentLike->save();

        $feedComment = GroupFeedComment::find($request->comment_id);
        $feedComment->likes_count += 1;
        $feedComment->save();

        $commentLikeUser = User::find($request->user_id);
        $feed = GroupsFeed::find($feedComment->groups_feed_id);
        $feedUser = User::find($feed->user_id);
        //notification for comment like
        if($comment->user_id != $commentLikeUser->id){
            $notificationMessage =' liked your comment. ';
            $likeGroupFeedNotification = Notifications::sendGroupFeedCommentlikeNotification($feedComment->user_id, $request->user_id, $feed->group_id, $feed->id, $request->comment_id, 'notificationDetails/'.'group_feed_comment_like'.'/'.$feed->user_id.'/'.$feedUser->id.'/'.$request->feedId.'/'.$request->groupId.'/'.$request->commentId, 'User Like Group Feed', 'group_feed_comment_like', $notificationMessage);
        }
        return response()->json(['success' => true, 'type' => $request->like_type, 'feed_id' => $feed->id, 'message' => 'Comment liked successfully']);
        
    }

    public function viewAllGroupFeedComments($feed_id, $userId){
        $feed = GroupsFeed::find($feed_id);
        if(!isset($feed) || !$feed){
            return response()->json(['success' => false, 'message'=> 'Feed does not exists'],201);
        }
        $comments = GroupFeedComment::where('parent_id', 0)->with('getUserData:id,first_name,last_name,name,username,avatar_location')->with('groupFeedCommentReplies.getUserData:id,first_name,last_name,username,avatar_location')->where('groups_feed_id', $feed_id)->get();
        if(!isset($comments) || count($comments) < 1){
            return response()->json(['success' => false, 'message'=> 'Comments does not exists for this feed', 'comments' =>$comments ],200);
        }

        $likes = GroupFeedCommentLikes::where('user_id', $userId)
            ->get()
            ->keyBy('comment_id');

        foreach($comments as $comment){
            // $comment->replies = GroupFeedComment::with('getUserData:id,first_name,last_name,name,username,avatar_location')->where(['groups_feed_id' => $feed_id, 'parent_id' =>  $comment->id])->get();
            // $comment->time = $comment->created_at->diffForHumans();
            $comment->like = $likes->has($comment->id);

            $this->loadLikesRecursively($comment, $likes);
        }
        return response()->json(['success' => true, 'comments' =>$comments ], 200);

    }

    private function loadLikesRecursively($comment, $likes)
    {
        foreach ($comment->groupFeedCommentReplies as $reply) {
            $reply->like = $likes->has($reply->id);
            $this->loadLikesRecursively($reply, $likes);
        }
    }


    public function viewAllGroupFeedLikes($feed_id){
        $feed = GroupsFeed::find($feed_id);
        if(!isset($feed) || !$feed){
            return response()->json(['success' => false, 'message'=> 'Feed does not exists'],201);
        }
        $likes = GroupFeedLike::with('getUserData:id,first_name,last_name,name,username,avatar_location')->where('groups_feed_id', $feed_id)->get();
        if(!isset($likes) || count($likes) < 1){
            return response()->json(['success' => false, 'message'=> 'Likes does not exists for this feed', 'likes' =>$likes ],200);
        }
        return response()->json(['success' => true, 'likes' =>$likes ], 200);
    }

    public function removeGroupFeedComment ($commentId){

        $comment = GroupFeedComment::where('id', $commentId)->get();

        if(!isset($comment[0])){
            return response()->json(['success' => false, 'message'=> 'Comment does not exists'],201);
        }

        $feed = GroupsFeed::find($comment[0]->groups_feed_id);
        
        foreach($comment as $key => $data['commentChilds']){
            $data['feedId'] = $data['commentChilds']->groups_feed_id;
            if(isset($comment)){
                if(isset($feed)){
                    $feed->comments_count = $feed->comments_count - 1;
                    $feed->save();
                    $checkNotifications = Notifications::where(['comment_id' => $data['commentChilds']->id, 'feed_id' => $data['commentChilds']->groups_feed_id, 'group_id' => $feed->group_id])->whereIn('notification_type', ['group_feed_comment', 'group_feed_comment_like'])->get();

                    if(isset($checkNotifications)){
                        $checkNotifications->each->delete();
                    }
                    $data['commentChilds']->delete();
                }
            }
            $this->deleteGroupFeedCommentChilds($data);
        }

        return response()->json(['success' => true, 'message' => 'Comment removed successfully'], 200);
    }

    public function deleteGroupFeedCommentChilds($data)
    {
        if(isset($data['commentChilds']->id)){
            $comment = GroupFeedComment::where('parent_id', $data['commentChilds']->id)->get();
            foreach($comment as $data['commentChilds']){
                $feed = GroupsFeed::find($data['feedId']);
                $data['feedId'] = $data['feedId'];
                $checkNotifications = Notifications::where(['comment_id' => $data['commentChilds']->id, 'feed_id' => $data['feedId'], 'group_id' => $feed->group_id])->whereIn('notification_type', ['group_feed_comment', 'group_feed_comment_like'])->get();
                if(isset($checkNotifications)){
                    $checkNotifications->each->delete();
                }
                if(isset($feed)){
                    $feed->comments_count = $feed->comments_count - 1;
                    $feed->save();
                    $data['commentChilds']->delete();
                }
                $this->deleteGroupFeedCommentChilds($data);
            }
        }
    }

    public function deleteGroupFeed($feedId, $groupId, $userId)
    {
        $groupFeed = GroupsFeed::where(['id' => $feedId, 'group_id' => $groupId])->first();
        Notifications::where(['feed_id'=> $feedId])->whereIn('notification_type', ['group_feed_comment', 'group_feed_like', 'group_feed_comment_like'])->delete();

        if(!$groupFeed){
            return response()->json(['success' => true, 'message' => 'Feed does not exists'], 200);
        }
        //admin check for deleting post
        if(isset($groupFeed->groupDetails) && $groupFeed->groupDetails->admin_user_id == $userId){
            $groupFeed->update(['is_deleted' => 1]);
            return response()->json(['success' => true, 'message' => 'Feed removed by admin successfully'], 200);
        }
        //check for feed owner
        if(isset($groupFeed) && $groupFeed->user_id == $userId){
            $groupFeed->update(['is_deleted' => 1]);
            return response()->json(['success' => true, 'message' => 'Feed removed successfully'], 200);
        }elseif(isset($groupFeed) && $groupFeed->user_id != $userId){
            return response()->json(['success' => true, 'message' => 'You are not the owner of feed.'], 200);
        }

    }

    public function groupFeedLikeList($feedId){
        $likeList = GroupFeedLike::where('groups_feed_id', $feedId)->with('getUserData:id,first_name,last_name,username,avatar_location,email')->whereHas('getUserData')->get();
        return response()->json(['success' => true,'likeList' => $likeList],200);
    }

    public function groupCommentLikeUsers($commentId, $checkUser = false)
    {
        $comment = GroupFeedComment::find($commentId);
        if(!$comment ){
            return response()->json(['success' => true, 'message' => 'comment does not exist'], 200);
        }
        $userIds = GroupFeedCommentLikes::where(['comment_id' => $commentId])->pluck('user_id')->toArray();
        $usersData = User::join('group_feed_comment_likes', 'users.id', '=', 'group_feed_comment_likes.user_id')
            ->whereIn('users.id', $userIds)
            ->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.avatar_location',
                'users.cover_image',
                'users.username',
                \DB::raw('MAX(group_feed_comment_likes.created_at) as like_created_at'),
            ])
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.avatar_location', 'users.cover_image', 'users.username') 
            ->orderBy('like_created_at', 'desc')
            ->get();
        $usersData->map(function ($user) use ($checkUser) {
            $user->time = Carbon::parse($user->like_created_at)->diffForHumans();
            $chatExists = ChatMessage::where(['resp_user_id' => $checkUser , 'user_id' => $user->id])->where('message_type', 'User')->first();
            $otherchatExist = ChatMessage::where(['user_id' => $checkUser , 'resp_user_id' => $user->id])->where('message_type', 'User')->first();
            $user->chatId =null;
            if(isset($chatExists)){
                $user->chatId= $chatExists->chat_id;
            }elseif(isset($otherchatExist)){
                $user->chatId= $otherchatExist->chat_id;
            }
            return $user;
        });
        return response()->json(['success' => true, 'data' =>$usersData], 200);
    }
}
