<?php

namespace App\Http\Controllers;
use App\Models\User;
// use App\Models\Friend;
// use App\Models\FriendRequest;

use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function getFriends($user_id)
    {
        $u = User::find($user_id);
        $data['users'] = $u->getAllFriends(['user_id' => $user_id]); 
        return response()->json($data['users'], 200);
    }

    public function getFriendRequest($user_id)
    {
        $data['users'] = User::with('getfriendrequest.getuser')->where('id', $user_id)->get('id');
        return response()->json(array([ 'users' => $data['users'] ]), 200);
    }
}
