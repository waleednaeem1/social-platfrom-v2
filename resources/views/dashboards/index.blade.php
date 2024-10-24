@php
    $user = auth()->user();
    use App\Models\GroupMembers;
    use App\Models\FeedReport;
@endphp

<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                <div class="col-sm-12">
                    @if ( $user->avatar_location == null || $user->avatar_location == '')
                        <div class="card">
                            <div class="card-header justify-content-between" style="">
                                <div class="header-title w-100">
                                    <div class="d-flex alighn-item-center justify-content-between">
                                        <p class="h4 m-0 my-auto p-0">Complete Your Profile</p>
                                        <a style="float: right;" href="{{ route('user-profile', $user->username) }}" class="btn btn-primary me-2">Edit Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card" style="height:290px" id="stories-div">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Stories</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="media-story list-inline m-0 p-0">
                                <li class="d-flex mb-3 align-items-center">
                                    <div class="item-link" data-bs-toggle="modal" data-bs-target="#story-modal" action="javascript:void();" style="display: flex;flex-direction: column;justify-content: center;align-items: center;cursor: pointer;">
                                        <div style="border-radius: 5%;border:2px solid #bd3381;">
                                            @if (isset($data['user']->avatar_location) && $data['user']->avatar_location !== '')
                                                <img src="{{ asset('storage/images/user/userProfileandCovers/' . $data['user']->id . '/' . $data['user']->avatar_location) }}" alt="story-img" class="img-fluid" style="margin-top:0px;object-fit: cover;width:113px;">
                                            @else
                                                <img src="{{ asset('images/user/Users_120x120.png') }}" alt="userimg" loading="lazy" style="height:113px;object-fit: cover;">
                                            @endif

                                            <div style="font-size:30px;text-align:center;">+</div>
                                        </div>
                                        <div style="font-size:15px; ">Create Story </div>

                                    </div>
                                    <div id="stories" class="storiesWrapper" style="padding:5px 0px 0px 5px;"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="post-modal-data" class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Create Post</h4>
                            </div>
                        </div>
                        <a href="javascript:void();" class="buttonEnable">
                            <div class="card-body">
                                <div class="d-flex align-items-center" >
                                    <div class="user-img">
                                        @if (isset($data['user']->avatar_location) && $data['user']->avatar_location !== '')
                                            <img src="{{ asset('storage/images/user/userProfileandCovers/' . $user->id . '/' . $data['user']->avatar_location) }}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                        @else
                                            {{-- <img src="{{asset('images/user/1.jpg')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy"> --}}
                                            <img src="{{ asset('images/user/Users_100x100.png') }}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                        @endif
                                    </div>
                                    <form class="post-text ms-3 w-100 buttonEnable" action="javascript:void();" >
                                        <input type="text" class="form-control rounded input-focus" placeholder="Write something here..." style="border:none; background-color:white" onclick="createPostModalShow()" readonly>
                                    </form>
                                </div>
                                <hr>
                                <ul class=" post-opt-block d-flex list-inline m-0 p-0 flex-wrap">
                                    <li class="me-3 mb-md-0 mb-2">
                                        <a href="javascript:void();" class="btn btn-soft-primary buttonEnable" onclick="createPostModalShow()">
                                            {{-- <img src="{{asset('images/small/07.png')}}" alt="story-img" class="img-fluid" alt="icon" class="img-fluid me-2" loading="lazy"> Photo/Video --}}
                                            <img src="{{ asset('images/user/Users_24x24.png') }}" alt="story-img" alt="icon" class="me-2" loading="lazy"> Photo/Video
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </a>
                    </div>
                </div>
                <!--group feeds -->
                <span class="updateFeed" id="loadeMoreFeed">
                    @foreach ($data['feeds'] as $key => $feed)
                        @include('partials/_feed')
                    @endforeach
                </span>
                @if($data['feeds']->count() == 0)
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
                                <div class="cover_spin"></div>
                                <div id="feedModalBodyContent" class="modal-content border-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <p id="websiteEnvironment" class="d-none">{{ $data['environment'] }}</p>
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
            </div>
            {{-- <div class="col-lg-4">
                @if ($data['webinars'] && count($data['webinars']) > 0)
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Webinars</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="media-story list-inline m-0 p-0">
                                @foreach ($data['webinars'] as $webinar)
                                    @if (isset($webinar))
                                        <li class="d-flex mb-4 align-items-center ">
                                            <a href="https://www.vetandtech.com/webinars/{{ $webinar->slug }}" target="_blank" style="display:flex; align-items:center">
                                                @if (isset($webinar->image) && $webinar->image !== '')
                                                    <img src="https://web.dvmcentral.com/up_data/webiners/images/{{ $webinar->image }}" alt="webinar-img" style="object-fit: fill" class="rounded-circle avatar-50" loading="lazy">
                                                @else
                                                    <img src="{{ asset('storage/images/page-img/s4.jpg') }}" alt="story-img" class="rounded-circle img-fluid" loading="lazy">
                                                @endif
                                                <div class="stories-data ms-3">
                                                    <h5>{{ $webinar->name }}</h5>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if ($data['birthdaysData'] && count($data['birthdaysData']) > 0)
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Birthdays</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="media-story list-inline m-0 p-0">
                                @foreach ($data['birthdaysData'] as $month => $friends)
                                    @if (isset($friends))
                                        <h5 class="card-title">{{ \App\Models\User::$months[$month] }} Birthdays</h5>
                                        @foreach ($friends as $friend)
                                            @if (isset($friend))
                                                @php
                                                    $path = asset('storage/images/user/userProfileandCovers/' . $friend->id . '/' . $friend->avatar_location);
                                                    if ($friend->avatar_location == '') {
                                                        $path = asset('images/user/Users_60x60.png');
                                                    }
                                                @endphp
                                                <li class="d-flex mb-4 align-items-center">
                                                    @if (isset($friend->username) && $friend->username !== '')
                                                        <a href="{{ route('user-profile', ['username' => $friend->username]) }}">
                                                            <img src="{{ $path }}" alt="profile-img" class="img-fluid rounded-circle img-fluid avatar-50">
                                                        </a>
                                                    @else
                                                        <img src="{{ $path }}" alt="profile-img" class="img-fluid">
                                                    @endif
                                                    <div class="stories-data ms-3">
                                                        <h5>{{ $friend->first_name . ' ' . $friend->last_name }}</h5>
                                                        <p class="mb-0">{{ date('dS M', strtotime($friend->dob)) }}</p>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if ($data['pages'] && count($data['pages']) > 0)
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Suggested Pages</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="suggested-page-story m-0 p-0 list-inline">
                                @foreach ($data['pages'] as $page)
                                    @if (isset($page))
                                        <li class="mb-3">
                                            <a href="{{ route('pagedetail', $page->id) }}">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="stories-data ms-3">
                                                        <h5 style="color: var(--bs-primary)">{{ $page->page_name }}</h5>
                                                    </div>
                                                </div>

                                                @if (isset($page->profile_image) && $page->profile_image !== '')
                                                    <img src="{{ asset('storage/images/page-img/' . $page->id . '/' . 'cover' . '/' . $page->profile_image) }}" class="img-fluid rounded" alt="Responsive image" loading="lazy" style="height: 100px;
                                                   width: -webkit-fill-available;  object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('images/user/Banners-03.png') }}" style="height: 100px;  width: -webkit-fill-available; object-fit: cover;" class="img-fluid rounded" alt="Responsive image" loading="lazy">
                                                @endif
                                            </a>
                                            <div class="mt-3">
                                                <button onclick="UnLikePageIndex({{ $page->id }}, {{ $user->id }})" class="btn btn-primary d-block w-100 d-flex align-items-center justify-content-center UnlikePage{{ $page->id }} d-none" style="justify-content: center;"><span class="material-symbols-outlined me-2 md-18">thumb_up</span> Liked </button>
                                                <button onclick="UnLikePageIndex({{ $page->id }}, {{ $user->id }})" class="btn btn-primary d-block w-100 d-flex align-items-center justify-content-center cancelRequestPage{{ $page->id }} d-none" style="justify-content: center;"><span class="material-symbols-outlined me-2 md-18">thumb_up</span>Cancel Request </button>
                                                <button onclick="likePageForm({{ $page->id }}, {{ $user->id }})" class="btn btn-primary d-block w-100 d-flex align-items-center justify-content-center likePage{{ $page->id }}" style="justify-content: center;"><span class="material-symbols-outlined me-2 md-18">thumb_up</span> Like </button>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if ($data['groups'] && count($data['groups']) > 0)
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Suggested Groups</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="suggested-page-story m-0 p-0 list-inline">
                                @foreach ($data['groups'] as $group)
                                    @if (isset($group))
                                        <li class="mb-3">
                                            <a href="{{ route('groupdetail', $group->id) }}">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="stories-data ms-3">
                                                        <h5 style="color: var(--bs-primary)">{{ $group->group_name }}</h5>
                                                    </div>
                                                </div>
                                                @if (isset($group->cover_image) && $group->cover_image !== '')
                                                    <img src="{{ asset('storage/images/group-img/' . $group->id . '/' . 'cover' . '/' . $group->cover_image) }}"  style="height: 100px;  width: -webkit-fill-available; object-fit: cover;"  class="img-fluid rounded" alt="group-cover-image" loading="lazy">
                                                @else
                                                    <img src="{{ asset('images/group-img/Banners-1488.png') }}"  style="height: 100px;  width: -webkit-fill-available; object-fit: cover;"  class="img-fluid rounded" alt="Responsive image" loading="lazy">
                                                @endif
                                            </a>
                                            <div class="mt-3">
                                                @if($group->privateGroupRequest->pluck('user_id')->contains(auth()->user()->id))
                                                    <button class="btn btn-primary w-100 cancelGroupRequest_{{ $group->id }}_{{ $user->id }}" onclick="leaveGroupForm({{ $group->id }}, {{ $user->id }})">Cancel Request</button>
                                                    <button class="btn btn-primary d-none w-100 joinGroup_{{ $group->id }}_{{ $user->id }}" onclick="joinGroupForm({{ $group->id }}, {{ $user->id }})">Join Group </button>
                                                @else
                                                    <button class="btn btn-primary d-block w-100 d-none cancelGroupRequest_{{ $group->id }}_{{ $user->id }}" onclick="leaveGroupForm({{ $group->id }}, {{ $user->id }})">Cancel Request</button>
                                                    <button class="btn btn-primary d-block w-100 d-none leaveGroup_{{ $group->id }}_{{ $user->id }}" onclick="leaveGroupForm({{ $group->id }}, {{ $user->id }})">Leave Group </button>
                                                    <button class="btn btn-primary d-block w-100 joinGroup_{{ $group->id }}_{{ $user->id }}" onclick="joinGroupForm({{ $group->id }}, {{ $user->id }})">Join Group </button>
                                                @endif
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div> --}}

            <div class="modal fade" id="post-modal" tabindex="-1" aria-labelledby="post-modalLabel" aria-hidden="true" style="margin-top:5rem">
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
                            <form method="" id="profileTimelineFeed" action="" class="post-text w-100 my-3" enctype="multipart/form-data">
                                @csrf

                                <div class="d-flex">
                                    <div class="user-img">
                                        @if (isset($data['user']->avatar_location) && $data['user']->avatar_location !== '')
                                            <img src="{{ asset('storage/images/user/userProfileandCovers/' . $user->id . '/' . $data['user']->avatar_location) }}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                        @else
                                            <img src="{{ asset('images/user/Users_100x100.png') }}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                        @endif
                                    </div>
                                    <div class="flex-input">
                                        <input type="text" name="postData" class="form-control rounded" id="postText" placeholder="Write something here..." style="border:none;">
                                    </div>
                                </div>
                                <input type="hidden" class="form-control rounded" value="{{ $user->id }}" name="userId" style="border:none;">
                                <input type="hidden" class="form-control rounded" value="homePage" name="pageType">
                                <hr>
                                <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                                    <li>
                                        <input type="file" multiple name="profileImage[]" id="profileImagePost" class="form-control fileInputGetOldValues" accept="image/*,video/mp4,video/x-m4v,video/*" placeholder="Profile Image" style="border:none;" onclick="addMoreFiles()" onchange="previewImages()">
                                        <div id="preview" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 8px; overflow-y: auto; max-height: 300px;min-width: 500px;"></div>
                                    </li>

                                </ul>
                                <button type="submit" id="ProfilePostCreateButton" class="btn btn-primary d-block w-100 mt-3">Post</button>
                            </form>
                        </div> --}}
                        @include('partials/_create_post')
                    </div>
                </div>
            </div>
            <div class="modal fade" id="story-modal" tabindex="-1" style="margin-top:5rem;" aria-labelledby="story-modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-groupCreatePost">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="post-modalLabel">Create Story</h5>
                            <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                <span class="material-symbols-outlined">close</span>
                            </a>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex align-items-center">
                                <div class="user-img">
                                    @if (isset($data['user']->avatar_location) && $data['user']->avatar_location !== '')
                                        <img src="{{ asset('storage/images/user/userProfileandCovers/' . $user->id . '/' . $data['user']->avatar_location) }}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                    @else
                                        <img src="{{ asset('images/user/Users_100x100.png') }}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                    @endif
                                </div>
                                <form method="POST" action="{{ route('user.createPost') }}" class="post-text ms-3 w-100" action="javascript:void();" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" class="form-control rounded" value={{ $user->id }} name="userId" style="border:none;">
                                    <input type="hidden" class="form-control rounded" value="story" name="type" style="border:none;">
                                    <input type="hidden" class="form-control rounded" value="homePage" name="pageType">
                                    <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                                        <li class="col-md-6 mb-3">
                                            <input type="file" required name="profileImage" id="profileImageStory" class="form-control" accept="image/*,video/mp4,video/x-m4v,video/*" placeholder="Profile Image" onchange="previewStoryImages()" style="border:none;">
                                            <div id="previewStoryImgDisplay" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 8px; overflow-y:unset; max-height: 300px;min-width: 500px;"></div>

                                        </li>
                                    </ul>
                                    <div class="container-fluid"><button type="submit" class="btn btn-primary d-block w-75 mt-3">Create a story</button></div>
                                </form>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-sm-12 text-center">
                <img src="{{asset('storage/images/page-img/page-load-loader.gif')}}" alt="loader" style="height: 100px;" loading="lazy">
            </div> --}}
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @push('scripts')
        <script src="{{ asset('js/feedModal.js?version=0.36') }}"></script>
    @endpush
    <!-- start stories sliders -->
    <!-- lib styles -->
    <link rel="stylesheet" href="{{ asset('zuck/dist/zuck.css?version=0.05') }}" />
    <!-- lib skins -->
    <link rel="stylesheet" href="{{ asset('zuck/dist/skins/snapgram.css?version=0.01') }}" />
    <script src="{{ asset('zuck/dist/zuck.js?version=0.03') }}"></script>
    <script src="{{ asset('zuck/demo/script.js') }}"></script>
