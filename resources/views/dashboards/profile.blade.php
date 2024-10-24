@php
    $user = auth()->user();
    use App\Models\Chat;
    use App\Models\UserFollow;
    use App\Models\User;
    use App\Models\Friend;
    use App\Models\FriendRequest;
    use App\Models\BlockedUser;
    $data['CheckchatsId'] = Chat::chatsId($data['user']->id);
    if($data['CheckchatsId'] === null){
        $data['chatsIdNull'] = Chat::chatsIdNull();
    }else{
        $data['chatsIdHave'] = Chat::chatsId($data['user']->id);
    }
    if(Session::has('pg')){
        $pg = Session::get('pg');
    }
    $classcomment = 'feedcomnt';


@endphp
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">

<!--for hobbies autosuggestion -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<style>
   .choices__list--multiple .choices__item {
    display: inline-block;
    vertical-align: middle;
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 12px;
    font-weight: 500;
    margin-right: 3.75px;
    margin-bottom: 3.75px;
    background-color: #8c68CD !important;
    border: 1px solid #8c68CD !important;
    color: #fff;
    word-break: break-all;
}
.fa-lock:before {

    position: absolute;
    margin-left: 80px;
    margin-top: 20px;
    color: rgb(178, 177, 180);
    font-size: 16px;
}
 .choices__input:focus-visible{
    outline: #fff !important;
}
.choices__list--dropdown {
    border: none !important;
    border-bottom: 1px solid #ddd;
}

</style>
<!--end file for hobbies autosuggestion -->

