<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PagesFeed;
use App\Models\PageFeedAttachment;
use App\Models\PageFeedComment;
use App\Models\GroupsFeed;
use App\Models\Group;
use App\Models\ShareFeed;
use App\Models\GroupFeedComment;
use App\Models\GroupFeedAttachment;
use App\Models\Notifications;
use PHPUnit\TextUI\XmlConfiguration\Groups;

class GroupPagesController extends Controller
{
    public function saveGroupsPagesCommentsReply(Request $request)
    {
        if($request->type == '-group-'){
            $commentReply = [
                'user_id' => auth()->user()->id,
                'groups_feed_id' => $request->feedId,
                'parent_id' => $request->parentCommentId,
                'comment' => $request->comment,
                'status' => 'Y',
            ];
            $reply = GroupFeedComment::create($commentReply);
            $commentUser = GroupFeedComment::find($request->parentCommentId);

            $getGroupFeedComment = GroupFeedComment::where(['user_id' => auth()->user()->id, 'groups_feed_id' => $request->feedId, 'parent_id' => $request->parentCommentId, 'comment' => $request->comment, 'status'=> 'Y'])->orderby('id', 'DESC')->first();

            $feed = GroupsFeed::find($request->feedId);
            $feed->comments_count = $feed->comments_count + 1;
            $feed->save();

            if(auth()->user()->id !== $commentUser->user_id){
                $notificationMessage = ' replied on your comment. ';
                $likeGroupFeedNotification = Notifications::sendGroupFeedNotification($commentUser->user_id, auth()->user()->id, $feed->group_id, $request->feedId, $getGroupFeedComment->id, 'notificationDetails/'.'group_feed_comment'.'/'.$commentUser->user_id.'/'.auth()->user()->id.'/'.$request->feedId.'/'.$feed->group_id, 'User Comment Group Feed', 'group_feed_comment', $notificationMessage);
            }

            $FeedCommentReply = GroupFeedComment::with('getUserData:id,first_name,last_name,avatar_location,cover_image,username')->where('id', $reply->id)->get();
            $FeedComment = GroupFeedComment::with('getUserData:id,first_name,last_name,avatar_location,cover_image,username')->where('id', $request->parentCommentId)->get();
            $feed = GroupsFeed::where('id', $request->feedId)->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->first();

        }
        else{
            $commentReply = [
                'user_id' => auth()->user()->id,
                'pages_feed_id' => $request->feedId,
                'parent_id' => $request->parentCommentId,
                'comment' => $request->comment,
                'status' => 'Y',
            ];
            $reply = PageFeedComment::create($commentReply);
            $commentUser = PageFeedComment::find($request->parentCommentId);
            
            $getPageFeedComment = PageFeedComment::where(['user_id' => auth()->user()->id, 'pages_feed_id' => $request->feedId, 'parent_id' => $request->parentCommentId, 'comment' => $request->comment, 'status'=> 'Y'])->orderby('id', 'DESC')->first();

            $feed = PagesFeed::find($request->feedId);
            $feed->comments_count = $feed->comments_count + 1;
            $feed->save();

            if(auth()->user()->id !== $commentUser->user_id){
                $notificationMessage = ' replied on your comment. ';
                Notifications::sendPageFeedCommentNotification($commentUser->user_id, auth()->user()->id, $feed->page_id, $request->feedId, $getPageFeedComment->id, 'notificationDetails/'.'page_feed_comment'.'/'.$commentUser->user_id.'/'.auth()->user()->id.'/'.$request->feedId.'/'.$feed->page_id, 'User Comment Page Feed', 'page_feed_comment', $notificationMessage);
            }

            $FeedCommentReply = PageFeedComment::with('getUserData:id,first_name,last_name,avatar_location,cover_image,username')->where('id', $reply->id)->get();
            $FeedComment = PageFeedComment::with('getUserData:id,first_name,last_name,avatar_location,cover_image,username')->where('id', $request->parentCommentId)->get();
            $feed = PagesFeed::where('id', $request->feedId)->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->first();

        }

        return ['success' => true,  'status' => 0, 'FeedCommentReply' => $FeedCommentReply, 'FeedComment' => $FeedComment, 'feed' => $feed, 'userAuthId' => auth()->user()->id];
    }

