@php
$user = auth()->user();
use App\Models\GroupMembers;

$checkGroupMember = count(GroupMembers::where(['group_id' => $data['groupDetail'][0]->id, 'user_id' => $user->id])->get());

@endphp

<link rel="stylesheet" href="{{ asset('css/croppie/croppie.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                <div class="container">
                    <div class="row">
                        <div class="card px-0 mx-0">
                            <div class="header-for-bg updateProfileCoverPhoto px-0 mx-0">
                            <div class="background-header position-relative">
                                @if(isset($data['groupDetail'][0]->cover_image) && $data['groupDetail'][0]->cover_image !== '')
                                <a data-fslightbox="gallery" href="{{asset('storage/images/group-img/'.$data['groupDetail'][0]->id . '/' . 'cover' . '/' . $data['groupDetail'][0]->cover_image)}}"><img src="{{asset('storage/images/group-img/'.$data['groupDetail'][0]->id . '/' . 'cover' . '/' . $data['groupDetail'][0]->cover_image)}}" class="w-100 rounded" style="height:450px; object-fit: fill;" alt="header-bg"></a>
                                @else
                                    {{-- <img src="{{asset('images/group-img/no-image.png')}}" class="img-fluid w-100 rounded rounded" alt="header-bg"> --}}
                                    <img src="{{asset('images/user/Banners-01.png')}}" class="img-fluid w-100 rounded rounded" style="height:450px; object-fit: fill;" alt="header-bg">
                                @endif
                                {{-- <div class="title-on-header">
                                    <div class="data-block">
                                        <h2>{{$data['groupDetail'][0]->group_name}}</h2>
                                    </div>
                                </div> --}}
                            </div>
                            </div>
                            <div class="row position-relative">
                            <div class="container coverImageDivRefresh">
                                <div class="col-md-12" style="text-align: end;">
                                        {{-- @if ($data['groupDetail'][0]->admin_user_id == $user->id) --}}
                                        {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#groupCover-post-modal" class="fa fa-camera fa shadow" id="upload_camera_icon" style="margin-top: -1rem; overflow: hidden;">
                                        </a> --}}
                                        <div class="dropdown">
                                        {{-- @if ($data['groupDetail'][0]->admin_user_id != $user->id && isset($data['groupDetail'][0]->cover_image) && $data['groupDetail'][0]->cover_image !=='' && $data['groupDetail'][0]->cover_image !== null)
                                            <a href="#" data-bs-toggle="dropdown" class="material-symbols-outlined dropdown shadow" id="upload_camera_icon" style="margin-top: -1rem; overflow: hidden;">
                                                visibility
                                            </a>
                                        @endif --}}
                                        @if ($data['groupDetail'][0]->admin_user_id == $user->id)
                                            <a href="javascript:void();" data-bs-toggle="dropdown" class="fa fa-camera fa dropdown shadow" id="upload_camera_icon" style="margin-top: -1rem; overflow: hidden;">
                                            </a>
                                        @endif
                                        <div class="dropdown-menu">
                                            @if(isset($data['groupDetail'][0]->cover_image) && $data['groupDetail'][0]->cover_image !=='')
                                                <a data-fslightbox="gallery" href="{{asset('storage/images/group-img/'.$data['groupDetail'][0]->id . '/' . 'cover' . '/' . $data['groupDetail'][0]->cover_image)}}" class="dropdown-item">View Cover Picture</a>
                                            @endif
                                            @if ($data['groupDetail'][0]->admin_user_id == $user->id)
                                                <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#groupCover-post-modal" class="dropdown-item">Update Cover Picture</a>
                                            @endif
                                        </div>
                                        </div>
                                        {{-- @endif --}}
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap updateProfilePhoto">
                                    <div class="group-info d-flex align-items-center ">
                                        {{-- <div class="me-3">
                                            @if(isset($data['groupDetail'][0]->profile_image) && $data['groupDetail'][0]->profile_image !== '')
                                            <img class="rounded-circle profile-image-group" src="{{asset('storage/images/group-img/'.$data['groupDetail'][0]->id.'/'.$data['groupDetail'][0]->profile_image)}}" alt="" loading="lazy" width="145" height="145">
                                            @else
                                            <img class="rounded-circle img-fluid avatar-100" src="{{asset('images/user/groupProfile.png')}}" alt="group-profile" loading="lazy">
                                            @endif
                                        </div>
                                        @if ($data['groupDetail'][0]->admin_user_id == $user->id)
                                            <div class="dropdown">
                                                <a href="#" data-bs-toggle="dropdown" data-bs-target="#groupProfile-post-modal" class="fa fa-camera fa dropdown shadow" id="upload_camera_icon" style="margin-top: 6rem; margin-left: -3rem;">
                                                </a>
                                                <div class="dropdown-menu">
                                                    @if(isset($data['groupDetail'][0]->profile_image) && $data['groupDetail'][0]->profile_image !=='')
                                                        <a data-fslightbox="gallery" href="{{asset('storage/images/group-img/'.$data['groupDetail'][0]->id.'/'.$data['groupDetail'][0]->profile_image)}}" class="dropdown-item">View Profile Picture</a>
                                                    @endif
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#groupProfile-post-modal" class="dropdown-item">Update Profile Picture</a>
                                                </div>
                                            </div>
                                        @endif --}}
                                        <div class="info" style="margin-left: 1rem">
                                            <h4>{{$data['groupDetail'][0]->group_name}}</h4>
                                            {{-- <p class="mb-0 d-flex"><i class="material-symbols-outlined pe-2">lock</i>{{$data['groupDetail'][0]->group_type}} Group . @if(count($data['groupDetail'][0]['groupMembers']) == 1) {{count($data['groupDetail'][0]['groupMembers'])}} member @else {{count($data['groupDetail'][0]['groupMembers'])}} members @endif</p> --}}
                                            <p class="mb-0 d-flex">@if ($data['groupDetail'][0]->group_type == 'Public')<i class="material-symbols-outlined pe-2" style="margin-left: -5px;">public</i>@elseif ($data['groupDetail'][0]->group_type == 'Private')<i class="material-symbols-outlined pe-2" style="margin-left: -5px;">lock</i>@endif{{$data['groupDetail'][0]->group_type}}</p>
                                            <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#seeAllMembers">
                                                <p>@if($data['groupMemberCount'] == 1) {{$data['groupMemberCount']}} Member @else {{$data['groupMemberCount']}} Members @endif</p>
                                            </a>


                                        </div>
                                    </div>
                                    <div class="group-member d-flex align-items-center  mt-md-0 mt-2">
                                        <div class="iq-media-group me-3">
                                            @if(isset($data['groupDetail'][0]['groupMembers'][0]['getUser']->avatar_location))
                                                <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][0]['getUser']->username])}}" class="iq-media">
                                                    <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][0]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][0]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                                </a>
                                            @endif
                                            @if(isset($data['groupDetail'][0]['groupMembers'][1]['getUser']->avatar_location))
                                                <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][1]['getUser']->username])}}" class="iq-media">
                                                    <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][1]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][1]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                                </a>
                                            @endif
                                            @if(isset($data['groupDetail'][0]['groupMembers'][2]['getUser']->avatar_location))
                                                <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][2]['getUser']->username])}}" class="iq-media">
                                                    <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][2]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][2]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                                </a>
                                            @endif
                                            @if(isset($data['groupDetail'][0]['groupMembers'][3]['getUser']->avatar_location))
                                                <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][3]['getUser']->username])}}" class="iq-media">
                                                    <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][3]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][3]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                                </a>
                                            @endif
                                            @if(isset($data['groupDetail'][0]['groupMembers'][4]['getUser']->avatar_location))
                                                <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][4]['getUser']->username])}}" class="iq-media">
                                                    <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][4]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][4]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                                </a>
                                            @endif
                                            @if(isset($data['groupDetail'][0]['groupMembers'][5]['getUser']->avatar_location))
                                                <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][5]['getUser']->username])}}" class="iq-media">
                                                    <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][5]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][5]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                                </a>
                                            @endif
                                            @if(isset($data['groupDetail'][0]['groupMembers'][6]['getUser']->avatar_location))
                                                <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][6]['getUser']->username])}}" class="iq-media">
                                                    <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][6]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][6]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="content-page" class="content-page">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8 orderformobile orderformobilelast updateFeed updateNewsFeed tab-content" id="groupPagerefresh">
                                    <div class="tab-pane fade active show" id="overview" role="tabpanel">
                                        @if($checkGroupMember == 1)
                                            <div id="post-modal-data" class="card">
                                                <div class="card-header d-flex justify-content-between">
                                                    <div class="header-title">
                                                        <h4 class="card-title">Create Post</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-img">
                                                            {{-- @if(isset($data['groupDetail'][0]->profile_image) && $data['groupDetail'][0]->profile_image !== '') --}}
                                                            @if(isset($user->avatar_location) && $user->avatar_location !== '')
                                                            {{-- <img src="{{asset('storage/images/group-img/'.$data['groupDetail'][0]->id.'/'.$data['groupDetail'][0]->profile_image)}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy"> --}}
                                                            <img src="{{asset('storage/images/user/userProfileandCovers/'.$user->id.'/'.$user->avatar_location)}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                                            @else
                                                            <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                                            @endif
                                                        </div>
                                                        <form class="post-text ms-3 w-100 buttonEnable"  action="javascript:void();">
                                                            <input type="text" class="form-control rounded input-focus" placeholder="Write something here..." style="border:none;background-color:white" onclick="createPostModalShow()" readonly>
                                                        </form>
                                                    </div>
                                                    <hr>
                                                    <ul class=" post-opt-block d-flex list-inline m-0 p-0 flex-wrap">
                                                        <li class="me-3 mb-md-0 mb-2">
                                                            <a href="javascript:void();" class="btn btn-soft-primary buttonEnable" onclick="createPostModalShow()" action="javascript:void();">
                                                                <img src="{{asset('images/user/Users_24x24.png')}}" alt="story-img" class="img-fluid" alt="icon" class="img-fluid me-2" loading="lazy"> Photo/Video
                                                            </a>
                                                        </li>
                                                        {{-- <li class="bg-soft-primary rounded p-2 pointer d-flex align-items-center me-3 mb-md-0 mb-2"><img src="{{asset('images/small/08.png')}}" alt="icon" class="img-fluid me-2" loading="lazy"> Tag Friend</li> --}}
                                                        {{-- <li class="bg-soft-primary rounded p-2 pointer d-flex align-items-center me-3"><img src="{{asset('images/small/09.png')}}" alt="icon" class="img-fluid me-2" loading="lazy"> Feeling/Activity</li> --}}
                                                        {{-- <li class="bg-soft-primary rounded p-2 pointer text-center">
                                                        <div class="card-header-toolbar d-flex align-items-center">
                                                        <div class="dropdown">
                                                        <a href="javascript:void(0);" class="dropdown-toggle d-flex" id="post-option" data-bs-toggle="dropdown">
                                                        <i class="material-symbols-outlined">more_horiz</i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="post-option" style="">
                                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#post-modal">Check in</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#post-modal">Live Video</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#post-modal">Gif</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#post-modal">Watch Party</a>
                                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#post-modal">Play with Friend</a>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </li> --}}
                                                    </ul>
                                                </div>
                                                {{-- <div class="modal fade" id="post-modal" tabindex="-1"  aria-labelledby="post-modalLabel" aria-hidden="true" style="margin-top:7rem">
                                                <div class="modal-dialog modal-groupCreatePost">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="post-modalLabel">Create Post</h5>
                                                <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                <span class="material-symbols-outlined">close</span>
                                                </a>
                                                </div>
                                                <div class="modal-body">
                                                <div class="cover_spin_ProfilePhotoUpdate"></div>
                                                <div class="d-flex align-items-center">
                                                <div class="user-img">
                                                @if(isset($data['groupDetail'][0]->profile_image) && $data['groupDetail'][0]->profile_image !== '')
                                                <img src="{{asset('storage/images/group-img/'.$data['groupDetail'][0]->id.'/'.$data['groupDetail'][0]->profile_image)}}" alt="userimg" class="avatar-60 rounded-circle img-fluid">
                                                @else
                                                <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="avatar-60 rounded-circle img-fluid">
                                                @endif
                                                </div>
                                                <form method="" id="groupAndPagePostCreate" action="" class="post-text ms-3 w-100" enctype="multipart/form-data">
                                                @csrf
                                                <input type="text" name="postData" id="postText" class="form-control rounded" placeholder="Write something here..." style="border:none;">
                                                <input type="hidden" class="form-control rounded" value={{$user->id}} name="userId" style="border:none;">
                                                <input type="hidden" class="form-control rounded" value={{$data['groupDetail'][0]->id}} name="groupId" style="border:none;">
                                                <input type="hidden" class="form-control rounded" value="groupFeed" name="type" style="border:none;">
                                                <hr>
                                                <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                                                <li class="col-md-6 mb-3">
                                                <input type="file" multiple name="profileImage[]" id="profileImagePost" class="form-control" accept="image/*,video/mp4,video/x-m4v,video/*" placeholder="Profile Image" style="border:none;" onchange="previewImagesNewsFeed()">
                                                <div id="preview" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 8px; overflow-y: auto; max-height: 300px;min-width: 650px;"></div>
                                                </li>
                                                </ul>
                                                <button type="submit" id="PostCreateButton" class="btn btn-primary d-block w-100 mt-3">Post</button>
                                                </form>
                                                </div>
                                                </div>
                                                </div>
                                                </div>
                                                </div> --}}
                                                <div class="modal fade" id="post-modal" tabindex="-1"  aria-labelledby="post-modalLabel" aria-hidden="true" style="margin-top:5rem">
                                                    <div class="modal-dialog modal-groupCreatePost">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="post-modalLabel">Create Post</h5>
                                                                <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                                <span class="material-symbols-outlined">close</span>
                                                                </a>
                                                            </div>
                                                            {{-- <div class="modal-body">
                                                                <div class="cover_spin_ProfilePhotoUpdate"></div>
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <div class="col-md-1 ml-auto">
                                                                            <div class="user-img">
                                                                            @if(isset($user->avatar_location) && $user->avatar_location !== '')
                                                                            <img src="{{asset('storage/images/user/userProfileandCovers/'.$user->id.'/'.$user->avatar_location)}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy" style="object-fit: cover;">
                                                                            @else
                                                                            <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy" style="object-fit: cover;">
                                                                            @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-11">
                                                                            <form method="" id="groupAndPagePostCreate" action="" class="post-text my-3 w-100" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <input type="text" name="postData" id="postText" class="form-control rounded" placeholder="Write something here..." style="border:none;">
                                                                            <input type="hidden" class="form-control rounded" value={{$user->id}} name="userId" style="border:none;">
                                                                            <input type="hidden" class="form-control rounded" value={{$data['groupDetail'][0]->id}} name="groupId" style="border:none;">
                                                                            <input type="hidden" class="form-control rounded" value="groupFeed" name="type" style="border:none;">
                                                                            <hr>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-1 ml-auto"></div>
                                                                        <div class="col-sm-11">
                                                                            <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                                                                            <li>
                                                                            <input type="file" multiple name="profileImage[]" id="profileImagePost" class="form-control fileInputGetOldValues" accept="image/*,video/mp4,video/x-m4v,video/*" placeholder="Profile Image" style="border:none;" onclick="addMoreFiles()" onchange="previewImagesNewsFeed()">
                                                                            <div id="preview" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 8px; overflow-y: auto; max-height: 300px;min-width: 650px; margin-top: 20px;"></div>
                                                                            </li>
                                                                            </ul>
                                                                            <button type="submit" id="PostCreateButton" class="btn btn-primary d-block w-100 mt-3">Post</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                            @include('partials/_create_post')
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="group-post-modal" tabindex="-1"  aria-labelledby="groupPost-modalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="groupPost-modalLabel">Create Group</h5>
                                                                <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                                <span class="material-symbols-outlined">close</span>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="d-flex align-items-center">
                                                                    <form class="post-text ms-3 w-100" action="{{ route('createGroup') }}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="userId" required class="form-control rounded" style="border:none;">

                                                                        <label>Profile Image</label>
                                                                        <input type="file" name="profileImage" id="profileImage" required class="form-control" accept="image/*" placeholder="Profile Image" style="border:none;">
                                                                        <hr>
                                                                        <label>Cover Image</label>
                                                                        <input type="file" name="coverImage" id="coverImage" required class="form-control" accept="image/*" placeholder="Cover Image" style="border:none;">
                                                                        <hr>
                                                                        <input type="text" name="groupName" required class="form-control rounded" placeholder="Group Name" style="border:none;">
                                                                        <hr>
                                                                        <input type="text" name="shortDescription" required class="form-control rounded" placeholder="Short Description" style="border:none;">
                                                                        <hr>
                                                                        <button type="submit" class="btn btn-primary d-block w-100 mt-3">Create Group</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade joinrequestmodal" id="joinrequestmodal" tabindex="-1"  aria-labelledby="joinRequest-modalLabel" aria-hidden="true" style="margin-top:5rem;">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="joinRequest-modalLabel">All Requests</h5>
                                                            <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                            <span class="material-symbols-outlined">close</span>
                                                            </a>
                                                        </div>
                                                        <div class="row" style="width:100%">
                                                            <div class="container" style="overflow-y: auto; padding: 0px 15px">
                                                                @foreach($data['allRequests'] as $request)
                                                                    @if(isset($request) && isset($request['getUser']))
                                                                        <div class="row" >
                                                                            <div class="col-md-6 p-2 bd-highlight">
                                                                                @if(isset($request['getUser']->username) && $request['getUser']->username !== '')
                                                                                <a href="{{route('user-profile',  ['username' => $request['getUser']->username])}}">
                                                                                @if(isset($request['getUser']->avatar_location) && $request['getUser']->avatar_location !== '')
                                                                                <img src="{{ asset('storage/images/user/userProfileandCovers/'.$request['getUser']->id.'/'.$request['getUser']->avatar_location) }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                                @else
                                                                                <img src="{{asset('images/user/Users_60x60.png')}}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                                @endif
                                                                                <span class="requestUserName">{{$request['getUser']->first_name.' '.$request['getUser']->last_name}}</span>
                                                                                </a>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-md-3 p-2 bd-highlight" id="approveGroupRequest{{$request['getUser']->id}}">
                                                                                <button class="btn btn-primary w-100 mt-3 btn-sm" onclick="approveGroupRequest({{$request['getUser']->id}},{{$data['groupDetail'][0]->id}}, {{$data['groupDetail'][0]->admin_user_id}})">Approve</button>
                                                                            </div>
                                                                            <div class="col-md-3 p-2 bd-highlight" id="rejectGroupRequest{{$request['getUser']->id}}">
                                                                                <button class="btn w-100 mt-3 btn-sm btn-secondary" onclick="rejectGroupRequest({{$request['getUser']->id}},{{$data['groupDetail'][0]->id}}, {{$data['groupDetail'][0]->admin_user_id}})">Reject</button>
                                                                            </div>
                                                                            <div class="col-md-6 bd-highlight">
                                                                                <button disabled id="approved{{$request['getUser']->id}}" class="btn btn-secondary d-none w-100 mt-3 btn-sm">Approved</button>
                                                                                <button disabled id="rejected{{$request['getUser']->id}}" class="btn btn-secondary d-none w-100 mt-3 btn-sm">Rejected</button>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade seeAllMembers" id="seeAllMembers" tabindex="-1"  aria-labelledby="seeAllMembers-modalLabel" aria-hidden="true" style="margin-top:5rem;">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="seeAllMembers-modalLabel">All Members</h5>
                                                            <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                            <span class="material-symbols-outlined">close</span>
                                                            </a>
                                                        </div>
                                                        @if (isset($data['groupAdmin']))
                                                            <div class="row" style="width:100%">
                                                                <div class="container" style="overflow-y: auto; max-height: 300px; padding: 0px 15px">
                                                                    <div class="row">
                                                                        <div class="col-md-8 p-2 bd-highlight">
                                                                            <a href="{{route('user-profile',  ['username' => $data['groupAdmin']->username])}}">
                                                                                @if(isset($data['groupAdmin']->avatar_location) && $data['groupAdmin']->avatar_location !== '')
                                                                                    <img src="{{ asset('storage/images/user/userProfileandCovers/'.$data['groupAdmin']->id.'/'.$data['groupAdmin']->avatar_location) }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                                @else
                                                                                    <img src="{{asset('images/user/Users_60x60.png')}}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                                @endif
                                                                                    <span class="requestUserName">{{$data['groupAdmin']->first_name.' '.$data['groupAdmin']->last_name}} <mark class="bg-info rounded">Admin</mark> </span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                            <div class="row" style="width:100%">
                                                                <div class="container" style="overflow-y: auto; max-height: 300px; padding: 0px 15px">
                                                                    @foreach($data['allMembers'] as $member)
                                                                        @if(isset($member['getUser']))
                                                                            @if ($data['groupDetail'][0]->admin_user_id == $member['getUser']->id)
                                                                                @continue;
                                                                            @endif
                                                                            <div class="row">
                                                                                <div class="col-md-8 p-2 bd-highlight">
                                                                                    <a href="{{route('user-profile',  ['username' => $member['getUser']->username])}}">
                                                                                        @if(isset($member['getUser']->avatar_location) && $member['getUser']->avatar_location !== '')
                                                                                            <img src="{{ asset('storage/images/user/userProfileandCovers/'.$member['getUser']->id.'/'.$member['getUser']->avatar_location) }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                                        @else
                                                                                            <img src="{{asset('images/user/Users_60x60.png')}}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                                        @endif
                                                                                            <span class="requestUserName">{{$member['getUser']->first_name.' '.$member['getUser']->last_name}}</span>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="col-md-4 p-2 bd-highlight" id="removeMember{{$member['getUser']->id}}">
                                                                                </div>
                                                                                <div class="col-md-4 bd-highlight">
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($checkGroupMember == 1 || ($checkGroupMember == 0 && $data['groupDetail'][0]->group_type == 'Public'))
                                            <div class="update-newsfeed-approve">
                                                @foreach($data['feeds'] as $feed)
                                                    @if(isset($feed))
                                                        @include('partials/_feed')
                                                    @endif
                                                @endforeach
                                            </div>
                                            @if($data['feeds']->count() <= 0)
                                                <div class="card">
                                                    <div class="card-body p-0">
                                                        <div class=" card-body text-center justify-content-center p-0" style="padding-top: 40px !important;padding-bottom: 40px !important;" >
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="40" fill="#8c68cd">
                                                                <path d="M140-120q-24.75 0-42.375-17.625T80-180v-660l67 67 66-67 67 67 67-67 66 67 67-67 67 67 66-67 67 67 67-67 66 67 67-67v660q0 24.75-17.625 42.375T820-120H140Zm0-60h310v-280H140v280Zm370 0h310v-110H510v110Zm0-170h310v-110H510v110ZM140-520h680v-120H140v120Z"/>
                                                            </svg>
                                                            <div>
                                                                <p class="fw-semibold" style="max-height: 10px;">No Post Yet</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="card">
                                                <div class="card-body p-0">
                                                    <div class=" card-body text-center justify-content-center p-0" style="padding-top: 40px !important;padding-bottom: 40px !important;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#8c68cd" version="1.1" id="Capa_1" width="40" height="50px" viewBox="0 0 342.52 342.52" xml:space="preserve">
                                                            <g>
                                                                <g>
                                                                    <path d="M171.254,110.681c-14.045,0-25.47,11.418-25.47,25.476v21.773h50.933v-21.773    C196.724,122.104,185.29,110.681,171.254,110.681z"></path>
                                                                    <path d="M171.26,0C76.825,0,0.006,76.825,0.006,171.257c0,94.438,76.813,171.263,171.254,171.263    c94.416,0,171.254-76.825,171.254-171.263C342.514,76.825,265.683,0,171.26,0z M226.225,239.291c0,4.119-3.339,7.446-7.458,7.446    h-95.032c-4.113,0-7.446-3.327-7.446-7.446v-73.91c0-4.119,3.333-7.458,7.446-7.458h7.152V136.15    c0-22.266,18.113-40.361,40.367-40.361c22.251,0,40.355,18.095,40.355,40.361v21.773h7.151c4.119,0,7.458,3.338,7.458,7.458v73.91    H226.225z"></path>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                        <div>
                                                            <p class="fw-semibold" style="max-height: 10px;">Group is private</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @if ($data['groupDetail'][0]->group_type != 'Public')
                                        <div class="tab-pane fade" id="feedApprovals" role="tabpane2">
                                            @if($data['groupDetail'][0]->admin_user_id == $user->id)
                                                @foreach($data['pendingFeedApprove'] as $feed)
                                                    @if(isset($feed))
                                                        <div class="pending-feed-approve-{{$feed->id}}">
                                                            @include('partials/_feed')
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach($data['pendingFeedApproveUser'] as $feed)
                                                    @if(isset($feed))
                                                        <div class="pending-feed-approve-user-{{$feed->id}}">
                                                            @include('partials/_feed')
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if($data['pendingFeedApprove']->count() <= 0 ||  $data['pendingFeedApproveUser']->count() <= 0 && $data['groupDetail'][0]->admin_user_id != $user->id)
                                                <div class="card">
                                                    <div class="card-body p-0">
                                                        <div class=" card-body text-center justify-content-center p-0" style="padding-top: 40px !important;padding-bottom: 40px !important;" >
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="40" fill="#8c68cd">
                                                                <path d="M140-120q-24.75 0-42.375-17.625T80-180v-660l67 67 66-67 67 67 67-67 66 67 67-67 67 67 66-67 67 67 67-67 66 67 67-67v660q0 24.75-17.625 42.375T820-120H140Zm0-60h310v-280H140v280Zm370 0h310v-110H510v110Zm0-170h310v-110H510v110ZM140-520h680v-120H140v120Z"/>
                                                            </svg>
                                                            <div>
                                                                <p class="fw-semibold" style="max-height: 10px;">No Post Yet</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="card d-none approve-feed-end">
                                                <div class="card-body p-0">
                                                    <div class=" card-body text-center justify-content-center p-0" style="padding-top: 40px !important;padding-bottom: 40px !important;" >
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="40" fill="#8c68cd">
                                                            <path d="M140-120q-24.75 0-42.375-17.625T80-180v-660l67 67 66-67 67 67 67-67 66 67 67-67 67 67 66-67 67 67 67-67 66 67 67-67v660q0 24.75-17.625 42.375T820-120H140Zm0-60h310v-280H140v280Zm370 0h310v-110H510v110Zm0-170h310v-110H510v110ZM140-520h680v-120H140v120Z"/>
                                                        </svg>
                                                        <div>
                                                            <p class="fw-semibold" style="max-height: 10px;">No Post Yet</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="tab-pane fade" id="groupMembers" role="tabpane3">
                                        @if ($data['groupDetail'][0]->admin_user_id == $user->id)
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Member Request</h5>
                                                    @forelse($data['allRequests'] as $key => $request)
                                                        @if(isset($request) && isset($request['getUser']))
                                                            <div class="row group-join-request-approve-{{$request['getUser']->id}}">
                                                                <div class="col-md-6 p-2 bd-highlight">
                                                                    @if(isset($request['getUser']->username) && $request['getUser']->username !== '')
                                                                        <a href="{{route('user-profile',  ['username' => $request['getUser']->username])}}">
                                                                            @if(isset($request['getUser']->avatar_location) && $request['getUser']->avatar_location !== '')
                                                                                <img src="{{ asset('storage/images/user/userProfileandCovers/'.$request['getUser']->id.'/'.$request['getUser']->avatar_location) }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                            @else
                                                                                <img src="{{asset('images/user/Users_60x60.png')}}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                            @endif
                                                                            <span class="requestUserName">{{$request['getUser']->first_name.' '.$request['getUser']->last_name}}</span>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3 p-2 bd-highlight my-auto" id="approveGroupRequest{{$request['getUser']->id}}">
                                                                    <button class="btn btn-primary w-100  btn-sm" onclick="approveGroupRequest({{$request['getUser']->id}},{{$data['groupDetail'][0]->id}}, {{$data['groupDetail'][0]->admin_user_id}})">Approve</button>
                                                                </div>
                                                                <div class="col-md-3 p-2 bd-highlight my-auto" id="rejectGroupRequest{{$request['getUser']->id}}">
                                                                    <button class="btn w-100  btn-sm btn-secondary" onclick="rejectGroupRequest({{$request['getUser']->id}},{{$data['groupDetail'][0]->id}}, {{$data['groupDetail'][0]->admin_user_id}})">Reject</button>
                                                                </div>
                                                                <div class="col-md-6 bd-highlight my-auto">
                                                                    <button disabled id="approved{{$request['getUser']->id}}" class="btn btn-secondary d-none w-100  btn-sm">Approved</button>
                                                                    <button disabled id="rejected{{$request['getUser']->id}}" class="btn btn-secondary d-none w-100  btn-sm">Rejected</button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @empty
                                                        <div class="">
                                                            <div class="card-body p-0">
                                                                <div class=" card-body text-center justify-content-center p-0" style="padding-top: 40px !important;padding-bottom: 40px !important;" >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="40" fill="#8c68cd"><path d="M500-482q29-32 44.5-73t15.5-85q0-44-15.5-85T500-798q60 8 100 53t40 105q0 60-40 105t-100 53Zm220 322v-120q0-36-16-68.5T662-406q51 18 94.5 46.5T800-280v120h-80Zm80-280v-80h-80v-80h80v-80h80v80h80v80h-80v80h-80Zm-480-40q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM0-160v-112q0-34 17.5-62.5T64-378q62-31 126-46.5T320-440q66 0 130 15.5T576-378q29 15 46.5 43.5T640-272v112H0Zm320-400q33 0 56.5-23.5T400-640q0-33-23.5-56.5T320-720q-33 0-56.5 23.5T240-640q0 33 23.5 56.5T320-560ZM80-240h480v-32q0-11-5.5-20T540-306q-54-27-109-40.5T320-360q-56 0-111 13.5T100-306q-9 5-14.5 14T80-272v32Zm240-400Zm0 400Z"/></svg>
                                                                
                                                                    <div>
                                                                        <p class="fw-semibold" style="max-height: 10px;">No Request</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        @endif
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Members</h5>
                                                @if (isset($data['groupAdmin']))
                                                    <div class="row" style="width:100%">
                                                        <div class="container" style="overflow-y: auto; max-height: 300px; padding: 0px 15px">
                                                            <div class="row">
                                                                <div class="col-md-8 p-2 card shadow-none w-100 mb-1">
                                                                    <a class="w-100 d-flex" href="{{route('user-profile',  ['username' => $data['groupAdmin']->username])}}">
                                                                        @if(isset($data['groupAdmin']->avatar_location) && $data['groupAdmin']->avatar_location !== '')
                                                                            <img src="{{ asset('storage/images/user/userProfileandCovers/'.$data['groupAdmin']->id.'/'.$data['groupAdmin']->avatar_location) }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                        @else
                                                                            <img src="{{asset('images/user/Users_60x60.png')}}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                        @endif
                                                                        <span class="requestUserName d-flex justify-content-between align-items-center w-100">{{$data['groupAdmin']->first_name.' '.$data['groupAdmin']->last_name}} <mark class="bg-primary px-2 rounded text-bg-dark">Admin</mark> </span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="allMembers">
                                                    @foreach($data['allMembers'] as $member)
                                                        @if(isset($member['getUser']))
                                                            @if ($data['groupDetail'][0]->admin_user_id == $member['getUser']->id)
                                                                @continue;
                                                            @endif
                                                            <div class="row removeMember{{$member['getUser']->id}}">
                                                                <div class="col-md-12 p-2 card shadow-none mb-1">
                                                                    <div class=" d-flex justify-content-between align-items-center px-2">
                                                                        <a class="" href="{{route('user-profile',  ['username' => $member['getUser']->username])}}">
                                                                            @if(isset($member['getUser']->avatar_location) && $member['getUser']->avatar_location !== '')
                                                                                <img src="{{ asset('storage/images/user/userProfileandCovers/'.$member['getUser']->id.'/'.$member['getUser']->avatar_location) }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                            @else
                                                                                <img src="{{asset('images/user/Users_60x60.png')}}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                                            @endif
                                                                                <span class="requestUserName ">{{$member['getUser']->first_name.' '.$member['getUser']->last_name}}</span>
                                                                        </a>
                                                                        @if ($data['groupDetail'][0]->admin_user_id == $user->id)
                                                                            <div class="p-2 bd-highlight my-auto pe-3">
                                                                                <button class="btn btn-primary w-100 btn-sm " onclick="removeMember({{$member['getUser']->id}},{{$data['groupDetail'][0]->id}}, {{$data['groupDetail'][0]->admin_user_id}})">Remove</button>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="groupSetting" role="tabpane4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Group Setting</h5>
                                                <div class="d-flex justify-content-between">
                                                    <div class="py-2">
                                                        <p class="card-text">Delete "{{ $data['groupDetail'][0]->group_name }}" group.</p>
                                                    </div>
                                                    <div class="">
                                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#delete-group" action="javascript:void();">Delete</button>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="delete-group" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="delete-group" aria-hidden="true" >
                                                    <div class="modal-dialog   modal-fullscreen-sm-down">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="align-items: flex-start;">
                                                                <div class="modal-title text-dark" style="font-weight: bold;">
                                                                    Delete Group?
                                                                </div>
                                                                <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                                    <span class="material-symbols-outlined">close</span>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body ">
                                                                <div class="d-flex align-items-center">
                                                                    <p class="modal-title ms-3 " id="unfollow-modalLabel">Do you want to delete group?</p>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="d-flex align-items-center">
                                                                    <form  method="POST" action="{{ route('deleteGroup', $data['groupDetail'][0]->id) }}">
                                                                        @csrf
                                                                        <button type="submit" data-bs-dismiss="modal" class="btn btn-primary me-2">Yes</button>
                                                                        <a href="javascript:void(0);" class="btn btn-secondary me-2" data-bs-dismiss="modal" action="javascript:void();" role="button">
                                                                            No
                                                                        </a>
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
                                <div class="modal fade" id="feed_likes_modal_popup">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-scrollable-feeds  modal-md" style="top:4rem">
                                        <div class="modal-content">
                                            <div class="card p-4 feed_likes_modal_loder d-none">
                                                <h5 class="card-title">
                                                    <div class="row flex-lg-nowrap">
                                                        <span class="avatar-65 col-2 placeholder rounded-5"></span>
                                                        <div>
                                                            <span class="placeholder col-7 mt-2 mb-2"></span>
                                                            <span class="placeholder col-5"></span>
                                                        </div>
                                                    </div>
                                                </h5>
                                                <div class="card-img-top bg-soft-light placeholder-img"></div>
                                                <div class="card-body">
                                                    <div class="row mb-2">
                                                        <div class="col-4">
                                                            <span class="placeholder py-3"></span>
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="placeholder py-3"></span>
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="placeholder py-3"></span>
                                                        </div>
                                                    </div>
                                                    <p class="card-text">
                                                        <span class="placeholder"></span>
                                                        <span class="placeholder"></span>
                                                        <span class="placeholder"></span>
                                                        <span class="placeholder"></span>
                                                        <span class="placeholder"></span>
                                                    </p>
                                                </div>
                                            </div>

                                            <div id="feedModalHeader" class="modal-header d-none">
                                                <h1 id="feedModalHeading" class="modal-title fs-5"></h1>
                                                <span id="feedModalClose" type="button" class="btn-close"></span>
                                            </div>
                                            <div class="modal-body ">
                                                <div id="feedModalBodyContent" class="modal-content border-0"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 joinRequests">
                                {{-- @if ($data['groupDetail'][0]->admin_user_id == $user->id)
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                            <h4 class="card-title">Join Requests</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-inline p-0 m-0">
                                                @if (isset($data['allRequests']) && count($data['allRequests']) > 0)
                                                    <li class="list-inline-item m-1">
                                                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#joinrequestmodal">See all Requests</a>
                                                    </li>
                                                @endif
                                                @if (isset($data['allMembers']) && count($data['allMembers']) > 1)
                                                <li class="list-inline-item m-1">
                                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seeAllMembers">See all Members</a>
                                                </li>
                                                @endif
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('editGroup', $data['groupDetail'][0]->id) }}" role="button">
                                                            <span class="material-symbols-outlined">settings</span>
                                                        </a>
                                                    </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif --}}
                                @if ($data['groupDetail'][0]->admin_user_id != $user->id)
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                            <h4 class="card-title">Groups</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-inline p-0 m-0" id="joinOrLeaveGroupButton">
                                                <li class="list-inline-item w-75">
                                                    @if($data['checkMember'])
                                                        <a href="javascript:void(0);" class="btn btn-primary d-block w-100 form-control rounded" data-bs-toggle="modal" data-bs-target="#leave-group" action="javascript:void();">Leave Group</a>
                                                        <div class="modal fade" id="leave-group" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="leave-group" aria-hidden="true" >
                                                            <div class="modal-dialog   modal-fullscreen-sm-down">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="align-items: flex-start;">
                                                                    <div class="modal-title text-dark" style="font-weight: bold;">
                                                                        Leave group?
                                                                </div>
                                                                    <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                                                        <span class="material-symbols-outlined">close</span>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body ">
                                                                    <div class="d-flex align-items-center">
                                                                        @if(isset($data['groupDetail'][0]->profile_image) && $data['groupDetail'][0]->profile_image !== '')
                                                                        <img class="avatar-80 rounded-circle-profile-tabs" src="{{asset('storage/images/group-img/'.$data['groupDetail'][0]->id.'/'.$data['groupDetail'][0]->profile_image)}}" alt="" loading="lazy" width="145" height="145">
                                                                        @else
                                                                        {{-- <img class="rounded-circle img-fluid avatar-100" src="{{asset('images/user/Users_512x512.png')}}" alt="group-profile" loading="lazy"> --}}
                                                                        <img class="rounded-circle img-fluid avatar-100" src="{{asset('images/user/groupProfile.png')}}" alt="group-profile" loading="lazy">
                                                                        @endif
                                                                        <p class="modal-title ms-3 " id="unfollow-modalLabel">Do you want to leave {{$data['groupDetail'][0]->group_name}}?</p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="d-flex align-items-center">
                                                                        <button data-bs-dismiss="modal" onclick="leaveGroup({{$user->id}},{{$data['groupDetail'][0]->id}})" class="btn btn-primary me-2">Yes</button>
                                                                        <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    @elseif (isset($data['checkRequest']) && $data['checkRequest']->status == 'pending')
                                                        <button class="btn btn-primary w-100" onclick="leaveGroupForm({{$data['groupDetail'][0]->id}}, {{$user->id}})">Cancel Request</button>
                                                    @else
                                                        <button onclick="joinGroup({{$user->id}},{{$data['groupDetail'][0]->id}})" class="btn btn-primary d-block w-100 form-control rounded">Join Group </button>
                                                    @endif
                                                    @if (isset($data['checkMember']) && isset($data['checkMember']->user_id) && $data['checkMember']->user_id == $user->id)
                                                        <li class="list-inline-item">
                                                            <div class="dropdown">
                                                                <span class=" btn btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                                    ...
                                                                </span>
                                                                <div class="dropdown-menu">
                                                                    @if (isset($data['checkMember']) && $data['checkMember']->follow == 1)
                                                                        <a href="javascript:void();" class="dropdown-item" id="unfollowGroupMember" onclick="unfollowGroupMember({{$user->id}},{{$data['groupDetail'][0]->id}})">Unfollow</a>
                                                                    @else
                                                                        <a href="javascript:void();" class="dropdown-item" id="followGroupMember" onclick="followGroupMember({{$user->id}},{{$data['groupDetail'][0]->id}})">Follow</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                                <div class="card mb-2">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <h4 class="card-title">About</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-inline p-0 m-0">
                                            <li class="mb-3">
                                            <p class="mb-0">{{$data['groupDetail'][0]->group_name}} Group...</p>
                                            </li>
                                            {{-- <li class="mb-3">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined">lock</i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6>{{$data['groupDetail'][0]->group_type}}</h6>
                                                </div>
                                            </div>
                                            </li> --}}
                                            {{-- <li class="mb-3">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined">visibility</i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6>Visible</h6>
                                                    <p class="mb-0">Various versions have evolved over the years</p>
                                                </div>
                                            </div>
                                            </li> --}}
                                            {{-- @if(isset({{$data['groupDetail'][0]->short_description}})) --}}
                                            @if ($data['groupDetail'][0]->short_description)
                                                <li class="">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            <i class="material-symbols-outlined">group</i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6>Description</h6>
                                                            <p class="mb-0">{{$data['groupDetail'][0]->short_description}}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="sidebar-default sidebar-base navs-rounded-all w-100">
                                            <div class="sidebar-body pt-0 data-scrollbar">
                                                <ul class="nav nav-pills w-100" id="groupTabs">
                                                    <li class="nav-item w-100 rounded">
                                                        <a class="nav-link list-group-item list-group-item-action border-0 d-flex text-primary active" data-bs-toggle="pill" href="#overview" role="tab" data-bs-target="#overview">
                                                            <i class="icon material-symbols-outlined material-symbols-outlined-filled filled me-1" style="font-size:25px">
                                                                layers
                                                            </i>
                                                            <span class="item-name"> Overview </span>
                                                        </a>
                                                    </li>
                                                    @if ($data['groupDetail'][0]->admin_user_id == $user->id && $data['groupDetail'][0]->group_type != 'Public')
                                                        <li class="nav-item w-100 rounded feedApprovals">
                                                            <a class="nav-link list-group-item list-group-item-action border-0 d-flex text-primary feedApprovals-nav" data-bs-toggle="pill" href="#feedApprovals" role="tab" data-bs-target="#feedApprovals">
                                                                <i class="icon material-symbols-outlined material-symbols-outlined-filled filled me-1" style="font-size:25px">
                                                                    newspaper
                                                                </i>
                                                                <span class="item-name"> Feed approvals </span>
                                                                @if($data['pendingFeedApprove']->count() >= 1)
                                                                    <span class="badge-pill border border-primary px-2 rounded text-primary">{{$data['pendingFeedApprove']->count()}}</span>
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if ($data['groupDetail'][0]->admin_user_id != $user->id && $data['groupDetail'][0]->group_type != 'Public' && $checkGroupMember == 1)
                                                        <li class="nav-item w-100 rounded feedApprovals">
                                                            <a class="nav-link list-group-item list-group-item-action border-0 d-flex text-primary" data-bs-toggle="pill" href="#feedApprovals" role="tab" data-bs-target="#feedApprovals">
                                                                <i class="icon material-symbols-outlined material-symbols-outlined-filled filled me-1" style="font-size:25px">
                                                                    newspaper
                                                                </i>
                                                                <span class="item-name"> Pending feed's </span>
                                                                @if($data['pendingFeedApproveUser']->count() >= 1)
                                                                    <span class="badge-pill border border-primary px-2 rounded text-primary">{{$data['pendingFeedApproveUser']->count()}}</span>
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li class="nav-item w-100 rounded">
                                                        <a class="nav-link list-group-item list-group-item-action border-0 d-flex text-primary" data-bs-toggle="pill" href="#groupMembers" role="tab" data-bs-target="#groupMembers">
                                                            <i class="icon material-symbols-outlined material-symbols-outlined-filled filled me-1" style="font-size:25px">
                                                                group
                                                            </i>
                                                            <span class="item-name"> Members </span>
                                                            @if($data['groupDetail'][0]->admin_user_id == $user->id && isset($data['allRequests']) && count($data['allRequests']) > 0)
                                                                <span class="badge-pill border border-primary rounded text-primary"><span class="material-symbols-outlined">exclamation</span></span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                    @if ($data['groupDetail'][0]->admin_user_id == $user->id)
                                                        <li class="nav-item w-100 rounded">
                                                            <a class="nav-link list-group-item list-group-item-action border-0 d-flex text-primary" data-bs-toggle="pill" href="#groupSetting" role="tab" data-bs-target="#groupSetting">
                                                                <i class="icon material-symbols-outlined material-symbols-outlined-filled filled me-1" style="font-size:25px">
                                                                    settings
                                                                </i>
                                                                <span class="item-name"> Group Setting </span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="modal fade" id="groupProfile-post-modal" aria-labelledby="groupPost-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 5rem">
                                <div class="modal-dialog modal-groupCreatePost">
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
                                                                <input type="file" name="profileImage" id="profile-image" required class="form-control" accept="image/x-png,image/gif,image/jpeg" placeholder="Profile Image" style="border:none;">
                                                                <input type="hidden" name="groupId" value={{ $data['groupDetail'][0]->id }} id="groupId" required class="form-control rounded" style="border:none;">
                                                                <input type="hidden" name="type" value="profile" required class="form-control rounded" style="border:none;">
                                                                <br />
                                                                <span id="error-profile" style="color: red; display: none;">Please select a valid image file</span>
                                                            </div>
                                                                <button style="display:none;" type="submit" id="showAndHideButtonProfile" class="btn btn-primary w-100 mt-3 upload-result">Update Profile Picture</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="groupCover-post-modal" aria-labelledby="coverPhoto-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 4rem">
                                <div class="modal-dialog modal-lg modal-lg-cover">
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
                                                            <input type="file" name="profileImage" id="cover-image" required class="form-control" accept="image/*" placeholder="Cover Image" style="border:none;">
                                                            <input type="hidden" name="groupId" id="groupIdforCover" value={{ $data['groupDetail'][0]->id}} required class="form-control rounded" style="border:none;">
                                                            <input type="hidden" name="type" value="cover" requiredclass="form-control rounded" style="border:none;">
                                                            <br />
                                                            <span id="error-cover" style="color: red; display: none;">Please select a valid image file</span>
                                                        </div>
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
                        </div>
                </div>
            </div>
        </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('js/croppie/croppie.js')}}"></script>
