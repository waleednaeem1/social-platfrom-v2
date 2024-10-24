<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Domains\Auth\Notifications\Frontend\UserVerificationEmail;

class VerificationController extends Controller
{
    public function resend(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        
        if ($user == null) {
            return response()->json(['success' => false ,'message' => 'User doesn\'t exist'], 404);
        }
        if ($user->email === null) {
            return response()->json(['success' => false ,'message' => 'email doesn\'t exist'], 404);
        }
        if ($user->email_verified_at == null) {
            $user->type = $request->type;
            $user->notify(new UserVerificationEmail);
            return response()->json(['success' => true ,'message' => 'we have resent you verification email. Please check your email and verify!'], 200);
        }else{
            return response()->json(['success' => false , 'message' => 'This user is already Verified. Please Proceed to login'], 201);
        }
    }
}
