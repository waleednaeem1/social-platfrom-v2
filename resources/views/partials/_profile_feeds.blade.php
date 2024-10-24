<div class="modal fade" id="post-modal" tabindex="-1" style="min-height: 400px; margin-top:5rem" aria-labelledby="post-modalLabel" aria-hidden="true">
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
                                    @if (isset($data['user']->avatar_location) && $data['user']->avatar_location !== '')
                                        <img src="{{ asset('storage/images/user/userProfileandCovers/' . $user->id . '/' . $data['user']->avatar_location) }}" alt="userimg" class="avatar-60 rounded-circle">
                                    @else
                                        <img src="{{asset('images/user/Users_60x60.png')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-11">
                                <form method="" id="profileTimelineFeed" action="" class="post-text w-100 my-3" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" id="postText" name="postData" class="form-control rounded" placeholder="Write something here..." style="border:none;">
                                    <input type="hidden" class="form-control rounded" value={{ $user->id }} name="userId" style="border:none;">
                                    <input type="hidden" class="form-control rounded" value="profilePage" name="pageType">
                                    <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 ml-auto">
                            </div>
                            <div class="col-sm-11">
                                <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                                    <li class="col-md-6 mb-3">
                                        <input type="file" multiple name="profileImage[]" id="profileImagePost" class="form-control fileInputGetOldValues" accept="image/*,video/mp4,video/x-m4v,video/*" placeholder="Profile Image" style="border:none;" onchange="previewImagesNewsFeed()">
                                        <div id="preview" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 8px; overflow-y: auto; max-height: 300px;min-width: 650px; margin-top: 10px;"></div>
                                    </li>
                                   
                                </ul>
                                <button type="submit" id="ProfilePostCreateButton" class="btn btn-primary d-block w-100 mt-3">Post</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> --}}
                @include('partials/_create_post')
        </div>
    </div>
</div>
<div class="col-lg-12 col-xxl-8 updateFeed updateNewsFeed">
    @if ($data['self_profile'])
        <div id="post-modal-data" class="card" >
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Create Post</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="user-img">
                        @if (isset($data['user']->avatar_location) && $data['user']->avatar_location !== '')
                            <img src="{{ asset('storage/images/user/userProfileandCovers/' . $user->id . '/' . $data['user']->avatar_location) }}" alt="userimg" class="avatar-60 rounded-circle">
                        @else
                            <img src="{{asset('images/user/Users_60x60.png')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                        @endif
                    </div>
                    <form class="post-text ms-3 w-100 buttonEnable" data-bs-toggle="modal" data-bs-target="#post-modal" action="javascript:void();">
                        <input type="text" class="form-control rounded" placeholder="Write something here..." style="border:none; background-color:white">
                    </form>
                </div>
                <hr>
                <ul class=" post-opt-block d-flex list-inline m-0 p-0 flex-wrap">
                    <li class="me-3 mb-md-0 mb-2">
                        <a href="javascript:void();" class="btn btn-soft-primary buttonEnable" data-bs-toggle="modal" data-bs-target="#post-modal">
                            <img src="{{ asset('images/user/Users_24x24.png') }}" alt="icon" class="img-fluid me-2"> Photo/Video
                        </a>
                    </li>
                    {{-- <li class="bg-soft-primary rounded p-2 pointer d-flex align-items-center me-3 mb-md-0 mb-2"><img src="{{asset('images/small/08.png')}}" alt="icon" class="img-fluid me-2"> Tag Friend</li> --}}
                    {{-- <li class="me-3 mb-md-0 mb-2">
                        <a href="#" class="btn btn-soft-primary" data-bs-toggle="modal" data-bs-target="#post-modal" action="javascript:void();">
                            <img src="{{asset('images/small/09.png')}}" alt="icon" class="img-fluid me-2"> Feeling/Activity
                        </a>
                    </li> --}}
                    {{-- <li class="bg-soft-primary rounded p-2 pointer text-center">
                        <div class="card-header-toolbar d-flex align-items-center">
                        <div class="dropdown">
                            <div class="dropdown-toggle" id="post-option"   data-bs-toggle="dropdown">
                                <span class="material-symbols-outlined">
                                    more_horiz
                                </span>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="post-option" style="">
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#post-modal">Check in</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#post-modal">Live Video</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#post-modal">Gif</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#post-modal">Watch Party</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#post-modal">Play with Friend</a>
                            </div>
                        </div>
                        </div>
                    </li> --}}
                </ul>
            </div>
        </div>
    @endif
    <div class="card shadow-none bg-transparent">
        <div class="card-body p-0">
            <div class="post-item" id="loadeMoreFeed">
                @if($data['feedsLock'] == false)
                    @foreach ($data['feeds'] as $feed)
                        @include('partials/_feed')
                    @endforeach
                    <p id="websiteEnvironment" class="d-none">{{$data['environment']}}</p>
                    @if($data['feeds']->count() != 0)
                        <div class="card p-4 feed__loder ">
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
                    @endif
                    <div class="modal fade" id="feed_likes_modal_popup" >
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
                @else
                <div class="card">
                    <div class="align-items-center card-body d-flex gap-2 justify-content-center p-0" style="max-height: 110px; padding-top: 40px !important;padding-bottom: 40px !important;">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#8c68cd" version="1.1" id="Capa_1" width="40" height="50px" viewBox="0 0 342.52 342.52" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M171.254,110.681c-14.045,0-25.47,11.418-25.47,25.476v21.773h50.933v-21.773    C196.724,122.104,185.29,110.681,171.254,110.681z"/>
                                    <path d="M171.26,0C76.825,0,0.006,76.825,0.006,171.257c0,94.438,76.813,171.263,171.254,171.263    c94.416,0,171.254-76.825,171.254-171.263C342.514,76.825,265.683,0,171.26,0z M226.225,239.291c0,4.119-3.339,7.446-7.458,7.446    h-95.032c-4.113,0-7.446-3.327-7.446-7.446v-73.91c0-4.119,3.333-7.458,7.446-7.458h7.152V136.15    c0-22.266,18.113-40.361,40.367-40.361c22.251,0,40.355,18.095,40.355,40.361v21.773h7.151c4.119,0,7.458,3.338,7.458,7.458v73.91    H226.225z"/>
                                </g>
                            </g>
                        </svg>
                        <div >
                            <p class="fw-semibold" style="max-height: 10px;">This timeline is locked</p>
                        </div>
                    </div>
                </div>
                @endif
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
            
        </div>
    </div>
</div>
