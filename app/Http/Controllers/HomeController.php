<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\Page;
use App\Models\PagesFeed;
use App\Models\PageMembers;
use App\Models\Group;
use App\Models\GroupMembers;
use App\Models\GroupsFeed;
use App\Models\Friend;
use App\Models\Feed;
use App\Models\ShareFeed;
use App\Models\UserProfileImage;
use App\Models\UserFollow;
use App\Models\BlockedUser;
use App\Models\CalenderEvents;
use App\Models\BlogPost;
use App\Models\NewsPost;
use App\Models\Webinar;
use App\Models\WebinarRegistration;
use App\Models\Speaker;
use App\Models\State;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Contact\SendContact;
use App\Models\GroupFollow;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /*
     * Dashboard Pages Routes
     */
    public function edit($id)
    {
        $users = User::findOrFail($id);
    }
    // public function index()
    // {
    //     $path = public_path('splash/index.php');
    //     return response()->file($path);
    // }

    public function home(Request $request)
    // public function index()
    {
        $user = auth()->user();
        $id = $user->id;

        $commentsUser = [];
        $index = 0;
        $data['user'] = User::find($id);
        $userIds= [];
        $userId[]=$id;
        $otherFriendsData = Friend::where('friend_id', $userId)->pluck('user_id');
        $followingUsers = UserFollow::where('user_id', $userId)->pluck('following_user_id');
        array_push($userIds,$userId);
        $userIds = [...$userIds, ...$followingUsers, ...$otherFriendsData];
        $mergeAllIds = array_merge($followingUsers->toArray(),$otherFriendsData->toArray(),$userId);
        $sorIdUser='';
        $lastKey = array_key_last($mergeAllIds);
        foreach($mergeAllIds as $key=>$getUserIdItem){
            $sorIdUser .= "'".$getUserIdItem."'";
            if($key != $lastKey){
                $sorIdUser .=",";
            }
        }

        $data['storiesrev'] = User::whereIn('id', $userIds)->with(['stories' => fn($query) => $query->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())])->whereHas('stories' , function($q){
            $q->with(['attachments' => fn($query) => $query->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())])->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->where('status','Y');
            })->orderByRaw(DB::raw("FIELD(id,$sorIdUser)"))->select('id','username','first_name','last_name','avatar_location','cover_image')->get();
       
        $data['stories'] = Feed::with('getUser:id,username,first_name,last_name,avatar_location,cover_image,email')->where(['user_id' => $id, 'type' => 'story', 'status' => 'Y'])->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->select('id','user_id', 'post', 'type', 'visibility','slug', 'created_at', 'updated_at')->orderBy('created_at', 'DESC')->get();
        $data['feeds'] = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location,first_name,last_name')->with('comments.getReplies.getUserData:id,name,first_name,last_name,username,avatar_location')->with('comments.commentLikes')->with('likes.getUserData:id,username,first_name,last_name,avatar_location')->with('shareFeed.shareFeedData', 'shareFeed.shareFeedData.attachments', 'shareFeed.shareFeedData.getUser')->where(['user_id' => $id, 'type' => 'feed', 'status' => 'Y', 'is_deleted' => 0, 'hide_from_timeline' => 0])->orderBy('created_at', 'DESC')->get();
        
        $friends = Friend::where('user_id', $id)->get();
        $otherFriends = Friend::where('friend_id', $id)->get();
        $followingUsers = UserFollow::where('user_id', $id)->get();
        $otherFollowingUsers = UserFollow::where('following_user_id', $id)->get();
        $friendsStories = $friendsFeeds = $followingUsersFeeds = $followingUsersStories = [];

        foreach ($followingUsers as $user){
            $followingUsersFeeds = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username,email')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location,first_name,last_name')->with('comments.getReplies.getUserData:id,name,username,avatar_location,first_name,last_name')->with('comments.commentLikes')->with('likes.getUserData:id,username,first_name,last_name,avatar_location')->where(['user_id' => $user->following_user_id, 'type' => 'feed', 'status' => 'Y', 'is_deleted' => 0, 'hide_from_timeline' => 0, 'report_count' => 0])->orderBy('created_at', 'DESC')->get();
            $followingUsersStories = Feed::with('getUser:id,first_name,last_name,username,avatar_location,email')->where(['user_id' => $user->following_user_id, 'type' => 'story', 'status' => 'Y'])->select('id','user_id', 'post', 'type', 'visibility', 'slug','created_at', 'updated_at')->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->orderBy('created_at', 'DESC')->get();
            $data['stories'] = $data['stories']->merge($followingUsersStories)->sortByDesc('id')->values();
            $data['feeds'] = $data['feeds']->merge($followingUsersFeeds)->sortByDesc('id')->values();
        }
        foreach ($otherFollowingUsers as $user){
            $followingUsersFeeds = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username,email')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location,first_name,last_name')->with('comments.getReplies.getUserData:id,name,username,avatar_location,first_name,last_name')->with('comments.commentLikes')->with('likes.getUserData:id,username,first_name,last_name,avatar_location')->where(['user_id' => $user->user_id, 'type' => 'feed', 'status' => 'Y', 'is_deleted' => 0, 'hide_from_timeline' => 0,'report_count' => 0])->orderBy('created_at', 'DESC')->get();
            $followingUsersStories = Feed::with('getUser:id,first_name,last_name,username,avatar_location,email')->where(['user_id' => $user->following_user_id, 'type' => 'story', 'status' => 'Y'])->select('id','user_id', 'post', 'type', 'visibility', 'slug','created_at', 'updated_at')->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->orderBy('created_at', 'DESC')->get();
            $data['stories'] = $data['stories']->merge($followingUsersStories)->sortByDesc('id')->values();
            $data['feeds'] = $data['feeds']->merge($followingUsersFeeds)->sortByDesc('id')->values();
        }
        if(isset($data['feeds']) && count($data['feeds']) > 0)
        {
            $datauserLikeFriend = [];
            foreach($data['feeds'] as $likeFriendUsers){
                foreach($likeFriendUsers['likes'] as $likeFriendUser){
                    $datauserLikeFriend[] = Friend::whereIn('user_id', [$likeFriendUser->user_id, auth()->user()->id])->whereIn('friend_id', [$likeFriendUser->user_id, auth()->user()->id])->first();
                }
            }
            $data['likes']['friendList'] = $datauserLikeFriend;

            foreach ($data['feeds'] as $feed) {
                foreach ($feed['comments'] as $getUser) {
                    if(isset($getUser) && $getUser !== ''){
                        $commentsUser[$index]['id'] = @$getUser['getUserData']->id;
                        $commentsUser[$index]['name'] = @$getUser['getUserData']->first_name.' '.@$getUser['getUserData']->last_name;
                        $commentsUser[$index]['username'] = @$getUser['getUserData']->username;
                        $index++;
                    }
                    else{
                        continue;
                    }
                }
            }
            $data['commentsUser'] = $commentsUser;
        } else {
            $data['commentsUser'] = '';
        }

        $user = auth()->user();
        // $dobs = $user->getBirthdays();
        // $data['birthdaysData'] = $dobs;
        // $data['webinars'] = Webinar::with('speaker:id,first_name,last_name,profile')->where([['show_in_app', 1],['webinar_type', 'website'],['end_date', '>=', date('y-m-d h:i:s')],['status', 'Y']])->limit(3)->get();

        // $data['pages'] = Page::whereDoesntHave('pageMembersData', function($query) use ($user){
        //     $query->where('user_id', $user->id);
        // })->where([['status', 'Y'],['admin_user_id', '!=', $user->id]])->limit(3)->get();

        // $data['groups'] = Group::with('privateGroupRequest')->whereDoesntHave('groupMembersData', function($query) use ($user){
        //     $query->where('user_id', $user->id);
        // })->where([['status', 'Y'],['admin_user_id', '!=', $user->id]])->limit(3)->get();

        
        //Group posts
        
        $getGroupId = GroupMembers::where(['user_id'=> $user->id])->pluck('group_id')->toArray();
        $blockedFriends = BlockedUser::Where('user_id', $user->id)->pluck( 'blocked_user_id')->toArray();

        $blockedOtherFriends = BlockedUser::Where('blocked_user_id', $user->id)->pluck( 'user_id')->toArray();

        $data['groupDetail'] = Group::with(
            ['groupMembers' => function ($query) use ($blockedFriends, $blockedOtherFriends) 
                {
                    $query->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends));
                }
            ]
        )->where('status' , 'Y')->whereIn('id',$getGroupId)->get();
        $allGroups = Group::where(['status'=> 'Y'])->pluck('id');
        $groupsFollowed = GroupFollow::where(['user_id'=> $user->id])->whereIn('group_id', $allGroups)->pluck('group_id');
        $groupsOwn = Group::where(['admin_user_id'=> $user->id])->where('status', 'Y')->pluck('id');
        $groupsFollows = collect($groupsFollowed)->merge($groupsOwn)->unique();

        $data['groupfeeds'] = GroupsFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,first_name,last_name,name,avatar_location,username')->with('comments.getReplies.getUserData:id,first_name,last_name,name,username,avatar_location')->with('comments.commentLikes')->with('groupDetails:id,admin_user_id,group_name,profile_image')->with('likes.getUserData:id,first_name,last_name,name,username')->with('shareFeed.shareGroupFeedData', 'shareFeed.shareGroupFeedData.attachments', 'shareFeed.shareGroupFeedData.getUser', 'shareFeed.shareGroupFeedData.groupDetails')->where(['approve_feed' => 'Y', 'status' => 'Y','is_deleted' => 0])->whereIn('group_id',$groupsFollows)->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends))->orderBy('created_at', 'DESC')->get();
        
        // $data['groupDetailIds'] = Group::where(['status' => 'Y', 'group_type' => 'Public'])->pluck('id');
        // $data['groupFeedsSuggested'] = GroupsFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,first_name,last_name,name,avatar_location,username')->with('comments.getReplies.getUserData:id,first_name,last_name,name,username,avatar_location')->with('comments.commentLikes')->with('groupDetails:id,admin_user_id,group_name,profile_image')->with('likes.getUserData:id,first_name,last_name,name,username')->with('shareFeed.shareGroupFeedData', 'shareFeed.shareGroupFeedData.attachments', 'shareFeed.shareGroupFeedData.getUser', 'shareFeed.shareGroupFeedData.groupDetails')->where(['approve_feed' => 'Y', 'status' => 'Y','is_deleted' => 0])->whereNotIn('group_id', $data['groupDetailIds'])->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends))->orderBy('created_at', 'DESC')->get();
        
        
        //Start Page Feed
        $allPage = Page::where(['status' => 'Y'])->pluck('id');
        $getPageId = PageMembers::where(['user_id'=> $user->id])->whereIn('page_id',$allPage)->pluck('page_id')->toArray();
        $blockedFriendsPages = BlockedUser::Where('user_id', $user->id)->pluck( 'blocked_user_id')->toArray();
        $blockedOtherFriendsPages = BlockedUser::Where('blocked_user_id', $user->id)->pluck( 'user_id')->toArray();

        $data['pageDetail'] = Page::with(['pageMembers' => function ($query) use ($blockedFriendsPages, $blockedOtherFriendsPages) {
            $query->whereNotIn('user_id', array_merge($blockedFriendsPages, $blockedOtherFriendsPages));
        }])->where(['status' => 'Y'])->whereIn('id',$getPageId)->get();

        $data['checkMember'] = PageMembers::where(['user_id'=> auth()->user()->id])->whereIn('page_id',$getPageId)->whereNotIn('user_id', array_merge($blockedFriendsPages, $blockedOtherFriendsPages))->first();
        $data['checkMemberCount'] = PageMembers::whereIn('page_id',$getPageId)->count();
        $index = 0;
        $data['pagefeeds'] = PagesFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData')->with('comments.getReplies.getUserData')->with('comments.commentLikes')->with('likes.getUserData')->with('pageDetails')->with('shareFeed.sharePageFeedData', 'shareFeed.sharePageFeedData.attachments', 'shareFeed.sharePageFeedData.getUser', 'shareFeed.sharePageFeedData.pageDetails')->where(['status' => 'Y','is_deleted' => 0])->whereIn('page_id',$getPageId)->orderBy('created_at', 'DESC')->get();
        
        // $data['pagefeedsIds'] = PagesFeed::where('status' , 'Y')->pluck('id');
        // $data['pageFeedsSuggested'] = PagesFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData')->with('comments.getReplies.getUserData')->with('comments.commentLikes')->with('likes.getUserData')->with('pageDetails')->with('shareFeed.sharePageFeedData', 'shareFeed.sharePageFeedData.attachments', 'shareFeed.sharePageFeedData.getUser', 'shareFeed.sharePageFeedData.pageDetails')->where(['status' => 'Y','is_deleted' => 0])->whereNotIn('id',$data['pagefeedsIds'])->orderBy('created_at', 'DESC')->get();

        //End Page Feed


        //Merge TimeLine & GroupFeed
        $allItems = collect();
        $allItems = $allItems->merge($data['feeds']);
        $allItems = $allItems->merge($data['groupfeeds']);
        $allItems = $allItems->merge($data['pagefeeds']);

        // if($allItems->count() == 0){
        //     $allItems = $allItems->merge($data['pageFeedsSuggested']);
        //     $allItems = $allItems->merge($data['groupFeedsSuggested']);
        // }
        
        $allItems = collect($allItems);
        $allItems->sortByDesc('created_at');
        $data['feeds'] = $allItems->sortByDesc('created_at');
        if(!isset($request->UpdatedData) && $request->UpdatedData != true){
            $data['paginateUrl'] = true;
            $data['feeds'] = $this->paginateWeb($data['feeds']);
        }else{
            $data['paginateUrl'] = false;
        }

        if (config('app.env') === 'local') {
            $data['environment'] = 'local';
        } else {
            $data['environment'] = 'production';
        }
        return view('dashboards.index', compact('data'));
    }

    public function addEvent(Request $request)
    {
        $data = [
            'user_id' => $request->userId,
            'event_name' => $request->eventName,
            'address' => $request->location,
            'description' => $request->description,
            'other_requirements' => $request->otherRequirements,
            // 'event_image' => $_FILES['eventImage']['name'],
            'event_start_time' => $request->startTime,
            'event_date' => $request->eventDate,
            'status' => 'Y',
        ];
        if(isset($request->schedule_id) && $request->schedule_id != '' && $request->schedule_id != null){
            $eventData = CalenderEvents::where('id', $request->schedule_id)->update($data);
            return response()->json(['check' => 'update','message' => 'updated successfully', 'data' => $data, 'eventData' => $eventData], 200);
        }else{
            $eventData = CalenderEvents::create($data);
            return response()->json(['check' => 'add','message' => 'added successfully', 'data' => $data, 'eventData' => $eventData], 200);
        }
        // return redirect()->route('calender');
    }
    public function deleteScheduleEvent($id){
        $eventData = CalenderEvents::find($id);
        $eventData->delete();
        return response()->json(['status' => true,'message' => 'deleted successfully'], 200);
    }

    public function registerWebinar(Request $request)
    {
        $checkEmail = WebinarRegistration::where(['email' => $request->email, 'webinar_id' => $request->userId])->first();
        if($checkEmail){
            return redirect()->back()->with('error', 'You have already register for webinar using this email');
        }

        $data = [
            'webinar_id' => $request->userId,
            'user_id' => $request->userId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'company' => $request->company,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zipcode,
            'speciality' => $request->speciality,
            'additional_comments' => $request->additional_comments,
            'veterinary_licence_number' => $request->licence_number,
            'role' => $request->role,
        ];
        $webinarRegisterData = WebinarRegistration::create($data);
        return redirect()->back()->with('success', 'Webinars Register form submit successfully.');
    }

    public function createGroups()
    {
        return view('group.group');
    }

    public function proimg(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        // $data['user'] = UserProfileImage::with('getUser:id,username,first_name,last_name,avatar_location,cover_image')->where(['user_id' => $id, 'status' => 'Y'])->get();
        $data['user'] = UserProfileImage::where(['user_id' => $id, 'status' => 'Y'])->get();
        return view('dashboards.proimg',compact('data'));
    }

    public function provideos(Request $request)
    {
        return view('dashboards.provideos');
    }

    public function profilevent(Request $request)
    {
        return view('dashboards.profilevent');
    }

    public function profilebadges(Request $request)
    {
        return view('dashboards.profilebadges');
    }

    public function profileforum(Request $request)
    {
        return view('dashboards.profileforum');
    }

    public function accountDetails(Request $request)
    {
        $user = auth()->user();
        return view('dashboards.accountdetails', compact('user'));
    }

    public function file(Request $request)
    {
        return view('dashboards.file');
    }



    public function todo(Request $request)
    {
        return view('dashboards.todo');
    }

    public function calender()
    {
        $date = date('y-m-d');
        $tomorrowDate = Carbon::createFromFormat('y-m-d', $date)->addDay()->format('y-m-d');
        $data['todaysSchedule'] = CalenderEvents::where(['user_id' =>  auth()->user()->id, 'event_date' => $date])->get();
        $data['tomorrowsSchedule'] = CalenderEvents::where(['user_id' =>  auth()->user()->id, 'event_date' => $tomorrowDate])->get();
        // echo "<pre>";
        // print_r($data);
        // die;
        return view('dashboards.calender', compact('data'));
    }

    public function birthday(Request $request)
    {
        $user = auth()->user();
        $dobs = $user->getBirthdays();
        $data['dobs'] = $dobs;
        return view('dashboards.birthday', compact('data'));
    }

    public function weather(Request $request)
    {
        return view('dashboards.weather');
    }

    public function music(Request $request)
    {
        return view('dashboards.music');
    }

    public function friendprofile(Request $request)
    {
        return view('dashboards.friendprofile');
    }

    /*layout*/
    public function withoutrightsidebar(Request $request)
    {
        return view('dashboards.withoutrightsidebar');
    }

    public function withoutleftsidebar(Request $request)
    {
        return view('dashboards.withoutleftsidebar');
    }

    /*blog pages*/
    public function bloggrid()
    {
        return view('blog.bloggrid');
    }
    public function bloglist()
    {
        $date = date('Y-m-d');
        $data['posts'] = BlogPost::where('status', 'Y')->where('publish_date', '<=', $date)->select('id','name','slug','short_content','image_thumbnail','publish_date','meta_title','meta_keywords','meta_description')->orderBy('publish_date', 'desc')->get();
        return view('blog.bloglist',compact('data'));
    }

    public function blogDetail(Request $request)
    {
        $date = date('Y-m-d');
        $data['post'] = BlogPost::where('status', 'Y')->where('publish_date', '<=', $date)->where('slug', $request->slug)->first();
        if ($data['post']) {
            $data['recent_posts'] = BlogPost::where('status', 'Y')->where([['publish_date', '<=', $date],['id', '!=', $data['post']->id]])->select('id','name','slug','short_content','image_thumbnail','publish_date')->orderBy('publish_date', 'desc')->paginate(5);
            return view('blog.blogdetail',compact('data'));
        } else {
            return response()->json(['page_error' => '404'], 404);
        }
    }

    public function newslist()
    {
        $data['news'] = NewsPost::where('status', 'Y')->select('id','name','slug','image_thumbnail','publish_date','top_image_banner','meta_title','meta_keywords','meta_description')->orderBy('publish_date', 'DESC')->get();

        return view('news.newslist',compact('data'));
    }

    public function newsDetail(Request $request)
    {
        /* Fetching Specific news details */
        $data['news'] = NewsPost::where([['slug', $request->slug],['status', 'Y']])->select('id','name','full_content','slug','top_image_banner','meta_title','meta_keywords','meta_description','publish_date')->first();
        /* Fetching Recent News in DESC order with limit 5 */
        $data['recentNews'] = NewsPost::where([['status', 'Y'],['id', '!=', $data['news']->id]])->select('id','name','slug','image_thumbnail','top_image_banner','publish_date')->orderBy('publish_date', 'DESC')->limit(5)->get();
        return view('news.newsdetail',compact('data'));
    }

    public function webinars(Request $request)
    {
        $data['webinars'] = Webinar::with('speaker:id,first_name,last_name,profile')->where([['show_in_app', 1],['webinar_type', 'website'],['end_date', '>=', date('y-m-d h:i:s')],['status', 'Y']
        ])->get();
        $data['states'] = State::all()->pluck('name','id');
        return view('dashboards.webinar',compact('data'));
    }

    public function myWebinars(Request $request)
    {
        $data['myWebinars'] = WebinarRegistration::with('webinar')->where(['email' => auth()->user()->email])->get();
        return view('dashboards.mywebinar',compact('data'));
    }

    public function webinarDetail(Request $request)
    {
        $data['webinar'] = Webinar::with('speaker:id,first_name,last_name,profile,slug')->where([['slug', $request->slug]])->first();
        return view('webinar.webinardetail',compact('data'));
    }

    public function speakers(Request $request)
    {
        $data['speakers'] = Speaker::with('webinarSpeakers')->where('status', 'Y')->select('id','slug','first_name','last_name', 'credentials', 'institute', 'job_title', 'profile','meta_title','meta_keywords','meta_description','sm_facebook','sm_linkedin','sm_twitter','sm_instagram','sm_pinterest','sm_youtube','sm_vimeo')->get();
        return view('dashboards.speaker',compact('data'));
    }

    public function speakerDetail(Request $request)
    {
        $data['speaker'] = Speaker::with('webinarSpeakers')->where('slug', $request->slug)->get();
        return view('speaker.speakerdetail',compact('data'));
    }

    public function signature()
    {
        return view('dashboards.signature');
    }

    public function createSignature(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // die;
        $updateSignatureStatus = User::where('id', $request->id)->update(['signature' => 'yes']);
        if($updateSignatureStatus == 1){
            $status = true;
        }else{
            $status = false;
        }
        return response()->json(['message' => 'Signature Created!', 'status' => $status], 200);
    }

    /*market paages*/
    public function market1()
    {
        return view('market.market1');
    }

    public function market2()
    {
        return view('market.market2');
    }

     /*profile paages*/
    public function profile1()
    {
        return view('profile.profile1');
    }
    public function profile2()
    {
        return view('profile.profile2');
    }
    public function profile3()
    {
        return view('profile.profile3');
    }

