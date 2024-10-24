<x-app-layout>
    @php
        $user = auth()->user();
    @endphp
        <div class="container">
            <div class="row">
                <div class="col-x-8 m-0 py-0 rem-div-1">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">General Setting</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card mb-0">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">See your blocked list</h4>
                                        <p>Keep your social media experience positive by reviewing your blocked list</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="acc-edit">
                                        <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#seeAllBlockedUsers" action="javascript:void();">See All</a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade seeAllMembers" id="seeAllBlockedUsers" tabindex="-1"  aria-labelledby="seeAllBlockedUsers-modalLabel" aria-hidden="true" style="margin-top:5rem;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" style="width: 586px">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="seeAllMembers-modalLabel">Blocked Users</h5>
                                            <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                            <span class="material-symbols-outlined">close</span>
                                            </a>
                                        </div>
                                        <div class="row" style="width:100%">
                                            <div class="container" style="overflow-y: auto; max-height: 300px; padding: 0px 15px">
                                                @if(count($data['allBlockedUsers']) !== 0)
                                                    @foreach($data['allBlockedUsers'] as $blocked)
                                                        @if(isset($blocked['getUserDataSelectedColumns']))
                                                            <div class="d-flex flex-row bd-highlight align-items-center my-3" >
                                                                <div class="col-md-8 p-2 bd-highlight">
                                                                    <a href="{{route('user-profile',  ['username' => $blocked['getUserDataSelectedColumns']->username])}}">
                                                                        @if (isset($blocked['getUserDataSelectedColumns']->avatar_location) && $blocked['getUserDataSelectedColumns']->avatar_location !== '')
                                                                            <img src="{{ asset('storage/images/user/userProfileandCovers/' . $blocked['getUserDataSelectedColumns']->id . '/' . $blocked['getUserDataSelectedColumns']->avatar_location) }}" class="rounded-circle" alt="profile-img" width="70px" height="70px">
                                                                        @else
                                                                            <img src="{{ asset('images/user/Users_150x150.png') }}" alt="profile-img" class="rounded-circle" alt="profile-img" width="70px" height="70px">
                                                                        @endif
                                                                        <span class="requestUserName text-nowrap">{{ $blocked['getUserDataSelectedColumns']->first_name. ' ' . (strlen($blocked['getUserDataSelectedColumns']->last_name) > 10 ? substr($blocked['getUserDataSelectedColumns']->last_name, 0, 10) . '...' : $blocked['getUserDataSelectedColumns']->last_name) }}</span>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-4 p-2 bd-highlight" >
                                                                    <a class="btn btn-primary w-100 unblockFriendBlockSection_{{$blocked['getUserDataSelectedColumns']->username}}" onclick="unblockFriendUserTab('{{$blocked['getUserDataSelectedColumns']->username}}')" href="javascript:void(0);">Unblock</a>
                                                                    <a class="btn btn-primary w-100 d-none blockFriendBlockSection_{{$blocked['getUserDataSelectedColumns']->username}}" onclick="blockFriendUserTab('{{$blocked['getUserDataSelectedColumns']->username}}')" href="javascript:void(0);">Block</a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <p class="text-center">No users have been blocked yet.</p>
                                                @endif                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Delete Account</h4>
                                    <p>You can recover your account within 60 days.</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="acc-edit">
                                    <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#delete-modal" action="javascript:void();">Delete</a>
                                </div>
                            </div>
                            <div class="modal fade" id="delete-modal" tabindex="-1" style="min-height: 400px; margin-top:10rem"  aria-labelledby="delete-modalLabel" aria-hidden="true" >
                                <div class="modal-dialog   modal-fullscreen-sm-down">
                                   <div class="modal-content">
                                      <div class="modal-header">
                                         <h5 class="modal-title" id="delete-modalLabel">Delete Account</h5>
                                         <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                            <span class="material-symbols-outlined">close</span>
                                         </a>
                                      </div>
                                      <div class="modal-body">
                                         <div class="d-flex align-items-center">
                                            <form method="POST" id="my-form" action="{{ route('users.delete',$user->id) }}" class="post-text ms-3 w-100" action="javascript:void();" enctype="multipart/form-data">
                                               @csrf
                                               <input type="hidden" class="form-control rounded" value={{$user->id}} name="userId" style="border:none;">
                                               <h4>Are you sure you want to delete your account?</h4>
                                               <hr>
                                               <button type="submit" class="btn btn-primary me-2">Yes</button>
                                               <button type="button" class="btn btn-primary me-2" data-bs-dismiss="modal">No</button>
                                            </form>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                             </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>