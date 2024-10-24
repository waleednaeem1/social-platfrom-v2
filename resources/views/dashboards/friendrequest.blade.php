@php
    use App\Models\FriendRequest;
    $user = auth()->user();
    if($user)
    {
       $data['friendsRequestList'] = FriendRequest::with('getRequestSender')->where(['friend_id' => $user->id])->where('status' , 'pending')->get();
    }
 @endphp
<x-app-layout>
      <div class="container">
         <div class="row">
            <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
               <div class="col-sm-12">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">Friend Requests</h4>
                        </div>
                     </div>
                     @forelse ($data['friendsRequestList'] as $request)
                     <div class="card-body">
                        <ul class="request-list list-inline m-0 p-0" >
                              <li class="d-flex align-items-center  justify-content-between flex-wrap" id="hide-friend-request-page">
                                 <div class="user-img img-fluid flex-shrink-0">
                                    <a href="{{route('user-profile',  ['username' => $request['getRequestSender']->username])}}">
                                       @if(isset($request['getRequestSender']->avatar_location))
                                          <img src="{{asset('storage/images/user/userProfileandCovers/'.$request['getRequestSender']->id.'/'.$request['getRequestSender']->avatar_location)}}" alt="story-img" class="rounded-circle avatar-40">
                                       @else
                                          <img src="{{asset('images/user/Users_150x150.png')}}" alt="story-img" class="rounded-circle avatar-40">
                                       @endif
                                    </a>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <a href="{{route('user-profile',  ['username' => $request['getRequestSender']->username])}}">
                                       <h6>{{$request['getRequestSender']->first_name}} {{$request['getRequestSender']->last_name}}</h6>
                                    </a>
                                 </div>
                                 <div class="d-flex align-items-center mt-2 mt-md-0">
                                       <a href="javascript:void(0);" onclick="approveRequest({{$request->user_id}}, 'frpage')" class="me-3 btn btn-primary rounded confirm-btn">Confirm</a>
                                       <a href="javascript:void(0);" onclick="disapproveRequest({{$request->id}}, 'frpage')" class="btn btn-secondary rounded">Delete</a>
                                 </div>
                              </li>
                              {{-- <li class="d-block text-center mb-0 pb-0">
                                 <a href="#" class="me-3 btn">View More Request</a>
                              </li> --}}
                           </ul>
                     </div>
                     @empty
                        <div class="card">
                           <div class="card-body p-0">
                               <div class="card-body text-center justify-content-center p-0 m-0" style="padding-top: 40px !important;padding-bottom: 40px !important;" >
                                    <span class="material-symbols-outlined" style="font-size:40px; color:#8c68cd;">group</span>
                                   <div>
                                       There are no friend requests to display.
                                   </div>
                               </div>
                           </div>
                       </div>
                     @endforelse
                  </div>
                  {{-- <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">People You May Know</h4>
                        </div>
                     </div>
                     <div class="card-body">
                        <ul class="request-list m-0 p-0">
                           <li class="d-flex align-items-center  flex-wrap">
                              <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/15.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Jen Youfelct</h6>
                                 <p class="mb-0">4  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                 <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                           <li class="d-flex align-items-center flex-wrap">
                              <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/16.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Cooke Edoh</h6>
                                 <p class="mb-0">20  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                 <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                           <li class="d-flex align-items-center flex-wrap">
                              <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/17.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Earl E. Riser</h6>
                                 <p class="mb-0">30  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                    <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                           <li class="d-flex align-items-center flex-wrap">
                                 <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/05.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Cliff Diver</h6>
                                 <p class="mb-0">5  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                    <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                           <li class="d-flex align-items-center flex-wrap">
                                 <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/06.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Cliff Diver</h6>
                                 <p class="mb-0">5  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                    <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                           <li class="d-flex align-items-center flex-wrap">
                              <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/07.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Vinny Gret</h6>
                                 <p class="mb-0">50  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                    <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                           <li class="d-flex align-items-center flex-wrap">
                              <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/08.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Paul Samic</h6>
                                 <p class="mb-0">6  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                    <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                           <li class="d-flex align-items-center flex-wrap">
                                 <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/09.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Gustav Wind</h6>
                                 <p class="mb-0">14  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                    <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                           <li class="d-flex align-items-center flex-wrap">
                              <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/10.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Minnie Strone</h6>
                                 <p class="mb-0">16  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                    <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                           <li class="d-flex align-items-center flex-wrap">
                              <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/11.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Ray Volver</h6>
                                 <p class="mb-0">9  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                    <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                           <li class="d-flex align-items-center flex-wrap">
                                 <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/12.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Indy Nile</h6>
                                 <p class="mb-0">6  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                    <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                           <li class="d-flex align-items-center mb-0 pb-0  flex-wrap">
                              <div class="user-img img-fluid flex-shrink-0">
                                 <img src="{{asset('images/user/13.jpg')}}" alt="story-img" class="rounded-circle avatar-40">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                 <h6>Jen Trification</h6>
                                 <p class="mb-0">42  friends</p>
                              </div>
                              <div class="d-flex align-items-center mt-2 mt-md-0">
                                    <a href="#" class="me-3 btn btn-primary rounde d-flex align-items-center">
                                    <span class="material-symbols-outlined md-18 me-1">
                                       person_add
                                    </span>
                                    Add Friend
                                 </a>
                                 <a href="#" class="btn btn-secondary rounded" data-extra-toggle="delete" data-closest-elem=".item">Remove</a>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div> --}}
               </div>
            </div>
         </div>
      </div>
<script>
function approveRequest(user_id, type) {
   $.ajax({
    method: 'GET',
    url: '/user-confirm/'+user_id,
    data: {id: user_id, type: type},
    headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   }).done(function (response) {
    if (response.type == 'frpage') {
        $('#hide-friend-request-page').addClass('d-none');
    }else{
        document.querySelector('.sub-drop-large').classList.add('show');
        $('#hide-response-count').addClass('d-none');
        $('#show-response-count').removeClass('d-none');
        document.getElementById("show-response-count").innerHTML = response.requestCount;
        $('#hide-friend-request').addClass('d-none');
    }
   });
}

function disapproveRequest(reqID, type) {
   $.ajax({
      method: 'GET',
      url: '/user-delete/'+reqID,
      data: {id: reqID, type: type},
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   }).done(function (response) {
    if (response.type == 'frpage') {
        $('#hide-friend-request-page').addClass('d-none');
    }else{
        document.querySelector('.sub-drop-large').classList.add('show');
        $('#hide-response-count').addClass('d-none');
        $('#show-response-count').removeClass('d-none');
        document.getElementById("show-response-count").innerHTML = response.requestCount;
        $('#hide-friend-request').addClass('d-none');
    }

   });
}
</script>
</x-app-layout>