@if($data['paginateUrl'] == true)
    <!--end storeies -->
    <script>
        var loadingData = false;
        var nextPageUrlCount = 0;
        var pageNumber = 2;

        function loadMoreData() {
            if (loadingData) {
                return;
            }

            loadingData = true;

            var nextPageUrl = `{!! $data['feeds']->links() !!}`;
            if (nextPageUrl != '' && nextPageUrl != null && nextPageUrl != undefined) {
                var links = nextPageUrl.match(/href="([^"]+)"/g);
                var nextPageUrl = "{!! $data['feeds']->nextPageUrl() !!}";
                var nextPageUrlTCounts = links.length - 1;
                if (nextPageUrlTCounts === nextPageUrlCount) {
                    var feedLoader = $(".feed__loder");
                    if (!feedLoader.hasClass("d-none")) {
                        feedLoader.addClass("d-none");
                    }
                    return;
                } else if (nextPageUrlCount == 0) {
                    baseUrl = window.location.href;
                    var nextPageUrl = baseUrl + "{!! $data['feeds']->nextPageUrl() !!}";
                } else {
                    var link = nextPageUrl;
                    var regex = /page=(\d+)/;
                    var match = regex.exec(link);
                    pageNumber = pageNumber + 1;
                    baseUrl = window.location.href;
                    var nextPageUrl = link.replace(regex, 'page=' + pageNumber);
                    var nextPageUrl = baseUrl + nextPageUrl;

                }
                var websiteEnvironment = $("#websiteEnvironment").text();
                if (websiteEnvironment != 'local') {
                    nextPageUrl = nextPageUrl.replace(/^http:/i, 'https:');
                }
                $.ajax({
                    url: nextPageUrl,
                    type: "GET",
                    dataType: "html",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(data) {
                        var extractedData = $(data).find("#loadeMoreFeed").html();
                        $("#loadeMoreFeed").append(extractedData);
                        loadingData = false;
                        nextPageUrlCount = nextPageUrlCount + 1;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        loadingData = false;
                    }
                });
            } else {
                var feedLoader = $(".feed__loder");
                if (!feedLoader.hasClass("d-none")) {
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
@endif
<script>
var currentSkin = getCurrentSkin();
      var stories = window.Zuck(document.querySelector('#stories'), {
        backNative: true,
        previousTap: true,
        skin: currentSkin['name'],
        autoFullScreen: currentSkin['params']['autoFullScreen'],
        avatars: currentSkin['params']['avatars'],
        paginationArrows: true,
        list: currentSkin['params']['list'],
        cubeEffect: currentSkin['params']['cubeEffect'],
        localStorage: true,
        stories: [
            <?php
            $i=1;
            $p=0;

            foreach ($data['storiesrev'] as $storiesmain){?>
            {
                id: "parent{{ $i }}",
                @if( isset($data['storiesrev'][$p]->stories[$p]->attachments[$p]->attachment_type) && $data['storiesrev'][$p]->stories[$p]->attachments[$p]->attachment_type =='image')
                <?php
                if(isset($storiesmain->avatar_location) && $storiesmain->avatar_location !== ''){ ?>
                photo:"{{asset('storage/images/feed-img/'.$storiesmain->id.'/'.@$data['storiesrev'][$p]->stories[$p]->attachments[$p]->attachment)}}",
                <?php }else{ ?>
                photo:"{{asset('storage/images/feed-img/'.$storiesmain->id.'/'.@$data['storiesrev'][$p]->stories[$p]->attachments[$p]->attachment)}}",
                <?php } ?>
                @else

                <?php
                if(isset($storiesmain->avatar_location) && $storiesmain->avatar_location !== ''  ){ ?>
                photo:"{{ asset('storage/images/user/userProfileandCovers/'. $storiesmain->id.'/'.$storiesmain->avatar_location) }}",
                <?php }else{ ?>
                photo:"{{asset('images/user/Users_120x120.png')}}",
                <?php } ?>

                @endif
                linkprofile : "profile/{{ $storiesmain->username; }}",
                name: "{{ $storiesmain->first_name.' '.$storiesmain->last_name; }}",
                time: timestamp(),
                items: [
                    <?php $i2=0;
                        foreach ($storiesmain->stories as $substories){
                        foreach($substories->attachments as $storyDataattach   ){
                    ?>
                {
                id: "child{{ $i2 }}",
                @if($storyDataattach->attachment_type =='image')
                type: 'photo',
                @else
                type: 'video',
                @endif
                length: 0,
                src: "{{asset('storage/images/feed-img/'.$storiesmain->id.'/'.@$storyDataattach->attachment)}}",
                preview:
                "{{asset('storage/images/feed-img/'.$storiesmain->id.'/'.@$storyDataattach->attachment)}}",
                link: ' ',
					 linkText: "{{\Carbon\Carbon::createFromTimeStamp(strtotime(@$storyDataattach->created_at))->diffForHumans()}}",


                },

                <?php $i2++;
                }
                } ?>

                ]
            },<?php

            $i++;
            $p++;

        }
         ?>
]
      });
//end stories sliders
    </script>

</x-app-layout>
