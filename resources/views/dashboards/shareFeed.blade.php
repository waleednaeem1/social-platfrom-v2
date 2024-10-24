@php
    $user = auth()->user();
    // echo "<pre>";
    // print_r($data['feeds']);
    // die;
@endphp


<x-app-layout>
    <div class="container">
        <div class="row">
            @if (isset($data['newsFeeds']))
               <div class="@if(isset($data['shareFeed'])) col-x-8 m-0 py-0 rem-div-1 @else col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1 @endif mx-auto">
                  @foreach ($data['feeds'] as $feed)
                     @include('partials/_feed')
                  @endforeach
               </div>
            @endif
            @if (isset($data['groupFeeds']))
               <link rel="stylesheet" href="{{ asset('css/croppie/croppie.css')}}">
               <div class="@if(isset($data['shareFeed'])) col-x-8 m-0 py-0 rem-div-1 @else col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1 @endif">
                  <div class="header-for-bg updateProfileCoverPhoto container">
                     <div class="background-header position-relative">
                        @if(isset($data['groupDetail'][0]->cover_image) && $data['groupDetail'][0]->cover_image !== '')
                           <img src="{{asset('storage/images/group-img/'.$data['groupDetail'][0]->id . '/' . 'cover' . '/' . $data['groupDetail'][0]->cover_image)}}" class="w-100 rounded" style="height:368px; object-fit: cover;" alt="header-bg">
                        @else
                           {{-- <img src="{{asset('images/group-img/no-image.png')}}" class="img-fluid w-100 rounded rounded" alt="header-bg"> --}}
                           <img src="{{asset('images/user/Banners-01.png')}}" class="img-fluid w-100 rounded rounded" style="height:368px; object-fit: cover;" alt="header-bg">
                        @endif
                        {{-- <div class="title-on-header">
                           <div class="data-block">
                              <h2>{{$data['groupDetail'][0]->group_name}}</h2>
                           </div>
                        </div> --}}
                     </div>
                  </div>
                  <div class="row position-relative">
                     <div class="container">
                        <div class="col-md-12" style="text-align: end;">
                              @if ($data['groupDetail'][0]->admin_user_id == $user->id)
                              {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#groupCover-post-modal" class="fa fa-camera fa shadow" id="upload_camera_icon" style="margin-top: -1rem; overflow: hidden;">
                              </a> --}}
                              <div class="dropdown">
                                 <a href="#" data-bs-toggle="dropdown" class="fa fa-camera fa dropdown shadow" id="upload_camera_icon" style="margin-top: -1rem; overflow: hidden;">
                                 </a>
                                 <div class="dropdown-menu">
                                    @if(isset($data['groupDetail'][0]->cover_image) && $data['groupDetail'][0]->cover_image !=='')
                                       <a data-fslightbox="gallery" href="{{asset('storage/images/group-img/'.$data['groupDetail'][0]->id . '/' . 'cover' . '/' . $data['groupDetail'][0]->cover_image)}}" class="dropdown-item">View Cover Picture</a>
                                    @endif
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#groupCover-post-modal" class="dropdown-item">Update Cover Picture</a>
                                 </div>
                              </div>
                              @endif
                        </div>
                     </div>
                  </div>
                  <div id="content-page" class="content-page">
                   <div class="container">
                      <div class="row">
                         <div class="col-lg-12">
                            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap updateProfilePhoto">
                               <div class="group-info d-flex align-items-center ">
                                  <div class="info" style="margin-left: 1rem">
                                     <h4>{{$data['groupDetail'][0]->group_name}}</h4>
                                     {{-- <p class="mb-0 d-flex"><i class="material-symbols-outlined pe-2">lock</i>{{$data['groupDetail'][0]->group_type}} Group . @if(count($data['groupDetail'][0]['groupMembers']) == 1) {{count($data['groupDetail'][0]['groupMembers'])}} member @else {{count($data['groupDetail'][0]['groupMembers'])}} members @endif</p> --}}
                                     <p class="mb-0 d-flex">@if ($data['groupDetail'][0]->group_type == 'Public')<i class="material-symbols-outlined pe-2" style="margin-left: -5px;">public</i>@elseif ($data['groupDetail'][0]->group_type == 'Private')<i class="material-symbols-outlined pe-2" style="margin-left: -5px;">lock</i>@endif{{$data['groupDetail'][0]->group_type}}</p>
                                     <p>@if($data['groupMemberCount'] == 1) {{$data['groupMemberCount']}} Member @else {{$data['groupMemberCount']}} Members @endif</p>
             
             
                                  </div>
                               </div>
                               <div class="group-member d-flex align-items-center  mt-md-0 mt-2">
                                  <div class="iq-media-group me-3">
             
                                     @if(isset($data['groupDetail'][0]['groupMembers'][0]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][0]['getUser']->username])}}" class="iq-media">
                                              <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][0]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][0]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                        </a>
                                     @endif
                                     @if(isset($data['groupDetail'][0]['groupMembers'][1]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][1]['getUser']->username])}}" class="iq-media">
                                              <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][1]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][1]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                        </a>
                                     @endif
                                     @if(isset($data['groupDetail'][0]['groupMembers'][2]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][2]['getUser']->username])}}" class="iq-media">
                                              <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][2]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][2]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                        </a>
                                     @endif
                                     @if(isset($data['groupDetail'][0]['groupMembers'][3]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][3]['getUser']->username])}}" class="iq-media">
                                              <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][3]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][3]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                        </a>
                                     @endif
                                     @if(isset($data['groupDetail'][0]['groupMembers'][4]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][4]['getUser']->username])}}" class="iq-media">
                                              <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][4]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][4]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                        </a>
                                     @endif
                                     @if(isset($data['groupDetail'][0]['groupMembers'][5]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][5]['getUser']->username])}}" class="iq-media">
                                              <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][5]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][5]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                        </a>
                                     @endif
                                     @if(isset($data['groupDetail'][0]['groupMembers'][6]['getUser']->avatar_location))
                                        <a href="{{route('user-profile',  ['username' => $data['groupDetail'][0]['groupMembers'][6]['getUser']->username])}}" class="iq-media">
                                              <img class="img-fluid avatar-40 rounded-circle" src="{{asset('storage/images/user/userProfileandCovers/'.$data['groupDetail'][0]['groupMembers'][6]['getUser']->id.'/'.$data['groupDetail'][0]['groupMembers'][6]['getUser']->avatar_location)}}" alt="" loading="lazy">
                                        </a>
                                     @endif
                                  </div>
                                  {{-- <button type="submit" class="btn btn-primary d-flex gap-2"><i class="material-symbols-outlined">add</i>Invite</button> --}}
                               </div>
                            </div>
                         </div>
                         <div class="@if(isset($data['shareFeed'])) col-12 @else col-lg-8 @endif updateFeed updateNewsFeed" id="groupPagerefresh">
                            @if($checkGroupMember == 1)
                               <div class="modal fade joinrequestmodal" id="joinrequestmodal" tabindex="-1"  aria-labelledby="joinRequest-modalLabel" aria-hidden="true" style="margin-top:5rem;">
                                  <div class="modal-dialog modal-lg">
                                     <div class="modal-content">
                                        <div class="modal-header">
                                           <h5 class="modal-title" id="joinRequest-modalLabel">All Requests</h5>
                                           <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                           <span class="material-symbols-outlined">close</span>
                                           </a>
                                        </div>
                                        <div class="row" style="width:100%">
                                           <div class="container" style="overflow-y: auto; max-height: 300px; padding: 0px 15px">
                                           @foreach($data['allRequests'] as $request)
                                              @if(isset($request) && isset($request['getUser']))
                                                 <div class="d-flex flex-row bd-highlight align-items-center my-3" >
                                                       <div class="col-md-6 p-2 bd-highlight">
                                                          @if(isset($request['getUser']->username) && $request['getUser']->username !== '')
                                                             <a href="{{route('user-profile',  ['username' => $request['getUser']->username])}}">
                                                             @if(isset($request['getUser']->avatar_location) && $request['getUser']->avatar_location !== '')
                                                                   <img src="{{ asset('storage/images/user/userProfileandCovers/'.$request['getUser']->id.'/'.$request['getUser']->avatar_location) }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                             @else
                                                                   <img src="{{asset('images/user/Users_60x60.png')}}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                             @endif
                                                             <span class="requestUserName">{{$request['getUser']->first_name.' '.$request['getUser']->last_name}}</span>
                                                             </a>
                                                          @endif
                                                       </div>
                                                       <div class="col-md-3 p-2 bd-highlight" id="approveGroupRequest{{$request['getUser']->id}}">
                                                             <button class="btn btn-primary w-100 mt-3 btn-sm" onclick="approveGroupRequest({{$request['getUser']->id}},{{$data['groupDetail'][0]->id}}, {{$data['groupDetail'][0]->admin_user_id}})">Approve</button>
                                                       </div>
                                                       <div class="col-md-3 p-2 bd-highlight" id="rejectGroupRequest{{$request['getUser']->id}}">
                                                             <button class="btn w-100 mt-3 btn-sm btn-secondary" onclick="rejectGroupRequest({{$request['getUser']->id}},{{$data['groupDetail'][0]->id}}, {{$data['groupDetail'][0]->admin_user_id}})">Reject</button>
                                                       </div>
                                                       <div class="col-md-6 bd-highlight">
                                                             <button disabled id="approved{{$request['getUser']->id}}" class="btn btn-secondary d-none w-100 mt-3 btn-sm">Approved</button>
                                                             <button disabled id="rejected{{$request['getUser']->id}}" class="btn btn-secondary d-none w-100 mt-3 btn-sm">Rejected</button>
                                                       </div>
                                                 </div>
                                              @endif
                                           @endforeach
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                               <div class="modal fade seeAllMembers" id="seeAllMembers" tabindex="-1"  aria-labelledby="seeAllMembers-modalLabel" aria-hidden="true" style="margin-top:5rem;">
                                  <div class="modal-dialog modal-lg">
                                     <div class="modal-content">
                                        <div class="modal-header">
                                           <h5 class="modal-title" id="seeAllMembers-modalLabel">All Members</h5>
                                           <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                           <span class="material-symbols-outlined">close</span>
                                           </a>
                                        </div>
                                        <div class="row" style="width:100%">
                                           <div class="container" style="overflow-y: auto; max-height: 300px; padding: 0px 15px">
                                              @foreach($data['allMembers'] as $member)
                                                 @if(isset($member['getUser']))
                                                    @if ($data['groupDetail'][0]->admin_user_id == $member['getUser']->id)
                                                       @continue;
                                                    @endif
                                                    <div class="d-flex flex-row bd-highlight align-items-center my-3" >
                                                       <div class="col-md-8 p-2 bd-highlight">
                                                          <a href="{{route('user-profile',  ['username' => $member['getUser']->username])}}">
                                                             @if(isset($member['getUser']->avatar_location) && $member['getUser']->avatar_location !== '')
                                                                   <img src="{{ asset('storage/images/user/userProfileandCovers/'.$member['getUser']->id.'/'.$member['getUser']->avatar_location) }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                             @else
                                                                   <img src="{{asset('images/user/Users_60x60.png')}}" alt="profile-img" class="avatar-45 rounded-circle" />
                                                             @endif
                                                             <span class="requestUserName">{{$member['getUser']->first_name.' '.$member['getUser']->last_name}}</span>
                                                          </a>
                                                       </div>
                                                       <div class="col-md-4 p-2 bd-highlight" id="removeMember{{$member['getUser']->id}}">
                                                          <button class="btn btn-primary w-100 mt-3 btn-sm" onclick="removeMember({{$member['getUser']->id}},{{$data['groupDetail'][0]->id}}, {{$data['groupDetail'][0]->admin_user_id}})">Remove</button>
                                                       </div>
                                                       {{-- <div class="col-md-3 p-2 bd-highlight" id="rejectGroupRequest{{$member['getUser']->id}}">
                                                          <button class="btn btn-primary w-100 mt-3 btn-sm" onclick="rejectGroupRequest({{$member['getUser']->id}},{{$data['groupDetail'][0]->id}}, {{$data['groupDetail'][0]->admin_user_id}})">Reject</button>
                                                       </div> --}}
                                                       <div class="col-md-4 bd-highlight">
                                                          {{-- <button disabled id="approved{{$member['getUser']->id}}" class="btn btn-secondary d-none w-100 mt-3 btn-sm">Approved</button> --}}
                                                          <button disabled id="removed{{$member['getUser']->id}}" class="btn btn-secondary d-none w-100 mt-3 btn-sm">Removed</button>
                                                       </div>
                                                    </div>
                                                 @endif
                                              @endforeach
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                            @endif
                            @if($checkGroupMember == 1 || ($checkGroupMember == 0 && $data['groupDetail'][0]->group_type == 'Public'))
                               @foreach($data['feeds'] as $feed)
                                  @if(isset($feed))
                                    @include('partials/_feed')
                                  @endif
                               @endforeach
                            @endif
                         </div>
                      </div>
                      <div class="modal fade" id="groupCover-post-modal" aria-labelledby="coverPhoto-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 4rem">
                        <div class="modal-dialog modal-lg modal-lg-cover">
                              <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title" id="coverPhoto-modalLabel">Upload Cover Photo</h5>
                                    <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                                    <span class="material-symbols-outlined">close</span>
                                 </a>
                              </div>
                              <div class="modal-body">
                                 <div class="cover_spin_ProfilePhotoUpdate"></div>
                                 <div class="d-flex align-items-center">
                                    <div class="container" style="">
                                          <div class="panel panel-primary">
                                             <div class="panel-body">
                                                <div class="row">
                                                <div class="col-md-9 text-center">
                                                      <div id="cropie-demo-cover"></div>
                                                </div>
                                                <div class="col-md-3" style="">
                                                      <strong>Select Image:</strong>
                                                      <input type="file" name="profileImage" id="cover-image" required class="form-control" accept="image/*" placeholder="Cover Image" style="border:none;">
                                                      <input type="hidden" name="groupId" id="groupIdforCover" value={{ $data['groupDetail'][0]->id}} required class="form-control rounded" style="border:none;">
                                                      <input type="hidden" name="type" value="cover" required class="form-control rounded" style="border:none;">
                                                      <br />
                                                      <span id="error-cover" style="color: red; display: none;">Please select a valid image file</span>
                                                </div>
                                                <button style="display:none;" type="submit" id="showAndHideButtonCover" class="btn btn-primary w-100 mt-3 upload-result-cover">Update Cover Photo</button>
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
               </div>
            @endif
            @if (isset($data['pageFeeds']))
               <div class="@if(isset($data['shareFeed'])) col-12 @else col-lg-8 @endif mx-auto">
                  @foreach($data['feeds'] as $feed)
                     @include('partials/_feed')
                     @endforeach
               
               </div>
            @endif
        </div>
    </div>
   <div class="modal fade" id="feed_likes_modal_popup">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-scrollable-feeds  modal-md" style="top:4rem">
         <div class="modal-content">
            <div class="card p-4 feed_likes_modal_loder d-none">
                  <h5 class="card-title">
                     <div class="row flex-lg-nowrap">
                        <span class="avatar-65 col-2 placeholder rounded-5"></span>
                        <div>
                              <span class="placeholder col-7 mt-2 mb-2"></span>
                              <span class="placeholder col-5"></span>
                        </div>
                     </div>
                  </h5>
                  <div class="card-img-top bg-soft-light placeholder-img"></div>
                  <div class="card-body">
                     <div class="row mb-2">
                        <div class="col-4">
                              <span class="placeholder py-3"></span>
                        </div>
                        <div class="col-4">
                              <span class="placeholder py-3"></span>
                        </div>
                        <div class="col-4">
                              <span class="placeholder py-3"></span>
                        </div>
                     </div>
                     <p class="card-text">
                        <span class="placeholder"></span>
                        <span class="placeholder"></span>
                        <span class="placeholder"></span>
                        <span class="placeholder"></span>
                        <span class="placeholder"></span>
                     </p>
                  </div>
            </div>

            <div id="feedModalHeader" class="modal-header d-none">
                  <h1 id="feedModalHeading" class="modal-title fs-5"></h1>
                  <span id="feedModalClose" type="button" class="btn-close"></span>
            </div>
            <div class="modal-body ">
                  <div id="feedModalBodyContent" class="modal-content border-0"></div>
            </div>
         </div>
      </div>
   </div>
    @push('scripts')
      <script src="{{ asset('js/feedModal.js?version=0.15') }}"></script>
   @endpush
    <script>
    $(document).ready(function() {
        $('#my-form').submit(function(event) {
            if ($('#postText').val() == '' && $('#profileImagePost').val() == '') {
                alert('Please enter at least one field!');
                event.preventDefault();
            }
        });
    });
    
    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('js/croppie/croppie.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $uploadCropCover = $('#cropie-demo-cover').croppie({
        enableExif: true,
        viewport: {
            width: 600,
            height: 300,
            type: 'rectangle'
        },
        boundary: {
            width: 700,
            height: 400
        }
    });


    $('#cover-image').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            $uploadCropCover.croppie('bind', {
                url: e.target.result
            }).then(function() {
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });


    $('.upload-result-cover').on('click', function(ev) {
      $('.cover_spin_ProfilePhotoUpdate').show();
        $uploadCropCover.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(resp) {
            const groupId = document.getElementById('groupIdforCover').value;
            $.ajax({
                url: "{{ route('imageCropGroup') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "image": resp,
                    "type": "Cover_image",
                    "groupId": groupId
                },
                success: function(data) {
                  $(".updateProfileCoverPhoto").load(" .updateProfileCoverPhoto"+"> *").fadeIn(0);
                  $(".coverImageDivRefresh").load(" .coverImageDivRefresh"+"> *").fadeIn(0);
                  setTimeout(function() {
                        $('.cover_spin_ProfilePhotoUpdate').hide();
                        $('#groupCover-post-modal').modal('hide');
                        $("#cover-image").val("");
                        $(".cr-image").attr("src", "");
                  }, 3000);
                }
            });
        });
    });

$(document).ready(function() {
        $('#cover-image').change(function() {
        var file = this.files[0];
        var fileType = file.type;
        var validImageTypes = ["image/jpeg", "image/png", "image/jpg"];

    if ($.inArray(fileType, validImageTypes) < 0) {
        $('#error-cover').show();
        $('#showAndHideButtonCover').hide();
        $('#profileImage').val("");
    } else {
        $('#error-cover').hide();
        $('#showAndHideButtonCover').show();
    }
    });
});
</script>
</x-app-layout>
    