    public function deleteGroupPagesFeedComment(Request $request)
    {
        if($request->type == 'group'){
            $comment = GroupFeedComment::where('id', $request->commentId)->get();
            $feed = GroupsFeed::find($request->feedId);
            foreach($comment as $key => $data['commentChilds']){
                $data['feedId'] = $request->feedId;
                if(isset($comment)){
                    if(isset($feed)){
                        $feed->comments_count = $feed->comments_count - 1;
                        $feed->save();
                        $checkNotifications = Notifications::where(['comment_id' => $data['commentChilds']->id, 'feed_id' => $request->feedId, 'group_id' => $feed->group_id])->whereIn('notification_type', ['group_feed_comment', 'group_feed_comment_like'])->get();

                        if(isset($checkNotifications)){
                            $checkNotifications->each->delete();
                        }
                        $data['commentChilds']->delete();
                    }
                }
                $this->deleteGroupFeedCommentChilds($data);
            }
            $feed->refresh();
            return response()->json(['success' => true, 'feed' => $feed, 'comment' => $comment[0], 'message' => 'Comment deleted successfully', 'deleted' => 1], 200);
        }
        else{
            $comment = PageFeedComment::where('id', $request->commentId)->get();
            $feed = PagesFeed::find($request->feedId);
            foreach($comment as $key => $data['commentChilds']){
                $data['feedId'] = $request->feedId;
                if(isset($comment)){
                    if(isset($feed)){
                        $feed->comments_count = $feed->comments_count - 1;
                        $feed->save();
                        $checkNotifications = Notifications::where(['comment_id' => $data['commentChilds']->id, 'feed_id' => $data['feedId'], 'page_id' => $feed->page_id])->whereIn('notification_type', ['page_feed_comment', 'page_feed_comment_like'])->get();
                        if(isset($checkNotifications)){
                            $checkNotifications->each->delete();
                        }
                        $data['commentChilds']->delete();
                    }
                }
                $this->deleteGroupFeedCommentChilds($data);
            }
            $feed->refresh();
            return response()->json(['success' => true, 'feed' => $feed, 'comment' => $comment[0], 'message' => 'Comment deleted successfully', 'deleted' => 1], 200);
        }
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
        return response()->json(['success' => true, 'message' => 'Comment deleted successfully', 'deleted' => 1], 200);
    }

