<x-guest-layout>
    <section class="sign-in-page">
        <div id="container-inside">
            <div id="circle-small"></div>
            <div id="circle-medium"></div>
            <div id="circle-large"></div>
            <div id="circle-xlarge"></div>
            <div id="circle-xxlarge"></div>
        </div>
        <div class="container" style="height: 100%;">
            <div class="row" style="height: 100%; overflow-y:auto;">
                <div class="col-md-12 bg-white">
                    @if(session()->has('message'))
                        <div id="alert" class="alert alert-success mt-2">
                            {{ session()->get('message') }}
                        </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="card">
                                <a href="/" class="sign-in-logo">
                                    <img src="{{ asset('images/icon/devsinc-logo.png')}}" alt="userimg" width="130px" style="height:70px" loading="lazy">
                               </a>
                                <h3 class="text-primary text-center">Customer Support</h3>
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
    </section>

</x-guest-layout>

