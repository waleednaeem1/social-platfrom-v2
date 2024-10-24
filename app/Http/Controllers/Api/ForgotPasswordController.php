<?php

namespace App\Http\Controllers\ApisV2;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Models\CentralUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Domains\Auth\Notifications\Frontend\ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use App\Mail\Vetandtech\ResetEmail;
use App\Mail\DVM\ResetEmailDvm;
use DB;
use Illuminate\Support\Str;
class ForgotPasswordController extends Controller
{   
    use Notifiable;
    use SendsPasswordResetEmails;

    public function sendResetLinkEmailJson(Request $request)
    {
        $user = Customer::where('email', $request->email)->first();
        if(isset($user) && $user != ""){
            $this->validateEmail($request);
            
            //check for vtfriends
            if($request->type == 'vtfriends'){
                $user = User::where('email', $request->email)->where('allow_on_vt_friend' , '1' )->first();
                if(!$user){
                    return response()->json(['incorrect_username_or_password_label' => true ,'success' => false,'message' => 'This email does not exist.'], 201);
                }
                // setting Devsinc as verified
                if($user->email_verified_at == null){
                    $user->email_verified_at = date('Y-m-d H:i:s');
                    $user->save();
                }
            }
            //check for dvm_central
            else if($request->type == 'dvm_central'){
                $user = User::where('email', $request->email)->where('allow_on_dvm' , '1' )->first();
                if(!$user){
                    return response()->json(['incorrect_username_or_password_label' => true ,'success' => false,'message' => 'This email does not exist.'], 201);
                }
            }
            //check for vetandtech
            else if($request->type == 'vetandtech'){
                $user = User::where('email', $request->email)->where('allow_on_vetandtech' , '1' )->first();
                if(!$user){
                    return response()->json(['incorrect_username_or_password_label' => true ,'success' => false,'message' => 'This email does not exist.'], 201);
                }
            }

            if($user->email_verified_at == null) {
                return response()->json(['success' => false ,'message' => 'Your email is not verified!'], 201);
            } 
            if ($request->type == 'vetandtech') {
                try {
                    $request->otp = random_int(100000, 999999);
                    Mail::send(new ResetEmail($request));
                    return response()->json(['message' => __('We\'ve sent an OTP Code to your email address.'), 'otp' => $request->otp, 'success' => true], 200);
                } catch (\Throwable $th) {
                    return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 200);
                }
            }
            if ($request->type == 'dvm_central') {
                try {
                    $request->otp = random_int(100000, 999999);
                    Mail::send(new ResetEmailDvm($request));
                    return response()->json(['message' => __('We\'ve sent an OTP Code to your email address.'), 'otp' => $request->otp, 'success' => true], 200);
                } catch (\Throwable $th) {
                    return response()->json(['message' => $th->getMessage(), 'line' => $th->getLine(), 'file' => $th->getFile(), 'success' => false], 200);
                }
            }


            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendResetLink(
                $this->credentials($request)
            );

            return $response == Password::RESET_LINK_SENT
                ? response()->json(['success' => true, 'message' => trans($response)], 200)
                : response()->json(['success' => false, 'message' => trans($response)], 401);
        } else {
            return response()->json(['success' => false ,'message' => 'This email does not exist!'], 201);
        }
    }

    public function savePassword(Request $request){
        $rules = [
            'email' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required',
        ];

        $input = $request->only(
            'email',
            'current_password',
            'password',
            'confirm_password'
        );
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 201);
        }
        $user = Customer::where('email', $request->email)->first();

        $data['page_type'] = "update-password";

        if($user){
            if(!(Hash::check($request->input('current_password'),$user->password))){
                // return response()->json(['error' => __('Your current password is invalid!'), $data], 201);
                return response()->json(['success' => false , 'message' => 'Your current password is invalid!',$data], 201);
            }
            if($request->password  == $request->confirm_password){
                if(Hash::check($request->input('password'),$user->password)){
                    return response()->json(['success' => false , 'message' => 'New Password Should Be Different From The Old Password' ,$data], 201);
                }else{
                    $user->password = Hash::make($request->password);
                    $user->save();
                }

                return response()->json(['success' => true , 'message' => 'Password Changed Successfully!',$data], 200);
            }else{
                return response()->json(['success' => false , 'message' => 'Password and Confirmed Password Must Match',$data], 201);
            }
        }else{
            return response()->json(['success' => false , 'message' => 'Email Does Not Exists',$data], 201);
        }
    }

    public function saveResetPassword(Request $request)
    {
        $user = Customer::where('email', $request->get('email'))->first();

        if($user)
        {
            if($request->password  == $request->confirm_password)
            {
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json(['success' => true , 'message' => 'Password Changed Successfully!'], 200);
            }
            else
            {
                return response()->json(['success' => false , 'message' => 'Password and Confirmed Password Must Match'], 201);
            }
        }
        else
        {
            return response()->json(['success' => false , 'message' => 'Email Does Not Exists'], 201);
        }
    }
}