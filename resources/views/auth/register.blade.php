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
                        {{-- <a class="sign-in-logo mb-5" href="#"><img src="{{asset('images/logo-full.png')}}" class="img-fluid" alt="logo"></a> --}}
                        <a class="sign-in-logo mb-5">
                            {{-- <img src="{{asset('images/logo-full.png')}}" class="img-fluid" alt="logo"> --}}
                             <img src="{{ asset('images/icon/logo.png')}}" alt="userimg" width="150px" style="height:100px" loading="lazy">
                             {{-- <h3 class="logo-title d-none d-sm-block" data-setting="app_name">Devsinc</h3> --}}
                        </a>
                        <div class="sign-slider overflow-hidden ">
                            <ul  class="swiper-wrapper list-inline m-0 p-0 ">
                                <li class="swiper-slide">
                                    <img src="{{asset('images/login/banner-03.png')}}" class="img-fluid mb-4 rounded" alt="logo">

                                    <h4 class="mb-1 text-white">Find new friends</h4>
                                    <p>Everyone you meet knows something you don't know but need to know.</p>
                                </li>
                                <li class="swiper-slide">
                                    <img src="{{asset('images/login/Juggling Through Various Stores Is Not Easy.png')}}" class="img-fluid mb-4 rounded" alt="logo">
                                    <h4 class="mb-1 text-white">Connect with the world</h4>
                                    <p>Connect to conquer together.</p>
                                </li>
                                {{-- <li class="swiper-slide">
                                    <img src="{{asset('images/login/3.png')}}" class="img-fluid mb-4 rounded" alt="logo">
                                    <h4 class="mb-1 text-white">Create new events</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 bg-white pt-5 pt-5 pb-lg-0 pb-5">
                    <div class="sign-in-from">
                        <h1 style="margin-bottom: 2rem">Sign Up</h1>
                        {{-- <p>Enter your email address and password to access admin panel.</p> --}}
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- Validation Errors -->
                        @if (Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{Session::get("error")}}
                            </div>
                        @endif
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <form method="POST" action="{{route('register')}}" data-toggle="validator">
                            {{-- {{csrf_field()}} --}}
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="username-name" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input id="username-name" name="username" value="{{old('username')}}" class="form-control" type="text" placeholder=" "  required autofocus >
                                </div>
                                {{-- <div class="form-group col-md-6">
                                    <label class="form-label" for="exampleInputEmail2">Email Address <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" placeholder=" " id="email"  name="email" value="{{old('email')}}" required>
                                </div> --}}
                                <div class="form-group col-md-6">
                                    <label for="phone" class="form-label">Phone No <span class="text-danger">*</span></label>
                                    <input type="text" id="phoneNumber" class="form-control phone" name="phone_number" value="{{old('phone_number')}}" maxlength="10" autocomplete="none" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="first-name" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input name="first_name" id="first_name_text" value="{{old('first_name')}}" class="form-control" type="text" placeholder=" "  required autofocus minlength="2" maxlength="14">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last-name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input name="last_name" id="last_name_text" value="{{old('last_name')}}" class="form-control" type="text" placeholder=" "  required autofocus minlength="2" maxlength="14">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="exampleInputEmail2">Email Address <span class="text-danger">*</span></label>
                                    <input class="form-control" pattern ="[^@]+@[^@]+\.[a-zA-Z]{2,6}" type="email" placeholder=" " id="email"  name="email" value="{{old('email')}}" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="dob" class="form-label">Date Of Birth <span class="text-danger">*</span></label><br />
                                    <div class="date-picker">
                                        <div class="span2">
                                            <input type="text" required class="rounded alert example px-2 py-1 rounded" value="{{old('dob')}}" autocomplete="off" style="width:64%; font-size: inherit;border-color: darkgray;color: currentcolor;" name="dob" id="datepicker" placeholder="MM-DD-YYYY">
                                        </div>
                                    </div>
                                    {{-- <input type="date" required class="form-control" id="dob" name="dob" > --}}
                                    {{-- <select class="form-select my-1 mx-2" aria-label="Default select example" id="day" name="dob_day" required>
                                        <option value="" selected disabled>Day</option>

                                        @for($day = 1 ; $day <= 31 ; $day++)
                                            @php
                                                if($day < 10) $day = '0'.$day;
                                            @endphp
                                            <option value="{{ $day }}" @if (old('dob_day') == $day) {{ 'selected' }} @endif>{{ $day }}</option>
                                        @endfor

                                    </select>
                                    <select class="form-select my-1" aria-label="Default select example" id="month" name="dob_month" style="width: auto;" required>
                                        <option value="" selected disabled>Month</option>
                                        <option value="01" @if (old('dob_month') == '01') {{ 'selected' }} @endif>January</option>
                                        <option value="02" @if (old('dob_month') == '02') {{ 'selected' }} @endif>February</option>
                                        <option value="03" @if (old('dob_month') == '03') {{ 'selected' }} @endif>March</option>
                                        <option value="04" @if (old('dob_month') == '04') {{ 'selected' }} @endif>April</option>
                                        <option value="05" @if (old('dob_month') == '05') {{ 'selected' }} @endif>May</option>
                                        <option value="06" @if (old('dob_month') == '06') {{ 'selected' }} @endif>June</option>
                                        <option value="07" @if (old('dob_month') == '07') {{ 'selected' }} @endif>July</option>
                                        <option value="08" @if (old('dob_month') == '08') {{ 'selected' }} @endif>August</option>
                                        <option value="09" @if (old('dob_month') == '09') {{ 'selected' }} @endif>September</option>
                                        <option value="10" @if (old('dob_month') == '10') {{ 'selected' }} @endif>October</option>
                                        <option value="11" @if (old('dob_month') == '11') {{ 'selected' }} @endif>November</option>
                                        <option value="12" @if (old('dob_month') == '12') {{ 'selected' }} @endif>December</option>
                                    </select>
                                    <select class="form-select my-1" aria-label="Default select example" id="year" name="dob_year" required>
                                        <option value="" selected disabled>Year</option>
                                        @php
                                            $min_age = 18;
                                            $current_year = date('Y');
                                        @endphp
                                        @for($year = $current_year - $min_age; $year >= 1900; $year--){
                                            {{-- echo '<option value="'.$year.'">'.$year.'</option>'; --}}
                                            {{-- <option value="{{ $year }}" @if (old('dob_year') == $year) {{ 'selected' }} @endif>{{ $year }}</option>
                                        }
                                        @endfor
                                    </select>  --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">

                                    <label class="form-label d-block">Gender <span class="text-danger">*</span></label>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" style="margin-top: 4px;" required type="radio" name="gender" id="inlineRadio10" value="male" @if (old('gender') == "male") {{ 'checked' }} @endif>
                                        <label class="form-check-label" for="inlineRadio10"> Male</label>
                                    </div>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" style="margin-top: 4px;" type="radio" name="gender" id="inlineRadio11" value="female" @if (old('gender') == "female") {{ 'checked' }} @endif>
                                        <label class="form-check-label" for="inlineRadio11">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" style="margin-top: 4px;" type="radio" name="gender" id="inlineRadio12" value="Don’t want to specify" @if (old('gender') == "Don’t want to specify") {{ 'checked' }} @endif>
                                        <label class="form-check-label" for="inlineRadio12">Don’t want to specify</label>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="form-group col-md-12">

                                    <label class="form-label d-block">Are you a Pet Parent <span class="text-danger">*</span></label>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" style="margin-top: 4px;" required type="radio" name="pet_parent" id="inlineRadio13" value="yes" @if (old('pet_parent') == "yes") {{ 'checked' }} @endif>
                                        <label class="form-check-label" for="inlineRadio13"> Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline my-2">
                                        <input class="form-check-input" style="margin-top: 4px;" type="radio" name="pet_parent" id="inlineRadio14" value="no" @if (old('pet_parent') == "no") {{ 'checked' }} @endif>
                                        <label class="form-check-label" for="inlineRadio14">No</label>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" placeholder=" " id="password" name="password" required autocomplete="new-password" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm-password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input id="password_confirmation" class="form-control" type="password" placeholder=" " name="password_confirmation" required >
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        {{-- <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                        </div> --}}
                                        <input name="password" type="password" value="" class="input form-control" id="password" required="true" aria-label="password" aria-describedby="basic-addon1" />
                                        <div class="input-group-append">
                                          <span class="input-group-text" style="height:39px;" onclick="password_show_hide();">
                                            {{-- <i class="fas fa-eye" id="show_eye"></i>
                                            <i class="fas fa-eye-slash d-none" id="hide_eye"></i> --}}
                                            <i class="fas fa-eye-slash" id="show_eye"></i>
                                            <i class="fas fa-eye d-none" id="hide_eye"></i>
                                          </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm-password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        {{-- <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                        </div> --}}
                                        <input name="password_confirmation" type="password" value="" class="input form-control" id="password_confirmation" required="true" aria-label="password" aria-describedby="basic-addon1" />
                                        <div class="input-group-append">
                                          <span class="input-group-text" style="height:39px;" onclick="confirm_password_show_hide();">
                                            <i class="fas fa-eye-slash" id="show_eye1"></i>
                                            <i class="fas fa-eye d-none" id="hide_eye1"></i>
                                          </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="d-inline-block mt-2 pt-1">
                                    <input type="checkbox" class="custom-control-input" id="dvmCheck" value="1" name="allow_on_dvm" @if (old('allow_on_dvm') == 1) {{ 'checked' }} @endif>
                                    <label class="form-check-label" for="dvmCheck">Would like to Sign Up on DVM Central</label>
                                </div>
                                <div class="d-inline-block mt-2 pt-1">
                                    <input type="checkbox" class="custom-control-input" id="vetandtechCheck" value="1" name="allow_on_vetandtech" @if (old('allow_on_vetandtech') == 1) {{ 'checked' }} @endif>
                                    <label class="form-check-label" for="vetandtechCheck">Would like to Sign Up on Vet and Tech</label>
                                </div>
                            </div> --}}
                            <div class="d-inline-block w-100">
                                <div class="d-inline-block mt-2 pt-1">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="customCheck1" required value="1" @if (old('customCheck1') == 1) {{ 'checked' }} @endif>
                                    <label class="form-check-label" for="customCheck1">I accept <a href="{{route('logout.termsofservice')}}">Terms and Conditions</a></label>
                                </div>
                                <button type="submit" id="submitBtn" class="btn btn-primary float-end">Sign Up</button>
                            </div>
                            <div class="sign-info">
                                {{-- <span class="dark-color d-inline-block line-height-2">Already Have Account ? <a href="{{route('signin')}}">Log In</a></span> --}}
                                <span class="dark-color d-inline-block line-height-2">Already Have Account ? <a href="{{route('login')}}">Sign In</a></span>
                                {{-- <ul class="iq-social-media">
                                    <li>
                                        <a href="#">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 16 16" fill="currentColor">
                                                <title>facebook</title>
                                                <path d="M15 16h-14c-0.553 0-1-0.447-1-1v-14c0-0.553 0.447-1 1-1h14c0.553 0 1 0.447 1 1v14c0 0.553-0.447 1-1 1zM14 2h-12v12h12v-12zM8 6c0-1.103 0.912-2 1.857-2h1.143v2h-1v1h1v2h-1v3h-2v-3h-1v-2h1v-1z"></path>
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="currentColor">
                                            <title>twitter</title>
                                            <path d="M20.833 5.262c-0.186 0.242-0.391 0.475-0.616 0.696-0.233 0.232-0.347 0.567-0.278 0.908 0.037 0.182 0.060 0.404 0.061 0.634 0 5.256-2.429 8.971-5.81 10.898-2.647 1.509-5.938 1.955-9.222 1.12 1.245-0.361 2.46-0.921 3.593-1.69 0.147-0.099 0.273-0.243 0.352-0.421 0.224-0.505-0.003-1.096-0.508-1.32-2.774-1.233-4.13-2.931-4.769-4.593-0.417-1.084-0.546-2.198-0.52-3.227 0.021-0.811 0.138-1.56 0.278-2.182 0.394 0.343 0.803 0.706 1.235 1.038 2.051 1.577 4.624 2.479 7.395 2.407 0.543-0.015 0.976-0.457 0.976-1v-1.011c-0.002-0.179 0.009-0.357 0.034-0.533 0.113-0.806 0.504-1.569 1.162-2.141 0.725-0.631 1.636-0.908 2.526-0.846s1.753 0.463 2.384 1.188c0.252 0.286 0.649 0.416 1.033 0.304 0.231-0.067 0.463-0.143 0.695-0.228zM22.424 2.183c-0.74 0.522-1.523 0.926-2.287 1.205-0.931-0.836-2.091-1.302-3.276-1.385-1.398-0.097-2.836 0.339-3.977 1.332-1.036 0.901-1.652 2.108-1.83 3.372-0.037 0.265-0.055 0.532-0.054 0.8-1.922-0.142-3.693-0.85-5.15-1.97-0.775-0.596-1.462-1.309-2.034-2.116-0.32-0.45-0.944-0.557-1.394-0.237-0.154 0.109-0.267 0.253-0.335 0.409 0 0-0.132 0.299-0.285 0.76-0.112 0.337-0.241 0.775-0.357 1.29-0.163 0.722-0.302 1.602-0.326 2.571-0.031 1.227 0.12 2.612 0.652 3.996 0.683 1.775 1.966 3.478 4.147 4.823-1.569 0.726-3.245 1.039-4.873 0.967-0.552-0.024-1.019 0.403-1.043 0.955-0.017 0.389 0.19 0.736 0.513 0.918 4.905 2.725 10.426 2.678 14.666 0.261 4.040-2.301 6.819-6.7 6.819-12.634-0.001-0.167-0.008-0.33-0.023-0.489 1.006-1.115 1.676-2.429 1.996-3.781 0.127-0.537-0.206-1.076-0.743-1.203-0.29-0.069-0.58-0.003-0.807 0.156z"></path>
                                        </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 28" fill="currentColor">
                                                <title>instagram</title>
                                                <path d="M16 14c0-2.203-1.797-4-4-4s-4 1.797-4 4 1.797 4 4 4 4-1.797 4-4zM18.156 14c0 3.406-2.75 6.156-6.156 6.156s-6.156-2.75-6.156-6.156 2.75-6.156 6.156-6.156 6.156 2.75 6.156 6.156zM19.844 7.594c0 0.797-0.641 1.437-1.437 1.437s-1.437-0.641-1.437-1.437 0.641-1.437 1.437-1.437 1.437 0.641 1.437 1.437zM12 4.156c-1.75 0-5.5-0.141-7.078 0.484-0.547 0.219-0.953 0.484-1.375 0.906s-0.688 0.828-0.906 1.375c-0.625 1.578-0.484 5.328-0.484 7.078s-0.141 5.5 0.484 7.078c0.219 0.547 0.484 0.953 0.906 1.375s0.828 0.688 1.375 0.906c1.578 0.625 5.328 0.484 7.078 0.484s5.5 0.141 7.078-0.484c0.547-0.219 0.953-0.484 1.375-0.906s0.688-0.828 0.906-1.375c0.625-1.578 0.484-5.328 0.484-7.078s0.141-5.5-0.484-7.078c-0.219-0.547-0.484-0.953-0.906-1.375s-0.828-0.688-1.375-0.906c-1.578-0.625-5.328-0.484-7.078-0.484zM24 14c0 1.656 0.016 3.297-0.078 4.953-0.094 1.922-0.531 3.625-1.937 5.031s-3.109 1.844-5.031 1.937c-1.656 0.094-3.297 0.078-4.953 0.078s-3.297 0.016-4.953-0.078c-1.922-0.094-3.625-0.531-5.031-1.937s-1.844-3.109-1.937-5.031c-0.094-1.656-0.078-3.297-0.078-4.953s-0.016-3.297 0.078-4.953c0.094-1.922 0.531-3.625 1.937-5.031s3.109-1.844 5.031-1.937c1.656-0.094 3.297-0.078 4.953-0.078s3.297-0.016 4.953 0.078c1.922 0.094 3.625 0.531 5.031 1.937s1.844 3.109 1.937 5.031c0.094 1.656 0.078 3.297 0.078 4.953z"></path>
                                            </svg>
                                        </a>
                                    </li>
                                </ul> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script type="text/javascript">
    document.getElementById("first_name_text").addEventListener("input", function(event) {
    var input = event.target.value;
    var regex = /([^a-zA-Z\s])/g;
    if (regex.test(input)) {
        event.target.value = input.replace(regex, "");
    } else {
        if(input.length < 2 || input.length > 14){}else{
            event.target.value = input;
        }
    }
    });
    document.getElementById("last_name_text").addEventListener("input", function(event) {
    var input = event.target.value;
    var regex = /([^a-zA-Z\s])/g;
    if (regex.test(input)) {
        event.target.value = input.replace(regex, "");
    } else {
        if(input.length < 2 || input.length > 14){}else{
            event.target.value = input;
        }
    }
    });
</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    
        document.getElementById("username-name").addEventListener("input", function(event) {
            var regex = /[^a-z0-9_]/g;
            var input = event.target.value;
            if (regex.test(input)) {
                event.target.value = input.replace(regex, "");
            } else {
                event.target.value = input;
            }
        });

        $('.phone').on('input', function(event) {
            var input = event.target.value;
            var regex = /[^a-zA-Z0-9]/g;
            if (regex.test(input)) {
                event.target.value = input.replace(regex, '');
            }
            $(this).val(formatPhoneNumber($(this).val()));
        });

        function formatPhoneNumber(input) {
            var phoneNumberCheck = document.getElementById("phoneNumber");
            var checkregex = /[^a-zA-Z0-9]/g;
            var phoneNumber = input.replace(checkregex, "");
            var regex = /^([a-zA-Z0-9]{3})([a-zA-Z0-9]{3})([a-zA-Z0-9]{4})$/;
            if (regex.test(input)) {
                phoneNumberCheck.setCustomValidity("");
                return input.replace(regex, '($1) $2-$3');
            } else {
                if(phoneNumber.length < 10 || phoneNumber.length > 11){
                    event.preventDefault();
                    phoneNumberCheck.setCustomValidity("Phone number must be between 10 and 11 digits");
                    return input;
                }else{
                    phoneNumberCheck.setCustomValidity("");
                    return input;
                }
            }
        }

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:-18',
                constrainInput: false,
                defaultDate: new Date(1980, 01, 01)
            });
        } );
        
        $("#datepicker").on('keypress',function(e){
        if(event.charCode == 9 ){
            return true;
        }
            return false;     
        });

        </script>
        
</x-guest-layout>
