<?php
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers\Admin\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
// use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = 'admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->middleware('admin.guest')->except('logout');
    // }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $pageTitle = "Admin Login";
        return view('admin.auth.login', compact('pageTitle'));
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

    public function username()
    {
        return 'username';
    }

    public function login(LoginRequest $request)
    {
        // die("Waleed login");
        // echo "<pre>";
        // print_r($request->all());
        // die;
        $user = User::where('email', $request->email)->first();
        if(isset($user) && $user->soft_delete == 1){
            return back()->withErrors(['msg' => 'The account has been deleted. To activate your account, please contact the administrator on this email waleed.naeem@devsinc.com.']);
        }
        if(isset($user) && $user->active == 0){
            return back()->withErrors(['msg' => 'The account has been deactivated. To activate your account, please contact the administrator on this email waleed.naeem@devsinc.com']);
        }

        if(!$user){
            return back()->withErrors(['msg' => 'This email does not exist']);
        }
        if($user->email_verified_at == null || $user->email_verified_at =='') {
            (new User())->verificationEmail($user);
            return back()->withErrors(['msg' => 'Your email is not verified, we have resent you verification email. Please check your email and verify!']);
        }
        if(! Hash::check($request->password,$user->password)){
            return back()->withInput()->withErrors(['msg' => 'Please enter the correct password and try again.']);
        }

        if($request->has('remember_me')){
            Cookie::queue(Cookie::make('adminuser', $request->email, 1440));
            Cookie::queue(Cookie::make('adminpwd', $request->password, 1440));
        }else{
            Cookie::queue(Cookie::forget('adminuser'));
            Cookie::queue(Cookie::forget('adminpwd'));
        }
        $request->authenticate();

        $request->session()->regenerate();

        return redirect(RouteServiceProvider::ADMIN);







        // $this->validateLogin($request);

        // $request->session()->regenerateToken();

        // // if(!verifyCaptcha()){
        // //     $notify[] = ['error','Invalid captcha provided'];
        // //     return back()->withNotify($notify);
        // // }


        // // Onumoti::getData();

        // // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // // the login attempts for this application. We'll key this by the username and
        // // the IP address of the client making these requests into this application.
        // if (method_exists($this, 'hasTooManyLoginAttempts') &&
        //     $this->hasTooManyLoginAttempts($request)) {
        //     $this->fireLockoutEvent($request);
        //     return $this->sendLockoutResponse($request);
        // }

        // if ($this->attemptLogin($request)) {
        //     return $this->sendLoginResponse($request);
        // }

        // // If the login attempt was unsuccessful we will increment the number of attempts
        // // to login and redirect the user back to the login form. Of course, when this
        // // user surpasses their maximum number of attempts they will get locked out.
        // $this->incrementLoginAttempts($request);

        // return $this->sendFailedLoginResponse($request);
    }


    public function logout(Request $request)
    {
        // $this->guard('admin')->logout();
        // $this->user()->logout();
        // $request->session()->invalidate();
        // return $this->loggedOut($request) ?: redirect('/admin');


        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin');
    }
}
