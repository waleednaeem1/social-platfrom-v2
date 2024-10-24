<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                <div class="header-for-bg">
                    <div class="background-header position-relative">
                        <img src="images/page-img/birthdays.jpg" class="img-fluid w-100" alt="profile-bg">
                        <div class="title-on-header">
                            <div class="data-block">
                                <h2>Birthdays</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="content-page" class="content-page">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                @foreach($data['dobs'] as $month => $friends)
                                    <div class="birthday-block">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between rounded border-bottom-0">
                                                <div class="header-title">
                                                    <h4 class="card-title">{{ \App\Models\User::$months[$month] }} Birthdays</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @foreach($friends as $friend)
                                                @php
                                                    $path = asset('storage/images/user/userProfileandCovers/' . $friend->id . '/' . $friend->avatar_location);
                                                    if($friend->avatar_location == '')
                                                        $path = asset('images/user/Users_60x60.png');
                                                @endphp
                                                <div class=" col-lg-6 col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                        <div class="iq-birthday-block">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    @if(isset($friend->username) && $friend->username !== null)
                                                                    <a href="{{route('user-profile',  ['username' => $friend->username])}}">
                                                                        <img src="{{ $path }}" alt="profile-img" class="avatar-60 rounded-circle img-fluid">
                                                                    </a>
                                                                    @else
                                                                        <img src="{{ $path }}" alt="profile-img" class="avatar-60 rounded-circle img-fluid">
                                                                    @endif
                                                                    <div class="friend-info ms-0 ms-md-3 mt-md-0 mt-2">
                                                                        <a href="{{route('user-profile',  ['username' => $friend->username])}}"><h5>{{ $friend->first_name . ' ' . $friend->last_name }}</h5></a>
                                                                    <p class="mb-0">{{ date('dS M', strtotime($friend->dob)) }}</p>
                                                                    </div>
                                                                </div>
                                                                {{-- <button class="btn btn-primary">Create Card</button> --}}
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
