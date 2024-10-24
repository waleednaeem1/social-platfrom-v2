<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfileDetails;
use Illuminate\Http\Request;

class ProfilePrivacyController extends Controller
{
    public function changeProfilePrivacy(Request $request){
        $userProfileData = UserProfileDetails::where('user_id', $request->userId)->first();
        if($userProfileData){
            if(isset($request->privacy)){
                $userProfileData->your_profile = $request->privacy;
            }

            if(isset($request->account_privacy)){
                $userProfileData->account_privacy = $request->account_privacy;
            }

            if(isset($request->content_notification)){
                $userProfileData->content_notification = $request->content_notification;
            }

            $userProfileData->save();
            return response()->json(['message' => 'Privacy updated successfully.', 'success' => true ], 200);
        }else{
            return response()->json(['message' => 'User does not exists.', 'success' => false ], 201);
        }
    }

    public function changeAccountPrivacy(Request $request){

        $userProfileData = UserProfileDetails::where('user_id', $request->user_id)->first();
        if($userProfileData){
            $userProfileData->your_profile = $request->your_profile ? $request->your_profile: 'public';
            $userProfileData->story_sharing = $request->story_sharing;
            $userProfileData->your_message = $request->your_message ? $request->your_message: 'anyone';
            $userProfileData->account_privacy = $request->account_privacy ? $request->account_privacy: 0;
            $userProfileData->content_notification = $request->login_notification ? $request->login_notification: 'enable';
  
            $userProfileData->save();
            return response()->json(['message' => 'Account privacy changed successfully.', 'success' => true ], 200);
        }else{
            return response()->json(['message' => 'User does not exists.', 'success' => false ], 201);
        }
    }

    public function getAccountPrivacy($userId){
        $user_privacy = UserProfileDetails::where('user_id', $userId)->select('id', 'user_id','your_message','account_privacy','activity_status','story_sharing','photo_of_you', 'your_profile', 'content_notification')->first();
        if($user_privacy){
            return response()->json(['user_privacy' => $user_privacy, 'success' => true ], 200);
        }else{
            return response()->json(['message' => 'User does not exists.', 'success' => false ], 201);
        }
    }
}