/*stock*/

    public function stock(Request $request)
    {
        return view('stock.list');
    }

/*appointment*/

    public function appointment(Request $request)
    {
        return view('appointment.doctors');
    }

/*store pages*/
    public function grid(Request $request)
    {
        return view('store.grid');
    }
    public function list(Request $request)
    {
        return view('store.list');
    }
    public function detail(Request $request)
    {
        return view('store.detail');
    }
    public function checkout(Request $request)
    {
        return view('store.checkout');
    }

/*email pages*/
    public function email(Request $request)
    {
        return view('mailbox.email');
    }
    public function emailcompose(Request $request)
    {
        return view('mailbox.emailcompose');
    }
/*form pages*/
    public function formcheckbox(Request $request)
    {
        return view('ui.formcheckbox');
    }
    public function formlayout(Request $request)
    {
        return view('ui.formlayout');
    }
    public function formradio(Request $request)
    {
        return view('ui.formradio');
    }
    public function formswitch(Request $request)
    {
        return view('ui.formswitch');
    }
    public function formvalidation(Request $request)
    {
        return view('ui.formvalidation');
    }
    /*table pages*/
    public function tablebasic(Request $request)
    {
        return view('ui.tablebasic');
    }
    public function datatable(Request $request)
    {
        $users =User::all();
        return view('ui.datatable', compact('users'));
    }
    public function tableedit(Request $request)
    {
        return view('ui.tableedit');
    }

    /*form pagees*/
    public function formwizard(Request $request)
    {
        return view('ui.formwizard');
    }
    public function formwizardvalidate(Request $request)
    {
        return view('ui.formwizardvalidate');
    }
    public function formwizardvertical(Request $request)
    {
        return view('ui.formwizardvertical');
    }
    /*icon pages*/
    public function iconfontawsome(Request $request)
    {
        return view('ui.iconfontawsome');
    }
    public function iconlineawsome(Request $request)
    {
        return view('ui.iconlineawsome');
    }
    public function iconremixon(Request $request)
    {
        return view('ui.iconremixon');
    }
    public function iconmaterial(Request $request)
    {
        return view('ui.iconmaterial');
    }

    /*pages*/
    public function signin(Request $request)
    {
        return view('pages.signin');
    }
    public function signup(Request $request)
    {
        return view('pages.signup');
    }
    public function pagerecover(Request $request)
    {
        return view('pages.pagerecover');
    }
    public function pageconfirmail(Request $request)
    {
        return view('pages.pageconfirmail');
    }
    public function lockscreen(Request $request)
    {
        return view('pages.lockscreen');
    }
    /*extrapage*/
    public function timeline(Request $request)
    {
        return view('pages.timeline');
    }
    public function invoice(Request $request)
    {
        return view('pages.invoice');
    }
    public function blankpage(Request $request)
    {
        return view('pages.blankpage');
    }
    public function adminpage(Request $request)
    {
        return view('pages.admin');
    }
    public function error(Request $request)
    {
        return view('pages.error');
    }
    public function error500(Request $request)
    {
        return view('pages.error500');
    }
    public function pricing(Request $request)
    {
        return view('pages.pricing');
    }
    public function pricingone(Request $request)
    {
        return view('pages.pricingone');
    }
    public function maintenance(Request $request)
    {
        return view('pages.maintenance');
    }
    public function comingsoon(Request $request)
    {
        return view('pages.comingsoon');
    }
    public function faq(Request $request)
    {
        return view('pages.faq');
    }

    public function uigrid()
    {
        return view('ui.uigrid');
    }

    public function uitabs()
    {
        return view('ui.uitabs');
    }

    public function uicard()
    {
        return view('ui.uicard');
    }

    public function uimodal()
    {
        return view('ui.uimodal');
    }

    public function uialert()
    {
        return view('ui.uialert');
    }

    public function uibadges()
    {
        return view('ui.uibadges');
    }

    public function uiimages()
    {
        return view('ui.uiimages');
    }



    public function uibutton()
    {
        return view('ui.uibutton');
    }

    public function uicarousel()
    {
        return view('ui.uicarousel');
    }

    public function uipopovers()
    {
        return view('ui.uipopovers');
    }

    public function uitooltips()
    {
        return view('ui.uitooltips');
    }
    public function uicolor()
    {
        return view('ui.uicolor');
    }




    public function uibreadcrumb()
    {
        return view('ui.uibreadcrumb');
    }

    public function uilistitems()
    {
        return view('ui.uilistitems');
    }

    public function uipagination()
    {
        return view('ui.uipagination');
    }

    public function uitypography()
    {
        return view('ui.uitypography');
    }

    public function uimedia()
    {
        return view('ui.uimedia');
    }

    public function uiprogressbars()
    {
        return view('ui.uiprogressbars');
    }

    public function uinotification()
    {
        return view('ui.uinotification');
    }

    public function uiemvideo()
    {
        return view('ui.uiemvideo');
    }

    /*CRUD*/


    public function create()
    {
        return view('user.add');
    }

    public function update(UserRequest $request, $id)
    {
        // dd($request->all());
        $user = User::with('userProfile')->findOrFail($id);
        // $role = Role::find($request->user_role);
        // if(env('IS_DEMO')) {
        //     if($role->name === 'admin') {
        //         return redirect()->back()->with('errors', 'Permission denied.');
        //     }
        // }
        // $user->assignRole($role->name);

        $request['password'] = $request->password != '' ? bcrypt($request->password) : $user->password;

        // User user data...
        $user->fill($request->all())->update();

        // Save user image...
        if (isset($request->profile_image) && $request->profile_image != null) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        // user profile data....
        $user->userProfile->fill($request->userProfile)->update();

        if(auth()->check()){
            return redirect()->route('dashboards.index')->withSuccess(__('message.msg_updated',['name' => __('message.user')]));
        }
        return redirect()->back()->withSuccess(__('message.msg_updated',['name' => 'My Profile']));

    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // $status = 'errors';
        //$message= __('global-message.delete_form', ['form' => __('users.title')]);

        if($user!='') {
            $user->delete();
            $status = 'success';
            //$message= __('global-message.delete_form', ['form' => __('users.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true,  'datatable_reload' => 'dataTable_wrapper']);
        }
        return redirect()->back()->with($status);
    }

       /*footer pages */
    public function privacypolicy()
    {
        return view('footer.privacypolicy');
    }
    public function privacypolicylogout()
    {
        return view('logout.privacypolicy');
    }

    public function termsofservice()
    {
        return view('footer.termsofservice');
    }
    public function termsofservicelogout()
    {
        return view('logout.termsofservice');
    }

    public function aboutus()
    {
        return view('footer.aboutus');
    }

    public function ourvision()
    {
        return view('footer.ourvision');
    }
    public function aboutuslogout()
    {
        return view('logout.aboutus');
    }
    public function customerSupport()
    {
        return view('footer.customersupport');
    }
    public function customerSupportlogout()
    {
        return view('logout.customersupport');
    }
    public function contactSupport(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'message' => $request->message,
        ];

        $contactData = Contact::create($data);

        try {
            Mail::send(new SendContact($request));
        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage(),], 200);
        }
        return redirect()->back()->with('message',"Message Sent Successfully.");
    }
}
