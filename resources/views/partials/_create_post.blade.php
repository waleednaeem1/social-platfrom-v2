<div class="modal-body">
    <div class="cover_spin_ProfilePhotoUpdate"></div>
    <form 
        method=""
        id="@if(isset($data['pageName']) && $data['pageName'] == 'pageDetail' || isset($data['pageName']) && $data['pageName'] == 'groupDetail') groupAndPagePostCreate @else profileTimelineFeed @endif" 
        action="" 
        class="post-text w-100 my-3 create-post-form  @if(isset($data['pageName']) && $data['pageName'] == 'pageDetail' || isset($data['pageName']) && $data['pageName'] == 'groupDetail') groupAndPagePostCreate @else profileTimelineFeed @endif" 
        enctype="multipart/form-data">
        @csrf
        <div class="d-flex">
            <div class="user-img d-flex alighn-items-center justify-content-between w-100">
                @if(isset($data['pageName']) && $data['pageName'] == 'pageDetail')
                    <div class="">
                        @if(isset($data['pageDetail'][0]->profile_image) && $data['pageDetail'][0]->profile_image !== '')
                            <img src="{{asset('storage/images/page-img/'.$data['pageDetail'][0]->id.'/'.$data['pageDetail'][0]->profile_image)}}" alt="userimg" class="avatar-60 rounded-circle">
                        @else
                            <img src="{{asset('images/user/pageProfile.png')}}" alt="userimg" class="avatar-45 rounded-circle">
                        @endif
    
                        <h5 class="mb-0 d-inline-block"> {{$data['pageDetail'][0]->page_name}} </h5>
                    </div>
                    
                    <div class="">
                        {{-- dropdown for post visibility --}}
                    </div>

                @elseif (isset($data['pageName']) && $data['pageName'] == 'groupDetail')
                    <div class="">
                        @if(isset($user->avatar_location) && $user->avatar_location !== '')
                            <img src="{{asset('storage/images/user/userProfileandCovers/'.$user->id.'/'.$user->avatar_location)}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy" style="object-fit: cover;">
                        @else
                            <img src="{{asset('images/user/Users_100x100.png')}}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy" style="object-fit: cover;">
                        @endif

                        <h5 class="mb-0 d-inline-block"> {{ $data['groupDetail'][0]->group_name }} </h5>
                    </div>
                    <div class="">
                        {{-- dropdown for post visibility --}}
                    </div>

                @else
                    <div class="">
                        @if (isset($data['user']->avatar_location) && $data['user']->avatar_location !== '')
                            <img src="{{ asset('storage/images/user/userProfileandCovers/' . $user->id . '/' . $data['user']->avatar_location) }}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                        @else
                            <img src="{{ asset('images/user/Users_100x100.png') }}" alt="userimg" class="avatar-60 rounded-circle" loading="lazy">
                        @endif
    
                        <h5 class="ps-2 d-inline-block my-auto">{{ $data['user']->first_name . ' ' . $data['user']->last_name }}</h5>  
                    </div>
                    <div class="">
                        <div class="dropdown d-none">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="visibilityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-globe"></i> Public
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="visibilityDropdown">
                                <li class="dropdown-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="visibility" id="public" value="public" checked>
                                        <label class="form-check-label visibility" for="public"><i class="fas fa-globe "></i> Public</label>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="visibility" id="friends" value="friends">
                                        <label class="form-check-label visibility" for="friends"><i class="fas fa-users "></i> Friends</label>
                                    </div>
                                </li>
                                <li class="dropdown-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="visibility" id="only-me" value="only-me">
                                        <label class="form-check-label visibility" for="only-me"><i class="fas fa-lock "></i> Only Me</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                @endif

            </div>
        </div>
        <div class="create-post-wrapp pt-2">
            <div class="flex-input">
                <textarea type="text" name="postData" class="form-control rounded border-0" id="postText" rows="1" placeholder="Write something here..."></textarea>
            </div>
            <input type="hidden" value="{{ $user->id }}" name="userId" >

            @if(isset($data['pageName']) && $data['pageName'] == 'groupDetail')

                <input type="hidden" value={{$data['groupDetail'][0]->id}} name="groupId" >
                <input type="hidden" value="groupfeed" name="type" >

            @elseif(isset($data['pageName']) && $data['pageName'] == 'pageDetail')

                <input type="hidden" value={{$data['pageDetail'][0]->id}} name="pageId" >
                <input type="hidden" value="pagefeed" name="type" >

            @elseif(isset($data['pageName']) && $data['pageName'] == 'profilePage')

                <input type="hidden" value="profilePage" name="pageType">
            
            @else
            
                <input type="hidden" value="homePage" name="pageType">
            
            @endif
            <hr class="border-0">
            <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                <li class="w-100">
                    <div class="d-flex align-items-center justify-content-center w-100 mb-2">
                        <label for="profileImagePost" class="d-flex flex-column align-items-center justify-content-center w-100 h-100 border border-2  border-dashed rounded bg-gray" onclick="addMoreFiles()" style="cursor:pointer">
                            <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                <svg class=" text-gray" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" width="50px" height="50px" viewBox="0 0 20 16">
                                    <path stroke="#777d74" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray"><span class="font-semibold fs-4">Add photos/videos</span></p>
                                <p class="text-xs text-gray pb-0 mb-0">or drag and drop</p>
                            </div>
                            <input type="file" multiple name="profileImage[]" id="profileImagePost" class="fileInputGetOldValues d-none" accept="image/*,video/mp4,video/x-m4v,video/*" onchange="previewImages(); enableButton()" >
                        </label>
                    </div> 
                    <div id="preview" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 8px;"></div>
                </li>
                
            </ul>
        </div>
        <button type="submit" id="PostCreateButton" class="btn btn-primary d-block w-100 mt-3">Post</button>
    </form>
</div>