<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PagesFeed;
use App\Models\PageFeedAttachment;
use App\Models\PageFeedComment;
use App\Models\PageFeedCommentLikes;
use App\Models\PageFeedLike;
use App\Models\Notifications;

class PageFeedsController extends Controller
{
    public function likePagePostComment(Request $request)
    {
        $check = PageFeedCommentLikes::where(['user_id'=> $request->userId, 'comment_id' => $request->commentId])->first();
        $feedComment = PageFeedComment::where(['id' => $request->commentId, 'pages_feed_id' => $request->feedId])->first();

        if(isset($check)){
            $check->delete();
            $totalCommentLikes = $feedComment->likes_count - 1;
            PageFeedComment::where('id', $request->commentId)->update(['likes_count' => $totalCommentLikes]);
            $checkNotification = Notifications::where(['user_id' => auth()->user()->id, 'friend_id' => $feedComment->user_id, 'page_id' => $request->pageId, 'feed_id' => $request->feedId, 'comment_id' => $request->commentId])->get();
            if(isset($checkNotification)){
                $checkNotification->each->delete();
            }
            $comment = PageFeedComment::find($request->commentId);
            $feed = PagesFeed::find($request->feedId);
            return response()->json(['success' => true,'comment'=>$comment, 'feed'=>$feed, 'message' => 'Comment UnLike successfully'], 200);
        }else{
            $data = [
                'user_id' => $request->userId,
                'page_feed_id' => $request->feedId,
                'like_type' => $request->type,
                'comment_id' => $request->commentId,
                'status' => 'Y',
            ];

            $pageFeed = PageFeedCommentLikes::create($data);
            $totalCommentLikes = $feedComment->likes_count + 1;
            PageFeedComment::where('id', $request->commentId)->update(['likes_count' => $totalCommentLikes]);
            $pageData = PagesFeed::find($request->feedId);
            if(auth()->user()->id !== $feedComment->user_id){
                $notificationMessage = ' liked your comment. ';
                $userdatataa = Notifications::sendPageFeedCommentlikeNotification($feedComment->user_id, auth()->user()->id, $pageData->page_id, $request->feedId, $request->commentId, 'notificationDetails/'.'page_feed_comment_like'.'/'.$feedComment->user_id.'/'.auth()->user()->id.'/'.$request->feedId.'/'.$pageData->page_id.'/'.$request->commentId, 'User Like Page Feed', 'page_feed_comment_like', $notificationMessage);
            }
        }
        
        $comment = PageFeedComment::find($request->commentId);
        $feed = PagesFeed::find($request->feedId);
        return response()->json(['success' => true,'comment'=>$comment, 'feed'=>$feed, 'message' => 'Comment Like Added successfully'], 200);
    }

    public function imageCropPagePost(Request $request)
    {
        $user = Page::find($request->pageId, 'admin_user_id');
        if($request->type == 'Profile_image'){
            $data = $request->image;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);
            $image_name = $user->admin_user_id .'-'.time() . '.png';

            $path = dirname(getcwd()) .'/storage/app/public/images/page-img/'. $request->pageId.'/'. $image_name;

            $imageDir = dirname(getcwd()) .'/storage/app/public/images/page-img/'. $request->pageId;

            if(!is_dir($imageDir))
            {
                mkdir($imageDir, 0777, true);
            }
            file_put_contents($path, $data); // image uploading
            Page::where('id', $request->pageId)->update(['profile_image' => $image_name]);

            return redirect()->route('pagedetail',  ['id' => $request->pageId]);
        }
        if($request->type == 'Cover_image'){
            $data = $request->image;

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);
            $image_name = $user->admin_user_id .'-'.time() . '.png';

            $path = dirname(getcwd()) .'/storage/app/public/images/page-img/'. $request->pageId.'/'.'cover'.'/'.$image_name;

            $imageDir = dirname(getcwd()) .'/storage/app/public/images/page-img/'. $request->pageId.'/'.'cover';
            if(!is_dir($imageDir))
            {
                mkdir($imageDir, 0777, true);
            }

