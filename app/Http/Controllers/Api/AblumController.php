<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAlbum;
use App\Models\UserAlbumImage;
use App\Models\UserProfileImage;
use Illuminate\Http\Request;

class AblumController extends Controller
{
    public function createAlbum(Request $request)
    {
        $UserAlbum = new UserAlbum;
        $UserAlbum->album_name = $request->album_name;
        $UserAlbum->user_id = $request->user_id;
        $UserAlbum->status = 'Y';
        $UserAlbum->save();


        if (isset($_FILES['album_image']))
        {
            $imageName = $_FILES['album_image']['name'];
            $ext = explode('.', $imageName);
                $ext = end($ext);
                $path = dirname(getcwd()) .'/storage/app/public/images/album-img/'.$request->user_id.'/'.$request->album_name.'/'.$imageName;
                $imageDir = dirname(getcwd()) .'/storage/app/public/images/album-img/'.$request->user_id.'/'.$request->album_name;
            if(!is_dir($imageDir))
            {
                mkdir($imageDir, 0777, true);
            }
            move_uploaded_file($_FILES['album_image']['tmp_name'], $path);

            $album = UserAlbum::where(['user_id' => $request->user_id, 'album_name' => $request->album_name])->first();

            $data = [
                'user_album_id' => $album->id,
                'image_path' => $imageName,
                'status' => 'Y',
            ];
            UserAlbumImage::create($data);
        }

        return response()->json(array(['success' => true, 'message' => 'User Album create successfully' , 'UserAlbumId' => $UserAlbum->id]),200);

    }