    public function createGroupAndPagePost(Request $request)
    {
        if($request->type == 'groupfeed'){
            $group  = Group::find($request->groupId);
            if(isset($request->formType)){
                if($request->formType == 'sharePost'){
                    $shareFeed = new ShareFeed;
                    $shareFeed->user_id = auth()->user()->id;
                    $shareFeed->groups_feed_id = $request->feed_id;
                    $shareFeed->post = $request->postData;
                    $shareFeed->type = $request->feedType;
                    $shareFeed->status = 'Y';
                    $shareFeed->save();

                    $feed = new GroupsFeed;
                    $feed->group_id = $request->groupId;
                    $feed->user_id = auth()->user()->id;
                    $feed->share_feed_id = $shareFeed->id;
                    $feed->type = 'feed';
                    $feed->status = 'Y';
                    $feed->save();
                    if($group->group_type == 'Private' && $group->admin_user_id != auth()->user()->id){
                        $feed->approve_feed = 'N';
                        $feed->save();
                        $feed = GroupsFeed::find($request->feed_id);
                        $notificationMessage = '\'s post in '.$group->group_name.' needs approval. ';
                        Notifications::sendGroupFeedNotification($group->admin_user_id, auth()->user()->id, $feed->group_id, $feed->id, null, 'notificationDetails/'.'group_feed_like'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$feed->id.'/'.$feed->group_id, 'Group feed request', 'group_feed_like', $notificationMessage);
                    }
                    return response()->json(['message' => 'Share Successfully', 'data' => $feed], 200);
                }

                $feed = GroupsFeed::find($request->feed_id);
                $feed->update([
                    'post' => $request->postData,
                    'visibility' => $request->visibility,
                ]);
                $feedAttachmentIds = explode(',', $request->feed_attachment_ids);
                GroupFeedAttachment::whereIn('id', $feedAttachmentIds)->delete();

                $request->merge([
                    'groupId' => $feed->group_id,
                    'userId' => $feed->user_id,
                ]);
            }else{
                $feed = new GroupsFeed;
                $feed->group_id = $request->groupId;
                $feed->user_id = $request->userId;
                $feed->post = $request->postData;
                $feed->type = 'feed';
                $feed->status = 'Y';
                
                if($group->group_type == 'Private' && $group->admin_user_id != auth()->user()->id)
                    $feed->approve_feed = 'N';
                
                $feed->save();

                if($group->group_type == 'Private' && $group->admin_user_id != auth()->user()->id){
                    $notificationMessage = '\'s post in '.$group->group_name.' needs approval. ';
                    Notifications::sendGroupFeedNotification($group->admin_user_id, auth()->user()->id, $feed->group_id, $feed->id, null, 'notificationDetails/'.'group_feed_like'.'/'.$feed->user_id.'/'.auth()->user()->id.'/'.$feed->id.'/'.$feed->group_id, 'Group feed request', 'group_feed_like', $notificationMessage);
                    $groupRequest = 'Private';
                }

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

                    $imagePath = $request->userId .'-'.$imageName.'-'.time(). '.' . $ext;
                    // $imagePath = $imageName;
                    $path = dirname(getcwd()) .'/storage/app/public/images/group-img/'. $request->groupId.'/'. $imagePath; // uploaded image path
                    $imageDir = dirname(getcwd()) .'/storage/app/public/images/group-img/'.$request->groupId;

                    if(!is_dir($imageDir))
                    {
                        mkdir($imageDir, 0777, true);
                    }
                    $uploaded = move_uploaded_file($_FILES['profileImage']['tmp_name'][$key], $path); // image uploading

                    if ($uploaded) {
                        $groupFeedAttachments = new GroupFeedAttachment;
                        $groupFeedAttachments->groups_feed_id = $feed->id;
                        $groupFeedAttachments->user_id = $request->userId;
                        $groupFeedAttachments->attachment_type = $attachment_type;
                        $groupFeedAttachments->attachment = $imagePath;
                        $groupFeedAttachments->save();
                    }
                }
            }
            
            if(isset($groupRequest))
                $feed->groupRequest = $groupRequest;

            return response()->json(['message' => 'Group Post Created!', 'data' => $feed, 'feedType' => 'groupfeed'], 200);
        }
        if($request->type == 'pagefeed'){
            if(isset($request->formType)){
                if($request->formType == 'sharePost'){
                    $shareFeed = new ShareFeed;
                    $shareFeed->user_id = auth()->user()->id;
                    $shareFeed->pages_feed_id = $request->feed_id;
                    $shareFeed->post = $request->postData;
                    $shareFeed->type = $request->feedType;
                    $shareFeed->status = 'Y';
                    $shareFeed->save();

                    $feed = new PagesFeed;
                    $feed->page_id = $request->pageId;
                    $feed->user_id = auth()->user()->id;
                    $feed->share_feed_id = $shareFeed->id;
                    $feed->type = 'feed';
                    $feed->status = 'Y';
                    $feed->save();

                    $feed = PagesFeed::find($request->feed_id);
                    return response()->json(['message' => 'Share Successfully', 'data' => $feed], 200);
                }
                
                $feed = PagesFeed::find($request->feed_id);
                $feed->update([
                    'post' => $request->postData,
                    'visibility' => $request->visibility,
                ]);
                $feedAttachmentIds = explode(',', $request->feed_attachment_ids);
                PageFeedAttachment::whereIn('id', $feedAttachmentIds)->delete();

                $request->merge([
                    'pageId' => $feed->page_id,
                    'userId' => $feed->user_id,
                ]);

            }else{
                $feed = new PagesFeed;
                $feed->page_id = $request->pageId;
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
                    // $imagePath = $imageName;
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
            return response()->json(['message' => 'Page Post Created!',  'data' => $feed, 'feedType' => 'pagefeed'], 200);
        }

    }

    public function deleteGroupPagePost(Request $request)
    {
        if ($request->type == 'group') {
            GroupsFeed::where(['id' => $request->feedId, 'group_id' => $request->Id, 'user_id' => $request->userId])->update(['is_deleted' => 1]);
            $feed = GroupsFeed::where(['id' => $request->feedId, 'group_id' => $request->Id, 'user_id' => $request->userId])->first();
            Notifications::where(['feed_id'=> $request->feedId])->whereIn('notification_type', ['group_feed_comment', 'group_feed_like', 'group_feed_comment_like'])->delete();

            $feedsApproveCount = GroupsFeed::where(['approve_feed' => 'N', 'group_id' =>  $feed->group_id, 'is_deleted' => 0])->count();
            if($feedsApproveCount <= 0)
                $feed->feedEnd = true;
            
            return response()->json(['message' => 'Delete Post Successfully', 'data' => $feed], 200);
        }
        if ($request->type == 'page') {
            PagesFeed::where(['id' => $request->feedId, 'page_id' => $request->Id, 'user_id' => $request->userId])->update(['is_deleted' => 1]);
            Notifications::where(['feed_id'=> $request->feedId, 'page_id' => $request->Id])->whereIn('notification_type', ['page_feed_like', 'page_feed_comment', 'page_feed_comment_like'])->delete();

            return response()->json(['message' => 'Delete Post Successfully'], 200);
        }
    }
}