            file_put_contents($path, $data); // image uploading
            Page::where('id', $request->pageId)->update(['cover_image' => $image_name]);
            return redirect()->route('pagedetail',  ['id' => $request->pageId]);
        }
    }


    public function createPagePost(Request $request)
    {
        $feed = new PagesFeed;
        $feed->page_id = $request->pageId;
        $feed->user_id = $request->userId;
        $feed->post = $request->postData;
        $feed->type = $request->type;
        $feed->status = 'Y';
        $feed->save();
        $feed->refresh();
        foreach($_FILES['profileImage']['name'] as $key => $imageName)
        {
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
                $path = dirname(getcwd()) .'/storage/app/public/images/page-img/'. $request->pageId.'/'. $imagePath; // uploaded image path
                $imageDir = dirname(getcwd()) .'/storage/app/public/images/page-img/'.$request->pageId;

                if(!is_dir($imageDir))
                {
                    mkdir($imageDir, 0777, true);
                }
                $uploaded = move_uploaded_file($_FILES['profileImage']['tmp_name'][$key], $path); // image uploading

                if ($uploaded) {
                    $pageFeedAttachments = new PageFeedAttachment;
                    $pageFeedAttachments->pages_feed_id = $feed->id;
                    $pageFeedAttachments->user_id = $request->userId;
                    $pageFeedAttachments->attachment_type = $attachment_type;
                    $pageFeedAttachments->attachment = $imagePath;
                    $pageFeedAttachments->save();
                }
            }
        }
        return redirect()->route('pagedetail',  ['id' => $request->pageId])->withFlashSuccess(__('Post Created Successfully.'));

    }

    public function likePagePost(Request $request)
    {
        $check = PageFeedLike::where(['user_id' =>  $request->userId, 'pages_feed_id' => $request->feedId, 'like_type' =>$request->type])->first();
        $feed = PagesFeed::find($request->feedId);
        $checkNotifications = Notifications::where(['user_id' =>  $feed->user_id, 'friend_id' => $request->userId, 'feed_id' => $request->feedId, 'notification_type' => 'page_feed_like'])->get();
        if($check){
            if(isset($feed) ){
                $check->delete();
                if($checkNotifications){
                    $checkNotifications->each->delete();
                }
                if($feed->likes_count  > 0) {
                    $feed->likes_count = $feed->likes_count-1;
                    $feed->save();
                    $feed = PagesFeed::find($request->feedId);
                    return response()->json(['success' => true, 'feed' => $feed, 'message' => 'Like removed successfully'], 200);
                }
            }
        }
        $feed = PagesFeed::find($request->feedId);
        $totalFeedLikes = $feed->likes_count + 1;
        PagesFeed::where('id', $request->feedId)->update(['likes_count' => $totalFeedLikes]);

        $data = [
            'pages_feed_id' => $request->feedId,
            'user_id' => $request->userId,
            'like_type' => $request->type,
            'status' => 'Y',
        ];
        $feedLike = PageFeedLike::create($data);
        if(auth()->user()->id !== $feed->user_id){
            $notificationMessage = ' liked your post. ';
            $likeGroupFeedNotification = Notifications::sendPageFeedNotification($feed->user_id, auth()->user()->id, $feed->page_id, $request->feedId, 'notificationDetails/'.'page_feed_like'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$request->feedId.'/'.$feed->page_id, 'User Like Page Feed', 'page_feed_like', $notificationMessage);
        }
        $feed = PagesFeed::find($request->feedId);
        return ['status' => 0, 'type' => $request->type, 'feed' => $feed, 'message' => 'Like Add successfully'];
    }

    public function pageCommentsStore(Request $request)
    {
        $data = [
            'user_id' => $request->userId,
            'pages_feed_id' => $request->feedId,
            'parent_id' => 0,
            'comment' => $request->comment,
            'status' => 'Y',
        ];
        $pageFeedComment = PageFeedComment::create($data);

        $feed = PagesFeed::find($request->feedId);
        $feed->comments_count = $feed->comments_count + 1;
        $feed->save();

        if(auth()->user()->id !== $feed->user_id){
            $notificationMessage = ' commented on your post. ';
            Notifications::sendPageFeedCommentNotification($feed->user_id, auth()->user()->id, $feed->page_id, $request->feedId, $pageFeedComment->id, 'notificationDetails/'.'page_feed_comment'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$request->feedId.'/'.$feed->page_id, 'User Comment Page Feed', 'page_feed_comment', $notificationMessage);
        }

        $FeedCommentData = PageFeedComment::with('getUserData:id,first_name,last_name,avatar_location,cover_image,username')->where('id', $pageFeedComment->id)->get();
        $feed = PagesFeed::where('id', $request->feedId)->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->first();
        $userAuthId = auth()->user()->id;
        
        return ['success' => true,  'status' => 0, 'feedComment' => $FeedCommentData, 'feed' => $feed, 'userAuthId' => $userAuthId];
    }
}
