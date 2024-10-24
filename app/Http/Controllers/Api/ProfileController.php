<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\BlockedUser;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Country;
use App\Models\Feed;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\State;
use App\Models\User;
use App\Models\UserAlbum;
use App\Models\UserFollow;
use App\Models\UserProfileDetail;
use App\Models\UserProfileDetails;
use App\Models\UserProfileImage;
use Illuminate\Support\Str;
class ProfileController extends Controller
{
    public function userData($id='')
    {
        /* Fetch user data on the basis of id for vetandtech profile update */
        $data['user'] = Customer::where('id', $id)->first(array('id','first_name','name','last_name','email','phone','address','gender','dob','country_id','allow_on_dvm','allow_on_vt_friend','allow_on_vetandtech'));
        if($data['user']->name == null){
            $data['user']->name = $data['user']->first_name  . ' ' . $data['user']->last_name ;
        }
        // $data['user'] = Customer::where('id', $id)->first();
        $data['country'] = Country::where('id', $data['user']->country_id)->first(array('id','name'));
        $data['allCountries'] = Country::all(array('id','name'));

        $data['page_type'] = "profile-info";

        return response()->json($data, 200);
    }

    public function getProfile($id, $checkUser = false)
    {
        //creating 2 albums for user
        $imageDirForCoverAlbum = dirname(getcwd()).'/storage/app/public/images/album-img/'.$id.'/'.'Cover';
        if(!is_dir($imageDirForCoverAlbum))
        {
            mkdir($imageDirForCoverAlbum, 0777, true);
        }

        $imageDirForPhotoAlbum = dirname(getcwd()).'/storage/app/public/images/album-img/'.$id.'/'.'Profile';
        if(!is_dir($imageDirForPhotoAlbum))
        {
            mkdir($imageDirForPhotoAlbum, 0777, true);
        }

        UserAlbum::firstOrCreate([
            'album_name' => "Profile",
            'user_id' => $id,
            'status' => 'Y',
        ]);

        UserAlbum::firstOrCreate([
            'album_name' => "Cover",
            'user_id' => $id,
            'status' => 'Y',
        ]);

        $blockedUserCheck = BlockedUser::where(['user_id' => $id, 'blocked_user_id' => $checkUser])->first();
        $blockedOtherUserCheck = BlockedUser::where(['blocked_user_id' => $id, 'user_id' => $checkUser])->first();
        // if($blockedUserCheck){
        //     return response()->json(['customer' => null,'success' => false, 'message' => 'You have been blocked by this user' ], 201);
        // }
        $customer = Customer::find($id, ['id','email', 'first_name', 'phone', 'last_name','name','username','gender' ,'bio','dob','address', 'website', 'avatar_location', 'cover_image', 'avatar_type']);
        if(!$customer || $customer == null){
            return response()->json(['customer' => null,'success' => false, 'message' => 'customer not found' ], 201);
        }
        if($customer->name == null){
            $customer->name = $customer->first_name  . ' ' . $customer->last_name ;
        }
        if (isset($checkUser) && $checkUser != null) {
            $userFriend = Friend::where(['user_id' => $checkUser, 'friend_id' => $customer->id])->first();
            $crossFriendCheck = Friend::where(['friend_id' => $checkUser, 'user_id' => $customer->id])->first();
            if ($crossFriendCheck || $userFriend) {
                $customer->friend = true;
            }else{
                $customer->friend = false;
            }

            $FriendRequestMultiple = FriendRequest::whereIn('user_id', [$checkUser, $customer->id])->whereIn('friend_id', [$checkUser, $customer->id])->get();
            if($FriendRequestMultiple->count() > 1){
                foreach($FriendRequestMultiple as $key => $FriendRequestSingle){
                    if($key != 0 ){
                        $FriendRequestSingle->delete();
                    }
                }
            }

            $otherFriendRequestData = FriendRequest::where(['friend_id' => $checkUser, 'user_id' => $customer->id, 'status' => 'pending'])->first();
            $friendRequestData = FriendRequest::where(['user_id' => $checkUser, 'friend_id' => $customer->id, 'status' => 'pending'])->first();
            $customer->friendRequest = $friendRequestData ? true : false;
            $customer->otherFriendRequest = $otherFriendRequestData ? true : false;

            $chatExists = ChatMessage::where(['resp_user_id' => $checkUser , 'user_id' => $customer->id])->where('message_type', 'User')->first();
            $otherchatExist = ChatMessage::where(['user_id' => $checkUser , 'resp_user_id' => $customer->id])->where('message_type', 'User')->first();
            $customer->chat = false;

            //friend reuqest ID
            if($friendRequestData){
                $customer->friendRequestId = $friendRequestData->id;
            }elseif($otherFriendRequestData){
                $customer->friendRequestId = $otherFriendRequestData->id;
            }

            $customer->chatId =null;
            $customer->chat = false;
            if(isset($chatExists)){
                $customer->chat = true;
                $customer->chatId= $chatExists->chat_id ;
            }elseif(isset($otherchatExist)){
                $customer->chat = true;
                $customer->chatId= $otherchatExist->chat_id ;
            }

            if ($friendRequestData !=null  && $customer->friendRequest == true){
                $customer->friend_request_status = $friendRequestData->status;
            }elseif($otherFriendRequestData !=null && $customer->otherFriendRequest == true){
                $customer->friend_request_status = $otherFriendRequestData->status;
            }
            // $followRequestData = FollowRequest::where(['user_id' => $checkUser, 'following_user_id' => $customer->id])->first();
            // $customer->followRequest = $followRequestData ? true : false;
            // if ($followRequestData !=null  && $customer->followRequest == true) {
            //     $customer->follow_request_status =  $followRequestData->status;
            // }
            $customer->follow = UserFollow::where(['user_id'=> $checkUser , 'following_user_id'=> $customer->id])->first() ? true : false;
            $customer->followBack = UserFollow::where(['following_user_id'=> $checkUser , 'user_id'=> $customer->id])->first() ? true : false;
        }
        $customer->block = $blockedUserCheck || $blockedOtherUserCheck? true : false;

        $data['allFollowing'] = UserFollow::with('getUserDetailsFollowing:id,first_name,last_name,avatar_location,cover_image,username')->whereHas('getUserDetailsFollowing')->where(['user_id' => $id])->get();
        $customer->total_followings = 0;
        foreach ($data['allFollowing'] as $key => $dataallFollowing) {
            if ($dataallFollowing->getUserDetailsFollowing->username) {
                $customer->total_followings += 1;
            }
        }


        $data['allFollowers'] = UserFollow::with('getUserDetailsFollowers:id,first_name,last_name,avatar_location,cover_image,username')->whereHas('getUserDetailsFollowers')->where(['following_user_id' => $id])->get();
        $customer->total_followers = 0;
        foreach ($data['allFollowers'] as $key => $dataallFollowers) {
            if ($dataallFollowers->getUserDetailsFollowers->username) {
                $customer->total_followers += 1;
            }
        }


        // $customer->total_followings = UserFollow::where('user_id', $id)->count();
        // $customer->total_followers = UserFollow::where('following_user_id', $id)->get();
        // $customer->total_followers = $customer->total_followers->count();

        $customer->total_posts_count = Feed::where(['user_id' => $id, 'type' => 'feed'])->where('is_deleted','!=' , '1')->count();
        //fetching user feeds
        foreach($customer->feeds as $feed){
            foreach ($feed->attachments as $attachment) {
                $attachment->time = $attachment->created_at->diffForHumans();
            }
        }
        $userProfileData = UserProfileDetails::where('user_id', $id)->select('id','user_id','state','city', 'marital_status', 'age', 'country', 'profile_image', 'account_privacy', 'your_profile','story_sharing','your_message')->first();
        //check for private account
        if($userProfileData->account_privacy != 1){
            return response()->json(['customer' => $customer,'userProfileData'=> $userProfileData ,'success' => true ], 200);
        }elseif($userProfileData->account_privacy == 1 &&  $checkUser!= $id){
            if($customer->friend == true || $customer->follow == true){
                return response()->json(['customer' => $customer,'userProfileData'=> $userProfileData ,'success' => true ], 200);
            }else{
                $customer = $userProfileData = [];
                $customer = Customer::find($id, ['id','email', 'first_name', 'last_name','name','username','gender' ,'bio','dob', 'avatar_location', 'cover_image', 'avatar_type']);
                $customer['total_followings'] = UserFollow::where('user_id', $id)->count();
                $customer['total_followers'] = UserFollow::where('following_user_id', $id)->count();
                $customer['total_posts_count'] = Feed::where(['user_id' => $id, 'type' => 'feed'])->where('is_deleted','!=' , '1')->count();
                $userProfileData = UserProfileDetails::where('user_id', $id)->select('id','user_id', 'account_privacy', 'your_profile','story_sharing','your_message')->first();
                return response()->json(['customer' => $customer,'userProfileData'=> $userProfileData ,'message' => 'This account is private.', 'success' => false ], 201);
            }
        }
        return response()->json(['customer' =>$customer,'userProfileData'=> $userProfileData ,'success' => true ], 200);
    }
    public function updateProfile(Request $request)
    {
        $customer = Customer::where('email', $request->get('email'))->orWhere('id', $request->get('user_id'))->first();
        if(!$customer || $customer == null){
            return response()->json(['customer' => null,'success' => false, 'message' => 'user not found' ], 404);
        }
        if(isset($request->first_name) && isset($request->first_name)){
            $customer->first_name = Str::title($request->get('first_name'));
            $customer->last_name =  Str::title($request->get('last_name'));
        }
        $customer->username = $request->get('username');
        $customer->name = $request->name ? $request->name : @$customer->first_name  . ' ' . @$customer->last_name ;
        $customer->phone = $request->get('phone');
        $customer->address = $request->get('address');
        $customer->gender = $request->get('gender');
        if($request->dob ){
            $customer->dob = $request->get('dob');
        }
        $customer->bio = $request->get('bio');
        $customer->website = $request->get('website');
        $customer->country_id = $request->get('country_id');
        $customer->allow_on_vt_friend = $request->get('allow_on_vt_friend');
        $customer->allow_on_dvm = $request->get('allow_on_dvm');
        $customer->allow_on_vetandtech = $request->get('allow_on_vetandtech');
        $customer->save();

        // if ($request->file('avatar_location')) {
        //     $file = $request->file('avatar_location');
        //     $ext =  $file->extension();
        //     $imagePath = $customer->avatar_type. '/' . str_replace(' ', '_', $request->name) .'-'.time(). '-' . $request->customer_id . '.' . $ext;
        //     $path = dirname(getcwd()) . '/storage/app/public/' . $imagePath; // uploaded image path

        //     if($customer->avatar_location)
        //     {
        //         $currentImage = dirname(getcwd()) . '/storage/app/public/' . $customer->avatar_location; // if current image exist then remove file
        //         if (is_file($currentImage)) {
        //             unlink($currentImage);
        //         }
        //     }
        //     $request->validate([
        //         'avatar_location' => 'required|mimes:jpeg,png,jpg|max:1024'
        //     ]);

        //     $imageDir = dirname(getcwd()) . '/storage/app/public/'.$customer->avatar_type;
        //     if(!is_dir($imageDir))
        //     {
        //         mkdir($imageDir);
        //     }
        //     move_uploaded_file($file , $path); // image uploading
        //     $customer->avatar_location = $imagePath;
        // }

        // $customer->save();

        return response()->json(['customer' =>$customer ,'message' => __('Profile successfully updated.')], 200);
    }