    public function uploadAblumImages(Request $request)
    {
        $album = UserAlbum::find($request->album_id);
        //saving attachments of the feed
        try{
            if (isset($_FILES['album_image'])) {
                $imageName = $_FILES['album_image']['name'];
                $ext = explode('.', $imageName);
                $ext = end($ext);
                $imagePath = $imageName;
                $path = dirname(getcwd()) .'/storage/app/public/images/album-img/'.$request->user_id.'/'.$album->album_name.'/'.$imageName;
                $imageDir = dirname(getcwd()) .'/storage/app/public/images/album-img/'.$request->user_id.'/'.$album->album_name;

                if(!is_dir($imageDir))
                {
                    mkdir($imageDir, 0777, true);
                }
                move_uploaded_file($_FILES['album_image']['tmp_name'], $path);
                $album = UserAlbum::where('user_id' , $request->user_id)->first();
                if (isset($album) && $album !=null) {


                    $data = [
                        'user_album_id' => $request->album_id,
                        'image_path' => $imagePath,
                        'status' => 'Y',
                    ];
                    UserAlbumImage::create($data);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 201);
        }

        return response()->json(['success' => true,  'message' => 'User Album create successfully' , 'UserAlbumId' => $request->album_id], 200);
    }
    public function showAlbumImages($albumId,$userId){

        $data['getUserAlbumImage'] = UserAlbumImage::where(['user_album_id' => $albumId])->where('is_deleted', '!=', 1)->get();
        $data['getUserAlbum'] = UserAlbum::find($albumId);
        // return response()->json(['images' => $data['getUserAlbumImage'], 'count' => count($data['getUserAlbumImage']), 'user_id' => auth()->user()->id ], 200);
        return response()->json(['images' => $data['getUserAlbumImage'], 'count' => count($data['getUserAlbumImage']), 'user_id' => $userId , 'album' =>$data['getUserAlbum']], 200);
    }

    public function addPhotoToAlbum(Request $request)
    {
        $userAlbum = UserAlbum::find($request->album_id);
        $imageName = $_FILES['album_image']['name'];
        if (isset($imageName)){
            $ext = explode('.', $imageName);
            $ext = end($ext);
            $imagePath = $imageName;
            $path = dirname(getcwd()) .'/storage/app/public/images/album-img/'.$request->user_id.'/'.$userAlbum->album_name.'/'.$imagePath;
            $imageDir = dirname(getcwd()) .'/storage/app/public/images/album-img/'.$request->user_id.'/'.$userAlbum->album_name;
            if(!is_dir($imageDir))
            {
                mkdir($imageDir, 0777, true);
            }
            move_uploaded_file($_FILES['album_image']['tmp_name'], $path);

            UserAlbumImage::create( [
                'user_album_id' => $request->album_id,
                'image_path' => $imagePath,
                'status' => 'Y',
            ]);

        }

        return response()->json(['success' => true, 'message' => 'Image Added successfully'], 200);
    }

    public function deleteAlbumImage($imageId)
    {
        if(request()->segment(count(request()->segments())) == 'album'){
            $userAlbumImage = UserAlbumImage::find($imageId);
            if(isset($userAlbumImage)){
                if($userAlbumImage->is_deleted == 1){
                    return response()->json(['success' => true, 'message' => 'Album image already deleted.'], 200);
                }
                $userAlbumImage->is_deleted = 1;
                $userAlbumImage->save();
                return response()->json(['success' => true, 'message' => 'Album image deleted succesfully.'], 200);
            }
            else{
                return response()->json(['success' => false, 'message' => 'Album image does not exists.'], 201);
            }
        }

        if(request()->segment(count(request()->segments())) == 'profile'){
            $userProfileImage = $userAlbumImage = UserProfileImage::find($imageId);
            if(isset($userProfileImage)){
                if($userProfileImage->is_deleted == 1){
                    return response()->json(['success' => true, 'message' => 'Profile image already deleted.'], 200);
                }
                $userProfileImage->is_deleted = 1;
                $userProfileImage->save();
                return response()->json(['success' => true, 'message' => 'Profile image deleted succesfully.'], 200);
            }else{
                return response()->json(['success' => false, 'message' => 'Profile image does not exists.'], 201);
            }
        }
    }
    public function deleteAlbum(Request $request)
    {
        $userAlbum = UserAlbum::where(['id'=> $request->album_id,'user_id'=> $request->user_id])->first();
        if(isset($userAlbum)){
            $userAlbum->is_deleted = 1;
            $userAlbum->save();
            return response()->json(['success' => true, 'message' => 'album deleted succesfully.'], 200);
        }else{
            return response()->json(['success' => false, 'message' => 'album does not exists.'], 201);
        }
    }

    public function userAllAlbums($userId){
        $user = User::find($userId);
        if(!$user){
            return response()->json(['success' => false, 'message' => 'user does not exists.'], 201);
        }
        $userAlbums = UserAlbum::where(['user_id' => $user->id, 'is_deleted' => 0])->with('getAlbumImages:id,user_album_id,image_path,created_at')->select('id', 'user_id', 'album_name','created_at')->get();
        $coverImages = UserProfileImage::where(['user_id' => $userId, 'status' => 'Y', 'type' => 'cover_image'])->get();
        $profileImages = UserProfileImage::where(['user_id' => $userId, 'status' => 'Y', 'type' => 'profile_image'])->get();
        $userAlbums = [...$userAlbums , ...$profileImages, ...$coverImages];
        return response()->json(['success' => true, 'user_all_albums' => $userAlbums], 200);
    }
    public function singleAlbums($userId, $album_id){
        $user = User::find($userId);
        if(!$user){
            return response()->json(['success' => false, 'message' => 'user does not exists.'], 201);
        }
        $checkAlbum = UserAlbum::find($album_id);
        if(!$checkAlbum){
            return response()->json(['success' => false, 'message' => 'Album does not exists.'], 201);
        }
        $userAlbums = UserAlbum::where(['id' => $album_id, 'user_id' => $user->id, 'is_deleted' => 0])->with('getAlbumImages:id,user_album_id,image_path,created_at')->select('id', 'user_id', 'album_name','created_at')->get();
        if(!$userAlbums->isEmpty()){
            return response()->json(['success' => true, 'user_single_album' => $userAlbums], 200);
        }else{
            return response()->json(['success' => false, 'message' => 'You enter wrong user_name or album_id. Please check again.'], 200);
        }
    }

    public function deleteAllAlbum($userId){
        $userAlbum = UserAlbum::where('user_id', $userId)->get();
        if(count($userAlbum) > 0){
            $userAlbum->each->delete();
            return response()->json(['success' => true, 'message' => 'albums deleted succesfully.'], 200);
        }else{
            return response()->json(['success' => false, 'message' => 'album does not exists.'], 201);
        }
    }

}
