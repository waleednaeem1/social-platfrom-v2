@php
   use App\Models\User;
   use App\Models\Group;
   use App\Models\GroupMembers;
   use App\Models\Page;
   use App\Models\PageMembers;
   use App\Models\FriendRequest;
   use App\Models\Friend;
   use Carbon\Carbon;
   $user = auth()->user();
   
   $userData = User::find(auth()->user()->id);
   $friends['friendsList'] = $userData->getAllFriends(['user_id' => $user->id])->take(20)->sortByDesc('created_at');

   $data['pages'] = Page::whereDoesntHave('pageMembersData', function($query) use ($user){
      $query->where('user_id', $user->id);
   })->where([['status', 'Y'],['admin_user_id', '!=', $user->id]])->inRandomOrder()->get();

   $pageIds = $data['pages']->pluck('id');
   $pageMembers = PageMembers::whereIn('page_id', $pageIds)->groupBy('user_id')->pluck('user_id');

   $data['groups'] = Group::with('privateGroupRequest')->whereDoesntHave('groupMembersData', function($query) use ($user){
      $query->where('user_id', $user->id);
   })->where([['status', 'Y'],['admin_user_id', '!=', $user->id]])->inRandomOrder()->get();

   $groupIds = $data['groups']->pluck('id');
   $groupMembers = GroupMembers::whereIn('group_id', $groupIds)->groupBy('user_id')->pluck('user_id');

   $peopleAll = collect($pageMembers)->merge($groupMembers)->unique();      
   $suggestedPeoples = User::whereIn('id', $peopleAll)->take(100)->whereNotNull('username')->where('username', '<>', '')->get();

   $i = 0;
   foreach($suggestedPeoples as $suggestedPeople){
      $FriendRequest = FriendRequest::whereIn('user_id', [$suggestedPeople->id, auth()->user()->id])->whereIn('friend_id', [$suggestedPeople->id, auth()->user()->id])->first();

      $Friends = Friend::whereIn('user_id', [$suggestedPeople->id, auth()->user()->id])->whereIn('friend_id', [$suggestedPeople->id, auth()->user()->id])->first();

      if(!isset($FriendRequest) && !isset($Friends)){
            $suggestedPeoplesAll[$i] =  $suggestedPeople;
      }
      $i++;
   }

   $suggestedPeoplesAll = empty($suggestedPeoplesAll) ? [] : $suggestedPeoplesAll;

   $data['suggestedUsers'] = collect($suggestedPeoplesAll)->take(20)->sortByDesc('created_at')->shuffle();
   $data['suggestedGroupsPages'] = collect($data['pages'])->merge($data['groups'])->shuffle()->take(20)->sortByDesc('created_at');

   // Style 
   $PGHeight = '18vh';
   $FHeight = '40vh';
   $PHeight = '27vh';
   
   if($data['suggestedUsers']->count() < 1){
      $PGHeight = '43vh';
      $FHeight = '43vh';
   }
   if($data['suggestedGroupsPages']->count() < 1){
      $PHeight = '43vh';
      $FHeight = '43vh';
   }
   if($friends['friendsList']->count() < 1){
      $PHeight = '43vh';
      $PGHeight = '43vh';
   }
   if($data['suggestedUsers']->count() < 1 && $data['suggestedGroupsPages']->count() < 1){
      $FHeight = '90vh';
   }
   if($data['suggestedUsers']->count() < 1 && $friends['friendsList']->count() < 1){
      $PGHeight = '90vh';
   }
   if($data['suggestedGroupsPages']->count() < 1 && $friends['friendsList']->count() < 1){
      $PHeight = '90vh';
   }
  

@endphp

@if($user)

