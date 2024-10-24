<x-app-layout>
    <div id="content-page" class="content-page">
        <div class="container">
            <h2 style="margin-bottom: 2rem;">All Notifications</h2>
            <div class="d-grid gap-2 d-grid-template-1fr-19 grid-cols-1">
                @foreach($data['userNotifications'] as $userNotification)
                    @php
                        $url = $userNotification->url;
                        $ids = explode("/", $url);
                        $urlProfile = array_slice($ids, 0, 1);
                        $urlProfileImp = isset($urlProfile[0]) ? $urlProfile[0] : null;
                        $ids = array_slice($ids, 1);
                        $id_string = implode("-", $ids);
                        $encrypted_ids = encrypt($id_string);
                        $userName = User::find($userNotification->friend_id);
                        $user_first_last_name = $userName->first_name . ' ' . $userName->last_name;
                        if($urlProfileImp === 'profile' && is_numeric($ids[0])){
                            $userNotificationUrl = DB::table('users')->select('username')->where('id', $ids[0])->first();
                        }
                    @endphp
                    @if($userNotification->viewed == 1)
                        <div class="iq-sub-card readNotificationsDropdownPage px-2 deleteNotification_{{$userNotification->id}}">
                            <div class="d-flex align-items-center">
                                <a href="@if($urlProfileImp === 'profile' && isset($userNotificationUrl->username)) /profile/{{$userNotificationUrl->username}} @elseif($urlProfileImp !== 'notificationDetails') /{{$userNotification->url}} @else /notificationDetails/{{ $encrypted_ids }} @endif" >
                                    @if ($userNotification->getUser === null)
                                    <img class="avatar-40 rounded-circle notify" src="{{asset('images/user/Users_100x100.png')}}" alt="">
                                    @else
                                        @if (isset($userNotification->getUser->avatar_location) && $userNotification->getUser->avatar_location !== '')
                                            <img class="avatar-40 rounded-circle notify" src="{{ asset('storage/images/user/userProfileandCovers/' . $userNotification->getUser->id . '/' . $userNotification->getUser->avatar_location) }}"alt="">
                                        @else
                                            <img class="avatar-40 rounded-circle notify" src="{{asset('images/user/Users_100x100.png')}}" alt="">
                                        @endif
                                    @endif
                                    @if(isset($ids[0]) && is_string($ids[0]) && in_array($ids[0], ['group_feed_comment', 'group_feed_like', 'group_feed_comment_like']))
                                        {{-- <i class="icon material-symbols-outlined">groups</i> --}}
                                    @elseif(isset($ids[0]) && is_string($ids[0]) && in_array($ids[0], ['page_feed_like', 'page_feed_comment', 'page_feed_comment_like']))
                                        {{-- <span class="position-relative  rounded-circle bg-white" style="right:-17px; bottom:24px"><i class="icon material-symbols-outlined fs-6">flag</i></span> --}}
                                    @else
                                    @endif
                                </a>
                                <a class="w-100" href="@if($urlProfileImp === 'profile' && isset($userNotificationUrl->username)) /profile/{{$userNotificationUrl->username}} @elseif($urlProfileImp !== 'notificationDetails') /{{$userNotification->url}} @else /notificationDetails/{{ $encrypted_ids }} @endif" >
                                    <div class="ms-3 w-100" style="max-width:fit-content">
                                        <h6 class="mb-0 me-4" >{{$user_first_last_name.$userNotification->message}}</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="float-right font-size-12">{{ $userNotification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                                <div style="max-width:20px; width:20px; min-width:20px" class="text-center">
                                    <div class="dropdown delete_notification_hover_page dropstart ">
                                        <button class="border-0 bg-transparent m-0 p-0"  id="notificationmenu" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <svg height="22px" viewBox="0 0 22 22" width="22px">
                                                <circle cx="11" cy="6" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle>
                                                <circle cx="11" cy="11" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle>
                                                <circle cx="11" cy="16" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle>
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu p-1" style="min-width:auto; top:0" aria-labelledby="notificationmenu">
                                            <li>
                                                <span class="btn btn-primary dropdown-item m-0 px-1 py-0" onclick="deleteNotification('{{$userNotification->id}}')">Remove</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="iq-sub-card unReadNotificationsDropdownPage bg-soft-primary rounded px-2 deleteNotification_{{$userNotification->id}}">
                            <div class="d-flex align-items-center ">
                                <a href="@if($urlProfileImp === 'profile' && isset($userNotificationUrl->username)) /profile/{{$userNotificationUrl->username}} @elseif($urlProfileImp !== 'notificationDetails') /{{$userNotification->url}} @else /notificationDetails/{{ $encrypted_ids }} @endif" onclick="readNotification({{$userNotification->id}})">
                                    <div class="">
                                        @if ($userNotification->getUser === null)
                                            <img class="avatar-40 rounded-circle notify" src="{{asset('images/user/Users_100x100.png')}}" alt="">
                                        @else
                                            @if (isset($userNotification->getUser->avatar_location) && $userNotification->getUser->avatar_location !== '')
                                                <img class="avatar-40 rounded-circle notify" src="{{ asset('storage/images/user/userProfileandCovers/' . $userNotification->getUser->id . '/' . $userNotification->getUser->avatar_location) }}"alt="">
                                            @else
                                                <img class="avatar-40 rounded-circle notify" src="{{asset('images/user/Users_100x100.png')}}" alt="">
                                            @endif
                                        @endif
                                    </div>
                                </a>
                                <a class="w-100" href="@if($urlProfileImp === 'profile' && isset($userNotificationUrl->username)) /profile/{{$userNotificationUrl->username}} @elseif($urlProfileImp !== 'notificationDetails') /{{$userNotification->url}} @else /notificationDetails/{{ $encrypted_ids }} @endif" onclick="readNotification({{$userNotification->id}})">
                                    <div class="ms-3 nootification-data" style="max-width:fit-content">
                                        <h6 class="mb-0 me-4">{{$user_first_last_name.$userNotification->message}}</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="float-right font-size-12">{{ $userNotification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown delete_notification_hover_page dropstart" style="max-width:20px; width:20px">
                                    <button class="border-0 bg-transparent p-0 m-0"  id="notificationmenu" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <svg height="22px" viewBox="0 0 22 22" width="22px">
                                            <circle cx="11" cy="6" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle>
                                            <circle cx="11" cy="11" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle>
                                            <circle cx="11" cy="16" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu p-1" style="min-width:auto; top:0" aria-labelledby="notificationmenu">
                                        <li>
                                            <span class="btn btn-primary dropdown-item m-0 px-1 py-0" onclick="deleteNotification('{{$userNotification->id}}')">Remove</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
