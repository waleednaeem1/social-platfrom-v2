@php

$user = auth()->user();
use App\Models\UserFollow;
use App\Models\User;
use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\BlockedUser;

@endphp

<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                        <h4 class="card-title">Friends List</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @forelse($data['friendsList'] as $friend)
                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card-body profile-page" style="padding:0px;">
                                    <div class="profile-header-image">
                                        <div class="cover-container">
                                            @php 
                                                $file_path = public_path('storage/images/user/userProfileandCovers/'.$friend->id.'/'.'cover'.'/'.$friend->cover_image);
                                            @endphp
                                            @if(isset($friend->cover_image) && $friend->cover_image !== '' && is_file($file_path))
                                                <img src="{{ asset('storage/images/user/userProfileandCovers/'.$friend->id.'/'.'cover'.'/'.$friend->cover_image) }}" height="475px" alt="cover-bg" class=" img-fluid-friends-list w-100" style="border-radius: 0px !important;">
                                            @else
                                                <img src="{{asset('images/user/banner-04.png')}}" alt="profile-bg" height="475px" class=" img-fluid-friends-list w-100" style="border-radius: 0px !important;">
                                            @endif
                                        </div>
                                        <div class="profile-detail d-flex">
                                            <a href="{{route('user-profile',  ['username' => $friend->username])}}">
                                                <div class="profile-img pe-4">
                                                    @php 
                                                        $file_path = public_path('storage/images/user/userProfileandCovers/'.$friend->id.'/'.$friend->avatar_location);
                                                    @endphp
                                                    @if(isset($friend->avatar_location) && $friend->avatar_location !== '' && is_file($file_path))
                                                        <img src="{{ asset('storage/images/user/userProfileandCovers/'.$friend->id.'/'.$friend->avatar_location) }}" alt="profile-img" width="120px" height="120px" />
                                                    @else
                                                        <img src="{{asset('images/user/Users_150x150.png')}}" alt="profile-img" width="120px" height="120px" />
                                                    @endif
                                                </div>
                                            </a>
                                        </div>
                                        <div class="profile-info pt-3 px-4" style="border: 1px solid #777d7424; min-height:78px">
                                            <div class="user-detail">
                                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                                    <div class="my-auto user-data-block">
                                                        <h4>
                                                            <a href="{{route('user-profile',  ['username' => $friend->username])}}">
                                                                @if(strlen($friend->first_name) <= 7 && strlen($friend->last_name) <= 7)
                                                                    {{ $friend->first_name . ' ' . $friend->last_name}}
                                                                @else
                                                                    {{$friend->first_name . ' ' . (strlen($friend->last_name) > 1 ? substr($friend->last_name, 0, 1) : $friend->last_name)}}
                                                                @endif
                                                            </a>
                                                        </h4>
                                                        {{-- <h6>@designer</h6>
                                                        <p>Lorem Ipsum is simply dummy text of the</p> --}}
                                                    </div>
                                                    <div class="friendsSectionsAddFriend_{{$friend->username}}">
                                                        <li class="friendButtonStyleInline updateProfileFriendRequestDiv_{{$friend->username}}">
                                                            @if ($data['check_friends'])
                                                                <div class="dropdown hideFriendSection_{{$friend->username}}">
                                                                    <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                                        Friend
                                                                    </span>
                                                                    <div class="dropdown-menu">
                                                                        @if ($data['is_following'])
                                                                            <a href="#" class="dropdown-item unfollowFriend_{{$friend->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_{{$friend->username}}" action="javascript:void();">Unfollow</a>
                                                                            <a class="dropdown-item d-none followFriend_{{$friend->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$friend->username}}')">Follow</a>
                                                                        @else
                                                                            <a class="dropdown-item followFriend_{{$friend->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$friend->username}}')">Follow</a>
                                                                            <a href="#" class="dropdown-item d-none unfollowFriend_{{$friend->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_{{$friend->username}}" action="javascript:void();">Unfollow</a>
                                                                        @endif
                                                                        @if ($data['is_blocking'])
                                                                            <a class="dropdown-item unblockFriend_{{$friend->username}}" onclick="unblockFriendUser('{{$friend->username}}')" href="javascript:void(0);">Unblock</a>
                                                                            <a class="dropdown-item d-none blockFriend_{{$friend->username}}" onclick="blockFriendUser('{{$friend->username}}')" href="javascript:void(0);">Block</a>
                                                                        @else
                                                                            <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#block-user-modal_following_{{$friend->username}}" action="javascript:void();">Block</a>
                                                                            <a class="dropdown-item d-none unblockFriend_{{$friend->username}}" onclick="unblockFriendUser('{{$friend->username}}')" href="javascript:void(0);">Unblock</a>    
                                                                        @endif
                                                                        <a class="dropdown-item unFriend_{{$friend->username}}" onclick="unFriendUser('{{$friend->username}}')" href="javascript:void(0);">Unfriend</a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                @if ($data['is_request_sending'])
                                                                    @if (isset($data['check_friendrequest_status']))
                                                                        @if ($data['check_friendrequest_status']->status == 'pending' || $data['check_friendrequest_status']->status == 'rejected' || $data['check_friendrequest_status']->status == 'unfriend')
                                                                            @if($data['friendrequest_status_for_accept'] )
                                                                                <div class="dropdown">
                                                                                    <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown"
                                                                                        aria-haspopup="true" aria-expanded="false"
                                                                                        role="button">
                                                                                        Respond Request
                                                                                    </span>
                                                                                    <div class="dropdown-menu">
                                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfileUser({{$data['friendrequest_status_for_accept']->user_id}} , '{{$friend->username}}')">Confirm</a>
                                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfileUser({{$data['friendrequest_status_for_accept']->id}} , '{{$friend->username}}')">Delete</a>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                @if($data['check_friendrequest_status_tocancel'])
                                                                                    <a onclick="cancelRequestUser('{{$friend->username}}')"
                                                                                        href="javascript:void(0);"
                                                                                        class="btn btn-primary d-flex align-items-center cancelRequest_{{$friend->username}}">Cancel Request</a>
                                                                                @else
                                                                                    <a onclick="addToFriendUser('{{$friend->username}}')" href="javascript:void(0);"
                                                                                            class="btn btn-primary d-flex align-items-center addFriend_{{$friend->username}}"><i
                                                                                                class="material-symbols-outlined me-2">add</i>Add
                                                                                            Friend</a>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    @if($data['friendrequest_status_for_accept'] )
                                                                        <div class="dropdown">
                                                                            <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false"
                                                                                role="button">
                                                                                Respond Request
                                                                            </span>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfileUser({{$data['friendrequest_status_for_accept']->user_id}} , '{{$friend->username}}')">Confirm</a>
                                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfileUser({{$data['friendrequest_status_for_accept']->id}} , '{{$friend->username}}')">Delete</a>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <a  onclick="addToFriendUser('{{$friend->username}}')" href="javascript:void(0);"
                                                                            class="btn btn-primary d-flex align-items-center addFriend_{{$friend->username}}"><i
                                                                                class="material-symbols-outlined me-2">add</i>Add
                                                                            Friend </a>
                                                                    @endif
                                                                    <a onclick="cancelRequestUser('{{$friend->username}}')" href="javascript:void(0);"
                                                                        class="btn btn-primary d-flex align-items-center d-none cancelRequest_{{$friend->username}}">Cancel Request</a>
                                                                @endif
                                                            @endif
                                                        </li>
                                                        <a onclick="addToFriendUser('{{$friend->username}}')" href="javascript:void(0);" class="btn btn-primary align-items-center d-none addToFriend_{{$friend->username}}"><i class="material-symbols-outlined me-2">add</i>Add Friend </a>
                                                        <a onclick="cancelRequestUser('{{$friend->username}}')" href="javascript:void(0);" class="btn btn-primary d-none cancelRequest_{{$friend->username}}">Cancel Request</a>
                                                    </div>
                                                    <div class="modal fade" id="unfollow-modal_{{$friend->username}}" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="delete-modalLabel" aria-hidden="true" >
                                                        <div class="modal-dialog   modal-fullscreen-sm-down">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="align-items: flex-start;">
                                                                    <div class="d-flex align-items-center">
                                                                        @if(isset($friend->avatar_location) && $friend->avatar_location !== '')
                                                                        <img src="{{ asset('storage/images/user/userProfileandCovers/'. $friend->id.'/'.$friend->avatar_location) }}" alt="userimg" class="avatar-80 rounded-circle" loading="lazy">
                                                                        @else
                                                                        {{-- <img src="{{asset('images/user/1.jpg')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy"> --}}
                                                                        <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                                                        @endif
                                                                        <h5 class="modal-title ms-3" id="delete-modalLabel">Are you sure you want to unfollow {{$friend->first_name}} {{$friend->last_name}} ?</h5>
                                                                    </div>
                                                                    <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                                    <span class="material-symbols-outlined">close</span>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body align-self-end">
                                                                    <div class="d-flex align-items-center">
                                                                        <button data-bs-dismiss="modal" onclick="unfollowFriendUser('{{$friend->username}}')" class="btn btn-primary me-2">Yes</button>
                                                                        <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="block-user-modal_following_{{$friend->username}}" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="block-modalLabel" aria-hidden="true" >
                                                        <div class="modal-dialog   modal-fullscreen-sm-down">
                                                        <div class="modal-content">
                                                                <div class="modal-header"style="align-items: flex-start;">
                                                                    <h5 class="modal-title ms-3" style="max-width:400px;" id="block-modalLabel">Are you sure you want to block {{$friend->first_name}} {{$friend->last_name}}?</h5>
                                                                    <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                                        <span class="material-symbols-outlined">close</span>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body align-self-end">
                                                                    <p style="color:red" class="mx-3">
                                                                        Once you block someone, that person can no longer see things you post on your timeline, start a conversation with you, or add you as a friend.
                                                                    </p>
                                                                    <div class="d-flex align-items-center justify-content-end">
                                                                        <button data-bs-dismiss="modal" onclick="blockFriendUser('{{$friend->username}}')" class="btn btn-primary me-2">Yes</button>
                                                                        <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="card-body text-center justify-content-center p-0 m-0" style="padding-top: 40px !important;padding-bottom: 40px !important;" >
                                    <span class="material-symbols-outlined" style="font-size:40px; color:#8c68cd;">group</span>
                                    <div>
                                        There are no friends to display.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