    public function uploadProfilePicture(Request $request)
    {
        $customer = Customer::where('email', $request->get('email'))->orWhere('id', $request->get('user_id'))->first();
            if( $customer){
            if ($request->file('avatar_location')) {
                $file = $request->file('avatar_location');
                $ext =  $file->extension();
                $imagePath = time(). '-' . $customer->first_name . '.' . $ext;
                $path = dirname(getcwd()) . '/storage/app/public/images/user/userProfileandCovers/' . $imagePath; // uploaded image path

                if($customer->avatar_location)
                {
                    $currentImage = dirname(getcwd()) . '/storage/app/public/images/user/userProfileandCovers/'.$customer->id.'/'. $customer->avatar_location; // if current image exist then remove file
                    if (is_file($currentImage)) {
                        unlink($currentImage);
                    }
                }
                $request->validate([
                    'avatar_location' => 'required|mimes:jpeg,png,jpg|max:1024'
                ]);

                $imageDir = dirname(getcwd()) . '/storage/app/public/images/user/userProfileandCovers/'.$customer->id;
                if(!is_dir($imageDir))
                {
                    mkdir($imageDir);
                }
                move_uploaded_file($file , $path);
                $customer->avatar_location = $imagePath;
            }

            $customer->save();
            return response()->json(['success' =>true ,'customer' =>$customer ,'message' => __('Profile successfully updated.')], 200);

        }else{
            return response()->json(['success' =>false ,'message' => __('Customer Not Found.')], 200);
        }
    }

