@php
    $user = auth()->user();
    use App\Models\PageMembers;
    use App\Models\GroupsFeed;
@endphp


<x-app-layout>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            {{-- <img src="{{asset('storage/images/page-img/banner-04.png')}}" class="img-fluid w-100 rounded rounded" alt="header-bg"> --}}
            {{-- <img src="{{asset('images/page-img/group-banner.png')}}" class="img-fluid w-100 rounded rounded" alt="header-bg"> --}}
            <img src="{{asset('images/page-img/page-banner.png')}}" class="img-fluid w-100 rounded rounded" alt="header-bg">
                {{-- <div class="title-on-header">
                    <div class="data-block">
                        <h2>Pages</h2>
                    </div>
                </div> --}}
        </div>
    </div>
    <div id="content-page" class="content-page">  
        <div class="container">
            <div class="d-grid gap-3 d-grid-template-1fr-19">
                @foreach($data['pages'] as $page)
                    <div class="card mb-0">
                        <div class="top-bg-image">
                            @if(isset($page->cover_image) && $page->cover_image !== '')
                                <img src="{{asset('storage/images/page-img/'.$page->id.'/'.$page->cover_image)}}" class="img-fluid w-100" alt="group-bg">
                            @else
                                <img src="{{asset('images/page-img/profile-bg1.jpg')}}" class="img-fluid w-100" alt="group-bg">
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <div class="group-icon">
                                @if(isset($page->profile_image) && $page->profile_image !== '')
                                    <img src="{{asset('storage/images/page-img/'.$page->id.'/'.$page->profile_image)}}"  alt="profile-img" class="rounded-circle img-fluid avatar-120">
                                @else
                                    <img src="{{asset('images/page-img/gi-1.jpg')}}" alt="profile-img" class="rounded-circle img-fluid avatar-120">
                                @endif
                            </div>
                            <div class="group-info pt-3 pb-3">
                                <h4><a href="{{route('pagedetail', $page->id)}}">{{$page->page_name}}</a></h4>
                                <p>{{$page->short_description}}</p>
                            </div>
                            <div class="group-details d-inline-block pb-3">
                                <ul class="d-flex align-items-center justify-content-between list-inline m-0 p-0">
                                    <li class="pe-3 ps-3">
                                        {{-- @php
                                            $totalFeeds = count(GroupsFeed::where(['status' => 'Y', 'group_id' => $page->id])->orderBy('created_at', 'DESC')->get());
                                        @endphp --}}
                                        <p class="mb-0">Post</p>
                                        {{-- <h6>{{$totalFeeds}}</h6> --}}
                                        <h6>5</h6>
                                    </li>
                                    <li class="pe-3 ps-3">
                                        <p class="mb-0">Member</p>
                                        <h6>{{count($page['pageMembers'])}}</h6>
                                        {{-- <h6>3</h6> --}}
                                    </li>
                                    {{-- <li class="pe-3 ps-3">
                                        <p class="mb-0">Visit</p>
                                        <h6>{{$page->short_description}}</h6>
                                    </li> --}}
                                </ul>
                            </div>
                            <div class="group-member mb-3">
                                        {{-- images/user/userProfileandCovers/'. $data['user']->id.'/'.$data['user']->avatar_location --}}
                                <div class="iq-media-group">
                                    @if(isset($page['pageMembers'][0]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $page['pageMembers'][0]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$page['pageMembers'][0]['getUser']->id.'/'.$page['pageMembers'][0]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/05.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($page['pageMembers'][1]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $page['pageMembers'][1]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$page['pageMembers'][1]['getUser']->id.'/'.$page['pageMembers'][1]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/05.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($page['pageMembers'][2]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $page['pageMembers'][2]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$page['pageMembers'][2]['getUser']->id.'/'.$page['pageMembers'][2]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/06.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($page['pageMembers'][3]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $page['pageMembers'][3]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/'.$page['pageMembers'][3]['getUser']->id.'/'.$page['pageMembers'][3]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/07.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($page['pageMembers'][4]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $page['pageMembers'][4]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/'.$page['pageMembers'][4]['getUser']->id.'/'.$page['pageMembers'][4]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/08.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($page['pageMembers'][5]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $page['pageMembers'][5]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/'.$page['pageMembers'][5]['getUser']->id.'/'.$page['pageMembers'][5]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/09.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($page['pageMembers'][6]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $page['pageMembers'][6]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/'.$page['pageMembers'][6]['getUser']->id.'/'.$page['pageMembers'][6]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/10.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @php
                                $joinedGroups = PageMembers::where(['user_id' => $user->id, 'page_id' => $page->id])->get();
                            @endphp
                            @if (isset($joinedGroups[0]) && $joinedGroups[0] != null)
                                <a @disabled(true) class="btn btn-primary d-block w-100 join-group">Joined</a>
                            @else
                            <form method="POST" action="{{ route('join-group') }}">
                                @csrf
                                <input type="hidden" id="groupId" value={{$page->id}} name="groupId">
                                <input type="hidden" id="userId" value={{$user->id}} name="userId">
                                <button type="submit" class="btn btn-primary d-block w-100 join-group">Join</button>
                            </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
    