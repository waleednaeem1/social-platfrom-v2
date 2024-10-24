@php
    $user = auth()->user();
    use App\Models\GroupMembers;
    use App\Models\GroupsFeed;
@endphp


<x-app-layout>
    <div class="header-for-bg">
        <div class="background-header position-relative">
            {{-- <img src="{{asset('storage/images/page-img/banner-04.png')}}" class="img-fluid w-100 rounded rounded" alt="header-bg"> --}}
            <img src="{{asset('images/page-img/group-banner.png')}}" class="img-fluid w-100 rounded rounded" alt="header-bg">
                <div class="title-on-header">
                    <div class="data-block">
                        <h2>Groups</h2>
                    </div>
                </div>
        </div>
    </div>
    <div id="content-page" class="content-page">  
        <div class="container">
            <div class="d-grid gap-3 d-grid-template-1fr-19">
                @foreach($data['groups'] as $group)
                    <div class="card mb-0">
                        <div class="top-bg-image">
                            @if(isset($group->cover_image) && $group->cover_image !== '')
                                <img src="{{asset('storage/images/group-img/'.$group->id.'/'.$group->cover_image)}}" class="img-fluid w-100" alt="group-bg">
                            @else
                                <img src="{{asset('images/group-img/profile-bg1.jpg')}}" class="img-fluid w-100" alt="group-bg">
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <div class="group-icon">
                                @if(isset($group->profile_image) && $group->profile_image !== '')
                                    <img src="{{asset('storage/images/group-img/'.$group->id.'/'.$group->profile_image)}}"  alt="profile-img" class="rounded-circle img-fluid avatar-120">
                                @else
                                    <img src="{{asset('images/page-img/gi-1.jpg')}}" alt="profile-img" class="rounded-circle img-fluid avatar-120">
                                @endif
                            </div>
                            <div class="group-info pt-3 pb-3">
                                <h4><a href="{{route('groupdetail', $group->id)}}">{{$group->group_name}}</a></h4>
                                <p>{{$group->short_description}}</p>
                            </div>
                            <div class="group-details d-inline-block pb-3">
                                <ul class="d-flex align-items-center justify-content-between list-inline m-0 p-0">
                                    <li class="pe-3 ps-3">
                                        @php
                                            $totalFeeds = count(GroupsFeed::where(['status' => 'Y', 'group_id' => $group->id])->orderBy('created_at', 'DESC')->get());
                                        @endphp
                                        <p class="mb-0">Post</p>
                                        <h6>{{$totalFeeds}}</h6>
                                    </li>
                                    <li class="pe-3 ps-3">
                                        <p class="mb-0">Member</p>
                                        <h6>{{count($group['groupMembers'])}}</h6>
                                    </li>
                                    {{-- <li class="pe-3 ps-3">
                                        <p class="mb-0">Visit</p>
                                        <h6>{{$group->short_description}}</h6>
                                    </li> --}}
                                </ul>
                            </div>
                            <div class="group-member mb-3">
                                        {{-- images/user/userProfileandCovers/'. $data['user']->id.'/'.$data['user']->avatar_location --}}
                                <div class="iq-media-group">
                                    @if(isset($group['groupMembers'][0]['getUser']->avatar_location) && isset($group['groupMembers'][0]['getUser']->username))
                                        <a href="{{route('user-profile',  ['username' => $group['groupMembers'][0]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$group['groupMembers'][0]['getUser']->id.'/'.$group['groupMembers'][0]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/05.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($group['groupMembers'][1]['getUser']->avatar_location) && isset($group['groupMembers'][1]['getUser']->username))
                                        <a href="{{route('user-profile',  ['username' => $group['groupMembers'][1]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$group['groupMembers'][1]['getUser']->id.'/'.$group['groupMembers'][1]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/05.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($group['groupMembers'][2]['getUser']->avatar_location) && isset($group['groupMembers'][2]['getUser']->username))
                                        <a href="{{route('user-profile',  ['username' => $group['groupMembers'][2]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$group['groupMembers'][2]['getUser']->id.'/'.$group['groupMembers'][2]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/06.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($group['groupMembers'][3]['getUser']->avatar_location) && isset($group['groupMembers'][3]['getUser']->username))
                                        <a href="{{route('user-profile',  ['username' => $group['groupMembers'][3]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/'.$group['groupMembers'][3]['getUser']->id.'/'.$group['groupMembers'][3]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/07.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($group['groupMembers'][4]['getUser']->avatar_location) && isset($group['groupMembers'][4]['getUser']->username))
                                        <a href="{{route('user-profile',  ['username' => $group['groupMembers'][4]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/'.$group['groupMembers'][4]['getUser']->id.'/'.$group['groupMembers'][4]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/08.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($group['groupMembers'][5]['getUser']->avatar_location) && isset($group['groupMembers'][5]['getUser']->username))
                                        <a href="{{route('user-profile',  ['username' => $group['groupMembers'][5]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/'.$group['groupMembers'][5]['getUser']->id.'/'.$group['groupMembers'][5]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/09.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                    @if(isset($group['groupMembers'][6]['getUser']->avatar_location) && isset($group['groupMembers'][6]['getUser']->username))
                                        <a href="{{route('user-profile',  ['username' => $group['groupMembers'][6]['getUser']->username])}}" class="iq-media">
                                            <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/'.$group['groupMembers'][6]['getUser']->id.'/'.$group['groupMembers'][6]['getUser']->avatar_location)}}" alt="">
                                            {{-- <img class="img-fluid avatar-40 rounded-circle" src="{{asset('images/user/10.jpg')}}" alt=""> --}}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @php
                                $joinedGroups = GroupMembers::where(['user_id' => $user->id, 'group_id' => $group->id])->get();
                            @endphp
                            @if (isset($joinedGroups[0]) && $joinedGroups[0] != null)
                                <a @disabled(true) class="btn btn-primary d-block w-100 join-group">Joined</a>
                            @else
                            <form method="POST" action="{{ route('join-group') }}">
                                @csrf
                                <input type="hidden" id="groupId" value={{$group->id}} name="groupId">
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
    