    public function getUserProfile(Request $req, $id)
    {
        //creating 2 albums for users
        $imageDirForCoverAlbum = dirname(getcwd()).'/storage/app/public/images/album-img/'.$id.'/'.'Cover';
        if(!is_dir($imageDirForCoverAlbum))
        {
            mkdir($imageDirForCoverAlbum, 0777, true);
        }

        $imageDirForPhotoAlbum = dirname(getcwd()).'/storage/app/public/images/album-img/'.$id.'/'.'Profile';
        if(!is_dir($imageDirForPhotoAlbum))
        {
            mkdir($imageDirForPhotoAlbum, 0777, true);
        }

        UserAlbum::firstOrCreate([
            'album_name' => "Cover",
            'user_id' => $id,
            'status' => 'Y',
        ]);
        UserAlbum::firstOrCreate([
            'album_name' => "Profile",
            'user_id' => $id,
            'status' => 'Y',
        ]);



        $customer = Customer::where('id', $id)->select('id','email', 'address',  'phone','dob','first_name', 'last_name', 'name','username','gender','pet_parent','avatar_location', 'cover_image', 'cover_image', 'avatar_type', 'bio')->with('feeds.attachments:id,feed_id,attachment_type,attachment,created_at')->first();

        if(!$customer){
            return response()->json(['success' => false, 'message'=> 'User does not exists'],404);
        }
        if($customer->name == null){
            $customer->name = $customer->first_name  . ' ' . $customer->last_name ;
        }

        $data['allFollowing'] = UserFollow::with('getUserDetailsFollowing:id,first_name,last_name,avatar_location,cover_image,username')->whereHas('getUserDetailsFollowing')->where(['user_id' => $id])->get();
        $customer->following = 0;
        foreach ($data['allFollowing'] as $key => $dataallFollowing) {
            if ($dataallFollowing->getUserDetailsFollowing->username) {
                $customer->following += 1;
            }
        }

        $data['allFollowers'] = UserFollow::with('getUserDetailsFollowers:id,first_name,last_name,avatar_location,cover_image,username')->whereHas('getUserDetailsFollowers')->where(['following_user_id' => $id])->get();
        $customer->followers = 0;
        foreach ($data['allFollowers'] as $key => $dataallFollowers) {
            if ($dataallFollowers->getUserDetailsFollowers->username) {
                $customer->followers += 1;
            }
        }

        $customer->posts_count = Feed::where(['user_id' => $id, 'type' => 'feed'])->where('is_deleted','!=' , '1')->count();
        if($customer->dob ){
            $customer->dob = $this->rev_date($customer->dob);
        }
         UserProfileDetails::firstOrCreate([
            'user_id' => $customer->id,
            // other fields in the UserProfileDetails table
        ]);
        // time format for each Feed/Post
        foreach($customer->feeds as $feed){
            foreach ($feed->attachments as $attachment) {
                $attachment->time = $attachment->created_at->diffForHumans();
            }
        }
        if(!$customer || $customer == null){
            return response()->json(['customer' => null,'success' => false, 'message' => 'User not found' ], 404);
        }

        //Check for friend true or not and friend request sent or not
        if(isset($req->other_user_id)){
            $customer->friend = false;
            $customer->requestSent = false;
            $customer->requestReceived = false;
            $checkForFriend = Friend::where(['user_id' => $req->other_user_id, 'friend_id' => $customer->id])->first() ? true : false;
            $checkForOtherFriend = Friend::where(['friend_id' => $req->other_user_id, 'user_id' => $customer->id])->first() ? true : false;

            $checkForRequest = FriendRequest::where(['user_id' => $req->other_user_id, 'friend_id' => $customer->id, 'status' => 'pending'])->first() ? true : false;
            $checkForOtherRequest = FriendRequest::where(['friend_id' => $req->other_user_id, 'user_id' => $customer->id, 'status' => 'pending'])->first() ? true : false;

            if($checkForFriend || $checkForOtherFriend ){
                $customer->friend = true;
            }

            if($checkForRequest){
                $customer->requestSent = true;
            }elseif($checkForOtherRequest){
                $customer->requestReceived = true;
            }
        }
        $userProfileData = UserProfileDetail::where('user_id', $customer->id)->select('id','user_id','state','city','your_profile', 'account_privacy','marital_status', 'age', 'country', 'profile_image', 'language_eng', 'language_french', 'language_chinese', 'language_spanish','language_arabic','language_italian')->first();
        if($userProfileData == null){
            $customer->state = null;
            $customer->city = null;
            $customer->marital_status = null;
            $customer->age = null;
        }
         //check for private account
        if($userProfileData->account_privacy != 1){
            return response()->json(['customer' => $customer,'userProfileData'=> $userProfileData ,'success' => true ], 200);
        }elseif($userProfileData->account_privacy == 1 &&  $req->other_user_id!= $customer->id){
            if($customer->friend == true || $customer->follow == true){
                return response()->json(['customer' => $customer,'userProfileData'=> $userProfileData ,'success' => true ], 200);
            }else{
                $customer = $userProfileData = [];
                return response()->json(['customer' =>$customer,'userProfileData'=> $userProfileData ,'message' => 'This account is private.', 'success' => false ], 201);
            }
        }
        return response()->json(['customer' =>$customer,'userProfileData'=> $userProfileData ,'success' => true ], 200);
    }

