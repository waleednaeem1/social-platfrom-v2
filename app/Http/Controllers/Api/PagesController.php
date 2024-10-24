<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockedUser;
use App\Models\ChatMessage;
use App\Models\Notifications;
use App\Models\Page;
use App\Models\PageCategory;
use App\Models\PageFeedAttachment;
use App\Models\PageFeedComment;
use App\Models\PageFeedCommentLikes;
use App\Models\PageFeedLike;
use App\Models\PageMembers;
use App\Models\PagesFeed;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
class PagesController extends Controller
{
    public function viewPages($userId = null){
        $data['pages'] = Page::with('pageMembers')->where(['status' => 'Y'])->get();
        foreach($data['pages'] as $page){
            $page->likes = $page->total_members;
            foreach($page->pageMembers as $member){
                if($member->user_id == $userId){
                    $page->member = true;
                }else{
                    $page->member = false;
                }
            }
        }
        return response()->json(array('data' => $data),200);
    }

    public function createPage(Request $request){
        $page = new Page;
        $page->page_name = $request->page_name;
        $page->admin_user_id = $request->user_id;
        $page->bio = $request->bio;
        $page->category = $request->category;
        if(isset($_FILES["profile_image"])){
            $page->profile_image = $_FILES["profile_image"]["name"];
        }
        if(isset($_FILES["cover_image"])){
            $page->cover_image = $_FILES["cover_image"]["name"];
        }
        $page->save();
        $page->refresh();

        //Assign the group to the person who created the group
        $pageMembers = new PageMembers();
        $pageMembers->page_id = $page->id;
        $pageMembers->user_id = $request->user_id;
        $pageMembers->status = 'Y';
        $pageMembers->save();
        if(isset($_FILES["profile_image"])){
            $target_dir = dirname(getcwd()) .'/storage/app/public/images/page-img/'.$page->id;

            $target_file1 = $target_dir.'/'.$_FILES["profile_image"]["name"];
            $target_file2 = $target_dir.'/'.$_FILES["cover_image"]["name"];

            if(!is_dir($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }

            move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file1);

            move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file2);
        }

