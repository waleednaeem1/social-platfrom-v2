<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Feed;
use App\Models\ShareFeed;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\Customer;
use App\Models\FeedsLike;
use App\Mail\DVM\TestMail;
use App\Models\CommentLike;
use App\Models\FeedComment;
use Illuminate\Http\Request;
use App\Models\FeedAttachment;
use App\Http\Controllers\Controller;
use App\Models\BlockedUser;
use App\Models\ChatMessage;
use App\Models\FavouriteFeed;
use App\Models\FeedReport;
use App\Models\GroupFollow;
use App\Models\GroupMembers;
use App\Models\GroupsFeed;
use App\Models\Group;
use App\Models\Notifications;
use App\Models\PageMembers;
use App\Models\PagesFeed;
use App\Models\Page;
use App\Models\StoryViewed;
use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FeedsController extends Controller
{
    public function getAllFeeds($userId){
        $user_data = Customer::find($userId, ['id', 'username', 'avatar_location', 'email']);
        if(!$user_data){
            return response()->json(['success' => false, 'error'=> 'user does not exists'],201);
        }
        $userJoinedGroups = GroupMembers::where(['user_id' => $userId, 'follow' => 1])->pluck('group_id')->toArray();
        // dd($userJoinedGroups);
        $myGroups = Group::where('admin_user_id', $userId)->pluck('id')->toArray();
        $allGroups = array_merge($userJoinedGroups, $myGroups);

        $userJoinedPagesList = PageMembers::where('user_id', $userId)->get();

        if (count($userJoinedPagesList) > 0) {
            foreach($userJoinedPagesList as $key => $userJoinedPage){
                $userJoinedPages =  Page::where(['id' => $userJoinedPage->page_id, 'status' => 'Y'])->pluck('id')->toArray();
            }
        } else {
            $userJoinedPages = [];
        }

        $myPages = Page::where(['admin_user_id' => $userId, 'status' => 'Y'])->pluck('id')->toArray();
        $allPages = array_merge($userJoinedPages, $myPages);

        // $data['stories'] = Feed::with('getUser:id,username,first_name,last_name,avatar_location,cover_image')->where(['user_id' => $userId, 'type' => 'story', 'status' => 'Y'])->select('id','user_id', 'post', 'type', 'visibility','slug', 'created_at', 'updated_at')->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->get();
        // $data['feeds'] = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location,first_name,last_name')->with('comments.getRepliesApi')->with('likes.getUserData:id,name')->with('shareFeed.shareFeedData', 'shareFeed.shareFeedData.attachments', 'shareFeed.shareFeedData.getUser')->where(['user_id' => $userId, 'type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->get();

        if($userId){
            $blockusers = BlockedUser::where('user_id', $userId)->pluck('blocked_user_id')->toArray();
        }else {
            $blockusers = [];
        }
        $data['feeds'] = Feed::with([
            'getUser:id,first_name,last_name,avatar_location,cover_image,username',
            'attachments',
            'comments' => function ($query) use ($blockusers) {
                $query->whereNotIn('user_id', $blockusers);
            },
            'comments.getUserData:id,name,username,avatar_location,first_name,last_name', 
            'likes' => function ($query) use ($blockusers) {
                $query->whereNotIn('user_id', $blockusers);
            },
            'likes.getUserData:id,name',
            'shareFeed.shareFeedData',
            'shareFeed.shareFeedData.attachments',
            'shareFeed.shareFeedData.getUser',
        ])
        ->where(['user_id' => $userId, 'type' => 'feed', 'status' => 'Y'])
        ->orderBy('created_at', 'DESC')
        ->where('is_deleted', '!=' , '1')
        ->get();
        $groupFeeds = GroupsFeed::with('groupDetails')->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getReplies')->with('likes.getUserData:id,name')->with('shareFeed.shareGroupFeedData', 'shareFeed.shareGroupFeedData.attachments', 'shareFeed.shareGroupFeedData.getUser', 'shareFeed.shareGroupFeedData.groupDetails')->whereIn('group_id' ,$allGroups )->where(['type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->get();

        $pageFeeds = PagesFeed::with('pageDetails')->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getReplies')->with('likes.getUserData:id,name')->with('shareFeed.sharePageFeedData', 'shareFeed.sharePageFeedData.attachments', 'shareFeed.sharePageFeedData.getUser', 'shareFeed.sharePageFeedData.pageDetails')->whereIn('page_id' ,$allPages )->where(['type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->get();

        // dd($groupFeeds);
        // $friends = Friend::where('user_id', $userId)->get();
        $followingUsers = UserFollow::where('user_id', $userId)->get();

        $reportedFeed = FeedReport::where('reported_user_id', $userId)->pluck('feed_id');

        //for blocked user
        $blocked = $userIds = $followingUsersFeeds = [];
        $blockedUsers = BlockedUser::where('user_id', $userId)->get();
        foreach($blockedUsers as $blockUser){
            array_push($blocked, $blockUser->blocked_user_id);
        }

        foreach ($followingUsers as $user){
            $followingUsersFeeds = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getRepliesApi')->with('likes.getUserData:id,name')->with('shareFeed.shareFeedData', 'shareFeed.shareFeedData.attachments', 'shareFeed.shareFeedData.getUser')->where(['user_id' => $user->following_user_id, 'type' => 'feed', 'status' => 'Y'])->where('is_deleted','!=' , '1')->whereNotIn('id' , $reportedFeed)->whereNotIn('id',$blocked )->orderBy('created_at', 'DESC')->get();
            // $followingUsersStories = Feed::with('getUser:id,username,first_name,last_name,avatar_location,cover_image')->where(['user_id' => $user->following_user_id, 'type' => 'story', 'status' => 'Y'])->select('id','user_id', 'post', 'type', 'visibility', 'slug','created_at', 'updated_at')->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->get();
            // $data['stories'] = $data['stories']->merge($followingUsersStories)->sortByDesc('id')->values();
            $data['feeds'] = $data['feeds']->merge($followingUsersFeeds)->sortByDesc('id')->values();
        }

        // $data['stories'] = $data['stories']->merge($friendsStories)->sortByDesc('id')->values();
        $data['feeds'] = $data['feeds']->merge($groupFeeds)->merge($pageFeeds)->sortByDesc('created_at');

        foreach ($data['feeds'] as $feed) {
            if($feed->likes_count  < 1) {
                $feed->likes_count = 0;
                $feed->save();
            }
            $feed->time = $feed->created_at->diffForHumans();
            $Class = optional($feed->pageDetails)->id ? '-page-' : (optional($feed->groupDetails)->id ? '-group-' : '');
            $feed->url = route('feedDetail', ['id' => base64_encode('feed_' . $Class . '_' . $feed->id)]);
            $feed->like = FeedsLike::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;
            foreach($feed->comments as $comment){
                $comment->time = $comment->created_at->diffForHumans();
                foreach($comment->getReplies as $reply){
                    $reply->time = $reply->created_at->diffForHumans();
                }
            }
            $feed->share_feed_count = ShareFeed::where('feed_id', $feed->id)->count();
            foreach ($feed->attachments as $attachment_data) {
                if(is_file(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment))){
                    if(isset($attachment_data->attachment) && $attachment_data->attachment_type == 'image'){
                        $attachment_data->imageDetails = getimagesize(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment));
                        $attachment_data->width = @$attachment_data->imageDetails[0];
                        $attachment_data->height = @$attachment_data->imageDetails[1];
                        unset($attachment_data->imageDetails);
                    }
                }
            }
            $feed['userLike'] = false;
            foreach($feed->likes as $like){
                if($like->user_id == $userId){
                    $feed['userLike'] = true;
                }
            }
        }
        $followingUsers = UserFollow::where('user_id', $userId)->pluck('following_user_id');

        $own_stories = User::where('id', $userId)->with(['stories' => fn($query) => $query->with('attachments')->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())])->whereHas('stories' , function($q){
            $q->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->where('status','Y');
            })->select('id','username','first_name','last_name','avatar_location','cover_image')->get();
        if(isset($own_stories) && count($own_stories) > 0){
            foreach ($own_stories as $storyData) {
                foreach ($storyData->stories as $story) {
                    $story->time = $story->created_at->diffForHumans();
                }
            }
        }

        $followers_stories = User::whereIn('id', $followingUsers)->with(['stories' => fn($query) => $query->with('attachments')->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())])->whereHas('stories' , function($q){
        $q->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->orderBy('created_at', 'DESC')->where('status','Y');
        })->select('id','username','first_name','last_name','avatar_location','cover_image')->get();
        if(isset($followers_stories) && count($followers_stories) > 0){
            foreach ($followers_stories as $storyData){
                foreach ($storyData->stories as $story){
                    $story->time = $story->created_at->diffForHumans();
                }
            }
        }

        //viewed stories

        $storyViewed = StoryViewed::where('user_id',$userId)->pluck('feed_id')->toArray();
        $data['stories'] = $own_stories->merge($followers_stories);
        foreach($data['stories'] as $story){
            foreach($story->stories as $userStory ){
                $userStory->viewed = in_array($userStory->id, $storyViewed);
                $viewed_count = StoryViewed::where('feed_id',$userStory->id)->count();
                $userStory->view_count = $viewed_count;
            }
            $story->all_viewed = true;
            foreach($story->stories as $userStory ){
                if($userStory->viewed == false){
                    $story->all_viewed = false;
                }
            }
        }

        // Suggested Feeds
        $publicgroupIds = Group::where(['group_type' => 'Public'])->pluck('id');
        $groupFeedsIds = GroupsFeed::whereIn('group_id', $publicgroupIds)->pluck('id');
        $groupFeedsSuggested = GroupsFeed::with('groupDetails')->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getReplies')->with('likes.getUserData:id,name')->where(['type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->whereNotIn('id', $groupFeedsIds)->get();

        $pageFeedsIds = PagesFeed::pluck('id');
        $pageFeedsSuggested = PagesFeed::with('pageDetails')->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getReplies')->with('likes.getUserData:id,name')->whereNotIn('id', $pageFeedsIds)->where(['type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->get();

        $feedsSuggested = collect();
        $feedsSuggested = $feedsSuggested->merge($feedsSuggested)->merge($groupFeedsSuggested)->merge($pageFeedsSuggested)->sortByDesc('created_at');

        // Suggested Pages

        $pages = Page::whereDoesntHave('pageMembersData', function($query) use ($userId){
            $query->where('user_id', $userId);
        })->where([['status', 'Y'],['admin_user_id', '!=', $userId]])->inRandomOrder()->groupBy('id')->get();

        $pageIds = $pages->pluck('id');
        $pageMembersIds = PageMembers::whereIn('page_id', $pageIds)->pluck('user_id');
        $pageMembers = User::whereIn('id', $pageMembersIds)->take(100)->get();

        // Suggested Pages

        $groups = Group::with('privateGroupRequest')->whereDoesntHave('groupMembersData', function($query) use ($userId){
           $query->where('user_id', $userId);
        })->where([['status', 'Y'],['admin_user_id', '!=', $userId]])->inRandomOrder()->groupBy('id')->get();

        $j = 0;
        foreach($groups as $group){
            if($group->group_type == 'Private'){
                $i = 0;
                foreach($group['privateGroupRequest'] as $privateGroupRequest){
                    if($privateGroupRequest->user_id != $userId){
                        $groupsPrivateAll[$i] = $group;
                    }
                    $i++;
                }
            }else{
                $groupsPublicAll[$j] = $group;
            }
            $j++;
        }

        if(!isset($groupsPublicAll)){
            $groupsPublicAll = [];
        }
        if(!isset($groupsPrivateAll)){
            $groupsPrivateAll = [];
        }

        $groups = collect();
        $groups = $groups->merge($groupsPrivateAll);
        $groups = $groups->merge($groupsPublicAll)->shuffle();

        $groupIds = $groups->pluck('id');
        $groupMembersIds = GroupMembers::whereIn('group_id', $groupIds)->pluck('user_id');
        $groupMembers = User::whereIn('id', $groupMembersIds)->take(100)->get();

        // Merge Pages And Groups Members

        $suggestedPeoples = collect();
        $suggestedPeoples = $suggestedPeoples->merge($groupMembers);
        $suggestedPeoples = $suggestedPeoples->merge($pageMembers);

        $suggestedPeoples->groupBy('id');
        $i = 0;
        foreach($suggestedPeoples as $suggestedPeople){
            $Friend = FriendRequest::whereIn('user_id', [$suggestedPeople->id, $userId])->whereIn('friend_id', [$suggestedPeople->id, $userId])->first();
            if(!isset($Friend)){
                $suggestedPeoplesAll[$i] =  $suggestedPeople;
            }
            $i++;
        }

        if(!isset($suggestedPeoplesAll)){
            $suggestedPeoplesAll = [];
        }

        $suggestedPeoples = collect($suggestedPeoplesAll);
        $suggestedPeoples = $suggestedPeoples->unique()->take(30)->sortByDesc('created_at')->shuffle();

        // Merge Pages And Groups

        $pages = $pages->shuffle()->take(10)->sortByDesc('created_at');
        $groups = $groups->take(10)->sortByDesc('created_at');

        // Array index change in sequence

        $i= 0;

        foreach ($data['feeds'] as $key => $value) {
            $feedsArray[$i] = $value;
            $i++;
        }

        if($data['feeds']->count() == 0){
            $feedsArray = $data['feeds'];
        }

        $data['feeds'] = $feedsArray;

        //End Array index change in sequence

        // Define Suggested Data On Indexes

        if (isset($data['feeds'][5])) {
            for ($i = count($data['feeds']) - 1; $i >= 5; $i--) {
                $data['feeds'][$i + 1] = $data['feeds'][$i];
            }
            $data['feeds'][5] = $suggestedPeoples;
        }


        if (isset($data['feeds'][10])) {
            for ($i = count($data['feeds']) - 1; $i >= 10; $i--) {
                $data['feeds'][$i + 1] = $data['feeds'][$i];
            }
            $data['feeds'][10] = [];
            $data['feeds'][10] = $groups;
        }

        if (isset($data['feeds'][15])) {
            for ($i = count($data['feeds']) - 1; $i >= 15; $i--) {
                $data['feeds'][$i + 1] = $data['feeds'][$i];
            }
            $data['feeds'][15] = [];
            $data['feeds'][15] = $pages;
        }

        $data['feeds'] = $this->paginate($data['feeds']);
        return response()->json(['success' => true, 'user' => $user_data ,'PostData' => $data ], 200);
    }

    public function getAllFeedsDuplicate($userId){
        $user = Customer::find($userId);
        if(!$user){
            return response()->json(['success' => false, 'error'=> 'user does not exists'],201);
        }

        //for blocked user
        $blocked = $userIds= [];
        $blockedUsers = BlockedUser::where('user_id', $userId)->get();
        foreach($blockedUsers as $blockUser){
            array_push($blocked, $blockUser->blocked_user_id);
        }
        //getting friends and followers for story data
        // $friendsData = Friend::where('user_id', $userId)->pluck('friend_id');
        // $otherFriendsData = Friend::where('friend_id', $userId)->pluck('user_id');
        $followingUsers = UserFollow::where('user_id', $userId)->pluck('following_user_id');
        array_push($userIds,$userId);

        $userIds = [...$userIds, ...$followingUsers];

        //for blocked or reported feeds
        $reported = [];
        $reportedFeeds = FeedReport::where('reported_user_id', $userId)->get();
        foreach($reportedFeeds as $reportedFeed){
            array_push($reported, $reportedFeed->feed_id);
        }

        $data['stories'] = User::whereIn('id', $userIds)->with('stories.attachments')->whereHas('stories' , function($q){
        $q->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->where('status','Y');
        })->select('id','username','first_name','last_name','avatar_location','cover_image')->get();

        $data['feeds'] = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')
        ->with('comments.getUserData:id,name,username,avatar_location')->with('likes.getUserData:id,name')
        ->where(['user_id' => $userId, 'type' => 'feed', 'status' => 'Y'])->where('is_deleted','!=' , '1')->orderBy('created_at', 'DESC')->get();


        $friends = Friend::where('user_id', $userId)->get();
        $followingUsers = UserFollow::where('user_id', $userId)->get();
        $friendsFeeds = $followingUsersFeeds  = [];
        foreach ($friends as $friend){
            $friendsFeeds = Feed::whereNotIn('id',$reported )->whereDoesntHave('blockedUser', function (Builder $query) use ($blocked) {
                $query->whereIn('blocked_user_id',$blocked );
            })->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location')->with('likes.getUserData:id,name')->where(['user_id' => $friend->friend_id, 'type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->get();
        //  $friendsStories = Feed::whereDoesntHave('blockedUser', function (Builder $query) use ($blocked) {
        //      $query->whereIn('blocked_user_id',$blocked );
        //  })->with('getUser:id,username,avatar_location')->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->where(['user_id' => $friend->friend_id, 'type' => 'story', 'status' => 'Y'])->select('id','user_id', 'post', 'type', 'visibility', 'slug','created_at', 'updated_at')->orderBy('created_at', 'DESC')->get();

        //  $data['stories'] = $data['stories']->merge($friendsStories);
            $data['feeds'] = $data['feeds']->merge($friendsFeeds)->sortByDesc('id')->values();
        }

        foreach ($followingUsers as $user){
            $followingUsersFeeds = Feed::whereNotIn('id',$reported )->whereDoesntHave('blockedUser', function (Builder $query) use ($blocked) {
                $query->whereIn('blocked_user_id',$blocked );
            })->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location')->with('likes.getUserData:id,name')->where(['user_id' => $user->following_user_id, 'type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->get();
            $followingUsersStories = Feed::whereDoesntHave('blockedUser', function (Builder $query) use ($blocked) {
                $query->whereIn('blocked_user_id',$blocked );
            })->with('getUser:id,username,avatar_location')->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->where(['user_id' => $user->following_user_id, 'type' => 'story', 'status' => 'Y'])->select('id','user_id', 'post', 'type', 'visibility', 'slug','created_at', 'updated_at')->orderBy('created_at', 'DESC')->get();

            // $data['stories'] = $data['stories']->merge($followingUsersStories);
            $data['feeds'] = $data['feeds']->merge($followingUsersFeeds)->sortByDesc('id')->values();
        }

        // $data['stories'] = $data['stories']->merge($friendsStories);
        // $data['feeds'] = $data['feeds']->merge($friendsFeeds);
        foreach ($data['stories'] as $story) {
            foreach ($story->stories as $storiesData) {
                $storiesData->time = $storiesData->created_at->diffForHumans();
                foreach($storiesData->attachments as $attachment_data ){
                    if(is_file(public_path('storage/user_posts/images/' . $attachment_data->attachment))){
                        if(isset($attachment_data->attachment) && $attachment_data->attachment_type == 'image'){
                            if(is_file(public_path('storage/user_posts/images/' . $attachment_data->attachment))){
                                $attachment_data->imageDetails = @getimagesize(public_path('storage/user_posts/images/' . $attachment_data->attachment));
                            }
                            $attachment_data->width = $attachment_data->imageDetails[0];
                            $attachment_data->height = $attachment_data->imageDetails[1];
                            unset($attachment_data->imageDetails);
                        }
                    }
                }
            }
        }
        foreach ($data['feeds'] as $feed) {
            $feed->time = $feed->created_at->diffForHumans();
            $feed->like = FeedsLike::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;
            $feed->favourite = FavouriteFeed::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;

            foreach($feed->comments as $comment){
                $comment->time = $comment->created_at->diffForHumans();
            }

            foreach ($feed->attachments as $attachment_data) {
                if(is_file(public_path('storage/user_posts/images/' . $attachment_data->attachment))){
                    if(isset($attachment_data->attachment) && $attachment_data->attachment_type == 'image'){
                        if(is_file(public_path('storage/user_posts/images/' . $attachment_data->attachment))){
                            $attachment_data->imageDetails = @getimagesize(public_path('storage/user_posts/images/' . $attachment_data->attachment));
                        }
                        $attachment_data->width = @$attachment_data->imageDetails[0];
                        $attachment_data->height = @$attachment_data->imageDetails[1];
                        unset($attachment_data->imageDetails);
                    }
                }
            }
        }

        return response()->json(['success' => true,  'PostData' => $data ], 200);
    }
    public function getUserFeeds($userId){
        $user = Customer::find($userId);
        if(!$user){
            return response()->json(['success' => false, 'error'=> 'user does not exists'],201);
        }
        if($userId){
            $blockusers = BlockedUser::where('user_id', $userId)->pluck('blocked_user_id')->toArray();
        }else {
            $blockusers = [];
        }
        $data['stories'] = Feed::with('getUser:id,username,first_name,last_name,avatar_location,cover_image')->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->where(['user_id' => $userId, 'type' => 'story'])->select('id','user_id', 'post', 'type', 'visibility','slug', 'created_at', 'updated_at')->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->get();
        // $data['feeds'] = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')
        // ->with(['comments' => function ($query) use ($blockusers) {
        //     $query->whereNotIn('user_id', $blockusers);
        // }])
        // ->with(['likes' => function ($query) use ($blockusers) {
        //     $query->whereNotIn('user_id', $blockusers);
        // }])->with('shareFeed.shareFeedData', 'shareFeed.shareFeedData.attachments', 'shareFeed.shareFeedData.getUser')->where(['user_id' => $userId, 'type' => 'feed'])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->paginate(20);
        $data['feeds'] = Feed::with([
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
        ->where(['user_id' => $userId, 'type' => 'feed'])
        ->orderBy('created_at', 'DESC')
        ->where('is_deleted', '!=' , '1')
        ->paginate(20);
    

        foreach ($data['feeds'] as $feed) {
            $Class = optional($feed->pageDetails)->id ? '-page-' : (optional($feed->groupDetails)->id ? '-group-' : '');
            $feed->url = route('feedDetail', ['id' => base64_encode('feed_' . $Class . '_' . $feed->id)]);
            $feed->time = $feed->created_at->diffForHumans();
            $feed->like = FeedsLike::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;
            $feed->favourite = FavouriteFeed::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;

            foreach($feed->comments as $comment){
                $comment->time = $comment->created_at->diffForHumans();
            }
            $feed->share_feed_count = ShareFeed::where('feed_id', $feed->id)->count();
            foreach ($feed->attachments as $attachment_data) {
                if(is_file(public_path('storage/user_posts/images/' . $attachment_data->attachment))){
                    if(isset($attachment_data->attachment) && $attachment_data->attachment_type == 'image'){
                        if(is_file(public_path('storage/user_posts/images/' . $attachment_data->attachment))){
                            $attachment_data->imageDetails = @getimagesize(public_path('storage/user_posts/images/' . $attachment_data->attachment));
                        }
                        $attachment_data->width = @$attachment_data->imageDetails[0];
                        $attachment_data->height = @$attachment_data->imageDetails[1];
                        unset($attachment_data->imageDetails);
                    }
                }
            }
        }


        return response()->json(['success' => true,  'PostData' => $data ], 200);
    }

    public function upcomingBirthdays($userId){
        $user = Customer::find($userId);
        if(!$user){
            return response()->json(['success' => false, 'error'=> 'user does not exists'],201);
        }
        $birthdaysData = Friend::with('getUserData:id,first_name,last_name,username,name,dob,gender,avatar_location,email')->whereHas('getUserData', function ($q) {
            $q->whereMonth('dob', Carbon::now()->month);
        })->where('user_id', $user->id)->get();

        if (isset($birthdaysData) && count($birthdaysData) > 0) {
            foreach ($birthdaysData as $birthday) {
                $current = strtotime(date("Y-m-d"));
                $date = strtotime($birthday->getUserData->dob);
                $datediff = $date - $current;
                $difference = floor($datediff / (60 * 60 * 24));
                if ($difference == 0) {
                    $birthday->getUserData->dob = 'Today';
                } else if ($difference > 1) {
                    $birthday->getUserData->dob = Carbon::parse($birthday->getUserData->dob)->format('M, d Y');
                } else if ($difference > 0) {
                    $birthday->getUserData->dob = 'Tomorrow';
                } else if ($difference < -1) {
                    $birthday->getUserData->dob = Carbon::parse($birthday->getUserData->dob)->format('M, d Y');
                } else {
                    $birthday->getUserData->dob = 'Yesterday';
                }
            }
        }
        return response()->json(['success' => true, 'birthdayData' => $birthdaysData ], 200);
    }

    public function createFeed(Request $req)
    {

        if(isset($req->formType) && $req->formType == 'sharePost'){
            $shareFeed = new ShareFeed;
            $shareFeed->user_id = $req->user_id;
            $shareFeed->feed_id = $req->feed_id;
            $shareFeed->post = $req->post;
            $shareFeed->type = $req->shareType;
            $shareFeed->status = 'Y';
            $shareFeed->save();

            $feed = new Feed;
            $feed->user_id = $req->user_id;
            $feed->share_feed_id = $shareFeed->id;
            $feed->type = $req->type;
            $feed->status = 'Y';
            $feed->save();

            $feed = Feed::find($req->feed_id);

            return response()->json(['message' => 'Share Successfully', 'data' => $feed], 200);
        }

        $feedData = Feed::create([
            'user_id' => $req->user_id,
            'parent_id' => $req->parent_id,
            'post'  => $req->post,
            'type' => $req->type,
            'visibility' => $req->visibility,
            'mood' => $req->mood,
            'status' => 'Y'
        ]);

        $feedData->slug = $feedData->type . '-' . $feedData->id;
        $feedData->save();
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

                $file->move(public_path('storage/images/feed-img/'.$req->user_id), $fileName);
                $attachmentData = FeedAttachment::create([
                    'feed_id' => $feedData->id,
                    'user_id' => $feedData->user_id,
                    'attachment_type' => @$attachment_type? $attachment_type: 'image',
                    'attachment' =>  time() . '-' . $_FILES['attachment']['name']
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 201);
        }

        return response()->json(['success' => true,  'message' => 'Post created successfully.', 'feed_id' =>$feedData->id], 200);
    }

    public function editFeed($id)
    {
        $data['feeds'] = Feed::with('getUser')->with('attachments')->where(['id' => $id])->first();
        return response()->json(['success' => true, 'data' =>$data], 200);
    }

    public function deleteFeedAttachments($feed_Id)
    {
        $data['feedAttachment'] = FeedAttachment::where('feed_id', $feed_Id)->get();
        if(isset($data['feedAttachment'][0]->id)){
            $data['feedAttachment']->each->delete();
            return response()->json(['success' => true, 'data' =>$data, 'message' => 'Feed attachment deleted successfully.'], 200);
        }else{
            return response()->json(['success' => false, 'message' => 'Feed attachments not found.'], 201);
        }
    }

    public function updateFeed(Request $request, $id)
    {
        $feedData = Feed::find($id);
        $feed = [
            'post'  => $request->post,
            'visibility' => $request->visibility,
        ];
        $feedData->update($feed);

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

                $file->move(public_path('storage/images/feed-img/'.$feedData->user_id), $fileName);
                $attachmentData = FeedAttachment::create([
                    'feed_id' => $feedData->id,
                    'user_id' => $feedData->user_id,
                    'attachment_type' => @$attachment_type? $attachment_type: 'image',
                    'attachment' =>  time() . '-' . $_FILES['attachment']['name']
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 201);
        }

        return response()->json(['success' => true,  'message' => 'Feed updated successfully.', 'feed_id' =>$feedData->id], 200);
    }

    public function updateShareFeed(Request $request, $id)
    {
        $feedData = ShareFeed::find($id);
        if(!$feedData){
            return response()->json(['success' => false, 'message'=> 'Share feed does not exists'],201);
        }
        $feed = [
            'post'  => $request->post,
        ];
        $feedData->update($feed);

        return response()->json(['success' => true,  'message' => 'Share Feed updated successfully.', 'feed_id' =>$feedData->id], 200);
    }

    public function saveLike(Request $request){
        $user = User::find($request->user_id);
        if(!$user){
            return response()->json(['success' => false, 'message'=> 'user does not exists'],201);
        }

        $check = FeedsLike::where(['user_id' =>  $request->user_id, 'feed_id' => $request->feed_id])->first();
        $feed = Feed::find($request->feed_id);
        $checkNotifications = Notifications::where(['user_id' =>  $feed->user_id, 'friend_id' => $request->user_id, 'feed_id' => $request->feed_id, 'notification_type' => 'feed_like'])->get();

        if($check){
            $check->delete();
            if(isset($feed) ){
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
            $like = FeedsLike::create($request->all());
            if(isset($feed) ){
                $feed->likes_count= $feed->likes_count+1;
                $feed->save();

            }
            $feedUser = User::find($feed->user_id);
            if($feed->user_id != $user->id){
                $notificationMessage =' liked your post. ';
                Notifications::sendFeedNotification($feed->user_id, $user->id, $request->feed_id, Null, 'notificationDetails/'.'feed_like'.'/'.$feed->user_id.'/'.$user->id.'/'.$request->feed_id, 'User Like Feed', 'feed_like', $notificationMessage);
            }

            return response()->json(['success' => true, 'message' => 'Like submitted successfully' , 'like' =>$like], 200);
        }

    }

    public function saveComment(Request $request){
        $user = Customer::find($request->user_id);
        if(!$user){
            return response()->json(['success' => false, 'message'=> 'User does not exists'],201);
        }
        $feed = Feed::find($request->feed_id);

        $comment = FeedComment::create($request->all());

        if(isset($feed) ){
            $feed->comments_count= $feed->comments_count+1;
            $feed->save();
        }

        if(isset($request->parent_id) && $request->parent_id != 0){
            $notificationMessage =' replied on your comment.';
            $FeedComment = FeedComment::find($request->parent_id);
            $feed->user_id = $FeedComment->user_id;
        }

        //notification for comment
        if($feed->user_id != $user->id || isset($request->parent_id) && $request->parent_id != 0 && $FeedComment->user_id != $request->user_id){

            if(!isset($request->parent_id) || $request->parent_id == '0'){
                $notificationMessage =' commented on your post.';
            }

            Notifications::sendFeedNotification($feed->user_id, $user->id, $request->feed_id, $comment->id, 'notificationDetails/'.'feed_comment'.'/'.$feed->user_id.'/'.$user->id.'/'.$request->feed_id, 'User comment Feed', 'feed_comment', $notificationMessage);
        }
        return response()->json(['success' => true, 'message' => 'Comment submitted successfully', 'comment' =>$comment ], 200);
    }

    public function viewAllComments($feed_id, $user_id)
    {
        $feed = Feed::find($feed_id);
        if (!isset($feed) || !$feed) {
            return response()->json(['success' => false, 'message' => 'Feed does not exist'], 201);
        }

        $comments = FeedComment::where('parent_id', 0)
            ->with('getUserData:id,first_name,last_name,name,username,avatar_location')
            ->with('getRepliesApi.getUserData:id,first_name,last_name,username,avatar_location')
            ->where('feed_id', $feed_id)
            ->get();

        if (!isset($comments) || count($comments) < 1) {
            return response()->json(['success' => false, 'message' => 'Comments do not exist for this feed', 'comments' => $comments], 200);
        }

        $likes = CommentLike::where('user_id', $user_id)
            ->get()
            ->keyBy('comment_id');

        foreach ($comments as $comment) {
            $comment->time = $comment->created_at->diffForHumans();
            $comment->like = $likes->has($comment->id);

            $this->loadLikesRecursively($comment, $likes);
        }

        return response()->json(['success' => true, 'comments' => $comments], 200);
    }

    private function loadLikesRecursively($comment, $likes)
    {
        foreach ($comment->getRepliesApi as $reply) {
            $reply->like = $likes->has($reply->id);
            $this->loadLikesRecursively($reply, $likes);
        }
    }

    public function viewAllLikes($feed_id){
        $feed = Feed::find($feed_id);
        if(!isset($feed) || !$feed){
            return response()->json(['success' => false, 'message'=> 'Feed does not exists'],201);
        }
        $likes = FeedsLike::with('getUserData:id,first_name,last_name,name,username,avatar_location')->where('feed_id', $feed_id)->get();
        if(!isset($likes) || count($likes) < 1){
            return response()->json(['success' => false, 'message'=> 'Likes does not exists for this feed', 'likes' =>$likes ],200);
        }
        return response()->json(['success' => true, 'likes' =>$likes ], 200);
    }

    public function removeFeed(Request $req){
        $feed = Feed::where([ 'id' => $req->feed_id, 'user_id' => $req->user_id])->first();
        if(!isset($feed) || !$feed){
            return response()->json(['success' => false, 'message'=> 'Feed does not exists'],201);
        }
        $userId = $feed->user_id;

        //removing images and videos against the feed
        // $feedAttachments = FeedAttachment::where('feed_id', $req->feed_id)->get();
        // $mainPath = storage_path();

        // foreach($feedAttachments as $attachmentFile){

        //     $file_path = $mainPath . '/app/public/user_posts/' . $attachmentFile->attachment_type . 's/' . $attachmentFile->attachment;
        //     if(file_exists($file_path)){
        //         unlink($file_path);
        //     }

        // }
        // dd($file_path);
        $feed->is_deleted = 1;
        $feed->save();

        //removing comments agaist the respective feed
        // $comments = FeedComment::where('feed_id' ,$req->feed_id)->get();
        // if ($comments) {
        //     foreach ($comments as $comment) {
        //         $comment->delete();
        //     }
        // }

        //removing likes agaist the respective feed
        // $likes = FeedsLike::where('feed_id' ,$req->feed_id)->get();
        // if($likes){
        //     foreach($likes as $likes){
        //         $likes->delete();
        //     }
        // }
        //remaining feeds with data
        $remainingFeeds = $data['feeds'] = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->where('is_deleted','!=' , '1')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location')->with('likes.getUserData:id,name')->where(['user_id' => $userId, 'type' => 'feed', 'status' => 'Y'])->get();
        foreach ($data['feeds'] as $feed) {
            $feed->time = $feed->created_at->diffForHumans();
            $feed->like = FeedsLike::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;
            foreach($feed->comments as $comment){
                $comment->time = $comment->created_at->diffForHumans();
            }
            foreach ($feed->attachments as $attachment_data) {
                if(is_file(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment))){
                    if (isset($attachment_data->attachment) && $attachment_data->attachment_type == 'image') {
                        $attachment_data->imageDetails = getimagesize(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment));
                        $attachment_data->width = @$attachment_data->imageDetails[0];
                        $attachment_data->height = @$attachment_data->imageDetails[1];
                        unset($attachment_data->imageDetails);
                    }
                }
                unset($attachment_data->imageDetails);
            }
        }
        Notifications::where(['feed_id'=> $req->feed_id])->whereIn('notification_type', ['feed_like', 'feed_comment', 'feed_comment_like'])->delete();
        return response()->json(['success' => true,'message'=> 'Feed deleted successfully', 'remainingFeeds' => $remainingFeeds ],200);
    }

    public function removeComment($commentId)
    {
        $comment = FeedComment::with('getRepliesApi')->where('id', $commentId)->get();
        $feed = Feed::find($comment[0]->feed_id);
        foreach($comment as $key => $data['commentChilds']){
            $data['feedId'] = $comment[0]->feed_id;
            if(isset($comment)){
                if(isset($feed)){
                    $feed->comments_count = $feed->comments_count - 1;
                    $feed->save();
                    $checkNotifications = Notifications::where(['comment_id'=> $data['commentChilds']->id, 'feed_id' => $comment[0]->feed_id])->whereIn('notification_type', ['feed_comment', 'feed_comment_like'])->get();
                    if(isset($checkNotifications)){
                        $checkNotifications->each->delete();
                    }
                    $data['commentChilds']->delete();
                }
            }
            $this->deleteFeedCommentChilds($data);
        }
        return response()->json(['success' => true, 'message' => 'Comment removed successfully'], 200);

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

    public function saveLikeForComment(Request $request){
        $user = Customer::find($request->user_id);
        if(!$user){
            return response()->json(['success' => false, 'message'=> 'user does not exists'],201);
        }
        //check for exisiting like
        $check = CommentLike::where(['user_id' =>  $request->user_id, 'comment_id' => $request->comment_id])->first();
        $comment = FeedComment::find($request->comment_id);
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

        $like = CommentLike::create($request->all());
        if(isset($comment) ){
            $comment->likes_count= $comment->likes_count+1;
            $comment->save();
        }
        //notification for comment like
        if($comment->user_id != $user->id){
            $notificationMessage =' liked your comment.';
            Notifications::sendFeedCommentsLikeNotification($comment->user_id, $user->id, $comment->feed_id, $request->commentId, 'notificationDetails/'.'feed_comment_like'.'/'.$comment->user_id.'/'.$user->id.'/'.$comment->feed_id, 'User Like on Comment NewsFeed', 'feed_comment_like', $notificationMessage);
        }
        return response()->json(['success' => true, 'message' => 'Like submitted successfully' , 'like' =>$like], 200);
    }

    public function uploadFeedImages(Request $req)
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
                $feed = Feed::find($req->feed_id);
                $file->move(public_path('storage/images/feed-img/'.$feed->user_id), $fileName);
                if (isset($feed) && $feed !=null) {

                    $attachmentData = FeedAttachment::create([
                        'feed_id' => $req->feed_id,
                        'user_id' => $feed->user_id,
                        'attachment_type' => @$attachment_type?  $attachment_type : 'image' ,
                        'attachment' =>  time() . '-' . $_FILES['attachment']['name']
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 201);
        }

        return response()->json(['success' => true,  'message' => 'Post created successfully', 'feed_id' =>$req->feed_id], 200);
    }

    public function AddToFavFeed(Request $request){
        $data = $request->all();
        $user = Customer::find($request->user_id);
        if(!$user){
            return response()->json(['success' => false, 'message'=> 'User does not exists'],201);
        }
        if($request->type == 'feed'){
            $feed = Feed::find($request->feed_id);
            if(!$feed){
                return response()->json(['success' => false, 'message'=> 'Feed does not exists'],201);
            }
            $existingFeed = FavouriteFeed::where(['feed_id' => $request->feed_id, 'user_id' => $request->user_id, 'type' => 'feed'])->first();

            if($existingFeed){
                $existingFeed->delete();
                $favouriteFeed = FavouriteFeed::with('getFeedData.attachments')->where(['user_id' => $request->user_id, 'type' => 'feed'])->get();
                return response()->json(['success' => true, 'message' => 'Feed removed from favourite successfully' ,'favouriteFeeds' => $favouriteFeed ], 200);
            }
            $data['type'] = 'feed';
            FavouriteFeed::create($data);
            $favouriteFeed = FavouriteFeed::with('getFeedData.attachments')->where(['user_id' => $request->user_id, 'type' => 'feed'])->get();
            return response()->json(['success' => true, 'message' => 'Feed added to favourite successfully' ,'favouriteFeeds' => $favouriteFeed ], 200);
		}elseif($request->type == 'group'){
            $feed = GroupsFeed::find($request->feed_id);
            if(!$feed){
                return response()->json(['success' => false, 'message'=> 'Group feed does not exists'],201);
            }
            $existingFeed = FavouriteFeed::where(['feed_id' => $request->feed_id, 'user_id' => $request->user_id, 'type' => 'group'])->first();

            if($existingFeed){
                $existingFeed->delete();
                $favouriteFeed = FavouriteFeed::with('getGroupFeedData.attachments')->where(['user_id' => $request->user_id, 'type' => 'group'])->get();
                return response()->json(['success' => true, 'message' => 'Group feed removed from favourite successfully' ,'favouriteFeeds' => $favouriteFeed], 200);
            }
            $data['type'] = 'group';
            FavouriteFeed::create($data);
            $favouriteFeed = FavouriteFeed::with('getGroupFeedData.attachments')->where(['user_id' => $request->user_id, 'type' => 'group'])->get();
            return response()->json(['success' => true, 'message' => 'Group feed added to favourite successfully' ,'favouriteFeeds' => $favouriteFeed], 200);
		}elseif($request->type == 'page'){
            $feed = PagesFeed::find($request->feed_id);
            if(!$feed){
                return response()->json(['success' => false, 'message'=> 'Page feed does not exists'],201);
            }
            $existingFeed = FavouriteFeed::where(['feed_id' => $request->feed_id, 'user_id' => $request->user_id, 'type' => 'page'])->first();

            if($existingFeed){
                $existingFeed->delete();
                $favouriteFeed = FavouriteFeed::with('getPageFeedData.attachments')->where(['user_id' => $request->user_id, 'type' => 'page'])->get();
                return response()->json(['success' => true, 'message' => 'Page feed removed from favourite successfully' ,'favouriteFeeds' => $favouriteFeed], 200);
            }
            $data['type'] = 'page';
            FavouriteFeed::create($data);
            $favouriteFeed = FavouriteFeed::with('getPageFeedData.attachments')->where(['user_id' => $request->user_id, 'type' => 'page'])->get();
            return response()->json(['success' => true, 'message' => 'Page feed added to favourite successfully' ,'favouriteFeeds' => $favouriteFeed], 200);
        }else{
            return response()->json(['success' => false, 'message'=> 'Feed does not exists'],201);
        }
    }

    public function RemoveFromFavFeed(Request $request){
        $user = Customer::find($request->user_id);
        if(!$user){
            return response()->json(['success' => false, 'message'=> 'User does not exists'],201);
        }
        $feed = Feed::find($request->feed_id);
        if(!$feed){
            return response()->json(['success' => false, 'message'=> 'Feed does not exists'],201);
        }

        $favFeed = FavouriteFeed::where(['feed_id' => $request->feed_id, 'user_id' => $request->user_id])->first();
        if($favFeed){
            $favFeed->delete();
            $remainingFavFeed = FavouriteFeed::with('getFeedData.attachments')->where('user_id', $request->user_id)->get();
            return response()->json(['success' => true, 'message' => 'Feed removed from favourite successfully' ,'favouriteFeeds' => $remainingFavFeed ], 200);
        }else{
            return response()->json(['success' => true, 'message' => 'This Feed doesn\'t exists in your favourites' ], 200);
        }
    }

    public function getFavouriteFeeds($userId){
        $user = Customer::find($userId);
        if(!$user){
            return response()->json(['success' => false, 'error'=> 'user does not exists'],201);
        }
        $favFeedsIds = FavouriteFeed::where('user_id', $userId)->pluck('feed_id')->toArray();

        // $data['feeds'] = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location')->with('shareFeed.shareFeedData', 'shareFeed.shareFeedData.attachments', 'shareFeed.shareFeedData.getUser')->whereIn('id', $favFeedsIds)->with('likes.getUserData:id,name')->where(['type' => 'feed', 'status' => 'Y'])->where('is_deleted','!=' , '1')->orderBy('created_at', 'DESC')->get();
        if($userId){
            $blockusers = BlockedUser::where('user_id', $userId)->pluck('blocked_user_id')->toArray();
        }else {
            $blockusers = [];
        }
        $data['feeds'] = Feed::with([
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
        ->whereIn('id', $favFeedsIds)
        ->where(['type' => 'feed', 'status' => 'Y'])
        ->orderBy('created_at', 'DESC')
        ->where('is_deleted', '!=' , '1')
        ->get();
        if($data['feeds']){
            foreach ($data['feeds'] as $feed) {
                $Class = optional($feed->pageDetails)->id ? '-page-' : (optional($feed->groupDetails)->id ? '-group-' : '');
                $feed->url = route('feedDetail', ['id' => base64_encode('feed_' . $Class . '_' . $feed->id)]);
                $feed->time = $feed->created_at->diffForHumans();
                $feed->like = FeedsLike::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;
                $feed->favourite = FavouriteFeed::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;

                foreach($feed->comments as $comment){
                    $comment->time = $comment->created_at->diffForHumans();
                }

                foreach ($feed->attachments as $attachment_data) {
                    if(is_file(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment))){
                        if(isset($attachment_data->attachment) && $attachment_data->attachment_type == 'image'){
                            if(is_file(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment))){
                                $attachment_data->imageDetails = @getimagesize(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment));
                            }
                            $attachment_data->width = @$attachment_data->imageDetails[0];
                            $attachment_data->height = @$attachment_data->imageDetails[1];
                            unset($attachment_data->imageDetails);
                        }
                    }
                }
            }
        }
        $favGroupFeedsIds = FavouriteFeed::where(['user_id' => $userId, 'type' => 'group'])->pluck('feed_id')->toArray();
        $data['Groupfeeds'] = GroupsFeed::with('groupDetails')->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getReplies')->with('likes.getUserData:id,name')->with('shareFeed.shareGroupFeedData', 'shareFeed.shareGroupFeedData.attachments', 'shareFeed.shareGroupFeedData.getUser', 'shareFeed.shareGroupFeedData.groupDetails')->whereIn('id' ,$favGroupFeedsIds)->where(['type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->get();

        if($data['Groupfeeds']){
            foreach ($data['Groupfeeds'] as $feed) {
                $Class = optional($feed->pageDetails)->id ? '-page-' : (optional($feed->groupDetails)->id ? '-group-' : '');
                $feed->url = route('feedDetail', ['id' => base64_encode('feed_' . $Class . '_' . $feed->id)]);
                $feed->time = $feed->created_at->diffForHumans();
                $feed->like = FeedsLike::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;
                $feed->favourite = FavouriteFeed::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;

                foreach($feed->comments as $comment){
                    $comment->time = $comment->created_at->diffForHumans();
                }

                foreach ($feed->attachments as $attachment_data) {
                    if(is_file(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment))){
                        if(isset($attachment_data->attachment) && $attachment_data->attachment_type == 'image'){
                            if(is_file(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment))){
                                $attachment_data->imageDetails = @getimagesize(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment));
                            }
                            $attachment_data->width = @$attachment_data->imageDetails[0];
                            $attachment_data->height = @$attachment_data->imageDetails[1];
                            unset($attachment_data->imageDetails);
                        }
                    }
                }
            }
        }
        $favPageFeedsIds = FavouriteFeed::where(['user_id' => $userId, 'type' => 'page'])->pluck('feed_id')->toArray();
        $data['Pagefeeds'] = PagesFeed::with('pageDetails')->with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getReplies')->with('likes.getUserData:id,name')->with('shareFeed.sharePageFeedData', 'shareFeed.sharePageFeedData.attachments', 'shareFeed.sharePageFeedData.getUser', 'shareFeed.sharePageFeedData.pageDetails')->whereIn('id' ,$favPageFeedsIds)->where(['type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'DESC')->where('is_deleted','!=' , '1')->get();
        
        if($data['Pagefeeds']){
            foreach ($data['Pagefeeds'] as $feed) {
                $Class = optional($feed->pageDetails)->id ? '-page-' : (optional($feed->groupDetails)->id ? '-group-' : '');
                $feed->url = route('feedDetail', ['id' => base64_encode('feed_' . $Class . '_' . $feed->id)]);
                $feed->time = $feed->created_at->diffForHumans();
                $feed->like = FeedsLike::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;
                $feed->favourite = FavouriteFeed::where(['feed_id' => $feed->id, 'user_id' => $userId])->first() ? true : false;

                foreach($feed->comments as $comment){
                    $comment->time = $comment->created_at->diffForHumans();
                }

                foreach ($feed->attachments as $attachment_data) {
                    if(is_file(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment))){
                        if(isset($attachment_data->attachment) && $attachment_data->attachment_type == 'image'){
                            if(is_file(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment))){
                                $attachment_data->imageDetails = @getimagesize(public_path('storage/images/feed-img/'.$userId. '/' . $attachment_data->attachment));
                            }
                            $attachment_data->width = @$attachment_data->imageDetails[0];
                            $attachment_data->height = @$attachment_data->imageDetails[1];
                            unset($attachment_data->imageDetails);
                        }
                    }
                }
            }
        }
        return response()->json(['success' => true,  'favFeedsData' => $data ], 200);
    }

    public function getFeedLikes($feedId){
        $feed = Feed::find($feedId);
        if(!$feed){
            return response()->json(['success' => false, 'error'=> 'feed does not exists'],201);
        }
        $feedLikes = FeedsLike::with('getUserData:id,first_name,last_name,name,username,avatar_location')->where('feed_id', $feedId)->get();
        return response()->json(['feedLikes'=>$feedLikes ,'success' => true],200);
    }

    public function hidePost($feed_id)
    {
        $feed = Feed::find($feed_id);
        if(isset($feed)){
            $feed->hide_from_timeline = 1;
            $feed->save();
            return response()->json(['success' => true, 'message'=> 'feed hide from timeline successfully.'],200);
        }else{
            return response()->json(['success' => false, 'message'=> 'feed does not exists'],201);
        }
    }

    public function removeStory($feed_id)
    {
        $feed = Feed::find($feed_id);
        if(isset($feed)){
            $feed->is_deleted = 1;
            $feed->status = 'N';
            $feed->save();
            return response()->json(['success' => true, 'message'=> 'Story deleted successfully.'],200);
        }else{
            return response()->json(['success' => false, 'message'=> 'Story does not exists'],201);
        }
    }

    public function paginate($items, $perPage = 20, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $itemsForPage = $items->forPage($page, $perPage)->values()->all();
        return new LengthAwarePaginator($itemsForPage, $items->count(), $perPage, $page, $options);
    }

    public function commentLikeUsers($commentId, $checkUser = false)
    {
        $comment = FeedComment::find($commentId);
        if(!$comment ){
            return response()->json(['success' => true, 'message' => 'comment does not exist'], 200);
        }
        $userIds = CommentLike::where(['comment_id' => $commentId])->pluck('user_id')->toArray();
        $usersData = User::join('comment_likes', 'users.id', '=', 'comment_likes.user_id')
            ->whereIn('users.id', $userIds)
            ->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.avatar_location',
                'users.cover_image',
                'users.username',
                \DB::raw('MAX(comment_likes.created_at) as like_created_at'),
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