    public function  rev_date($date){
        $array=explode("-",$date);
        $rev=array_reverse($array);
        $date=implode("-",$rev);
        return $date;
    }
    public function updateProfileApp(Request $request)
    {
        if($request->dob == 'null'){
            $request->dob= null;
        }
        if($request->country == 'null'){
            $request->country= null;
        }
        if($request->city == 'null'){
            $request->city= null;
        }
        if($request->state == 'null'){
            $request->state= null;
        }
        if($request->address == 'undefined'){
            $request->address= null;
        }
        $date = $this->rev_date(@$request->dob);

        $customer = Customer::where('email', $request->get('email'))->orWhere('id', $request->get('user_id'))->select('id', 'email', 'name', 'username', 'phone', 'bio','dob','first_name','last_name','address','gender', 'website', 'avatar_location', 'cover_image')->first();
        if(!$customer || $customer == null){
            return response()->json(['customer' => null,'success' => false, 'message' => 'User not found' ], 201);
        }
        if(isset($request->username) && $customer){
            if($customer->username != $request->get('username')){
                $checkforExistingUsername = User::where('username', $request->username)->first();
                if($checkforExistingUsername){
                    return response()->json(['customer' => null,'success' => false, 'message' => 'Username already taken' ], 201);
                }
            }
        }

        $customer->name = $request->name ? $request->name : @$request->first_name  . ' ' . @$request->last_name ;
        if($request->bio)
        $customer->bio = @$request->bio;
        if($request->username)
        $customer->username = $request->username;
        if($request->website)
        $customer->website = $request->website;
        if($request->first_name)
        $customer->first_name = $request->first_name;
        if($request->last_name)
        $customer->last_name = $request->last_name;
        if($request->gender)
        $customer->gender = $request->gender;
        if($request->dob)
        $customer->dob = @$date;
        if($request->country)
        $customer->country_id = @$request->country;
        if($request->phone)
        $customer->phone = $request->phone;

        $customer->address = $request->address;
        $customer->pet_parent = $request->pet_parent;
        // $customer->city = $request->city;
        $customer->save();
        if($request->age == 'null' || $request->age == 'Null'){
            $request->age = null;
        }
        $userProfileData = UserProfileDetails::where('user_id', $customer->id)->select('id','user_id','state','city','marital_status', 'age', 'country','profile_image')->first();
        if($userProfileData){
            if($request->state)
            $userProfileData->state = @$request->state;
            if($request->city)
            $userProfileData->city = $request->city;
            if($request->marital_status)
            $userProfileData->marital_status = $request->marital_status;
            if($request->age)
            $userProfileData->age = $request->age;
            if($request->country)
            $userProfileData->country = @$request->country;
            $userProfileData->save();
        }else{
            $userProfileData = UserProfileDetails::create([
                'user_id' => $customer->id,
                'state' => @$request->state,
                'city' => @$request->city,
                'age' => @$request->age,
                'country' => @$request->country,
                'marital_status' => @$request->marital_status,
            ]);
        }

        if (isset($_FILES['avatar_location'])) {
            $ext = explode('.', $_FILES['avatar_location']['name']);
            $ext = end($ext);

            $imagePath = $customer->id .'-'.time(). '.' . $ext;
            $path = dirname(getcwd()) . '/storage/app/public/images/user/userProfileandCovers/' . $customer->id . '/'. $imagePath; // uploaded image path

            if($customer->avatar_location)
            {
                $currentImage = dirname(getcwd()) . '/storage/app/public/images/user/userProfileandCovers/'.$customer->id.'/' . $userProfileData->profile_image; // if current image exist then remove file
                if (is_file($currentImage)) {
                    unlink($currentImage);
                }
            }

            $imageDir = dirname(getcwd()) . '/storage/app/public/images/user/userProfileandCovers/'.$customer->id;
            if(!is_dir($imageDir))
            {
                mkdir($imageDir);
            }

            move_uploaded_file($_FILES['avatar_location']['tmp_name'], $path); // image uploading
            $customer->avatar_location = $imagePath;
            $customer->save();

            $userProfileImage = new UserProfileImage;
            $userProfileImage->user_id = $customer->id;
            $userProfileImage->image_path = $imagePath;
            $userProfileImage->status = 'Y';
            $userProfileImage->type = 'profile_image';
            $userProfileImage->save();
        }

        if (isset($_FILES['cover_image'])) {
            $ext = explode('.', $_FILES['cover_image']['name']);
            $ext = end($ext);
            $imagePath =  'cover-'.$customer->id .'-'.time(). '.' . $ext;
            $imageDir = dirname(getcwd()).'/storage/app/public/images/user/userProfileandCovers/'.$customer->id.'/'.'cover';
            if(!is_dir($imageDir))
            {
                mkdir($imageDir, 0777, true);
            }
            $path = dirname(getcwd()).'/storage/app/public/images/user/userProfileandCovers/'.$customer->id.'/'.'cover'.'/'.$imagePath;
            move_uploaded_file($_FILES['cover_image']['tmp_name'], $path); // image uploading
            $customer->cover_image = $imagePath;
            $customer->save();

            $userProfileImage = new UserProfileImage;
            $userProfileImage->user_id = $customer->id;
            $userProfileImage->image_path = $imagePath;
            $userProfileImage->status = 'Y';
            $userProfileImage->type = 'cover_image';
            $userProfileImage->save();
        }
        $customer->save();
        return response()->json([ 'customer' =>$customer,'userProifleData'=> $userProfileData ,'message' => __('Profile successfully updated.')], 200);
    }

