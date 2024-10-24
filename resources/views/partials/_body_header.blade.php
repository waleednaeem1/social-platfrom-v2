<div class="iq-top-navbar">
   @php
      use App\Models\User;
      use App\Models\Chat;
      use App\Models\FriendRequest;
      use App\Models\Notifications;
      use Carbon\Carbon;
      use App\Models\UserProfileDetails;
      $user = auth()->user();
      if($user)
      {
        

         $data['allChats'] = Chat::getChats($user->id);
         $data['userTotalChats'] = Chat::getChatsNewCount();
         $data['friendsRequestList'] = FriendRequest::with('getRequestSender')->where(['friend_id' => $user->id])->where('status' , 'pending')->get();
         $requestCount = FriendRequest::with('getRequestSender')->where(['friend_id' => $user->id])->where(['status' => 'pending', 'uncheck_request' => '0'])->count();
         $userNotificationBadgeRead = Notifications::where(['user_id' => $user->id,'notification_badge_read'=> 0])->count();
         $lastSixWeeks = Carbon::now()->subWeeks(6);
         $data['userNotificationsCount'] = Notifications::where(['user_id' => $user->id,'viewed'=> 0])->where('created_at', '>=', $lastSixWeeks)->count();
       
         $userNotifications = Notifications::with('getUser:id,avatar_location')->with(['groupDetails','pageDetails'])->where(['user_id' => $user->id])->where('created_at', '>=', $lastSixWeeks)->orderBy('created_at','desc')->get();
         // foreach($userNotifications as $userNotification){
         //    $userNotification['groupDetail'] =  
         // }

         $data['userNotifications'] = $userNotifications;
      }
   @endphp

   <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar p-lg-0">
      <div class="container-fluid navbar-inner mx-sm-3 mx-md-2">
         <div class="d-flex align-items-center gap-3">
            <a href="{{route('home')}}" class="d-flex align-items-center gap-2 iq-header-logo d-none d-md-flex ">
               <img src="{{ asset('images/icon/devsinc-logo.png')}}" alt="devsinc" width="110px" loading="lazy">
            </a>
            <a class="sidebar-toggle mini d-xl-none" data-toggle="sidebar" data-active="true" href="javascript:void(0);">
               <div class="icon material-symbols-outlined iq-burger-menu">
                  menu
               </div>
            </a>

         </div>
         <div class="d-block d-md-none">
            {{-- <a href="{{route('home')}}" class="d-flex align-items-center gap-2 iq-header-logo"> --}}
               {{-- <svg width="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M1.67733 9.50001L7.88976 20.2602C9.81426 23.5936 14.6255 23.5936 16.55 20.2602L22.7624 9.5C24.6869 6.16666 22.2813 2 18.4323 2H6.00746C2.15845 2 -0.247164 6.16668 1.67733 9.50001ZM14.818 19.2602C13.6633 21.2602 10.7765 21.2602 9.62181 19.2602L9.46165 18.9828L9.46597 18.7275C9.48329 17.7026 9.76288 16.6993 10.2781 15.8131L12.0767 12.7195L14.1092 16.2155C14.4957 16.8803 14.7508 17.6132 14.8607 18.3743L14.9544 19.0239L14.818 19.2602ZM16.4299 16.4683L19.3673 11.3806C18.7773 11.5172 18.172 11.5868 17.5629 11.5868H13.7316L15.8382 15.2102C16.0721 15.6125 16.2699 16.0335 16.4299 16.4683ZM20.9542 8.63193L21.0304 8.5C22.1851 6.5 20.7417 4 18.4323 4H17.8353L17.1846 4.56727C16.6902 4.99824 16.2698 5.50736 15.9402 6.07437L13.8981 9.58676H17.5629C18.4271 9.58676 19.281 9.40011 20.0663 9.03957L20.9542 8.63193ZM14.9554 4C14.6791 4.33499 14.4301 4.69248 14.2111 5.06912L12.0767 8.74038L10.0324 5.22419C9.77912 4.78855 9.48582 4.37881 9.15689 4H14.9554ZM6.15405 4H6.00746C3.69806 4 2.25468 6.50001 3.40938 8.50001L3.4915 8.64223L4.37838 9.04644C5.15962 9.40251 6.00817 9.58676 6.86672 9.58676H10.2553L8.30338 6.22943C7.9234 5.57587 7.42333 5.00001 6.8295 4.53215L6.15405 4ZM5.07407 11.3833L7.88909 16.2591C8.05955 15.7565 8.28025 15.2702 8.54905 14.8079L10.4218 11.5868H6.86672C6.26169 11.5868 5.66037 11.5181 5.07407 11.3833Z" fill="currentColor"/>
               </svg> --}}
               <a href="{{route('home')}}" class="d-flex align-items-center gap-2 iq-header-logo">
                  <img src="{{ asset('images/icon/logo.png')}}" alt="devsinc" width="50" height="50px"  class="avatar-61 rounded-circle" loading="lazy">
                  <h3 class="logo-title d-none d-sm-block" data-setting="app_name">Devsinc</h3>
               </a>
            {{-- </a> --}}
         </div>
         <div class="d-lg-none">
            <div id="nav-searchbar-sm-btn" class="d-block">
               <a class="d-flex" href="javascript:void(0);" onclick="navSearchbarSm()">
                  <span class="material-symbols-outlined">search</span>
               </a>
            </div>
            <div id="nav-searchbar-sm-modal" class="device-search d-none bg-white">
               <div class="nav-searchbar-sm-container">
                  <form method="GET" action="/search-results" class="searchbox" >
                     <div class="d-flex align-items-center justify-content-between w-100">
                        <a class="search-link" href="javascript:void(0);" onclick="navSearchbarSm()">
                           <span class="material-symbols-outlined pt-1">arrow_back</span>
                        </a>
                        <input id="search_input_put_value" class="text search-input form-control bg-soft-primary" type="text" name="search_input" onkeypress="searchFunction(event, this.value)" onkeyup="userSearch(this.value)"  placeholder="Search here..." autocomplete="off">
                        <a class="search-btn-input" href="javascript:void(0);" onclick="searchEnter()">
                           <span class="material-symbols-outlined">search</span>
                        </a>
                     </div>
                  </form>
                  <div class="search-result-box-sm pt-3"></div>
               </div>
            </div>
         </div>
         <div class="d-none d-lg-block">
            <div class="iq-search-bar device-search  position-relative">
               <form method="GET" action="/searched-users-list" class="searchbox" >
                  <a class="search-link d-none d-lg-block" href="javascript:void(0);" onclick="searchEnter()">
                     <span class="material-symbols-outlined">search</span>
                  </a>
                  <input id="search_input_put_value" type="text" name="search_input" onclick="openModel()" onkeypress="searchFunction(event, this.value)" onkeyup="userSearch(this.value)" class="text search-input form-control bg-soft-primary  d-none d-lg-block" placeholder="Search here..." autocomplete="off" >
                   <a class="d-lg-none d-flex" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreenSm" >
                     <span class="material-symbols-outlined">search</span>
                  </a>
               </form>
               {{-- modal full screen modal --}}
               <div class="modal fade search-modal" id="exampleModalFullscreenSm" aria-labelledby="exampleModalFullscreenSmLabel" aria-hidden="true" >
                  <div class="modal-dialog modal-fullscreen-lg-down">
                     <div class="modal-content">
                        <div class="modal-header py-2">
                           <div class="d-flex align-items-center justify-content-between d-lg-none w-100 my-4">
                              <form method="GET" action="/searched-users-list" id="searchForm" class="w-75">
                                   <div class="input-group rounded">
                                       <input type="text" name="search_input" id="search_input" onkeypress="searchFunction(event, this.value)" onkeyup="userSearch(this.value)" class="form-control rounded" placeholder="Search here..." aria-label="Search" aria-describedby="search-addon" />
                                       {{-- <span class="input-group-text border-0" id="search-addon">
                                       <i class="fas fa-search"></i>
                                       </span> --}}
                                   </div>
                                   {{-- <a class="search-link" href="javascript:void(0);" >
                                       <span class="material-symbols-outlined">search</span>
                                   </a>
                                   <input type="text" name="search_input" id="search_input" class="text search-input form-control bg-soft-primary" placeholder="Search here..."> --}}
                              </form>
                              <a href="javascript:void(0);" class="material-symbols-outlined text-dark" data-bs-dismiss="modal">close</a>
                           </div>
                           <div class="d-none d-lg-flex align-items-center justify-content-between w-100">
                              {{-- <h4 class="modal-title" id="exampleModalFullscreenLabel">Recent</h4> --}}
                              {{-- <a  class="text-dark" href="javascript:void(0);">Clear All</a> --}}
                           </div>
                        </div>
                           <div style="max-height: 412px; height:auto !important; overflow-y: auto;" class="search-result-box modal-body p-0 header overflow-scroll">
                              {{-- <div class="d-flex d-lg-none align-items-center justify-content-between w-100 p-3 pb-0">
                                 <h5 class="modal-title h4" id="exampleModalFullscreenLabel">Recent</h5> --}}
                                 {{-- <a href="javascript:void(0);" class="text-dark">Clear All</a> --}}
                              {{-- </div> --}}
                              {{-- <div class="d-flex align-items-center border-bottom search-hover py-2 px-3">
                                 <div class="flex-shrink-0">
                                    <img src="{{asset('storage/images/page-img/19.jpg')}}" class="align-self-center img-fluid avatar-50 rounded-pill" alt="#">
                                 </div>
                                 <div class="d-flex flex-column ms-3">
                                    <a href="javascript:void(0);" class="h5">Search</a>
                                 </div>
                                 <div class="d-flex align-items-center ms-auto">
                                    <a href="javascript:void(0);" class="me-3 d-flex align-items-center"><small>Follow</small> </a>
                                 </div>
                              </div> --}}
                           </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="offcanvas offcanvas-end iq-profile-menu-responsive" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
               <h5 id="offcanvasRightLabel">General Setting</h5>
               <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
               <ul class="navbar-nav  ms-auto navbar-list">
                  <li class="nav-item">
                     <a href="{{route('home')}}" class="d-flex align-items-center">
                        <i class="material-symbols-outlined">home</i>
                        <span class="mobile-text d-lg-none ms-3">Home</span>
                     </a>
                  </li>
                  {{-- <li class="nav-item">
                     <a href="{{route('cart')}}" class="d-flex align-items-center">
                        <i class="material-symbols-outlined">shopping_cart</i>
                        <span class="mobile-text d-lg-none ms-3">Cart</span>
                     </a>
                  </li> --}}
                  @if(!$user)
                     <li class="nav-item">
                        <a href="{{route('index')}}" class="d-flex align-items-center">
                           <i class="material-symbols-outlined">login</i>
                           <span class="mobile-text d-lg-none ms-3">login</span>
                        </a>
                     </li>
                  @endif
                  @if($user)
                  <li class="nav-item dropdown d-none d-lg-block">
                     <a href="javascript:void(0);" onclick="friendRequestReadBadge()" class="dropdown-toggle d-flex align-items-center friend-requests" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="material-symbols-outlined">group</span>
                     </a>
                     <div id="friendRequestBadgeReadFresh"> @if($requestCount > 0) <span id="friendRequesBadge" class="badge badge-pill position-absolute rounded-pill" style="background-color: var(--bs-primary); font-size:14px; bottom:40px; padding:2px 5px 20px 5px; height:17px; left:27px;"><p>{{$requestCount}}</p></span> @endif</div>
                     <div class="sub-drop sub-drop-large dropdown-menu" aria-labelledby="group-drop" id="group-drop" style="width: 25.25rem">
                        <div class="card shadow-none m-0">
                           <div class="card-header d-flex justify-content-between bg-primary">
                              <div class="header-title">
                                 <h5 class="mb-0 text-white">Friend Requests</h5>
                              </div>
                              {{-- <small class="badge  bg-light text-dark " id="hide-response-count">{{$requestCount}}</small> --}}
                              {{-- <small class="badge  bg-light text-dark d-none" id="show-response-count"></small> --}}
                              {{-- <small class="badge  bg-light text-dark ">4</small> --}}
                           </div>
                           <div id="friendRequestUpdate" class="card-body p-0" style="max-height: 80vh; height:auto; overflow-y: auto;">
                              @forelse ($data['friendsRequestList'] as $request)
                                 @if(isset($request['getRequestSender']))
                                    <div class="iq-friend-request">
                                       <div class="iq-sub-card iq-sub-card-big d-flex align-items-center justify-content-between" id="hide-friend-request{{$request->user_id}}">
                                          <div class="d-flex align-items-center">
                                             @if(isset($request['getRequestSender']->avatar_location) && $request['getRequestSender']->avatar_location != '' && $request['getRequestSender']->username != '')
                                                <a href="{{route('user-profile',  ['username' => $request['getRequestSender']->username])}}">
                                                      <img class="rounded-circle avatar-40" src="{{asset('storage/images/user/userProfileandCovers/'.$request['getRequestSender']->id.'/'.$request['getRequestSender']->avatar_location)}}" alt="" loading="lazy">
                                                </a>
                                             @else
                                                @if(isset($request['getRequestSender']->username) && $request['getRequestSender']->username != '')
                                                   <a href="{{route('user-profile',  ['username' => $request['getRequestSender']->username])}}">
                                                         <img class="rounded-circle avatar-40" src="{{asset('images/user/Users_60x60.png')}}"alt="" loading="lazy">
                                                   </a>
                                                @endif
                                             @endif
                                             @if(isset($request['getRequestSender']))
                                                <div class="ms-3">
                                                   @if(isset($request['getRequestSender']) && isset($request['getRequestSender']->username) && $request['getRequestSender']->username != '')
                                                      <a href="{{route('user-profile',  ['username' => $request['getRequestSender']->username])}}">
                                                         {{-- <h6 class="mb-0 ">{{$request['getRequestSender']->first_name.' '.$request['getRequestSender']->last_name}}</h6> --}}
                                                         <h6 class="mb-0">
                                                            {{substr(@$request['getRequestSender']->first_name, 0, 14).' '. substr(@$request['getRequestSender']->last_name, 0, 4)}}
                                                            @if(strlen(@$request['getRequestSender']->first_name) > 14 || strlen(@$request['getRequestSender']->last_name) > 6)
                                                               ...
                                                            @endif
                                                         </h6>
                                                      </a>
                                                   @endif
                                                </div>
                                             @endif
                                          </div>
                                          <div class="d-flex align-items-center">
                                             <input onclick="approveRequest({{$request->user_id}})" class=" btn btn-primary rounded" type="submit" value="Confirm">
                                             <input onclick="disapproveRequest({{$request->id}},{{$request->user_id}})" class="ms-3 btn btn-secondary rounded" type="submit" value="Delete">
                                          </div>
                                       </div>
                                    </div>
                                 @endif
                              @empty
                              <div style="padding:20px;">
                                 <p style="display: flex; align-item:center;">
                                    <span class="material-symbols-outlined" style="padding-right:10px">group</span> There are no friend requests to display.
                                 </p>
                              </div>
                              @endforelse
                              {{-- <div class="text-center">
                                 <a href="javascript:void(0);" class=" btn text-primary">View More Request</a>
                              </div> --}}
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="nav-item d-lg-none">
                     <a href="{{route('friendrequest')}}" class="d-flex align-items-center">
                        <span class="material-symbols-outlined">group</span>
                        <span class="mobile-text  ms-3">Friend Requests</span>
                     </a>
                  </li>
                  <li class="nav-item dropdown d-none d-lg-block">
                     <a href="javascript:void(0);" onclick="chatReadBadge()" class="dropdown-toggle d-flex align-items-center" id="mail-drop" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-symbols-outlined">mail</i>
                        <span class="mobile-text d-lg-none ms-3">Message</span>
                        <div id="chatBadgeReadFresh">@if($data['userTotalChats'] > 0) <span id="notificationBadge" class="badge badge-pill position-absolute rounded-pill" style="background-color: var(--bs-primary); font-size:14px; bottom:40px; padding:2px 5px 20px 5px; height:17px; left:27px;"><p>{{$data['userTotalChats']}}</p></span> @endif</div>
                     </a>
                     <div class="sub-drop dropdown-menu" aria-labelledby="mail-drop">
                        <div class="card shadow-none m-0">
                           <div class="card-header d-flex justify-content-between bg-primary">
                              <div class="header-title bg-primary">
                                 @php $chatsCountS = $data['allChats']['userChats']->count() @endphp
                                 <h5 class="mb-0 text-white">@if($chatsCountS === 1 && $chatsCountS === 0) All Message @else All Messages @endif</h5>
                              </div>
                              {{-- <small class="badge bg-light text-dark">4</small> --}}
                           </div>
                           <div id="user_chats" class="card-body p-0 " style="max-height: 80vh; height:auto; overflow-y: auto;">
                              @forelse ($data['allChats']['userChats'] as $chat)
                                 @php
                                    $userIdsArray = explode(',', $chat->user_ids);
                                    $sender_info = \App\Models\Chat::getChatSender($chat->user_ids);
                                    $message = $chat->last_message;
                                    if(strlen($message) > 40)
                                       $message = substr($message, 0, 40).' ...';
                                 @endphp
                                 @if(isset($sender_info) && isset($sender_info->first_name) && isset($sender_info->last_name))
                                    <a href="javascript:void(0);" class="iq-sub-card" class="open-button" onclick="openForm({{$chat->id, $chat->user_id}})">
                                       <div class="d-flex  align-items-center">
                                          <div class="">
                                             @if(isset($sender_info->avatar_location) && $sender_info->avatar_location !== '')
                                                <img class="avatar-40 rounded" src="{{asset('storage/images/user/userProfileandCovers/'. $sender_info->id.'/'.$sender_info->avatar_location)}}" alt="" loading="lazy">
                                             @else
                                                <img class="avatar-40 rounded" src="{{asset('images/user/Users_100x100.png')}}" alt="" loading="lazy">
                                             @endif
                                          </div>
                                          <div class=" w-100 ms-3">
                                             <h5 class="mb-0 ">{{$sender_info->first_name}} {{$sender_info->last_name}}</h5>
                                             <span class="block ml-2 text-sm text-gray-600 text-break">{{ $message }}</span>
                                             <small class="font-size-12">{{ $chat->updated_at->diffForHumans() }}</small>
                                          </div>
                                          @if(isset($data['allChats']['chatMessages']))
                                             @for($i = count($data['allChats']['chatMessages']) - 1; $i >= 0; $i--)
                                                @if(isset($data['allChats']['chatMessages'][$i]) && $data['allChats']['chatMessages'][$i] !== null)
                                                   @if($chat->id == $data['allChats']['chatMessages'][$i]->chat_id)
                                                      @if( $chat['chatmessages']->resp_user_id == $user->id)
                                                         @if( $chat['chatmessages']->resp_user_id == $user->id && $chat['chatmessages']->responseUserNewMsg == 0)
                                                            <div class="unreadChatDot">
                                                               <span style="background-color: var(--bs-primary); height: 8px;width: 8px;border-radius: 50%;display: inline-block;">
                                                            </div>
                                                         @endif
                                                         @if( $chat['chatmessages']->resp_user_id == $user->id && $chat['chatmessages']->senderUserNewMessage == 0)
                                                            <div class="unreadChatDot">
                                                               <span style="background-color: var(--bs-primary); height: 8px;width: 8px;border-radius: 50%;display: inline-block;">
                                                            </div>
                                                         @endif
                                                      @endif
                                                   @endif
                                                @endif
                                             @endfor
                                          @endif
                                       </div>
                                    </a>
                                 @endif
                              @empty
                              <div style="padding:20px;">
                                 <p style="display: flex; align-item:center;">
                                    <span class="material-symbols-outlined" style="padding-right:10px">chat</span> There are no messages to display.
                                 </p>
                              </div>
                              @endforelse
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="nav-item d-lg-none">
                     <a href="{{route('chat.index')}}" class="dropdown-toggle d-flex align-items-center" id="mail-drop-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-symbols-outlined">mail</i>
                        <span class="mobile-text  ms-3">Message</span>
                     </a>
                  </li>
                  <li class="nav-item dropdown d-none d-lg-block " >
                     <a href="javascript:void(0);" class="search-toggle dropdown-toggle d-flex align-items-center"  onclick="notificationReadBadge()" id="notification-drop" data-bs-toggle="dropdown">
                        <i class="material-symbols-outlined">notifications</i>
                        <div id="notificationBadgeReadFresh">@if($userNotificationBadgeRead > 0) <span id="notificationBadge" class="badge badge-pill position-absolute rounded-pill" style="background-color: var(--bs-primary); font-size:14px; bottom:40px; padding:2px 5px 20px 5px; height:17px; left:27px;"><p>{{$userNotificationBadgeRead}}</p></span> @endif</div>
                     </a>
                     <div class="sub-drop dropdown-menu avoideCloseDropdown" aria-labelledby="notification-drop">
                        <div  class="card shadow-none m-0" >
                           <div class="card-header d-flex justify-content-between bg-primary">
                              <div class="header-title bg-primary">
                                 <h5 class="mb-0 text-white">All Notifications</h5>
                              </div>
                           </div>
                           <div id="notification-area" class="card-body p-0" style="max-height: 80vh; height:auto; overflow-y: auto;">
                              @forelse($data['userNotifications'] as $userNotification)
                                 @php
                                    $url = $userNotification->url;
                                    $ids = explode("/", $url);
                                    $urlProfile = array_slice($ids, 0, 1);
                                    $urlProfileImp = isset($urlProfile[0]) ? $urlProfile[0] : null;
                                    $ids = array_slice($ids, 1);
                                    $id_string = implode("-", $ids);
                                    $encrypted_ids = base64_encode($id_string);
                                    $userName = User::find($userNotification->friend_id);
                                    if( $userName){
                                       $user_first_last_name = $userName->first_name . ' ' . $userName->last_name;

                                       if(str_contains($userNotification->message, 'Admins have approved your request to join') || str_contains($userNotification->message, 'An admin approved your post in'))
                                          $user_first_last_name = '';
                                       
                                    }
                                    if($urlProfileImp === 'profile' && is_numeric($ids[0])){
                                       $userNotificationUrl = user::select('username')->where('id', $ids[0])->first();
                                    }
                                    if(!isset($user_first_last_name)){
                                       $user_first_last_name = '';
                                    }
                                 @endphp
                                 @if(isset($userName))
                                    @if($userNotification->viewed == 1)
                                       <div class="iq-sub-card readNotificationsDropdown deleteNotification_{{$userNotification->id}}" >
                                          <div class="d-flex align-items-center justify-content-lg-between">
                                             <a href="@if($urlProfileImp === 'profile' && isset($userNotificationUrl->username)) /profile/{{$userNotificationUrl->username}} @elseif($urlProfileImp !== 'notificationDetails') /{{$userNotification->url}} @else /notificationDetails/{{ $encrypted_ids }} @endif" style="max-width: min-content; max-height: 40px;">   
                                                @if( in_array($userNotification->notification_type, ['join_group_private_request', 'join_group']))

                                                   @if (isset($userNotification['groupDetails']->cover_image) && $userNotification['groupDetails']->cover_image !== '')
                                                      <img class="avatar-40 rounded" src="{{asset('storage/images/group-img/'.$userNotification['groupDetails']->id . '/' . 'cover' . '/' . $userNotification['groupDetails']->cover_image)}}"alt="">
                                                   @else
                                                      <img class="avatar-40 rounded" src="{{asset('images/user/Banners-01.png')}}" alt="">
                                                   @endif
                                                   
                                                   
                                                @elseif( in_array($userNotification->notification_type, ['like_page']))
                                                   
                                                   @if (isset($userNotification['pageDetails']->profile_image) && $userNotification['pageDetails']->profile_image !== '')
                                                      <img class="avatar-40 rounded" src="{{asset('storage/images/page-img/'.$userNotification['pageDetails']->id.'/'.$userNotification['pageDetails']->profile_image)}}"alt="">
                                                   @else
                                                      <img class="avatar-40 rounded" src="{{asset('images/user/pageProfile.png')}}" alt="">
                                                   @endif

                                                @else
                                                   
                                                   @if (isset($userNotification->getUser->avatar_location) && $userNotification->getUser->avatar_location !== '')
                                                      <img class="avatar-40 rounded" src="{{ asset('storage/images/user/userProfileandCovers/' . $userNotification->getUser->id . '/' . $userNotification->getUser->avatar_location) }}"alt="">
                                                   @else
                                                      <img class="avatar-40 rounded" src="{{asset('images/user/Users_100x100.png')}}" alt="">
                                                   @endif

                                                @endif

                                                @if( in_array($userNotification->notification_type, ['group_feed_comment', 'group_feed_like', 'group_feed_comment_like', 'join_group_private_request', 'join_group']))
                                                   <span class="position-relative" style="right:-25px; bottom:18px"><i class="icon material-symbols-outlined material-symbols-outlined-filled text-white p-1 rounded-circle" style="background-color:#8c68cd; font-size:15px">groups</i></span>
                                                @elseif(in_array($userNotification->notification_type, ['like_page', 'page_feed_like', 'page_feed_comment', 'page_feed_comment_like']))
                                                   <span class="position-relative " style="right:-25px; bottom:18px"><i class="icon material-symbols-outlined material-symbols-outlined-filled text-white p-1 rounded-circle" style="background-color:#8c68cd; font-size:15px">flag</i></span>
                                                @else
                                                @endif

                                             </a>
                                             <a class="w-75" href="@if($urlProfileImp === 'profile' && isset($userNotificationUrl->username)) /profile/{{$userNotificationUrl->username}} @elseif($urlProfileImp !== 'notificationDetails') /{{$userNotification->url}} @else /notificationDetails/{{ $encrypted_ids }} @endif" >
                                                <div class="ms-3 w-100" style="max-width:fit-content">
                                                   <h6 class="mb-0 me-4" style="max-width:140px">{{$user_first_last_name.$userNotification->message}}</h6>
                                                   <div class="d-flex justify-content-between align-items-center">
                                                      <small class="float-right font-size-12">{{ $userNotification->created_at->diffForHumans() }}</small>
                                                   </div>
                                                </div>
                                             </a>
                                             <div style="max-width:20px; width:20px; min-width:20px" class="text-center">
                                                <div class="dropdown delete_notification_hover dropstart d-none">
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
                                       <div class="iq-sub-card unReadNotificationsDropdown deleteNotification_{{$userNotification->id}}">
                                          <div class="d-flex align-items-center justify-content-lg-between">
                                             <a href="@if($urlProfileImp === 'profile' && isset($userNotificationUrl->username)) /profile/{{$userNotificationUrl->username}} @elseif($urlProfileImp !== 'notificationDetails') /{{$userNotification->url}} @else /notificationDetails/{{ $encrypted_ids }} @endif" onclick="readNotification({{$userNotification->id}})" style="max-width: min-content; max-height: 40px;">
                                                @if(in_array($userNotification->notification_type, [ 'join_group_private_request', 'join_group']))
                                                   @if (isset($userNotification['groupDetails']->cover_image) && $userNotification['groupDetails']->cover_image !== '')
                                                      <img class="avatar-40 rounded" src="{{asset('storage/images/group-img/'.$userNotification['groupDetails']->id . '/' . 'cover' . '/' . $userNotification['groupDetails']->cover_image)}}"alt="">
                                                   @else
                                                      <img class="avatar-40 rounded" src="{{asset('images/user/Banners-01.png')}}" alt="">
                                                   @endif
                                                   
                                                @elseif(in_array($userNotification->notification_type, ['like_page']))
                                                   
                                                   @if (isset($userNotification['pageDetails']->profile_image) && $userNotification['pageDetails']->profile_image !== '')
                                                      <img class="avatar-40 rounded" src="{{asset('storage/images/page-img/'.$userNotification['pageDetails']->id.'/'.$userNotification['pageDetails']->profile_image)}}"alt="">
                                                   @else
                                                      <img class="avatar-40 rounded" src="{{asset('images/user/pageProfile.png')}}" alt="">
                                                   @endif

                                                @else
                                                   
                                                   @if (isset($userNotification->getUser->avatar_location) && $userNotification->getUser->avatar_location !== '')
                                                      <img class="avatar-40 rounded" src="{{ asset('storage/images/user/userProfileandCovers/' . $userNotification->getUser->id . '/' . $userNotification->getUser->avatar_location) }}"alt="">
                                                   @else
                                                      <img class="avatar-40 rounded" src="{{asset('images/user/Users_100x100.png')}}" alt="">
                                                   @endif

                                                @endif

                                                @if( in_array($userNotification->notification_type, ['group_feed_comment', 'group_feed_like', 'group_feed_comment_like', 'join_group_private_request', 'join_group']))
                                                   <span class="position-relative" style="right:-25px; bottom:18px"><i class="icon material-symbols-outlined material-symbols-outlined-filled text-white p-1 rounded-circle" style="background-color:#8c68cd; font-size:15px">groups</i></span>
                                                @elseif(in_array($userNotification->notification_type, ['like_page', 'page_feed_like', 'page_feed_comment', 'page_feed_comment_like']))
                                                   <span class="position-relative " style="right:-25px; bottom:18px"><i class="icon material-symbols-outlined material-symbols-outlined-filled text-white p-1 rounded-circle" style="background-color:#8c68cd; font-size:15px">flag</i></span>
                                                @else
                                                @endif

                                             </a>
                                             <a class="w-75" href="@if($urlProfileImp === 'profile' && isset($userNotificationUrl->username)) /profile/{{$userNotificationUrl->username}} @elseif($urlProfileImp !== 'notificationDetails') /{{$userNotification->url}} @else /notificationDetails/{{ $encrypted_ids }} @endif" onclick="readNotification({{$userNotification->id}})">
                                                <div class="ms-3 nootification-data" style="max-width:fit-content">
                                                   <h6 class="mb-0 me-4">{{$user_first_last_name.$userNotification->message}}</h6>
                                                   <div class="d-flex justify-content-between align-items-center">
                                                      <small class="float-right font-size-12">{{ $userNotification->created_at->diffForHumans() }}</small>
                                                   </div>
                                                </div>
                                             </a>
                                             <div class="unreadNotificationDot" style="max-width:20px; width:20px ; padding:0px 0px 0px 6px">
                                                <span style="background-color: var(--bs-primary); height: 8px;width: 8px;border-radius: 50%;display: inline-block;">
                                             </div>
                                             <div class="dropdown delete_notification_hover dropstart d-none" style="max-width:20px; width:20px">
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
                                 @endif
                              @empty
                              <div style="padding:20px;">
                                 <p style="display: flex; align-item:center;">
                                    <span class="material-symbols-outlined" style="padding-right:10px">notifications_off</span> There are no notifications to display.
                                 </p>
                             </div>
                              @endforelse
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="nav-item d-lg-none">
                     <a href="{{route('notification')}}" class="d-flex align-items-center">
                        <i class="material-symbols-outlined">notifications</i>
                        <span class="mobile-text  ms-3">Notifications</span>
                     </a>
                  </li>
                  <li class="nav-item dropdown d-none d-lg-block">
                     <a href="javascript:void(0);" class="d-flex align-items-center dropdown-toggle" id="drop-down-arrow" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(isset($user->avatar_location) && $user->avatar_location !== '')
                           <img src="{{ asset('storage/images/user/userProfileandCovers/'.$user->id.'/'.$user->avatar_location)}}" class="img-fluid rounded-circle me-3" width="100px" height="100px"  alt="user" loading="lazy">
                        @else
                           <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="img-fluid rounded-circle me-3" loading="lazy">
                        @endif
                        <div class="caption">
                           {{-- <h6 class="mb-0 line-height">@if($user){{$user->first_name.' '. $user->last_name}}@else User @endif</h6> --}}
                           <h6 class="mb-0 line-height">
                              @if($user)
                                {{substr($user->first_name, 0, 10).' '. substr($user->last_name, 0, 7)}}
                                @if(strlen($user->first_name) > 10 || strlen($user->last_name) > 7)
                                  ...
                                @endif
                              @else
                                User
                              @endif
                            </h6>
                        </div>
                     </a>
                     <div class="sub-drop dropdown-menu caption-menu" aria-labelledby="drop-down-arrow">
                        <div class="card shadow-none m-0">
                           <div class="card-header ">
                              <div class="header-title">
                                 <h5 class="mb-0 ">Hello @if($user){{$user->first_name}}@else User @endif</h5>
                              </div>
                           </div>
                           <div class="card-body p-0 ">
                              @if(isset($user) && $user->username != null && $user->username != '')
                                 <a href="{{route('user-profile',  ['username' => $user->username])}}" class="mb-0 h6">
                                    <div class="d-flex align-items-center iq-sub-card border-0">
                                    <span class="material-symbols-outlined">
                                          line_style
                                       </span>
                                       <div class="ms-3">
                                          My Profile
                                       </div>
                                    </div>
                                 </a>
                              @endif
                              <a href="{{route('profileedit')}}" class="mb-0 h6">
                                 <div class="d-flex align-items-center iq-sub-card border-0">
                                    <span class="material-symbols-outlined">
                                       edit_note
                                    </span>
                                    <div class="ms-3">
                                       Edit Profile
                                    </div>
                                 </div>
                              </a>
                              <a href="{{route('accountsetting')}}" class="mb-0 h6">
                                 <div class="d-flex align-items-center iq-sub-card border-0">
                                    <span class="material-symbols-outlined">
                                       manage_accounts
                                    </span>
                                    <div class="ms-3">
                                       Account Settings
                                    </div>
                                 </div>
                              </a>
                              <a href="{{route('privacysetting')}}" class="mb-0 h6">
                                 <div class="d-flex align-items-center iq-sub-card border-0">
                                    <span class="material-symbols-outlined">
                                       security
                                       </span>
                                    <div class="ms-3">
                                       Privacy Settings
                                    </div>
                                 </div>
                              </a>
                              {{-- <a href="{{route('myCourses')}}" class="mb-0 h6">
                                 <div class="d-flex align-items-center iq-sub-card border-0">
                                    <span class="material-symbols-outlined">
                                       library_books
                                    </span>
                                    <div class="ms-3">
                                       My Courses
                                    </div>
                                 </div>
                              </a>
                              <a href="{{route('team')}}" class="mb-0 h6">
                                 <div class="d-flex align-items-center iq-sub-card border-0">
                                    <span class="material-symbols-outlined">
                                       groups
                                    </span>
                                    <div class="ms-3">
                                       Team
                                    </div>
                                 </div>
                              </a>
                              <a href="{{route('marking')}}" class="mb-0 h6">
                                 <div class="d-flex align-items-center iq-sub-card border-0">
                                    <span class="material-symbols-outlined">
                                       lock
                                    </span>
                                    <div class="ms-3">
                                       Marking
                                    </div>
                                 </div>
                              </a> --}}
                              <a href="{{route('events')}}" class="mb-0 h6">
                                 <div class="d-flex align-items-center iq-sub-card border-0">
                                    <span class="material-symbols-outlined">
                                       lock
                                    </span>
                                    <div class="ms-3">
                                       My Events
                                    </div>
                                 </div>
                              </a>
                              {{-- <a href="{{route('my-invoices')}}" class="mb-0 h6">
                                 <div class="d-flex align-items-center iq-sub-card border-0">
                                    <span class="material-symbols-outlined">
                                       lock
                                    </span>
                                    <div class="ms-3">
                                       My Invoices
                                    </div>
                                 </div>
                              </a> --}}
                              <a href="{{route('generalsetting')}}" class="mb-0 h6">
                                 <div class="d-flex align-items-center iq-sub-card border-0">
                                    <span class="material-symbols-outlined">
                                       Settings
                                    </span>
                                    <div class="ms-3">
                                       General Settings
                                    </div>
                                 </div>
                              </a>
                              <form method="POST" action="{{route('logout')}}">
                                 @csrf
                              <a href="javascript:void(0)" class="mb-0 h6"
                                      onclick="event.preventDefault();
                                    this.closest('form').submit();">
                              <div class="d-flex align-items-center iq-sub-card">
                                 <span class="material-symbols-outlined">
                                    login
                                 </span>
                                 <div class="ms-3">
                                        {{ __('Sign out') }}
                                  </div>

                              </div>
                           </a>
                        </form>
                              {{-- <div class=" iq-sub-card">
                                 <h5>Chat Settings</h5>
                              </div>
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                  <i class="material-symbols-outlined text-success md-14">
                                    circle
                                 </i>
                                 <div class="ms-3">
                                    Online
                                 </div>
                              </div>
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <i class="material-symbols-outlined text-warning md-14">
                                    circle
                                 </i>
                                 <div class="ms-3">
                                    Away
                                 </div>
                              </div>
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                 <i class="material-symbols-outlined text-danger md-14">
                                    circle
                                 </i>
                                 <div class="ms-3">
                                    Disconnected
                                 </div>
                              </div>
                              <div class="d-flex align-items-center iq-sub-card border-0">
                                  <i class="material-symbols-outlined text-gray md-14">
                                    circle
                                 </i>
                                 <div class="ms-3">
                                    Invisible
                                 </div>
                              </div> --}}
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="nav-item d-lg-none">
                     @if(isset($user) && $user->username != null && $user->username != '')
                        <a href="{{route('user-profile',  ['username' => $user->username])}}" class="dropdown-toggle d-flex align-items-center">
                           <span class="material-symbols-outlined">person</span>
                           <span class="mobile-text  ms-3">Profile</span>
                        </a>
                     @endif
                  </li>

               </ul>

               @endif
            </div>


            <div class="bg-white border-top  top-header-responsive d-lg-none">
                <ul class="list-unstyled p-0 m-0 menu-list">
                   <li class="icon-class"><a href="{{route('home')}}" ><i class="material-symbols-outlined">home</i></a></li>
                   @if($user)
                      {{-- <li class="icon-class">
                         <div class="btn-group dropup">
                            <a href="#" data-bs-toggle="dropdown" aria-expanded="false" onclick="notificationReadBadge()">
                               <i class="material-symbols-outlined">notifications</i>
                               <span class="badge badge-pill position-absolute rounded-pill BadgeFresh" style="background-color: var(--bs-primary); font-size:14px; bottom:14px; padding:2px 5px 20px 5px; height:25px; left:12px;"><p>{{ $userNotificationBadgeRead }}</p></span>
                            </a> --}}
                            {{-- <ul class="dropdown-menu" >
                               <div class="header-title bg-primary">
                                  <h5 class="mb-0 text-white p-2">All Notifications</h5>
                               </div>
                               <li class="divDataRefresh" style="max-height: 70vh; height:auto; overflow-y: auto;">
                                     <div class="card-body p-2 " style="width: 265px !important;">
                                        @foreach($data['userNotifications'] as $userNotification)
                                           @php
                                                 $url = $userNotification->url;
                                                 $ids = explode("/", $url);
                                                 $urlProfile = array_slice($ids, 0, 1);
                                                 $urlProfileImp = isset($urlProfile[0]) ? $urlProfile[0] : null;
                                                 $ids = array_slice($ids, 1);
                                                 $id_string = implode("-", $ids);
                                                 $encrypted_ids = encrypt($id_string);
                                           @endphp
                                           @if($userNotification->viewed == 1)
                                                 <a href="@if($urlProfileImp == 'profile') /{{$userNotification->url}} @else/notificationDetails/{{ $encrypted_ids }}@endif"   class="iq-sub-card">
                                                    <div class="d-flex align-items-center">
                                                    <div class="">
                                                       @if ($userNotification->getUser === null)
                                                       <img class="avatar-40 rounded" src="{{asset('images/user/Users_60x60.png')}}" alt="">
                                                       @else
                                                             @if (isset($userNotification->getUser->avatar_location) && $userNotification->getUser->avatar_location !== '')
                                                                <img class="avatar-40 rounded" src="{{ asset('storage/images/user/userProfileandCovers/' . $userNotification->getUser->id . '/' . $userNotification->getUser->avatar_location) }}"alt="">
                                                             @else
                                                                <img class="avatar-40 rounded" src="{{asset('images/user/Users_60x60.png')}}" alt="">
                                                             @endif
                                                       @endif
                                                    </div>
                                                    <div class="ms-3 w-100">
                                                       <h6 class="mb-0 " style="opacity: 0.7;">{{$userNotification->message}}</h6>
                                                       <div class="d-flex justify-content-between align-items-center">
                                                             <small class="float-right font-size-12" style="opacity: 0.7;">{{ $userNotification->created_at->diffForHumans() }}</small>
                                                       </div>
                                                    </div>
                                                    </div>
                                                 </a>
                                                 <hr>
                                           @else
                                                 <a href="@if($urlProfileImp == 'profile') /{{$userNotification->url}} @else/notificationDetails/{{ $encrypted_ids }}@endif"   class="iq-sub-card">
                                                    <div class="d-flex align-items-center">
                                                       <div class="">
                                                             @if ($userNotification->getUser === null)
                                                             <img class="avatar-40 rounded" src="{{asset('images/user/Users_60x60.png')}}" alt="">
                                                             @else
                                                                @if (isset($userNotification->getUser->avatar_location) && $userNotification->getUser->avatar_location !== '')
                                                                   <img class="avatar-40 rounded" src="{{ asset('storage/images/user/userProfileandCovers/' . $userNotification->getUser->id . '/' . $userNotification->getUser->avatar_location) }}"alt="">
                                                                @else
                                                                   <img class="avatar-40 rounded" src="{{asset('images/user/Users_60x60.png')}}" alt="">
                                                                @endif
                                                             @endif
                                                       </div>
                                                       <div class="ms-3 w-100">
                                                             <h6 class="mb-0 ">{{$userNotification->message}}</h6>
                                                             <div class="d-flex justify-content-between align-items-center">
                                                                <small class="float-right font-size-12">{{ $userNotification->created_at->diffForHumans() }}</small>
                                                             </div>
                                                       </div>
                                                    </div>
                                                 </a>
                                                 <hr>
                                           @endif
                                        @endforeach
                                     </div>
                               </li>
                            </ul> --}}
                         {{-- </div> --}}

                         {{--<div class="sub-drop dropdown-menu" aria-labelledby="mobile-notification-drop">
                             <div id="notification-area" class="card shadow-none m-0" style="max-height: 85vh; height:auto; overflow-y: auto;">
                               <div class="card-header d-flex justify-content-between bg-primary"> --}}
                                  {{-- <small class="badge  bg-light text-dark">{{ $data['userNotificationsCount'] }}</small> --}}
                               {{-- </div>
                               <div class="card-body p-0">
                               </div>
                            </div>
                         </div> --}}
                      {{-- </li> --}}
                      <li class="icon-class"><a href="{{route('notification')}}" ><span class="material-symbols-outlined">notifications</span></a></li>
                      <li class="icon-class"><a href="{{route('friendrequest')}}" ><span class="material-symbols-outlined">group</span></a></li>
                      {{-- <li class="icon-class"><a href="{{route('group-1')}}" ><span class="material-symbols-outlined">group</span></a></li> --}}
                      <li class="icon-class"><a href="{{route('chats')}}" ><span class="material-symbols-outlined">mail</span></a></li>
                      @if(isset($user) && $user->username != null && $user->username != '')
                        <li class="icon-class"><a href="{{route('user-profile',  ['username' => $user->username])}}"><span class="material-symbols-outlined">person</span></a></li>
                      @endif
                      <li class="icon-class"><a href="{{route('accountDetails')}}"><span class="material-symbols-outlined">account_circle</span></a></li>
                      {{-- <li class="icon-class">
                        <div class="dropup">
                            <a href="javascript:void(0);" class="d-flex align-items-center dropdown-toggle py-1" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(isset($user->avatar_location) && $user->avatar_location !== '')
                                <img src="{{ asset('storage/images/user/userProfileandCovers/'.$user->id.'/'.$user->avatar_location)}}" class="img-fluid rounded-circle" width="20px" height="20px"  alt="user" loading="lazy">
                                @else
                                <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="img-fluid rounded-circle" loading="lazy">
                                @endif
                            </a>
                            <div class="sub-drop dropdown-menu caption-menu" aria-labelledby="drop-down-arrow">
                                <div class="card shadow-none m-0">
                                    <div class="card-header ">
                                        <div class="header-title">
                                            <h5 class="mb-0 ">Hello @if($user){{$user->first_name.' '. $user->last_name}}@else User @endif</h5>
                                        </div>
                                    </div>
                                <div class="card-body p-0 ">
                                    <div class="d-flex align-items-center iq-sub-card border-0">
                                        <span class="material-symbols-outlined">
                                            line_style
                                        </span>
                                        <div class="ms-3">
                                            <a href="{{route('user-profile',  ['username' => $user->username])}}" class="mb-0 h6">
                                            My Profile
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center iq-sub-card border-0">
                                        <span class="material-symbols-outlined">
                                            edit_note
                                        </span>
                                        <div class="ms-3">
                                            <a href="{{route('profileedit')}}" class="mb-0 h6">
                                            Edit Profile
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center iq-sub-card border-0">
                                        <span class="material-symbols-outlined">
                                            manage_accounts
                                        </span>
                                        <div class="ms-3">
                                            <a href="{{route('accountsetting')}}" class="mb-0 h6">
                                            Account Settings
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center iq-sub-card border-0">
                                        <span class="material-symbols-outlined">
                                            lock
                                        </span>
                                        <div class="ms-3">
                                            <a href="{{route('privacysetting')}}" class="mb-0 h6">
                                            Privacy Settings
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center iq-sub-card">
                                        <span class="material-symbols-outlined">
                                            login
                                        </span>
                                        <div class="ms-3"><form method="POST" action="{{route('logout')}}">
                                            @csrf
                                            <a href="javascript:void(0)" class="mb-0 h6"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                                {{ __('Sign out') }}
                                            </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                      </li> --}}

                   @endif
                </ul>
             </div>
      </div>
   </nav>

   <div class="chat-popup" id="myForm">
      <div id="cover-spin"></div>
      <div class="form-container">
         @if($user)
         <div class="modal-header top_chat_header">
            <div class="d-flex align-items-center">
               <div class="chat-profile me-3">
                  <img src="/images/user/Users_40x40.png" id="chatUserId" alt="chat-user" class="avatar-60 rounded-circle img-fluid">
               </div>
               <div class="chat-caption">
                  <a href="" id="chatReciverId"><h5 class="mb-0"></h5></a>
                  {{-- <p class="m-0">Web Designer</p> --}}
               </div>
            </div>
            <a class="lh-1" style="cursor: pointer" onclick="closeForm()">
               <span class="material-symbols-outlined">close</span>
            </a>
         </div>
         @endif
         {{-- <hr> --}}
         {{-- <div class="reciever " id="recieverdiv">
               {{-- <div class="msg rounded" id="messagess">
                  hi
               </div>
               <div class="time">
                  @php
                     $date = date('d-m-y h:i:s');
                     echo $date;
                  @endphp
               </div> --}}
            {{-- </div>
            <div class="sender" id="senderdiv">
               {{-- <div class="msg rounded">
                  testing here testing here testing here
               </div> --}}
               {{-- <div id="messages" class="msg rounded sender_messages"></div>
               <div class="time">
                  @php
                     $date = date('d-m-y h:i:s');
                     echo $date;
                  @endphp
               </div> --}}
            {{-- </div> --}}
         <div>
            <div class="chat_wrapper" id="refreshChat">
  
           </div>
           <div class="toogle-chat-tobottom"></div>
         </div>
         <form class="chat-message-send">@csrf
            <div class="align-items-center d-flex ">
               <div class="like-data">
                  <div class="dropdown">
                     <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                        {{-- <img src="{{asset('images/icon/1.png')}}" alt="story-img" class="img-fluid" class="img-fluid" alt=""> --}}
                        {{-- <a href="#" class="d-flex align-items-center pe-3"> <svg class="icon-24" width="24" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_156_599)">
                              <path d="M20.4853 4.01473C18.2188 1.74823 15.2053 0.5 12 0.5C8.79469 0.5 5.78119 1.74823 3.51473 4.01473C1.24819 6.28119 0 9.29469 0 12.5C0 15.7053 1.24819 18.7188 3.51473 20.9853C5.78119 23.2518 8.79469 24.5 12 24.5C15.2053 24.5 18.2188 23.2518 20.4853 20.9853C22.7518 18.7188 24 15.7053 24 12.5C24 9.29469 22.7518 6.28119 20.4853 4.01473ZM12 23.0714C6.17091 23.0714 1.42856 18.3291 1.42856 12.5C1.42856 6.67091 6.17091 1.92856 12 1.92856C17.8291 1.92856 22.5714 6.67091 22.5714 12.5C22.5714 18.3291 17.8291 23.0714 12 23.0714Z" fill="currentcolor"></path>
                              <path d="M9.40398 9.3309C8.23431 8.16114 6.33104 8.16123 5.16136 9.3309C4.88241 9.60981 4.88241 10.0621 5.16136 10.3411C5.44036 10.62 5.89266 10.62 6.17157 10.3411C6.78432 9.72836 7.78126 9.7284 8.39392 10.3411C8.53342 10.4806 8.71618 10.5503 8.89895 10.5503C9.08171 10.5503 9.26457 10.4806 9.40398 10.3411C9.68293 10.0621 9.68293 9.60986 9.40398 9.3309Z" fill="currentcolor"></path>
                              <path d="M18.8384 9.3309C17.6688 8.16123 15.7655 8.16114 14.5958 9.3309C14.3169 9.60981 14.3169 10.0621 14.5958 10.3411C14.8748 10.62 15.3271 10.62 15.606 10.3411C16.2187 9.72836 17.2156 9.72831 17.8284 10.3411C17.9679 10.4806 18.1506 10.5503 18.3334 10.5503C18.5162 10.5503 18.699 10.4806 18.8384 10.3411C19.1174 10.0621 19.1174 9.60986 18.8384 9.3309Z" fill="currentcolor"></path>
                              <path d="M18.3335 13.024H5.6668C5.2723 13.024 4.95251 13.3438 4.95251 13.7383C4.95251 17.6243 8.11409 20.7859 12.0001 20.7859C15.8862 20.7859 19.0477 17.6243 19.0477 13.7383C19.0477 13.3438 18.728 13.024 18.3335 13.024ZM12.0001 19.3573C9.14366 19.3573 6.77816 17.215 6.42626 14.4525H17.574C17.2221 17.215 14.8566 19.3573 12.0001 19.3573Z" fill="currentcolor"></path>
                        </g>
                        <defs>
                              <clipPath>
                                 <rect width="24" height="24" fill="white" transform="translate(0 0.5)"></rect>
                              </clipPath>
                        </defs>
                        </svg>
                        </a> --}}
                        <a href="javascript:void(0);" class="material-symbols-outlined  me-3">
                           sentiment_satisfied
                        </a>
                     </span>
                     <div class="dropdown-menu py-2 emojis">
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#x1F600;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128513;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128514;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128515;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128516;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128517;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128518;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128519;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128520;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128521;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128522;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128523;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128524;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128525;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128526;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128527;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128528;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128529;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128530;</a>
                        <a class="ms-2 emojisStyleChat" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128531;</a>
                     </div>
                  </div>
               </div>
               @if($user)
            <div class="rounded message_wrapper " style="width: 90%">
               <input type="hidden" value={{auth()->user()->id}} name="userSenderId" id="userSenderId" class="form-control rounded">
               <input type="hidden" value="" name="userRecieverId" id="userRecieverId" class="form-control rounded">
               <input type="hidden" value="User" name="message_type" id="message_type" class="form-control rounded">
               <input class="form-control  message_field" name="message" id="message" placeholder="Type something ..."/>
                  {{-- <input class="form-control  message_field" name="message" id="message" onkeydown="if (event.keyCode == 13) {sendMessage(this.value,document.getElementById('userSenderId').value,document.getElementById('userRecieverId').value)}" placeholder="Type something ..." /> --}}
                  <button type="submit" class="border-0 bg-transparent">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="#418ffe">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                     </svg>
                  </button>

               </span>
               </div>
               @endif
            </div>
         </form>
      </div>
   </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    @if($user)
    <script>

       $(function() {
          $(".emojisStyleChat").click(function() {
             $('#message').val($('#message').val() + $(this).html());
          });
       });
       function openFormUser(chatId, userId) {
          document.getElementById('btnOpenFormUser').classList.add("d-none");
          document.getElementById('btnOpenForm').classList.remove("d-none");

          this.createAndFetchChats(chatId,userId);
       }

       function createAndFetchChats(chatId,userId){
          $.ajax({
             method: 'POST',
             url: '/createAndFetchChats',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: { chatId: chatId,userId: userId},
             success: function (data) {
                const userIDs = data.fetchChat.user_ids.split(',');
                var userId1 = userIDs[0];
                var userId2 = userIDs[1];
                openForm(data.fetchChat.id, userId2);
             }
          });
      }

      function openForm(chatId, userId) {
         if (typeof fetchchatInterval !== "undefined") {
            $('#refreshChat').scrollTop(0);
            clearInterval(fetchchatInterval);
         }
         document.getElementById("myForm").style.display = "block";
         $('#cover-spin').show();
         $('#message').focus();
         var scrollPos = $('#refreshChat').prop('scrollHeight');
         fetchchatInterval = setInterval(function() {
            var scrollPos = $('#refreshChat').scrollTop();
            fetchChats(chatId,scrollPos);
            $('#refreshChat').scrollTop(scrollPos);
         }, 5000);
         var scrollPos = 'openChatModal';
         this.fetchChats(chatId,scrollPos);
      }

      let messageLength = 0;
      function fetchChats(id,scrollPos) {
         $.ajax({
            method: 'POST',
            url: '/fetchChats',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id},
            success: function (data) {
               let messages = data.chat.original.user_chat;
               let newMessageLength = messages.length;
               if (newMessageLength != messageLength) {
                  $('#cover-spin').hide();
                  $("#refreshChat").empty();
                  var userdata = data.chat.original.user_chat[0];
                  var user_data_1 = data.chat.original.user_data_1;
                  var userName = data.chat.original.user_data_1.first_name+' '+data.chat.original.user_data_1.last_name;
                  const userIDs = userdata.user_ids.split(',');
                  var userId1 = userIDs[0];
                  var userId2 = userIDs[1];
                  var authUserId = {!! auth()->user()->id !!};
                  var userRecieverId = document.getElementById("#userRecieverId");
                  if(authUserId == userId1){
                     $("#userRecieverId").val(userId2);
                  }else{
                     $("#userRecieverId").val(userId1);
                  }
                  $(".chat-caption h5").html(userName);
                  document.getElementById("chatReciverId").href="/profile/"+user_data_1.username;
                  if(user_data_1.avatar_location && user_data_1.avatar_location !== '')
                  {
                     document.getElementById("chatUserId").src="/storage/images/user/userProfileandCovers/"+user_data_1.id+'/'+user_data_1.avatar_location;
                  }
                  else{
                     document.getElementById("chatUserId").src="/images/user/Users_100x100.png";
                  }
                  var today = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                  var lastDateDisplayed = null;
                  // Check New Message If scroll Chat End
                  // var refreshChatPositionVal = $('#refreshChat').scrollTop();
                  // var refreshChatPosition = $('#refreshChat')[0].scrollHeight - $('#refreshChat').height();
                  // if(refreshChatPositionVal < refreshChatPosition){
                  //    scrollPos = $('#refreshChat').scrollTop() + 1000;
                  // }

                  messages.forEach(function (message) {
                     if (message.last_message !== null && message.message !== undefined ) {
                        var messageDate = new Date(message.chat_message_create_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

                        if (messageDate !== lastDateDisplayed) {
                           $('.chat_wrapper').append('<div class="date text-center">' + (messageDate == today ? 'Today' : messageDate) + '</div>');
                           lastDateDisplayed = messageDate;
                        }
                        if (authUserId == message.user_id) {
                           if(message.deleted_from_sender !== 'Y'){
                              $('.chat_wrapper').append('<div class="sender align-items-stretch senderdiv chat_message_id_' + message.chat_message_id + '"><div class="dropdown delete_message_hover" ><button class="border-0 bg-transparent" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg height="22px" viewBox="0 0 22 22" width="22px"><circle cx="11" cy="6" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle><circle cx="11" cy="11" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle><circle cx="11" cy="16" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle></svg></button><ul class="dropdown-menu p-1" style="min-width:auto" aria-labelledby="dropdownMenuButton"><li><button class="btn btn-primary dropdown-item m-0 px-1 py-0" type="submit" onclick="delete_chat_message('+ message.chat_message_id +')">Remove</button></li></ul></div><div  style=""><div class="msg rounded sender_messages">' + message.message + '</div><div class="time message_time text-end">' +  new Date(message.chat_message_create_at).toLocaleTimeString([], {hour12: true, hourCycle: 'h23', hour: '2-digit', minute:'2-digit'}) + '</div></div></div>');
                              $('.sender').hover(function() {
                                 $(this).find('.delete_message_hover').show();
                              }, function() {
                                 $(this).find('.delete_message_hover').hide();
                              });
                           }
                        } else {
                           if(message.deleted_from_receiver !== 'Y'){
                              $('.chat_wrapper').append('<div class="reciever recieverdiv chat_message_id_' + message.chat_message_id + '"><div><div class="msg rounded sender_messages">' + message.message + '</div><div class="time message_time ">' +  new Date(message.chat_message_create_at).toLocaleTimeString([], {hour12: true, hourCycle: 'h23', hour: '2-digit', minute:'2-digit'}) + '</div></div></div>');
                           }
                        }
                     }
                  });
                  
                  chatScrollToBottom();

                  messageLength = newMessageLength;
                 
                  if(scrollPos == 'openChatModal'){
                     var scrollPosEnd = document.querySelector('#refreshChat');
                     scrollPosEnd.scrollTop = scrollPosEnd.scrollHeight - scrollPosEnd.clientHeight;
                  }else{
                     $('#refreshChat').scrollTop(scrollPos);
                  }
               }
            }
         });
         // setInterval(refreshChats(id), 5000);
      }
      
      $("#refreshChat").on('scroll', function () {
         var refreshChatPositionVal = $('#refreshChat').scrollTop() + 50;
         var refreshChatPosition = $('#refreshChat')[0].scrollHeight - $('#refreshChat').height()

         if(refreshChatPositionVal < refreshChatPosition){
            console.log('if', refreshChatPositionVal , refreshChatPosition);
            $(".toogle-chat-tobottom").empty();
            $('.toogle-chat-tobottom').append('<span class="material-symbols-outlined position-absolute chat-bottom-toggle" onclick="showBottomChat()">arrow_downward</span>')
         }else{
            console.log('else', refreshChatPositionVal , refreshChatPosition);
            $(".toogle-chat-tobottom").empty();
            showBottomChat();
         }
      });

      function chatScrollToBottom() {
         var refreshChatPositionVal = $('#refreshChat').scrollTop() + 100;
         var refreshChatPosition = $('#refreshChat')[0].scrollHeight - $('#refreshChat').height()

         if(refreshChatPositionVal < refreshChatPosition){
            $(".toogle-chat-tobottom").empty();
            $('.toogle-chat-tobottom').append('<span class="material-symbols-outlined position-absolute chat-bottom-toggle" onclick="showBottomChat()">arrow_downward</span>')
         }else{
            $(".toogle-chat-tobottom").empty();
            $('#refreshChat').scrollTop($('#refreshChat').prop('scrollHeight'));
         }
      };

      function showBottomChat() {
         $('#refreshChat').scrollTop($('#refreshChat').prop('scrollHeight'));
      }

       function refreshChats(chatId) {
          setInterval(fetchChats(chatId), 5000);
       }

       function closeForm() {
            messageLength = 0;
            $('#refreshChat').scrollTop(0);
            $("#myForm").hide().load(" #myForm"+"> *").fadeIn(0);
            document.getElementById("myForm").style.display = "none";
            clearInterval(fetchchatInterval);
       }

       $(document).on('submit', 'form.chat-message-send', function(e) {
            event.preventDefault();
            var form = $(this);
            var getValue= document.getElementById("message");
            if(getValue.value != null && getValue.value.trim() !== ''){
               $.ajax({
                  method: 'POST',
                  url: '/storeChat',
                  data: form.serialize(),
                  success: function (data) {
                     $('.chat_wrapper').append('<div class="sender align-items-stretch senderdiv chat_message_id_' + data.id  + '"><div class="dropdown delete_message_hover"><button class="border-0 bg-transparent" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg height="22px" viewBox="0 0 22 22" width="22px"><circle cx="11" cy="6" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle><circle cx="11" cy="11" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle><circle cx="11" cy="16" fill="var(--bs-primary)" r="2" stroke-width="1px"></circle></svg></button><ul class="dropdown-menu p-1" style="min-width:auto" aria-labelledby="dropdownMenuButton"><li><button class="btn btn-primary dropdown-item m-0 px-1 py-0" type="submit" onclick="delete_chat_message('+ data.id +')">Remove</button></li></ul></div><div  style=""><div class="msg rounded sender_messages">' + data.message + '</div><div class="time message_time text-end">' +  data.time + '</div></div></div>');
                     $('.sender').hover(function() {
                     $(this).find('.delete_message_hover').show();
                     }, function() {
                     $(this).find('.delete_message_hover').hide();
                     });
                     $('#refreshChat').scrollTop($('#refreshChat').prop('scrollHeight'));
                     getValue.value = "";
                  }
               });
            }
         });

       function userSearch(keyword) {
          $.ajax({
             method: 'GET',
             url: '/search-results',
             data: {search_input: keyword}
          }).done(function (response) {
             let result = '';
             let src = '';
             if(response.searchData.users.length === 0 && response.searchData.groups.length === 0 && response.searchData.pages.length === 0) {
                result = '<div class="d-flex align-items-center border-bottom search-hover py-2 px-3"><div class="flex-shrink-0"><span> No Result found </span></div></div>';
             } else {
                response.searchData.users.forEach(function(userData) {
                   if(userData.avatar_location != null && userData.avatar_location !== ''){
                      src = '/storage/images/user/userProfileandCovers/'+userData.id+'/'+userData.avatar_location;
                   }else{
                      src = '/images/user/Users_40x40.png';
                   }
                   result += '<div class="d-flex align-items-center border-bottom search-hover py-2 px-3"><div class="flex-shrink-0"><img src="'+src+'" class="align-self-center img-fluid avatar-50 rounded-pill" alt="#"></div><div class="d-flex flex-column ms-3"><a href="/profile/'+userData.username+'" class="h5">'+userData.first_name+ ' '+userData.last_name +'</a><span>'+userData.username +'</span></div><div class="d-flex align-items-center ms-auto"></div></div>';
                });
                response.searchData.groups.forEach(function(groupsData) {
                   if(groupsData.cover_image != null && groupsData.cover_image !== ''){
                     src = '/storage/images/group-img/'+groupsData.id+'/cover/'+groupsData.cover_image;
                   }else{
                      src = '/images/user/groupProfile.png';
                   }
                   result += '<div class="d-flex align-items-center border-bottom search-hover py-2  px-3"><div class="flex-shrink-0"><img src="'+src+'" class="align-self-center img-fluid avatar-50 rounded-pill" alt="#"></div><div class="d-flex flex-column ms-3"><a href="/groupdetail/'+groupsData.id+'" class="h5">'+groupsData.group_name+ '</a></div><div class="d-flex align-items-center ms-auto"><p class="me-3 d-flex align-items-center mt-3"><small>Group</small> </p></div></div>';
                });
                response.searchData.pages.forEach(function(pagesData) {
                   if(pagesData.profile_image != null && pagesData.profile_image !== ''){
                     src = '/storage/images/page-img/'+pagesData.id+'/'+pagesData.profile_image;
                   }else{
                      src = '/images/user/pageProfile.png';
                   }
                   result += '<div class="d-flex align-items-center border-bottom search-hover py-2 px-3"><div class="flex-shrink-0"><img src="'+src+'" class="align-self-center img-fluid avatar-50 rounded-pill" alt="#"></div><div class="d-flex flex-column ms-3"><a href="/pagedetail/'+pagesData.id+'" class="h5">'+pagesData.page_name+ '</a></div><div class="d-flex align-items-center ms-auto"><p class="me-3 d-flex align-items-center mt-3"><small>Page</small> </p></div></div>';
                });
             }
             document.querySelector('.search-result-box ').innerHTML = result;
             document.querySelector('.search-result-box-sm').innerHTML = result;
          });
       }

       document.addEventListener(
          "click",
          function(event) {
             if (!event.target.closest(".modal-content")) {
               closeModal()
             }else{
               document.querySelector(".search-modal").classList.add('show');
               modalBackdrop = document.querySelector(".modal-backdrop");
               if(modalBackdrop){
                  modalBackdrop.style.display = "block";
               }
             }
          },
          false
       )

       function closeModal() {
          document.querySelector(".search-modal").classList.remove('show');
          document.querySelector(".search-modal").style.display = "none";
          // document.querySelector(".modal-backdrop").style.display = "none";
       }

       function openModel(){
          let modalBox = document.getElementById('search_input').value;
          if(modalBox.length <= 0 || modalBox.innerHTML == ''){
             document.querySelector("#exampleModalFullscreenSm").classList.remove('show');
             document.querySelector(".search-modal").style.display = "none";
          }else{
             document.querySelector("#exampleModalFullscreenSm").classList.add('show');
             document.querySelector(".search-modal").style.display = "block";
          }
          console.log(modalBox, 'length:',modalBox.length);
          document.querySelector(".search-modal").classList.add('show');
          document.querySelector(".search-modal").style.display = "block";
          // document.querySelector(".modal-backdrop").style.display = "block";

    }
    function searchEnter(){
      keyword = $('#search_input_put_value').val();
      $('#search_input').val(keyword);
      
      if(keyword != '' && keyword != null)                     
         document.getElementById("searchForm").submit();
    }
    
    function searchFunction(event, keyword) {
      
         let modalBox = document.getElementById('search_input').value;
         if(modalBox.innerHTML != ''){  console.log('buttons pressed')
            document.querySelector("#exampleModalFullscreenSm").classList.add('show');
            document.querySelector(".search-modal").style.display = "block";
         }
         if (event.keyCode == 13) {
            
            if(keyword == '' || keyword == null){
               event.preventDefault();
               return; 
            }
            
            $('#search_input').val(keyword);
            
            if(keyword != '' && keyword != null)
               document.getElementById("searchForm").submit();

         }
      
    }

 </script>
 <script>
   function navSearchbarSm(){
      var navSearchbarSmBtn = $('#nav-searchbar-sm-btn');
      var navSearchbarSmModal = $('#nav-searchbar-sm-modal');
      if (navSearchbarSmModal.hasClass('d-none') && navSearchbarSmBtn.hasClass('d-block')) {
         navSearchbarSmModal.removeClass('d-none');
         navSearchbarSmModal.addClass('d-block');

         $("body").css("overflow", "hidden");

         navSearchbarSmBtn.addClass('d-none');
         navSearchbarSmBtn.removeClass('d-block');
      } else {
         navSearchbarSmModal.removeClass('d-block');
         navSearchbarSmModal.addClass('d-none');

         $("body").css("overflow", "auto");
         
         navSearchbarSmBtn.removeClass('d-none');
         navSearchbarSmBtn.addClass('d-block');
      }
   }
    function approveRequest(user_id) {
       $.ajax({
          method: 'GET',
          url: '/user-confirm/'+user_id,
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
       }).done(function (response) {
          document.querySelector('.sub-drop-large').classList.add('show');
         //  $('#hide-response-count').addClass('d-none');
         //  $('#show-response-count').removeClass('d-none');
         //  document.getElementById("show-response-count").innerHTML = response.requestCount;
          $('#hide-friend-request'+user_id).addClass('d-none');
       });
    }


    function disapproveRequest(reqID, userId) {
       $.ajax({
          method: 'GET',
          url: '/user-delete/'+reqID,
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
       }).done(function (response) {
          document.querySelector('.sub-drop-large').classList.add('show');
         //  $('#hide-response-count').addClass('d-none');
         //  $('#show-response-count').removeClass('d-none');
         //  document.getElementById("show-response-count").innerHTML = response.requestCount;
          $('#hide-friend-request'+userId).addClass('d-none');

       });
    }

   function readNotification(id){
      $.ajax({
          method: 'GET',
          url: '/readnotification/'+id,
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
       }).done(function (response) {
       });
   }
   function delete_chat_message(chatMessageId) {
       $.ajax({
          method: 'GET',
          url: '/delete-message/'+chatMessageId,
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
       }).done(function (response) {
          $('.chat_message_id_'+chatMessageId).addClass('d-none');
       });
    }

    function chatReadBadge()
   {
    $('#chatBadgeReadFresh').html('')
    updateChatData()
      $.ajax({
         method: 'GET',
         url: "/chatreadbadge",
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
      })
   }
   function friendRequestReadBadge()
   {
    $('#friendRequestBadgeReadFresh').html('');
    updateFriendRequestData();
      $.ajax({
         method: 'GET',
         url: "/friendrequestreadbadge",
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
      })
   }

 </script>
 @endif
</div>
