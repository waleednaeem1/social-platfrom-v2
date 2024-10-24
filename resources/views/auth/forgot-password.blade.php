<x-guest-layout>

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
                        <a class="sign-in-logo mb-5" href="#">
                            {{-- <img src="{{asset('images/logo-full.png')}}" class="img-fluid" alt="logo"> --}}
                             <img src="{{ asset('images/icon/logo.png')}}" alt="userimg" width="150px" style="height: 100px;" loading="lazy">
                             {{-- <h3 class="logo-title d-none d-sm-block" data-setting="app_name">Devsinc</h3> --}}
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
                    <h2 class="mb-2">Reset Password</h2>
                    <p>Enter your email address and we'll send you an email with instructions to reset your password.</p>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" class="mt-4" action="{{ route('password.email') }}" data-toggle="validator" class="">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="floating-label form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email", name="email" aria-describedby="email" placeholder=" ">
                            </div>
                            </div>
                        </div>
                        <button type="submit" id="resetFormButton" class="btn btn-primary btn-block">  {{ __('Reset') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>