@php
    use App\Models\GroupMembers;
    use App\Models\PageMembers;
    $user = auth()->user();
    if($user)
        $data['myGroups'] = GroupMembers::whereHas('group')->where(['status' => 'Y', 'user_id' => $user->id])->get();
        $data['myPages'] = PageMembers::whereHas('page')->where(['status' => 'Y', 'user_id' => $user->id])->get();
        $myGroup = GroupMembers::whereHas('group', function ($query) {
        $query->where('admin_user_id', '=', auth()->user()->id);
        })->where(['status' => 'Y', 'user_id' => $user->id])->count();
        $joinedGroup = GroupMembers::whereHas('group', function ($query) {
        $query->where('admin_user_id', '!=', auth()->user()->id);
        })->where(['status' => 'Y', 'user_id' => $user->id])->count();
        $myPage = PageMembers::whereHas('page', function ($query) {
        $query->where('admin_user_id', '=', auth()->user()->id);
        })->where(['status' => 'Y', 'user_id' => $user->id])->count();
        $likedPage = PageMembers::whereHas('page', function ($query) {
        $query->where('admin_user_id', '!=', auth()->user()->id);
        })->where(['status' => 'Y', 'user_id' => $user->id])->count();
@endphp

@if($user)
<!-- Sidebar Menu Start -->
<ul class="navbar-nav iq-main-menu" id="sidebar-menu">
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Social</span>
            <span class="mini-icon" data-bs-toggle="tooltip" title="Social" data-bs-placement="right">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('home'))}}" aria-current="page"
            href="{{route('home')}}">
            <i class="icon material-symbols-outlined">
                newspaper
            </i>
            <span class="item-name">Newsfeed</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#profile" role="button" aria-expanded="false"
            aria-controls="profile">
            <i class="icon material-symbols-outlined">
                person
            </i>
            <span class="item-name">Profiles</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a> --}}
        {{-- <ul class="sub-nav collapse" id="profile" data-bs-parent="#sidebar-menu"> --}}
            @if(isset($user->username) && $user->username!=='')
                <li class="nav-item">
                    <a class="nav-link {{activeRoute(route('user-profile',  ['username' => $user->username]))}}" href="{{route('user-profile',  ['username' => $user->username])}}">
                        <i class="icon material-symbols-outlined filled" style="font-size:25px">
                            person
                        </i>
                        <i class="sidenav-mini-icon"> P </i>
                        <span class="item-name"> Profile </span>
                    </a>
                </li>
            @endif
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute(route('profile.profile1'))}}"
                    href="{{route('profile.profile1')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> P </i>
                    <span class="item-name">Profile 1 </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('profile.profile2'))}}"
                    href="{{route('profile.profile2')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> P </i>
                    <span class="item-name">Profile 2 </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('profile.profile3'))}}"
                    href="{{route('profile.profile3')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> P </i>
                    <span class="item-name">Profile 3 </span>
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute(route('proimg'))}}"
                    href="{{route('proimg')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> PI </i>
                    <span class="item-name">Profile Image</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute(route('provideos'))}}"
                    href="{{route('provideos')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> PV </i>
                    <span class="item-name">Profile Video</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute(route('profilevent'))}}"
                    href="{{route('profilevent')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> PE </i>
                    <span class="item-name">Profile Events</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('profilebadges'))}}"
                    href="{{route('profilebadges')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> PB </i>
                    <span class="item-name">Profile Badges</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute(route('profileforum'))}}"
                    href="{{route('profileforum')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> PF </i>
                    <span class="item-name">Profile Forum</span>
                </a>
            </li> --}}
        {{-- </ul> --}}
    {{-- </li> --}}
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#friend-list" role="button" aria-expanded="false"
            aria-controls="sidebar-special">
            <i class="icon material-symbols-outlined">
                people
            </i>
            <span class="item-name">Friend</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="friend-list" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('friendlist'))}}"
                    href="{{route('friendlist')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> FL </i>
                    <span class="item-name"> Friend List</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute(route('friendprofile'))}}"
                    href="{{route('friendprofile')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> FP </i>
                    <span class="item-name">Friend Profile</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('friendrequest'))}}" aria-current="page"
                    href="{{route('friendrequest')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> FR </i>
                    <span class="item-name">Friend Requests</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item" >
        <a class="nav-link" data-bs-toggle="collapse" href="#groups-list" role="button" aria-expanded="false"
            aria-controls="sidebar-special" >
            <i class="icon material-symbols-outlined">
                groups
            </i>
            <span class="item-name">Groups</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="groups-list" data-bs-parent="#sidebar-menu">
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute(route('group-1'))}}" aria-current="page"
                    href="{{route('group-1')}}">
                    <i class="icon material-symbols-outlined">
                        groups
                    </i>
                    <i class="sidenav-mini-icon"> AG </i>
                    <span class="item-name">All Groups</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('group.create'))}}" aria-current="page"
                    href="{{route('group.create')}}">
                    <i class="icon material-symbols-outlined">
                        add_circle
                    </i>
                    <i class="sidenav-mini-icon"> CG </i>
                    <span class="item-name">Create a Group</span>
                </a>
            </li>
            @if($myGroup > 0)
                <div id="MyGroupsNav">
                    <li class="nav-item" >
                            <a class="nav-link" data-bs-toggle="collapse" href="#my-groups-list" role="button" aria-expanded="false"
                            aria-controls="sidebar-special" >
                            <i class="icon material-symbols-outlined">
                                groups
                            </i>
                            <span class="item-name">My Groups</span>
                            <i class="right-icon material-symbols-outlined">chevron_right</i>
                        </a>
                        @foreach($data['myGroups'] as $myGroup)
                            @if(isset($myGroup) && isset($myGroup['group']))
                                @if(isset($myGroup['group']) && $myGroup['group']->admin_user_id != auth()->user()->id)
                                    @continue
                                @else
                                    <ul class="sub-nav collapse" id="my-groups-list">
                                        <a class="nav-link {{activeRoute(route('groupdetail', $myGroup['group']->id))}}"
                                            href="{{route('groupdetail', $myGroup['group']->id)}}">
                                            @if($myGroup['group']->cover_image !== null && $myGroup['group']->cover_image !== '')
                                                <img class="rounded groupandpagefeatureimage" src="{{asset('storage/images/group-img/'.$myGroup->group_id.'/'. 'cover'. '/' .$myGroup['group']->cover_image)}}" alt="" loading="lazy">
                                            @else
                                                <img class="rounded groupandpagefeatureimage" src="{{asset('images/user/groupProfile.png')}}" alt="" loading="lazy">
                                            @endif
                                            <i class="sidenav-mini-icon"> MG </i>
                                            <span class="item-name"> {{$myGroup['group']->group_name}}</span>
                                        </a>
                                    </ul>
                                @endif
                            @endif
                        @endforeach
                    </li>
                </div>
            @endif
            @if($joinedGroup > 0)
                <div id="JoinedGroupsNav">
                    <li class="nav-item" >
                            <a class="nav-link" data-bs-toggle="collapse" href="#join-groups-list" role="button" aria-expanded="false"
                            aria-controls="sidebar-special" >
                            <i class="icon material-symbols-outlined">
                                groups
                            </i>
                            <span class="item-name">Joined Groups</span>
                            <i class="right-icon material-symbols-outlined">chevron_right</i>
                        </a>
                        @foreach($data['myGroups'] as $myGroup)
                            @if(isset($myGroup) && isset($myGroup['group']))
                                @if(isset($myGroup['group']) && $myGroup['group']->admin_user_id == auth()->user()->id)
                                    @continue
                                @else
                                    <ul class="sub-nav collapse" id="join-groups-list">
                                        <a class="nav-link {{activeRoute(route('groupdetail', $myGroup['group']->id))}}"
                                            href="{{route('groupdetail', $myGroup['group']->id)}}">
                                            @if($myGroup['group']->cover_image !== null && $myGroup['group']->cover_image !== '')
                                                <img class="rounded groupandpagefeatureimage" src="{{asset('storage/images/group-img/'.$myGroup->group_id.'/'. 'cover'. '/' .$myGroup['group']->cover_image)}}" alt="" loading="lazy">
                                            @else
                                                <img class="rounded groupandpagefeatureimage" src="{{asset('images/user/groupProfile.png')}}" alt="" loading="lazy">
                                            @endif
                                            <i class="sidenav-mini-icon"> MG </i>
                                            <span class="item-name"> {{$myGroup['group']->group_name}}</span>
                                        </a>
                                    </ul>
                                @endif
                            @endif
                        @endforeach
                    </li>
                </div>
            @endif
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#pages-list" role="button" aria-expanded="false"
            aria-controls="sidebar-special" >
            <i class="icon material-symbols-outlined">
                flag
            </i>
            <span class="item-name">Pages</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="pages-list" data-bs-parent="#sidebar-menu">
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute(route('pages'))}}" aria-current="page"
                    href="{{route('pages')}}">
                    <i class="icon material-symbols-outlined">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> AP </i>
                    <span class="item-name">All Pages</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('page.create'))}}" aria-current="page"
                    href="{{route('page.create')}}">
                    <i class="icon material-symbols-outlined">
                        add_circle
                    </i>
                    <i class="sidenav-mini-icon"> CP </i>
                    <span class="item-name">Create a Page</span>
                </a>
            </li>
            @if($myPage > 0)
                <div id="MyNavPages">
                    <li class="nav-item" >
                            <a class="nav-link" data-bs-toggle="collapse" href="#my-pages-list" role="button" aria-expanded="false"
                            aria-controls="sidebar-special" >
                            <i class="icon material-symbols-outlined">
                                flag_circle
                            </i>
                            <span class="item-name">My Pages</span>
                            <i class="right-icon material-symbols-outlined">chevron_right</i>
                        </a>
                        @foreach($data['myPages'] as $myPage)
                            @if(isset($myPage) && isset($myPage['page']))
                                @if(isset($myPage['page']) && $myPage['page']->admin_user_id != auth()->user()->id)
                                    @continue
                                @else
                                    <ul class="sub-nav collapse" id="my-pages-list">
                                        <a class="nav-link {{activeRoute(route('pagedetail', $myPage['page']->id))}}"
                                            href="{{route('pagedetail', $myPage['page']->id)}}">
                                            {{-- <i class="icon material-symbols-outlined filled">
                                                fiber_manual_record
                                            </i> --}}
                                            @if($myPage['page']->profile_image !== null && $myPage['page']->profile_image !== '')
                                                <img class="rounded groupandpagefeatureimage" src="{{asset('storage/images/page-img/'.$myPage['page']->id.'/'.$myPage['page']->profile_image)}}" alt="" loading="lazy">
                                            @else
                                                <img class="rounded groupandpagefeatureimage" src="{{asset('images/user/pageProfile.png')}}" alt="" loading="lazy">
                                            @endif
                                            <i class="sidenav-mini-icon"> MG </i>
                                            <span class="item-name"> {{$myPage['page']->page_name}}</span>
                                        </a>
                                    </ul>
                                @endif
                            @endif
                        @endforeach
                    </li>
                </div>
            @endif
            @if($likedPage > 0)
                <div id="LikedNavPages">
                    <li class="nav-item" >
                            <a class="nav-link" data-bs-toggle="collapse" href="#liked-pages-list" role="button" aria-expanded="false" aria-controls="sidebar-special" >
                                <i class="icon material-symbols-outlined">
                                    thumb_up
                                </i>
                                <span class="item-name">Liked Pages</span>
                                <i class="right-icon material-symbols-outlined">chevron_right</i>
                            </a>
                        @foreach($data['myPages'] as $myPage)
                            @if(isset($myPage) && isset($myPage['page']))
                                @if(isset($myPage['page']) && $myPage['page']->admin_user_id == auth()->user()->id)
                                    @continue
                                @else
                                    <ul class="sub-nav collapse" id="liked-pages-list">
                                        <a class="nav-link {{activeRoute(route('pagedetail', $myPage['page']->id))}}"
                                            href="{{route('pagedetail', $myPage['page']->id)}}">
                                            {{-- <i class="icon material-symbols-outlined filled">
                                                fiber_manual_record
                                            </i> --}}
                                            @if($myPage['page']->profile_image !== null && $myPage['page']->profile_image !== '')
                                                <img class="rounded groupandpagefeatureimage" src="{{asset('storage/images/page-img/'.$myPage['page']->id.'/'.$myPage['page']->profile_image)}}" alt="" loading="lazy">
                                            @else
                                                <img class="rounded groupandpagefeatureimage" src="{{asset('images/user/pageProfile.png')}}" alt="" loading="lazy">
                                            @endif
                                            <i class="sidenav-mini-icon"> MG </i>
                                            <span class="item-name"> {{$myPage['page']->page_name}}</span>
                                        </a>
                                    </ul>
                                @endif
                            @endif
                        @endforeach
                    </li>
                </div>
            @endif
        </ul>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link {{activeRoute(route('notification'))}}" aria-current="page"
            href="{{route('notification')}}">
            <i class="icon material-symbols-outlined">
                notifications
            </i>
            <span class="item-name">Notification</span>
        </a>
    </li> --}}
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Featured</span>
            <span class="mini-icon" data-bs-toggle="tooltip" title="Social" data-bs-placement="right">-</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link {{activeRoute(route('file'))}}" aria-current="page"
            href="{{route('file')}}">
            <i class="icon material-symbols-outlined">
                insert_drive_file
            </i>
            <span class="item-name">Files</span>
        </a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link {{activeRoute(route('chat.index'))}}" aria-current="page"
            href="{{route('comingsoon')}}"> --}}
            {{-- href="{{route('chat.index')}}"> --}}
            {{-- href="{{route('chatify')}}"> --}}
            {{-- <i class="icon material-symbols-outlined">
                message
            </i>
            <span class="item-name">Chat</span>
        </a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link {{activeRoute(route('todo'))}}" aria-current="page"
            href="{{route('todo')}}">
            <i class="icon material-symbols-outlined">
                task_alt
            </i>
            <span class="item-name">Todo</span>
        </a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('calender'))}}" aria-current="page"
            href="{{route('calender')}}">
            <i class="icon material-symbols-outlined">
                calendar_month
            </i>
            <span class="item-name">Calendar</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('birthday'))}}" aria-current="page"
            href="{{route('birthday')}}">
            <i class="icon material-symbols-outlined">
                cake
            </i>
            <span class="item-name">Birthday</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link {{activeRoute(route('my-pets'))}}" aria-current="page"
            href="{{route('my-pets')}}">
            <i class="icon material-symbols-outlined">
                pets
            </i>
            <span class="item-name">My Pets</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('pet-of-the-month'))}}" aria-current="page"
            href="{{route('pet-of-the-month')}}">
            <i class="icon material-symbols-outlined">
                pets
            </i>
            <span class="item-name">Pet of the month</span>
        </a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#courses" role="button" aria-expanded="false"
            aria-controls="sidebar-special">
            <i class="icon material-symbols-outlined">
                library_books
            </i>
            <span class="item-name">Courses</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="courses" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('courses.categories'))}}"
                    href="{{route('courses.categories')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> CC </i>
                    <span class="item-name">Courses Categories</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('jobs'))}}" aria-current="page"
            href="{{route('jobs')}}">
            <i class="icon material-symbols-outlined">
                person
            </i>
            <span class="item-name">Jobs</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link {{activeRoute(route('weather'))}}" aria-current="page"
            href="{{route('weather')}}">
            <i class="icon material-symbols-outlined">
                thunderstorm
            </i>
            <span class="item-name">Weather</span>
        </a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link {{activeRoute(route('music'))}}" aria-current="page"
            href="{{route('music')}}">
            <i class="icon material-symbols-outlined">
                play_circle
            </i>
            <span class="item-name">Music</span>
        </a>
    </li> --}}
    {{-- <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Other Pages</span>
            <span class="mini-icon" data-bs-toggle="tooltip" title="otherpages" data-bs-placement="right">-</span>
        </a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#market" role="button" aria-expanded="false"
            aria-controls="sidebar-special">
            <i class="icon material-symbols-outlined">
                poll
            </i>
            <span class="item-name">Market Place</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="market" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('market.market1'))}}"
                    href="{{route('market.market1')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> M </i>
                    <span class="item-name">Market 1</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('market.market2'))}}"
                    href="{{route('market.market2')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> M </i>
                    <span class="item-name">Market 2</span>
                </a>
            </li>
        </ul>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#blog" role="button" aria-expanded="false"
            aria-controls="sidebar-special">
            <i class="icon material-symbols-outlined">
                web
            </i>
            <span class="item-name">Blog</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="blog" data-bs-parent="#sidebar-menu">
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute(route('blog.bloggrid'))}}"
                    href="{{route('blog.bloggrid')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> BG </i>
                    <span class="item-name">Blog Grid</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link {{activeRoute('blog/bloglist')}}"
                    href="{{route('blog.bloglist')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> BL </i>
                    <span class="item-name">Blog List</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute('blog/blogdetail')}}"
                    href="{{route('blog.blogdetail')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> BD </i>
                    <span class="item-name">Blog Detail</span>
                </a>
            </li> --}}
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#news" role="button" aria-expanded="false"
            aria-controls="sidebar-special">
            <i class="icon material-symbols-outlined">
                article
            </i>
            <span class="item-name">News</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="news" data-bs-parent="#sidebar-menu">
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute(route('blog.bloggrid'))}}"
                    href="{{route('blog.bloggrid')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> BG </i>
                    <span class="item-name">Blog Grid</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link {{activeRoute('news/newslist')}}"
                    href="{{route('news.newslist')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> BL </i>
                    <span class="item-name">News List</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link {{activeRoute('blog/blogdetail')}}"
                    href="{{route('blog.blogdetail')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> BD </i>
                    <span class="item-name">Blog Detail</span>
                </a>
            </li> --}}
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('signature'))}}" aria-current="page"
            href="{{route('signature')}}">
            <i class="icon material-symbols-outlined">
                record_voice_over
            </i>
            <span class="item-name">Signature</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('stock'))}}"
            href="{{route('stock')}}">
            <i class="icon material-symbols-outlined">
                storefront
            </i>
            <i class="sidenav-mini-icon"> CG </i>
            <span class="item-name">Old Stock</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('doctors'))}}"
            href="{{route('doctors')}}">
            <i class="icon material-symbols-outlined">
                storefront
            </i>
            <i class="sidenav-mini-icon"> CG </i>
            <span class="item-name">Doctors Appointment</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link {{activeRoute(route('speakers'))}}" aria-current="page"
            href="{{route('speakers')}}">
            <i class="icon material-symbols-outlined">
                record_voice_over

            </i>
            <span class="item-name">Speakers</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('webinars'))}}" aria-current="page"
            href="{{route('webinars')}}">
            <i class="icon material-symbols-outlined">
                live_tv
            </i>
            <span class="item-name">Webinars</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('myWebinars'))}}" aria-current="page"
            href="{{route('myWebinars')}}">
            <i class="icon material-symbols-outlined">
                subscriptions
            </i>
            <span class="item-name">My Webinars</span>
        </a>
    </li> --}}

    {{-- <li class="nav-item">
        <a class="nav-link {{activeRoute(route('team'))}}" aria-current="page"
            href="{{route('team')}}">
           <i class="icon material-symbols-outlined filled" style="font-size:25px">
             person
             </i>
            <span class="item-name">Team</span>
        </a>
    </li> --}}

    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Other Links</span>
            <span class="mini-icon" data-bs-toggle="tooltip" title="Social" data-bs-placement="right">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('footer.aboutus'))}}" aria-current="page" href="{{route('footer.aboutus')}}">
            <i class="icon material-symbols-outlined">
                person_search
            </i>
            <span class="item-name">About Us</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('footer.ourvision'))}}" aria-current="page" href="{{route('footer.ourvision')}}">
            <i class="icon material-symbols-outlined">
                person_search
            </i>
            <span class="item-name">Our Vision</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('footer.privacypolicy'))}}" aria-current="page" href="{{route('footer.privacypolicy')}}">
            <i class="icon material-symbols-outlined">
                security
            </i>
            <span class="item-name">Privacy Policy</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('footer.termsofservice'))}}" aria-current="page" href="{{route('footer.termsofservice')}}">
            <i class="icon material-symbols-outlined">
                prescriptions
            </i>
            <span class="item-name">Terms of Use</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('pages.faq'))}}" aria-current="page" href="{{route('pages.faq')}}">
            <i class="icon material-symbols-outlined">
                help
            </i>
            <span class="item-name">FAQ's</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('footer.customersupport'))}}" aria-current="page" href="{{route('footer.customersupport')}}">
            <i class="icon material-symbols-outlined">
                support_agent
            </i>
            <span class="item-name">Customer Support</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#store" role="button" aria-expanded="false"
            aria-controls="sidebar-special">
            <i class="icon material-symbols-outlined">
                storefront
            </i>
            <span class="item-name">Store</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="store" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('store.grid'))}}"
                    href="{{route('store.grid')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> CG </i>
                    <span class="item-name">Category Grid</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('store/list')}}"
                    href="{{route('store.list')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> CL </i>
                    <span class="item-name">Category List</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('store.detail'))}}"
                    href="{{route('store.detail')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> SD </i>
                    <span class="item-name">Store Detail</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('store.checkout'))}}"
                    href="{{route('store.checkout')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> C </i>
                    <span class="item-name">Checkout</span>
                </a>
            </li>
        </ul>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#mail" role="button" aria-expanded="false"
            aria-controls="sidebar-special">
            <i class="icon material-symbols-outlined">
                mail_outline
            </i>
            <span class="item-name">Mail</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="mail" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute('mailbox/email')}}" href="{{route('mailbox.email')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> I </i>
                    <span class="item-name">Inbox</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('mailbox.emailcompose'))}}"
                    href="{{route('mailbox.emailcompose')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> E </i>
                    <span class="item-name">Email Compose</span>
                </a>
            </li>
        </ul>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-special" role="button" aria-expanded="false"
            aria-controls="sidebar-special">
            <i class="icon material-symbols-outlined">
                assignment
            </i>
            <span class="item-name">Special Pages</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="sidebar-special" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('pages.timeline'))}}"
                    href="{{route('pages.timeline')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> T </i>
                    <span class="item-name">Timeline</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('pages.invoice'))}}"
                    href="{{route('pages.invoice')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> I </i>
                    <span class="item-name">Invoice</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('pages.pricing'))}}"
                    href="{{route('pages.pricing')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> P </i>
                    <span class="item-name">Pricing 1</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('pages/pricingone')}}"
                    href="{{route('pages.pricingone')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> P </i>
                    <span class="item-name">Pricing 2</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('pages.faq'))}}"
                    href="{{route('pages.faq')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> F </i>
                    <span class="item-name">Faq</span>
                </a>
            </li>
        </ul>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-auth" role="button" aria-expanded="false"
            aria-controls="sidebar-auth">
            <i class="icon material-symbols-outlined">
                library_books
            </i>
            <span class="item-name">Auth</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="sidebar-auth" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('pages.signin'))}}"
                    href="{{route('pages.signin')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <span class="item-name">Login</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('pages/signup')}}"
                    href="{{route('pages.signup')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <span class="item-name">Register</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('pages/pagerecover')}}"
                    href="{{route('pages.pagerecover')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <span class="item-name">Recover Password</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('pages/pageconfirmail')}}"
                    href="{{route('pages.pageconfirmail')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <span class="item-name">Confirm Mail</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('pages/lockscreen')}}"
                    href="{{route('pages.lockscreen')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <span class="item-name">Lock Screen</span>
                </a>
            </li>
        </ul>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#utilities-error" role="button" aria-expanded="false"
            aria-controls="utilities-error">
            <i class="icon material-symbols-outlined">
                turned_in_not
            </i>
            <span class="item-name">Utilities</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="utilities-error" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('pages.error'))}}"
                    href="{{route('pages.error')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <span class="item-name">Error 404</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('pages/error500')}}"
                    href="{{route('pages.error500')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <span class="item-name">Error 500</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('pages/maintenance')}}"
                    href="{{route('pages.maintenance')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <span class="item-name">Maintence</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('pages.blankpage'))}}"
            href="{{route('pages.blankpage')}}">
            <i class="icon material-symbols-outlined">
                check_box_outline_blank
            </i>
            <span class="item-name">Blank Page</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute('pages/adminpage')}}" href="{{route('adminpage')}}">
            <i class="icon material-symbols-outlined">
                admin_panel_settings
            </i>
            <span class="item-name">Admin</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{activeRoute(route('pages.comingsoon'))}}"
            href="{{route('pages.comingsoon')}}">
            <i class="icon material-symbols-outlined">
                fiber_smart_record
            </i>
            <span class="item-name">Pages Comingsoon</span>
        </a>
    </li> --}}
    {{-- <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Elements</span>
            <span class="mini-icon" data-bs-toggle="tooltip" title="elements" data-bs-placement="right">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-kit" role="button" aria-expanded="false"
            aria-controls="ui-kit">
            <i class="icon material-symbols-outlined">
                adjust
            </i>
            <span class="item-name">Ui Elements</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="ui-kit" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uicolor'))}}"
                    href="{{route('ui.uicolor')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> U </i>
                    <span class="item-name">Ui Color</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uitypography'))}}"
                    href="{{route('ui.uitypography')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> T </i>
                    <span class="item-name">Typography</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('ui/uialert')}}"
                    href="{{route('ui.uialert')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> A </i>
                    <span class="item-name">Alerts</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uibadges'))}}"
                    href="{{route('ui.uibadges')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> B </i>
                    <span class="item-name">Badges</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uibreadcrumb'))}}"
                    href="{{route('ui.uibreadcrumb')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> B </i>
                    <span class="item-name">Breadcrumb</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uibutton'))}}"
                    href="{{route('ui.uibutton')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> B </i>
                    <span class="item-name">Buttons</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uicard'))}}"
                    href="{{route('ui.uicard')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> C </i>
                    <span class="item-name">Cards</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uicarousel'))}}"
                    href="{{route('ui.uicarousel')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> C </i>
                    <span class="item-name">Carousel</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uiemvideo'))}}"
                    href="{{route('ui.uiemvideo')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> V </i>
                    <span class="item-name">Video</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uigrid'))}}"
                    href="{{route('ui.uigrid')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> G </i>
                    <span class="item-name">Grid</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uiimages'))}}"
                    href="{{route('ui.uiimages')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> I </i>
                    <span class="item-name">Images</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uilistitems'))}}"
                    href="{{route('ui.uilistitems')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> L </i>
                    <span class="item-name">list Group</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uimodal'))}}"
                    href="{{route('ui.uimodal')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> M </i>
                    <span class="item-name">Modal</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uinotification'))}}"
                    href="{{route('ui.uinotification')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> N</i>
                    <span class="item-name">Notifications</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uipagination'))}}"
                    href="{{route('ui.uipagination')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> P</i>
                    <span class="item-name">Pagination</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uipopovers'))}}"
                    href="{{route('ui.uipopovers')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> P</i>
                    <span class="item-name">Popovers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uiprogressbars'))}}"
                    href="{{route('ui.uiprogressbars')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> P</i>
                    <span class="item-name">Progressbars</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uitabs'))}}"
                    href="{{route('ui.uitabs')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> T</i>
                    <span class="item-name">Tabs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.uitooltips'))}}"
                    href="{{route('ui.uitooltips')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> T</i>
                    <span class="item-name">Tooltips</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-wizard" role="button" aria-expanded="false"
            aria-controls="sidebar-wizard">
            <i class="icon material-symbols-outlined">
                text_snippet
            </i>
            <span class="item-name">Forms Wizard</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="sidebar-wizard" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.formwizard'))}}"
                    href="{{route('ui.formwizard')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> SW </i>
                    <span class="item-name">Simple Wizard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.formwizardvalidate'))}}"
                    href="{{route('ui.formwizardvalidate')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> VW </i>
                    <span class="item-name">Validate Wizard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.formwizardvertical'))}}"
                    href="{{route('ui.formwizardvertical')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> VW </i>
                    <span class="item-name">Vertical Wizard</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-table" role="button" aria-expanded="false"
            aria-controls="sidebar-table">
            <i class="icon material-symbols-outlined">
                table_chart
            </i>
            <span class="item-name">Table</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="sidebar-table" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.tablebasic'))}}"
                    href="{{route('ui.tablebasic')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> BT </i>
                    <span class="item-name">Basic Tables</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('ui/datatable')}}"
                    href="{{route('ui.datatable')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> D </i>
                    <span class="item-name">Data Table</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('ui/tableedit')}}"
                    href="{{route('ui.tableedit')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> E </i>
                    <span class="item-name">Editable Table</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-form" role="button" aria-expanded="false"
            aria-controls="sidebar-form">
            <i class="icon material-symbols-outlined">
                view_timeline
            </i>
            <span class="item-name">Form</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="sidebar-form" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link{{activeRoute(route('ui.formlayout'))}}"
                    href="{{route('ui.formlayout')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> FE </i>
                    <span class="item-name">Form Elements</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.formvalidation'))}}"
                    href="{{route('ui.formvalidation')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> FV</i>
                    <span class="item-name">Form Validation</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.formswitch'))}}"
                    href="{{route('ui.formswitch')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> FS </i>
                    <span class="item-name">Form Switch</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.formcheckbox'))}}"
                    href="{{route('ui.formcheckbox')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> FC</i>
                    <span class="item-name">Form Checkbox</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute('ui/formradio')}}"
                    href="{{route('ui.formradio')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> FR</i>
                    <span class="item-name">Form Radio</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item mb-4">
        <a class="nav-link" data-bs-toggle="collapse" href="#sidebar-icons" role="button" aria-expanded="false"
            aria-controls="sidebar-icons">
            <i class="icon material-symbols-outlined">
                error_outline
            </i>
            <span class="item-name">Icons</span>
            <i class="right-icon material-symbols-outlined">chevron_right</i>
        </a>
        <ul class="sub-nav collapse" id="sidebar-icons" data-bs-parent="#sidebar-menu">
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.iconfontawsome'))}}"
                    href="{{route('ui.iconfontawsome')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> F </i>
                    <span class="item-name">Font Awesome 5</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.iconlineawsome'))}}"
                    href="{{route('ui.iconlineawsome')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> L </i>
                    <span class="item-name">Line Awesome</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('ui.iconremixon'))}}"
                    href="{{route('ui.iconremixon')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> R </i>
                    <span class="item-name">Remixicon</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{activeRoute(route('iconmaterial'))}}"
                    href="{{route('iconmaterial')}}">
                    <i class="icon material-symbols-outlined filled">
                        fiber_manual_record
                    </i>
                    <i class="sidenav-mini-icon"> M </i>
                    <span class="item-name">Material</span>
                </a>
            </li>
        </ul>
    </li> --}}
</ul>
<!-- Sidebar Menu End -->
@endif