        return response()->json(array(['success' => true, 'message' => 'Page create successfully','page' => $page]),200);

    }

    public function likePage(Request $request)
    {
        $check = PageMembers::where(['page_id'=> $request->page_id,'user_id'=> $request->user_id])->first();
        if($check){
            return response()->json(['message' => ' User alredy liked page.'], 201);
        }else{
            $pageMembers = new PageMembers;
            $pageMembers->page_id = $request->page_id;
            $pageMembers->user_id = $request->user_id;
            $pageMembers->status = 'Y';
            $pageMembers->save();

            $likeUser = User::find($request->user_id);
            $pageData = Page::find($request->page_id);
            $notificationMessage =' Like the '.$pageData->page_name.' page. ';
            Notifications::sendLikePageNotification($pageData->admin_user_id, $likeUser->id, $request->page_id, 'pagedetail/'.$request->page_id, 'Like Page', 'like_page', $notificationMessage);

            return response()->json(array(['success' => true, 'message' => 'Page liked successfully']),200);
        }
    }

    public function pageDetail($id, $userId = null)
    {
        $pageDetail = Page::with('pageMembers')->where(['status' => 'Y', 'id' => $id])->first();
        if(isset($pageDetail)){
            $pageDetail->likes = $pageDetail->total_members;
        }
        // $feeds = PagesFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,first_name,last_name,name,avatar_location,username')->with('likes.getUserData:id,first_name,last_name,name,username')->where(['status' => 'Y', 'page_id' => $id])->orderBy('created_at', 'DESC')->where('is_deleted' ,0)->get();
        if($userId){
            $blockusers = BlockedUser::where('user_id', $userId)->pluck('blocked_user_id')->toArray();
        }else {
            $blockusers = [];
        }
        $feeds = PagesFeed::with([
            'getUser:id,first_name,last_name,avatar_location,cover_image,username',
            'attachments',
            'comments' => function ($query) use ($blockusers) {
                $query->whereNotIn('user_id', $blockusers);
            },
            'comments.getUserData:id,name,username,avatar_location,first_name,last_name', 
            'likes' => function ($query) use ($blockusers) {
                $query->whereNotIn('user_id', $blockusers);
            },
            'likes.getUserData:id,first_name,last_name,name,username',
        ])
        ->where(['status' => 'Y', 'page_id' => $id])
        ->orderBy('created_at', 'DESC')
        ->where('is_deleted' ,0)
        ->get();
        foreach($feeds as $feed){
            $feed->time = $feed->created_at->diffForHumans();
            $Class = optional($feed->pageDetails)->id ? '-page-' : (optional($feed->groupDetails)->id ? '-group-' : '');
            $feed->url = route('feedDetail', ['id' => base64_encode('feed_' . $Class . '_' . $feed->id)]);
            $feed['userLike'] = false;
            foreach($feed->likes as $like){
                if($like->user_id == $userId){
                    $feed['userLike'] = true;
                }
            }
        }

        //getting admin details
        $pageDetail['admin_details'] = User::find( $pageDetail->admin_user_id, ['id','first_name','last_name','avatar_location','cover_image','username','bio']);
        return response()->json((['success' => true, 'pageDetail' => $pageDetail, 'feeds' => $feeds]),200);
    }

    public function createPageFeed(Request $request)
    {
        $feed = new PagesFeed;
        $feed->page_id = $request->page_id;
        $feed->user_id = $request->user_id;
        if($request->post == null){
            $request->post = '';
        }
        $feed->post = $request->post;
        $feed->type = $request->type;
        $feed->status = 'Y';
        $feed->save();

        //saving slug for feed
        $feed->slug = 'page'.'-'.$feed->type . '-' . $feed->id;
        $feed->save();

        if (isset($_FILES['attachment']))
        {
            $imageName = $_FILES['attachment']['name'];
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
            $path = dirname(getcwd()) .'/storage/app/public/images/page-img/'. $request->page_id.'/'. $imagePath; // uploaded image path
            $imageDir = dirname(getcwd()) .'/storage/app/public/images/page-img/'.$request->page_id;

            if(!is_dir($imageDir))
            {
                mkdir($imageDir, 0777, true);
            }
            move_uploaded_file($_FILES['attachment']['tmp_name'], $path); // image uploading


            $pageFeedAttachments = new PageFeedAttachment();
            $pageFeedAttachments->pages_feed_id = $feed->id;
            $pageFeedAttachments->user_id = $request->user_id;
            $pageFeedAttachments->attachment_type = $attachment_type;
            $pageFeedAttachments->attachment = $imagePath;
            $pageFeedAttachments->save();
        }

        return response()->json(['success' => true, 'message' => 'Page feed create successfully' , 'feed_id' => $feed->id],200);

    }

    public function uploadPageFeedImages(Request $req)
    {
        //saving attachments of the feed
        try{
            if (isset($_FILES['attachment'])) {
                $file = $req->file('attachment');
                $ext = $file->getClientOriginalExtension();
                $fileName = time() . '-' . $file->getClientOriginalName();

                $videoType = ['mp4', 'mov', 'wmv', 'avi', 'mkv'];
                if (in_array($ext, $videoType)) {
                    $attachment_type = 'video';
                }else{
                    $attachment_type = 'image';
                }
                $feed = PagesFeed::find($req->page_feed_id);
                $file->move(public_path('storage/images/page-img/'.$feed->page_id), $fileName);
                if (isset($feed) && $feed !=null) {

                    $attachmentData = PageFeedAttachment::create([
                        'pages_feed_id' => $req->page_feed_id,
                        'user_id' => $feed->user_id,
                        'attachment_type' => @$attachment_type?  $attachment_type : 'image' ,
                        'attachment' =>  time() . '-' . $_FILES['attachment']['name']
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 201);
        }

        return response()->json(['success' => true,  'message' => 'Page feed create successfully', 'page_feed_id' =>$req->page_feed_id], 200);
    }


    public function likePagePost(Request $request)
    {
        $check = PageFeedLike::where(['user_id' =>  $request->user_id, 'pages_feed_id' => $request->feed_id])->first();
        $feed = PagesFeed::find($request->feed_id);
        $checkNotifications = Notifications::where(['user_id' =>  $feed->user_id, 'friend_id' => $request->user_id, 'feed_id' => $request->feed_id, 'notification_type' => 'page_feed_like'])->get();
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
            return response()->json(['success' => true, 'message' => 'Like removed successfully'], 200);
        }else{
            $data = [
                'pages_feed_id' => $request->feed_id,
                'user_id' => $request->user_id,
                'like_type' => $request->like_type,
                'status' => 'Y',
            ];
            PageFeedLike::create($data);
            PagesFeed::where('id', $request->feed_id)->update(['likes_count' => $feed->likes_count+1]);
            $user = User::find($request->user_id);

            if($request->user_id !== $feed->user_id){
                $notificationMessage =' like your post. ';
                Notifications::sendPageFeedNotification($feed->user_id, $user->id, $feed->group_id, $request->feed_id, 'notificationDetails/'.'page_feed_like'.'/'.$feed->user_id.'/'.$user->id.'/'.$request->feed_id.'/'.$feed->page_id, 'User Like Page Feed', 'page_feed_like', $notificationMessage);
            }
            return response()->json(['success' => true, 'type' => $request->like_type, 'feed_id' => $request->feed_id, 'message' => 'Like submitted successfully'],200);
        }
    }

    public function commentPagePost(Request $request)
    {
        $data = [
            'user_id' => $request->user_id,
            'pages_feed_id' => $request->feed_id,
            'parent_id' => $request->parent_id,
            'comment' => $request->comment,
            'status' => 'Y',
        ];

        $pageFeedComment = PageFeedComment::create($data);

        $feed = PagesFeed::find($request->feed_id);
        if($feed ){
            $feed->comments_count = $feed->comments_count + 1;
            $feed->save();
        }

        if(isset($request->parent_id) && $request->parent_id != 0){
            $notificationMessage =' replied on your comment.';
            $FeedComment = PageFeedComment::find($request->parent_id);
            $feed->user_id = $FeedComment->user_id;
        }

        $user = User::find($request->user_id);
        if($user->id !== $feed->user_id || isset($request->parent_id) && $request->parent_id != 0 && $FeedComment->user_id != $request->user_id){

            if($request->parent_id == 0)
                $notificationMessage =' commented on your post. ';

            Notifications::sendPageFeedCommentNotification($feed->user_id, $user->id, $feed->page_id, $request->feed_id, $pageFeedComment->id, 'notificationDetails/'.'page_feed_comment'.'/'.$feed->user_id.'/'.$user->id.'/'.$request->feed_id.'/'.$feed->page_id, 'User Comment Page Feed', 'page_feed_comment', $notificationMessage);
        }

        $FeedCommentData = PageFeedComment::with('getUserData:id,first_name,last_name,avatar_location,cover_image,username')->where('id', $pageFeedComment->id)->get();
        $feed = PagesFeed::where('id', $request->feedId)->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->first();

        return response()->json(['success' => true, 'feed_id' => $request->feed_id, 'message' => 'Post commented successfully', 'feedComment' => $FeedCommentData, 'feed' => $feed],200);
    }

    public function UserJoinedPages($userId){

        $pages = Page::whereHas('pageMembersData' , function ($q) use ($userId){
            $q->where('user_id', $userId);
        })->where(['status' => 'Y'])->get();

        return response()->json(['pages' => $pages],200);

    }

    public function uploadPageImageAndCover(Request $request)
    {
        if(!$request->page_id){
            return response()->json(['success' => false, 'message' => 'Page id is required.'],201);
        }
        $page =  Page::find($request->page_id);
        if(!$page){
            return response()->json(['success' => false, 'message' => 'Page does not exists.'],201);
        }
        try{

            if(isset($_FILES["cover_image"])){
                $target_dir = dirname(getcwd()) .'/storage/app/public/images/page-img/'.$page->id.'/'.'cover'.'/';

                if(!is_dir($target_dir))
                {
                    mkdir($target_dir, 0777, true);
                }
                $coverImage = $target_dir.'/'.$page->admin_user_id .'-'.time() . '.png';
                move_uploaded_file($_FILES["cover_image"]["tmp_name"], $coverImage);
                $page->cover_image = $page->admin_user_id .'-'.time() . '.png';
            }
            if(isset($_FILES["profile_image"])){
                $target_dir = dirname(getcwd()) .'/storage/app/public/images/page-img/'.$page->id;

                if(!is_dir($target_dir))
                {
                    mkdir($target_dir, 0777, true);
                }
                $profileImage = $target_dir.'/'.$page->admin_user_id .'-'.time() . '.png';
                move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profileImage);
                $page->profile_image = $page->admin_user_id .'-'.time() . '.png';
            }

            $page->save();

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 201);
        }

        return response()->json(['success' => true, 'message' => 'Page image uploaded successfully','Page' => $page],200);
    }

    public function unlikePage(Request $request)
    {
        $pageMember = PageMembers::where(['user_id'=> $request->user_id,'page_id'=> $request->page_id])->first();
        $page =  Page::find($request->page_id);
        if ($pageMember) {
            $pageMember->delete();
            return response()->json(['success' => true, 'message' => 'Page unliked successfully','Page' => $page],200);
        }else{
            return response()->json(['success' => false, 'message' => 'Record not found'],201);
        }
    }

    public function saveLikeForPageFeedComment(Request $request)
    {
        $user = User::find($request->user_id);
        if(!$user){
            return response()->json(['success' => false, 'message'=> 'user does not exists'],201);
        }
        //check for exisiting like
        $check = PageFeedCommentLikes::where(['user_id' =>  $request->user_id, 'comment_id' => $request->comment_id])->first();
        $comment = PageFeedComment::find($request->comment_id);
        if(!$comment ){
            return response()->json(['success' => true, 'message' => 'comment does not exist'], 200);
        }
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

        $like = PageFeedCommentLikes::create($request->all());
        if(isset($comment) ){
            $comment->likes_count= $comment->likes_count+1;
            $comment->save();
        }

        $pageFeed = PagesFeed::find($request->pages_feed_id);
        //notification for comment like
        if($user->id !== $comment->user_id){
            $notificationMessage =' like your comment. ';
            Notifications::sendPageFeedCommentlikeNotification($comment->user_id, $user->id, $pageFeed->page_id, $request->pages_feed_id, $request->commentId, 'notificationDetails/'.'page_feed_comment_like'.'/'.$comment->user_id.'/'.$user->id.'/'.$request->feed_id.'/'.$pageFeed->page_id.'/'.$request->comment_id, 'User Like Page Feed', 'page_feed_comment_like', $notificationMessage);
        }
        return response()->json(['success' => true, 'message' => 'Like submitted successfully' , 'like' =>$like], 200);

    }
    public function pagesCategories(){
        $categories = PageCategory::where('status' , 'Y')->select('id', 'category')->get();
        return response()->json(array('data' => $categories),200);
    }

    public function pageFeedLikeList($feedId){
        $likeList = PageFeedLike::where('pages_feed_id', $feedId)->with('getUserData:id,first_name,last_name,username,avatar_location,email')->whereHas('getUserData')->get();
        return response()->json(['success' => true,'likeList' => $likeList],200);
    }

    public function pageFeedCommentList($feed_id , $userId){
        $feed = PagesFeed::find($feed_id);
        if(!isset($feed) || !$feed){
            return response()->json(['success' => false, 'message'=> 'Feed does not exists'],201);
        }
        $comments = PageFeedComment::where('parent_id' , 0)->with('getUserData:id,first_name,last_name,name,username,avatar_location')->with('pageFeedCommentReplies.getUserData:id,first_name,last_name,username,avatar_location')->where('pages_feed_id', $feed_id)->get();
        if(!isset($comments) || count($comments) < 1){
            return response()->json(['success' => false, 'message'=> 'Comments does not exists for this feed', 'comments' =>$comments ],200);
        }

        $likes = PageFeedCommentLikes::where('user_id', $userId)
            ->get()
            ->keyBy('comment_id');

        foreach($comments as $comment){
            // $comment->replies = PageFeedComment::with('getUserData:id,first_name,last_name,name,username,avatar_location')->where(['pages_feed_id' => $feed_id, 'parent_id' =>  $comment->id])->get();
            // $comment->time = $comment->created_at->diffForHumans();
            $comment->like = $likes->has($comment->id);

            $this->loadLikesRecursively($comment, $likes);
        }
        return response()->json(['success' => true, 'comments_count' =>$feed->comments_count ,'comments' =>$comments ], 200);
    }

    private function loadLikesRecursively($comment, $likes)
    {
        foreach ($comment->pageFeedCommentReplies as $reply) {
            $reply->like = $likes->has($reply->id);
            
            $this->loadLikesRecursively($reply, $likes);
        }
    }

    public function suggestedPages($userId){
        $user = User::find($userId);
        if(!$user){
            return response()->json(['message' =>'User does not exists', 'success' => false], 201);
        }

        $data['pages'] = Page::whereDoesntHave('pageMembersData', function($query) use ($user){
            $query->where('user_id', $user->id);
        })->where([['status', 'Y'],['admin_user_id', '!=', $user->id]])->limit(3)->get();

        //checking page liked
        foreach($data['pages'] as $page){
            foreach($page->pageMembers as $member){
                if($member->user_id == $userId){
                    $page->liked = true;
                }else{
                    $page->liked = false;
                }
            }
            unset($page->pageMembers);
        }

        return response()->json(['success' => true, 'pages' => $data['pages'] ], 200);
    }

    public function deletePageFeed($feedId, $pageId, $userId)
    {
        $pageFeed = PagesFeed::where(['id' => $feedId, 'page_id' => $pageId])->first();

        if(!$pageFeed){
            return response()->json(['success' => true, 'message' => 'Feed does not exists'], 200);
        }
        //admin check for deleting post
        if(isset($pageFeed->pageDetails) && $pageFeed->pageDetails->admin_user_id == $userId){
            $pageFeed->update(['is_deleted' => 1]);
            Notifications::where(['feed_id'=> $feedId, 'page_id' => $pageId])->whereIn('notification_type', ['page_feed_like', 'page_feed_comment', 'page_feed_comment_like'])->delete();
            return response()->json(['success' => true, 'message' => 'Feed removed by admin successfully'], 200);
        }
        //check for feed owner
        if(isset($pageFeed) && $pageFeed->user_id == $userId){
            $pageFeed->update(['is_deleted' => 1]);
            Notifications::where(['feed_id'=> $feedId, 'page_id' => $pageId])->whereIn('notification_type', ['page_feed_like', 'page_feed_comment', 'page_feed_comment_like'])->delete();
            return response()->json(['success' => true, 'message' => 'Feed removed successfully'], 200);
        }elseif(isset($pageFeed) && $pageFeed->user_id != $userId){
            return response()->json(['success' => true, 'message' => 'You are not the owner of feed.'], 200);
        }

    }

    public function removePageFeedComment ($commentId){

        //check for comment
        $comment = PageFeedComment::where('id', $commentId)->get();
        if($comment->isEmpty()){
            return response()->json(['success' => false, 'message'=> 'Comment does not exists'],201);
        }
        $feed = PagesFeed::find($comment[0]->pages_feed_id);
        foreach($comment as $data['commentChilds']){
            $data['feedId'] = $comment[0]->pages_feed_id;
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
            $this->deletePageFeedCommentChilds($data);
        }
        return response()->json(['success' => true, 'feed' => $feed, 'comment' => $comment[0], 'message' => 'Comment deleted successfully', 'deleted' => 1], 200);
    }
    public function deletePageFeedCommentChilds($data)
    {
        if(isset($data['commentChilds']->id)){
            $comment = PageFeedComment::where('parent_id', $data['commentChilds']->id)->get();
            foreach($comment as $data['commentChilds']){
                $feed = PagesFeed::find($data['feedId']);
                if(isset($feed)){
                    $feed->comments_count = $feed->comments_count - 1;
                    $feed->save();
                    $checkNotifications = Notifications::where(['comment_id' => $data['commentChilds']->id, 'feed_id' => $data['feedId'], 'page_id' => $feed->page_id])->whereIn('notification_type', ['page_feed_comment', 'page_feed_comment_like'])->get();
                    if(isset($checkNotifications)){
                        $checkNotifications->each->delete();
                    }
                    $data['commentChilds']->delete();
                }
                $this->deletePageFeedCommentChilds($data);
            }
        }
        return response()->json(['success' => true, 'message' => 'Comment deleted successfully', 'deleted' => 1], 200);
    }

    public function deletePage($pageId, $userId) {
        $user =  User::find($userId);
        if(!$user){
            return response()->json(['success' => false, 'message' => 'User does not exists.'],201);
        }
        $page =  Page::find($pageId);
        if($page){
            if($page->admin_user_id == $userId){
                $page->status = 'N';
                $page->save();
                return response()->json(['success' => true, 'message' => 'Page deleted successfully.'],200);
            }else{
                return response()->json(['success' => false, 'message' => 'Only admin can delete page .'],201);
            }
        }else{
            return response()->json(['success' => false, 'message' => 'Page does not exists.'], 201);
        }
    }

    public function pageCommentLikeUsers($commentId, $checkUser = false)
    {
        $comment = PageFeedComment::find($commentId);
        if(!$comment ){
            return response()->json(['success' => true, 'message' => 'comment does not exist'], 200);
        }
        $userIds = PageFeedCommentLikes::where(['comment_id' => $commentId])->pluck('user_id')->toArray();
        $usersData = User::join('pages_feed_comment_likes', 'users.id', '=', 'pages_feed_comment_likes.user_id')
            ->whereIn('users.id', $userIds)
            ->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.avatar_location',
                'users.cover_image',
                'users.username',
                \DB::raw('MAX(pages_feed_comment_likes.created_at) as like_created_at'),
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
