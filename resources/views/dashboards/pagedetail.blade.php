@php
   $user = auth()->user();
   use App\Models\PageMembers;
   $checkPageMember = count(PageMembers::where(['page_id' => $data['pageDetail'][0]->id, 'user_id' => $user->id])->get());
   $classcomment = 'pagecomnt';
@endphp
<link rel="stylesheet" href="{{ asset('css/croppie/croppie.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<x-app-layout>
   <div class="container">
      <div class="row">
          <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
            <div class="header-for-bg container">
               <div class="background-header position-relative updateProfileCoverPhoto">
                  @if(isset($data['pageDetail'][0]->cover_image) && $data['pageDetail'][0]->cover_image !== '')
                     <a data-fslightbox="gallery" href="{{asset('storage/images/page-img/'.$data['pageDetail'][0]->id . '/' . 'cover' . '/' . $data['pageDetail'][0]->cover_image)}}" class="dropdown-item"><img src="{{asset('storage/images/page-img/'.$data['pageDetail'][0]->id . '/' . 'cover' . '/' . $data['pageDetail'][0]->cover_image)}}" class="w-100 rounded" style="height:450px; object-fit: fill;" alt="header-bg"></a>
                  @else
                     <img src="{{asset('images/user/Banners-03.png')}}" class="img-fluid w-100 rounded rounded" alt="header-bg" style="height:450px; object-fit: fill;">
                  @endif
               </div>
               <div class="row position-relative">
                  <div class="container coverImageDivRefresh">
                        <div class="col-md-12" style="text-align: end;">
                           {{-- @if ($data['pageDetail'][0]->admin_user_id == $user->id) --}}
                              <div class="dropdown">
                                    {{-- @if($data['pageDetail'][0]->admin_user_id != $user->id && isset($data['pageDetail'][0]->cover_image) && $data['pageDetail'][0]->cover_image !=='' && $data['pageDetail'][0]->cover_image !== null)
                                       <a href="#" data-bs-toggle="dropdown" class="material-symbols-outlined dropdown shadow" id="upload_camera_icon" style="margin-top: -1rem; overflow: hidden;">
                                          visibility
                                       </a>
                                    @endif --}}
                                    @if($data['pageDetail'][0]->admin_user_id == $user->id)
                                       <a href="javascript:void();" data-bs-toggle="dropdown" class="fa fa-camera fa dropdown shadow" id="upload_camera_icon" style="margin-top: -1rem; overflow: hidden;">
                                       </a>
                                    @endif
                                    <div class="dropdown-menu">
                                    @if(isset($data['pageDetail'][0]->cover_image) && $data['pageDetail'][0]->cover_image !=='')
                                       <a data-fslightbox="gallery" href="{{asset('storage/images/page-img/'.$data['pageDetail'][0]->id . '/' . 'cover' . '/' . $data['pageDetail'][0]->cover_image)}}" class="dropdown-item">View Cover Picture</a>
                                    @endif
                                    @if ($data['pageDetail'][0]->admin_user_id == $user->id)
                                       <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#pageCover-modal" class="dropdown-item">Update Cover Picture</a>
                                    @endif
                                    </div>
                              </div>
                           {{-- @endif --}}
                        </div>
                  </div>
               </div>
            </div>
            <div id="content-page" class="content-page updatePageData">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-12 updateProfilePhoto">
                        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
                           <div class="group-info d-flex align-items-center">
                              <div class="me-3">
                                 @if(isset($data['pageDetail'][0]->profile_image) && $data['pageDetail'][0]->profile_image !== '')
                                    <a data-fslightbox="gallery" href="{{asset('storage/images/page-img/'.$data['pageDetail'][0]->id.'/'.$data['pageDetail'][0]->profile_image)}}" class="dropdown-item"><img class="rounded-circle" src="{{asset('storage/images/page-img/'.$data['pageDetail'][0]->id.'/'.$data['pageDetail'][0]->profile_image)}}" alt="" loading="lazy" width="145" height="145"></a>
                                 @else
                                    <img class="rounded-circle img-fluid avatar-100" src="{{asset('images/user/pageProfile.png')}}" alt="" loading="lazy">
                                 @endif
                              </div>
                              {{-- @if ($data['pageDetail'][0]->admin_user_id == $user->id) --}}
                                 <div class="dropdown profileImageDivRefresh">
                                       {{-- @if ($data['pageDetail'][0]->admin_user_id != $user->id && isset($data['pageDetail'][0]->profile_image) && $data['pageDetail'][0]->profile_image !=='' && $data['pageDetail'][0]->profile_image !== null)
                                          <a href="#" data-bs-toggle="dropdown" class="material-symbols-outlined" id="upload_camera_icon" style="margin-top: 6rem; margin-left: -3rem;">
                                             visibility
                                          </a>
                                       @endif --}}
                                       @if ($data['pageDetail'][0]->admin_user_id == $user->id)
                                          <a href="javascript:void();" data-bs-toggle="dropdown" class="fa fa-camera fa dropdown shadow" id="upload_camera_icon" style="margin-top: 6rem; margin-left: -3rem;">
                                          </a>
                                       @endif
                                       <div class="dropdown-menu">
                                          @if(isset($data['pageDetail'][0]->profile_image) && $data['pageDetail'][0]->profile_image !=='')
                                             <a data-fslightbox="gallery" href="{{asset('storage/images/page-img/'.$data['pageDetail'][0]->id.'/'.$data['pageDetail'][0]->profile_image)}}" class="dropdown-item">View Profile Picture</a>
                                          @endif
                                          @if ($data['pageDetail'][0]->admin_user_id == $user->id)
                                             <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#pageProfile-modal" class="dropdown-item">Update Profile Picture</a>
                                          @endif
                                       </div>
                                 </div>
                              {{-- @endif --}}
                              <div class="info" style="margin-left: 1rem">
                                 <h4>{{$data['pageDetail'][0]->page_name}}</h4>
                                 {{-- <p class="mb-0 d-flex">@if ($data['pageDetail'][0]->page_type == 'private')<i class="material-symbols-outlined pe-2">lock</i>@endif{{$data['pageDetail'][0]->page_type}} page</p> --}}
                                 {{-- <p class="mb-0 d-flex">@if ($data['pageDetail'][0]->page_type == 'Public')<i class="material-symbols-outlined pe-2" style="margin-left: -5px;">public</i>@elseif ($data['pageDetail'][0]->page_type == 'Private')<i class="material-symbols-outlined pe-2" style="margin-left: -5px;">lock</i>@endif{{$data['pageDetail'][0]->page_type}} page</p> --}}
                                 <p>@if($data['checkMemberCount'] == 1) {{$data['checkMemberCount']}} Follower @else {{$data['checkMemberCount']}} Followers @endif</p>
                              </div>
                           </div>
                           <div class="group-member d-flex align-items-center  mt-md-0 mt-2">
                              <div class="iq-media-group me-3">

                                 @if(isset($data['pageDetail'][0]['pageMembers'][0]['getUser']->avatar_location))
                                    <a href="{{route('user-profile',  ['username' => $data['pageDetail'][0]['pageMembers'][0]['getUser']->username])}}" class="iq-media">
                                          <img class="avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['pageDetail'][0]['pageMembers'][0]['getUser']->id.'/'.$data['pageDetail'][0]['pageMembers'][0]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                    </a>
                                 @endif
                                 @if(isset($data['pageDetail'][0]['pageMembers'][1]['getUser']->avatar_location))
                                    <a href="{{route('user-profile',  ['username' => $data['pageDetail'][0]['pageMembers'][1]['getUser']->username])}}" class="iq-media">
                                          <img class="avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['pageDetail'][0]['pageMembers'][1]['getUser']->id.'/'.$data['pageDetail'][0]['pageMembers'][1]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                    </a>
                                 @endif
                                 @if(isset($data['pageDetail'][0]['pageMembers'][2]['getUser']->avatar_location))
                                    <a href="{{route('user-profile',  ['username' => $data['pageDetail'][0]['pageMembers'][2]['getUser']->username])}}" class="iq-media">
                                          <img class="avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['pageDetail'][0]['pageMembers'][2]['getUser']->id.'/'.$data['pageDetail'][0]['pageMembers'][2]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                    </a>
                                 @endif
                                 @if(isset($data['pageDetail'][0]['pageMembers'][3]['getUser']->avatar_location))
                                    <a href="{{route('user-profile',  ['username' => $data['pageDetail'][0]['pageMembers'][3]['getUser']->username])}}" class="iq-media">
                                          <img class="avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['pageDetail'][0]['pageMembers'][3]['getUser']->id.'/'.$data['pageDetail'][0]['pageMembers'][3]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                    </a>
                                 @endif
                                 @if(isset($data['pageDetail'][0]['pageMembers'][4]['getUser']->avatar_location))
                                    <a href="{{route('user-profile',  ['username' => $data['pageDetail'][0]['pageMembers'][4]['getUser']->username])}}" class="iq-media">
                                          <img class="avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['pageDetail'][0]['pageMembers'][4]['getUser']->id.'/'.$data['pageDetail'][0]['pageMembers'][4]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                    </a>
                                 @endif
                                 @if(isset($data['pageDetail'][0]['pageMembers'][5]['getUser']->avatar_location))
                                    <a href="{{route('user-profile',  ['username' => $data['pageDetail'][0]['pageMembers'][5]['getUser']->username])}}" class="iq-media">
                                          <img class="avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['pageDetail'][0]['pageMembers'][5]['getUser']->id.'/'.$data['pageDetail'][0]['pageMembers'][5]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                    </a>
                                 @endif
                                 @if(isset($data['pageDetail'][0]['pageMembers'][6]['getUser']->avatar_location))
                                    <a href="{{route('user-profile',  ['username' => $data['pageDetail'][0]['pageMembers'][6]['getUser']->username])}}" class="iq-media">
                                          <img class="avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['pageDetail'][0]['pageMembers'][6]['getUser']->id.'/'.$data['pageDetail'][0]['pageMembers'][6]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                    </a>
                                 @endif
                              </div>
                              {{-- <button type="submit" class="btn btn-primary d-flex gap-2"><i class="material-symbols-outlined">add</i>Invite</button> --}}
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-8 updateFeed updateNewsFeed">
                        {{-- @if($checkPageMember == 1) --}}
                        @if ($data['pageDetail'][0]->admin_user_id == $user->id)
                           <div id="post-modal-data" class="card">
                              <div class="card-header d-flex justify-content-between">
                                 <div class="header-title">
                                    <h4 class="card-title">Create Post</h4>
                                 </div>
                              </div>
                              <div class="card-body">
                                 <div class="d-flex align-items-center">
                                    <div class="user-img">
                                       @if(isset($data['pageDetail'][0]->profile_image) && $data['pageDetail'][0]->profile_image !== '')
                                          <img src="{{asset('storage/images/page-img/'.$data['pageDetail'][0]->id.'/'.$data['pageDetail'][0]->profile_image)}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                       @else
                                          <img src="{{asset('images/user/pageProfile.png')}}" alt="userimg" class="avatar-45 rounded-circle" loading="lazy">
                                       @endif
                                    </div>
                                    <form class="post-text ms-3 w-100 buttonEnable" action="javascript:void();">
                                       <input type="text"  class="form-control rounded input-focus" placeholder="Write something here..." style="border:none;background-color:white" onclick="createPostModalShow()" readonly>
                                    </form>
                                 </div>
                                 <hr>
                                 <ul class=" post-opt-block d-flex list-inline m-0 p-0 flex-wrap">
                                    <li class="me-3 mb-md-0 mb-2">
                                       <a href="javascript:void();" class="btn btn-soft-primary buttonEnable" onclick="createPostModalShow()" action="javascript:void();">
                                          <img src="{{asset('images/user/Users_24x24.png')}}" alt="story-img" alt="icon" class="me-2" loading="lazy"> Photo/Video
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
                           </div>
                           {{-- <div class="modal fade" id="post-modal" tabindex="-1"  aria-labelledby="post-modalLabel" aria-hidden="true" style="margin-top:5rem" >
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
                                             @if(isset($data['pageDetail'][0]->profile_image) && $data['pageDetail'][0]->profile_image !== '')
                                                <img src="{{asset('storage/images/page-img/'.$data['pageDetail'][0]->id.'/'.$data['pageDetail'][0]->profile_image)}}" alt="userimg" class="avatar-60 rounded-circle">
                                             @else
                                                <img src="{{asset('images/user/pageProfile.png')}}" alt="userimg" class="avatar-45 rounded-circle">
                                             @endif
                                          </div>
                                          <form method="" id="groupAndPagePostCreate" action="" class="post-text ms-3 w-100" enctype="multipart/form-data">
                                             @csrf
                                             <input type="text" name="postData" id="postText" class="form-control rounded" placeholder="Write something here..." style="border:none;">
                                             <input type="hidden" class="form-control rounded" value={{$user->id}} name="userId" style="border:none;">
                                             <input type="hidden" class="form-control rounded" value={{$data['pageDetail'][0]->id}} name="pageId" style="border:none;">
                                             <input type="hidden" class="form-control rounded" value="pageFeed" name="type" style="border:none;">
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
                                                         @if(isset($data['pageDetail'][0]->profile_image) && $data['pageDetail'][0]->profile_image !== '')
                                                            <img src="{{asset('storage/images/page-img/'.$data['pageDetail'][0]->id.'/'.$data['pageDetail'][0]->profile_image)}}" alt="userimg" class="avatar-60 rounded-circle">
                                                         @else
                                                            <img src="{{asset('images/user/pageProfile.png')}}" alt="userimg" class="avatar-45 rounded-circle">
                                                         @endif
                                                   </div>
                                                </div>
                                                <div class="col-sm-11">
                                                   <form method="" id="groupAndPagePostCreate" action="" class="post-text my-3 w-100" enctype="multipart/form-data">
                                                         @csrf
                                                         <input type="text" name="postData" id="postText" class="form-control rounded" placeholder="Write something here..." style="border:none;">
                                                         <input type="hidden" class="form-control rounded" value={{$user->id}} name="userId" style="border:none;">
                                                         <input type="hidden" class="form-control rounded" value={{$data['pageDetail'][0]->id}} name="pageId" style="border:none;">
                                                         <input type="hidden" class="form-control rounded" value="pageFeed" name="type" style="border:none;">
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
                        @endif

                        @foreach($data['feeds'] as $feed)
                           @if(isset($feed))
                              @include('partials/_feed')
                           @endif
                        @endforeach
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
                     </div>
                     <div class="col-lg-4">
                        @if ($data['pageDetail'][0]->admin_user_id != $user->id)
                           <div class="card">
                              <div class="card-header d-flex justify-content-between">
                                 <div class="header-title">
                                    <h4 class="card-title">Page</h4>
                                 </div>
                              </div>
                              <div class="card-body">
                                 <ul class="list-inline p-0 m-0">
                                    {{-- <li class="mb-3 pb-3 border-bottom">
                                       <div class="iq-search-bar members-search p-0">
                                          <form action="#" class="searchbox w-auto">
                                             <input type="text" class="text search-input bg-grey bg-soft-primary" placeholder="Type here to search...">
                                             <a class="search-link" href="#"><i class="material-symbols-outlined">search</i></a>
                                          </form>
                                       </div>
                                    </li>
                                    <li class="mb-3 d-flex align-items-center">
                                       <div class="avatar-40 rounded-circle bg-gray d-flex align-items-center justify-content-center me-3"><i class="material-symbols-outlined">credit_card</i></div>
                                       <h6 class="mb-0">Your Feed</h6>
                                    </li>
                                    <li class="mb-3 d-flex align-items-center">
                                       <div class="avatar-40 rounded-circle bg-gray d-flex align-items-center justify-content-center me-3"><i class="material-symbols-outlined">explore</i></div>
                                       <h6 class="mb-0">Discover</h6>
                                    </li> --}}
                                    <li >
                                       @if($data['checkMember'])
                                       <button onclick="UnLikePage({{$user->id}},{{$data['pageDetail'][0]->id}}, 'type')" class="btn btn-secondary d-flex align-items-center d-block w-100 form-control rounded" style="justify-content: center;">Liked </button>
                                          {{-- <form method="POST" action="{{route('leavePage')}}">
                                             @csrf
                                             <input type="hidden" class="form-control rounded" value={{ $user->id }} name="userId">
                                             <input type="hidden" class="form-control rounded" value={{ $data['pageDetail'][0]->id }} name="pageId">
                                             <input type="hidden" class="form-control rounded" value="detailpage" name="type">
                                             <button type="submit" >Liked </button>
                                          </form> --}}
                                          {{-- <button onclick="leaveGroup({{$user->id}},{{$data['pageDetail'][0]->id}})" class="btn btn-primary d-flex align-items-center d-block w-100 form-control rounded">Leave Group </button> --}}
                                       @else
                                       <button onclick="LikePage({{$user->id}},{{$data['pageDetail'][0]->id}}, 'type')" class="btn btn-primary d-flex align-items-center d-block w-100 form-control rounded" style="justify-content: center;">Like </button>
                                       {{-- <form method="POST" action="{{route('like-page')}}">
                                          @csrf
                                          <input type="hidden" class="form-control rounded" value={{ $user->id }} name="userId">
                                          <input type="hidden" class="form-control rounded" value={{ $data['pageDetail'][0]->id }} name="pageId">
                                          <input type="hidden" class="form-control rounded" value="detailpage" name="type">
                                       </form> --}}
                                       @endif
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        @endif
                        <div class="card">
                           <div class="card-header d-flex justify-content-between">
                              <div class="header-title">
                                 <h4 class="card-title">About</h4>
                              </div>
                              @if ($data['pageDetail'][0]->admin_user_id == $user->id)
                                 <div class="header-title">
                                    <a href="{{ route('editPage', $data['pageDetail'][0]->id) }}" role="button">
                                       <span class="material-symbols-outlined">settings</span>
                                    </a>
                                 </div>
                              @endif
                           </div>
                           <div class="card-body">
                              <ul class="list-inline p-0 m-0">
                                 <li class="mb-3">
                                    <h5 class="mb-0">{{$data['pageDetail'][0]->page_name}}</h5>
                                 </li>
                                 @if ($data['pageDetail'][0]->bio)
                                 <li class="mb-3">
                                    <b>Bio:</b><p class="mb-0">{{$data['pageDetail'][0]->bio}}</p>
                                 </li>
                              @endif
                                 <li class="mb-3">
                                    <b>Category:</b><p class="mb-0">{{str_replace(', ', ' . ', $data['pageDetail'][0]->category)}}</p>
                                 </li>
                                 {{-- <li class="mb-3">
                                    <div class="d-flex">
                                       <div class="flex-shrink-0">
                                          <i class="material-symbols-outlined">lock</i>
                                       </div>
                                       <div class="flex-grow-1 ms-3">
                                          <h6>{{$data['pageDetail'][0]->page_type}}</h6>
                                          <p class="mb-0">Success in slowing economic activity.</p>
                                       </div>
                                    </div>
                                 </li>
                                 <li class="mb-3">
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
                                 @if ($data['pageDetail'][0]->short_description)
                                 <li class="">
                                    <div class="d-flex">
                                       <div class="flex-shrink-0">
                                          <i class="material-symbols-outlined">group</i>
                                       </div>
                                       <div class="flex-grow-1 ms-3">
                                          <h6>Intro</h6>
                                          <p class="mb-0">{{$data['pageDetail'][0]->short_description}}</p>
                                       </div>
                                    </div>
                                 </li>
                              @endif
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal fade" id="pageCover-modal" aria-labelledby="coverPhoto-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 4rem">
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
                                          <input type="hidden" name="pageId" id="pageIdforCover" value={{ $data['pageDetail'][0]->id}} required class="form-control rounded" style="border:none;">
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
            <div class="modal fade" id="pageProfile-modal" aria-labelledby="groupPost-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 5rem">
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
                                                <input type="hidden" name="pageId" value={{ $data['pageDetail'][0]->id }} id="pageId" required class="form-control rounded" style="border:none;">
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
         const pageId = document.getElementById('pageId').value;
         $.ajax({
            url: "{{ route('imageCropPage') }}",
            type: "POST",
            data: {
               "_token": "{{ csrf_token() }}",
               "image": resp,
               "type": "Profile_image",
               "pageId": pageId
            },
            success: function(data) {
               $(".updateProfilePhoto").load(" .updateProfilePhoto"+"> *").fadeIn(0);
               $(".profileImageDivRefresh").load(" .profileImageDivRefresh"+"> *").fadeIn(0);
               $(".updateNewsFeed").load(" .updateNewsFeed"+"> *").fadeIn(0);
               setTimeout(function() {
                     $('.cover_spin_ProfilePhotoUpdate').hide();
                     $('#pageProfile-modal').modal('hide');
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
         const pageId = document.getElementById('pageIdforCover').value;
         $.ajax({
            url: "{{ route('imageCropPage') }}",
            type: "POST",
            data: {
               "_token": "{{ csrf_token() }}",
               "image": resp,
               "type": "Cover_image",
               "pageId": pageId
            },
            success: function(data) {
               $(".updateProfileCoverPhoto").load(" .updateProfileCoverPhoto"+"> *").fadeIn(0);
               $(".coverImageDivRefresh").load(" .coverImageDivRefresh"+"> *").fadeIn(0);
               setTimeout(function() {
                     $('.cover_spin_ProfilePhotoUpdate').hide();
                     $('#pageCover-modal').modal('hide');
                     $("#profile-image").val("");
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

   function LikePage(userId,pageId)
   {
      $.ajax({
         method: 'POST',
         url: '/like-page',
         data: {userId: userId,pageId:pageId,type:'detailpage'},
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      }).done(function (response) {
         $(".updatePageData").hide().load(" .updatePageData"+"> *").fadeIn(0);
      });
   }
   function UnLikePage(userId,pageId)
   {
      $.ajax({
         method: 'POST',
         url: '/leavePage',
         data: {userId: userId,pageId:pageId,type:'detailpage'},
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      }).done(function (response) {
         $(".updatePageData").hide().load(" .updatePageData"+"> *").fadeIn(0);
      });
   }
//    function previewImagesNewsFeed()
//    {
//       var preview = document.querySelector('#preview');
//       preview.innerHTML = '';
//       var files = document.querySelector('#profileImagePost').files;
//       for (var i = 0; i < files.length; i++) {
//          var file = files[i];
//          var reader = new FileReader();
//          reader.onload = function (event) {
//             var element;
//             if (file.type.match('video.*')) { // Check if the file is a video
//                   element = document.createElement('video');
//                   element.controls = true;
//                   element.style.width = '100%';
//                   element.style.height = '100%';
//                   element.style.objectFit = 'cover';
//                   element.src = URL.createObjectURL(file); // Create a new URL for each video file
//             } else {
//                   element = document.createElement('img');
//                   element.src = event.target.result;
//                   element.style.width = '100%';
//                   element.style.height = '100%';
//                   element.style.objectFit = 'cover';
//             }
//             preview.appendChild(element);
//          };
//          reader.readAsDataURL(file);
//       }
//    }


</script>
</x-app-layout>
