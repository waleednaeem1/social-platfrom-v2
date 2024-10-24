<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfileImage;
use Illuminate\Http\Request;

class UserImagesController extends Controller
{
    public function getAllCoverPics($userId){
        $coverImages = UserProfileImage::where(['user_id' => $userId, 'status' => 'Y', 'type' => 'cover_image'])->get();
        return response()->json(['coverImages'=>$coverImages ,'success' => true],200);
    }
    
    public function getAllProfilePics($userId){
        $profileImages = UserProfileImage::where(['user_id' => $userId, 'status' => 'Y', 'type' => 'profile_image'])->get();
        return response()->json(['profileImages'=>$profileImages ,'success' => true],200);
    }
}
