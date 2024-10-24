<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserFamilyRelationship;
use App\Models\UserHobbies;
use App\Models\UserHobbyInterest;
use App\Models\UserPlaceLive;
use App\Models\UserProfileDetail;
use App\Models\UserProfileDetails;
use App\Models\UserProfileImage;
use App\Models\UserWorkAndEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class UserInformationController extends Controller
{
    public function saveHobbiesAndInterests(Request $request){
        $data = $request->all();
        $data['hobbies'] = implode(', ',$request->hobbies);
        $UserHobbyInterest =UserHobbyInterest::create($data);
        return response()->json(['message' =>'Hobby and Interests details saved successfully', 'UserHobbyInterest' =>$UserHobbyInterest, 'success' => true]);
    } 


    public function updateHobbiesAndInterests(Request $request){
        $id  = $request->user_id;
        $UserHobbyInterest = UserHobbyInterest::where('user_id',  $id)->first();
        if(!$UserHobbyInterest){
            $data = $request->all();
            // $data['hobbies'] = implode(', ',$request->hobbies);
            $UserHobbyInterest =UserHobbyInterest::create($data);
            $UserHobbyInterest = UserHobbyInterest::where('user_id',  $id)->first();
            return response()->json(['message' =>'Hobby and Interests details saved successfully', 'UserHobbyInterest' =>$UserHobbyInterest, 'success' => true]);
        }
        if($request->hobbies)
        $UserHobbyInterest->hobbies = $request->get('hobbies');
        if($request->fav_tv_show)
        $UserHobbyInterest->fav_tv_show = $request->get('fav_tv_show');
        if($request->fav_movies)
        $UserHobbyInterest->fav_movies = $request->get('fav_movies');
        if($request->fav_games)
        $UserHobbyInterest->fav_games = $request->get('fav_games');
        if($request->fav_music)
        $UserHobbyInterest->fav_music = $request->get('fav_music');
        if($request->fav_books)
        $UserHobbyInterest->fav_books = $request->get('fav_books');
        if($request->fav_writters)
        $UserHobbyInterest->fav_writters = $request->get('fav_writters');
        $UserHobbyInterest->save();
        $UserHobbyInterest = UserHobbyInterest::where('user_id',  $id)->first();
        return response()->json(['message' =>'Hobby and Interests details updated successfully', 'UserHobbyInterest' =>$UserHobbyInterest, 'success' => true]);
    }

    public function getHobbiesAndInterests($userId){
        $UserHobbyInterest = UserHobbyInterest::where('user_id',  $userId)->first();
        return response()->json(['UserHobbyInterest' =>$UserHobbyInterest, 'success' => true]);
    }

    public function savePlacedYouLived(Request $request){
        $data = $request->all();

        $user = UserPlaceLive::create([
            'user_id' => $data['user_id'],
            'current_city' => $data['current_city'],
            'home_town' => $data['home_town'],
            'move_year' => $data['move_year'],
            'move_month' => $data['move_month'],
        ]);
        return response()->json(['message' =>'User placed saved successfully', 'success' => true ,'user' => $user]);
       
    }

    public function updatePlacedYouLived(Request $request){
        $data = $request->all();

        $user = UserPlaceLive::find(request('id'));

        if ($user !== null) {
            if(isset($data['current_city']))
            $user->current_city =$data['current_city'];
            if(isset($data['home_town']))
            $user->home_town =$data['home_town'];
            if(isset($data['move_year']))
            $user->move_year =$data['move_year'];
            if(isset($data['move_month']))
            $user->move_month =$data['move_month'];

            $user->save();
        }
        return response()->json(['message' =>'User placed updated successfully', 'success' => true, 'user' => $user]);
    }

    public function getPlacedYouLived($userId){
        $user = User::find($userId);
        if(!$user){
            return response()->json(['message' =>'User does not exists', 'success' => false],201);
        }
        $userLivedPlace = UserPlaceLive::where('user_id',  $userId)->get();
        return response()->json(['user_lived_places' =>$userLivedPlace, 'success' => true]);
    }

    public function saveWorkAndEducation(Request $request){
        $data = $request->all();

        $user = UserWorkAndEducation::where('user_id', request('user_id'))->first();
     
        $user = UserWorkAndEducation::create([
            'user_id' => $data['user_id'],
            'type' => $data['type'],
            'name' => $data['name'],
            'title' => $data['title'],
            'city' => $data['city'],
            'current_status' => $data['current_status'],
            'from_year' => $data['from_year'],
            'to_year' => $data['current_status'] == 1 ? null :  $data['to_year'],
        ]);
        return response()->json(['message' =>'User work and education saved successfully', 'success' => true ,'user' => $user]);
        
       
    }

    public function updateWorkAndEducation(Request $request){
        $data = $request->all();

        $userRecord = UserWorkAndEducation::find(request('id'));
        if(!$userRecord){
            return response()->json(['message' =>'User record does not exists', 'success' => false], 201);
        }
        if ($userRecord !== null) {
            if(isset($data['type']))
            $userRecord->type =$data['type'];
            if(isset($data['name']))
            $userRecord->name =$data['name'];
            if(isset($data['title']))
            $userRecord->title =$data['title'];
            if(isset($data['city']))
            $userRecord->city =$data['city'];
            if(isset($data['current_status']))
            $userRecord->current_status =$data['current_status'];
            if(isset($data['from_year']))
            $userRecord->from_year =$data['from_year'];
            if(isset($data['to_year']))
            $userRecord->to_year =$data['current_status'] == 1 ? null :  $data['to_year'];

            $userRecord->save();
            return response()->json(['message' =>'User work and education updated successfully', 'success' => true, 'user' => $userRecord]);
        }
    } 

    public function getWorkAndEducation($userId){
        $user = User::find($userId);
        if(!$user){
            return response()->json(['message' =>'User does not exists', 'success' => false], 201);
        }

        $UserWorkAndEducations = UserWorkAndEducation::where('user_id',  $userId)->get();
        return response()->json(['user_work_and_educations' =>$UserWorkAndEducations, 'success' => true]);
    }

    public function saveRelationshipDetails(Request $request){
        $data = $request->all();

        $profileDetails = UserProfileDetails::where('user_id', $data['user_id'])->select('user_id','marital_status')->first();
        if($data['type'] == 'ownstatus'){
            $profileDetails->marital_status = $data['relationship'];
            $profileDetails->save();
            $user = UserFamilyRelationship::where('user_id', request('user_id'))->first();
            return response()->json(['message' =>'User marital status saved successfully', 'success' => true, 'user' => $user , 'profileDetails' =>$profileDetails]);
        }
        $data['relationship'] = Str::ucfirst($data['relationship']);
        //check for duplicate relationships
        $fatherRelation = UserFamilyRelationship::where('user_id', request('user_id'))->where('relationship' ,'Father')->first();
        $motherRelation = UserFamilyRelationship::where('user_id', request('user_id'))->where('relationship' ,'Mother')->first();

        if($data['relationship']== 'Father' && $fatherRelation != null){
            return response()->json(['message' =>'Father relationship is already added', 'success' => false], 201);
        }elseif($data['relationship'] == 'Mother' && $motherRelation != null){
            return response()->json(['message' =>'Mother relationship is already added', 'success' => false], 201);
        }
        $record = UserFamilyRelationship::where(['family_member' => $request->family_member,'user_id' => $request->user_id, 'type' =>  'familymember'])->first();
        if($record){
            $record->relationship = $request->relationship;
            $record->save();
            return response()->json(['message' =>'User family relationship updated successfully', 'success' => true , 'profileDetails' =>$profileDetails]);
        }
        $user = UserFamilyRelationship::create([
            'user_id' => $data['user_id'],
            'family_member' => $data['family_member'],
            'relationship' => $data['relationship'],
            'type' => $data['type']
        ]);
        return response()->json(['message' =>'User family relationship saved successfully', 'success' => true ,'user' => $user , 'profileDetails' =>$profileDetails]);
    }

    public function updateRelationshipDetails(Request $request){
        $data = $request->all();
        $profileDetails = UserProfileDetails::where('user_id', $data['user_id'])->select('user_id','marital_status')->first();
        if($data['type'] == 'ownstatus'){
            $profileDetails->marital_status = $data['relationship'];
            $profileDetails->save();
            $user = UserFamilyRelationship::where('user_id', request('user_id'))->first();
            return response()->json(['message' =>'User marital status updated successfully', 'success' => true, 'user' => $user , 'profileDetails' =>$profileDetails]);
        }
        $userRecord = UserFamilyRelationship::find(request('id'));
        if(!$userRecord){
            return response()->json(['message' =>'User record does not exists', 'success' => false], 201);
        }
        if ($userRecord !== null) {
            if(isset($data['user_id']))
            $userRecord->user_id =$data['user_id'];
            if(isset($data['family_member']))
            $userRecord->family_member =$data['family_member'];
            if(isset($data['relationship']))
            $userRecord->relationship =$data['relationship'];
            if(isset($data['type']))
            $userRecord->type =$data['type'];

            $userRecord->save();
            return response()->json(['message' =>'User family relationship updated successfully', 'success' => true, 'user' => $userRecord, 'profileDetails' =>$profileDetails]);
        }
    } 

    public function getRelationshipDetails($userId){
        $user = User::find($userId);
        if(!$user){
            return response()->json(['message' =>'User does not exists', 'success' => false], 201);
        }
        $profileDetails = UserProfileDetails::where('user_id', $userId)->select('user_id','marital_status')->first();
        $userRelationalshipDetails = UserFamilyRelationship::where('user_id',  $userId)->where('type' , '!=' , 'ownstatus')->get();
        if(isset($userRelationalshipDetails) && count($userRelationalshipDetails) > 0){
            foreach($userRelationalshipDetails as $userRelation){
                $userRelation->userDetails = User::find($userRelation->family_member, ['id','first_name','last_name','avatar_location','cover_image','username','bio']);
            }
        }
        return response()->json(['user_relationalship_details' =>$userRelationalshipDetails, 'profileDetails' =>$profileDetails ,'success' => true]);
    }

    public function updateOwnStatus(Request $request){
        $profileDetails = UserProfileDetails::where('user_id', $request->user_id)->select('id','user_id','marital_status')->first();

        $user = UserFamilyRelationship::where('user_id', request('user_id'))->first();
        if($profileDetails){
            $profileDetails->marital_status = $request->marital_status;
            $profileDetails->save();
            return response()->json(['message' =>'User marital status saved successfully', 'success' => true, 'profileDetails' =>$profileDetails, 'user' => $user ]);
        }
    }

    public function saveSocialDetails(Request $request){
        $data = $request->all();

        $userRecord = UserProfileDetails::where('user_id', request('user_id'))->first();
        
        if ($userRecord !== null) {
            if(isset($data['altemail']))
            $userRecord->altemail =$data['altemail'];
            if(isset($data['language_eng']))
            $userRecord->language_eng =$data['language_eng'];
            if(isset($data['language_chinese']))
            $userRecord->language_chinese =$data['language_chinese'];
            if(isset($data['language_french']))
            $userRecord->language_french =$data['language_french'];
            if(isset($data['language_spanish']))
            $userRecord->language_spanish =$data['language_spanish'];
            if(isset($data['language_arabic']))
            $userRecord->language_arabic =$data['language_arabic'];
            if(isset($data['language_italian']))
            $userRecord->language_italian =$data['language_italian'];
            if(isset($data['twitter_link']))
            $userRecord->twitter_link =$data['twitter_link'];
            if(isset($data['instagram_link']))
            $userRecord->instagram_link =$data['instagram_link'];
            if(isset($data['google_link']))
            $userRecord->google_link =$data['google_link'];
            if(isset($data['youtube_link']))
            $userRecord->youtube_link =$data['youtube_link'];
            if(isset($data['facebook_link']))
            $userRecord->facebook_link =$data['facebook_link'];

            $userRecord->save();
            return response()->json(['message' =>'User social details updated successfully', 'success' => true, 'user' => $userRecord]);
        }
        $userRecord = UserProfileDetails::create([
            'user_id' => $data['user_id'],
            'altemail' => $data['altemail'],
            'language_eng' => $data['language_eng'],
            'language_chinese' => $data['language_chinese'],
            'language_french' => $data['language_french'],
            'language_spanish' => $data['language_spanish'],
            'language_arabic' => $data['language_arabic'],
            'language_italian' => $data['language_italian'],
            'twitter_link' => $data['twitter_link'],
            'instagram_link' => $data['instagram_link'],
            'youtube_link' => $data['youtube_link'],
            'google_link' => $data['google_link'],
            'facebook_link' => $data['facebook_link'],

        ]);
        return response()->json(['message' =>'User social details saved successfully', 'success' => true ,'user_social_details' => $userRecord]);
    }


    public function getSocialDetails($userId){
        $user = User::find($userId);
        if(!$user){
            return response()->json(['message' =>'User does not exists', 'success' => false], 201);
        }

        $userRelationalshipDetails = UserProfileDetails::where('user_id',  $userId)->select('id', 'user_id', 'altemail','language_eng','language_chinese','language_french','language_spanish','language_arabic','language_italian','twitter_link','instagram_link','youtube_link','google_link','facebook_link')->get();
        return response()->json(['user_relationalship_details' =>$userRelationalshipDetails, 'success' => true]);
    }

    public function viewOtherUserAbout($userId){
        $user = User::find($userId);
        if(!$user){
            return response()->json(['message' =>'User does not exists', 'success' => false], 201);
        }
        $data['profileDetails'] = UserProfileDetails::where('user_id', $userId)->select('user_id','marital_status')->first();
        $data['userLivedPlace'] = UserPlaceLive::where('user_id',  $userId)->get();
        $data['userHobbyInterest'] = UserHobbyInterest::where('user_id',  $userId)->first();
        $data['userWorkAndEducations'] = UserWorkAndEducation::where('user_id',  $userId)->get();
        $data['userRelationalshipDetails'] = UserFamilyRelationship::with('userDetails')->where('user_id',  $userId)->get();
        return response()->json(['user_about' =>$data, 'success' => true]);
    }

    public function deleteUserAbout($id, $type){
        
        if($type=='family_member'){
            $data = UserFamilyRelationship::find($id);
            if(isset($data)){
                    $data->delete();
                    return response()->json(['message'=>'Family Relationship record has been deleted.' ,'success' => true]);
            }

        }

        if($type=='own_status'){
            $data = UserFamilyRelationship::where(['id' =>$id , 'type' => 'ownstatus'])->first();
            if(isset($data)){
                    $data->delete();
                    return response()->json(['message'=>'User own status has been deleted.' ,'success' => true]);
            }

        }
        
        if($type=='work'){
            $data = userWorkAndEducation::find($id);
            if(isset($data)){
                    $data->delete();
                    return response()->json(['message'=>'Work and Education record has been deleted.' ,'success' => true]);
            }

        }
        if($type=='lived_place'){
            $data = UserPlaceLive::find($id);
            if(isset($data)){
                    $data->delete();
                    return response()->json(['message'=>'Place Lived record has been deleted.' ,'success' => true]);
            }

        }
        if($type=='hobbies_and_interest'){
            $data = UserHobbyInterest::find($id);
            if(isset($data)){
                    $data->delete();
                    return response()->json(['message'=>'Hobby and Interest record has been deleted.' ,'success' => true]);
            }

        }
        
        return  response()->json(['message'=> 'Record not found.' ,'success' => false]);
    }

    public function getUserProfileImagesAndCovers($userId){
        $data['profileImages'] = UserProfileImage::where(['user_id' => $userId, 'status' => 'Y', 'type' => 'profile_image', 'is_deleted' => 0])->get();
        $data['coverImages'] = UserProfileImage::where(['user_id' => $userId, 'status' => 'Y', 'type' => 'cover_image' , 'is_deleted' => 0])->get();
        return response()->json(['UserAllImages'=>$data ,'success' => true],200);
    }

    public function getHobbiesList(){
        $hobbiesList = UserHobbies::where('status','Y')->select('id', 'hobbies')->get();
        return response()->json(['hobbiesList'=>$hobbiesList ,'success' => true],200);
    }

    public function recentlyAddedFriends($userId){
        $user = User::find($userId);
        if(!$user){
            return response()->json(['message' =>'User does not exists', 'success' => false], 201);
        }

        $data['recentlyAddedFriends'] = $user->getRecentlyAddedFriends(['user_id' => $user->id]);
        foreach ($data['recentlyAddedFriends'] as $friend) {
            $friend->name = $friend->first_name. ' '. $friend->last_name;
            $friend->save();
        }
        if(isset($data['recentlyAddedFriends'])){
            $data['count'] = count($data['recentlyAddedFriends']);
        }
        return response()->json(['data'=>$data ,'success' => true],200);
    }
}