<link rel="stylesheet" href="{{ asset('css/croppie/croppie.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-x-8 rem-div-1">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body profile-page p-0">
                            <div class="profile-header">
                                <div class="updateProfileCoverPhoto updateProfilePhoto">
                                    <div class="position-relative ">

                                        @if (isset($data['user']->cover_image) && $data['user']->cover_image !== '')
                                            <a data-fslightbox="gallery" href="{{ asset('storage/images/user/userProfileandCovers/' . $data['user']->id . '/' . 'cover' . '/' . $data['user']->cover_image) }}" class="dropdown-item p-0">
                                                <img src="{{ asset('storage/images/user/userProfileandCovers/' . $data['user']->id . '/' . 'cover' . '/' . $data['user']->cover_image) }}"  alt="cover-bg" class="rounded" style="object-fit: fill; max-width: -webkit-fill-available; min-height:300px; max-height:400px;  width:100%"/>
                                            </a>
                                        @else
                                            <img src="{{ asset('images/user/Upload.jpg') }}" alt="profile-bg" width="100%" height="450px" alt="cover-bg" class="rounded" style="object-fit: fill;">
                                        @endif

                                        <div class="col-12 text-end">
                                            <div class="position-relative profile-cover-btn">
                                                <div class="dropdown">
                                                    @if ($data['self_profile'])
                                                        <a href="javascript:void();" data-bs-toggle="dropdown" class="fa fa-camera fa dropdown shadow upload_camera_icon "></a>
                                                        <div class="dropdown-menu">
                                                            @if(isset($data['user']->cover_image) && $data['user']->cover_image !== '')
                                                                <a data-fslightbox="gallery" href="{{ asset('storage/images/user/userProfileandCovers/' . $data['user']->id . '/' . 'cover' . '/' . $data['user']->cover_image) }}" class="dropdown-item">View Cover Picture</a>
                                                            @endif
                                                            @if ($data['self_profile'])
                                                                <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#coverphoto-post-modal" class="dropdown-item">Update Cover Picture</a>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="user-detail user-detail-profile-lg mb-lg-3 text-center">
                                        <div class="d-lg-flex d-xxl-block justify-content-lg-start justify-content-xxl-center alighn-items-lg-center">
                                            <div class="">
                                                @if (isset($data['user']->avatar_location) && $data['user']->avatar_location !== '' && is_file(public_path('storage/images/user/userProfileandCovers/'.$data['user']->id.'/'.$data['user']->avatar_location)))
                                                    <a data-fslightbox="gallery" href="{{ asset('storage/images/user/userProfileandCovers/' . $data['user']->id . '/' . $data['user']->avatar_location) }}">
                                                        <img class="border border-1 border-primary rounded-circle" data-fslightbox="gallery" src="{{ asset('storage/images/user/userProfileandCovers/' . $data['user']->id . '/' . $data['user']->avatar_location) }}" width="120px" height="120px" />
                                                    </a>
                                                @else
                                                    <img src="{{ asset('images/user/Users_512x512.png') }}" alt="profile-img" class="avatar-130 img-fluid" />
                                                @endif
                                                <div class="position-relative profile-img-btn">
                                                    <div class="dropdown">
                                                        @if ($data['self_profile'])
                                                            <a href="javascript:void();" data-bs-toggle="dropdown" class="fa fa-camera fa shadow upload_camera_icon profile-icon" id="ipad-profile"></a>
                                                        @endif
                                                        <div class="dropdown-menu">
                                                            @if(isset($data['user']->avatar_location) && $data['user']->avatar_location !== '')
                                                                <a data-fslightbox="gallery" href="{{ asset('storage/images/user/userProfileandCovers/' . $data['user']->id . '/' . $data['user']->avatar_location) }}" class="dropdown-item">View Profile Picture</a>
                                                            @endif
                                                            @if ($data['self_profile'])
                                                                <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#group-post-modal" class="dropdown-item">Update Profile Picture</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- @if ($data['self_profile']) 
                                                <div class="row">
                                                    <div style="width: 55%; float: left; text-align: right; margin-top: -36px;">
                                                        <div class="dropdown">
                                                            <a href="javascript:void();" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button" class="fa fa-camera fa dropdown shadow" style="color: #8c68cd;background: white;border-radius: 50%;border: 1px solid #8c68cd;width: 40px;height: 40px;display: flex;justify-content: center;align-items: center;"></a>
                                                            <div class="dropdown-menu">
                                                                @if(isset($data['user']->avatar_location) && $data['user']->avatar_location !== '')
                                                                    <a data-fslightbox="gallery" href="{{ asset('storage/images/user/userProfileandCovers/' . $data['user']->id . '/' . $data['user']->avatar_location) }}" class="dropdown-item">View Profile Picture</a>
                                                                @endif
                                                                <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#group-post-modal" class="dropdown-item">Update Profile Picture</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="width: 45%; float: right; text-align: right; padding-right: 10px; margin-top: -36px;">
                                                        <div class="dropdown">
                                                            <a href="javascript:void();" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button" class="fa fa-camera fa dropdown shadow" style="color: #8c68cd;background: white;border-radius: 50%;border: 1px solid #8c68cd;width: 40px;height: 40px;display: flex;justify-content: center;align-items: center;"></a>
                                                            <div class="dropdown-menu">
                                                                @if(isset($data['user']->cover_image) && $data['user']->cover_image !== '')
                                                                    <a data-fslightbox="gallery" href="{{ asset('storage/images/user/userProfileandCovers/' . $data['user']->id . '/' . 'cover' . '/' . $data['user']->cover_image) }}" class="dropdown-item">View Cover Picture</a>
                                                                @endif
                                                                <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#coverphoto-post-modal" class="dropdown-item">Update Cover Picture</a>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            @endif --}}
                                            <div class="profile-detail profile-user-name">
                                                @if (!$data['self_profile'])
                                                    @if (strlen($data['user']->first_name) > 10 || strlen($data['user']->last_name) > 10)
                                                        <h4 class="user-profile-name"> {{ (strlen($data['user']->first_name) > 10 ? substr($data['user']->first_name, 0, 10) . '' : $data['user']->first_name). ' ' . (strlen($data['user']->last_name) > 10 ? substr($data['user']->last_name, 0, 10) . '...' : $data['user']->last_name) }}</h4>
                                                    @else
                                                        <h3 class="user-profile-name"> {{ (strlen($data['user']->first_name) > 10 ? substr($data['user']->first_name, 0, 10) . '' : $data['user']->first_name). ' ' . (strlen($data['user']->last_name) > 10 ? substr($data['user']->last_name, 0, 10) . '...' : $data['user']->last_name) }}</h3>
                                                    @endif
                                                @else
                                                    <h3 class="user-profile-name"> {{ $data['user']->first_name. ' ' . (strlen($data['user']->last_name) > 10 ? substr($data['user']->last_name, 0, 10) . '...' : $data['user']->last_name) }}</h3>
                                                @endif
                                                @if (!$data['self_profile'])
                                                    <div class="d-none d-lg-block d-xxl-none"> 
                                                        <li class="alighn-items-center d-flex justify-content-center" id="updateFollowFollowing">
                                                            {{-- <div>
                                                                <p>Posts {{ $data['feedsCount'] }}</p>
                                                            </div> --}}
                                                            <div class="">
                                                                <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#follower_user">
                                                                    <p class="mb-0">{{ $data['follower_user'] }} Followers</p>
                                                                </a>
                                                            </div>
                                                            <div class=" ps-3 ">
                                                                <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#following_user">
                                                                    <p class="mb-0">{{ $data['following_user'] }} Following</p>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    </div> 
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade modal-dialog-scrollable" id="group-post-modal" aria-labelledby="groupPost-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 5rem">
                                    <div class="modal-dialog modal-groupCreatePost modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="groupPost-modalLabel">Upload Profile Picture
                                                </h5>
                                                <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                    <span class="material-symbols-outlined">close</span>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <div class="cover_spin_ProfilePhotoUpdate"></div>
                                                <div class="d-flex align-items-center">
                                                    <div class="container" style="margin-top:30px;">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 text-center">
                                                                        <div id="cropie-demo" style="width:250px;"></div>
                                                                    </div>
                                                                    <div class="col-md-6" style="padding-top:30px;">
                                                                        <strong>Select Image:</strong>
                                                                        {{-- <input type="file" required id="upload"> --}}
                                                                        <input type="file"name="profileImage" id="profile-image" required class="form-control" accept="image/x-png,image/jpg,image/jpeg" placeholder="Profile Image" style="border:none;" onchange="checkImageExtensions()">
                                                                        <input type="hidden" name="userId" value={{ $user->id }}>
                                                                        <input type="hidden" name="type" value="profile">
                                                                        <br />
                                                                        <span id="error-profile" style="color: red; display: none;">Please select a valid image file</span>
                                                                    </div>
                                                                    {{-- <button class="btn btn-primary upload-result">Upload Image</button> --}}
                                                                    <button style="display:none;" type="submit" name="submit" id="showAndHideButtonProfile" class="btn btn-primary w-100 mt-3 upload-result">Update Profile Picture</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade modal-dialog-scrollable" id="coverphoto-post-modal" aria-labelledby="coverPhoto-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 5rem">
                                    <div class="modal-dialog modal-lg modal-lg-cover modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="coverPhoto-modalLabel">Upload Cover Photo</h5>
                                                <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                    <span class="material-symbols-outlined">close</span>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <div class="cover_spin_ProfilePhotoUpdate"></div>
                                                <div class="d-flex align-items-center">
                                                    <div class="container" style="">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-md-9 text-center">
                                                                        <div id="cropie-demo-cover"></div>
                                                                    </div>
                                                                    <div class="col-md-3" style="">
                                                                        <strong>Select Image:</strong>
                                                                        {{-- <input type="file" required id="uploadCover"> --}}
                                                                        <input type="file" name="profileImage" id="cover-image" accept="image/x-png,image/jpg,image/jpeg" required class="form-control" accept="image/*" placeholder="Cover Image" style="border:none;" onchange="checkImageExtensions()">
                                                                        <input type="hidden" name="userId" value={{ $user->id }}>
                                                                        <input type="hidden" name="type" value="profile">
                                                                        <br />
                                                                        <span id="error-cover" style="color: red; display: none;">Please select a valid image file</span>
                                                                    </div>
                                                                    {{-- <button id="upload-result-cover" class="btn btn-primary">Upload Cover Image</button> --}}
                                                                    <button style="display:none;" type="submit" id="showAndHideButtonCover" class="btn btn-primary w-100 mt-3 upload-result-cover">Update Cover Photo</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-info pb-3 position-relative">
                                    <div class="social-links">
                                        <ul class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                                            @if (isset($data['user']->fb_url) && $data['user']->fb_url !== '')
                                                <li class="text-center pe-3">
                                                    <a href="javascript:void();"><img src="{{ asset('images/icon/Social_facebook.png') }}" class="img-fluid rounded" alt="facebook"></a>
                                                </li>
                                            @endif
                                            @if (isset($data['user']->twitter_url) && $data['user']->twitter_url !== '')
                                                <li class="text-center pe-3">
                                                    <a href="javascript:void();"><img src="{{ asset('images/icon/Social_twitter.png') }}" class="img-fluid rounded" alt="Twitter"></a>
                                                </li>
                                            @endif
                                            @if (isset($data['user']->instagram_url) && $data['user']->instagram_url !== '')
                                                <li class="text-center pe-3">
                                                    <a href="javascript:void();"><img src="{{ asset('images/icon/Social_instagram.png') }}" class="img-fluid rounded" alt="Instagram"></a>
                                                </li>
                                            @endif
                                            @if (isset($data['user']->google_plus_url) && $data['user']->google_plus_url !== '')
                                                <li class="text-center pe-3">
                                                    <a href="javascript:void();"><img src="{{ asset('images/icon/Social_google plus.png') }}" class="img-fluid rounded" alt="Google plus"></a>
                                                </li>
                                            @endif
                                            @if (isset($data['user']->youtube_url) && $data['user']->youtube_url !== '')
                                                <li class="text-center pe-3">
                                                    <a href="javascript:void();"><img src="{{ asset('images/icon/Social_youtube.png') }}" class="img-fluid rounded" alt="You tube"></a>
                                                </li>
                                            @endif
                                            @if (isset($data['user']->linkedin_url) && $data['user']->linkedin_url !== '')
                                                <li class="text-center md-pe-3 pe-0">
                                                    <a href="javascript:void();"><img src="{{ asset('images/icon/Social_linksin.png') }}" class="img-fluid rounded" alt="linkedin"></a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="social-info  mt-0 mt-lg-3" id="updateProfileFriendRequestDiv">
                                        <div class="text-center col-12 align-items-center d-flex justify-content-center justify-content-lg-end justify-content-xxl-between">
                                            <ul class="align-items-center cover-header-friend d-grid d-xxl-flex grid-col--1 grid-cols--xxl-2 justify-content-center justify-content-lg-end justify-content-xxl-between list-inline m-0 p-0 ps-xxl-3 social-data-block w-100">
                                                @if (!$data['self_profile'])
                                                    <li class="alighn-items-center d-flex justify-content-center mt-2 order-2 order-xxl-1">
                                                        @if ($data['check_friends'])
                                                            <div class="dropdown" id="hideFriendSection">
                                                                <span class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                                    Friend
                                                                </span>
                                                                <div class="dropdown-menu">
                                                                    @if ($data['is_following'])
                                                                        <a href="javascript:void();" class="dropdown-item" id="unfollowFriend" data-bs-toggle="modal" data-bs-target="#unfollow-modal_profile" action="javascript:void();">Unfollow</a>
                                                                        <a class="dropdown-item d-none" id="followFriend" href="javascript:void(0);" onclick="followFriend()">Follow</a>
                                                                    @else
                                                                        <a class="dropdown-item" id="followFriend" href="javascript:void(0);" onclick="followFriend()">Follow</a>
                                                                        <a href="javascript:void();" class="dropdown-item d-none" id="unfollowFriend" data-bs-toggle="modal" data-bs-target="#unfollow-modal_profile" action="javascript:void();">Unfollow</a>
                                                                    @endif
                                                                    @if ($data['is_blocking'])
                                                                        <a class="dropdown-item" id="unblockFriend" onclick="unblockFriend()" href="javascript:void(0);">Unblock</a>

                                                                        <a href="javascript:void();" class="dropdown-item d-none" data-bs-toggle="modal" data-bs-target="#block-user-modal_profile" action="javascript:void();">Block</a>
                                                                        {{-- <a class="dropdown-item d-none" id="blockFriend" onclick="blockFriend()" href="javascript:void(0);">Block</a> --}}

                                                                    @else

                                                                        {{-- <a class="dropdown-item" id="blockFriend" onclick="blockFriend()" href="javascript:void(0);">Block</a> --}}
                                                                        <a href="javascript:void();" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#block-user-modal_profile" action="javascript:void();">Block</a>

                                                                        <a class="dropdown-item d-none" id="unblockFriend" onclick="unblockFriend()" href="javascript:void(0);">Unblock</a>
                                                                    @endif
                                                                    <a class="dropdown-item" id="unFriend" onclick="unFriend()" href="javascript:void(0);">Unfriend</a>
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
                                                                                    <li>
                                                                                        <div class="dropdown" id="profileUserAction">
                                                                                            <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                                                                ...
                                                                                            </span>
                                                                                            <div class="dropdown-menu">
                                                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfile({{$data['friendrequest_status_for_accept']->user_id}})">Confirm</a>
                                                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfile({{$data['friendrequest_status_for_accept']->id}})">Delete</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </li>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            @if($data['check_friendrequest_status_tocancel'])
                                                                                <a onclick="cancelRequest()" href="javascript:void(0);" class="btn btn-primary d-flex align-items-center " id="cancelRequest">Cancel Request</a>
                                                                            @else
                                                                                <a onclick="addToFriend()" href="javascript:void(0);" id="addFriend" class="btn btn-primary d-flex align-items-center"><i class="material-symbols-outlined me-2">add</i>Add Friend</a>
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
                                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfile({{$data['friendrequest_status_for_accept']->user_id}})">Confirm</a>
                                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfile({{$data['friendrequest_status_for_accept']->id}})">Delete</a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <a onclick="addToFriend()" href="javascript:void(0);" id="addFriend" class="btn btn-primary d-flex align-items-center"><i class="material-symbols-outlined me-2">add</i>Add Friend</a>
                                                                @endif
                                                                <a onclick="cancelRequest()" href="javascript:void(0);" class="btn btn-primary d-flex align-items-center d-none" id="cancelRequest">Cancel Request</a>
                                                            @endif
                                                        @endif
                                                        @if($data['chatLock'] == false)
                                                            @if($data['CheckchatsId'] === null)
                                                                <button id="btnOpenFormUser" action="#" onclick="openFormUser({{$data['chatsIdNull']}},{{$data['user']->id}})" type="submit" class="btn btn-primary d-flex align-items-center mx-2" >Message</button>
                                                                <button id="btnOpenForm" action="#" onclick="openForm({{$data['chatsIdNull']}},{{$data['user']->id}})" type="submit" class="btn btn-primary d-flex align-items-center d-none mx-2" >Message</button>
                                                            @else
                                                                <button action="#" onclick="openForm({{$data['chatsIdHave']->id}},{{$data['user']->id}})" type="submit" class="btn btn-primary d-flex align-items-center mx-2" >Message</button>
                                                            @endif
                                                        @endif
                                                    </li>
                                                @endif
                                                @if ($data['self_profile'])
                                                    <li class="alighn-items-center d-flex justify-content-center" id="updateFollowFollowing">
                                                        <div>
                                                            <h6>Posts</h6>
                                                            <p class="mb-0">{{ $data['feedsCount'] }}</p>
                                                        </div>
                                                        <div class="ps-3">
                                                            <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#follower_user">
                                                                <h6>Followers</h6>
                                                                <p class="mb-0">{{ $data['follower_user'] }}</p>
                                                            </a>
                                                            {{-- <p class="mb-0">{{$data['user']->total_followers}}</p> --}}
                                                        </div>
                                                        <div class=" ps-3 pe-lg-3">
                                                            <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#following_user">
                                                                <h6>Following</h6>
                                                                <p class="mb-0">{{ $data['following_user'] }}</p>
                                                            </a>
                                                            {{-- <p class="mb-0">{{$data['follow_count']}}</p> --}}
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="alighn-items-center justify-content-center d-flex d-lg-none d-xxl-flex order-1 order-xxl-2" id="updateFollowFollowing" >
                                                        <div>
                                                            <h6>Posts</h6>
                                                            <p class="mb-0">{{ $data['feedsCount'] }}</p>
                                                        </div>
                                                        <div class="ps-3">
                                                            <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#follower_user">
                                                                <h6>Followers</h6>
                                                                <p class="mb-0">{{ $data['follower_user'] }}</p>
                                                            </a>
                                                            {{-- <p class="mb-0">{{$data['user']->total_followers}}</p> --}}
                                                        </div>
                                                        <div class=" ps-3 pe-lg-3">
                                                            <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#following_user">
                                                                <h6>Following</h6>
                                                                <p class="mb-0">{{ $data['following_user'] }}</p>
                                                            </a>
                                                            {{-- <p class="mb-0">{{$data['follow_count']}}</p> --}}
                                                        </div>
                                                    </li>
                                                @endif
                                            </ul>
                                            @if (!$data['self_profile'] && !$data['check_friends'])
                                                <ul class="social-data-block px-2 list-inline mb-0 pb-0">
                                                    <li class="border btn-icon rounded">
                                                        <div class="dropdown">
                                                            <span class="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                                <svg height="22px" viewBox="0 0 22 22" width="22px"><circle cx="11" cy="6" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle><circle cx="11" cy="11" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle><circle cx="11" cy="16" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle></svg>
                                                            </span>
                                                            <div class="dropdown-menu">
                                                                @if(!$data['check_friends'])
                                                                    @if($data['userFollow'])
                                                                        <a href="javascript:void();" class="dropdown-item" id="unfollowFriend" data-bs-toggle="modal" data-bs-target="#unfollow-modal_profile" action="javascript:void();">Following</a>
                                                                        <a class="dropdown-item d-none" id="followFriend" href="javascript:void(0);" onclick="followFriend()">Follow</a>
                                                                    @else
                                                                        <a href="javascript:void();" class="dropdown-item d-none" id="unfollowFriend" data-bs-toggle="modal" data-bs-target="#unfollow-modal_profile" action="javascript:void();">Following</a>
                                                                        <a class="dropdown-item" id="followFriend" href="javascript:void(0);" onclick="followFriend()">Follow</a>
                                                                    @endif
                                                                @endif
                                                                <a href="javascript:void();" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#block-user-modal_profile" action="javascript:void();">Block</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            @endif
                                        </div>
                                        <div class="modal fade" id="unfollow-modal_profile" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="delete-modalLabel" aria-hidden="true" >
                                            <div class="modal-dialog   modal-fullscreen-sm-down">
                                            <div class="modal-content">
                                                    <div class="modal-header"style="align-items: flex-start;">
                                                        <div class="d-flex align-items-center">
                                                            @if(isset($data['user']->avatar_location) && $data['user']->avatar_location !== ''  && is_file(public_path('storage/images/user/userProfileandCovers/'.$data['user']->id.'/'.$data['user']->avatar_location)))
                                                                <img src="{{ asset('storage/images/user/userProfileandCovers/'. $data['user']->id.'/'.$data['user']->avatar_location) }}" alt="userimg" class="avatar-80 rounded-circle" loading="lazy">
                                                            @else
                                                            {{-- <img src="{{asset('images/user/1.jpg')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy"> --}}
                                                            <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                                            @endif
                                                            <h5 class="modal-title ms-3" id="delete-modalLabel">Are you sure you want to unfollow {{$data['user']->first_name}} {{$data['user']->last_name}} ?</h5>
                                                        </div>
                                                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                            <span class="material-symbols-outlined">close</span>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body align-self-end">
                                                        <div class="d-flex align-items-center">
                                                            <button data-bs-dismiss="modal" onclick="unfollowFriend()" class="btn btn-primary me-2">Yes</button>
                                                            <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="block-user-modal_profile" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="delete-modalLabel" aria-hidden="true" >
                                            <div class="modal-dialog   modal-fullscreen-sm-down">
                                            <div class="modal-content">
                                                    <div class="modal-header"style="align-items: flex-start;">
                                                        <h5 class="modal-title ms-3" style="max-width:400px;" id="delete-modalLabel">Are you sure you want to block {{$data['user']->first_name}} {{$data['user']->last_name}}?</h5>
                                                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                            <span class="material-symbols-outlined">close</span>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body align-self-end">
                                                        <p style="color:red" class="mx-3">
                                                            Once you block someone, that person can no longer see things you post on your timeline, start a conversation with you, or add you as a friend.
                                                        </p>
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            <button data-bs-dismiss="modal" onclick="blockFriend()" class="btn btn-primary me-2">Yes</button>
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
                    @if (isset($data['follower_user']) && $data['follower_user'] > 0)
                        <div class="modal fade follower_user" id="follower_user" tabindex="-1"  aria-labelledby="follower_user-modalLabel" aria-hidden="true" style="margin-top:5rem;">
                            <div class="modal-dialog followers_following_model_width">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="follower_user-modalLabel">All Followers</h5>
                                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                        <span class="material-symbols-outlined">close</span>
                                        </a>
                                    </div>
                                    <div class="row" style="width:100%">
                                        <div class="container" style="overflow-y: auto; max-height: 400px; padding: 0px 15px">
                                            @foreach($data['allFollowers'] as $follower)
                                                @if(isset($follower['getUserDetailsFollowers']) && isset($follower['getUserDetailsFollowers']->username))
                                                    <div class="d-flex flex-row bd-highlight align-items-center my-3" >
                                                        <div class="col-md-12 p-2 bd-highlight">
                                                            @if(isset($follower['getUserDetailsFollowers']->username))
                                                                <a href="{{ route('user-profile', ['username' => $follower['getUserDetailsFollowers']->username]) }}">
                                                                    @if (isset($follower['getUserDetailsFollowers']->avatar_location) && $follower['getUserDetailsFollowers']->avatar_location !== '' && is_file(public_path('storage/images/user/userProfileandCovers/'.$follower['getUserDetailsFollowers']->id.'/'.$follower['getUserDetailsFollowers']->avatar_location)))
                                                                        <img src="{{ asset('storage/images/user/userProfileandCovers/' . $follower['getUserDetailsFollowers']->id . '/' . $follower['getUserDetailsFollowers']->avatar_location) }}" class="avatar-40" alt="profile-img" style="object-fit: cover;">
                                                                    @else
                                                                        <img src="{{ asset('images/user/Users_150x150.png') }}" alt="profile-img" class="avatar-40" style="object-fit: cover;">
                                                                    @endif
                                                                    <span class="requestUserName">{{$follower['getUserDetailsFollowers']->first_name.' '.$follower['getUserDetailsFollowers']->last_name}}</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        {{-- <div class="col-md-4 p-2 bd-highlight">
                                                            <button class="btn w-100 btn-sm btn-primary">Dummy Button</button>
                                                        </div> --}}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="modal fade follower_user" id="follower_user" tabindex="-1"  aria-labelledby="follower_user-modalLabel" aria-hidden="true" style="margin-top:5rem;">
                            <div class="modal-dialog followers_following_model_width">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="follower_user-modalLabel">All Followers</h5>
                                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                        <span class="material-symbols-outlined">close</span>
                                        </a>
                                    </div>
                                    <div class="row" style="width:100%">
                                        <div class="container" style="overflow-y: auto; max-height: 400px; padding: 0px 15px">
                                            <div class="d-flex flex-row bd-highlight align-items-center my-3" >
                                                <div class="col-md-12 p-2 bd-highlight">
                                                    <span class="requestUserName">No follower Found!</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (isset($data['following_user']) && $data['following_user'] > 0)
                        <div class="modal fade following_user" id="following_user" tabindex="-1"  aria-labelledby="following_user-modalLabel" aria-hidden="true" style="margin-top:5rem;">
                            <div class="modal-dialog followers_following_model_width">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="following_user-modalLabel">All Following</h5>
                                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                        <span class="material-symbols-outlined">close</span>
                                        </a>
                                    </div>
                                    <div class="row" style="width:100%">
                                        <div class="container" style="overflow-y: auto; max-height: 400px; padding: 0px 15px">
                                            @foreach($data['allFollowing'] as $following)
                                                @if(isset($following['getUserDetailsFollowing']))
                                                    <div class="d-flex flex-row bd-highlight align-items-center my-3" >
                                                        <div class="col-md-12 p-2 bd-highlight">
                                                            @if(isset($following['getUserDetails']->username))
                                                                <a href="{{ route('user-profile', ['username' => $following['getUserDetails']->username]) }}">
                                                                    @if (isset($following['getUserDetails']->avatar_location) && $following['getUserDetails']->avatar_location !== '' && is_file(public_path('storage/images/user/userProfileandCovers/'.$following['getUserDetails']->id.'/'.$following['getUserDetails']->avatar_location)))
                                                                        <img src="{{ asset('storage/images/user/userProfileandCovers/' . $following['getUserDetails']->id . '/' . $following['getUserDetails']->avatar_location) }}" class="avatar-40" alt="profile-img" style="object-fit: cover;">
                                                                    @else
                                                                        <img src="{{ asset('images/user/Users_150x150.png') }}" alt="profile-img" class="avatar-40" alt="profile-img" style="object-fit: cover;">
                                                                    @endif
                                                                    <span class="requestUserName">{{$following['getUserDetailsFollowing']->first_name.' '.$following['getUserDetailsFollowing']->last_name}}</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        {{-- <div class="col-md-4 p-2 bd-highlight">
                                                            <button class="btn w-100 btn-sm btn-primary">Dummy Button</button>
                                                        </div> --}}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="modal fade following_user" id="following_user" tabindex="-1"  aria-labelledby="following_user-modalLabel" aria-hidden="true" style="margin-top:5rem;">
                            <div class="modal-dialog followers_following_model_width">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="following_user-modalLabel">All Following</h5>
                                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                        <span class="material-symbols-outlined">close</span>
                                        </a>
                                    </div>
                                    <div class="row" style="width:100%">
                                        <div class="container" style="overflow-y: auto; max-height: 400px; padding: 0px 15px">
                                            <div class="d-flex flex-row bd-highlight align-items-center my-3" >
                                                <div class="col-md-12 p-2 bd-highlight">
                                                    <span class="requestUserName">No following Found!</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body p-0">
                            @if($data['completeLock'] == true)
                                <div class="align-items-md-end card-body d-flex gap-2 justify-content-center p-0" style="padding-top: 40px !important;padding-bottom: 40px !important;">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#8c68cd" version="1.1" id="Capa_1" width="40" height="50px" viewBox="0 0 342.52 342.52" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path d="M171.254,110.681c-14.045,0-25.47,11.418-25.47,25.476v21.773h50.933v-21.773    C196.724,122.104,185.29,110.681,171.254,110.681z"/>
                                                <path d="M171.26,0C76.825,0,0.006,76.825,0.006,171.257c0,94.438,76.813,171.263,171.254,171.263    c94.416,0,171.254-76.825,171.254-171.263C342.514,76.825,265.683,0,171.26,0z M226.225,239.291c0,4.119-3.339,7.446-7.458,7.446    h-95.032c-4.113,0-7.446-3.327-7.446-7.446v-73.91c0-4.119,3.333-7.458,7.446-7.458h7.152V136.15    c0-22.266,18.113-40.361,40.367-40.361c22.251,0,40.355,18.095,40.355,40.361v21.773h7.151c4.119,0,7.458,3.338,7.458,7.458v73.91    H226.225z"/>
                                            </g>
                                        </g>
                                    </svg>
                                    <div>
                                        <p class="fw-semibold" style="max-height: 10px;">This account is private</p>
                                        <p style=" margin-bottom: 0rem;">Only followers and friends can see this account.</p>
                                    </div>
                                </div>
                            @else
                                <div class="user-tabing">
                                    <ul class="nav nav-pills d-flex align-items-center justify-content-center profile-feed-items p-0 m-0">
                                        <li class="nav-item col-12 col-sm-3 p-0">
                                            <a class="nav-link @if(!isset($pg)) active  @endif " href="#pills-timeline-tab" id="timeline-title-hide" data-bs-toggle="pill" data-bs-target="#timeline" role="button">Timeline</a>
                                        </li>
                                        <li class="nav-item col-12 col-sm-3 p-0 ">
                                            <a style="font-weight: normal !important;" class="align-items-center d-flex h1 justify-content-center nav-link @if(isset($pg) && $pg==2)) active @endif" href="#pills-about-tab" data-bs-toggle="pill" data-bs-target="#about"   role="button">About 
                                                @if($data['lock'] == true)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" fill="#8c908a" width="20px" height="20px" viewBox="0 0 448 512"><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
                                                @endif
                                            </a>
                                        </li>
                                        <li class="nav-item col-12 col-sm-3 p-0">
                                            <a class="nav-link" href="#pills-friends-tab" data-bs-toggle="pill" id="show-friends" data-bs-target="#friendsTab" role="button">Friends</a>
                                        </li>
                                        <li class="nav-item col-12 col-sm-3 p-0">
                                            <a class="nav-link" href="#pills-photos-tab" data-bs-toggle="pill" id="show-photos" data-bs-target="#photos" role="button">Photos</a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if($data['completeLock'] == false)
                    <div class="col-sm-12">
                        <div class="tab-content">
                            <div class="tab-pane fade @if(!isset($pg)) active show @endif  " id="timeline" role="tabpanel">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="d-xxl-none">
                                            @if ($data['self_profile'])
                                                <div class="card">
                                                    <div class="card-body">
                                                        <a href="{{route('user.favoriteFeeds')}}"><span class="badge badge-pill bg-primary font-weight-normal ms-auto me-1 material-symbols-outlined md-14">grade</span> See your favorite feeds</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-none d-xxl-block col-xxl-4">
                                            @if ($data['self_profile'])
                                                <div class="card">
                                                    <div class="card-body">
                                                        <a href="{{route('user.favoriteFeeds')}}"><span class="badge badge-pill bg-primary font-weight-normal ms-auto me-1 material-symbols-outlined md-14">grade</span> See your favorite feeds</a>
                                                    </div>
                                                </div>
                                            @endif
                                            {{-- <div class="card">
                                                <div class="card-header d-flex justify-content-between">
                                                    <div class="header-title">
                                                        <h4 class="card-title">Life Event</h4>
                                                    </div>
                                                    <div class="card-header-toolbar d-flex align-items-center">
                                                        <p class="m-0"><a href="javacsript:void();"> Create </a></p>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                        <div class="event-post position-relative">
                                                            <a href="javascript:void();"><img src="{{asset('images/page-img/07.jpg')}}" alt="gallary-image" class="img-fluid rounded"></a>
                                                            <div class="job-icon-position">
                                                                <div class="job-icon bg-primary p-2 d-inline-block rounded-circle material-symbols-outlined text-white">
                                                                    local_mall
                                                                </div>
                                                            </div>
                                                            <div class="card-body text-center p-2">
                                                                <h5>Started New Job at Apple</h5>
                                                                <p>January 24, 2019</p>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                        <div class="event-post position-relative">
                                                            <a href="javascript:void();"><img src="{{asset('images/page-img/06.jpg')}}" alt="gallary-image" class="img-fluid rounded"></a>
                                                            <div class="job-icon-position">
                                                                <div class="job-icon bg-primary p-2 d-inline-block rounded-circle material-symbols-outlined text-white">
                                                                    local_mall
                                                                </div>
                                                            </div>
                                                            <div class="card-body text-center p-2">
                                                                <h5>Freelance Photographer</h5>
                                                                <p class="mb-0">January 24, 2019</p>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="fixedElement hoverToScroll">
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="header-title">
                                                            <h4 class="card-title">Photos</h4>
                                                        </div>
                                                        @if ($data['self_profile'])
                                                            <div class="card-header-toolbar d-flex align-items-center">
                                                                <p class="m-0"><a href="javacsript:void();" onclick="goToPhotos()">See all Photos </a></p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if($data['feedsLock'] == false)
                                                        <div class="card-body">
                                                            <ul class="profile-img-gallary p-0 m-0 list-unstyled " id="timeLinePhoto">
                                                                @if($data['profileImages']->count() >= 10)
                                                                        @foreach ($data['profileImages']->slice(0, 9) as $img)
                                                                            @if(is_file(public_path('storage/images/user/userProfileandCovers/'.$img->user_id.'/'.$img->image_path)))
                                                                                <li class="">
                                                                                    <a href="javascript:void();">
                                                                                        @if (isset($img) && $img !== ''  && is_file(public_path('storage/images/user/userProfileandCovers/'.$img->user_id.'/'.$img->image_path)))
                                                                                            <a data-fslightbox="gallery" href="{{ asset('storage/images/user/userProfileandCovers/' . $img->user_id . '/' . $img->image_path) }}">
                                                                                                <img src="{{ asset('storage/images/user/userProfileandCovers/' . $img->user_id . '/' . $img->image_path) }}" alt="" width="90px" height="90px" class="rounded"/>
                                                                                            </a>
                                                                                        @else
                                                                                            <img src="{{ asset('images/page-img/g1.jpg') }}" alt="" class="img-fluid" />
                                                                                        @endif
                                                                                    </a>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                    @foreach ($data['profileImages'] as $img)
                                                                        @if(is_file(public_path('storage/images/user/userProfileandCovers/'.$img->user_id.'/'.$img->image_path)))
                                                                            <li class="">
                                                                                <a href="javascript:void();">
                                                                                    @if (isset($img) && $img !== '')
                                                                                        <a data-fslightbox="gallery" href="{{ asset('storage/images/user/userProfileandCovers/' . $img->user_id . '/' . $img->image_path) }}">
                                                                                            <img src="{{ asset('storage/images/user/userProfileandCovers/' . $img->user_id . '/' . $img->image_path) }}" alt="" width="90px" height="90px" class="rounded"/>
                                                                                        </a>
                                                                                    @else
                                                                                        <img src="{{ asset('images/page-img/g1.jpg') }}" alt="" class="img-fluid" />
                                                                                    @endif
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="header-title">
                                                            <h4 class="card-title">Friends</h4>
                                                            @if($data['friends']->count() != 0)
                                                                {{$data['friends']->count() == 0 ? '' : ($data['friends']->count() <= 1 ? $data['friends']->count().' Friend' : $data['friends']->count().' Friends')}}
                                                            @endif
                                                        </div>
                                                        <div class="card-header-toolbar d-flex align-items-center">
                                                            <p class="m-0"><a href="javacsript:void();" onclick="goToFriends()">See all Friends </a></p>
                                                        </div>
                                                    </div>
                                                    @if($data['feedsLock'] == false)
                                                        <div class="card-body">
                                                            <ul class="profile-img-gallary p-0 m-0 list-unstyled ">
                                                                {{-- @foreach ($data['friends'][0]['getfriends'] as $friend) --}}
                                                                @if($data['friends']->count() >= 10)
                                                                    @foreach ($data['friends']->slice(0, 9) as $friend)
                                                                        <li class="" style="max-width: 92px">
                                                                            {{-- <a href="{{ route('user-profile', ['username' => $friend->username]) }}"> --}}
                                                                                @if (isset($friend->avatar_location) && $friend->avatar_location !== '' && is_file(public_path('storage/images/user/userProfileandCovers/'.$friend->id.'/'.$friend->avatar_location)))
                                                                                    <img src="{{ asset('storage/images/user/userProfileandCovers/' . $friend->id . '/' . $friend->avatar_location) }}" alt="" class="img-fluid-profile-friends-list rounded" />
                                                                                @else
                                                                                    <img src="{{ asset('images/user/Users_150x150.png') }}" alt="" class="img-fluid" />
                                                                                @endif
                                                                            {{-- </a> --}}
                                                                                @if (isset($friend->username) && $friend->username !== '')
                                                                                    <a href="{{ route('user-profile', ['username' => $friend->username]) }}">
                                                                                        <h6 class="mt-2 text-center">{{ $friend->first_name }}</h6>
                                                                                    </a>
                                                                                @else
                                                                                    <h6 class="mt-2 text-center">{{ $friend->first_name }}</h6>
                                                                                @endif
                                                                        </li>
                                                                    @endforeach
                                                                @else
                                                                    @foreach ($data['friends'] as $friend)
                                                                        <li class="" style="max-width: 92px">
                                                                            {{-- <a href="{{ route('user-profile', ['username' => $friend->username]) }}"> --}}
                                                                                @if (isset($friend->avatar_location) && $friend->avatar_location !== '' && is_file(public_path('storage/images/user/userProfileandCovers/'.$friend->id.'/'.$friend->avatar_location)))
                                                                                    <img src="{{ asset('storage/images/user/userProfileandCovers/' . $friend->id . '/' . $friend->avatar_location) }}" alt="" class="img-fluid-profile-friends-list rounded" />
                                                                                @else
                                                                                    <img src="{{ asset('images/user/Users_150x150.png') }}" alt="" class="img-fluid" />
                                                                                @endif
                                                                            {{-- </a> --}}
                                                                                @if (isset($friend->username) && $friend->username !== '')
                                                                                    <a href="{{ route('user-profile', ['username' => $friend->username]) }}">
                                                                                        <h6 class="mt-2 text-center">{{ $friend->first_name }}</h6>
                                                                                    </a>
                                                                                @else
                                                                                    <h6 class="mt-2 text-center">{{ $friend->first_name }}</h6>
                                                                                @endif
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @include('partials._profile_feeds')
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(isset($pg)) show active  @endif" id="about" role="tabpanel">
                                @if($data['lock'] != true || $data['user']->id == auth()->user()->id)
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <ul class="nav nav-pills basic-info-items list-inline d-block p-0 m-0">
                                                        <li>
                                                            <a class="nav-link active" href="#v-pills-basicinfo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-basicinfo-tab" role="button">Contact and Basic Info</a>
                                                        </li>
                                                        <li>
                                                            <a class="nav-link" href="#v-pills-details-tab" data-bs-toggle="pill" data-bs-target="#v-pills-details-tab" role="button">Hobbies and Interests</a>
                                                        </li>
                                                        <li>
                                                            <a class="nav-link" href="#v-pills-family-tab" data-bs-toggle="pill" data-bs-target="#v-pills-family" role="button">Family and Relationship</a>
                                                        </li>
                                                        <li>
                                                            <a class="nav-link" href="#v-pills-work-tab" data-bs-toggle="pill" data-bs-target="#v-pills-work-tab" role="button">Work and Education</a>
                                                        </li>
                                                        <li>
                                                            <a class="nav-link" href="#v-pills-lived-tab" data-bs-toggle="pill" data-bs-target="#v-pills-lived-tab" role="button">Places You've Lived</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @include('partials._profile_about_section')
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="card">
                                        <div class="align-items-center card-body d-flex gap-2 justify-content-center p-0" style="padding-top: 40px !important;padding-bottom: 40px !important;">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#8c68cd" version="1.1" id="Capa_1" width="40" height="50px" viewBox="0 0 342.52 342.52" xml:space="preserve">
                                                <g>
                                                    <g>
                                                        <path d="M171.254,110.681c-14.045,0-25.47,11.418-25.47,25.476v21.773h50.933v-21.773    C196.724,122.104,185.29,110.681,171.254,110.681z"/>
                                                        <path d="M171.26,0C76.825,0,0.006,76.825,0.006,171.257c0,94.438,76.813,171.263,171.254,171.263    c94.416,0,171.254-76.825,171.254-171.263C342.514,76.825,265.683,0,171.26,0z M226.225,239.291c0,4.119-3.339,7.446-7.458,7.446    h-95.032c-4.113,0-7.446-3.327-7.446-7.446v-73.91c0-4.119,3.333-7.458,7.446-7.458h7.152V136.15    c0-22.266,18.113-40.361,40.367-40.361c22.251,0,40.355,18.095,40.355,40.361v21.773h7.151c4.119,0,7.458,3.338,7.458,7.458v73.91    H226.225z"/>
                                                    </g>
                                                </g>
                                            </svg>
                                            <div >
                                                <p class="fw-semibold" style="max-height: 10px;">User's About Section is Locked</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="friendsTab" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h2>Friends</h2>
                                        <div class="friend-list-tab mt-2">
                                            <ul class="nav nav-pills d-flex align-items-center justify-content-left friend-list-items p-0 mb-2">
                                                <li>
                                                    <a class="nav-link active" data-bs-toggle="pill" href="#pill-all-friends" data-bs-target="#all-friends">All Friends</a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" data-bs-toggle="pill" href="#pill-recently-add" data-bs-target="#recently-add">Recently Added</a>
                                                </li>
                                                {{-- <li>
                                                    <a class="nav-link" data-bs-toggle="pill" href="#pill-closefriends" data-bs-target="#closefriends"> Close friends</a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" data-bs-toggle="pill" href="#pill-home" data-bs-target="#home-town"> Home/Town</a>
                                                </li> --}}
                                                <li>
                                                    <a class="nav-link" data-bs-toggle="pill" href="#pill-following" data-bs-target="#following">Following</a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" data-bs-toggle="pill" href="#pill-followers" data-bs-target="#followers">Followers</a>
                                                </li>
                                                <li>
                                                    <a class="nav-link" data-bs-toggle="pill" href="#pill-blocked" data-bs-target="#blocked">Blocked</a>
                                                </li>
                                            </ul>
                                            @include('partials._profile_friends_tab')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="photos" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h2>Photos</h2>
                                        <div class="friend-list-tab mt-2">
                                            <ul class="nav nav-pills d-flex align-items-center justify-content-left friend-list-items p-0 mb-2">
                                                <li><a class="nav-link active" data-bs-toggle="pill" href="#pill-photosofyou" data-bs-target="#photosofyou{{$data['user']->id}}">Photos of You</a></li>
                                                <li><a class="nav-link" data-bs-toggle="pill" href="#pill-your-photos" data-bs-target="#your-photos">Your Photos</a></li>
                                                <li><a class="nav-link" data-bs-toggle="pill" href="#pill-albums" data-bs-target="#albums" onclick="backToAlbum({{$user->id}})">Albums</a></li>
                                                <li><a class="nav-link" data-bs-toggle="pill" href="#pill-your-videos" data-bs-target="#your-videos">Videos</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane fade active show photosofyou" id="photosofyou{{$data['user']->id}}" role="tabpanel">
                                                    {{-- <div class="card-body p-0">
                                                        <div class="d-grid gap-3 d-grid-template-1fr-13">
                                                            @foreach ($data['profileImages'] as $img)
                                                                <div class="">
                                                                    <div class="user-images position-relative overflow-hidden">
                                                                            @if (isset($img) && $img !== '')
                                                                                <a data-fslightbox="gallery" href="{{ asset('storage/images/user/userProfileandCovers/' . $img->user_id . '/' . $img->image_path) }}">
                                                                                    <img src="{{ asset('storage/images/user/userProfileandCovers/' . $img->user_id . '/' . $img->image_path) }}" class="rounded" width="230px" height="230px" style="object-fit: cover;">
                                                                                </a>
                                                                            @else
                                                                                <img src="{{ asset('images/page-img/51.jpg') }}" class="img-fluid rounded" alt="Responsive image">
                                                                            @endif
                                                                            <div class="image-hover-data">
                                                                                <div class="product-elements-icon">
                                                                                <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                                                    <li><a href="javascript:void();" class="pe-3 text-white d-flex align-items-center"> 60 <i class="material-symbols-outlined md-14 ms-1">
                                                                                        thumb_up
                                                                                        </i> </a>
                                                                                    </li>
                                                                                    <li><a href="javascript:void();" class="pe-3 text-white d-flex align-items-center"> 30 <span class="material-symbols-outlined  md-14 ms-1">
                                                                                        chat_bubble_outline
                                                                                        </span> </a>
                                                                                    </li>
                                                                                    <li><a href="javascript:void();" class="pe-3 text-white d-flex align-items-center"> 10 <span class="material-symbols-outlined md-14 ms-1">
                                                                                        forward
                                                                                        </span></a>
                                                                                    </li>
                                                                                </ul>
                                                                                </div>
                                                                            </div>
                                                                        @if ($data['self_profile'])
                                                                            <a href="javascript:void(0);" onclick="deletePicture({{$img->id}})" class="image-edit-btn material-symbols-outlined md-16" data-bs-toggle="tooltip" data-bs-placement="top" title="">delete</a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-12">
                                                        <div class="d-grid gap-2 grid-cols--2 grid-cols--sm-3 grid-cols--xl-4 grid-cols--xxl-5">
                                                            @foreach ($data['profileImages'] as $img)
                                                                <div class="">
                                                                    <div class="user-images" style="margin-top: 13px !important;">
                                                                        @if (isset($img) && $img !== '')
                                                                        <a data-fslightbox="gallery" href="{{ asset('storage/images/user/userProfileandCovers/' . $img->user_id . '/' . $img->image_path) }}">
                                                                            <img src="{{ asset('storage/images/user/userProfileandCovers/' . $img->user_id . '/' . $img->image_path) }}" class="rounded" style="object-fit: cover; width: -webkit-fill-available; height:170px;">
                                                                        </a>
                                                                        @else
                                                                            <img src="{{ asset('images/page-img/51.jpg') }}" class="rounded" style="object-fit: cover; width: -webkit-fill-available; height:170px;">
                                                                        @endif
                                                                        {{-- <div class="image-hover-data">
                                                                            <div class="product-elements-icon">
                                                                            <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                                                <li><a href="javascript:void();" class="pe-3 text-white d-flex align-items-center"> 60 <i class="material-symbols-outlined md-14 ms-1">
                                                                                    thumb_up
                                                                                    </i> </a>
                                                                                </li>
                                                                                <li><a href="javascript:void();" class="pe-3 text-white d-flex align-items-center"> 30 <span class="material-symbols-outlined  md-14 ms-1">
                                                                                    chat_bubble_outline
                                                                                    </span> </a>
                                                                                </li>
                                                                                <li><a href="javascript:void();" class="pe-3 text-white d-flex align-items-center"> 10 <span class="material-symbols-outlined md-14 ms-1">
                                                                                    forward
                                                                                    </span></a>
                                                                                </li>
                                                                            </ul>
                                                                            </div>
                                                                        </div> --}}
                                                                        @if ($data['self_profile'])
                                                                            <a href="javascript:void(0);" onclick="deletePicture({{$img->id}})" class="photoofyou-image-edit-btn material-symbols-outlined md-16" data-bs-toggle="tooltip" data-bs-placement="top" title="">delete</a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="your-photos" role="tabpanel">
                                                    <div class="card-body p-0">
                                                        <div class="d-grid gap-3 d-grid-template-1fr-13 ">
                                                            @foreach ($data['feedImages'] as $img)
                                                                <div class="">
                                                                    <div class="user-images position-relative overflow-hidden">
                                                                        <a href="javascript:void();">
                                                                            @if (isset($img) && $img !== '')
                                                                                <a data-fslightbox="gallery" href="{{ asset('storage/images/feed-img/' . $img->user_id . '/' . $img->attachment) }}">
                                                                                    <img src="{{ asset('storage/images/feed-img/' . $img->user_id . '/' . $img->attachment) }}" class="rounded image-height-max" width="100%" height="100%" style="object-fit: cover;">
                                                                                    {{-- <img src="{{asset('storage/images/feed-img/'.$img->user_id.'/'.$img->attachment)}}" class="rounded" max-width="300px" max-height="300px" alt="Responsive image"> --}}
                                                                                </a>
                                                                            @else
                                                                                <img src="{{ asset('images/page-img/51.jpg') }}" class="img-fluid rounded" width="100%" height="100%" style="object-fit: cover;">
                                                                            @endif
                                                                        </a>
                                                                        {{-- <div class="image-hover-data">
                                                                            <div class="product-elements-icon">
                                                                            <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                                                <li><a href="javascript:void();" class="pe-3 text-white d-flex align-items-center"> 60 <i class="material-symbols-outlined md-14 ms-1">
                                                                                    thumb_up
                                                                                    </i> </a>
                                                                                </li>
                                                                                <li><a href="javascript:void();" class="pe-3 text-white d-flex align-items-center"> 30 <span class="material-symbols-outlined  md-14 ms-1">
                                                                                    chat_bubble_outline
                                                                                    </span> </a>
                                                                                </li>
                                                                                <li><a href="javascript:void();" class="pe-3 text-white d-flex align-items-center"> 10 <span class="material-symbols-outlined md-14 ms-1">
                                                                                    forward
                                                                                    </span></a>
                                                                                </li>
                                                                            </ul>
                                                                            </div>
                                                                        </div> --}}
                                                                        {{-- <a href="javascript:void();" class="image-edit-btn material-symbols-outlined md-16" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit or Remove">drive_file_rename_outline</a> --}}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="albums" role="tabpanel">
                                                    <div class="row gap-3">
                                                        <div class="container">
                                                            <div class="col-md-12" id="wholeAlbumForm">
                                                                @if ($data['self_profile'])
                                                                    <div id="createAlbum">
                                                                        <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#create-albums" class="material-symbols-outlined md-18" id="submitButtonBack">
                                                                            add
                                                                        </a><span>Create Album</span>
                                                                    </div>
                                                                @endif
                                                                <div class="modal fade" id="create-albums" aria-labelledby="groupPost-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 4rem">
                                                                    <div class="modal-dialog  modal-groupCreatePost">
                                                                        <div class="modal-content" id="hideAlbumForm">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="groupPost-modalLabel">Create Album
                                                                                </h5>
                                                                                <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                                                    <span class="material-symbols-outlined">close</span>
                                                                                </a>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="container">
                                                                                        <div class="panel panel-primary">
                                                                                            <div class="panel-body">
                                                                                                <form method="POST" action="" class="post-text ms-3 w-100" action="javascript:void();" enctype="multipart/form-data" id="createAlbumFormSubmit">
                                                                                                    @csrf
                                                                                                    <input type="text" id="albumName" name="albumName" required class="form-control rounded" placeholder="Write Album Name" style="border:none;">
                                                                                                    <input type="hidden" class="form-control rounded" value={{ $user->id }} name="userId" style="border:none;">
                                                                                                    <hr>
                                                                                                    <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                                                                                                        <li class="col-md-6 mb-3">
                                                                                                            <input type="file" multiple name="albumsImage[]" required class="form-control" accept="image/*" id="albumsImage" placeholder="Albums Image" style="border:none;" onchange="previewalbumImages()">
                                                                                                            <div id="previewalbum" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 8px; overflow-y: auto; max-height: 300px;min-width: 500px;"></div>
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                    <button type="submit" class="btn btn-primary d-block w-100 mt-3" id="createAlbumButtonClick">Create Album</button>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row userAlbum ajaxuseralbumshow" id="ajaxuseralbumshow{{$data['user']->id}}">
                                                                <div class="d-grid gap-2 grid-cols--2 grid-cols--sm-3 grid-cols--xl-4 grid-cols--xxl-5">
                                                                    @foreach ($data['UserAlbum'] as $userAlbumData)
                                                                        @if(isset($userAlbumData->getAlbumImages))
                                                                            <div class="">
                                                                                <div class="card user-images" >
                                                                                    <a href="javascript:void(0);" onclick="showAlbumImages({{$userAlbumData->id}}, {{$data['user']->id}})">
                                                                                        @if (isset($userAlbumData))
                                                                                            <img src="{{ asset('/storage/images/album-img/'.$data['user']->id.'/'.$userAlbumData->album_name.'/'.$userAlbumData->getAlbumImages[0]->image_path) }}" class="rounded" style="object-fit: cover; width: -webkit-fill-available; height:170px;" alt="Album main image">
                                                                                        @endif
                                                                                        <div class="card-body">
                                                                                            {{-- <span>({{count($userAlbumData->getAlbumImages)}})</span> --}}
                                                                                            <h5 class="card-title" style="color: var(--bs-primary)">{{$userAlbumData->album_name}}</h5>
                                                                                        </div>
                                                                                    </a>
                                                                                    @if ($data['self_profile'])
                                                                                        @if (isset($userAlbumData->album_name) && $userAlbumData->album_name == 'Cover')
    
                                                                                            @elseif (isset($userAlbumData->album_name) && $userAlbumData->album_name == 'Profile')
    
                                                                                            @else
                                                                                                <a href="javascript:void(0);" onclick="deleteAlbum({{$userAlbumData->id}})" class="album-image-edit-btn material-symbols-outlined md-16" data-bs-toggle="tooltip" data-bs-placement="top" title="">delete</a>
                                                                                        @endif
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="row show_pop_up_div d-none">
                                                                @if ($data['self_profile'])
                                                                    <div id="createAlbum">
                                                                        <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#add_photo_album" class="material-symbols-outlined md-18" id="backAddPhotos">
                                                                            add
                                                                        </a><span>Add Photos</span>
                                                                    </div>
                                                                @endif
                                                                <div class="modal fade" id="add_photo_album" aria-labelledby="groupPost-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
                                                                    <div class="modal-dialog  modal-lg">
                                                                        <div class="modal-content" id="hideAlbumForm">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="groupPost-modalLabel">Add Photos</h5>
                                                                                <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                                                    <span class="material-symbols-outlined">close</span>
                                                                                </a>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="container" style="margin-top:30px;">
                                                                                        <div class="panel panel-primary">
                                                                                            <div class="panel-body">
                                                                                                <form method="POST" action="" class="post-text ms-3 w-100" enctype="multipart/form-data" id="addPhotoAlbumFormSubmit">
                                                                                                    @csrf
                                                                                                    <input type="hidden" class="form-control rounded" value={{ $data['user']->id }} name="userId" style="border:none;">
                                                                                                    <input type="hidden" class="form-control rounded" value="" id="addPhotoAlbumId" name="albumId" style="border:none;">
                                                                                                    <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                                                                                                        <li class="col-md-6 mb-3">
                                                                                                            <input type="file" multiple name="albumsImage[]" required id="albums" class="form-control" accept="image/*" id="addAlbumPhoto" placeholder="Add Album Image" style="border:none;">
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                    <button type="submit" class="btn btn-primary d-block w-100 mt-3" id="addPhotoAlbumButtonClick">Add Photo</button>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-none userAlbumImages show_images" id="userAlbumImages{{$data['user']->id}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="your-videos" role="tabpanel">
                                                    <div class="row">
                                                        @foreach ($data['feedsVideosAttach'] as $video)
                                                        @if(count($video->attachments) > 0 && isset($video->attachments[0]))
                                                            @if ($video->attachments[0]->attachment_type == 'video')
                                                                <div class="col-md-6 my-2">
                                                                    <video width="100%" id="{{ $video->attachments[0]->id }}" height="240" style="border: 1px solid #000;" controls>
                                                                        <source src="{{asset('storage/images/feed-img/'.$video->attachments[0]->user_id . '/' . $video->attachments[0]->attachment)}}">
                                                                    </video>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-12 text-center">
                                <img src="{{asset('images/page-img/page-load-loader.gif')}}" alt="loader" style="height: 100px;">
                            </div> --}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script> --}}
    <script src="{{asset('js/croppie/croppie.js')}}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $uploadCrop = $('#cropie-demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'square'
            },
            boundary: {
                width: 300,
                height: 300
            }
        });


        $('#profile-image').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function() {
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });


        $('.upload-result').on('click', function(ev) {
            $('.cover_spin_ProfilePhotoUpdate').show();
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(resp) {
                $.ajax({
                    url: "{{ route('imageCrop') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "image": resp,
                        "type":"Profile_image"
                    },
                    success: function(data) {
                        $(".updateProfilePhoto").load(" .updateProfilePhoto"+"> *").fadeIn(0);
                        $(".updateNewsFeed").load(" .updateNewsFeed"+"> *").fadeIn(0);
                        $("#drop-down-arrow").hide().load(" #drop-down-arrow"+"> *").fadeIn(0);
                        $("#photos").hide().load(" #photos"+"> *").fadeIn(0);
                        $("#timeLinePhoto").hide().load(" #timeLinePhoto"+"> *").fadeIn(0);
                        setTimeout(function() {
                            $('.cover_spin_ProfilePhotoUpdate').hide();
                            $('#group-post-modal').modal('hide');
                            $("#profile-image").val("");
                            $(".cr-image").attr("src", "");
                            $('#showAndHideButtonProfile').hide();
                        }, 5000);
                    }
                });
            });
        });

    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $uploadCropCover = $('#cropie-demo-cover').croppie({
            enableExif: true,
            viewport: {
                width: 600,
                height: 300,
                type: 'rectangle'
            },
            boundary: {
                width: 700,
                height: 400
            }
        });


        $('#cover-image').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $uploadCropCover.croppie('bind', {
                    url: e.target.result
                }).then(function() {
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });


        $('.upload-result-cover').on('click', function(ev) {
            $('.cover_spin_ProfilePhotoUpdate').show();
            $uploadCropCover.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(resp) {
                $.ajax({
                    url: "{{ route('imageCrop') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "image": resp,
                        "type": "Cover_image"
                    },
                    success: function(data) {
                        $(".updateProfileCoverPhoto").load(" .updateProfileCoverPhoto"+"> *").fadeIn(0);
                        setTimeout(function() {
                            $('.cover_spin_ProfilePhotoUpdate').hide();
                            $('#coverphoto-post-modal').modal('hide');
                            $("#cover-image").val("");
                            $(".cr-image").attr("src", "");
                            $('#showAndHideButtonCover').hide();
                        }, 3000);

                    }
                });
            });
        });

    </script>
    <script>
        window.onload = function() {
            //Reference the DropDownList.
            var workStartYear = document.getElementById("workStartYear");
            var workEndYear = document.getElementById("workEndYear");
            var workStartYearUpdate = document.getElementById("workStartYearUpdate");
            var workEndYearUpdate = document.getElementById("workEndYearUpdate");
            var eduStartYear = document.getElementById("eduStartYear");
            var eduStartYearUpdate = document.getElementById("eduStartYearUpdate");
            var eduEndYear = document.getElementById("eduEndYear");
            var eduEndYearUpdate = document.getElementById("eduEndYearUpdate");
            var moveYear = document.getElementById("moveYear");
            var moveYearUpdate = document.getElementById("moveYearUpdate");

            //Determine the Current Year.
            var currentYear = (new Date()).getFullYear();

            for (var i = currentYear; i >= 1950; i--) {
                var option = document.createElement("OPTION");
                option.innerHTML = i;
                option.value = i;
                moveYear.appendChild(option);
            }
            for (var i = currentYear; i >= 1950; i--) {
                var option = document.createElement("OPTION");
                option.innerHTML = i;
                option.value = i;
                moveYearUpdate.appendChild(option);
            }
            //Loop and add the Year values to DropDownList.
            for (var i = currentYear; i >= 1950; i--) {
                var option = document.createElement("OPTION");
                option.innerHTML = i;
                option.value = i;
                workStartYear.appendChild(option);
            }
            for (var i = currentYear; i >= 1950; i--) {
                var option = document.createElement("OPTION");
                option.innerHTML = i;
                option.value = i;
                workStartYearUpdate.appendChild(option);
            }

            //Loop and add the Year values to DropDownList.
            for (var i = currentYear; i >= 1950; i--) {
                var option = document.createElement("OPTION");
                option.innerHTML = i;
                option.value = i;
                workEndYear.appendChild(option);
            }
            for (var i = currentYear; i >= 1950; i--) {
                var option = document.createElement("OPTION");
                option.innerHTML = i;
                option.value = i;
                workEndYearUpdate.appendChild(option);
            }
            for (var i = currentYear; i >= 1950; i--) {
                var option = document.createElement("OPTION");
                option.innerHTML = i;
                option.value = i;
                eduStartYear.appendChild(option);
            }
            for (var i = currentYear; i >= 1950; i--) {
                var option = document.createElement("OPTION");
                option.innerHTML = i;
                option.value = i;
                eduStartYearUpdate.appendChild(option);
            }

            //Loop and add the Year values to DropDownList.
            for (var i = currentYear; i >= 1950; i--) {
                var option = document.createElement("OPTION");
                option.innerHTML = i;
                option.value = i;
                eduEndYear.appendChild(option);
            }
            for (var i = currentYear; i >= 1950; i--) {
                var option = document.createElement("OPTION");
                option.innerHTML = i;
                option.value = i;
                eduEndYearUpdate.appendChild(option);
            }
        };

        function setupCurrentStatusCheckbox(currentStatusCheckboxId, toYearSelectId) {
            const currentStatusCheckbox = document.querySelector('#' + currentStatusCheckboxId);
            const toYearSelect = document.querySelector('#' + toYearSelectId);
            currentStatusCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    toYearSelect.parentElement.style.display = 'none';
                    document.getElementById('workEndYear').required="";
                    document.getElementById('eduEndYear').required="";
                } else {
                    toYearSelect.parentElement.style.display = '';
                    document.getElementById('workEndYear').required="true";
                    document.getElementById('eduEndYear').required="true";
                }
            });
        }

        // Call the setup function for both forms when the document is ready
        document.addEventListener('DOMContentLoaded', function() {
            setupCurrentStatusCheckbox('current_status_working', 'workEndYear');
            setupCurrentStatusCheckbox('current_status_working_update', 'workEndYearUpdate');
            setupCurrentStatusCheckbox('current_status_education_update', 'eduEndYearUpdate');
            setupCurrentStatusCheckbox('current_status_education', 'eduEndYear');
        });
        $(document).ready(function() {
            //listing showing on-load
            getWorkExperience();
            getprofskills();
            getCollegeList();
            getPlaceList();
            getfamilymemberList();
            getuserstatusList();
            getuserHobbyList();
            $('#add-familymember-modal-edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes
                $.ajax({
                    method: 'POST',
                    url: '/getFamilyMember',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    console.log(response);
                    var strg = response.name
                    var arrg = strg.split(" ");
                    //document.getElementById('familyMember').value = response.name
                    document.getElementById('relationid').value = response.id

                    var select = document.getElementById('familyrelation');
                    var options = select.options;
                    for (var i = 0; i < options.length; i++) {
                        if (options[i].value === response.relation) {
                            select.selectedIndex = i;
                            break;
                        }
                    }


                    var selectmem = document.getElementById('choices-add-family-member');
                    var optionsmem = selectmem.options;
                    for (var i = 0; i < optionsmem.length; i++) {
                        if (optionsmem[i].value === response.name) {
                            select.selectedIndex = i;
                            break;
                        }
                    }
                });
            });
            $('#add-work-modal-edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes
                $.ajax({
                    method: 'POST',
                    url: '/getWorkPlace',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    console.log(response);
                    document.getElementById('workName').value = response.name
                    document.getElementById('workTitle').value = response.title
                    document.getElementById('workCity').value = response.city
                    document.getElementById('workId').value = response.id

                    var myCheckbox = document.getElementById("current_status_working_update");
                    myCheckbox.checked = response.current_status;
                    if (myCheckbox.checked == true) {
                        $("#hidetoselect").hide();
                    } else {
                        $("#hidetoselect").show();
                    }

                    var select = document.getElementById('workStartYearUpdate');
                    var options = select.options;
                    for (var i = 0; i < options.length; i++) {
                        if (options[i].value === response.from_year) {
                            select.selectedIndex = i;
                            break;
                        }
                    }
                    var select = document.getElementById('workEndYearUpdate');
                    var options = select.options;
                    for (var i = 0; i < options.length; i++) {
                        if (options[i].value === response.to_year) {
                            select.selectedIndex = i;
                            break;
                        }
                    }
                });
            });
            $('#edit-professional-skills').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes
                $.ajax({
                    method: 'POST',
                    url: '/getProfessionalSkill',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    console.log(response);
                    document.getElementById('skillname').value = response.name
                    document.getElementById('skillId').value = response.id
                });
            });
            $('#edit-college-data').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes
                $.ajax({
                    method: 'POST',
                    url: '/getCollegeDetails',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    console.log(response);
                    const collegeSelect = document.getElementById('eduName');
                    const collegeOption = document.createElement('option');
                    collegeOption.value = response.name;
                    collegeOption.textContent = response.name;
                    collegeOption.selected = true;
                    collegeOption.disabled = false;
                    collegeSelect.appendChild(collegeOption);
                    document.getElementById('eduTitle').value = response.title
                    document.getElementById('eduCity').value = response.city
                    document.getElementById('eduId').value = response.id

                    var myCheckbox = document.getElementById("current_status_education_update");
                    myCheckbox.checked = response.current_status;
                    console.log(myCheckbox.checked);
                    if (myCheckbox.checked == true) {
                        $("#hidetoselectedu").hide();
                    } else {
                        $("#hidetoselectedu").show();
                    }

                    var select = document.getElementById('eduStartYearUpdate');
                    var options = select.options;
                    for (var i = 0; i < options.length; i++) {
                        if (options[i].value === response.from_year) {
                            select.selectedIndex = i;
                            break;
                        }
                    }
                    var select = document.getElementById('eduEndYearUpdate');
                    var options = select.options;
                    for (var i = 0; i < options.length; i++) {
                        if (options[i].value === response.to_year) {
                            select.selectedIndex = i;
                            break;
                        }
                    }
                });
            });
            $('#edit-places-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes
                $.ajax({
                    method: 'POST',
                    url: '/getLivedPlaces',
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    // Current city edit option append
                    const citySelect = document.getElementById('current-city');
                    const newOption = document.createElement('option');
                    newOption.value = response.current_city;
                    newOption.textContent = response.current_city;
                    newOption.selected = true;
                    newOption.disabled = false;
                    citySelect.appendChild(newOption);
                    // Home town edit option append
                    const townSelect = document.getElementById('home-town');
                    const townOption = document.createElement('option');
                    townOption.value = response.home_town;
                    townOption.textContent = response.home_town;
                    townOption.selected = true;
                    townOption.disabled = false;
                    townSelect.appendChild(townOption);

                    var select = document.getElementById('moveYearUpdate');
                    var options = select.options;
                    for (var i = 0; i < options.length; i++) {
                        if (options[i].value === response.move_year) {
                            select.selectedIndex = i;
                            break;
                        }
                    }
                    var select = document.getElementById('moveMonthUpdate');
                    var options = select.options;
                    for (var i = 0; i < options.length; i++) {
                        if (options[i].value === response.move_month) {
                            select.selectedIndex = i;
                            break;
                        }
                    }
                    document.getElementById('livedId').value = response.id
                    //  document.getElementById('eduId').value = response.id

                    //  var myCheckbox = document.getElementById("current_status_education_update");
                    //  myCheckbox.checked = response.current_status;
                    //  console.log(myCheckbox.checked);
                    //  if (myCheckbox.checked == true) {
                    //      $("#hidetoselectedu").hide();
                    //     }
                    //     else{
                    //     $("#hidetoselectedu").show();
                    //  }

                });
            });
        });

        function followFriend() {
            // var sPageURL = window.location.search.substring();
            var pageURL = $(location).attr("href");
            var userName = pageURL.split("/").pop();
            console.log(pageURL.split("/").pop());
            $.ajax({
                method: 'GET',
                url: '/followUser/' + userName,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                console.log($('#followFriend'));
                $('#followFriend').addClass('d-none');
                $('#unfollowFriend').removeClass('d-none');
                $("#updateFollowFollowing").hide().load(" #updateFollowFollowing"+"> *").fadeIn(0);
                // document.querySelector('.sub-drop-large').classList.add('show');
                // document.getElementById("followFriendhide").innerHTML = "Following";
            });
        }

        function unfollowFriend() {
            // var sPageURL = window.location.search.substring();
            var pageURL = $(location).attr("href");
            var userName = pageURL.split("/").pop();
            console.log(pageURL.split("/").pop());
            $.ajax({
                method: 'GET',
                url: '/unfollowUser/' + userName,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                $('#followFriend').removeClass('d-none');
                $('#unfollowFriend').addClass('d-none');
                $("#updateFollowFollowing").hide().load(" #updateFollowFollowing"+"> *").fadeIn(0);
            });
        }

        function blockFriend() {
            // var sPageURL = window.location.search.substring();
            var pageURL = $(location).attr("href");
            var userName = pageURL.split("/").pop();
            console.log(pageURL.split("/").pop());
            $.ajax({
                method: 'GET',
                url: '/blockFriend/' + userName,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                location.replace('/generalsetting')
            });
        }

        function unblockFriend() {
            // var sPageURL = window.location.search.substring();
            var pageURL = $(location).attr("href");
            var userName = pageURL.split("/").pop();
            console.log(pageURL.split("/").pop());

            $.ajax({
                method: 'GET',
                url: '/unblockFriend/' + userName,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                $('#blockFriend').removeClass('d-none');
                $('#unblockFriend').addClass('d-none');
            });
        }

        function unFriend() {
            // var sPageURL = window.location.search.substring();
            var pageURL = $(location).attr("href");
            var userName = pageURL.split("/").pop();
            console.log(pageURL.split("/").pop());
            $.ajax({
                method: 'GET',
                url: '/unFriend/' + userName,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                $("#updateProfileFriendRequestDiv").hide().load(" #updateProfileFriendRequestDiv"+"> *").fadeIn(0);

            });
        }

        function addToFriend() {
            // var sPageURL = window.location.search.substring();
            var pageURL = $(location).attr("href");
            var userName = pageURL.split("/").pop();
            console.log(pageURL.split("/").pop());
            $.ajax({
                method: 'GET',
                url: '/addToFriend/' + userName,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                $("#updateProfileFriendRequestDiv").hide().load(" #updateProfileFriendRequestDiv"+"> *").fadeIn(0);
            });
        }

        function cancelRequest() {
            // var sPageURL = window.location.search.substring();
            var pageURL = $(location).attr("href");
            var userName = pageURL.split("/").pop();
            console.log(pageURL.split("/").pop());
            $.ajax({
                method: 'GET',
                url: '/cancelRequest/' + userName,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                $("#updateProfileFriendRequestDiv").hide().load(" #updateProfileFriendRequestDiv"+"> *").fadeIn(0);
            });
        }

        $(document).ready(function() {
            $('#my-form').submit(function(event) {
                if ($('#postText').val() == '' && $('#profileImagePost').val() == '') {
                    alert('Please enter at least one field!');
                    event.preventDefault();
                }
            });
        });

        $(document).ready(function() {
            $('#profile-image').change(function() {
            var file = this.files[0];
            var fileType = file.type;
            var validImageTypes = ["image/jpeg", "image/png", "image/jpg"];

            if ($.inArray(fileType, validImageTypes) < 0) {
                $('#error-profile').show();
                $('#showAndHideButtonProfile').hide();
                $('#profileImage').val("");
            } else {
                $('#error-profile').hide();
                $('#showAndHideButtonProfile').show();
            }
            });
        });
        $(document).ready(function() {
            $('#cover-image').change(function() {
            var file = this.files[0];
            var fileType = file.type;
            var validImageTypes = ["image/jpeg", "image/png", "image/jpg"];

        if ($.inArray(fileType, validImageTypes) < 0) {
            $('#error-cover').show();
            $('#showAndHideButtonCover').hide();
            $('#profileImage').val("");
        } else {
            $('#error-cover').hide();
            $('#showAndHideButtonCover').show();
        }
        });
    });
    // function showAlbumImages(albumId, userId){
    //     $.ajax({
    //             method: 'GET',
    //             url: '/showAlbumImages',
    //             data: {userId: userId, albumId :albumId},
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         }).done(function(response) {
    //             $(".userAlbum").hide();
    //             $("#createAlbum").hide();
    //             $(".show_images").removeClass('d-none');
    //             $(".show_pop_up_div").removeClass('d-none');
    //             result='';
    //             response.images.forEach(function(image) {
    //             if(image.image_path != null && image.image_path !== ''){
    //                 src = '/storage/images/album-img'+'/'+response.user_id+'/'+ response.albumdata.album_name +'/'+image.image_path;
    //             }else{
    //                 src = '/images/user/Users_40x40.png';
    //             }
    //             result += '<div class="col-lg-3 col-md-4 col-sm-6 user-images"><img style="margin-top:16px; object-fit: cover;" src="'+src+'" class="rounded" width="230px" height="230px" style="object-fit: cover;" alt="Album main image"><a href="javascript:void(0);" onclick="deleteAlbumInnerPicture('+image.id+","+image.user_album_id+')" class="addimage-edit-btn material-symbols-outlined md-16" data-bs-toggle="tooltip" data-bs-placement="top" title="">delete</a></div>';
    //             });
    //             document.querySelector('.show_images').innerHTML = result;
    //             $("#addPhotoAlbumId").val(response.albumId);
    //         });
    // }
    // function backToAlbum(id){
    //     $(".userAlbum").show();
    //     $("#createAlbum").show();
    //     $(".show_images").addClass('d-none');
    //     $(".show_pop_up_div").addClass('d-none');
    //     updateAlbumDiv(id);
    // }
    </script>
    <script>
        $(document).ready(function(){
            var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount:15,
            searchResultLimit:15,
            renderChoiceLimit:10,
            maxItemText:''
            });

            var multipleCancelButton = new Choices('#choices-multiple-remove-button-edit', {
            removeItemButton: true,
            maxItemCount:15,
            searchResultLimit:15,
            renderChoiceLimit:10,
            maxItemText:''
            });

            var multipleCancelButton = new Choices('#choices-add-family-member', {
            removeItemButton: true,
            maxItemCount:1,
            searchResultLimit:15,
            renderChoiceLimit:10,
            maxItemText:''
            });
        });
        // $('#createAlbumFormSubmit').on('submit', function(e){

        //     e.preventDefault();
        //     // Disable submit button
        //     $('#createAlbumButtonClick').attr('disabled','disabled');

        //     $.ajax({
        //     url:'/createAlbum',
        //     method:$(this).attr('method'),
        //     data:new FormData(this),
        //     processData:false,
        //     dataType:'json',
        //     contentType:false
        //     }).done(function(response){
        //     $('#create-albums').removeClass('show');
        //     $('#create-albums').hide();
        //     $('#create-albums').attr("aria-modal","true");
        //     $('#create-albums').attr("role","dialog");
        //     $('#create-albums').removeAttr("aria-hidden");
        //     $('.modal-backdrop').removeClass("show");
        //     $('.modal-backdrop').hide();
        //     $('.theme-color-default').removeAttr("style");
        //     $('.theme-color-default').removeClass("show");
        //     $('#createAlbumFormSubmit')[0].reset();
        //     updateAlbumDiv(response.user_id);

        //     // Enable submit button
        //     $('#createAlbumButtonClick').removeAttr('disabled');
        //     });
        // });
    // $('#addPhotoAlbumFormSubmit').on('submit', function(e){
    //      e.preventDefault();
    //     // Disable submit button
    //     $('#addPhotoAlbumFormSubmit').attr('disabled','disabled');
    //      $.ajax({
    //         url:'/addPhotoAlbum',
    //         method:$(this).attr('method'),
    //         data:new FormData(this),
    //         processData:false,
    //         dataType:'json',
    //         contentType:false
    //      }).done(function(response){
    //         console.log(response);
    //         //  updateAddAlbumPhotoDiv(response.id);
    //          result='';
    //          response.images.forEach(function(image) {
    //              if(image.image_path != null && image.image_path !== ''){
    //                  src = '/storage/images/album-img'+'/'+response.user_id+'/'+response.albumdata.album_name+'/'+image.image_path;
    //              }else{
    //                  src = '/images/user/Users_40x40.png';
    //              }
    //             //  result += '<div class="col-md-3"><img style="margin-top:16px; object-fit: cover;" src="'+src+'" class="rounded" width="230px" height="230px" style="object-fit: cover;" alt="Album main image"></div>';
    //             result += '<div class="col-lg-3 col-md-4 col-sm-6 user-images"><img style="margin-top:16px; object-fit: cover;" src="'+src+'" class="rounded" width="230px" height="230px" style="object-fit: cover;" alt="Album main image"><a href="javascript:void(0);" onclick="deleteAlbumInnerPicture('+image.id+","+image.user_album_id+')" class="addimage-edit-btn material-symbols-outlined md-16" data-bs-toggle="tooltip" data-bs-placement="top" title="">delete</a></div>';
    //         });
    //         document.querySelector('.show_images').innerHTML = result;
    //         $('#add_photo_album').removeClass('show');
    //         $('#add_photo_album').hide();
    //         $('#add_photo_album').attr("aria-modal","true");
    //         $('#add_photo_album').attr("role","dialog");
    //         $('#add_photo_album').removeAttr("aria-hidden");
    //         $('.modal-backdrop').removeClass("show");
    //         $('.modal-backdrop').hide();
    //         $('.theme-color-default').removeAttr("style");
    //         $('.theme-color-default').removeClass("show");
    //         $('#addPhotoAlbumFormSubmit')[0].reset();

    //         // Enable submit button
    //         $('#addPhotoAlbumFormSubmit').removeAttr('disabled');
    //         });
    //     });

    // function updateAlbumDiv(id)
    //     {
    //         $("#ajaxuseralbumshow"+id).hide().load(" #ajaxuseralbumshow"+id+"> *").fadeIn(200);
    //     }
    // function updateAddAlbumPhotoDiv(id)
    // {
    //     $("#userAlbumImages"+id).hide().load(" #userAlbumImages"+id+"> *").fadeIn(200);
    // }
    // $("#createAlbumButtonClick").click(function(){

    //     $('#createAlbumButtonClick').removeClass('d-block');
    //     $('#createAlbumButtonClick').addClass('d-none');
    // });
    // $("#submitButtonBack").click(function(){
    //     $('#createAlbumButtonClick').addClass('d-block');
    //     $('#createAlbumButtonClick').removeClass('d-none');
    //     $('.modal-backdrop').addClass('show');
    //     $('.modal-backdrop').hide();
    // });
    // $("#addPhotoAlbumButtonClick").click(function(){
    //     $('#addPhotoAlbumButtonClick').removeClass('d-block');
    //     $('#addPhotoAlbumButtonClick').addClass('d-none');
    // });
    // $("#backAddPhotos").click(function(){
    //     $('#addPhotoAlbumButtonClick').addClass('d-block');
    //     $('#addPhotoAlbumButtonClick').removeClass('d-none');
    //     $('.modal-backdrop').addClass('show');
    // });
        //Add Work Experiecnce
        $('#workExpForm').on('submit', function(e){

            e.preventDefault();
            var form = $('#workExpForm')[0];
            var data = new FormData(form);
            $('#workExpForm')[0].reset();
            $.ajax({
                    method: 'POST',
                    url: '/aboutInformation',
                    data: data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    $('#workExpForm')[0].reset();
                    document.getElementById("workExpForm").reset();
                    $("#add-work-modal").modal("hide");
                    //$('#add-work-modal').hide();
                    //$('.modal-backdrop').hide();
                    getWorkExperience();


                });
        });


        //Edit  Work Experiecnce
        $('#aboutInformationUpdateForm').on('submit', function(e){
            e.preventDefault();
            var form = $('#aboutInformationUpdateForm')[0];
            var data = new FormData(form);

            $.ajax({
                    method: 'POST',
                    url: '/aboutInformationUpdate',
                    data: data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            }).done(function(response) {

                $("#add-work-modal-edit").modal("hide");
                getWorkExperience();

            });
        });

        //dele work
        function delEdulist(id,type) {
            $.ajax({
                method: 'GET',
                url: '/delProfileData/'+id+'/'+type,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                getWorkExperience();
            });
        }

        //Get Work Experience
        function getWorkExperience() {

            $.ajax({
                method: 'GET',
                url: '/userworklist/'+"{{$data['user']->username}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                $("#userworklistload").html(response);
            });
        }

        //Add professional skills
        $('#addprofskillForm').on('submit', function(e){

            e.preventDefault();
            var form = $('#addprofskillForm')[0];
            var data = new FormData(form);

            $.ajax({
                    method: 'POST',
                    url: '/aboutInformation',
                    data: data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    document.getElementById("addprofskillForm").reset();

                    $("#add-professional-skills").modal("hide");
                   getprofskills();


                });
        });

        //Edit professional skills
        $('#profskillupdateForm').on('submit', function(e){

        e.preventDefault();
        var form = $('#profskillupdateForm')[0];
        var data = new FormData(form);

        $.ajax({
            method: 'POST',
            url: '/aboutInformationUpdate',
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            $("#edit-professional-skills").modal("hide");
                getprofskills();
            });
        });
        //delete the skill list
        function delSkilllist(id,type) {
            $.ajax({
                method: 'GET',
                url: '/delProfileData/'+id+'/'+type,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                getprofskills();
            });
        }

        //get professional skills
        function getprofskills() {
           $.ajax({
               method: 'GET',
               url: '/userprofskilllist/'+"{{$data['user']->username}}",
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           }).done(function(response) {
               $("#userskillload").html(response);
           });
        }

       //////*************************************

       //Add College
       $('#collegForm').on('submit', function(e){
            e.preventDefault();
            var form = $('#collegForm')[0];
            var data = new FormData(form);
            $.ajax({
                method: 'POST',
                url: '/aboutInformation',
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                $("#add-college-data").modal("hide");
                document.getElementById("collegForm").reset();
                getCollegeList();
            });
        });


    //Edit College
    $('#editcollogeupdateForm').on('submit', function(e){

    e.preventDefault();
    var form = $('#editcollogeupdateForm')[0];
    var data = new FormData(form);

    $.ajax({
            method: 'POST',
            url: '/aboutInformationUpdate',
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {

            $("#edit-college-data").modal("hide");
            getCollegeList();


        });
    });

    //delete College List
    function delCollegelist(id,type) {

     $.ajax({
         method: 'GET',
         url: '/delProfileData/'+id+'/'+type,
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     }).done(function(response) {
        getCollegeList();
     });
 }
    //Get College List
    function getCollegeList() {

           $.ajax({
               method: 'GET',
               url: '/usercollegelist/'+"{{$data['user']->username}}",
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           }).done(function(response) {
               $("#usercollegelistload").html(response);
           });
       }



    //Add Place you lived
    $('#placeyoulivedForm').on('submit', function(e){

            e.preventDefault();
            var form = $('#placeyoulivedForm')[0];
            var data = new FormData(form);

            $.ajax({
                    method: 'POST',
                    url: '/placeLives',
                    data: data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    document.getElementById("placeyoulivedForm").reset();
                    $(".select2").each(function() {
                    $(this).val(null).trigger("change");
                    });
                    getPlaceList();


                });
        });

    //Edit Place you lived
    $('#placeliveupd').on('submit', function(e){

e.preventDefault();
var form = $('#placeliveupd')[0];
var data = new FormData(form);

$.ajax({
        method: 'POST',
        url: '/placeLivesUpdate',
        data: data,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {
        document.getElementById("placeyoulivedForm").reset();
        getPlaceList();


    });
});


    //delete Place live List
    function delPlaceList(id,type) {

    $.ajax({
        method: 'GET',
        url: '/delProfileData/'+id+'/'+type,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {
        getPlaceList();
    });
}




        //Get Place live List
    function getPlaceList() {

           $.ajax({
               method: 'GET',
               url: '/userlivelist/'+"{{$data['user']->username}}",
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           }).done(function(response) {
               $("#userlivelistData").html(response);
           });
       }


       //validation Add family member
       function addFamilyMemberValidation(){
        let optionsLength = document.getElementById("choices-add-family-member").length;
        if(optionsLength == 0){
                document.getElementById("error_family_member_add").style.display = "";
                return false;
            }
            if(optionsLength > 0){
                document.getElementById("error_family_member_add").style.display = "none";
            }
                return true;
       }



       //Add Family Member
    $('#addfamilymemberForm').on('submit', function(e){

        let optionsLength = document.getElementById("choices-add-family-member").length;
            // if(optionsLength > 0){
            //         alert("The Length is : "+optionsLength);
            // }
            if(optionsLength == 0){
                document.getElementById("error_family_member_add").style.display = "";
                return false;
            }
            if(optionsLength > 0){
                document.getElementById("error_family_member_add").style.display = "none";
            }

            e.preventDefault();
            var form = $('#addfamilymemberForm')[0];
            var data = new FormData(form);

            $.ajax({
                    method: 'POST',
                    url: '/familyRelationship',
                    data: data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    document.getElementById("addfamilymemberForm").reset();
                    $("#add-familymember-modal").modal("hide");
                    getfamilymemberList();


                });
        });



        //Edit Relation
    $('#familyRelationshipFormEdit').on('submit', function(e){
    e.preventDefault();
    var form = $('#familyRelationshipFormEdit')[0];
    var data = new FormData(form);
    $.ajax({
        method: 'POST',
        url: '/familyRelationshipEdit',
        data: data,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {
        $("#add-familymember-modal-edit").modal("hide");
        getfamilymemberList();


    });
});



         //delete Famil List
    function delFamilyList(id,type) {

     $.ajax({
         method: 'GET',
         url: '/delProfileData/'+id+'/'+type,
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     }).done(function(response) {
        getfamilymemberList();
     });
 }

        //Get Family member list
        function getfamilymemberList() {

           $.ajax({
               method: 'GET',
               url: '/userfamilymemberlist/'+"{{$data['user']->username}}",
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           }).done(function(response) {
               $("#familymemberlistload").html(response);
           });
       }


       //Add Relation Status
       $('#familraltionshipstatusform').on('submit', function(e){

            e.preventDefault();
            var form = $('#familraltionshipstatusform')[0];
            var data = new FormData(form);

            $.ajax({
                    method: 'POST',
                    url: '/familyRelationship',
                    data: data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    document.getElementById("familraltionshipstatusform").reset();
                    $("#add-relationship-modal").modal("hide");
                    getuserstatusList();


                });
        });


        //Edit Relation Status
       $('#singlefamiliyformedit').on('submit', function(e){

        e.preventDefault();
        var form = $('#singlefamiliyformedit')[0];
        var data = new FormData(form);

        $.ajax({
                method: 'POST',
                url: '/familyRelationshipeditsingle',
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                $("#add-relationship-modal-edit").modal("hide");
                getuserstatusList();


            });
        });


        //Get user relation status
        function getuserstatusList() {

           $.ajax({
               method: 'GET',
               url: '/userstatuslist/'+"{{$data['user']->username}}",
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           }).done(function(response) {
               $("#userprofilestatusload").html(response);
           });
       }

       //validation add interst field
       function getHobbiesValidation(){

        let optionsLength = document.getElementById("choices-multiple-remove-button").length;

            if(optionsLength == 0){
                document.getElementById("error_add_hobbies_intrest").style.display = "";
                return false;
            }
            if(optionsLength > 0){
                document.getElementById("error_add_hobbies_intrest").style.display = "none";
            return true;
            }

       }
       //end validation
       //Add Hobbies and Interests
       $('#hobbyinterstForm').on('submit', function(e){
            e.preventDefault();

            let optionsLength = document.getElementById("choices-multiple-remove-button").length;
            if(optionsLength == 0){
                document.getElementById("error_add_hobbies_intrest").style.display = "";
                return false;
            }
            if(optionsLength > 0){
                document.getElementById("error_add_hobbies_intrest").style.display = "none";
            }

            var form = $('#hobbyinterstForm')[0];
            var data = new FormData(form);
            $.ajax({
                    method: 'POST',
                    url: '/hobbyAndInterest',
                    data: data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response) {
                    $('#add-hobbiesandintrests-modal').modal("hide");
                    document.getElementById("hobbyinterstForm").reset();
                    getuserHobbyList();
                });
        })


        //validation add interst field
       function getHobbiesValidationEdit(){
        console.log('validation work');
        let optionsLength = document.getElementById("choices-multiple-remove-button-edit").length;
            console.log(optionsLength);
            if(optionsLength == 0){
                document.getElementById("error_edit_hobbies_intrest").style.display = "";
                return false;
            }
            if(optionsLength > 0){
                document.getElementById("error_edit_hobbies_intrest").style.display = "none";
            return true;
            }

       }
       //end validation
        //Edit Hobby List
        $('#hobbylistEdit').on('submit', function(e){
        e.preventDefault();
        let optionsLength = document.getElementById("choices-multiple-remove-button-edit").length;
            if(optionsLength == 0){
                document.getElementById("error_edit_hobbies_intrest").style.display = "";
                return false;
            }
            if(optionsLength > 0){
                document.getElementById("error_edit_hobbies_intrest").style.display = "none";
            }

        var form = $('#hobbylistEdit')[0];
        var data = new FormData(form);

        $.ajax({
                method: 'POST',
                url: '/hobbyAndInterestEdit',
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                $('#add-hobbiesandintrests-modal-edit').modal("hide");
                getuserHobbyList();


            });
        });



        //Get user Hobby listing
        function getuserHobbyList() {

           $.ajax({
               method: 'GET',
               url: '/userhobbylist/'+"{{$data['user']->username}}",
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           }).done(function(response) {

               $("#userhobbylistload").html(response);
           });
       }
        function deleteAlbum(albumId) {

           $.ajax({
               method: 'POST',
               url: '/deleteAlbum/'+albumId,
               data:{
                albumId: albumId
                },
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           }).done(function(response) {

            updateAlbumDiv(response.user_id);
           });
       }
        function deletePicture(imagId) {

           $.ajax({
               method: 'POST',
               url: '/deletePicture/'+imagId,
               data:{
                imagId: imagId
                },
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           }).done(function(response) {

            photosOfYouDivUpdate(response.user_id);
           });
       }
        function deleteAlbumInnerPicture(imagId, albumId) {

           $.ajax({
               method: 'POST',
               url: '/deleteAlbumInnerPicture/'+imagId+'/'+albumId,
               data:{
                imagId: imagId,
                albumId: albumId
                },
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           }).done(function(response) {
            console.log(response);
            console.log(showAlbumImages(response.albumId ,response.user_id));
           });
       }
       function photosOfYouDivUpdate(id)
        {
            $("#photosofyou"+id).hide().load(" #photosofyou"+id+"> *").fadeIn(200);
        }

    var loadingData = false;
    var nextPageUrlCount = 0;
    var pageNumber = 2;
    function loadMoreData() {
        if (loadingData) {
            return;
        }

        loadingData = true;

        var nextPageUrl = `{!! $data['feeds']->links() !!}`;
        if(nextPageUrl != '' && nextPageUrl != null && nextPageUrl != undefined){
            var links = nextPageUrl.match(/href="([^"]+)"/g);
            var nextPageUrl = "{!! $data['feeds']->nextPageUrl() !!}";
            var nextPageUrlTCounts = links.length - 1;
            if (nextPageUrlTCounts === nextPageUrlCount) {
                var feedLoader = $(".feed__loder");
               if (!feedLoader.hasClass("d-none")) {
                  feedLoader.addClass("d-none");
               }
                return;
            } else if(nextPageUrlCount == 0){
                var nextPageUrl = "{!! $data['feeds']->nextPageUrl() !!}";
            }else {
                var link = nextPageUrl;
                var regex = /page=(\d+)/;
                var match = regex.exec(link);
                pageNumber = pageNumber+1;
                var nextPageUrl = link.replace(regex, 'page=' + pageNumber);
            }
                var websiteEnvironment = $("#websiteEnvironment").text();
                if(websiteEnvironment != 'local'){
                        nextPageUrl = nextPageUrl.replace(/^http:/i, 'https:');
                }
            $.ajax({
                url: nextPageUrl,
                type: "GET",
                dataType: "html",
                success: function (data) {
                    var extractedData = $(data).find("#loadeMoreFeed").html();
                    $("#loadeMoreFeed").append(extractedData);
                    loadingData = false;
                    nextPageUrlCount =  nextPageUrlCount + 1;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    loadingData = false;
                }
            });
        }else{
            var feedLoader = $(".feed__loder");
            if (feedLoader && !feedLoader.hasClass("d-none")) {
                feedLoader.addClass("d-none");
            }
        }
    }
    window.onscroll = function() {
        windowScrollY = window.scrollY + 2000;
        if ((window.innerHeight + windowScrollY) >= document.body.offsetHeight) {
            loadMoreData();
        }
    };

</script>
@push('scripts')
    <script src="{{ asset('js/feedModal.js?version=0.36') }}"></script>
@endpush
</x-app-layout>

