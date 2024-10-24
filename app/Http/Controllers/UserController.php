<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Models\UserProfileDetails;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\BlockedUser;
use App\Models\Group;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\Notifications;
use App\Models\UserFollow;


// use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Hash;

class UserController extends Controller
{
    
    public function index(UsersDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('users.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="'.route('users.create').'" class="btn btn-sm btn-primary" role="button">Add User</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    public function create()
    {
        $roles = Role::where('status',1)->get()->pluck('title', 'id');

        return view('users.form', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $request['password'] = bcrypt($request->password);
        $request['username'] = $request->username ?? stristr($request->email, "@", true) . rand(100,1000);
        $user = User::create($request->all());
        storeMediaFile($user,$request->profile_image, 'profile_image');
        $user->assignRole('user');
        // Save user Profile data...
        $user->userProfile()->create($request->userProfile);
        return redirect()->route('users.index')->withSuccess(trans('users.store'));
    }

    public function show($id)
    {
        $data = User::with('userProfile','roles')->findOrFail($id);
        $profileImage = getSingleMedia($data, 'profile_image');
        return view('users.profile', compact('data', 'profileImage'));
    }

    public function edit($id)
    {
        $data = User::with('userProfile','roles')->findOrFail($id);

        $data['user_type'] = $data->roles->pluck('id')[0] ?? null;

        $roles = Role::where('status',1)->get()->pluck('title', 'id');

        $profileImage = getSingleMedia($data, 'profile_image');

        return view('users.form', compact('data','id', 'roles', 'profileImage'));
    }

    public function verifiedUser()
    {
        return view('auth.verified');

    }

    public function searchResult(Request $request){

        $user = User::where([ 'allow_on_vt_friend' => 1])->select('id', 'name', 'first_name', 'last_name','username', 'email', 'address', 'phone', 'gender', 'dob', 'country_id', 'avatar_location', 'type');
        $group = Group::where('status','Y')->select('id','group_name','short_description','profile_image','cover_image');
        $page = Page::where('status','Y')->select('id','page_name','bio','profile_image','cover_image');
        $blockedFriends = BlockedUser::Where('user_id', auth()->user()->id)->pluck( 'blocked_user_id')->toArray();
        $blockedOtherFriends = BlockedUser::Where('blocked_user_id', auth()->user()->id)->pluck( 'user_id')->toArray();

        if (isset($request->search_input)) {
            $keywords = $request->search_input;
            $singular = Str::singular($keywords);
            $plural = Str::plural($keywords);
            $search = [];
            array_push($search, $keywords);
            if ($singular != $keywords)
                array_push($search, $singular);
            if ($plural != $keywords)
                array_push($search, $plural);

            $user->where(function ($user) use ($search) {
                foreach ($search as $keyword) {
                    $user->orWhere('first_name', 'like', '%' . $keyword . '%');
                    $user->orWhere('last_name', 'like', '%' . $keyword . '%');
                    $user->orWhere('name', 'like', '%' . $keyword . '%');
                    $user->orWhere('email', 'like', '%' . $keyword . '%');
                    $user->orWhere('username', 'like', '%' . $keyword . '%');
                }
            });
            $group->where(function ($group) use ($search) {
                foreach ($search as $keyword) {
                    $group->orWhere('group_name', 'like', $keyword . '%')->orWhere('group_name', 'like', '%'.$keyword . '%');
                    $group->orWhere('short_description', 'like', $keyword . '%')->orWhere('short_description', 'like', '%'. $keyword . '%');
                }
            });
            $page->where(function ($page) use ($search) {
                foreach ($search as $keyword) {
                    $page->orWhere('page_name', 'like', $keyword . '%')->orWhere('page_name', 'like', '%'.$keyword . '%');
                    $page->orWhere('bio', 'like', $keyword . '%')->orWhere('bio', 'like', '%'. $keyword . '%');
                }
            });
            $data['users'] = $user->where('username','!=', null)->where('username','!=', '')->whereNotIn('id', array_merge($blockedFriends, $blockedOtherFriends))->get();
            $data['groups'] = $group->get();
            $data['pages'] = $page->get();
        }else{
            $data['users'] = User::where(['allow_on_vt_friend' => 1])->select('id', 'name', 'first_name','username', 'last_name', 'email', 'address', 'phone', 'gender', 'dob', 'country_id', 'avatar_location', 'type')->where('username','!=', null)->where('username','!=', '')->whereNotIn('id', array_merge($blockedFriends, $blockedOtherFriends))->get();
            $data['groups'] = Group::where('status','Y')->select('id','group_name','short_description','profile_image')->get();
            $data['pages'] = Page::where('status','Y')->select('id','page_name','bio','profile_image')->get();
        }
        
        return view('dashboards.search',compact('data'));
    }

    public function update(UserRequest $request, $id)
    {

        if($request->type == 'personalInformation'){
            if(isset($request->profile_user_id)){
            $id  = $request->profile_user_id;
            }else{
            $users = auth()->user();
            $id  = $users->id;
            }

            $userdata = UserProfileDetails::where('user_id',  $id)->first();
            $role = Role::find($request->user_role);
            if(env('IS_DEMO')) {
                if($role->name === 'admin') {
                    return redirect()->back()->with('errors', 'Permission denied.');
                }
            }
            $userdata->city = $request->get('city');
            $userdata->marital_status = $request->get('marital_status');
            // $userdata->age = $request->get('age');
            $userdata->country = $request->get('country_id');
            $userdata->state = $request->get('state');
            $userdata->save();

            $validator = Validator::make($request->all(), [
                'dob' => 'required|date_format:m/d/Y|before:-18 years',
                // 'dob_month' => 'required|numeric|between:1,12',
                // 'dob_year' => 'required|date_format:Y',
            ]);
            // $validator->after(function ($validator) use ($request) {
            //     $date = $request->dob_year.'-'.$request->dob_month.'-'.$request->dob_day;
            //     if (!checkdate($request->dob_month, $request->dob_day, $request->dob_year)) {
            //         $validator->errors()->add('dob_day', 'Invalid date of birth');
            //     }
            // });
            if ($validator->fails()) {
                return response()->json(['error' => true, 'errortype' => 'dob', 'message'=> 'Please enter valid date of birth.!', 'type' => 'personalInformation']);
                //return redirect()->back()->with(Input::all());
            }
            if(isset($request->dob)){
                $date = \Carbon\Carbon::createFromFormat('m/d/Y', $request->dob)->format('Y/m/d');
            }
            $user_d = User::where('id', $id)->first();
            $user_d->first_name = $request->get('first_name');
            $user_d->last_name =  $request->get('last_name');
            $user_d->pet_parent =  $request->get('pet_parent');
            $user_d->name = $user_d->first_name  . ' ' . $user_d->last_name;

            // username work start for User table
            $user_d->username = $request->input('username');
            // $existingUsername = User::where('username', $user_d->username)->where('username', '!==', $user_d->username)->first();
            $existingUsername = User::where('username', $user_d->username)->where('id', '!=', $user_d->id)->first();
            if ($existingUsername) {
                return response()->json(['error' => true, 'errortype' => 'username', 'message'=> 'The username has already been taken.!', 'type' => 'personalInformation']);
            }
            // username work end for User table
            $user_d->gender = $request->get('gender');
            $user_d->dob = $date;
            $user_d->address = $request->get('address');
            $user_d->zip_code = $request->get('zip_code')  ?? null;
            $user_d->role_id = $request->get('role_id') ?? 0 ;
            $user_d->email_event_reminder = $request->get('email_event_reminder') ?? 0 ;
            $user_d->email_general_info = $request->get('email_general_info') ?? 0 ;
            $user_d->email_marketing_events_courses = $request->get('email_marketing_events_courses') ?? 0 ;
            $user_d->save();
            return response()->json(['success' => true, 'message' => 'Personal Information updated successfully!', 'userdata' => $user_d, 'type' => 'personalInformation'], 200);
        }

        if($request->type == 'accountSetting'){
            $users = auth()->user();
            $id  = $users->id;
            $userdata = UserProfileDetails::where('user_id',  $id)->first();
            $role = Role::find($request->user_role);
            if(env('IS_DEMO')) {
                if($role->name === 'admin') {
                    return redirect()->back()->with('errors', 'Permission denied.');
                }
            }
            $checkAlternateEmail = User::where('email',  $request->altemail)->first();
            if(auth()->user()->email == $request->altemail){
                return response()->json(['error' => true,'message'=> "The email address you've entered is already set to your Primary email address.", 'type' => 'accountSetting']);
            }else{
                // $userdata->username = $request->get('username');
            $userdata->altemail = $request->get('altemail');
            $userdata->language_eng = $request->input('language_eng', 0);
            $userdata->language_french = $request->input('language_french', 0);
            $userdata->language_chinese = $request->input('language_chinese', 0);
            $userdata->language_spanish = $request->input('language_spanish', 0);
            $userdata->language_arabic = $request->input('language_arabic', 0);
            $userdata->language_italian = $request->input('language_italian', 0);
            $userdata->save();
            return response()->json(['success' => true, 'message' => 'Account settings updated successfully!', 'userdata' => $userdata, 'type' => 'accountSetting'], 200);
            // return redirect()->back()->withSuccess(trans('users.update_account_settings'));
            }
        }
        if($request->type == 'socialLink'){
            $users = auth()->user();
            $id  = $users->id;
            $userdata = UserProfileDetails::where('user_id',  $id)->first();
            $role = Role::find($request->user_role);
            if(env('IS_DEMO')) {
                if($role->name === 'admin') {
                    return redirect()->back()->with('errors', 'Permission denied.');
                }
            }
            $userdata->facebook_link = $request->get('facebook_link');
            $userdata->twitter_link = $request->get('twitter_link');
            $userdata->google_link = $request->get('google_link');
            $userdata->instagram_link = $request->get('instagram_link');
            $userdata->youtube_link = $request->get('youtube_link');
            $userdata->save();
            return response()->json(['success' => true, 'message' => 'Social link updated successfully!', 'userdata' => $userdata, 'type' => 'socialLink'], 200);
        }
        if($request->type == 'manageContact'){

            if(isset($request->profile_user_id)){
            $id  = $request->profile_user_id;
            }else{
            $users = auth()->user();
            $id  = $users->id;
            }

            $user_d = User::where('id', $id)->first();
            $user_d->phone = $request->get('phone');
            $user_d->website = $request->get('website');
            $user_d->save();
            return response()->json(['success' => true, 'message' => 'Contact information updated successfully!', 'userdata' => $user_d, 'type' => 'manageContact'], 200);
        }
        if($request->type == 'privacySetting'){
            $users = auth()->user();
            $id  = $users->id;
            $userdata = UserProfileDetails::where('user_id',  $id)->first();
            $role = Role::find($request->user_role);
            if(env('IS_DEMO')) {
                if($role->name === 'admin') {
                    return redirect()->back()->with('errors', 'Permission denied.');
                }
            }
            $userdata->account_privacy = $request->input('account_privacy', 0);
            $userdata->activity_status = $request->input('activity_status', 0);
            $userdata->story_sharing = $request->input('story_sharing', 0);
            $userdata->photo_of_you = $request->get('photo_of_you');
            $userdata->your_profile = $request->get('your_profile');
            $userdata->your_message = $request->get('your_message');
            $userdata->login_notification = $request->get('login_notification');
            $userdata->save();
            return response()->json(['success' => true, 'message' => 'Privacy Settings updated successfully!', 'userdata' => $userdata, 'type' => 'privacySetting'], 200);
        }
        if($request->type == 'changePassword'){
            // $request->validate([
            //     'old_password' => 'required',
            //     'new_password' => 'required|min:8',
            // ]);

            // $user = Auth::user();

            // if (Hash::check($request->old_password, $user->password)) {
            //     $user->password = Hash::make($request->new_password);
            //     $user->save();

            //     return redirect('/')->with('success', 'Password changed successfully.');
            // } else {
            //     return back()->withErrors(['old_password' => 'The old password you entered is incorrect.'])->withInput();
            // }
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user = Auth::user();
            $hashedPassword = $user->password;

            if (Hash::check($request->current_password, $hashedPassword)) {
                $user->fill([
                    'password' => Hash::make($request->new_password)
                ])->save();

                Auth::guard('web')->login($user);

                return response()->json(['success' => true, 'message' => 'Password changed successfully.', 'userdata' => $user, 'type' => 'changePassword'], 200);
            }

            return redirect()->back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('users.title')]);

        if(isset($user->id)) {
            $user->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('users.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }

    public function getUserData()
    {
        $id = 1;
        $data['user'] = User::where('id', $id)->first(array('id','first_name','last_name','email','phone','address','gender','dob','country_id','allow_on_dvm','allow_on_vt_friend','allow_on_vetandtech'));
        return response()->json($data, 200);
    }

    public function searchUsers(Request $request)
    {
        $filter = (array) array_merge(['keywords' => @$request->search_input], $request->except('search_input'));
        $searchData = $this->getUsers($filter);
        return response()->json(['searchData' => $searchData ], 200);
    }

    public function getUsers(array $filter = [])
    {
        $user = User::where([ 'allow_on_vt_friend' => 1])->select('id', 'name', 'first_name', 'last_name','username', 'email', 'address', 'phone', 'gender', 'dob', 'country_id', 'avatar_location', 'type');
        $group = Group::where('status','Y')->select('id','group_name','short_description','profile_image','cover_image');
        $page = Page::where('status','Y')->select('id','page_name','bio','profile_image','cover_image');
        $blockedFriends = BlockedUser::Where('user_id', auth()->user()->id)->pluck( 'blocked_user_id')->toArray();
        $blockedOtherFriends = BlockedUser::Where('blocked_user_id', auth()->user()->id)->pluck( 'user_id')->toArray();

        if (isset($filter['keywords'])) {
            $keywords = $filter['keywords'];
            $singular = Str::singular($keywords);
            $plural = Str::plural($keywords);
            $search = [];
            array_push($search, $keywords);
            if ($singular != $keywords)
                array_push($search, $singular);
            if ($plural != $keywords)
                array_push($search, $plural);

            $user->where(function ($user) use ($search) {
                foreach ($search as $keyword) {
                    $user->orWhere('first_name', 'like', '%' . $keyword . '%');
                    $user->orWhere('last_name', 'like', '%' . $keyword . '%');
                    $user->orWhere('name', 'like', '%' . $keyword . '%');
                    $user->orWhere('email', 'like', '%' . $keyword . '%');
                    $user->orWhere('username', 'like', '%' . $keyword . '%');
                }
            });
            $group->where(function ($group) use ($search) {
                foreach ($search as $keyword) {
                    $group->orWhere('group_name', 'like', $keyword . '%')->orWhere('group_name', 'like', '%'.$keyword . '%');
                    $group->orWhere('short_description', 'like', $keyword . '%')->orWhere('short_description', 'like', '%'. $keyword . '%');
                }
            });
            $page->where(function ($page) use ($search) {
                foreach ($search as $keyword) {
                    $page->orWhere('page_name', 'like', $keyword . '%')->orWhere('page_name', 'like', '%'.$keyword . '%');
                    $page->orWhere('bio', 'like', $keyword . '%')->orWhere('bio', 'like', '%'. $keyword . '%');
                }
            });
            $data['users'] = $user->where('username','!=', null)->where('username','!=', '')->whereNotIn('id', array_merge($blockedFriends, $blockedOtherFriends))->get();
            $data['groups'] = $group->get();
            $data['pages'] = $page->get();
        }else{
            $data['users'] = User::where(['allow_on_vt_friend' => 1])->select('id', 'name', 'first_name','username', 'last_name', 'email', 'address', 'phone', 'gender', 'dob', 'country_id', 'avatar_location', 'type')->where('username','!=', null)->where('username','!=', '')->whereNotIn('id', array_merge($blockedFriends, $blockedOtherFriends))->get();
            $data['groups'] = Group::where('status','Y')->select('id','group_name','short_description','profile_image')->get();
            $data['pages'] = Page::where('status','Y')->select('id','page_name','bio','profile_image')->get();
        }

        return $data;
    }

    public function allowUser($email){
        $user = User::where('email',$email)->first();
        $user->allow_on_vt_friend = 1;
        $user->save();
        if($user->email_verified_at == null){
            (new User())->verificationEmail($user);
            return response()->json(['message' => 'Registered on Devsinc successfully. Please check your email and verify before sign in.'], 200);
        }
        return response()->json(['message' => 'Registered on Devsinc successfully. Please enter your credentials to sign in'], 200);
    }

    public function delete(Request $request){
        $user = User::find($request->userId);
        $user->soft_delete = 1;
        $user->deleted_at = now();
        $user->save();

        //logout user after account inactivate
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->withErrors(['msg' => 'Account deleted successfully. You can recover your account within 60 days.']);
    }

    public function privacy(Request $request){
        $userProfileData = UserProfileDetails::where('user_id', auth()->user()->id)->first();
        if($userProfileData){
            $userProfileData->your_profile = $request->your_profile ? $request->your_profile: 'public';
            $userProfileData->story_sharing = $request->story_sharing;
            $userProfileData->your_message = $request->your_message ? $request->your_message: 'anyone';
            $userProfileData->account_privacy = $request->account_privacy ? $request->account_privacy: 0;
            $userProfileData->content_notification = $request->login_notification;
            
            $userProfileData->save();
                return response()->json(['success' => true, 'type' => 'privacySetting', 'message' => 'Privacy Settings updated successfully!', 'userdata' => $userProfileData], 200);
        }
    }

    public function deleteRequest(Request $request)
    {
        FriendRequest::where('id', $request->id)->update(['status' => 'rejected']);
        $userRequestSent = FriendRequest::where('id', $request->id)->first();
        $checkNotifications = Notifications::where(['user_id' => auth()->user()->id, 'friend_id' => $userRequestSent->user_id,'notification_type' => 'friend_request'])->get();
        if($checkNotifications){
            $checkNotifications->each->delete();
        }
        $data['friendsRequestList'] = FriendRequest::with('getRequestSender')->where(['friend_id' => auth()->user()->id])->where('status' , 'pending')->get();
        $requestCount = count($data['friendsRequestList']);
        return response()->json(['message' => 'Friend Request Rejected Successfully', 'requestCount' => $requestCount, 'type' => $request->type], 200);
        // return ['status' => 0, 'message' => 'Friend Request Rejected Successfully'];
    }

    public function acceptRequest(Request $request)
    {
        $friendReq = FriendRequest::where('friend_id', auth()->user()->id)->where('user_id', $request->id)->first();
        if(isset($friendReq) && $friendReq->status == 'pending'){
            $friendReq->status = 'accepted';
            $friendReq->save();
            $friend = new Friend;
            $friend->user_id = $request->id;
            $friend->friend_id = auth()->user()->id;
            $friend->save();
        }
        $data['friendsRequestList'] = FriendRequest::with('getRequestSender')->where(['friend_id' => auth()->user()->id])->where('status' , 'pending')->get();
        $requestCount = count($data['friendsRequestList']);

        $notificationMessage = ' accepted your friend request.';
        $requestSendNotify = Notifications::sendNotification($request->id,auth()->user()->id, 'profile/'.auth()->user()->id, 'User Accept Friend Request', 'accept_friend_request', $notificationMessage);

        return response()->json(['message' => 'Friend Request Accepted Successfully', 'requestCount' => $requestCount, 'type' => $request->type ], 200);
    }

    public function unFriend(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        $friend = Friend::whereIn('user_id', [$user->id, auth()->user()->id])->whereIn('friend_id', [$user->id, auth()->user()->id])->first();

        if ($friend) {
            $unfriend =  $friend->delete();
            $statusupdate = FriendRequest::whereIn('user_id', [auth()->user()->id, $user->id])->whereIn('friend_id', [auth()->user()->id, $user->id])->update(['status' => 'unfriend']);

            return response()->json(['message' => 'unfriend successfully.'], 200);
        } else {
            return response()->json(['message' => 'Error'], 404);
        }
    }

    public function addToFriend(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        
        $FriendRequestMultiple = FriendRequest::whereIn('user_id', [$user->id, auth()->user()->id])->whereIn('friend_id', [$user->id, auth()->user()->id])->get();
        if($FriendRequestMultiple->count() > 1){
            foreach($FriendRequestMultiple as $key => $FriendRequestSingle){
                if($key != 0 ){
                    $FriendRequestSingle->delete();
                }
            }
        }

        $checkFriendRequest = FriendRequest::where('friend_id', $user->id)->where('user_id', auth()->user()->id)->first();
        $checkFriendRequestHave = FriendRequest::where('friend_id', auth()->user()->id)->where('user_id', $user->id)->first();
        if($checkFriendRequest || $checkFriendRequestHave){
            if(isset($checkFriendRequestHave->friend_id) == auth()->user()->id){
                $checkFriendRequestHave->friend_id = $user->id;
                $checkFriendRequestHave->user_id = auth()->user()->id;
                $checkFriendRequestHave->status = 'pending';
                $checkFriendRequestHave->uncheck_request = '0';
                $checkFriendRequestHave->save();

                $checkFollow = UserFollow::where(['following_user_id' => $user->id ,'user_id' => auth()->user()->id])->first();
                if(empty($checkFollow))
                {
                    $addToFollow = new UserFollow;
                    $addToFollow->user_id = auth()->user()->id;
                    $addToFollow->following_user_id = $user->id;
                    $addToFollow->save();

                    $notificationMessage = ' followed you.';
                    $requestSendNotify = Notifications::sendNotification( $user->id, auth()->user()->id, 'profile/'.auth()->user()->id, 'User Followed', 'user_followed', $notificationMessage );
                }
                $addToFriend = $checkFriendRequestHave->refresh();
            }else{
                $checkFriendRequest->status = 'pending';
                $checkFriendRequest->uncheck_request = '0';
                $checkFriendRequest->save();

                $checkFollow = UserFollow::where(['following_user_id' => $user->id ,'user_id' => auth()->user()->id])->first();
                if(empty($checkFollow))
                {
                    $addToFollow = new UserFollow;
                    $addToFollow->user_id = auth()->user()->id;
                    $addToFollow->following_user_id = $user->id;
                    $addToFollow->save();

                    $notificationMessage = ' followed you.';
                    $requestSendNotify = Notifications::sendNotification( $user->id, auth()->user()->id, 'profile/'.auth()->user()->id, 'User Followed', 'user_followed', $notificationMessage );
                }
                $addToFriend = $checkFriendRequest->refresh();
            }
            if(auth()->user()->id !== $user->user_id){
                $notificationMessage = ' sent you friend request.';
                $requestSendNotify = Notifications::sendNotification( $user->id, auth()->user()->id, 'profile/'.auth()->user()->id, 'User Friend Request', 'friend_request', $notificationMessage );
            }
            return response()->json(['response' => $addToFriend], 200);
        }
        else {
            $addToFriend = new FriendRequest;
            $addToFriend->user_id = auth()->user()->id;
            $addToFriend->friend_id = $user->id;
            $addToFriend->save();

            $checkFollow = UserFollow::where(['following_user_id' => $user->id ,'user_id' => auth()->user()->id])->first();
            if(empty($checkFollow))
            {
                $addToFollow = new UserFollow;
                $addToFollow->user_id = auth()->user()->id;
                $addToFollow->following_user_id = $user->id;
                $addToFollow->save();

                $notificationMessage = ' followed you.';
                $requestSendNotify = Notifications::sendNotification( $user->id, auth()->user()->id, 'profile/'.auth()->user()->id, 'User Followed', 'user_followed', $notificationMessage );
            }

            $notificationMessage = ' sent you friend request.';
            $requestSendNotify = Notifications::sendNotification( $user->id, auth()->user()->id, 'profile/'.auth()->user()->id, 'User Friend Request', 'friend_request', $notificationMessage );
            $addToFriend->refresh();

            // return redirect()->route('user-profile',  ['username' => $user->username]);
            return response()->json(['response' => $addToFriend], 200);
        }
    }

    public function cancelRequest(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        $cancelRequest = FriendRequest::where('user_id', auth()->user()->id)
            ->where('friend_id', $user->id)
            ->first();
        $checkNotifications = Notifications::where(['user_id' => $user->id, 'friend_id' =>  auth()->user()->id,'notification_type' => 'friend_request'])->get();
        if ($cancelRequest) {
            $cancelRequest->delete();
            if($checkNotifications){
                $checkNotifications->each->delete();
            }
            // $cancelFriendRequest = Notifications::CancelrequestNotification($user);
            return response()->json(['message' => 'cancelRequest successfully.'], 200);
        } else {
            return response()->json(['message' => 'Error'], 404);
        }
    }

    public function deleteFriendRequest(Request $request,  $reqId)
    {
        FriendRequest::where('id', $reqId)->update(['status' => 'disapproved']);
        return ['status' => 0, 'message' => 'Friend Request Disapproved Successfully'];
    }

    public function unFriendUser(Request $request)
    {
        Friend::where(['user_id' => $request->userId, 'friend_id' => $request->friendId])->delete();
        return redirect()->route('profile');
    }

    public function followUser(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        $userFollow = new UserFollow;
        $userFollow->user_id = auth()->user()->id;
        $userFollow->following_user_id = $user->id;
        $userFollow->save();

        $notificationMessage = ' followed you.';
        Notifications::sendNotification($user->id,auth()->user()->id, 'profile/'.auth()->user()->id, 'User Followed', 'user_followed', $notificationMessage);

        $userFollow->refresh();

        return response()->json(['response' => $userFollow], 200);
    }

    public function unfollowUser(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        $unfollowUser = UserFollow::where('user_id', auth()->user()->id)
            ->where('following_user_id', $user->id)
            ->first();

        $checkUserNotifications = Notifications::where(['user_id' =>  auth()->user()->id, 'friend_id' => $user->id, 'notification_type' => 'user_followed'])->first();
        $checkFriendNotifications = Notifications::where(['user_id' =>  $user->id, 'friend_id' => auth()->user()->id, 'notification_type' => 'user_followed'])->first();

        if ($unfollowUser) {
            $unfollowUser->delete();
            if($checkUserNotifications){
                $checkUserNotifications->delete();

            }
            if($checkFriendNotifications){
                $checkFriendNotifications->delete();
            }
            return response()->json(['message' => 'Unfollowed user successfully.'], 200);
        } else {
            return response()->json(['message' => 'User is not being followed.'], 404);
        }
    }

    public function blockFriend(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if($user->id !== auth()->user()->id){
            $checkUnblockFriend = BlockedUser::where('user_id', auth()->user()->id)->where('blocked_user_id', $user->id)->first();
            if($checkUnblockFriend === null){
                $blockFriend = new BlockedUser;
                $blockFriend->user_id = auth()->user()->id;
                $blockFriend->blocked_user_id = $user->id;
                $friend = Friend::whereIn('user_id', [auth()->user()->id, $user->id])->whereIn('friend_id', [auth()->user()->id, $user->id])->first();
                if ($friend) {
                    $unfriend =  $friend->delete();
                    $statusupdate = FriendRequest::where(['user_id' => auth()->user()->id, 'friend_id' => $user->id])->orWhere(['user_id' => $user->id, 'friend_id' => auth()->user()->id])->update(['status' => 'unfriend']);
                }else{
                    $statusupdate = FriendRequest::where(['user_id' => auth()->user()->id, 'friend_id' => $user->id])->orWhere(['user_id' => $user->id, 'friend_id' => auth()->user()->id])->update(['status' => 'unfriend']);
                }
                $unfollowUser = UserFollow::where('user_id', auth()->user()->id)->where('following_user_id', $user->id)->orWhere(['user_id' => $user->id, 'following_user_id' => auth()->user()->id])->get();

                if ($unfollowUser) {
                    $unfollowUser->each->delete();
                    $blockFriend->save();
                    $blockFriend->refresh();
                    return response()->json(['response' => $blockFriend, 'friend' => $friend, 'blockUser' => $user], 200);
                }else {
                    $blockFriend->save();
                    $blockFriend->refresh();
                    return response()->json(['response' => $blockFriend], 200);
                }
                return response()->json(['response' => $blockFriend, 'friend' => $friend], 404);
            }
            return redirect()->back()->with('success', 'Already User blocked');
        }
        return redirect()->back()->with(['Error', 'User is auth', 'user' => $user], 404);
    }

    public function unblockFriend(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        $unblockFriend = BlockedUser::where('user_id', auth()->user()->id)->where('blocked_user_id', $user->id)->first();
        if ($unblockFriend) {
            $unblockFriend->delete();
            return response()->json(['message' => 'Unblock user successfully.'], 200);
        } else {
            return response()->json(['message' => 'User is not being block.'], 404);
        }
    }

    public function friendlist(Request $request)
    {
        $userData = User::find(auth()->user()->id);
        $data['friendsList'] = $userData->getAllFriends(['user_id' => auth()->user()->id]);

        foreach($data['friendsList'] as $friend){
            $data['is_following'] = (bool) UserFollow::where(['user_id' => auth()->user()->id, 'following_user_id'=>$friend->id])->first();
            $data['is_blocking'] = (bool) BlockedUser::where(['user_id' => $userData->id, 'blocked_user_id' => $friend->id])->first();
            $data['allFollowing'] = UserFollow::with('getUserDetailsFollowing:id,first_name,last_name,avatar_location,cover_image,username')->where(['user_id' => $userData->id])->get();
            $data['following_user'] = count($data['allFollowing']);

            $data['UserFollow'] = UserFollow::where(['user_id' => auth()->user()->id, 'following_user_id'=>$friend->id])->first();
            $data['other_friends'] = User::with('getfriends.getuser')->where('id', $friend->id)->first();

            $data['check_friends'] =  Friend::whereIn('user_id', [$data['other_friends']->id, auth()->user()->id])->whereIn('friend_id', [$data['other_friends']->id, auth()->user()->id])->first();

            $data['friendrequest_status_for_accept'] = FriendRequest::where(['user_id' => $userData->id,'status' => 'pending'])->first();
            $data['check_friendrequest_status_tocancel'] =  FriendRequest::where(['user_id' => $friend->id, 'friend_id' => $data['other_friends']->id, 'status' => 'pending'])->first();

            $data['is_request_sending'] = (bool) FriendRequest::where(['user_id' => $userData->id, 'friend_id' => $data['other_friends']->id])->first();
            $data['check_friendrequest_status'] =  FriendRequest::where(['user_id' => $userData->id, 'friend_id' => $data['other_friends']->id])->first();
        }

        return view('dashboards.friendlist',compact('data'));
    }
}

