<?php

namespace App\Http\Controllers;
use App\Models\UserProfileDetails;

use Illuminate\Http\Request;

class UserProfileDetailController extends Controller
{
    public function update(UserRequest $request, $id)
    {
        // dd($request->all());
        // $user = UserProfileDetail::with('userProfile')->findOrFail($id);
        $user = UserProfileDetail::where('user_id',  $id)->first();
        $role = Role::find($request->user_role);
        if(env('IS_DEMO')) {
            if($role->name === 'admin') {
                return redirect()->back()->with('errors', 'Permission denied.');
            }
        }
        // $user->assignRole($role->name);
        // $request['password'] = $request->password != '' ? bcrypt($request->password) : $user->password;
        // User user data...
        // $user->fill($request->all())->update();
        // $request->get('user_id')->first();
        $user->first_name = Str::title($request->get('first_name'));
        $user->last_name =  Str::title($request->get('last_name'));
        $user->username = $user->first_name  . ' ' . $user->last_name ;
        $user->city = $request->get('city');
        $user->address = $request->get('address');
        $user->gender = $request->get('gender');
        $user->dob = $request->get('date_of_birth');
        $user->country = $request->get('country');
        $user->state = $request->get('state');
        $user->address = $request->get('address');
        $user->save();
        // dd($user);
        // Save user image...
        if (isset($request->profile_image) && $request->profile_image != null) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        // user profile data....
        // $user->userProfile->fill($request->userProfile)->update();

        if(auth()->check()){
            return redirect()->back()->withSuccess(trans('users.update'));
        }
        return redirect()->back()->withSuccess(trans('users.update_profile'));

    }
}
