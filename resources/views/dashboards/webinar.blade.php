@php
    $user = auth()->user();
@endphp
<style>
    .modal {
    --bs-modal-width: 800px !important;
}
</style>
<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                <div class="card-header d-flex justify-content-between" style="margin-bottom: 3rem">
                    <div class="header-title">
                    <h4 class="card-title">Webinars</h4>
                    </div>
                </div>
                <div class="row">
                    @foreach($data['webinars'] as $webinar)
                        {{-- <a href="{{route('webinar.webinardetail',  ['slug' => $webinar->slug])}}"> --}}
                        <div class="col-lg-4 col-md-6">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-body profile-page p-0">
                                    <a href="https://www.vetandtech.com/webinars/{{$webinar->slug}}" target="_blank">
                                        <div class="profile-header-image">
                                            <div class="cover-container">
                                                @if(isset($webinar->image) && $webinar->image !== '')
                                                    <img src="https://web.dvmcentral.com/up_data/webiners/images/{{$webinar->image}}" style="object-fit: cover"  alt="cover-bg" class="rounded w-100">
                                                    {{-- <img src="https://web.dvmcentral.com/up_data/webiners/images/202303275616.jpg"  style="object-fit: cover"  alt="cover-bg" class="rounded w-100"> --}}
                                                @else
                                                    <img src="{{asset('images/page-img/profile-bg2.jpg')}}" alt="profile-bg" class="rounded img-fluid w-100">
                                                @endif
                                            </div>
                                            <div class="profile-info p-4">
                                                <div class="user-detail">
                                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                                    <div class="profile-detail d-flex">
                                                        <div class="user-data-block">
                                                            <h6>{{$webinar->name}}</h6>
                                                            <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($webinar->start_date)->isoFormat('MMM D, YYYY h:mm A')}}</p>
                                                        </div>
                                                    </div>
                                                    {{-- <a class="btn btn-primary d-block join-group" id="registerForWebinar" data-bs-toggle="modal" data-bs-target="#post-modal" action="javascript:void();">Register</a> --}}
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal fade" id="post-modal" tabindex="-1" style=" margin-top:3rem"  aria-labelledby="post-modalLabel" aria-hidden="true" >
                    <div class="modal-dialog   modal-fullscreen-sm-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" style="text-align:center;" id="post-modalLabel">Fill the Form Below to Register</h5>
                                <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                    <span class="material-symbols-outlined">close</span>
                                </a>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex align-items-center" data-bs-spy="scroll">
                                    <form class="post-text ms-3 w-100" action="{{ route('user.registerWebinar') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="event_calender_grid" style="display: grid;grid-template-columns: 1fr 1fr;">
                                            <div class="mx-2">
                                                <input type="hidden" name="userId" value={{auth()->user()->id}} required class="form-control rounded" style="border:none;">
                                                <input type="text" name="first_name" required class="form-control rounded" placeholder="First Name" style="border:none;">
                                                <hr>
                                                <input type="email" name="email" required class="form-control rounded" placeholder="Email" style="border:none;">
                                                <hr>
                                            </div>
                                            <div class="mx-2">
                                                <input type="text" name="last_name" required class="form-control rounded" placeholder="Last Name" style="border:none;">
                                                <hr>
                                                <input type="text" name="phone" required class="form-control rounded" placeholder="Phone" style="border:none;">
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="mx-2">
                                            <input type="text" name="address" required class="form-control rounded" placeholder="Address" style="border:none;">
                                            <hr>
                                        </div>

                                        <div class="event_calender_grid" style="display: grid;grid-template-columns: 1fr 1fr;">
                                            <div class="mx-2">
                                                <input type="text" name="company" required class="form-control rounded" placeholder="Company" style="border:none;">
                                                <hr>
                                                <input type="text" name="city" required class="form-control rounded" placeholder="City" style="border:none;">
                                                <hr>
                                                {{-- <input type="text" name="role" required class="form-control rounded" placeholder="Your Role" style="border:none;"> --}}
                                                <select name="role" class="form-control rounded" required style="border:none;">
                                                    <option selected disabled>Your Role</option>
                                                    <option value="Veterinarian">Veterinarian</option>
                                                    <option value="Dentist">Dentist</option>
                                                    <option value="Technician">Technician</option>
                                                    <option value="Office Manager">Office Manager</option>
                                                    <option value="Clinic Owner">Clinic Owner</option>
                                                    <option value="Associated with Hospital">Associated with Hospital</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <hr>
                                            </div>
                                            <div class="mx-2">
                                                {!! Form::select('state', $data['states'], null,['class'=>'form-control',  'placeholder'=>'Select state ...', 'style'=>'border:none']) !!}
                                                <hr>
                                                <input type="text" name="zipcode" required class="form-control rounded" placeholder="Zip / Postal Code" style="border:none;">
                                                <hr>
                                                {{-- <input type="text" name="speciality" required class="form-control rounded" placeholder="Your Speciality" style="border:none;"> --}}
                                                <select name="speciality" class="form-control rounded" required style="border:none;">
                                                    <option selected disabled>Your Speciality ...</option>
                                                    <option value="Dental">Dental</option>
                                                    <option value="Orthopedic">Orthopedic</option>
                                                    <option value="Soft Tissue">Soft Tissue</option>
                                                    <option value="Spay Neuter">Spay Neuter</option>
                                                </select>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="mx-2">
                                            <input type="text" name="licence_number" required class="form-control rounded" placeholder="Veterinary License Number" style="border:none;">
                                            <hr>
                                            <small>Note: Please enter your veterinary license number for atleast one state</small>
                                            {{-- <input type="textarea" name="additional_comments" class="form-control rounded" placeholder="Additional Comments" style="border:none;"> --}}
                                            <textarea class="form-control rounded" name="additional_comments" cols="100" rows="5" placeholder="Additional Comments"></textarea>
                                        </div>
                                        <div>
                                            <p style="color:crimson">* Please fill complete details in order to make yourself eligible for free webinars.</p>
                                        </div>
                                        <button type="submit" class="btn btn-primary d-block w-100 mt-3">Register</button>
                                    </form>
                                </div>
                            </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
