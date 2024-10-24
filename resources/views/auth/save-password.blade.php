<x-guest-layout>
    @php
        $url = url()->current();
        $url = explode('/', $url);
        $email =$url[4];
        $userOtpData = DB::table('password_resets')->where(['email'=> $email])->first();

    @endphp
        <section class="sign-in-page">
            <div id="container-inside">
                <div id="circle-small"></div>
                <div id="circle-medium"></div>
                <div id="circle-large"></div>
                <div id="circle-xlarge"></div>
                <div id="circle-xxlarge"></div>
            </div>
            <div class="container p-0">
                <div class="row no-gutters">
                    <div class="col-md-6 text-center pt-5">
                        <div class="sign-in-detail text-white">
                            <a href="/" class="sign-in-logo mb-5">
                                {{-- <img src="{{asset('images/logo-full.png')}}" class="img-fluid" alt="logo"> --}}
                                 <img src="{{ asset('images/icon/logo.png')}}" alt="userimg" width="150px" style="height:100px" loading="lazy">
                                 {{-- <h3 class="logo-title d-none d-sm-block" data-setting="app_name">VT Friends</h3> --}}
                            </a>
                            <div class="sign-slider overflow-hidden ">
                                <ul  class="swiper-wrapper list-inline m-0 p-0 ">
                                    <li class="swiper-slide">
                                        <img src="{{asset('images/login/banner-03.png')}}" class="img-fluid mb-4 rounded" alt="logo">
    
                                        <h4 class="mb-1 text-white">Find new friends</h4>
                                        <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                    </li>
                                    <li class="swiper-slide">
                                        <img src="{{asset('images/login/Juggling Through Various Stores Is Not Easy.png')}}" class="img-fluid mb-4 rounded" alt="logo">
                                        <h4 class="mb-1 text-white">Connect with the world</h4>
                                        <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                    </li>
                                    <li class="swiper-slide">
                                        <img src="{{asset('images/login/Conferences-PNG.png')}}" class="img-fluid mb-4 rounded" alt="logo">
                                        <h4 class="mb-1 text-white">Create new events</h4>
                                        <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bg-white pt-5 pt-5 pb-lg-0 pb-5">
                        <h2 class="mb-2">Create New Password <span style="margin-left: 4rem"><a href="{{route('login')}}" class="btn btn-primary btn-block">Sign in</a></span></h2>
                        <p>Create a new strong password to protect your account</p>
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <form method="POST" class="mt-4" action="{{ route('password.update') }}" data-toggle="validator" class="">
                            @csrf
                            <input type="hidden" name="email" value = {{$email}}>
                            {{-- <input type="hidden" name="token" id="token" value="{{$url[4]}}" > --}}
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                {{-- <a href="{{route('password.request')}}" class="float-end">Forgot password?</a> --}}
                                <input class="form-control" type="password" placeholder="********"  name="password" value="{{ env('IS_DEMO') ? 'password' : '' }}" required autocomplete="current-password">
                            </div>
                            <div class="form-group">
                                <label for="confirm-password" class="form-label">Confirm Password</label>
                                <input class="form-control" type="password" placeholder="********"  name="password_confirmation" value="{{ env('IS_DEMO') ? 'password' : '' }}" required autocomplete="current-password">
                            </div>
                            <div class="form-group">
                                <label for="otp" class="form-label">OTP</label>
                                <input class="form-control"  type="text" placeholder="********"  name="otp" required">
                            </div>

                            <div style="font-size: 14px; color:rgb(180, 25, 25)" id="otp-timer">Your OTP will expire in <span id="timer"></span> seconds</div> <br>
                            <button type="submit" class="btn btn-primary btn-block">  {{ __('Submit') }}</button>
                        </form>
                        <div class="mt-2">
                            <form method="POST" action="{{ route('email.resend')}}">
                                @csrf
                                <input type="hidden" name="email" value = {{$email}}>
                                <button type="submit" class="btn btn-primary btn-block">  {{ __('Resend OTP') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
    </x-guest-layout>
    @if(strtotime($userOtpData->created_at) > strtotime("-10 minutes"))
    @php
        
        $diff = strtotime($userOtpData->created_at) - strtotime("-10 minutes");
    @endphp
        <script>
            let diff = {!! json_encode($diff) !!}; console.log(diff)
            setTimeout(() => {
                    timer(diff);
                }, "10")
                timer(600);
        </script>
    @else
        <script>
            document.getElementById('otp-timer').innerHTML = '';
        </script>
    @endif
    <script>
        let timerOn = true;

        function timer(remaining) {
            var m = Math.floor(remaining / 600);
            var s = remaining % 600;
            
            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('timer').innerHTML =  s;
            remaining -= 1;
            
            if(remaining >= 0 && timerOn) {
                setTimeout(function() {
                    timer(remaining);
                }, 1000);
                return;
            }

            if(!timerOn) {
                document.getElementById('otp-timer').innerHTML = '';
            }
            
            document.getElementById('otp-timer').innerHTML = 'OTP expired. Click on Resend OTP button to get a new code';
        }
        
    </script>

        