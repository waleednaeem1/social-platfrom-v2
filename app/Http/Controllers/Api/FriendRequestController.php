<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FriendRequest;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function viewedFriendRequests(Request $request){
        if(count($request->friend_requests) > 0){
            foreach($request->friend_requests as $friendRequestId){
                $friendRequest = FriendRequest::find($friendRequestId);
                if(isset($friendRequest)){
                    $friendRequest->uncheck_request = '0';
                    $friendRequest->save();
                }
            }
            return response()->json(['success' => true, 'message' => 'requests viewed successfully'],200);
        }else{
            return response()->json(['success' => false, 'message' => 'array is empty'],201);
        }
    }
}
