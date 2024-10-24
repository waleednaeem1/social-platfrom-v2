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
                        <h4 class="card-title">Speakers</h4>
                    </div>
                </div>
                <div class="row">
                    @foreach($data['speakers'] as $speaker)
                        {{-- <a href="{{route('speaker.speakerdetail',  ['slug' => $speaker->slug])}}"> --}}
                            <div class="col-md-6">
                                <div class="card card-block card-stretch card-height" style="margin-right:20px">
                                    <div class="card-body profile-page p-0">
                                        <div class="profile-header-image">
                                            <div class="profile-info p-4">
                                                <div class="user-detail">
                                                    <div class="d-flex flex-wrap justify-content-between align-items-start">
                                                        <a href="https://www.vetandtech.com/speakers/{{$speaker->slug}}" target="_blank">
                                                        <div class="profile-detail d-flex">
                                                            <div class="pe-4">
                                                                @if(isset($speaker->profile) && $speaker->profile !== '')
                                                                    <img src="https://web.dvmcentral.com/up_data/speakers/{{$speaker->profile}}" style="object-fit: cover" alt="profile-img" class="avatar-130 rounded-circle" />
                                                                @else
                                                                    <img src="{{asset('images/user/Users_150x150.png')}}" alt="profile-img" class="avatar-130" />
                                                                @endif
                                                            </div>
                                                            <div class="user-data-block">
                                                                    <h6 style="color:blueviolet">{{$speaker->first_name}} {{$speaker->last_name}}</h6>
                                                                <p><strong>Institute:</strong> {{$speaker->institute}}</p>
                                                                <p><strong>Job Title:</strong> {{$speaker->job_title}}</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- </a> --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