<div class="right-sidebar-mini right-sidebar">
   <div class="right-sidebar-panel p-0">
      <div class="card shadow-none bg-transparent">
         <div class="card-body p-0">
            @if($data['suggestedUsers']->count() >= 1)
               <div class="card-header d-flex justify-content-between py-2">
                  <div class="header-title">
                      <h5 class="card-title" style="font-weight: bold;">Suggested People</h5>
                  </div>
               </div>
               <div class="media-height p-3" data-scrollbar="init" style="max-height:{{$PHeight}} !important">
                  @foreach($data['suggestedUsers'] as $randomFriend)
                     @if ($randomFriend->username)
                        <a href="{{route('user-profile',  ['username' => $randomFriend->username])}}">
                     @endif
                           <div class="d-flex align-items-center mb-4">
                              <div class="iq-profile-avatar @if(isset($randomFriend->last_online_at) && Carbon::parse($randomFriend->last_online_at)->diffInMinutes(Carbon::now()->diffForHumans()) <= 5) status-online @endif">
                                 @php 
                                    $file_path = public_path('storage/images/user/userProfileandCovers/'.$randomFriend->id.'/'.$randomFriend->avatar_location);
                                 @endphp
                                 @if(isset($randomFriend->avatar_location)  && is_file($file_path))
                                       <img class="rounded-circle avatar-50" src="{{ asset('storage/images/user/userProfileandCovers/'.$randomFriend->id.'/'.$randomFriend->avatar_location) }}" alt="" loading="lazy">
                                 @else
                                       <img class="rounded-circle avatar-50" src="{{asset('images/user/Users_60x60.png')}}" alt="" loading="lazy">
                                 @endif
                              </div>
                              @if (isset($randomFriend))
                              <div class="ms-3">
                                 {{-- <h6 class="mb-0">{{$randomFriend->first_name}}</h6> --}}
                                 <h6 class="mb-0">{{ $randomFriend->first_name . ' ' . (strlen($randomFriend->last_name) > 4 ? substr($randomFriend->last_name, 0, 4) . '...' : $randomFriend->last_name) }}</h6>
                                 @if(isset($randomFriend->last_online_at) && Carbon::parse($randomFriend->last_online_at)->diffInMinutes(Carbon::now()->diffForHumans()) <= 5) <p class="mb-0"> Active </p> @elseif(isset($randomFriend->last_online_at)) <p class="mb-0 text-dark"> {{Carbon::parse($randomFriend->last_online_at)->diffForHumans()}} </p> @else <p class="mb-0 text-dark"> A long time ago </p> @endif
                              </div>
                              @endif
                           </div>
                        </a>
                  @endforeach
               </div>
            @endif
            @if($data['suggestedGroupsPages']->count() >= 1)
               <div class="card-header d-flex justify-content-between border-top py-2">
                  <div class="header-title">
                      <h5 class="card-title" style="font-weight: bold;">Suggested Groups & Pages</h5>
                  </div>
               </div>
               <div class="media-height p-3" data-scrollbar="init" style="max-height:{{$PGHeight}} !important">
                  @foreach ($data['suggestedGroupsPages'] as $groupPage)
                     @if(isset($groupPage->group_name))
                        <a href="{{ route('groupdetail', $groupPage->id) }}">
                           <div class="d-flex align-items-center mb-4">
                              <div class="">
                                 @php 
                                    $file_path = public_path('storage/images/group-img/' . $groupPage->id . '/' . 'cover' . '/' . $groupPage->cover_image);
                                 @endphp
                                 @if(isset($groupPage->cover_image) && $groupPage->cover_image !== '' && is_file($file_path))
                                       <img class="rounded-circle avatar-50" src="{{ asset('storage/images/group-img/' . $groupPage->id . '/' . 'cover' . '/' . $groupPage->cover_image) }}" alt="" loading="lazy">
                                 @else
                                       <img class="rounded-circle avatar-50" src="{{ asset('images/group-img/Banners-1488.png') }}" alt="" loading="lazy">
                                 @endif
                              </div>
                              @if (isset($groupPage))
                              <div class="ms-3 d-flex flex-column">
                                 {{-- <h6 class="mb-0">{{$friend->first_name}}</h6> --}}
                                 <h6 class="mb-0">{{ (strlen($groupPage->group_name) > 12 ? substr($groupPage->group_name, 0, 12) . '...' : $groupPage->group_name) }}</h6>
                                 <small class="mb-0">Group</small>
                              </div>
                              @endif
                           </div>
                        </a>
                     @else
                        <a href="{{ route('pagedetail', $groupPage->id) }}">
                           <div class="d-flex align-items-center mb-4">
                              <div class="">
                                 @php 
                                    $file_path = public_path('storage/images/page-img/' . $groupPage->id . '/' . $groupPage->profile_image);
                                 @endphp
                                 @if (isset($groupPage->cover_image) && $groupPage->cover_image !== '' && is_file($file_path))
                                       <img class="rounded-circle avatar-50" src="{{ asset('storage/images/page-img/' . $groupPage->id . '/' . $groupPage->profile_image) }}" alt="" loading="lazy">
                                 @else
                                       <img class="rounded-circle avatar-50" src="{{ asset('images/user/Banners-03.png') }}" alt="" loading="lazy">
                                 @endif
                              </div>
                              @if (isset($groupPage))
                              <div class="d-flex flex-column ms-3">
                                 {{-- <h6 class="mb-0">{{$friend->first_name}}</h6> --}}
                                 <h6 class="mb-0 w-100">{{ (strlen($groupPage->page_name) > 12 ? substr($groupPage->page_name, 0, 12) . '...' : $groupPage->page_name) }}</h6>
                                 <small class="mb-0">Page</small>
                              </div>
                              @endif
                           </div>
                        </a>
                     @endif
                  @endforeach
               </div>
            @endif
            @if($friends['friendsList']->count() >= 1)
               <div class="card-header d-flex justify-content-between border-top py-2">
                  <div class="header-title">
                      <h5 class="card-title" style="font-weight: bold;">Friends</h5>
                  </div>
               </div>
               <div class="media-height p-3" data-scrollbar="init" style="max-height: {{$FHeight}} !important">
                  @foreach($friends['friendsList'] as $friend)
                     @if ($friend->username)
                        <a href="{{route('user-profile',  ['username' => $friend->username])}}">
                     @endif
                           <div class="d-flex align-items-center mb-4">
                              <div class="iq-profile-avatar @if(isset($friend->last_online_at) && Carbon::parse($friend->last_online_at)->diffInMinutes(Carbon::now()->diffForHumans()) <= 5) status-online @endif">
                                 @php 
                                    $file_path = public_path('storage/images/user/userProfileandCovers/'.$friend->id.'/'.$friend->avatar_location);
                                 @endphp
                                 @if(isset($friend->avatar_location)  && is_file($file_path))
                                       <img class="rounded-circle avatar-50" src="{{ asset('storage/images/user/userProfileandCovers/'.$friend->id.'/'.$friend->avatar_location) }}" alt="" loading="lazy">
                                 @else
                                       <img class="rounded-circle avatar-50" src="{{asset('images/user/Users_60x60.png')}}" alt="" loading="lazy">
                                 @endif
                              </div>
                              @if (isset($friend))
                              <div class="ms-3">
                                 {{-- <h6 class="mb-0">{{$friend->first_name}}</h6> --}}
                                 <h6 class="mb-0">{{ $friend->first_name . ' ' . (strlen($friend->last_name) > 4 ? substr($friend->last_name, 0, 4) . '...' : $friend->last_name) }}</h6>
                                 @if(isset($friend->last_online_at) && Carbon::parse($friend->last_online_at)->diffInMinutes(Carbon::now()->diffForHumans()) <= 5) <p class="mb-0"> Active </p> @elseif(isset($friend->last_online_at)) <p class="mb-0 text-dark"> {{Carbon::parse($friend->last_online_at)->diffForHumans()}} </p> @else <p class="mb-0 text-dark"> A long time ago </p> @endif
                              </div>
                              @endif
                           </div>
                        </a>
                  @endforeach
               </div>
            @endif
            <div class="right-sidebar-toggle bg-primary text-white mt-3 ">
               <span class="material-symbols-outlined pt-2">chat</span>
            </div>
          </div>
       </div>
    </div>
 </div>
@endif
