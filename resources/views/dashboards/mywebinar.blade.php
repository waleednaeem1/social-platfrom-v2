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
                    <h4 class="card-title">My Webinars</h4>
                    </div>
                </div>
                <div class="row">
                    @foreach($data['myWebinars'] as $webinar)
                        {{-- <a href="{{route('webinar.webinardetail',  ['slug' => $webinar->slug])}}"> --}}
                        <div class="col-lg-4 col-md-6">
                            <div class="card card-block card-stretch card-height">
                                <div class="card-body profile-page p-0">
                                    <a href="https://www.vetandtech.com/webinars/{{$webinar['webinar']->slug}}" target="_blank">
                                        <div class="profile-header-image">
                                            <div class="cover-container">
                                                @if(isset($webinar['webinar']->image) && $webinar['webinar']->image !== '')
                                                    <img src="https://web.dvmcentral.com/up_data/webiners/images/{{$webinar['webinar']->image}}" height="475px" alt="cover-bg" class="rounded img-fluid-friends-list w-100">
                                                @else
                                                    <img src="{{asset('images/page-img/profile-bg2.jpg')}}" alt="profile-bg" class="rounded img-fluid w-100">
                                                @endif
                                            </div>
                                            <div class="profile-info p-4">
                                                <div class="user-detail">
                                                    <div class="d-flex flex-wrap justify-content-between align-items-start">
                                                        <div class="profile-detail d-flex">
                                                            <div class="user-data-block">
                                                                <h6>{{$webinar['webinar']->name}}</h6>
                                                                <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($webinar['webinar']->start_date)->isoFormat('MMM D, YYYY h:mm A')}}</p>
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
            </div>
        </div>
    </div>
</x-app-layout>
