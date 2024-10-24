<x-app-layout>
    <div id="content-page" class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                    <h2 style="margin-bottom: 2rem; margin-left:15px">Search Results</h2>
                    @if(isset($data['users']) && count($data['users']) > 0)
                        <div style="margin-bottom: 1rem">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                    <h4 class="card-title">Users</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-3 d-grid-template-1fr-19 grid-cols-3">
                                @foreach($data['users'] as $user)
                                    @if (isset($user))
                                        <div class="card mb-0" style="max-width: 320px; height: 8rem;overflow-wrap:anywhere;">
                                            <div class="align-items-center card-body d-flex justify-content-between text-center">
                                                @php
                                                    $userFollowers = App\Models\UserFollow::where('following_user_id', $user->id)->count();
                                                @endphp
                                                <div class="user-icon mt-0" style="margin-bottom: 15px;">
                                                    @if(isset($user->avatar_location) && $user->avatar_location !== '')
                                                        <img src="{{asset('storage/images/user/userProfileandCovers/'.$user->id.'/'.$user->avatar_location)}}" style="width:75px; min-width:75px; min-height:75px; height:75px;" alt="profile-img" class="rounded-circle img-fluid">
                                                    @elseif(isset($user->profile_image) && $user->profile_image !== '')
                                                        <img src="{{asset('storage/images/user/userProfileandCovers/'.$user->id.'/'.$user->profile_image)}}" style="width:75px; min-width: 75px; min-height:75px; height:75px;" alt="profile-img" class="rounded-circle img-fluid">
                                                    @else
                                                        <img src="{{asset('images/user/Users_40x40.png')}}" alt="profile-img" class="rounded-circle img-fluid" style="width:75px; min-width: 75px; min-height:75px; height:75px;">
                                                    @endif
                                                </div>
                                                <div class="group-info pt-3 pb-3">
                                                    <h5><a href="/profile/{{$user->username}}" style="overflow: hidden;">{{$user->first_name}}</a></h5>
                                                    <p style="margin-bottom:0;">{{$user->email}}</p>
                                                    <p style="margin-bottom:0rem;">Followers : {{$userFollowers}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if(isset($data['pages']) && count($data['pages']) > 0)
                        <div style="margin-bottom: 1rem">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Pages</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-3 d-grid-template-1fr-19 grid-cols-3">
                                @foreach($data['pages'] as $page)
                                    <div class="card mb-0" style="max-width: 320px; height: 8rem;">
                                        <div class="align-items-center card-body d-flex justify-content-between text-center">
                                            <div class="user-icon mt-0" style="margin-bottom: 15px;">
                                                @if(isset($page->profile_image) && $page->profile_image !== '')
                                                    <img src="{{asset('storage/images/page-img/'.$page->id.'/'.$page->profile_image)}}" style="width:75px; min-width: 75px; min-height:75px; height:75px;" alt="profile-img" class="rounded-circle img-fluid">
                                                @else
                                                    <img src="{{asset('/images/user/pageProfile.png')}}" alt="profile-img" class="rounded-circle img-fluid" style="width:75px; min-width: 75px; min-height:75px; height:75px;">
                                                @endif
                                            </div>
                                            <div class="group-info pt-3 pb-3">
                                                <h4><a href="{{route('pagedetail', $page->id)}}" style="overflow: hidden;">{{$page->page_name}}</a></h4>
                                                <p style="margin-bottom:0rem;">@if(count($page['pageMembers']) == 1) Total Like : {{count($page['pageMembers'])}} @else Total Likes : {{count($page['pageMembers'])}} @endif</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if(isset($data['groups']) && count($data['groups']) > 0)
                        <div style="margin-bottom: 1rem">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Groups</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-3 d-grid-template-1fr-19 grid-cols-3">
                                @foreach($data['groups'] as $group)
                                    <div class="card mb-0" style="max-width: 320px; height: 8rem;">
                                        <div class="align-items-center card-body d-flex justify-content-between text-center">
                                            <div class="user-icon mt-0" style="margin-bottom: 15px;">
                                                @if(isset($group->cover_image) && $group->cover_image !== '')
                                                    <img src="{{asset('storage/images/group-img/'.$group->id.'/cover/'.$group->cover_image)}}" style="width:75px; min-width: 75px; min-height:75px; height:75px;" alt="profile-img" class="rounded-circle img-fluid">
                                                @else
                                                    <img src="{{asset('/images/user/pageProfile.png')}}" alt="profile-img" class="rounded-circle img-fluid" style="width:75px; min-width: 75px; min-height:75px; height:75px;">
                                                @endif
                                            </div>
                                            <div class="group-info pt-3 pb-3">
                                                <h4><a href="{{route('groupdetail', $group->id)}}" style="overflow: hidden;">{{$group->group_name}}</a></h4>
                                                <p style="margin-bottom:0rem;">@if(count($group['groupMembers']) == 1) Total Member : {{count($group['groupMembers'])}} @else Total Members : {{count($group['groupMembers'])}} @endif</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <input id="search_input_value" type="hidden" value="{{@$data['searchKeywords']}}">
    </div>
</x-app-layout>
