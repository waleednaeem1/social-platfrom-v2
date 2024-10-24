<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\GroupsFeed;
use App\Models\PagesFeed;
use App\Models\FeedComment;
use App\Models\FeedAttachment;
use App\Models\FeedsLike;
use App\Models\FeedCommentLikes;
use App\Models\Feed;
use App\Models\ShareFeed;
use App\Models\FeedReport;
use App\Models\Notifications;
use App\Models\FavouriteFeed;
use App\Models\Customer;
use App\Models\FeedReportType;

use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{   
    public function createProfileTimelineFeed(Request $request)
    {

        if(isset($request->formType)){
            if($request->formType == 'sharePost'){
                $shareFeed = new ShareFeed;
                $shareFeed->user_id = auth()->user()->id;
                $shareFeed->feed_id = $request->feed_id;
                $shareFeed->post = $request->postData;
                $shareFeed->type = $request->feedType;
                $shareFeed->status = 'Y';
                $shareFeed->save();

                $feed = new Feed;
                $feed->user_id = auth()->user()->id;
                $feed->share_feed_id = $shareFeed->id;
                $feed->type = 'feed';
                $feed->status = 'Y';
                $feed->save();

                $feed = Feed::find($request->feed_id);

                return response()->json(['message' => 'Share Successfully', 'data' => $feed], 200);
            }

            $feed = Feed::find($request->feed_id);
            $feed->update([
                'post' => $request->postData,
                'visibility' => $request->visibility,
            ]);
            
            $feedAttachmentIds = explode(',', $request->feed_attachment_ids);
            FeedAttachment::whereIn('id', $feedAttachmentIds)->delete();
            
        }else{
            $feed = new Feed;
            $feed->user_id = $request->userId;
            $feed->post = $request->postData;
            $feed->type = 'feed';
            $feed->status = 'Y';
            $feed->save();
        }
        $feed->refresh();
        foreach($_FILES['profileImage']['name'] as $key => $imageName)
        {
            if (isset($imageName))
            {
                $ext = explode('.', $imageName);
                $ext = end($ext);
                
                $imageName = preg_replace('/[^A-Za-z0-9]/', '', $imageName);
                
                $videoType = ['mp4', 'mov', 'wmv', 'avi', 'mkv', 'flv', 'webm'];
                
                if (in_array($ext, $videoType)) {
                    $attachment_type = 'video';
                }else{
                    $attachment_type = 'image';
                }
                
                $imagePath = $request->userId .'-'.$imageName.'-'.time().'-'.rand(10000,10000000). '.' . $ext;

                $path = dirname(getcwd()) .'/storage/app/public/images/feed-img/'.$request->userId.'/'.$imagePath;
                $imageDir = dirname(getcwd()) .'/storage/app/public/images/feed-img/'.$request->userId;
                if(!is_dir($imageDir))
                {
                    mkdir($imageDir, 0777, true);
                }
                $uploaded = move_uploaded_file($_FILES['profileImage']['tmp_name'][$key], $path); 
                
                
                if($uploaded) {
                    $feedAttachments = new FeedAttachment;
                    $feedAttachments->feed_id = $feed->id;
                    $feedAttachments->user_id = $request->userId;
                    $feedAttachments->attachment_type = $attachment_type;
                    $feedAttachments->attachment = $imagePath;
                    $feedAttachments->save();
                }
            }
        }
        if($request->pageType == 'homePage' || $request->type == 'story'){
            return response()->json(['message' => 'Home Post Created!', 'id' =>  $request->userId, 'data' => $feed, 'feedType' => 'profilefeed'], 200);
        }
        else{
            return response()->json(['message' => 'Post Created!', 'data' => $feed], 200);
        }
    }

    public function createPost(Request $request)
    {
        $feed = new Feed;
        $feed->user_id = $request->userId;
        $feed->post = $request->postData;
        $feed->type = $request->type;
        $feed->status = 'Y';
        $feed->save();
        $feed->refresh();
        // foreach($_FILES['profileImage']['name'] as $key => $imageName)
        // {
            $imageName = $_FILES['profileImage']['name'];
            if (isset($imageName))
            {
                $ext = explode('.', $imageName);
                $ext = end($ext);

                $videoType = ['mp4', 'mov', 'wmv', 'avi', 'mkv', 'flv', 'webm'];
                if (in_array($ext, $videoType)) {
                    $attachment_type = 'video';
                }else{
                    $attachment_type = 'image';
                }
                // $imagePath = $request->userId .'-'.time(). '.' . $ext;
                $imagePath = $imageName;
                $path = dirname(getcwd()) .'/storage/app/public/images/feed-img/'.$request->userId.'/'.$imagePath; // uploaded image path
                $imageDir = dirname(getcwd()) .'/storage/app/public/images/feed-img/'.$request->userId;

                if(!is_dir($imageDir))
                {
                    mkdir($imageDir, 0777, true);
                }
                $uploaded = move_uploaded_file($_FILES['profileImage']['tmp_name'], $path); // image uploading
                // $uploaded = move_uploaded_file($_FILES['profileImage']['tmp_name'][$key], public_path().'/'.$imageDir1); // image uploading
                if($uploaded) {
                    $feedAttachments = new FeedAttachment;
                    $feedAttachments->feed_id = $feed->id;
                    $feedAttachments->user_id = $request->userId;
                    $feedAttachments->attachment_type = $attachment_type;
                    $feedAttachments->attachment = $imagePath;
                    $feedAttachments->save();
                }
            }
        //}
        if($request->pageType == 'homePage' || $request->type == 'story'){
            return redirect()->route('home');
        }
        else{
            return response()->json(['message' => 'Profile Post Created!'], 200);
        }
    }

    public function likePost(Request $request)
    {

        //check for exisiting same like type
        $check = FeedsLike::where(['user_id' =>  $request->userId, 'feed_id' => $request->feedId])->first();
        $feed = Feed::find($request->feedId);
        $checkNotifications = Notifications::where(['user_id' =>  $feed->user_id, 'friend_id' => $request->userId, 'feed_id' => $request->feedId, 'notification_type' => 'feed_like'])->get();
        if($check){
            if(isset($feed) ){
                $check->delete();
                if($checkNotifications){
                    $checkNotifications->each->delete();
                }
                if($feed->likes_count  > 0) {
                    $feed->likes_count = $feed->likes_count-1;
                    $feed->save();
                }
            }
            return response()->json(['success' => true, 'feed' => $feed, 'message' => 'Like removed successfully'], 200);
        }
        $feed = Feed::find($request->feedId);
        $totalFeedLikes = $feed->likes_count + 1;
        Feed::where('id', $request->feedId)->update(['likes_count' => $totalFeedLikes]);

        $feedLikes = new FeedsLike;
        $feedLikes->feed_id = $request->feedId;
        $feedLikes->user_id = $request->userId;
        $feedLikes->like_type = $request->type;
        $feedLikes->status = 'Y';
        $feedLikes->save();

        if(auth()->user()->id !== $feed->user_id){
            $notificationMessage = ' liked your post. ';
            $likeFeedNotification = Notifications::sendFeedNotification($feed->user_id, auth()->user()->id, $request->feedId, Null ,'notificationDetails/'.'feed_like'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$request->feedId, 'User Like feed', 'feed_like', $notificationMessage);
        }
        $feed = Feed::find($request->feedId);
        return ['status' => 0, 'type' => $request->type, 'feed' => $feed, 'message' => 'Like add successfully'];
    }

    public function storeComments(Request $request)
    {
        $feedComment = new FeedComment;
        $feedComment->user_id = $request->userId;
        $feedComment->feed_id = $request->feedId;
        $feedComment->parent_id = 0;
        $feedComment->comment = $request->comment;
        $feedComment->status = 'Y';
        $feedComment->save();
        $FeedCommentData = FeedComment::with('getUserData:id,first_name,last_name,avatar_location,cover_image,username')->where('id', $feedComment->id)->get();
        $feed = Feed::where('id', $request->feedId)->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->first();
        $feed->comments_count = $feed->comments_count + 1;
        $feed->save();

        $userAuthId = auth()->user()->id;

        if(auth()->user()->id !== $feed->user_id){
            $notificationMessage = ' commented on your post. ';
            $feedCommentId = $feedComment->id;
            $likeFeedNotification = Notifications::sendFeedNotification($feed->user_id, auth()->user()->id, $request->feedId, $feedCommentId, 'notificationDetails/'.'feed_comment'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$request->feedId, 'User comment Feed', 'feed_comment', $notificationMessage);
        }

        return ['success' => true,  'status' => 0, 'feedComment' => $FeedCommentData, 'feed' => $feed, 'userAuthId' => $userAuthId];
    }

    public function saveCommentLike(Request $request)
    {
        //check for exisiting same like type
        $check = FeedCommentLikes::where(['user_id' =>  $request->userId, 'comment_id' => $request->commentId])->first();
        $comment = FeedComment::find($request->commentId);
        $checkNotifications = Notifications::where(['user_id' =>  $comment->user_id, 'friend_id' => $request->userId, 'feed_id' => $comment->feed_id, 'feed_comment_id'=>$request->commentId,'notification_type' => 'feed_comment_like'])->get();
        if($check){
            $check->delete();
            if(isset($checkNotifications)){
                $checkNotifications->each->delete();
            }
            if(isset($comment) ){
                if($comment->likes_count  > 0) {
                    $comment->likes_count = $comment->likes_count-1;
                    $comment->save();
                    $comment = FeedComment::find($request->commentId);
                    $feed = Feed::find($comment->feed_id);
                    return response()->json(['success' => true,'comment'=>$comment, 'feed'=>$feed,  'message' => 'Like removed successfully'], 200);
                }
            }
        }

        $feed = FeedComment::where(['id' => $request->commentId])->first();
        $totalFeedLikes = $feed->likes_count + 1;
        FeedComment::where(['id' => $request->commentId])->update(['likes_count' => $totalFeedLikes]);



        $feedCommentLike = new FeedCommentLikes;
        $feedCommentLike->comment_id = $request->commentId;
        $feedCommentLike->user_id = $request->userId;
        $feedCommentLike->like_type = 'like';
        $feedCommentLike->status = 'Y';
        $feedCommentLike->save();

        if(auth()->user()->id !== $comment->user_id){
            $notificationMessage = ' liked your comment. ';
            $likeGroupFeedNotification = Notifications::sendFeedCommentsLikeNotification($comment->user_id, auth()->user()->id, $feed->feed_id, $request->commentId, 'notificationDetails/'.'feed_comment_like'.'/'.$comment->user_id.'/'.auth()->user()->id.'/'.$comment->feed_id, 'User Like on Comment NewsFeed', 'feed_comment_like', $notificationMessage);
        }
        $comment = FeedComment::find($request->commentId);
        $feed = Feed::find($comment->feed_id);
        return response()->json(['success' => true,'comment'=>$comment, 'feed'=>$feed, 'message' => 'Comment Like Added successfully'], 200);
    }

    public function likePostComment(Request $request)
    {
        //check for exisiting like
        $check = FeedCommentLikes::where(['user_id' =>  $request->userId, 'comment_id' => $request->commentId])->first();
        $comment = FeedComment::find($request->commentId);

        if($check){
            $check->delete();
            if(isset($comment) ){
                if($comment->likes_count  > 0) {
                    $comment->likes_count = $comment->likes_count-1;
                    $comment->save();
                }
            }
            return response()->json(['success' => true, 'message' => 'Like removed successfully'], 200);
        }

        $feedCommentLike = new FeedCommentLikes;
        $feedCommentLike->user_id = $request->userId;
        // $feedCommentLike->feed_id = $request->feedId;
        $feedCommentLike->like_type = $request->type;
        $feedCommentLike->comment_id = $request->commentId;
        $feedCommentLike->status = 'Y';
        $feedCommentLike->save();

        $feedComment = FeedComment::where(['id' => $request->commentId, 'feed_id' => $request->feedId])->first();

        $totalCommentLikes = $feedComment->likes_count + 1;
        FeedComment::where('id', $request->commentId)->update(['likes_count' => $totalCommentLikes]);
        return redirect()->route('index');
    }

    public function saveCommentsReply(Request $request)
    {
        $user = auth()->user();
        $commentReply = [
            'user_id' => auth()->user()->id,
            'feed_id' => $request->feedId,
            'parent_id' => $request->parentCommentId,
            'comment' => $request->comment,
            'status' => 'Y',
        ];
        $reply = FeedComment::create($commentReply);
        $FeedCommentReply = FeedComment::with('getUserData:id,first_name,last_name,avatar_location,cover_image,username')->where('id', $reply->id)->get();
        $FeedComment = FeedComment::with('getUserData:id,first_name,last_name,avatar_location,cover_image,username')->where('id', $request->parentCommentId)->get();
        $CommentUser = FeedComment::find($request->parentCommentId);

        $feed = Feed::where('id', $request->feedId)->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->first();
        $feed->comments_count = $feed->comments_count + 1;
        $feed->save();

        if($CommentUser->user_id !== $user->id){
            $notificationMessage =' replied on your comment. ';
            $likeFeedNotification = Notifications::sendFeedNotification($CommentUser->user_id, $user->id, $request->feedId, $reply->id, 'notificationDetails/'.'feed_comment'.'/'.$CommentUser->user_id.'/'.$user->id.'/'.$request->feedId, 'User comment Feed', 'feed_comment', $notificationMessage);
        }
        
        return ['success' => true,  'status' => 0, 'FeedCommentReply' => $FeedCommentReply, 'FeedComment' => $FeedComment, 'feed' => $feed, 'userAuthId' => auth()->user()->id];
    }

    public function deleteFeedComment(Request $request)
    {
        $comment = FeedComment::with('getRepliesApi')->where('id', $request->commentId)->get();
        $feed = Feed::find($request->feedId);
        foreach($comment as $key => $data['commentChilds']){
            $data['feedId'] = $request->feedId;
            if(isset($comment)){
                if(isset($feed)){
                    $feed->comments_count = $feed->comments_count - 1;
                    $feed->save();
                    $checkNotifications = Notifications::where(['comment_id'=> $data['commentChilds']->id, 'feed_id' => $request->feedId])->whereIn('notification_type', ['feed_comment', 'feed_comment_like'])->get();
                    if(isset($checkNotifications)){
                        $checkNotifications->each->delete();
                    }
                    $data['commentChilds']->delete();
                }
            }
            $this->deleteFeedCommentChilds($data);
        }
        $feed->refresh();
        return response()->json(['success' => true, 'feed' => $feed, 'comment' => $comment[0], 'message' => 'Comment deleted successfully', 'deleted' => 1], 200);
    }

    public function deleteFeedCommentChilds($data)
    {
        if(isset($data['commentChilds']->id)){
            $comment = FeedComment::with('getRepliesApi')->where('parent_id', $data['commentChilds']->id)->get();
            foreach($comment as $data['commentChilds']){
                $feed = Feed::find($data['feedId']);
                $data['feedId'] = $data['feedId'];
                $checkNotifications = Notifications::where(['comment_id'=> $data['commentChilds']->id, 'feed_id' => $data['feedId']])->whereIn('notification_type', ['feed_comment', 'feed_comment_like'])->get();
                if(isset($checkNotifications)){
                    $checkNotifications->each->delete();
                }
                if(isset($feed)){
                    $feed->comments_count = $feed->comments_count - 1;
                    $feed->save();
                    $data['commentChilds']->delete();
                }
                $this->deleteFeedCommentChilds($data);
            }
        }
    }
    
    public function deletePost(Request $request, $id)
    {
        $feed = Feed::where('id', $id)->first();
        $feed->is_deleted = 1;
        $feed->save();
        $FeedAttachment = FeedAttachment::where('feed_id', $id)->get();
        foreach($FeedAttachment as $attachment) {
            $attachment->is_deleted = 1;
            $attachment->save();
        }
        Notifications::where(['feed_id'=> $id])->whereIn('notification_type', ['feed_like', 'feed_comment', 'feed_comment_like'])->delete();
        return response()->json(['message' => 'Delete Post Successfully'], 200);
        // return redirect()->route('user-profile',  ['username' => auth()->user()->username]);
    }

    public function savePost(Request $request)
    {
        $data = [
            'feed_id' => $request->feedId,
            'user_id' => auth()->user()->id,
        ];
        $saveFeed = FavouriteFeed::create($data);
        if(isset($saveFeed)){
            $saveFeed = 1;
        }else{
            $saveFeed = 0;
        }
        // return redirect()->back()->with('success', 'Post Save successfully.');
        return response()->json(['feedId' => $request->feedId, 'status' => $saveFeed], 200);
    }

    public function removePost(Request $request)
    {
        $data = FavouriteFeed::where(['feed_id' => $request->feedId, 'user_id' => auth()->user()->id])->first();
        if($data!=''){
            $removePost = $data->delete();
            if (isset($removePost)) {
                $removePost = 1;
            }else{
                $removePost = 0;
            }
        }
        // return response()->json(['success', 'Post Removed successfully.']);
        return response()->json(['feedId' => $request->feedId, 'status' => $removePost], 200);
    }

    public function reportFeed(Request $request)
    {
        $reportingUser = User::find($request->reported_user_id);
        if(!$reportingUser){
            return redirect()->back()->with('error', 'Reporting user does not exists');
        }

        $feedUser = User::find($request->feed_user_id);
        if(!$feedUser){
            return redirect()->back()->with('error', 'Feed user does not exists');
        }
        
        if($request->post_type =='group'){
            $feed = GroupsFeed::find($request->feed_id);
        }elseif($request->post_type =='page'){
            $feed = PagesFeed::find($request->feed_id);
        }else{
            $feed = Feed::find($request->feed_id);
        }

        if(!$feed){
            return redirect()->back()->with('error', 'Feed does not exists');
        }

        $data = $request->all();

        $check = FeedReport::where(['feed_id' => $data['feed_id'], 'reported_user_id' => $data['reported_user_id'], 'feed_user_id' => $data['feed_user_id'],'post_type' => $data['post_type'] ])->first();
        
        if($check){
            return redirect()->back()->with('error', 'Feed already reported');
        }else{
            $reportData = FeedReport::create($data);

            if($request->post_type =='group'){
                $feed = GroupsFeed::find($data['feed_id']);
            }elseif($request->post_type =='page'){
                $feed = PagesFeed::find($data['feed_id']);
            }else{
                $feed = Feed::find($data['feed_id']);
            }
            
            if($request->post_type =='feed'){
                $feed->report_count = $feed->report_count+ 1;
                if($feed->report_count > 5){
                    $feed->status = 'N';
                    $feed->blocked = 'Y';
                    $feed->is_deleted = 1;
                }
            }
            
            $feed->save();
            $reportType = FeedReportType::find($data['feed_reported_type_id']);
            $reportingUser = User::find($data['reported_user_id']);
            if($feed->user_id != $reportingUser->id){
                $notificationMessage =' reported your post as '. $reportType->feed_report;
                if($request->post_type =='group'){
                    Notifications::sendGroupFeedNotification($feed->user_id, auth()->user()->id, $feed->group_id, $feed->id, null, 'notificationDetails/'.'group_feed_like'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$feed->id.'/'.$feed->group_id, 'User Like Group Feed', 'group_feed_like', $notificationMessage);
                }
                elseif($request->post_type =='page'){
                    Notifications::sendPageFeedNotification($feed->user_id, auth()->user()->id, $feed->page_id, $feed->id, 'notificationDetails/'.'page_feed_like'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$feed->id.'/'.$feed->page_id, 'User Like Page Feed', 'page_feed_like', $notificationMessage);
                }
                else{
                    Notifications::sendFeedNotification($feed->user_id, auth()->user()->id, $feed->id, null, 'notificationDetails/'.'feed_like'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$feed->id, 'User Like feed', 'feed_like', $notificationMessage);
                }
            }
            return redirect()->back()->with('success', 'Feed reported successfully');
        }
    }

    public function hidePost(Request $request)
    {
        Feed::where('id', $request->feedId)->update(['hide_from_timeline' => 1]);
        return redirect()->route('user-profile',  ['username' => auth()->user()->username]);
    }

}