@push('scripts')
    <script src="{{ asset('js/feedModal.js?version=0.36') }}"></script>
@endpush
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
            const groupId = document.getElementById('groupId').value;
            $.ajax({
                url: "{{ route('imageCropGroup') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "image": resp,
                    "type": "Profile_image",
                    "groupId": groupId
                },
                success: function(data) {
                  $(".updateProfilePhoto").load(" .updateProfilePhoto"+"> *").fadeIn(0);
                  $(".updateNewsFeed").load(" .updateNewsFeed"+"> *").fadeIn(0);
                  setTimeout(function() {
                        $('.cover_spin_ProfilePhotoUpdate').hide();
                        $('#groupProfile-post-modal').modal('hide');
                        $("#profile-image").val("");
                        $(".cr-image").attr("src", "");
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
            const groupId = document.getElementById('groupIdforCover').value;
            $.ajax({
                url: "{{ route('imageCropGroup') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "image": resp,
                    "type": "Cover_image",
                    "groupId": groupId
                },
                success: function(data) {
                  $(".updateProfileCoverPhoto").load(" .updateProfileCoverPhoto"+"> *").fadeIn(0);
                  $(".coverImageDivRefresh").load(" .coverImageDivRefresh"+"> *").fadeIn(0);
                  setTimeout(function() {
                        $('.cover_spin_ProfilePhotoUpdate').hide();
                        $('#groupCover-post-modal').modal('hide');
                        $("#cover-image").val("");
                        $(".cr-image").attr("src", "");
                  }, 3000);
                }
            });
        });
    });

</script>
<script>

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

// function previewImagesNewsFeed() {
//     var preview = document.querySelector('#preview');
//     preview.innerHTML = '';
//     var files = document.querySelector('#profileImagePost').files;
//     for (var i = 0; i < files.length; i++) {
//         var file = files[i];
//         var reader = new FileReader();
//         reader.onload = function (event) {
//             var element;
//             if (file.type.match('video.*')) { // Check if the file is a video
//                 element = document.createElement('video');
//                 element.controls = true;
//                 element.style.width = '100%';
//                 element.style.height = '100%';
//                 element.style.objectFit = 'cover';
//                 element.src = URL.createObjectURL(file); // Create a new URL for each video file
//             } else {
//                 element = document.createElement('img');
//                 element.src = event.target.result;
//                 element.style.width = '100%';
//                 element.style.height = '100%';
//                 element.style.objectFit = 'cover';
//             }
//             preview.appendChild(element);
//         };
//         reader.readAsDataURL(file);
//     }
//  }
</script>
</x-app-layout>
