<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfileDetails;
use App\Models\UserWorkAndEducation;
use App\Models\UserPlaceLive;
use App\Models\UserFamilyRelationship;
use App\Models\UserHobbyInterest;
use App\Http\Requests\UserRequest;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\FeedAttachment;
use App\Models\Feed;
use App\Models\UserProfileImage;
use App\Models\UserFollow;
use App\Models\BlockedUser;
use App\Models\State;
use App\Models\Country;
use App\Models\UserAlbum;
use App\Models\UserAlbumImage;
use App\Models\FavouriteFeed;
use App\Models\LearningRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profile(Request $request, $username)
    {

        $user = User::where('username', $username)->first();//auth()->user();
        if(!$user) abort(404);
        $commentsUser = [];
        $index = 0;
        if(auth()->user() == null){
            return redirect()->route('login');
        }
        if($username !== auth()->user()->username){
            $blockedUser = BlockedUser::where(['user_id' => auth()->user()->id, 'blocked_user_id' => $user->id])->first();
            $blockedOtherUser = BlockedUser::Where(['blocked_user_id' => auth()->user()->id, 'user_id' => $user->id])->first();
            if(isset($blockedUser) || isset($blockedOtherUser)){
                return back();
            }
        }
        $data['logged_in_user_id'] = auth()->user()->id;
        $data['self_profile'] = $data['logged_in_user_id'] == $user->id;

        $data['user'] = $user;//User::find($user->id);
        $feeds = Feed::where(['user_id' => $user->id, 'type' => 'feed', 'status' => 'Y'])->get();
        $storyFeeds = Feed::where(['user_id' => $user->id, 'type' => 'story', 'status' => 'Y'])->pluck('id')->toArray();

        $data['is_following'] = (bool) UserFollow::where(['user_id' => $data['logged_in_user_id'], 'following_user_id' => $data['user']->id])->first();
        $data['is_blocking'] = (bool) BlockedUser::where(['user_id' => $data['logged_in_user_id'], 'blocked_user_id' => $data['user']->id])->first();

        $data['allFollowing'] = UserFollow::with('getUserDetailsFollowing:id,first_name,last_name,avatar_location,cover_image,username')->whereHas('getUserDetailsFollowing')->where(['user_id' => $user->id])->get();
        $data['following_user'] = 0;
        foreach ($data['allFollowing'] as $key => $dataallFollowing) {
            if ($dataallFollowing->getUserDetailsFollowing->username) {
                $data['following_user'] += 1;
            }
        }


        $data['allFollowers'] = UserFollow::with('getUserDetailsFollowers:id,first_name,last_name,avatar_location,cover_image,username')->whereHas('getUserDetailsFollowers')->where(['following_user_id' => $user->id])->get();
        $data['follower_user'] = 0;
        foreach ($data['allFollowers'] as $key => $dataallFollowers) {
            if ($dataallFollowers->getUserDetailsFollowers->username) {
                $data['follower_user'] += 1;
            }
        }

        $data['userFollow'] = UserFollow::where(['user_id'=> $data['logged_in_user_id'],'following_user_id' => $user->id])->first();

        $data['allBlockedUsers'] = BlockedUser::with('getUserDataSelectedColumns')->where('user_id',auth()->user()->id)->get();
        $data['blockedUsers'] = count($data['allBlockedUsers']);

        $data['feeds'] = Feed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData:id,name,username,avatar_location,first_name,last_name')->with('comments.commentLikes')->with('likes.getUserData:id,username,first_name,last_name')->with('getFavFeed:id,feed_id,user_id')->where(['user_id' => $user->id, 'type' => 'feed', 'status' => 'Y', 'is_deleted' => 0, 'hide_from_timeline' => 0])->orderBy('created_at', 'DESC')->paginate(5);
        $userData = User::find($user->id);

        $data['friends'] = $userData->getAllFriends(['user_id' =>$user->id]);


        $data['allRecentlyAdded'] = $userData->getRecentlyAddedFriends(['user_id' => $user->id]);
        $data['recentlyAdded'] = count($data['allRecentlyAdded']);

        // $data['check_friends'] = (bool) User::with('getfriends.getuser')->where('id', $user->id)->get();


        // $data['friends'] = User::with('getfriends.getuser')->where('id', $user->id)->get();
        $data['other_friends'] = User::with('getfriends.getuser')->where('id', $user->id)->first();

        $data['check_friends'] =  Friend::whereIn('user_id', [$data['other_friends']->id, auth()->user()->id])->whereIn('friend_id', [$data['other_friends']->id, auth()->user()->id])->first();

        $data['getfreiendrelation'] = UserFamilyRelationship::where(['user_id' => $user->id])->get();
        //dd($data['getfreiendrelation']);

        $FriendRequestMultiple = FriendRequest::whereIn('user_id', [$user->id, auth()->user()->id])->whereIn('friend_id', [$user->id, auth()->user()->id])->get();
        if($FriendRequestMultiple->count() > 1){
            foreach($FriendRequestMultiple as $key => $FriendRequestSingle){
                if($key != 0 ){
                    $FriendRequestSingle->delete();
                }
            }
        }

        $data['friendrequest_status_for_accept'] = FriendRequest::where(['user_id' => $user->id ,'friend_id' => auth()->user()->id,'status' => 'pending'])->first();
        $data['check_friendrequest_status_tocancel'] =  FriendRequest::where(['user_id' => $data['logged_in_user_id'], 'friend_id' => $data['other_friends']->id, 'status' => 'pending'])->first();

        $data['is_request_sending'] = (bool) FriendRequest::where(['user_id' => $data['logged_in_user_id'], 'friend_id' => $data['other_friends']->id])->first();
        $data['check_friendrequest_status'] =  FriendRequest::where(['user_id' => $data['logged_in_user_id'], 'friend_id' => $data['other_friends']->id])->first();

        foreach ($data['feeds'] as $feed) {
            if(isset($feed['getUser'])){
                $commentsUser[$index]['id'] = $feed['getUser']->id;
                $commentsUser[$index]['name'] = $feed['getUser']->first_name . ' ' . $feed['getUser']->last_name;
                $index++;
            }
        }
        $data['feedsCount'] = Feed::where(['user_id' => $user->id, 'type' => 'feed', 'status' => 'Y', 'is_deleted' => 0, 'hide_from_timeline' => 0])->count();
        $data['commentsUser'] = $commentsUser;
        $data['profileImages'] = UserProfileImage::where(['user_id' => $user->id, 'status' => 'Y','is_deleted' => 0,'type' => 'profile_image'])->orderBy('created_at', 'DESC')->get();
        $data['feedImages'] = FeedAttachment::where(['user_id' => $user->id, 'attachment_type' => 'image', 'is_deleted' => 0])->whereNotIn('feed_id', $storyFeeds)->orderBy('created_at', 'DESC')->get();
        $data['feedVideos'] = FeedAttachment::where(['user_id' => $user->id, 'attachment_type' => 'video'])->get();
        $data['feedsVideosAttach'] = Feed::where(['user_id' => $user->id,'type' => 'feed','is_deleted' => 0])->with('attachments')->orderBy('created_at', 'DESC')->get();
        $data['UserProfileDetails'] = UserProfileDetails::where(['user_id' => $user->id])->first();
        $data['userWorkAndEducationUpdate'] = userWorkAndEducation::select(['id','name','city'])->orderBy('id', 'DESC')->get();
        $data['userWorkAndEducation'] = userWorkAndEducation::where(['user_id' => $user->id])->orderBy('id', 'DESC')->get();
        $data['UserPlaceLive'] = UserPlaceLive::where(['user_id' => $user->id])->orderBy('id', 'DESC')->get();
        $data['UserFamilyRelationship'] = UserFamilyRelationship::where(['user_id' => $user->id])->orderBy('id', 'DESC')->get();
        $data['UserFamilyRelationshipStatus'] = UserFamilyRelationship::where(['user_id' => $user->id])->where(['type' => 'ownstatus'])->first();
        $data['UserHobbyInterest'] = UserHobbyInterest::where(['user_id' => $user->id])->first();
        $data['UserHobbyList'] = DB::table('user_hobbies')->get();

        $userAlbums = UserAlbum::with('getAlbumImages:id,user_album_id,image_path,is_deleted')->whereHas('getAlbumImages')->where(['user_id' => $user->id, 'is_deleted' => 0])->get();
        $coverImages = UserProfileImage::where(['user_id' => $user->id, 'status' => 'Y', 'type' => 'cover_image'])->get();
        $profileImages = UserProfileImage::where(['user_id' => $user->id, 'status' => 'Y', 'type' => 'profile_image'])->get();
        // $data['UserAlbum'] = [...$userAlbums , ...$profileImages, ...$coverImages];
        $data['UserAlbum'] = [...($userAlbums ?? []), ...($profileImages ?? []), ...($coverImages ?? [])];

        //setting data according to user about privacy settings

        $friend = false;
        $data['lock'] =  $data['completeLock'] = $data['chatLock'] = $data['feedsLock'] = false;
        $userFriend = \App\Models\Friend::where(['user_id' => @$data['UserProfileDetails']->user_id, 'friend_id' => auth()->user()->id])->first();
        $crossFriendCheck = \App\Models\Friend::where(['friend_id' => @$data['UserProfileDetails']->user_id, 'user_id' => auth()->user()->id])->first();
        if ($crossFriendCheck || $userFriend) {
            $friend = true;
        }
        if( isset($data['UserProfileDetails']) && $data['UserProfileDetails']->your_profile ==null){
            $data['UserProfileDetails']->your_profile == 'public';
            $data['UserProfileDetails']->save();
        }
        if(isset($data['UserProfileDetails']) && $data['UserProfileDetails']->your_profile == 'public'){
            $data['lock'] = false;
        }elseif(isset($data['UserProfileDetails']) && $data['UserProfileDetails']->your_profile == 'friend' &&  auth()->user()->id != $data['UserProfileDetails']->user_id){
            if($friend == true){
                $data['lock'] = false;
            }else{
                $data['lock'] = true;
            }
        }elseif(isset($data['UserProfileDetails']) && $data['UserProfileDetails']->your_profile == 'only_me'){
            if(auth()->user()->id == $data['UserProfileDetails']->user_id){
                $data['lock'] = false;
            }else{
                $data['lock'] = true;
            }
        }else{
            $data['lock'] = false;
        }

        //full account privacy
        if(isset($data['UserProfileDetails']) && $data['UserProfileDetails']->account_privacy == 1 &&  auth()->user()->id != $data['UserProfileDetails']->user_id){
            if($friend == true){
                $data['completeLock'] = false;
            }else{
                $data['completeLock'] = true;
            }
        }

        //Chat messages privacy
        if(isset($data['UserProfileDetails']) && $data['UserProfileDetails']->your_message == 'friend' &&  auth()->user()->id != $data['UserProfileDetails']->user_id){
            if($friend == true){
                $data['chatLock'] = false;
            }else{
                $data['chatLock'] = true;
            }
        }
        if(isset($data['UserProfileDetails']) && $data['UserProfileDetails']->your_message == 'anyone'){
            $data['chatLock'] = false;
        }

        //story sharing privacy
        if(isset($data['UserProfileDetails']) && $data['UserProfileDetails']->story_sharing == 'public'){
            $data['feedsLock'] = false;
        }elseif(isset($data['UserProfileDetails']) &&  auth()->user()->id == $data['UserProfileDetails']->user_id){
            $data['feedsLock'] = false;
        }else{
            $data['feedsLock'] = true;
        }

        if (config('app.env') === 'local') {
            $data['environment'] = 'local';
        } else {
            $data['environment'] = 'production';
        }
        $data['pageName'] = 'profilePage';
        return view('dashboards.profile',compact('data'));

    }

    public function profileedit(Request $request)
    {

        if($request->query('user_id')){
         $id  =$request->query('user_id');
         $type='team_member';
         $user = User::where('id', $id)->first();
        }else{
        $user = auth()->user();
        $id  = $user->id;
        $type='';
        }

        $roles=LearningRole::where('status','Y')->pluck('name','id');
        $users = UserProfileDetails::where('user_id',  $id)->first();
        $data['country'] = Country::all()->pluck('name','id');
        $data['states'] = State::where('id',$users->state)->pluck('name','id');
        $data['dob'] = explode('-', $user->dob);
        $data['type'] = $type;
        $data['roles'] = $roles;
        $data['user_id'] = $id;
        $data['team_id'] = $request->query('team_id');
        return view('dashboards.profileedit', compact('users','data','user'));
    }

    public function delProfileData($id,$type){
        $userId     =  auth()->user()->id;
        $userName   =  auth()->user()->username;


        if($type=='live'){
            $data = UserPlaceLive::where(['user_id' =>$userId,'id'=>$id])->first();
            if(isset($data->id)){
                    $data->delete();
                    return redirect('profile/'.$userName)->with(['success'=>'Record has been deleted.','pg'=>2]);
            }

        }


        if($type=='skill'){
            $data = userWorkAndEducation::where(['user_id' =>$userId,'id'=>$id])->first();
            if(isset($data->id)){
                    $data->delete();
                    return redirect('profile/'.$userName)->with(['success'=>'Record has been deleted.','pg'=>2]);
            }

        }

        if($type=='education'){
            $data = userWorkAndEducation::where(['user_id' =>$userId,'id'=>$id])->first();
            if(isset($data->id)){
                    $data->delete();
                    return redirect('profile/'.$userName)->with(['success'=>'Record has been deleted.','pg'=>2]);
            }

        }

        if($type=='familymember'){
            $data = UserFamilyRelationship::where(['user_id' =>$userId,'id'=>$id])->first();
            if(isset($data->id)){
                    $data->delete();
                    return redirect('profile/'.$userName)->with(['success'=>'Record has been deleted.','pg'=>2]);
            }

        }

        if($type=='work'){
            $data = userWorkAndEducation::where(['user_id' =>$userId,'id'=>$id])->first();
            if(isset($data->id)){
                    $data->delete();
                    return redirect('profile/'.$userName)->with(['success'=>'Record has been deleted.','pg'=>2]);
            }

        }

        return redirect('profile/'.$userName)->with(['success'=>'Record has not been deleted.','pg'=>2]);
    }

    function changePassword(Request $request){
        //Validate form

        $validator = \Validator::make($request->all(),[
            'current_password'=>[
                'required', function($attribute, $value, $fail){
                    if( !\Hash::check($value, Auth::user()->password) ){
                        return $fail(__('The current password is incorrect'));
                    }
                },
                'min:8',
                'max:30'
             ],
             'new_password'=>[
                 'required',
                 'min:8',
                 'max:30',
                 function($attribute, $value, $fail) use ($request) {
                     if (\Hash::check($value, Auth::user()->password)) {
                         return $fail(__('The new password should be different from the old password'));
                     }
                 },
             ],
             'new_password_confirmation'=>'required|same:new_password'
         ],[
             'current_password.required'=>'Enter your current password',
             'current_password.min'=>'Current password must have atleast 8 characters',
             'current_password.max'=>'Current password must not be greater than 30 characters',
             'new_password.required'=>'Enter new password',
             'new_password.min'=>'New password must have atleast 8 characters',
             'new_password.max'=>'New password must not be greater than 30 characters',
             'new_password_confirmation.required'=>'ReEnter your new password',
             'new_password_confirmation.same'=>'New password and Confirm new password must match'
         ]);

         if( !$validator->passes() ){
                return response()->json(['success' => true, 'type' => 'changePassword', 'status'=>0,'error'=>$validator->errors()->toArray()]);
            }else{

            if(isset($request->profile_user_id)){
             $id  = $request->profile_user_id;
            }else{
             $id  =Auth::user()->id;
            }

             $update = User::find($id)->update(['password'=>\Hash::make($request->new_password)]);

             if( !$update ){
                 return response()->json(['success' => true, 'type' => 'changePassword','status'=>0,'msg'=>'Something went wrong, Failed to update password in db']);
             }else{
                 return response()->json(['success' => true, 'type' => 'changePassword','status'=>1,'message'=>'Password changed successfully.']);
             }
            }
    }

    public function changePasswordSuccess(){

        return redirect('profileedit')->with(['success'=>'Password changed successfully']);
    }

    public function accountsetting(Request $request)
    {
        $users = auth()->user();
        $id  = $users->id;
        $users = UserProfileDetails::where('user_id',  $id)->first();
        return view('dashboards.accountsetting', compact('users'));
    }

    public function privacysetting(Request $request)
    {
        $users = auth()->user();
        $id  = $users->id;
        $users = UserProfileDetails::where('user_id',  $id)->first();
        return view('dashboards.privacysetting', compact('users'));
    }

    public function generalsetting(Request $request)
    {
        $users = auth()->user();
        $id  = $users->id;
        $users = UserProfileDetails::where('user_id',  $id)->first();
        $data['allBlockedUsers'] = BlockedUser::with('getUserDataSelectedColumns')->where('user_id',auth()->user()->id)->get();
        return view('dashboards.generalsetting', compact('users','data'));
    }

    public function aboutInformation(Request $request)
    {
        if($request->type == 'skill'){
            $userWorkAndEducation = new UserWorkAndEducation;
            $user = auth()->user();
            $userWorkAndEducation->user_id = $user->id;
            $userWorkAndEducation->type = $request->type;
            $userWorkAndEducation->name = $request->name;
            $userWorkAndEducation->save();
            return redirect()->back()->with(['success'=>'Professional skill has been added/updated successfully.','pg'=>2]);
        }else{
            $userWorkAndEducation = new UserWorkAndEducation;
            $user = auth()->user();
            $userWorkAndEducation->user_id = $user->id;
            $userWorkAndEducation->type = $request->type;
            $userWorkAndEducation->name = $request->name;
            $userWorkAndEducation->title = $request->title;
            $userWorkAndEducation->city = $request->city;
            $userWorkAndEducation->current_status = $request->has('current_status');
            $userWorkAndEducation->from_year = $request->from_year;
            $userWorkAndEducation->to_year = $request->to_year;
            $userWorkAndEducation->save();
        }
        if($request->type == 'work'){

            return redirect()->back()->with(['success'=>'Work Experience has been added/updated successfully.','pg'=>2]);
        }
        if($request->type == 'education'){
            return redirect()->back()->with(['success'=>'College details have been added/updated successfully.','pg'=>2]);
        }

    }

    public function placeLives(Request $request)
    {
        $currentPlace = $request->currentCity;
        $currentArray = explode(', ', $currentPlace);
        $homeTownPlace = $request->homeTown;
        $homeTownArray = explode(', ', $homeTownPlace);
        $UserPlaceLive = new UserPlaceLive;
        $user = auth()->user();
        $UserPlaceLive->user_id = $user->id;
        $UserPlaceLive->current_city = $currentArray[0];
        $UserPlaceLive->current_state = $currentArray[1];
        $UserPlaceLive->current_country = $currentArray[2];
        $UserPlaceLive->home_town = $homeTownArray[0];
        $UserPlaceLive->home_town_state = $homeTownArray[1];
        $UserPlaceLive->home_town_country = $homeTownArray[2];
        $UserPlaceLive->move_year = $request->move_year;
        $UserPlaceLive->move_month = $request->move_month;
        $UserPlaceLive->save();
        return redirect()->back()->with(['success'=>'Details have been added/updated successfully.','pg'=>2]);

    }

    public function familyRelationship(Request $request)
    {
        if($request->type == 'familymember'){
            $user = auth()->user();
            if($request->relationship == 'Father')
            {
                $checkFather = UserFamilyRelationship::where(['user_id' => $user->id, 'relationship' => 'Father'])->first();
                if($checkFather){
                   // return redirect()->back()->withErrors(['msg' => 'Father relationship is already added!.','pg'=>2]);
                    return response()->json(['msg' => 'Father relationship is already added!.','pg'=>2]);
                }
            }
            if($request->relationship == 'Mother')
            {
                $checkMother = UserFamilyRelationship::where(['user_id' => $user->id, 'relationship' => 'Mother'])->first();
                if($checkMother){
                    //return redirect()->back()->withErrors(['msg' => 'Mother relationship is already added!.','pg'=>2]);
                    return response()->json(['msg' => 'Mother relationship is already added!.','pg'=>2]);
                }
            }
            $family_member  =  implode(",",$request->family_member);
            //check the validation for already relation
            $checkRelation = UserFamilyRelationship::where(['user_id' => $user->id,'family_member' => $family_member, 'type' => 'familymember'])->first();
                if($checkRelation){
                   //update the relation
                    $userfamily = UserFamilyRelationship::find($checkRelation->id)->update(['family_member' => $family_member,'relationship' => $request->relationship]);
                    return response()->json(['success'=>'User Family Member Relation updated.','pg'=>2]);
                }

            $UserFamilyRelationship = new UserFamilyRelationship;
            $UserFamilyRelationship->user_id = $user->id;
            $UserFamilyRelationship->type = $request->type;
            $UserFamilyRelationship->family_member = $family_member;
            $UserFamilyRelationship->relationship = $request->relationship;
            $UserFamilyRelationship->save();
            return response()->json(['success'=>'User Family Member details have been added.','pg'=>2]);
        }
        else{
            UserProfileDetails::where('user_id', auth()->user()->id)->update(['marital_status' => $request->ownstatus]);
            return response()->json(['success'=>'User Own Relationship Status details have been added.','pg'=>2]);
        }

    }

    public function familyRelationshipEdit(Request $request)
    {
        $family_member  =  implode(",",$request->family_member);
        if($request->type == 'familymember'){
            $users = auth()->user();
            $id  = $users->id;
            if($request->relationship != 'Mother' || $request->relationship != 'Father' )
            {

              $userfamily = UserFamilyRelationship::find($request->input('id'))->update(['family_member' => $family_member,'relationship' => $request->get('relationship')]);
              return response()->json(['success'=>'Family Relationship updated.','pg'=>2]);
             }
             return response()->json(['success'=>'Family Relationship already added.','pg'=>2]);
           // return redirect()->back()->with(['success' =>'Family relationship has been updated successfully.','pg'=>2]);
        }

        UserProfileDetails::where('user_id', auth()->user()->id)->update(['marital_status' => $request->get('relationship')]);
       // return redirect()->back()->with(['success' => 'Relationship status has been updated successfully.','pg'=>2]);
       return response()->json(['success'=>'Relationship status has been updated successfully.','pg'=>2]);
    }

    public function familyRelationshipEditSingle(Request $request)
    {
        UserProfileDetails::where('user_id', auth()->user()->id)->update(['marital_status' => $request->get('relationship')]);
       // return redirect()->back()->with(['success' => 'Relationship status has been updated successfully.','pg'=>2]);
       return response()->json(['success'=>'Relationship status has been updated successfully.','pg'=>2]);
    }

    public function getFamilyMember(Request $request)
    {
        $userData = UserFamilyRelationship::where('id', $request->id)->first();
        $userfriend = User::find($userData->family_member);
        $fullName =$userfriend->getFullNameAttribute();
        return ['name' => $fullName, 'relation' => $userData->relationship, 'id' => $userData->id];
    }

    public function getWorkPlace(Request $request)
    {
        $userData = UserWorkAndEducation::where('id', $request->id)->first();
        return ['id' => $userData->id, 'name' => $userData->name, 'title' => $userData->title, 'city' => $userData->city, 'current_status' => $userData->current_status, 'from_year' => $userData->from_year, 'to_year' => $userData->to_year];
    }

    public function getProfessionalSkill(Request $request)
    {
        $userData = UserWorkAndEducation::where('id', $request->id)->first();
        return ['id' => $userData->id, 'name' => $userData->name];
    }

    public function getCollegeDetails(Request $request)
    {
        $userData = UserWorkAndEducation::where('id', $request->id)->first();
        return ['id' => $userData->id, 'name' => $userData->name, 'title' => $userData->title, 'city' => $userData->city, 'current_status' => $userData->current_status, 'from_year' => $userData->from_year, 'to_year' => $userData->to_year];
    }

    public function getLivedPlaces(Request $request)
    {
        $userData = UserPlaceLive::where('id', $request->id)->first();
        return ['id' => $userData->id, 'current_city' => $userData->current_city, 'home_town' => $userData->home_town, 'move_year' => $userData->move_year, 'move_month' => $userData->move_month];
    }

    public function hobbyAndInterest(Request $request)
    {
        $allHobbies = implode(', ',$request->hobbies);
        $UserHobbyInterest = new UserHobbyInterest;
        $user = auth()->user();
        $UserHobbyInterest->user_id = $user->id;
        $UserHobbyInterest->hobbies = $allHobbies;
        $UserHobbyInterest->fav_tv_show = $request->fav_tv_show;
        $UserHobbyInterest->fav_movies = $request->fav_movies;
        $UserHobbyInterest->fav_games = $request->fav_games;
        $UserHobbyInterest->fav_music = $request->fav_music;
        $UserHobbyInterest->fav_books = $request->fav_books;
        $UserHobbyInterest->fav_writters = $request->fav_writters;
        $UserHobbyInterest->save();
        return redirect()->back()->with(['success' => 'User Hobby and Interests details have been added.','pg'=>2]);
    }

    public function hobbyAndInterestEdit(Request $request)
    {
        $users = auth()->user();
        $id  = $users->id;
        $allHobbies = implode(', ',$request->hobbies);
        $UserHobbyInterest = UserHobbyInterest::where('user_id',  $id)->first();
        $UserHobbyInterest->hobbies = $allHobbies;
        $UserHobbyInterest->fav_tv_show = $request->get('fav_tv_show');
        $UserHobbyInterest->fav_movies = $request->get('fav_movies');
        $UserHobbyInterest->fav_games = $request->get('fav_games');
        $UserHobbyInterest->fav_music = $request->get('fav_music');
        $UserHobbyInterest->fav_books = $request->get('fav_books');
        $UserHobbyInterest->fav_writters = $request->get('fav_writters');
        $UserHobbyInterest->save();
        return redirect()->back()->with(['success' => 'User Hobby and Interests details have been Updated.','pg'=>2]);
    }

    public function hobbyAndInterestEditData()
    {
        $users = auth()->user();
        $id  = $users->id;
        $UserHobbyInterest = UserHobbyInterest::where('user_id',  $id)->first();
        return ['hobbies' => $UserHobbyInterest->hobbies, 'fav_tv_show' => $UserHobbyInterest->fav_tv_show, 'fav_movies' => $UserHobbyInterest->fav_movies, 'fav_games' => $UserHobbyInterest->fav_games, 'fav_music' => $UserHobbyInterest->fav_music, 'fav_books' => $UserHobbyInterest->fav_books, 'fav_writters' => $UserHobbyInterest->fav_writters];
    }

    public function aboutInformationUpdate(Request $request)
    {
        if($request->type == 'skill'){
            $userdata = UserWorkAndEducation::find($request->input('id'))->update(['name' => $request->get('name')]);
            return redirect()->back()->with(['success'=>'User skill details have been Update.','pg'=>2]);
        }
        else
        {
            $user = auth()->user();
            $id  = $user->id;
            $userdata = UserWorkAndEducation::find($request->input('id'))->update(['name' => $request->get('name'),'title' => $request->get('title'),'city' => $request->get('city'),'current_status' => ($request->get('current_status') == 'on' ? 1 : 0),'from_year' => $request->get('from_year'),'to_year' => $request->get('to_year')]);
        }
        if($request->type == 'work'){
            return redirect()->back()->with(['success'=>'User work details have been Update.','pg'=>2]);
        }
        if($request->type == 'education'){
            return redirect()->back()->with(['success'=> 'User education details have been Update.','pg'=>2]);
        }
    }

    public function placeLivesUpdate(Request $request)
    {
        $currentPlace = $request->get('currentCity');
        $currentArray = explode(', ', $currentPlace);
        $homeTownPlace = $request->get('homeTown');
        $homeTownArray = explode(', ', $homeTownPlace);
        $userdataUpdate = UserPlaceLive::find($request->input('id'));
        if(!isset($currentArray[1]) && !isset($currentArray[2])){
            $currentArray[1] = $userdataUpdate->current_state;
            $currentArray[2] = $userdataUpdate->current_country;

        }
        if(!isset($homeTownArray[1]) && !isset($homeTownArray[2])){
            $homeTownArray[1] = $userdataUpdate->home_town_state;
            $homeTownArray[2] = $userdataUpdate->home_town_country;
        }
        $user = auth()->user();
        $id  = $user->id;
        $userdata = UserPlaceLive::find($request->input('id'))->update(['current_city' => $currentArray[0], 'current_state' => $currentArray[1], 'current_country' => $currentArray[2], 'home_town' => $homeTownArray[0], 'home_town_state' => $homeTownArray[1], 'home_town_country' => $homeTownArray[2], 'move_year' => $request->get('move_year'), 'move_month' => $request->get('move_month')]);
        return redirect()->back()->with(['success' =>'User Place Lives details have been Update.','pg'=>2]);

    }

    public function userWorkEdu($username){

        $user = User::where('username', $username)->first();
        $data['logged_in_user_id'] = auth()->user()->id;
        $data['self_profile'] = $data['logged_in_user_id'] == $user->id;
        $data['userWorkAndEducation'] = userWorkAndEducation::where(['user_id' => $user->id])->orderBy('id', 'DESC')->get();

        foreach ($data['userWorkAndEducation'] as $userWorkAndEducation){
              $userWorkhtml="";
            if ($userWorkAndEducation->type == 'work'){
            $userWorkhtml .= '<li class="d-flex mb-4 align-items-center justify-content-between">
                               <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <div class="ms-3">
                                        <h6>'.$userWorkAndEducation->name.' (Company)</h6>
                                        <p class="mb-0">'. $userWorkAndEducation->title.' (Position)</p>';

                                        if($userWorkAndEducation->current_status==1){

                                            $userWorkhtml .= '<p class="mb-0">Currently Working</p>';
                                        }

                                        if($userWorkAndEducation->current_status==0){
                                            $userWorkhtml .= '<p class="mb-0">'.$userWorkAndEducation->city.' ('.$userWorkAndEducation->from_year. '-'.$userWorkAndEducation->to_year .')</p>';

                                        }

                                        $userWorkhtml .= '</div>';
                                    if ($data['self_profile']){
                                    $userWorkhtml .= '<div class="edit-relation">
                                            <a href="#" class="d-flex align-items-center">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#add-work-modal-edit" data-id="'.$userWorkAndEducation->id.'" class="material-symbols-outlined md-18 edit-familymember">
                                                    edit
                                                </a>
                                            </a>';

                                                $id = $userWorkAndEducation->id;
                                                $type = 'work';
                                                $userWorkhtml .='<a href="javascript:void(0)" onclick="return delEdulist('.$id.","."'$type'".')"  class="material-symbols-outlined md-18 edit-familymember" >
                                        delete
                                    </a>

                                        </div>';
                                    }
                                    $userWorkhtml .='</div>
                            </div>
                        </li>
                        <hr>';
                    }
            echo  $userWorkhtml;
        }




    }

    public function userstatusList($username){

        $user = User::where('username', $username)->first();
        $data['logged_in_user_id'] = auth()->user()->id;
        $data['self_profile'] = $data['logged_in_user_id'] == $user->id;
        $data['UserProfileDetails'] = UserProfileDetails::where(['user_id' => $user->id])->first();
        $userWorkhtml="";
        $userWorkhtml .='<li class="d-flex mb-4 align-items-center">';
                    if ($data['UserProfileDetails']->marital_status == null){
                        if ($data['self_profile']){


                            $userWorkhtml .='<div class="user-img img-fluid">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#add-relationship-modal" class="material-symbols-outlined md-18">
                                    add
                                </a>
                            </div>
                            <div class="media-support-info ms-3">
                                <h6>Add Your Relationship Status</h6>
                            </div>';
                        }
                    }
                    $userWorkhtml .='</li>
                <li class="d-flex mb-4 align-items-center justify-content-between">
                    <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <div class="ms-3"><h6>'.$data['UserProfileDetails']->marital_status.'</h6></div>';
                            if ($data['self_profile']){
                                $userWorkhtml .='<div class="edit-relation">
                                    <a href="#" class="d-flex align-items-center">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#add-relationship-modal-edit" class="material-symbols-outlined md-18">
                                            edit
                                        </a>
                                    </a>
                                </div>';
                            }
                            $userWorkhtml .='</div>
                    </div>
                </li>';
        echo $userWorkhtml;

    }

    public function userHobbyList($username){

        $user = User::where('username', $username)->first();
        $data['logged_in_user_id'] = auth()->user()->id;
        $data['self_profile'] = $data['logged_in_user_id'] == $user->id;
        $data['UserHobbyInterest'] = UserHobbyInterest::where(['user_id' => $user->id])->first();
        $userWorkhtml="";

       // if(isset($data['UserHobbyInterest']->user_id) && $data['UserHobbyInterest']->user_id == $id ){

         //   if ($data['UserHobbyInterest']){
                $userWorkhtml .='<ul class="suggestions-lists m-0 p-0">';
                        if ($data['self_profile']){
                            if ($data['UserHobbyInterest'] != null){
                            $userWorkhtml .='<li class="d-flex mb-4 align-items-center">
                                <div class="user-img img-fluid">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#add-hobbiesandintrests-modal-edit" class="material-symbols-outlined md-18">
                                        edit
                                    </a>
                                </div>
                                <div class="media-support-info ms-3">
                                    <h6>Edit Your Hobbies and Interests</h6>
                                </div>
                            </li>';
                            }
                        }
                        $userWorkhtml .='</ul>';
         //   }
       // }
            if ($data['UserHobbyInterest'] == null){
                    $userWorkhtml .='<ul class="suggestions-lists m-0 p-0">';
                        if ($data['self_profile']){
                            $userWorkhtml .='<li class="d-flex mb-4 align-items-center">
                                <div class="user-img img-fluid">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#add-hobbiesandintrests-modal" class="material-symbols-outlined md-18">
                                        add
                                    </a>
                                </div>
                                <div class="media-support-info ms-3">
                                    <h6>Add Your Hobbies and Interests</h6>
                                </div>
                            </li>';
                        }
                        $userWorkhtml .='</ul>';
            }



        $userWorkhtml .='<h4 class="mt-2">Hobbies and Interests</h4><hr>';
        if ($data['UserHobbyInterest']){
            $userWorkhtml .= '<h5 class="mb-1"><strong>Hobbies:</strong></h5>';
            if ($data['UserHobbyInterest']->hobbies) {
                $userWorkhtml .= '<p>' . $data['UserHobbyInterest']->hobbies . '</p>';
            }
            if ($data['UserHobbyInterest']->fav_tv_show) {
                $userWorkhtml .= '<h5 class="mt-2 mb-1"><strong>Favorite TV Shows:</strong></h5>
                                <p>' . $data['UserHobbyInterest']->fav_tv_show . '</p>';
            }
            if ($data['UserHobbyInterest']->fav_movies) {
                $userWorkhtml .= '<h5 class="mt-2 mb-1"><strong>Favorite Movies:</strong></h5>
                                <p>' . $data['UserHobbyInterest']->fav_movies . '</p>';
            }
            if ($data['UserHobbyInterest']->fav_games) {
                $userWorkhtml .= '<h5 class="mt-2 mb-1"><strong>Favorite Games:</strong></h5>
                                <p>' . $data['UserHobbyInterest']->fav_games . '</p>';
            }
            if ($data['UserHobbyInterest']->fav_music) {
                $userWorkhtml .= '<h5 class="mt-2 mb-1"><strong>Favorite Music Bands / Artists:</strong></h5>
                                <p>' . $data['UserHobbyInterest']->fav_music . '</p>';
            }
            if ($data['UserHobbyInterest']->fav_books) {
                $userWorkhtml .= '<h5 class="mt-2 mb-1"><strong>Favorite Books:</strong></h5>
                                <p>' . $data['UserHobbyInterest']->fav_books . '</p>';
            }
            if ($data['UserHobbyInterest']->fav_writters) {
                $userWorkhtml .= '<h5 class="mt-2 mb-1"><strong>Favorite Writers:</strong></h5>
                                <p>' . $data['UserHobbyInterest']->fav_writters . '</p>';
            }
        }
        echo $userWorkhtml;

    }

    public function userCollegeList($username){

        $user = User::where('username', $username)->first();
        $data['logged_in_user_id'] = auth()->user()->id;
        $data['self_profile'] = $data['logged_in_user_id'] == $user->id;
        $data['userWorkAndEducation'] = userWorkAndEducation::where(['user_id' => $user->id])->orderBy('id', 'DESC')->get();

        foreach ($data['userWorkAndEducation'] as $userWorkAndEducation){
                $userWorkhtml="";
                if ($userWorkAndEducation->type == 'education'){
                $userWorkhtml .= '<li class="d-flex mb-4 align-items-center justify-content-between">
                <div class="user-img img-fluid">

                </div>
                <div class="w-100">
                    <div class="d-flex justify-content-between">
                        <div class="ms-3">
                            <h6>'.$userWorkAndEducation->name.'</h6>
                            <p class="mb-0">'.$userWorkAndEducation->title.'.</p>
                            <p class="mb-0">';
                                if($userWorkAndEducation->current_status==1){
                                    $userWorkhtml .= $userWorkAndEducation->city.' ('.$userWorkAndEducation->from_year.')';
                                }
                                if($userWorkAndEducation->current_status==0){
                                    $userWorkhtml .= $userWorkAndEducation->city.' ('.$userWorkAndEducation->from_year.'-'.$userWorkAndEducation->to_year.')';
                                }
                                $userWorkhtml .='</p>
                        </div>';
                        if ($data['self_profile']){
                            $userWorkhtml .=' <div class="edit-relation">
                                <a href="#" class="d-flex align-items-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit-college-data" data-id="'. $userWorkAndEducation->id.'" class="material-symbols-outlined md-18 edit-familymember">
                                        edit
                                    </a>
                                </a>';

                                    $id = $userWorkAndEducation->id;
                                    $type = 'education';

                                    $userWorkhtml .='<a href="javascript:void(0)" onclick="return delCollegelist('.$id.","."'$type'".')"  class="material-symbols-outlined md-18 edit-familymember" >
                                delete
                            </a>
                            </div>';
                            }
                            $userWorkhtml .='</div>
                </div>
            </li>
                            <hr>';

                    }
                echo  $userWorkhtml;


        }


    }

    public function userProfSkill($username)
    {
        $user = User::where('username', $username)->first();
        $data['logged_in_user_id'] = auth()->user()->id;
        $data['self_profile'] = $data['logged_in_user_id'] == $user->id;

        $data['userWorkAndEducation'] = userWorkAndEducation::where(['user_id' => $user->id])->orderBy('id', 'DESC')->get();

        foreach ($data['userWorkAndEducation'] as $userWorkAndEducation){
              $userWorkhtml="";
            if ($userWorkAndEducation->type == 'skill'){
            $userWorkhtml .= '<li class="d-flex mb-4 align-items-center justify-content-between">
            <div class="w-100">
                <div class="d-flex justify-content-between">
                    <div class="ms-3">
                        <h6 style="line-height: 0%"><span
                                class="material-symbols-outlined me-2 md-18">done</span>'.$userWorkAndEducation->name.'</h6>
                    </div>';
                    if ($data['self_profile']){
                        $userWorkhtml .='<div class="edit-relation">
                            <a href="#" class="d-flex align-items-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#edit-professional-skills" data-id="'.$userWorkAndEducation->id.'" class="material-symbols-outlined md-18 edit-familymember">
                                    edit
                                </a>
                            </a>';
                            $id = $userWorkAndEducation->id;
                            $type = 'skill';
                            $userWorkhtml .='<a href="javascript:void(0)" onclick="return delSkilllist('.$id.","."'$type'".')"  class="material-symbols-outlined md-18 edit-familymember" >
                            delete
                        </a>
                        </div>';
                    }
                    $userWorkhtml .='</div></div></li><hr>';
                    }
            echo  $userWorkhtml;
        }




    }

    public function userFamilyMemberList($username){
        $user = User::where('username', $username)->first();
        $data['logged_in_user_id'] = auth()->user()->id;
        $data['self_profile'] = $data['logged_in_user_id'] == $user->id;
        $data['UserFamilyRelationship'] = UserFamilyRelationship::where(['user_id' => $user->id])->orderBy('id', 'DESC')->get();
        $userWorkhtml="";

        foreach ($data['UserFamilyRelationship'] as $UserFamilyRelationship){
                    if ($UserFamilyRelationship->type == 'familymember'){
                       if(isset($UserFamilyRelationship->family_member)){
                           $userfriend = User::find($UserFamilyRelationship->family_member);
                           $fullName =$userfriend->getFullNameAttribute();
                        }else{
                           $fullName = '';
                        }

                        $userWorkhtml .='<li class="d-flex mb-4 align-items-center justify-content-between">
                            <div class="user-img img-fluid">

                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <div class="ms-3">
                                        <h6>'.$fullName.'</h6>
                                        <p class="mb-0">'.$UserFamilyRelationship->relationship.'</p>
                                    </div>';
                                    if ($data['self_profile']){
                                        $userWorkhtml .=  '<div class="edit-relation">
                                            <a href="#" class="d-flex align-items-center">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#add-familymember-modal-edit" data-id="'.$UserFamilyRelationship->id.'" class="material-symbols-outlined md-18 edit-familymember">
                                                    edit
                                                </a>
                                            </a>';

                                        $id = $UserFamilyRelationship->id;
                                        $type = 'familymember';


                                        $userWorkhtml .='<a href="javascript:void(0)" onclick="return delFamilyList('.$id.","."'$type'".')"  class="material-symbols-outlined md-18 edit-familymember" >
                                        delete
                                    </a>
                                        </div>';
                                    }
                                    $userWorkhtml .='</div>
                                                    </div>
                                                    </li>';
                    }
        }
        echo  $userWorkhtml;

    }

    public function userLiveList($username){

        $user = User::where('username', $username)->first();
        $data['logged_in_user_id'] = auth()->user()->id;
        $data['self_profile'] = $data['logged_in_user_id'] == $user->id;
        $data['UserPlaceLive'] = UserPlaceLive::where(['user_id' => $user->id])->orderBy('id', 'DESC')->get();
        $userWorkhtml="";

        foreach ($data['UserPlaceLive'] as $UserPlaceLive){
            $type = 'live';
            $userWorkhtml .='<li class="d-flex mb-4 align-items-center justify-content-between">
                  <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <div class="ms-3">
                                <h6>'.$UserPlaceLive->current_city.'</h6>
                                <p class="mb-0">'.$UserPlaceLive->home_town.' ('.$UserPlaceLive->move_month.'-'.$UserPlaceLive->move_year.')</p>
                            </div>';
                            if ($data['self_profile']){
                                $userWorkhtml .='<div class="edit-relation">
                                    <a href="#"
                                        class="d-flex align-items-center">

                                        <a href="#" data-bs-toggle="modal" data-bs-target="#edit-places-modal" data-id="'.$UserPlaceLive->id.'" class="material-symbols-outlined md-18 edit-familymember">
                                            edit
                                        </a>
                                    </a>';

                                        $id = $UserPlaceLive->id;
                                        // $type = 'live';

                                        $userWorkhtml .='<a href="javascript:void(0)" onclick="return delPlaceList('.$id.","."'$type'".')"  class="material-symbols-outlined md-18 edit-familymember" >
                                        delete
                                    </a>
                                </div>';
                            }
                            $userWorkhtml .='</div></div></li>';
                        }
                        echo $userWorkhtml;


    }

    public function get_states(Request $request)
    {
        $states = State::select('id', 'name', 'iso2')->where('country_id', $request->input('country_id'))->orderBy('name', 'asc')->get();

        if(count($states) > 0)
        {
            return ['status' => '1', 'data' => $states];
        }

        return ['status' => '0'];
    }

    public function favoriteFeeds()
    {
        $user = auth()->user();
        $blockedFriends = BlockedUser::where('user_id', $user->id)->pluck('blocked_user_id')->toArray();
        $blockedOtherFriends = BlockedUser::where('blocked_user_id', $user->id)->pluck('user_id')->toArray();

        $blockUser = [...$blockedFriends, ...$blockedOtherFriends];

        $data['feedsWhereNot'] = FavouriteFeed::where('user_id', $user->id)->pluck('feed_id')->toArray();
        $data['feedsAll'] = Feed::with([
            'getUser' => function ($query) use ($blockUser) {
                $query->whereNotIn('id', $blockUser);
            },
            'getUser' => function ($query) use ($blockUser) {
                $query->whereNotIn('id', $blockUser);
            },
            'attachments' => function ($query) use ($blockUser) {
                $query->whereNotIn('user_id', $blockUser);
            },
            'comments.getUserData' => function ($query) use ($blockUser) {
                $query->whereNotIn('id', $blockUser);
            },
            'comments.getReplies.getUserData' => function ($query) use ($blockUser) {
                $query->whereNotIn('id', $blockUser);
            },
            'likes.getUserData' => function ($query) use ($blockUser) {
                $query->whereNotIn('id', $blockUser);
            }
        ])->with('comments.commentLikes')->whereHas('getUser')->whereNotIn('user_id', $blockUser)->where(['type' => 'feed', 'status' => 'Y'])->where('is_deleted','!=' , '1')->orderByDesc('created_at');
        $data['feeds'] = $data['feedsAll']->whereIn('id', $data['feedsWhereNot'])->get();
        return view('dashboards.favoritefeeds',compact('data'));
    }

    public function createAlbum(Request $request)
    {
        $getAlbumDetails = [
            'album_name' => $request->albumName,
            'user_id' => $request->userId,
            'status' => 'Y',
        ];
        $createAlbum = UserAlbum::create($getAlbumDetails);

        foreach($_FILES['albumsImage']['name'] as $key => $imageName){
            if (isset($imageName)){
                $ext = explode('.', $imageName);
                $ext = end($ext);
                $imagePath = $imageName;
                $path = dirname(getcwd()) .'/storage/app/public/images/album-img/'.$request->userId.'/'.$request->albumName.'/'.$imagePath;
                $imageDir = dirname(getcwd()) .'/storage/app/public/images/album-img/'.$request->userId.'/'.$request->albumName;
                if(!is_dir($imageDir))
                {
                    mkdir($imageDir, 0777, true);
                }
                $uploaded = move_uploaded_file($_FILES['albumsImage']['tmp_name'][$key], $path);
                if($uploaded) {
                    $albumid = UserAlbum::where('user_id' , $request->userId)->orderBy('id', 'DESC')->first();
                    // dd($albumid);
                    $getAlbumForImages = [
                        'user_album_id' => $albumid->id,
                        'image_path' => $imagePath,
                        'status' => 'Y',
                    ];
                    $createAlbumImage = UserAlbumImage::create($getAlbumForImages);
                }
            }
        }

        $data['getUserAlbumImage'] = UserAlbumImage::where(['user_album_id' => $albumid->id])->get();
        return response()->json(['imagepath' => $data['getUserAlbumImage'][0], 'count' => count($data['getUserAlbumImage']), 'user_id' => $request->userId, 'album_id' => $albumid->id, 'albumname' =>$request->albumName ], 200);
    }
    public function addPhotoAlbum(Request $request)
    {

        $userAlbum = UserAlbum::find($request->albumId);
        foreach($_FILES['albumsImage']['name'] as $key => $imageName){
            if (isset($imageName)){
                $ext = explode('.', $imageName);
                $ext = end($ext);
                $imagePath = $imageName;
                $path = dirname(getcwd()) .'/storage/app/public/images/album-img/'.$request->userId.'/'.$userAlbum->album_name.'/'.$imagePath;
                $imageDir = dirname(getcwd()) .'/storage/app/public/images/album-img/'.$request->userId.'/'.$userAlbum->album_name;
                if(!is_dir($imageDir))
                {
                    mkdir($imageDir, 0777, true);
                }
                $uploaded = move_uploaded_file($_FILES['albumsImage']['tmp_name'][$key], $path);
                if($uploaded) {
                    // dd($albumid);
                    $getAlbumForImages = [
                        'user_album_id' => $request->albumId,
                        'image_path' => $imagePath,
                        'status' => 'Y',
                    ];
                    $createAlbumImage = UserAlbumImage::create($getAlbumForImages);
                }
            }
        }
        $data['getUserAlbumImage'] = UserAlbumImage::where(['user_album_id' => $request->albumId])->orderBy('id','DESC')->get();
        return response()->json(['Message' => 'Image Added', 'user_id' => $request->userId, 'images' => $data['getUserAlbumImage'] , 'albumdata' => $userAlbum], 200);
    }

    public function showAlbumImages(Request $request){
        $data['getUserAlbumImage'] = UserAlbumImage::where(['user_album_id' => $request->albumId, 'is_deleted' => 0])->get();
        $data['serAlbum'] = UserAlbum::find($request->albumId);
        // return response()->json(['images' => $data['getUserAlbumImage'], 'count' => count($data['getUserAlbumImage']), 'user_id' => auth()->user()->id ], 200);
        return response()->json(['images' => $data['getUserAlbumImage'], 'albumdata' => $data['serAlbum'], 'count' => count($data['getUserAlbumImage']), 'user_id' => $request->userId, 'albumId' => $request->albumId ], 200);
    }

    public function deletePicture(Request $request)
    {
        UserProfileImage::where(['id'=> $request->imagId,'user_id'=> auth()->user()->id])->update(['is_deleted' => 1]);
        // User::where(['id'=> auth()->user()->id])->update(['avatar_location' => null]); //Do not delete this.
        // return redirect()->route('user-profile',  ['username' => auth()->user()->username]);
        return response()->json(['imagId' => $request->imagId, 'user_id'=> auth()->user()->id], 200);
    }

    public function deleteAlbumInnerPicture(Request $request)
    {
        UserAlbumImage::where(['id'=> $request->imagId])->update(['is_deleted' => 1]);
        // User::where(['id'=> auth()->user()->id])->update(['avatar_location' => null]); //Do not delete this.
        // return redirect()->route('user-profile',  ['username' => auth()->user()->username]);
        return response()->json(['imagId' => $request->imagId, 'user_id'=> auth()->user()->id, 'albumId' => $request->albumId], 200);
    }

    public function deleteAlbum(Request $request)
    {
        // dd($request->all());
        UserAlbum::where(['id'=> $request->albumId,'user_id'=> auth()->user()->id])->update(['is_deleted' => 1]);
        // return redirect()->route('user-profile',  ['username' => auth()->user()->username]);
        return response()->json(['albumId' => $request->albumId, 'user_id'=> auth()->user()->id], 200);
    }

    public function friendrequestreadbadge(Request $request)
    {
        $check = FriendRequest::with('getRequestSender')->where(['friend_id' => auth()->user()->id])->where(['status' => 'pending', 'uncheck_request' => '0'])->get();
        if (isset($check))
            {
                foreach($check as $checkSingle){
                    $checkSingle->uncheck_request = '1';
                    $checkSingle->save();
                }
            }
    }

    public function imageCropPost(Request $request)
    {
        $user = auth()->user();
        if($request->type == 'Profile_image'){
            $data = $request->image;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name = $user->id .'-'.time() . '.png';
            // $path = public_path() . "/images/" . $image_name;
            $path = dirname(getcwd()) .'/storage/app/public/images/user/userProfileandCovers/'. $user->id.'/' . $image_name;
            $imageDir = dirname(getcwd()) .'/storage/app/public/images/user/userProfileandCovers/'. $user->id;
            if(!is_dir($imageDir))
            {
                mkdir($imageDir, 0777, true);
            }
            // file_put_contents($path, $data);
            file_put_contents($path, $data);
            User::where('id', $user->id)->update(['avatar_location' => $image_name]);

            $userProfileImage = new UserProfileImage;
            $userProfileImage->user_id = $user->id;
            $userProfileImage->image_path = $image_name;
            $userProfileImage->status = 'Y';
            $userProfileImage->type = 'profile_image';
            $userProfileImage->save();

            $pathforAlbum = dirname(getcwd()).'/storage/app/public/images/album-img/'.$user->id.'/'.'Profile'.'/'.$image_name;
            $imageDirForAlbum = dirname(getcwd()).'/storage/app/public/images/album-img/'.$user->id.'/'.'Profile';
            if(!is_dir($imageDirForAlbum))
            {
                mkdir($imageDirForAlbum, 0777, true);
            }
            // file_put_contents($path, $data);
            file_put_contents($pathforAlbum, $data);

            $checkAlbumExist = UserAlbum::where(['user_id' => $user->id, 'album_name' => "Profile"])->first();
            if($checkAlbumExist){
                $addImageToAlbum = [
                    'user_album_id' => $checkAlbumExist->id,
                    'image_path' => $image_name,
                    'status' => 'Y',
                ];
                $checkAlbumExist->update(['is_deleted' => 0]);
                $createAlbumImage = UserAlbumImage::create($addImageToAlbum);
                // return redirect()->route('user-profile',  ['username' => $user->username, 'msg' => 'Update Existing Album']);
                return response()->json(['status' => true, 'message' => 'Update Existing Album'], 200);
            }
            else
            {
                $profilePhotoAlbum = [
                    'album_name' => "Profile",
                    'user_id' => $user->id,
                    'status' => 'Y',
                ];
                $createAlbum = UserAlbum::create($profilePhotoAlbum);

                $albumid = UserAlbum::where(['user_id' => $user->id, 'album_name' => 'Profile'])->orderBy('id', 'DESC')->first();
                $getAlbumForImages = [
                    'user_album_id' => $albumid->id,
                    'image_path' => $image_name,
                    'status' => 'Y',
                ];
                $createAlbumImage = UserAlbumImage::create($getAlbumForImages);
            }
            // return redirect()->route('user-profile',  ['username' => $user->username]);
            return response()->json(['status' => true, 'message' => 'Profile Images Added Successfully'], 200);
        }
        if($request->type == 'Cover_image'){
            $data = $request->image;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name = $user->id .'-'.time() . '.png';
            // $path = public_path() . "/images/" . $image_name;
            $pathforUser = dirname(getcwd()).'/storage/app/public/images/user/userProfileandCovers/'.$user->id.'/'.'cover'.'/'.$image_name;
            $imageDirForUser = dirname(getcwd()).'/storage/app/public/images/user/userProfileandCovers/'.$user->id.'/'.'cover';
            if(!is_dir($imageDirForUser))
            {
                mkdir($imageDirForUser, 0777, true);
            }
            file_put_contents($pathforUser, $data);

            User::where('id', $user->id)->update(['cover_image' => $image_name]);

            $userProfileImage = new UserProfileImage;
            $userProfileImage->user_id = $user->id;
            $userProfileImage->image_path = $image_name;
            $userProfileImage->status = 'Y';
            $userProfileImage->type = 'cover_image';
            $userProfileImage->save();

            $pathforAlbum = dirname(getcwd()).'/storage/app/public/images/album-img/'.$user->id.'/'.'Cover'.'/'.$image_name;
            $imageDirForAlbum = dirname(getcwd()).'/storage/app/public/images/album-img/'.$user->id.'/'.'Cover';
            if(!is_dir($imageDirForAlbum))
            {
                mkdir($imageDirForAlbum, 0777, true);
            }
            // file_put_contents($path, $data);
            file_put_contents($pathforAlbum, $data);
            $checkAlbumExist = UserAlbum::where(['user_id' => $user->id, 'album_name' => "Cover"])->first();
            if($checkAlbumExist){
                $addImageToAlbum = [
                    'user_album_id' => $checkAlbumExist->id,
                    'image_path' => $image_name,
                    'status' => 'Y',
                ];
                $checkAlbumExist->update(['is_deleted' => 0]);
                $createAlbumImage = UserAlbumImage::create($addImageToAlbum);
                return redirect()->route('user-profile',  ['username' => $user->username, 'msg' => 'Update Existing Album']);
            }
            else
            {
                $coverPhotoAlbum = [
                    'album_name' => "Cover",
                    'user_id' => $user->id,
                    'status' => 'Y',
                ];
                $createAlbum = UserAlbum::create($coverPhotoAlbum);
                // file_put_contents($path, $data);
                file_put_contents($pathforAlbum, $data);
                $albumid = UserAlbum::where(['user_id' => $user->id])->orderBy('id', 'DESC')->first();
                $getAlbumForImages = [
                    'user_album_id' => $albumid->id,
                    'image_path' => $image_name,
                    'status' => 'Y',
                ];
                $createAlbumImage = UserAlbumImage::create($getAlbumForImages);
                return redirect()->route('user-profile',  ['username' => $user->username, 'msg' => 'Add New Album']);
            }

        }
    }

    public function store(UserRequest $request)
    {
        $request['password'] = bcrypt($request->password);

        $request['username'] = $request->username ?? stristr($request->email, "@", true) . rand(100,1000);

        $user = User::create($request->all());


        //storeMediaFile($user,$request->profile_image, 'profile_image');

        // $user->assignRole('user');

        // Save user Profile data...
        $user->userProfile()->create($request->userProfile);

        return redirect()->route('users.index')->withSuccess(__('message.msg_added',['name' => __('users.store')]));
    }

    public function show($id)
    {
        $data = User::with('userProfile')->findOrFail($id);

        $profileImage = getSingleMedia($data, 'profile_image');

        return view('users.profile', compact('data', 'profileImage'));
    }

    public function userlist()
    {
       $users =User::all();
       return view('user.user_list', compact('users'));
    }

    public function datatable(Request $request)
    {
        $users =User::all();
        return view('ui.datatable', compact('users'));
    }

    public function friendrequest()
    {
        $data['friendsList'] = FriendRequest::with('getRequestSender')->where(['friend_id' => auth()->user()->id])->where('status' , 'pending')->get();
        return view('dashboards.friendrequest',compact('data'));
    }

}
