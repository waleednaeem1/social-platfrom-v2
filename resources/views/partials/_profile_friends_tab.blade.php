@php
    use App\Models\UserFollow;
    use App\Models\User;
    use App\Models\Friend;
    use App\Models\FriendRequest;
    use App\Models\BlockedUser;
@endphp
<div class="tab-content">
    <div class="tab-pane fade active show" id="all-friends" role="tabpanel">
        <div class="card-body p-0">
            <div class="grid-cols--xxl-2 d-grid gap-2">
                @foreach ($data['friends'] as $friend)
                    @php
                        $data['is_following_all-friends'] = (bool) UserFollow::where(['user_id' => auth()->user()->id, 'following_user_id'=>$friend->id])->first();
                        $data['is_blocking_all-friends'] = (bool) BlockedUser::where(['user_id' => $user->id, 'blocked_user_id' => $friend->id])->first();
                        $data['allFollowing_all-friends'] = UserFollow::with('getUserDetailsFollowing:id,first_name,last_name,avatar_location,cover_image,username')->where(['user_id' => $user->id])->get();
                        $data['following_user_all-friends'] = count($data['allFollowing_all-friends']);

                        $data['UserFollow_all-friends'] = UserFollow::where(['user_id' => auth()->user()->id, 'following_user_id'=>$friend->id])->first();
                        $data['other_friends_all-friends'] = User::with('getfriends.getuser')->where('id', $friend->id)->first();

                        $data['check_friends_all-friends'] =  Friend::whereIn('user_id', [$data['other_friends_all-friends']->id, auth()->user()->id])->whereIn('friend_id', [$data['other_friends_all-friends']->id, auth()->user()->id])->first();

                        $data['friendrequest_status_for_accept_all-friends'] = FriendRequest::where(['friend_id' => $user->id,'status' => 'pending'])->first();
                        $data['check_friendrequest_status_tocancel_all-friends'] =  FriendRequest::where(['user_id' => $user->id, 'friend_id' => $data['other_friends_all-friends']->id, 'status' => 'pending'])->first();

                        $data['is_request_sending_all-friends'] = (bool) FriendRequest::whereIn('user_id', [$user->id, $data['other_friends_all-friends']->id])->whereIn('friend_id', [$user->id, $data['other_friends_all-friends']->id])->first();
                        // $data['is_request_sending'] = (bool) FriendRequest::where(['user_id' => $user->id, 'friend_id' => $data['other_friends']->id])->first();
                        $data['check_friendrequest_status_all-friends'] =  FriendRequest::whereIn('user_id', [$user->id, $data['other_friends_all-friends']->id])->whereIn('friend_id', [$user->id, $data['other_friends_all-friends']->id])->first();
                    @endphp
                    <div class="">
                        <div class="iq-friendlist-block border-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    {{-- <a href="{{ route('user-profile', ['username' => $friend->username]) }}"> --}}
                                        @if (isset($friend->avatar_location) && $friend->avatar_location !== '')
                                            <img src="{{ asset('storage/images/user/userProfileandCovers/' . $friend->id . '/' . $friend->avatar_location) }}" class="rounded-circle-profile-tabs friend-section-profile" alt="profile-img" width="100px" height="100px">
                                        @else
                                            <img src="{{ asset('images/user/Users_150x150.png') }}" alt="profile-img" class="friend-section-profile" width="100px" height="100px">
                                        @endif
                                    {{-- </a> --}}
                                    @if (isset($friend))
                                        @if (isset($friend->username) && $friend->username !== '')
                                            <a href="{{ route('user-profile', ['username' => $friend->username]) }}">
                                                <div class="friend-info ms-3">
                                                    <h5>{{ $friend->first_name }} {{ $friend->last_name }}</h5>
                                                </div>
                                            </a>
                                        @else
                                            <h5>{{$friend->first_name.' '.$friend->last_name}}</h5>
                                        @endif
                                    @endif
                                </div>
                                @if($friend->username !== $user->username)
                                <div class="card-header-toolbar d-flex align-items-center me-2 friendsSectionsAddFriend_{{$friend->username}}">
                                    <div class="updateProfileFriendRequestDiv_{{$friend->username}}" style="width: max-content;display: flex;align-items: center;justify-content: flex-start;">
                                        <div class="d-none dropdown hideApproveFriendSection_{{$friend->username}}">
                                            <span class="dropdown-toggle=" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                <svg style="color: rgb(140, 104, 205);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16"> <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" fill="#8c68cd"></path> </svg>
                                            </span>
                                            <div class="dropdown-menu">
                                                @if ($data['is_following_all-friends'])
                                                    <a href="javascript:void(0);" class="dropdown-item unfollowFriend_{{$friend->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_all-friends_{{$friend->username}}" action="javascript:void();">Unfollow</a>
                                                    <a class="dropdown-item d-none followFriend_{{$friend->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$friend->username}}')">Follow</a>
                                                @else
                                                    <a class="dropdown-item followFriend_{{$friend->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$friend->username}}')">Follow</a>
                                                    <a href="javascript:void(0);" class="dropdown-item d-none unfollowFriend_{{$friend->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_all-friends_{{$friend->username}}" action="javascript:void();">Unfollow</a>
                                                @endif
                                                @if ($data['is_blocking_all-friends'])
                                                    <a class="dropdown-item unblockFriend_{{$friend->username}}" onclick="unblockFriendUser('{{$friend->username}}')" href="javascript:void(0);">Unblock</a>
                                                    <a href="javascript:void(0);" class="dropdown-item d-none" data-bs-toggle="modal" data-bs-target="#block-user-modal_all-friends_{{$friend->username}}" action="javascript:void();">Block</a>

                                                    {{-- <a class="dropdown-item d-none blockFriend_{{$friend->username}}" onclick="blockFriendUser('{{$friend->username}}')" href="javascript:void(0);">Block</a> --}}
                                                @else
                                                    {{-- <a class="dropdown-item blockFriend_{{$friend->username}}" onclick="blockFriendUser('{{$friend->username}}')" href="javascript:void(0);">Block</a> --}}

                                                    <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#block-user-modal_all-friends_{{$friend->username}}" action="javascript:void();">Block</a>
                                                    <a class="dropdown-item d-none unblockFriend_{{$friend->username}}" onclick="unblockFriendUser('{{$friend->username}}')" href="javascript:void(0);">Unblock</a>
                                                @endif
                                                <a class="dropdown-item unFriend_{{$friend->username}}" onclick="unFriendUser('{{$friend->username}}')" href="javascript:void(0);">Unfriend</a>
                                            </div>
                                        </div>
                                        @if ($data['check_friends_all-friends'])
                                            <div class="dropdown hideFriendSection_{{$friend->username}}">
                                                <span class="dropdown-toggle=" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                    <svg style="color: rgb(140, 104, 205);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16"> <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" fill="#8c68cd"></path> </svg>
                                                </span>
                                                <div class="dropdown-menu">
                                                    @if ($data['is_following_all-friends'])
                                                        <a href="javascript:void(0);" class="dropdown-item unfollowFriend_{{$friend->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_all-friends_{{$friend->username}}" action="javascript:void();">Unfollow</a>
                                                        <a class="dropdown-item d-none followFriend_{{$friend->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$friend->username}}')">Follow</a>
                                                    @else
                                                        <a class="dropdown-item followFriend_{{$friend->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$friend->username}}')">Follow</a>
                                                        <a href="javascript:void(0);" class="dropdown-item d-none unfollowFriend_{{$friend->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_all-friends_{{$friend->username}}" action="javascript:void();">Unfollow</a>
                                                    @endif
                                                    @if ($data['is_blocking_all-friends'])
                                                        <a class="dropdown-item unblockFriend_{{$friend->username}}" onclick="unblockFriendUser('{{$friend->username}}')" href="javascript:void(0);">Unblock</a>
                                                        <a href="javascript:void(0);" class="dropdown-item d-none" data-bs-toggle="modal" data-bs-target="#block-user-modal_all-friends_{{$friend->username}}" action="javascript:void();">Block</a>

                                                        {{-- <a class="dropdown-item d-none blockFriend_{{$friend->username}}" onclick="blockFriendUser('{{$friend->username}}')" href="javascript:void(0);">Block</a> --}}
                                                    @else
                                                        {{-- <a class="dropdown-item blockFriend_{{$friend->username}}" onclick="blockFriendUser('{{$friend->username}}')" href="javascript:void(0);">Block</a> --}}

                                                        <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#block-user-modal_all-friends_{{$friend->username}}" action="javascript:void();">Block</a>
                                                        <a class="dropdown-item d-none unblockFriend_{{$friend->username}}" onclick="unblockFriendUser('{{$friend->username}}')" href="javascript:void(0);">Unblock</a>
                                                    @endif
                                                    <a class="dropdown-item unFriend_{{$friend->username}}" onclick="unFriendUser('{{$friend->username}}')" href="javascript:void(0);">Unfriend</a>
                                                </div>
                                            </div>
                                        @else
                                        {{-- @dump($data['is_request_sending'], $friend->username); --}}
                                        @if ($data['is_request_sending_all-friends'])
                                                @if (isset($data['check_friendrequest_status_all-friends']))
                                                    @if ($data['check_friendrequest_status_all-friends']->status == 'pending' || $data['check_friendrequest_status_all-friends']->status == 'rejected' || $data['check_friendrequest_status_all-friends']->status == 'unfriend')
                                                    {{-- @dump($data['check_friendrequest_status']);     --}}
                                                    @if($data['friendrequest_status_for_accept_all-friends'] )
                                                            <div class="dropdown respondRequest_{{$friend->username}}">
                                                                <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false"
                                                                    role="button">
                                                                    Respond Request
                                                                </span>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfileUser({{$data['friendrequest_status_for_accept_all-friends']->user_id}} , '{{$friend->username}}')">Confirm</a>
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfileUser({{$data['friendrequest_status_for_accept_all-friends']->id}} , '{{$friend->username}}')">Delete</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                        @if($data['check_friendrequest_status_tocancel_all-friends'])
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
                                                @if($data['is_request_sending_all-friends'] )
                                                    <div class="dropdown respondRequest_{{$friend->username}}">
                                                        <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"
                                                            role="button">
                                                            Respond Request
                                                        </span>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfileUser({{$data['friendrequest_status_for_accept_all-friends']->user_id}}, '{{$friend->username}}')">Confirm</a>
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfileUser({{$data['friendrequest_status_for_accept_all-friends']->id}}, '{{$friend->username}}')">Delete</a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <a  onclick="addToFriendUser('{{$friend->username}}')" href="javascript:void(0);"
                                                        class="btn btn-primary d-flex align-items-center  text-nowrap addFriend_{{$friend->username}}"><i
                                                            class="material-symbols-outlined me-2">add</i>Add Friend </a>
                                                @endif
                                                <a onclick="cancelRequestUser('{{$friend->username}}')" href="javascript:void(0);"
                                                    class="btn btn-primary d-flex align-items-center d-none cancelRequest_{{$friend->username}}">Cancel Request</a>
                                            @endif
                                        @endif
                                    </div>
                                    <a onclick="addToFriendUser('{{$friend->username}}')" href="javascript:void(0);" class="btn btn-primary d-flex align-items-center text-nowrap d-none addToFriend_{{$friend->username}}"><i class="material-symbols-outlined me-2">add</i>Add Friend </a>
                                    <a onclick="cancelRequestUser('{{$friend->username}}')" href="javascript:void(0);" class="btn btn-primary d-none cancelRequest_{{$friend->username}}">Cancel Request</a>
                                </div>
                                @endif
                            </div>
                            <div class="modal fade" id="unfollow-modal_all-friends_{{$friend->username}}" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="unfollow-modalLabel" aria-hidden="true" >
                                <div class="modal-dialog   modal-fullscreen-sm-down">
                                   <div class="modal-content">
                                      <div class="modal-header" style="align-items: flex-start;">
                                        <div class="d-flex align-items-center">
                                            @if(isset($friend->avatar_location) && $friend->avatar_location !== '')
                                            <img src="{{ asset('storage/images/user/userProfileandCovers/'. $friend->id.'/'.$friend->avatar_location) }}" alt="userimg" class="avatar-80 rounded-circle" loading="lazy">
                                            @else
                                            {{-- <img src="{{asset('images/user/1.jpg')}}" alt="userimg" class="avatar-60 rounded-circle-profile-tabs" loading="lazy"> --}}
                                            <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                            @endif
                                            <p class="modal-title ms-3" id="unfollow-modalLabel" >Are you sure you want to unfollow {{$friend->first_name}} {{$friend->last_name}}?</p>
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
                            <div class="modal fade" id="block-user-modal_all-friends_{{$friend->username}}" tabindex="-1" style="min-height: 400px; margin-top:4.8rem"  aria-labelledby="block-modalLabel" aria-hidden="true" >
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
                                                <button data-bs-dismiss="modal" onclick="blockFriendUserTab('{{$friend->username}}')" class="btn btn-primary me-2">Yes</button>
                                                <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="recently-add" role="tabpanel">
        <div class="card-body p-0">
            <div class="grid-cols--xxl-2 d-grid gap-2">
                @foreach ($data['allRecentlyAdded'] as $recentAdd)
                    @if(isset($recentAdd))
                        @php
                            $data['is_following_recently-add'] = (bool) UserFollow::where(['user_id' => auth()->user()->id, 'following_user_id'=>$recentAdd->id])->first();
                            $data['is_blocking_recently-add'] = (bool) BlockedUser::where(['user_id' => $user->id, 'blocked_user_id' => $recentAdd->id])->first();
                            $data['allFollowing_recently-add'] = UserFollow::with('getUserDetailsFollowing:id,first_name,last_name,avatar_location,cover_image,username')->where(['user_id' => $user->id])->get();
                            $data['following_user_recently-add'] = count($data['allFollowing_recently-add']);

                            $data['UserFollow_recently-add'] = UserFollow::where(['user_id' => auth()->user()->id, 'following_user_id'=>$recentAdd->id])->first();
                            $data['other_friends_recently-add'] = User::with('getfriends.getuser')->where('id', $recentAdd->id)->first();

                            $data['check_friends_recently-add'] =  Friend::whereIn('user_id', [$data['other_friends_recently-add']->id, auth()->user()->id])->whereIn('friend_id', [$data['other_friends_recently-add']->id, auth()->user()->id])->first();

                            $data['friendrequest_status_for_accept_recently-add'] = FriendRequest::where(['friend_id' => $user->id,'status' => 'pending'])->first();
                            $data['check_friendrequest_status_tocancel_recently-add'] =  FriendRequest::where(['user_id' => $user->id, 'friend_id' => $data['other_friends_recently-add']->id, 'status' => 'pending'])->first();

                            $data['is_request_sending_recently-add'] = (bool) FriendRequest::whereIn('user_id', [$user->id, $data['other_friends_recently-add']->id])->whereIn('friend_id', [$user->id, $data['other_friends_recently-add']->id])->first();
                            // $data['is_request_sending'] = (bool) FriendRequest::where(['user_id' => $user->id, 'friend_id' => $data['other_friends']->id])->first();
                            $data['check_friendrequest_status_recently-add'] =  FriendRequest::whereIn('user_id', [$user->id, $data['other_friends_recently-add']->id])->whereIn('friend_id', [$user->id, $data['other_friends_recently-add']->id])->first();
                            $recently_add = 'recently-add';
                        @endphp
                        <div class="">
                            <div class="iq-friendlist-block border-0">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        {{-- <a href="{{ route('user-profile', ['username' => $recentAdd->username]) }}"> --}}
                                            @if (isset($recentAdd->avatar_location) && $recentAdd->avatar_location !== '')
                                                <img src="{{ asset('storage/images/user/userProfileandCovers/' . $recentAdd->id . '/' . $recentAdd->avatar_location) }}" class="rounded-circle-profile-tabs friend-section-profile" alt="profile-img" width="100px" height="100px">
                                            @else
                                                <img src="{{ asset('images/user/Users_150x150.png') }}" alt="profile-img" class="friend-section-profile" width="100px" height="100px">
                                            @endif
                                        {{-- </a> --}}
                                        @if (isset($recentAdd))
                                            @if (isset($recentAdd->username) && $recentAdd->username !== '')
                                                <a href="{{ route('user-profile', ['username' => $recentAdd->username]) }}">
                                                    <div class="friend-info ms-3">
                                                        <h5>{{ $recentAdd->first_name }} {{ $recentAdd->last_name }}</h5>
                                                    </div>
                                                </a>
                                            @else
                                                <h5>{{$recentAdd->first_name.' '.$recentAdd->last_name}}</h5>
                                            @endif
                                        @endif
                                    </div>
                                    @if($recentAdd->username !== $user->username)
                                        <div class="card-header-toolbar d-flex align-items-center me-2 friendsSectionsAddFriend_{{$recentAdd->username}}_{{$recently_add}}">
                                            <div class="updateProfileFriendRequestDiv_{{$recentAdd->username}}" style="width: max-content;display: flex;align-items: center;justify-content: flex-start;">
                                                <div class="d-none dropdown hideApproveFriendSection_{{$recentAdd->username}}">
                                                    <span class="dropdown-toggle=" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                        <svg style="color: rgb(140, 104, 205);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16"> <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" fill="#8c68cd"></path> </svg>
                                                    </span>
                                                    <div class="dropdown-menu">
                                                        @if ($data['is_following_recently-add'])
                                                            <a href="javascript:void(0);" class="dropdown-item unfollowFriend_{{$recentAdd->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_recently-add_{{$recentAdd->username}}" action="javascript:void();">Unfollow</a>
                                                            <a class="dropdown-item d-none followFriend_{{$recentAdd->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$recentAdd->username}}')">Follow</a>
                                                        @else
                                                            <a class="dropdown-item followFriend_{{$recentAdd->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$recentAdd->username}}')">Follow</a>
                                                            <a href="javascript:void(0);" class="dropdown-item d-none unfollowFriend_{{$recentAdd->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_recently-add_{{$recentAdd->username}}" action="javascript:void();">Unfollow</a>
                                                        @endif
                                                        @if ($data['is_blocking_recently-add'])
                                                            <a class="dropdown-item unblockFriend_{{$recentAdd->username}}" onclick="unblockFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);">Unblock</a>
                                                            <a href="javascript:void(0);" class="dropdown-item d-none" data-bs-toggle="modal" data-bs-target="#block-user-modal_recently-add_{{$recentAdd->username}}" action="javascript:void();">Block</a>

                                                            {{-- <a class="dropdown-item d-none blockFriend_{{$recentAdd->username}}" onclick="blockFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);">Block</a> --}}
                                                        @else
                                                            {{-- <a class="dropdown-item blockFriend_{{$recentAdd->username}}" onclick="blockFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);">Block</a> --}}

                                                            <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#block-user-modal_recently-add_{{$recentAdd->username}}" action="javascript:void();">Block</a>
                                                            <a class="dropdown-item d-none unblockFriend_{{$recentAdd->username}}" onclick="unblockFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);">Unblock</a>
                                                        @endif
                                                        <a class="dropdown-item unFriend_{{$recentAdd->username}}" onclick="unFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);">Unfriend</a>
                                                    </div>
                                                </div>
                                                @if ($data['check_friends_recently-add'])
                                                    <div class="dropdown hideFriendSection_{{$recentAdd->username}}">
                                                        <span class="dropdown-toggle=" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                            <svg style="color: rgb(140, 104, 205);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16"> <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" fill="#8c68cd"></path> </svg>
                                                        </span>
                                                        <div class="dropdown-menu">
                                                            @if ($data['is_following_recently-add'])
                                                                <a href="javascript:void(0);" class="dropdown-item unfollowFriend_{{$recentAdd->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_recently-add_{{$recentAdd->username}}" action="javascript:void();">Unfollow</a>
                                                                <a class="dropdown-item d-none followFriend_{{$recentAdd->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$recentAdd->username}}')">Follow</a>
                                                            @else
                                                                <a class="dropdown-item followFriend_{{$recentAdd->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$recentAdd->username}}')">Follow</a>
                                                                <a href="javascript:void(0);" class="dropdown-item d-none unfollowFriend_{{$recentAdd->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_recently-add_{{$recentAdd->username}}" action="javascript:void();">Unfollow</a>
                                                            @endif
                                                            @if ($data['is_blocking_recently-add'])
                                                                <a class="dropdown-item unblockFriend_{{$recentAdd->username}}" onclick="unblockFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);">Unblock</a>
                                                                <a href="javascript:void(0);" class="dropdown-item d-none" data-bs-toggle="modal" data-bs-target="#block-user-modal_recently-add_{{$friend->username}}" action="javascript:void();">Block</a>

                                                                {{-- <a class="dropdown-item d-none blockFriend_{{$recentAdd->username}}" onclick="blockFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);">Block</a> --}}
                                                            @else
                                                                {{-- <a class="dropdown-item blockFriend_{{$recentAdd->username}}" onclick="blockFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);">Block</a> --}}

                                                                <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#block-user-modal_recently-add_{{$friend->username}}" action="javascript:void();">Block</a>
                                                                <a class="dropdown-item d-none unblockFriend_{{$recentAdd->username}}" onclick="unblockFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);">Unblock</a>
                                                            @endif
                                                            <a class="dropdown-item unFriend_{{$recentAdd->username}}" onclick="unFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);">Unfriend</a>
                                                        </div>
                                                    </div>
                                                @else
                                                @if ($data['is_request_sending_recently-add'])
                                                        @if (isset($data['check_friendrequest_status_recently-add']))
                                                            @if ($data['check_friendrequest_status_recently-add']->status == 'pending' || $data['check_friendrequest_status_recently-add']->status == 'rejected' || $data['check_friendrequest_status_recently-add']->status == 'unfriend')
                                                            @if($data['friendrequest_status_for_accept_recently-add'] )
                                                                    <div  class="dropdown respondRequest_{{$recentAdd->username}}">
                                                                        <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            role="button">
                                                                            Respond Request
                                                                        </span>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfileUser({{$data['friendrequest_status_for_accept_recently-add']->user_id}} , '{{$recentAdd->username}}')">Confirm</a>
                                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfileUser({{$data['friendrequest_status_for_accept_recently-add']->id}} , '{{$recentAdd->username}}')">Delete</a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                @if($data['check_friendrequest_status_tocancel_recently-add'])
                                                                        <a onclick="cancelRequestUser('{{$recentAdd->username}}')"
                                                                            href="javascript:void(0);"
                                                                            class="btn btn-primary d-flex align-items-center cancelRequest_{{$recentAdd->username}}">Cancel Request</a>
                                                                    @else
                                                                        <a onclick="addToFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);"
                                                                                class="btn btn-primary d-flex align-items-center addFriend_{{$recentAdd->username}}"><i
                                                                                    class="material-symbols-outlined me-2">add</i>Add
                                                                                Friend</a>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if($data['is_request_sending_recently-add'] )
                                                            <div class="dropdown respondRequest_{{$recentAdd->username}}">
                                                                <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false"
                                                                    role="button">
                                                                    Respond Request
                                                                </span>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfileUser({{$data['friendrequest_status_for_accept_recently-add']->user_id}} , '{{$recentAdd->username}}')">Confirm</a>
                                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfileUser({{$data['friendrequest_status_for_accept_recently-add']->id}} , '{{$recentAdd->username}}')">Delete</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <a  onclick="addToFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);"
                                                                class="btn btn-primary d-flex align-items-center text-nowrap addFriend_{{$recentAdd->username}}"><i
                                                                    class="material-symbols-outlined me-2">add</i>Add Friend </a>
                                                        @endif
                                                        <a onclick="cancelRequestUser('{{$recentAdd->username}}')" href="javascript:void(0);"
                                                            class="btn btn-primary d-flex align-items-center d-none cancelRequest_{{$recentAdd->username}}">Cancel Request</a>
                                                    @endif
                                                @endif
                                            </div>
                                            <a onclick="addToFriendUser('{{$recentAdd->username}}')" href="javascript:void(0);" class="btn btn-primary d-flex align-items-center text-nowrap d-none addToFriend_{{$recentAdd->username}}"><i class="material-symbols-outlined me-2">add</i>Add Friend </a>
                                            <a onclick="cancelRequestUser('{{$recentAdd->username}}')" href="javascript:void(0);" class="btn btn-primary d-none cancelRequest_{{$recentAdd->username}}">Cancel Request</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="unfollow-modal_recently-add_{{$recentAdd->username}}" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="unfollow-modalLabel" aria-hidden="true" >
                            <div class="modal-dialog   modal-fullscreen-sm-down">
                               <div class="modal-content">
                                  <div class="modal-header" style="align-items: flex-start;">
                                    <div class="d-flex align-items-center">
                                        @if(isset($recentAdd->avatar_location) && $recentAdd->avatar_location !== '')
                                        <img src="{{ asset('storage/images/user/userProfileandCovers/'. $recentAdd->id.'/'.$recentAdd->avatar_location) }}" alt="userimg" class="avatar-80 rounded-circle" loading="lazy">
                                        @else
                                        {{-- <img src="{{asset('images/user/1.jpg')}}" alt="userimg" class="avatar-60 rounded-circle-profile-tabs" loading="lazy"> --}}
                                        <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                        @endif
                                        <p class="modal-title ms-3" id="unfollow-modalLabel" >Are you sure you want to unfollow {{$recentAdd->first_name}} {{$recentAdd->last_name}}?</p>
                                    </div>
                                     <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                        <span class="material-symbols-outlined">close</span>
                                     </a>
                                  </div>
                                  <div class="modal-body align-self-end">
                                     <div class="d-flex align-items-center">
                                           <button data-bs-dismiss="modal" onclick="unfollowFriendUser('{{$recentAdd->username}}')" class="btn btn-primary me-2">Yes</button>
                                           <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                                     </div>
                                  </div>
                               </div>
                            </div>
                        </div>
                        <div class="modal fade" id="block-user-modal_recently-add_{{$recentAdd->username}}" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="block-modalLabel" aria-hidden="true" >
                            <div class="modal-dialog   modal-fullscreen-sm-down">
                               <div class="modal-content">
                                    <div class="modal-header"style="align-items: flex-start;">
                                        <h5 class="modal-title ms-3" style="max-width:400px;" id="block-modalLabel">Are you sure you want to block {{$recentAdd->first_name}} {{$recentAdd->last_name}}?</h5>
                                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                            <span class="material-symbols-outlined">close</span>
                                        </a>
                                    </div>
                                    <div class="modal-body align-self-end">
                                        <p style="color:red" class="mx-3">
                                            Once you block someone, that person can no longer see things you post on your timeline, start a conversation with you, or add you as a friend.
                                        </p>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button data-bs-dismiss="modal" onclick="blockFriendUserTab('{{$recentAdd->username}}')" class="btn btn-primary me-2">Yes</button>
                                            <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="closefriends" role="tabpanel">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="iq-friendlist-block border-0">
                        <div
                            class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);">
                                    <img src="{{ asset('images/user/19.jpg') }}"
                                        alt="profile-img" class="img-fluid">
                                </a>
                                <div class="friend-info ms-3">
                                    <h5>Bud Wiser</h5>
                                    <p class="mb-0">32 friends</p>
                                </div>
                            </div>
                            <div
                                class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span
                                        class="dropdown-toggle btn btn-secondary me-2 d-flex align-items-center"
                                        id="dropdownMenuButton01"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="true" role="button">
                                        <i class="material-symbols-outlined me-2">
                                            done
                                        </i>
                                        Friend
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton39">
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Get
                                            Notification</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Close Friend</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Unfollow</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Unfriend</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Block</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="iq-friendlist-block border-0">
                        <div
                            class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);">
                                    <img src="{{ asset('images/user/05.jpg') }}"
                                        alt="profile-img" class="img-fluid">
                                </a>
                                <div class="friend-info ms-3">
                                    <h5>Otto Matic</h5>
                                    <p class="mb-0">9 friends</p>
                                </div>
                            </div>
                            <div
                                class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span
                                        class="dropdown-toggle btn btn-secondary me-2 d-flex align-items-center"
                                        id="dropdownMenuButton01"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="true" role="button">
                                        <i class="material-symbols-outlined me-2">
                                            done
                                        </i>
                                        Friend
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton40">
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Get
                                            Notification</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Close Friend</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Unfollow</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Unfriend</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Block</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="iq-friendlist-block border-0">
                        <div
                            class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);">
                                    <img src="{{ asset('images/user/06.jpg') }}"
                                        alt="profile-img" class="img-fluid">
                                </a>
                                <div class="friend-info ms-3">
                                    <h5>Peter Pants</h5>
                                    <p class="mb-0">2 friends</p>
                                </div>
                            </div>
                            <div
                                class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span
                                        class="dropdown-toggle btn btn-secondary me-2 d-flex align-items-center"
                                        id="dropdownMenuButton01"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="true" role="button">
                                        <i class="material-symbols-outlined me-2">
                                            done
                                        </i>
                                        Friend
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton41">
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Get
                                            Notification</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Close Friend</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Unfollow</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Unfriend</a>
                                        <a class="dropdown-item"
                                            href="javascript:void(0);">Block</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="iq-friendlist-block border-0">
                        <div
                            class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);">
                                    <img src="{{ asset('images/user/07.jpg') }}"
                                        alt="profile-img" class="img-fluid">
                                </a>
                                <div class="friend-info ms-3">
                                    <h5>Zack Lee</h5>
                                    <p class="mb-0">15 friends</p>
                                </div>
                            </div>
                            <div
                                class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span
                                        class="dropdown-toggle btn btn-secondary me-2 d-flex align-items-center"
                                        id="dropdownMenuButton01"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="true" role="button">
                                        <i class="material-symbols-outlined me-2">
                                            done
                                        </i>
                                        Friend
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton42">
                                        <a class="dropdown-item"href="javascript:void(0);">GetNotification</a>
                                        <a class="dropdown-item"href="javascript:void(0);">Close Friend</a>
                                        <a class="dropdown-item"href="javascript:void(0);">Unfollow</a>
                                        <a class="dropdown-item"href="javascript:void(0);">Unfriend</a>
                                        <a class="dropdown-item"href="javascript:void(0);">Block</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="home-town" role="tabpanel">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="iq-friendlist-block border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);">
                                    <img src="{{ asset('images/user/18.jpg') }}" alt="profile-img" class="img-fluid">
                                </a>
                                <div class="friend-info ms-3">
                                    <h5>Paul Molive</h5>
                                    <p class="mb-0">14 friends</p>
                                </div>
                            </div>
                            <div
                                class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span
                                        class="dropdown-toggle btn btn-secondary me-2 d-flex align-items-center"
                                        id="dropdownMenuButton01"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="true" role="button">
                                        <i class="material-symbols-outlined me-2">
                                            done
                                        </i>
                                        Friend
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton49">
                                        <a class="dropdown-item" href="javascript:void(0);">Get Notification</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Close Friend</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Unfollow</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Unfriend</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Block</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="iq-friendlist-block border-0">
                        <div
                            class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);">
                                    <img src="{{ asset('images/user/19.jpg') }}"
                                        alt="profile-img" class="img-fluid">
                                </a>
                                <div class="friend-info ms-3">
                                    <h5>Paige Turner</h5>
                                    <p class="mb-0">8 friends</p>
                                </div>
                            </div>
                            <div
                                class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span
                                        class="dropdown-toggle btn btn-secondary me-2 d-flex align-items-center"
                                        id="dropdownMenuButton01"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="true" role="button">
                                        <i class="material-symbols-outlined me-2">
                                            done
                                        </i>
                                        Friend
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton50">
                                        <a class="dropdown-item" href="javascript:void(0);">Get Notification</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Close Friend</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Unfollow</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Unfriend</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Block</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="iq-friendlist-block border-0">
                        <div
                            class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);">
                                    <img src="{{ asset('images/user/05.jpg') }}"
                                        alt="profile-img" class="img-fluid">
                                </a>
                                <div class="friend-info ms-3">
                                    <h5>Barb Ackue</h5>
                                    <p class="mb-0">23 friends</p>
                                </div>
                            </div>
                            <div
                                class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span
                                        class="dropdown-toggle btn btn-secondary me-2 d-flex align-items-center"
                                        id="dropdownMenuButton01"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="true" role="button">
                                        <i class="material-symbols-outlined me-2">
                                            done
                                        </i>
                                        Friend
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton51">
                                        <a class="dropdown-item" href="javascript:void(0);">Get Notification</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Close Friend</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Unfollow</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Unfriend</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Block</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="iq-friendlist-block border-0">
                        <div
                            class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);">
                                    <img src="{{ asset('images/user/06.jpg') }}"
                                        alt="profile-img" class="img-fluid">
                                </a>
                                <div class="friend-info ms-3">
                                    <h5>Ira Membrit</h5>
                                    <p class="mb-0">16 friends</p>
                                </div>
                            </div>
                            <div
                                class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span
                                        class="dropdown-toggle btn btn-secondary me-2 d-flex align-items-center"
                                        id="dropdownMenuButton01"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="true" role="button">
                                        <i class="material-symbols-outlined me-2">
                                            done
                                        </i>
                                        Friend
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton52">
                                        <a class="dropdown-item" href="javascript:void(0);">Get Notification</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Close Friend</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Unfollow</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Unfriend</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Block</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="iq-friendlist-block border-0">
                        <div
                            class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);">
                                    <img src="{{ asset('images/user/07.jpg') }}" alt="profile-img" class="img-fluid">
                                </a>
                                <div class="friend-info ms-3">
                                    <h5>Maya Didas</h5>
                                    <p class="mb-0">12 friends</p>
                                </div>
                            </div>
                            <div
                                class="card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span class="dropdown-toggle btn btn-secondary me-2 d-flex align-items-center" id="dropdownMenuButton01" data-bs-toggle="dropdown" saria-expanded="true" role="button">
                                        <i class="material-symbols-outlined me-2">
                                            done
                                        </i>
                                        Friend
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuButton53">
                                        <a class="dropdown-item" href="javascript:void(0);">Get Notification</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Close Friend</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Unfollow</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Unfriend</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Block</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="following" role="tabpanel">
        <div class="card-body p-0">
            <div class="grid-cols--xxl-2 d-grid gap-2">
                @foreach($data['allFollowing'] as $following)
                    @if(isset($following['getUserDetailsFollowing']))
                        @php
                            $data['is_following_following'] = (bool) UserFollow::where(['user_id' => auth()->user()->id, 'following_user_id'=>$following['getUserDetails']->id])->first();
                            $data['is_blocking_following'] = (bool) BlockedUser::where(['user_id' => $user->id, 'blocked_user_id' => $following['getUserDetails']->id])->first();
                            $data['allFollowing_following'] = UserFollow::with('getUserDetailsFollowing:id,first_name,last_name,avatar_location,cover_image,username')->where(['user_id' => $user->id])->get();
                            $data['following_user_following'] = count($data['allFollowing_following']);

                            $data['UserFollow_following'] = UserFollow::where(['user_id' => auth()->user()->id, 'following_user_id'=>$following['getUserDetails']->id])->first();
                            $data['other_friends_following'] = User::with('getfriends.getuser')->where('id', $following['getUserDetails']->id)->first();
                            $data['check_friends_following'] =  Friend::whereIn('user_id', [$data['other_friends_following']->id, auth()->user()->id])->whereIn('friend_id', [$data['other_friends_following']->id, auth()->user()->id])->first();

                            $data['friendrequest_status_for_accept_following'] = FriendRequest::where(['friend_id' => $user->id,'status' => 'pending'])->first();
                            $data['check_friendrequest_status_tocancel_following'] =  FriendRequest::where(['user_id' => $user->id, 'friend_id' => $data['other_friends_following']->id, 'status' => 'pending'])->first();

                            $data['is_request_sending_following'] = (bool) FriendRequest::whereIn('user_id', [$user->id, $data['other_friends_following']->id])->whereIn('friend_id', [$user->id, $data['other_friends_following']->id])->first();
                            // $data['is_request_sending'] = (bool) FriendRequest::where(['user_id' => $user->id, 'friend_id' => $data['other_friends']->id])->first();
                            $data['check_friendrequest_status_following'] =  FriendRequest::whereIn('user_id', [$user->id, $data['other_friends_following']->id])->whereIn('friend_id', [$user->id, $data['other_friends_following']->id])->first();
                        @endphp
                        <div class="">
                            <div class="iq-friendlist-block border-0">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        {{-- <a href="{{ route('user-profile', ['username' => @$following['getUserDetails']->username]) }}"> --}}
                                            @if (isset($following['getUserDetails']->avatar_location) && $following['getUserDetails']->avatar_location !== '')
                                                <img src="{{ asset('storage/images/user/userProfileandCovers/' . $following['getUserDetails']->id . '/' . $following['getUserDetails']->avatar_location) }}" class="rounded-circle-profile-tabs friend-section-profile" alt="profile-img" width="100px" height="100px">
                                            @else
                                                <img src="{{ asset('images/user/Users_150x150.png') }}" alt="profile-img" class="friend-section-profile" width="100px" height="100px">
                                            @endif
                                        {{-- </a> --}}
                                        <div class="friend-info ms-3">
                                            @if(isset($following['getUserDetails']->username) && $following['getUserDetails']->username !== '')
                                                <a href="{{ route('user-profile', ['username' => $following['getUserDetails']->username]) }}">
                                                    <h5>{{$following['getUserDetailsFollowing']->first_name.' '.$following['getUserDetailsFollowing']->last_name}}</h5>
                                                </a>
                                            @else
                                                <h5>{{$following['getUserDetailsFollowing']->first_name.' '.$following['getUserDetailsFollowing']->last_name}}</h5>
                                            @endif
                                        </div>
                                    </div>
                                    @if($following['getUserDetailsFollowing']->username !== $user->username)
                                        <div class="card-header-toolbar d-flex align-items-center me-2 friendsSectionsAddFriend_{{$following['getUserDetails']->username}}">
                                            <div class="updateProfileFriendRequestDiv_{{$following['getUserDetails']->username}}" style="width: max-content;display: flex;align-items: center;justify-content: flex-start;">
                                                <div class="d-none dropdown hideApproveFriendSection_{{$following['getUserDetails']->username}}">
                                                    <span class="dropdown-toggle=" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                        <svg style="color: rgb(140, 104, 205);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16"> <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" fill="#8c68cd"></path> </svg>
                                                    </span>
                                                    <div class="dropdown-menu">
                                                        @if ($data['is_following_following'])
                                                            <a href="javascript:void(0);" class="dropdown-item unfollowFriend_{{$following['getUserDetails']->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_following_{{$following['getUserDetails']->username}}" action="javascript:void();">Unfollow</a>
                                                            <a class="dropdown-item d-none followFriend_{{$following['getUserDetails']->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$following['getUserDetails']->username}}')">Follow</a>
                                                        @else
                                                            <a class="dropdown-item followFriend_{{$following['getUserDetails']->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$following['getUserDetails']->username}}')">Follow</a>
                                                            <a href="javascript:void(0);" class="dropdown-item d-none unfollowFriend_{{$following['getUserDetails']->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_following_{{$following['getUserDetails']->username}}" action="javascript:void();">Unfollow</a>
                                                        @endif
                                                        @if ($data['is_blocking_following'])
                                                            <a class="dropdown-item unblockFriend_{{$following['getUserDetails']->username}}" onclick="unblockFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);">Unblock</a>
                                                            <a href="javascript:void(0);" class="dropdown-item d-none" data-bs-toggle="modal" data-bs-target="#block-user-modal_following_{{$following->username}}" action="javascript:void();">Block</a>

                                                            {{-- <a class="dropdown-item d-none blockFriend_{{$following['getUserDetails']->username}}" onclick="blockFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);">Block</a> --}}
                                                        @else
                                                            {{-- <a class="dropdown-item blockFriend_{{$following['getUserDetails']->username}}" onclick="blockFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);">Block</a> --}}

                                                            <a href="javascript:void(0);" class="dropdown-item " data-bs-toggle="modal" data-bs-target="#block-user-modal_following_{{$following->username}}" action="javascript:void();">Block</a>
                                                            <a class="dropdown-item d-none unblockFriend_{{$following['getUserDetails']->username}}" onclick="unblockFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);">Unblock</a>
                                                        @endif
                                                        <a class="dropdown-item unFriend_{{$following['getUserDetails']->username}}" onclick="unFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);">Unfriend</a>
                                                    </div>
                                                </div>
                                                @if ($data['check_friends_following'])
                                                    <div class="dropdown hideFriendSection_{{$following['getUserDetails']->username}}">
                                                        <span class="dropdown-toggle=" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                            <svg style="color: rgb(140, 104, 205);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16"> <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" fill="#8c68cd"></path> </svg>
                                                        </span>
                                                        <div class="dropdown-menu">
                                                            @if ($data['is_following_following'])
                                                                <a href="javascript:void(0);" class="dropdown-item unfollowFriend_{{$following['getUserDetails']->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_following_{{$following['getUserDetails']->username}}" action="javascript:void();">Unfollow</a>
                                                                <a class="dropdown-item d-none followFriend_{{$following['getUserDetails']->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$following['getUserDetails']->username}}')">Follow</a>
                                                            @else
                                                                <a class="dropdown-item followFriend_{{$following['getUserDetails']->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$following['getUserDetails']->username}}')">Follow</a>
                                                                <a href="javascript:void(0);" class="dropdown-item d-none unfollowFriend_{{$following['getUserDetails']->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_following_{{$following['getUserDetails']->username}}" action="javascript:void();">Unfollow</a>
                                                            @endif
                                                            @if ($data['is_blocking_following'])
                                                                <a class="dropdown-item unblockFriend_{{$following['getUserDetails']->username}}" onclick="unblockFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);">Unblock</a>
                                                                <a href="javascript:void(0);" class="dropdown-item d-none" data-bs-toggle="modal" data-bs-target="#block-user-modal_following_{{$following['getUserDetails']->username}}" action="javascript:void();">Block</a>

                                                                {{-- <a class="dropdown-item d-none blockFriend_{{$following['getUserDetails']->username}}" onclick="blockFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);">Block</a> --}}
                                                            @else
                                                                {{-- <a class="dropdown-item blockFriend_{{$following['getUserDetails']->username}}" onclick="blockFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);">Block</a> --}}

                                                                <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#block-user-modal_following_{{$following['getUserDetails']->username}}" action="javascript:void();">Block</a>
                                                                <a class="dropdown-item d-none unblockFriend_{{$following['getUserDetails']->username}}" onclick="unblockFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);">Unblock</a>
                                                            @endif
                                                            <a class="dropdown-item unFriend_{{$following['getUserDetails']->username}}" onclick="unFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);">Unfriend</a>
                                                        </div>
                                                    </div>
                                                @else
                                                @if ($data['is_request_sending_following'])
                                                        @if (isset($data['check_friendrequest_status_following']))
                                                            @if ($data['check_friendrequest_status_following']->status == 'pending' || $data['check_friendrequest_status_following']->status == 'rejected' || $data['check_friendrequest_status_following']->status == 'unfriend')
                                                            @if($data['friendrequest_status_for_accept_following'] )
                                                                    <div  class="dropdown respondRequest_{{$following['getUserDetails']->username}}">
                                                                        <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            role="button">
                                                                            Respond Request
                                                                        </span>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfileUser({{$data['friendrequest_status_for_accept_following']->user_id}} , '{{$following['getUserDetails']->username}}')">Confirm</a>
                                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfileUser({{$data['friendrequest_status_for_accept_following']->id}} , '{{$following['getUserDetails']->username}}')">Delete</a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                @if($data['check_friendrequest_status_tocancel_following'])
                                                                        <a onclick="cancelRequestUser('{{$following['getUserDetails']->username}}')"
                                                                            href="javascript:void(0);"
                                                                            class="btn btn-primary d-flex align-items-center cancelRequest_{{$following['getUserDetails']->username}}">Cancel Request</a>
                                                                    @else
                                                                        <a onclick="addToFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);"
                                                                                class="btn btn-primary d-flex align-items-center addFriend_{{$following['getUserDetails']->username}}"><i
                                                                                    class="material-symbols-outlined me-2">add</i>Add
                                                                                Friend</a>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if($data['is_request_sending_following'] )
                                                            <div class="dropdown respondRequest_{{$following['getUserDetails']->username}}">
                                                                <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false"
                                                                    role="button">
                                                                    Respond Request
                                                                </span>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfileUser({{$data['friendrequest_status_for_accept_following']->user_id}}, '{{$following['getUserDetails']->username}}')">Confirm</a>
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfileUser({{$data['friendrequest_status_for_accept_following']->id}}, '{{$following['getUserDetails']->username}}')">Delete</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <a  onclick="addToFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);"
                                                                class="btn btn-primary d-flex align-items-center text-nowrap addFriend_{{$following['getUserDetails']->username}}"><i
                                                                    class="material-symbols-outlined me-2">add</i>Add Friend </a>
                                                        @endif
                                                        <a onclick="cancelRequestUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);"
                                                            class="btn btn-primary d-flex align-items-center d-none cancelRequest_{{$following['getUserDetails']->username}}">Cancel Request</a>
                                                    @endif
                                                @endif
                                            </div>
                                            <a onclick="addToFriendUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);" class="btn btn-primary d-flex align-items-center text-nowrap d-none addToFriend_{{$following['getUserDetails']->username}}"><i class="material-symbols-outlined me-2">add</i>Add Friend </a>
                                            <a onclick="cancelRequestUser('{{$following['getUserDetails']->username}}')" href="javascript:void(0);" class="btn btn-primary d-none cancelRequest_{{$following['getUserDetails']->username}}">Cancel Request</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="unfollow-modal_following_{{$following['getUserDetails']->username}}" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="unfollow-modalLabel" aria-hidden="true" >
                            <div class="modal-dialog   modal-fullscreen-sm-down">
                               <div class="modal-content">
                                  <div class="modal-header" style="align-items: flex-start;">
                                    <div class="d-flex align-items-center">
                                        @if(isset($following['getUserDetails']->avatar_location) && $following['getUserDetails']->avatar_location !== '')
                                        <img src="{{ asset('storage/images/user/userProfileandCovers/'. $following['getUserDetails']->id.'/'.$following['getUserDetails']->avatar_location) }}" alt="userimg" class="avatar-80 rounded-circle" loading="lazy">
                                        @else
                                        {{-- <img src="{{asset('images/user/1.jpg')}}" alt="userimg" class="avatar-60 rounded-circle-profile-tabs" loading="lazy"> --}}
                                        <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                        @endif
                                        <p class="modal-title ms-3" id="unfollow-modalLabel" >Are you sure you want to unfollow {{$following['getUserDetails']->first_name}} {{$following['getUserDetails']->last_name}}?</p>
                                    </div>
                                     <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                        <span class="material-symbols-outlined">close</span>
                                     </a>
                                  </div>
                                  <div class="modal-body align-self-end">
                                     <div class="d-flex align-items-center">
                                           <button data-bs-dismiss="modal" onclick="unfollowFriendUser('{{$following['getUserDetails']->username}}')" class="btn btn-primary me-2">Yes</button>
                                           <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                                     </div>
                                  </div>
                               </div>
                            </div>
                        </div>
                        <div class="modal fade" id="block-user-modal_following_{{$following['getUserDetails']->username}}" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="block-modalLabel" aria-hidden="true" >
                            <div class="modal-dialog   modal-fullscreen-sm-down">
                               <div class="modal-content">
                                    <div class="modal-header"style="align-items: flex-start;">
                                        <h5 class="modal-title ms-3" style="max-width:400px;" id="block-modalLabel">Are you sure you want to block {{$following['getUserDetails']->first_name}} {{$following['getUserDetails']->last_name}}?</h5>
                                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                            <span class="material-symbols-outlined">close</span>
                                        </a>
                                    </div>
                                    <div class="modal-body align-self-end">
                                        <p style="color:red" class="mx-3">
                                            Once you block someone, that person can no longer see things you post on your timeline, start a conversation with you, or add you as a friend.
                                        </p>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button data-bs-dismiss="modal" onclick="blockFriendUserTab('{{$following['getUserDetails']->username}}')" class="btn btn-primary me-2">Yes</button>
                                            <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="followers" role="tabpanel">
        <div class="card-body p-0">
            <div class="grid-cols--xxl-2 d-grid gap-2">
                @foreach($data['allFollowers'] as $follower)
                    @if(isset($follower['getUserDetailsFollowers']))
                        @php
                            $data['is_following_followers'] = (bool) UserFollow::where(['user_id' => auth()->user()->id, 'following_user_id'=>$follower['getUserDetailsFollowers']->id])->first();
                            $data['is_blocking_followers'] = (bool) BlockedUser::where(['user_id' => $user->id, 'blocked_user_id' => $follower['getUserDetailsFollowers']->id])->first();
                            $data['allFollowing_followers'] = UserFollow::with('getUserDetailsFollowing:id,first_name,last_name,avatar_location,cover_image,username')->where(['user_id' => $user->id])->get();
                            $data['following_user_followers'] = count($data['allFollowing_followers']);

                            $data['UserFollow_followers'] = UserFollow::where(['user_id' => auth()->user()->id, 'following_user_id'=>$follower['getUserDetailsFollowers']->id])->first();
                            $data['other_friends_followers'] = User::with('getfriends.getuser')->where('id', $follower['getUserDetailsFollowers']->id)->first();

                            $data['check_friends_followers'] =  Friend::whereIn('user_id', [$data['other_friends_followers']->id, auth()->user()->id])->whereIn('friend_id', [$data['other_friends_followers']->id, auth()->user()->id])->first();

                            $data['friendrequest_status_for_accept_followers'] = FriendRequest::where(['friend_id' => $user->id,'status' => 'pending'])->first();
                            $data['check_friendrequest_status_tocancel_followers'] =  FriendRequest::where(['user_id' => $user->id, 'friend_id' => $data['other_friends_followers']->id, 'status' => 'pending'])->first();

                            $data['is_request_sending_followers'] = (bool) FriendRequest::whereIn('user_id', [$user->id, $data['other_friends_followers']->id])->whereIn('friend_id', [$user->id, $data['other_friends_followers']->id])->first();
                            // $data['is_request_sending'] = (bool) FriendRequest::where(['user_id' => $user->id, 'friend_id' => $data['other_friends']->id])->first();
                            $data['check_friendrequest_status_followers'] =  FriendRequest::whereIn('user_id', [$user->id, $data['other_friends_followers']->id])->whereIn('friend_id', [$user->id, $data['other_friends_followers']->id])->first();
                        @endphp
                        <div class="">
                            <div class="iq-friendlist-block border-0">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        {{-- <a href="{{ route('user-profile', ['username' => $follower['getUserDetailsFollowers']->username]) }}"> --}}
                                            @if (isset($follower['getUserDetailsFollowers']->avatar_location) && $follower['getUserDetailsFollowers']->avatar_location !== '')
                                                <img src="{{ asset('storage/images/user/userProfileandCovers/' . $follower['getUserDetailsFollowers']->id . '/' . $follower['getUserDetailsFollowers']->avatar_location) }}" class="rounded-circle-profile-tabs friend-section-profile" alt="profile-img" width="100px" height="100px">
                                            @else
                                                <img src="{{ asset('images/user/Users_150x150.png') }}" alt="profile-img" class="friend-section-profile" width="100px" height="100px">
                                            @endif
                                        {{-- </a> --}}
                                        <div class="friend-info ms-3">
                                            @if(isset($follower['getUserDetailsFollowers']->username) && $follower['getUserDetailsFollowers']->username !== '')
                                                <a href="{{ route('user-profile', ['username' => $follower['getUserDetailsFollowers']->username]) }}">
                                                    <h5>{{$follower['getUserDetailsFollowers']->first_name.' '.$follower['getUserDetailsFollowers']->last_name}}</h5>
                                                </a>
                                            @else
                                                <h5>{{$follower['getUserDetailsFollowers']->first_name.' '.$follower['getUserDetailsFollowers']->last_name}}</h5>
                                            @endif
                                        </div>
                                    </div>
                                    @if($follower['getUserDetailsFollowers']->username !== $user->username)
                                        <div class="card-header-toolbar d-flex align-items-center me-2 friendsSectionsAddFriend_{{$follower['getUserDetailsFollowers']->username}}">
                                            <div class="updateProfileFriendRequestDiv_{{$follower['getUserDetailsFollowers']->username}}" style="width: max-content;display: flex;align-items: center;justify-content: flex-start;">
                                                <div class="d-none dropdown hideApproveFriendSection_{{$follower['getUserDetailsFollowers']->username}}">
                                                    <span class="dropdown-toggle=" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                        <svg style="color: rgb(140, 104, 205);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16"> <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" fill="#8c68cd"></path> </svg>
                                                    </span>
                                                    <div class="dropdown-menu">
                                                        @if ($data['is_following_followers'])
                                                            <a href="javascript:void(0);" class="dropdown-item unfollowFriend_{{$follower['getUserDetailsFollowers']->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_followers_{{$follower['getUserDetailsFollowers']->username}}" action="javascript:void();">Unfollow</a>
                                                            <a class="dropdown-item d-none followFriend_{{$follower['getUserDetailsFollowers']->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$follower['getUserDetailsFollowers']->username}}')">Follow</a>
                                                        @else
                                                            <a class="dropdown-item followFriend_{{$follower['getUserDetailsFollowers']->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$follower['getUserDetailsFollowers']->username}}')">Follow</a>
                                                            <a href="javascript:void(0);" class="dropdown-item d-none unfollowFriend_{{$follower['getUserDetailsFollowers']->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_followers_{{$follower['getUserDetailsFollowers']->username}}" action="javascript:void();">Unfollow</a>
                                                        @endif
                                                        @if ($data['is_blocking_followers'])
                                                            <a class="dropdown-item unblockFriend_{{$follower['getUserDetailsFollowers']->username}}" onclick="unblockFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);">Unblock</a>
                                                            <a href="javascript:void(0);" class="dropdown-item d-none" data-bs-toggle="modal" data-bs-target="#block-user-modal_followers_{{$follower['getUserDetailsFollowers']->username}}" action="javascript:void();">Block</a>

                                                            {{-- <a class="dropdown-item d-none blockFriend_{{$follower['getUserDetailsFollowers']->username}}" onclick="blockFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);">Block</a> --}}
                                                        @else
                                                            {{-- <a class="dropdown-item blockFriend_{{$follower['getUserDetailsFollowers']->username}}" onclick="blockFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);">Block</a> --}}

                                                            <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#block-user-modal_followers_{{$follower['getUserDetailsFollowers']->username}}" action="javascript:void();">Block</a>
                                                            <a class="dropdown-item d-none unblockFriend_{{$follower['getUserDetailsFollowers']->username}}" onclick="unblockFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);">Unblock</a>
                                                        @endif
                                                        <a class="dropdown-item unFriend_{{$follower['getUserDetailsFollowers']->username}}" onclick="unFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);">Unfriend</a>
                                                    </div>
                                                </div>
                                                @if ($data['check_friends_followers'])
                                                    <div class="dropdown hideFriendSection_{{$follower['getUserDetailsFollowers']->username}}">
                                                        <span class="dropdown-toggle=" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                            <svg style="color: rgb(140, 104, 205);" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16"> <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" fill="#8c68cd"></path> </svg>
                                                        </span>
                                                        <div class="dropdown-menu">
                                                            @if ($data['is_following_followers'])
                                                                <a href="javascript:void(0);" class="dropdown-item unfollowFriend_{{$follower['getUserDetailsFollowers']->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_followers_{{$follower['getUserDetailsFollowers']->username}}" action="javascript:void();">Unfollow</a>
                                                                <a class="dropdown-item d-none followFriend_{{$follower['getUserDetailsFollowers']->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$follower['getUserDetailsFollowers']->username}}')">Follow</a>
                                                            @else
                                                                <a class="dropdown-item followFriend_{{$follower['getUserDetailsFollowers']->username}}" href="javascript:void(0);" onclick="followFriendUser('{{$follower['getUserDetailsFollowers']->username}}')">Follow</a>
                                                                <a href="javascript:void(0);" class="dropdown-item d-none unfollowFriend_{{$follower['getUserDetailsFollowers']->username}}" data-bs-toggle="modal" data-bs-target="#unfollow-modal_followers_{{$follower['getUserDetailsFollowers']->username}}" action="javascript:void();">Unfollow</a>
                                                            @endif
                                                            @if ($data['is_blocking_followers'])
                                                                <a class="dropdown-item unblockFriend_{{$follower['getUserDetailsFollowers']->username}}" onclick="unblockFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);">Unblock</a>
                                                                <a href="javascript:void(0);" class="dropdown-item d-none" data-bs-toggle="modal" data-bs-target="#block-user-modal_followers_{{$follower['getUserDetailsFollowers']->username}}" action="javascript:void();">Block</a>

                                                                {{-- <a class="dropdown-item d-none blockFriend_{{$follower['getUserDetailsFollowers']->username}}" onclick="blockFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);">Block</a> --}}
                                                            @else
                                                                {{-- <a class="dropdown-item blockFriend_{{$follower['getUserDetailsFollowers']->username}}" onclick="blockFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);">Block</a> --}}

                                                                <a href="javascript:void(0);" class="dropdown-item " data-bs-toggle="modal" data-bs-target="#block-user-modal_followers_{{$follower['getUserDetailsFollowers']->username}}" action="javascript:void();">Block</a>
                                                                <a class="dropdown-item d-none unblockFriend_{{$follower['getUserDetailsFollowers']->username}}" onclick="unblockFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);">Unblock</a>
                                                            @endif
                                                            <a class="dropdown-item unFriend_{{$follower['getUserDetailsFollowers']->username}}" onclick="unFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);">Unfriend</a>
                                                        </div>
                                                    </div>
                                                @else
                                                @if ($data['is_request_sending_followers'])
                                                        @if (isset($data['check_friendrequest_status_followers']))
                                                            @if ($data['check_friendrequest_status_followers']->status == 'pending' || $data['check_friendrequest_status_followers']->status == 'rejected' || $data['check_friendrequest_status_followers']->status == 'unfriend')

                                                            @if($data['friendrequest_status_for_accept_followers'] )
                                                                    <div class="dropdown respondRequest_{{$follower['getUserDetailsFollowers']->username}}">
                                                                        <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            role="button">
                                                                            Respond Request
                                                                        </span>
                                                                        <div class="dropdown-menu">
                                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfileUser({{$data['friendrequest_status_for_accept_followers']->user_id}} , '{{$follower['getUserDetailsFollowers']->username}}')">Confirm</a>
                                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfileUser({{$data['friendrequest_status_for_accept_followers']->id}} , '{{$follower['getUserDetailsFollowers']->username}}')">Delete</a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                @if($data['check_friendrequest_status_tocancel_followers'])
                                                                        <a onclick="cancelRequestUser('{{$follower['getUserDetailsFollowers']->username}}')"
                                                                            href="javascript:void(0);"
                                                                            class="btn btn-primary d-flex align-items-center cancelRequest_{{$follower['getUserDetailsFollowers']->username}}">Cancel Request</a>
                                                                    @else
                                                                        <a onclick="addToFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);"
                                                                                class="btn btn-primary d-flex align-items-center addFriend_{{$follower['getUserDetailsFollowers']->username}}"><i
                                                                                    class="material-symbols-outlined me-2">add</i>Add
                                                                                Friend</a>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if($data['is_request_sending_followers'] )
                                                            <div class="dropdown respondRequest_{{$follower['getUserDetailsFollowers']->username}}">
                                                                <span class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false"
                                                                    role="button">
                                                                    Respond Request
                                                                </span>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="approveRequestProfileUser({{$data['friendrequest_status_for_accept_followers']->user_id}}, '{{$follower['getUserDetailsFollowers']->username}}')">Confirm</a>
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="disapproveRequestProfileUser({{$data['friendrequest_status_for_accept_followers']->id}}, '{{$follower['getUserDetailsFollowers']->username}}')">Delete</a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <a  onclick="addToFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);"
                                                                class="btn btn-primary d-flex align-items-center text-nowrap addFriend_{{$follower['getUserDetailsFollowers']->username}}"><i
                                                                    class="material-symbols-outlined me-2">add</i>Add Friend </a>
                                                        @endif
                                                        <a onclick="cancelRequestUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);"
                                                            class="btn btn-primary d-flex align-items-center d-none cancelRequest_{{$follower['getUserDetailsFollowers']->username}}">Cancel Request</a>
                                                    @endif
                                                @endif
                                            </div>
                                            <a onclick="addToFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);" class="btn btn-primary d-flex align-items-center text-nowrap d-none addToFriend_{{$follower['getUserDetailsFollowers']->username}}"><i class="material-symbols-outlined me-2">add</i>Add Friend </a>
                                            <a onclick="cancelRequestUser('{{$follower['getUserDetailsFollowers']->username}}')" href="javascript:void(0);" class="btn btn-primary d-none cancelRequest_{{$follower['getUserDetailsFollowers']->username}}">Cancel Request</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="unfollow-modal_followers_{{$follower['getUserDetailsFollowers']->username}}" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="unfollow-modalLabel" aria-hidden="true" >
                            <div class="modal-dialog   modal-fullscreen-sm-down">
                               <div class="modal-content">
                                  <div class="modal-header" style="align-items: flex-start;">
                                    <div class="d-flex align-items-center">
                                        @if(isset($follower['getUserDetailsFollowers']->avatar_location) && $follower['getUserDetailsFollowers']->avatar_location !== '')
                                        <img src="{{ asset('storage/images/user/userProfileandCovers/'. $follower['getUserDetailsFollowers']->id.'/'.$follower['getUserDetailsFollowers']->avatar_location) }}" alt="userimg" class="avatar-80 rounded-circle" loading="lazy">
                                        @else
                                        {{-- <img src="{{asset('images/user/1.jpg')}}" alt="userimg" class="avatar-60 rounded-circle-profile-tabs" loading="lazy"> --}}
                                        <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                                        @endif
                                        <p class="modal-title ms-3" id="unfollow-modalLabel">Are you sure you want to unfollow {{$follower['getUserDetailsFollowers']->first_name}} {{$follower['getUserDetailsFollowers']->last_name}}?</p>
                                    </div>
                                     <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                        <span class="material-symbols-outlined">close</span>
                                     </a>
                                  </div>
                                  <div class="modal-body align-self-end">
                                     <div class="d-flex align-items-center">
                                           <button data-bs-dismiss="modal" onclick="unfollowFriendUser('{{$follower['getUserDetailsFollowers']->username}}')" class="btn btn-primary me-2">Yes</button>
                                           <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                                     </div>
                                  </div>
                               </div>
                            </div>
                        </div>
                        <div class="modal fade" id="block-user-modal_followers_{{$follower['getUserDetailsFollowers']->username}}" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="block-modalLabel" aria-hidden="true" >
                            <div class="modal-dialog   modal-fullscreen-sm-down">
                               <div class="modal-content">
                                    <div class="modal-header"style="align-items: flex-start;">
                                        <p class="modal-title ms-3" style="max-width:400px;" id="block-modalLabel">Are you sure you want to block {{$follower['getUserDetailsFollowers']->first_name}} {{$follower['getUserDetailsFollowers']->last_name}}?</p>
                                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                            <span class="material-symbols-outlined">close</span>
                                        </a>
                                    </div>
                                    <div class="modal-body align-self-end">
                                        <p style="color:red" class="mx-3">
                                            Once you block someone, that person can no longer see things you post on your timeline, start a conversation with you, or add you as a friend.
                                        </p>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button data-bs-dismiss="modal" onclick="blockFriendUserTab('{{$follower['getUserDetailsFollowers']->username}}')" class="btn btn-primary me-2">Yes</button>
                                            <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="blocked" role="tabpanel">
        <div class="card-body p-0">
            <div class="grid-cols--xxl-2 d-grid gap-2">
                @foreach($data['allBlockedUsers'] as $blocked)
                    @if(isset($blocked['getUserDataSelectedColumns']))
                            <div class="">
                                <div class="iq-friendlist-block border-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            {{-- <a href="{{ route('user-profile', ['username' => $blocked['getUserDataSelectedColumns']->username]) }}"> --}}
                                                @if (isset($blocked['getUserDataSelectedColumns']->avatar_location) && $blocked['getUserDataSelectedColumns']->avatar_location !== '')
                                                    <img src="{{ asset('storage/images/user/userProfileandCovers/' . $blocked['getUserDataSelectedColumns']->id . '/' . $blocked['getUserDataSelectedColumns']->avatar_location) }}" class="rounded-circle-profile-tabs friend-section-profile" alt="profile-img" width="100px" height="100px">
                                                @else
                                                    <img src="{{ asset('images/user/Users_150x150.png') }}" alt="profile-img" class="friend-section-profile" width="100px" height="100px">
                                                @endif
                                            {{-- </a> --}}
                                            <div class="friend-info ms-3">
                                                @if(isset($blocked['getUserDataSelectedColumns']->username) && $blocked['getUserDataSelectedColumns']->username !== '')
                                                    <a href="{{ route('user-profile', ['username' => $blocked['getUserDataSelectedColumns']->username]) }}">
                                                        <h5>{{$blocked['getUserDataSelectedColumns']->first_name.' '.$blocked['getUserDataSelectedColumns']->last_name}}</h5>
                                                    </a>
                                                @else
                                                    <h5>{{$blocked['getUserDataSelectedColumns']->first_name.' '.$blocked['getUserDataSelectedColumns']->last_name}}</h5>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-header-toolbar d-flex align-items-center">
                                            <div class="dropdown">
                                                <a class="btn btn-primary me-2 d-flex align-items-center unblockFriendBlockSection_{{$blocked['getUserDataSelectedColumns']->username}}" onclick="unblockFriendUserTab('{{$blocked['getUserDataSelectedColumns']->username}}')" href="javascript:void(0);">Unblock</a>
                                                <a class="btn btn-primary me-2 d-flex align-items-center d-none blockFriendBlockSection_{{$blocked['getUserDataSelectedColumns']->username}}" onclick="blockFriendUserTab('{{$blocked['getUserDataSelectedColumns']->username}}')" href="javascript:void(0);">Block</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
