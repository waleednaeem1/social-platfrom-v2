<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Devsinc</title>

        @include('partials._head')
    </head>
    <x-app-layout>
        <body class="my-5">
            <div class="container-fluid container">
                <div class="row">
                    <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                        <h3 class="text-primary text-center mb-3">Customer Support</h3>
                        @if(session()->has('message'))
                        <div id="alert" class="alert alert-success mt-2">
                            {{ session()->get('message') }}
                        </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="card" style="margin-top: 2rem">
                                {{-- <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Information</h4>
                                    </div>
                                </div> --}}
                                <div class="card-body">
                                    <p>Welcome to Devsinc customer support! We're here to assist you with any questions or concerns you may have about our new social networking site.</p>
                                </div>
                            </div>
                            <div class="card">
                                {{-- <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Information</h4>
                                    </div>
                                </div> --}}
                                <div class="card-body">
                                    <p>Our team is dedicated to providing you with the best possible experience on Devsinc. Whether you need help setting up your account, navigating the site, or troubleshooting any issues, we're here to help.</p>
                                    <p>You can reach out to us through our customer support email or chat, and we'll be happy to assist you as quickly and efficiently as possible.</p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title ml-2" style="margin-left: 20px;">Contact Form</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form class="post-text ms-3 w-100" action="{{ route('user.contactSupport') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="event_calender_grid" style="display: grid;grid-template-columns: 1fr 1fr;">
                                            <div>
                                                @if(auth()->user())
                                                    <input type="hidden" name="userId" value={{auth()->user()->id}} required class="form-control rounded" style="border:none;">
                                                @endif
                                                <input type="text" id="name" name="name" required class="form-control rounded" minlength="2" maxlength="40" value="{{old('name')}}" placeholder="Name" style="width:90%;margin-bottom:1rem">
                                                {{-- <input type="text" id="phoneNumber" maxlength="13" name="phone" value="{{old('phone')}}" required class="form-control rounded phone" placeholder="Phone" style="width:90%;margin-bottom:1rem"> --}}
                                            </div>
                                            <div>
                                                <input type="email" name="email" pattern ="[^@]+@[^@]+\.[a-zA-Z]{2,6}" value="{{old('email')}}" required class="form-control rounded" placeholder="Email" style="width:90%;margin-bottom:1rem">
                                            </div>
                                            <div>
                                                <input type="text" id="phoneNumber" maxlength="10" minlength="10" name="phone" value="{{old('phone')}}" required class="form-control rounded phone" placeholder="e.g. (123) 478-9987" style="width:90%;margin-bottom:1rem">
                                            </div>
                                            <div>
                                                <input type="text" name="company" required class="form-control rounded" placeholder="Company" style="width:90%;margin-bottom:1rem">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="contactMessage" class="form-label">Your Message</label>
                                            <textarea class="form-control rounded" required id="message" name="message" rows="4" style="width:95%"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary d-block mt-3">Send Information</button>
                                    </form><br>
                                    <div class="card-body mt-4">
                                        <p class=" mt-4">By submitting this form you agree to our terms and conditions and our Privacy Policy which explains how we may collect, use and disclose your personal information including to third parties.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
            <script type="text/javascript">
                document.getElementById("name").addEventListener("input", function(event) {
                    var input = event.target.value;
                    var regex = /([^a-zA-Z\s])/g;
                    if (regex.test(input)) {
                        event.target.value = input.replace(regex, "");
                    } else {
                        if(input.length < 2 || input.length > 40){}else{
                            event.target.value = input;
                        }
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
                setTimeout(() => {
                const box = document.getElementById('alert');
                box.style.display = 'none';
                }, 5000);
            </script>
        </body>
    </x-app-layout>
</html>