    public function getAllProfileDetails($profileUserId, $viewingUserId) {

        $blockedUserCheck = BlockedUser::where(['user_id' => $profileUserId, 'blocked_user_id' => $viewingUserId])->first();
        $blockedOtherUserCheck = BlockedUser::where(['blocked_user_id' => $profileUserId, 'user_id' => $viewingUserId])->first();

        $customer = Customer::find($profileUserId, ['id','email', 'first_name', 'phone', 'last_name','name','username','gender' ,'bio','dob','address', 'website', 'avatar_location', 'cover_image', 'avatar_type']);
        if(!$customer || $customer == null){
            return response()->json(['customer' => null,'success' => false, 'message' => 'customer not found' ], 201);
        }
        if($customer->name == null){
            $customer->name = $customer->first_name  . ' ' . $customer->last_name ;
        }
        if (isset($viewingUserId) && $viewingUserId != null) {
            $userFriend = Friend::where(['user_id' => $viewingUserId, 'friend_id' => $customer->id])->first();
            $crossFriendCheck = Friend::where(['friend_id' => $viewingUserId, 'user_id' => $customer->id])->first();
            if ($crossFriendCheck || $userFriend) {
                $customer->friend = true;
            }else{
                $customer->friend = false;
            }
            $otherFriendRequestData = FriendRequest::where(['friend_id' => $viewingUserId, 'user_id' => $customer->id, 'status' => 'pending'])->first();
            $friendRequestData = FriendRequest::where(['user_id' => $viewingUserId, 'friend_id' => $customer->id, 'status' => 'pending'])->first();
            $customer->friendRequest = $friendRequestData ? true : false;
            $customer->otherFriendRequest = $otherFriendRequestData ? true : false;

            $chatExists = ChatMessage::where(['resp_user_id' => $viewingUserId , 'user_id' => $customer->id])->where('message_type', 'User')->first();
            $otherchatExist = ChatMessage::where(['user_id' => $viewingUserId , 'resp_user_id' => $customer->id])->where('message_type', 'User')->first();
            $customer->chat = false;

            //friend reuqest ID
            if($friendRequestData){
                $customer->friendRequestId = $friendRequestData->id;
            }elseif($otherFriendRequestData){
                $customer->friendRequestId = $otherFriendRequestData->id;
            }

            $customer->chatId =null;
            if($chatExists || $otherchatExist ){
                $customer->chat = $chatExists ? true : false;
                $customer->chatId= $chatExists->chat_id ;
            }
            if ($friendRequestData !=null  && $customer->friendRequest == true){
                $customer->friend_request_status = $friendRequestData->status;
            }elseif($otherFriendRequestData !=null && $customer->otherFriendRequest == true){
                $customer->friend_request_status = $otherFriendRequestData->status;
            }

            $customer->follow = UserFollow::where(['user_id'=> $viewingUserId , 'following_user_id'=> $customer->id])->first() ? true : false;
            $customer->followBack = UserFollow::where(['following_user_id'=> $viewingUserId , 'user_id'=> $customer->id])->first() ? true : false;
        }
        $customer->block = $blockedUserCheck || $blockedOtherUserCheck? true : false;
        $customer->total_followings = UserFollow::where('user_id', $profileUserId)->count();
        $customer->total_followers = UserFollow::where('following_user_id', $profileUserId)->count();
        $customer->total_posts_count = Feed::where(['user_id' => $profileUserId, 'type' => 'feed'])->where('is_deleted','!=' , '1')->count();
        //fetching user feeds
        foreach($customer->feeds as $feed){
            foreach ($feed->attachments as $attachment) {
                $attachment->time = $attachment->created_at->diffForHumans();
                unset($attachment->updated_at,$attachment->user_id,$attachment->created_at);  //removing extra fields
            }
        }
        $userProfileData = UserProfileDetail::where('user_id', $customer->id)->first();

        //check for private account
        if($userProfileData->account_privacy != 1){
            return response()->json(['customer' => $customer,'userProfileData'=> $userProfileData ,'success' => true ], 200);
        }elseif($userProfileData->account_privacy == 1 &&  $viewingUserId != $profileUserId){
            if($customer->friend == true || $customer->follow == true){
                return response()->json(['customer' => $customer,'userProfileData'=> $userProfileData ,'success' => true ], 200);
            }else{
                $customer = $userProfileData = [];
                return response()->json(['customer' =>$customer,'userProfileData'=> $userProfileData ,'message' => 'This account is private.', 'success' => false ], 201);
            }
        }

        //setting data according to user privacy settings
        if($userProfileData->your_profile == 'public'){
            return response()->json(['customer' => $customer,'userProfileData'=> $userProfileData ,'success' => true ], 200);
        }elseif($userProfileData->your_profile == 'friend' &&  $viewingUserId != $profileUserId){
            if($customer->friend == true){
                return response()->json(['customer' => $customer,'userProfileData'=> $userProfileData ,'success' => true ], 200);
            }else{
                return response()->json(['message' => 'Only friends can view this profile.', 'success' => false ], 201);
            }
        }elseif($userProfileData->your_profile == 'only_me'){
            if($viewingUserId == $profileUserId){
                return response()->json(['customer' => $customer,'userProfileData'=> $userProfileData ,'success' => true ], 200);
            }else{
                return response()->json(['message' => 'This profile is private.', 'success' => false ], 201);
            }
        }
    }
}
