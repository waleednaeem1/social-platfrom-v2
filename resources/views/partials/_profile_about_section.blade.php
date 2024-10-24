<div class="col-md-9 ps-4">
    <div class="tab-content">
        <div class="tab-pane fade active show" id="v-pills-basicinfo-tab" role="tabpanel" aria-labelledby="v-pills-basicinfo-tab">
            <h4>Contact Information</h4>
            <hr>
            <div class="row">
                <div class="col-3">
                    <h6>Email</h6>
                </div>
                <div class="col-9">
                    <p class="mb-0">{{ $data['user']->email }}</p>
                </div>
                <div class="col-3">
                    <h6>Mobile</h6>
                </div>
                <div class="col-9">
                    <p class="mb-0">{{ $data['user']->phone }}</p>
                </div>
                <div class="col-3">
                    <h6>Address</h6>
                </div>
                <div class="col-9">
                    <p class="mb-0">{{ $data['user']->address }}</p>
                </div>
            </div>
            {{-- <h4 class="mt-3">Websites and Social Links</h4> --}}
            {{-- <hr> --}}
            {{-- <div class="row">
                <div class="col-3">
                    <h6>Website</h6>
                </div>
                <div class="col-9">
                    <p class="mb-0">www.bootstrap.com</p>
                </div>
                <div class="col-3">
                    <h6>Social Link</h6>
                </div>
                <div class="col-9">
                    <p class="mb-0">www.bootstrap.com</p>
                </div>
            </div> --}}
            <h4 class="mt-3">Basic Information</h4>
            <hr>
            <div class="row">
                <div class="col-3">
                    <h6>Birthday</h6>
                </div>
                <div class="col-9">
                    <p class="mb-0">{{ $data['user']->dob }}</p>
                </div>
                {{-- <div class="col-3">
                        <h6>Birth Year</h6>
                    </div>
                    <div class="col-9">
                        <p class="mb-0">{{$data['user']->address}}</p>
                    </div> --}}
                <div class="col-3">
                    <h6>Gender</h6>
                </div>
                <div class="col-9">
                    <p class="mb-0">{{ $data['user']->gender }}</p>
                </div>
                {{-- <div class="col-3">
                    <h6>interested in</h6>
                </div>
                <div class="col-9">
                    <p class="mb-0">{{$data['user']->address}}</p>
                </div> --}}
                <div class="col-3">
                    <h6>Languages</h6>
                </div>
                <div class="col-9">
                    <p class="mb-0">
                        @if ($data['UserProfileDetails'])
                            {{-- @if ($data['UserProfileDetails']->language_eng == 1) --}}
                                <span style="margin-right: -5px;">English</span>
                            {{-- @endif --}}
                            @if ($data['UserProfileDetails']->language_french == 1)<span style="margin-right: -5px;">, French</span>@endif
                            @if ($data['UserProfileDetails']->language_chinese == 1)<span style="margin-right: -5px;">, Chinese</span>@endif
                            @if ($data['UserProfileDetails']->language_spanish == 1)<span style="margin-right: -5px;">, Spanish</span>@endif
                            @if ($data['UserProfileDetails']->language_arabic == 1)<span style="margin-right: -5px;">, Arabic</span>@endif
                            @if ($data['UserProfileDetails']->language_italian == 1)<span style="margin-right: -5px;">, Italian</span>@endif
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="v-pills-details-tab" role="tabpanel"
            aria-labelledby="v-pills-details-tab">

            <span id="userhobbylistload"></span>

        </div>
        <div class="tab-pane fade" id="v-pills-family" role="tabpanel" >
            <h4 class="mb-3">Relationship Status</h4>
            <ul class="suggestions-lists m-0 p-0">
                <span id="userprofilestatusload"></span>

            </ul>
            <h4 class="mt-3 mb-3">Family Members</h4>
            <ul class="suggestions-lists m-0 p-0">
                <li class="d-flex mb-4 align-items-center">
                    @if ($data['self_profile'])
                        <div class="user-img img-fluid">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-familymember-modal" class="material-symbols-outlined md-18">
                                add
                            </a>
                        </div>
                        <div class="media-support-info ms-3">
                            <h6>Add Family Members</h6>
                        </div>
                    @endif
                </li>
                <span id="familymemberlistload"></span>

            </ul>
        </div>
        <div class="modal fade" id="add-relationship-modal" tabindex="-1" aria-labelledby="relationship-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Add
                            Relationship Status </h5>
                        <a href="javascript:void(0);" class="lh-1"
                            data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100"  id="familraltionshipstatusform" action="javascript:void(0)"  method="POST">
                                @csrf
                                <input type="hidden" class="form-control" name="type" value="ownstatus">
                                <label>Relationship Status</label>
                                <select class="form-control" name="ownstatus" id="ownstatus">
                                    <option value="" selected disabled>Select Relationship Status</option>
                                    <option value="Single">Single</option>
                                    <option value="In a Relationship">In a Relationship</option>
                                    <option value="Engaged">Engaged</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Don’t want to specify">Don’t want to specify</option>
                                </select>
                                <button type="submit" class="btn btn-primary d-block w-100 mt-3">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-relationship-modal-edit" tabindex="-1" aria-labelledby="relationship-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Edit Relationship Status</h5>
                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100"  id="singlefamiliyformedit" action="javascript:void(0)" method="POST">
                                @csrf
                                <input type="hidden" class="form-control"
                                    name="type" value="ownstatus">
                                <label>Relationship Status</label>
                                <select class="form-control" name="relationship" id="ownstatusedit">
                                    <option value="" disabled>Select Relationship Status</option>
                                    <option value="Single"{{ optional($data['UserProfileDetails'])->marital_status == 'Single' ? 'selected' : '' }}>
                                        Single</option>
                                    <option value="In a Relationship" {{ optional($data['UserProfileDetails'])->marital_status == 'In a Relationship' ? 'selected' : '' }}>
                                        In a Relationship</option>
                                    <option value="Engaged" {{ optional($data['UserProfileDetails'])->marital_status == 'Engaged' ? 'selected' : '' }}>
                                        Engaged</option>
                                    <option value="Married" {{ optional($data['UserProfileDetails'])->marital_status == 'Married' ? 'selected' : '' }}>
                                        Married</option>
                                    <option value="Divorced" {{ optional($data['UserProfileDetails'])->marital_status == 'Divorced' ? 'selected' : '' }}>
                                        Divorced</option>
                                    <option value="Don’t want to specify" {{ optional($data['UserProfileDetails'])->marital_status == 'Don’t want to specify' ? 'selected' : '' }}>
                                        Don’t want to specify</option>
                                </select>
                                <button type="submit" class="btn btn-primary d-block w-100 mt-3">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-hobbiesandintrests-modal" aria-labelledby="work-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 5rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content" style="margin-bottom: 5rem;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Hobbies and Interests</h5>
                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100"  action="javascript:void(0)" id="hobbyinterstForm" method="POST">
                                @csrf
                                <span class="alert alert-danger" id="error_add_hobbies_intrest" style="display:none">Please select atleast 1 hobby</span>
                                <select name="hobbies[]" id="choices-multiple-remove-button"  placeholder="Select your hobbies" multiple onchange="getHobbiesValidation()" >
                                    <option disabled value="">Select Your Hobbies</option>
                                    @foreach ($data['UserHobbyList'] as $userHobbyList )
                                        <option value="{{ $userHobbyList->hobbies }}">{{ $userHobbyList->hobbies }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" name="hobbies" required class="form-control rounded" placeholder="Write about your hobbies" style="border:none;"> --}}
                                <hr>
                                <input type="text" name="fav_tv_show"  class="form-control rounded" placeholder="Write Favorite TV Shows" style="border:none;">
                                <hr>
                                <input type="text" name="fav_movies"  class="form-control rounded" placeholder="Write Favorite Movies" style="border:none;">
                                <hr>
                                <input type="text" name="fav_games"  class="form-control rounded" placeholder="Write Favorite Games" style="border:none;">
                                <hr>
                                <input type="text" name="fav_music"  class="form-control rounded" placeholder="Write Favorite Music Bands / Artists" style="border:none;">
                                <hr>
                                <input type="text" name="fav_books"  class="form-control rounded" placeholder="Write Favorite Books" style="border:none;">
                                <hr>
                                <input type="text" name="fav_writters"  class="form-control rounded" placeholder="Write Favorite Writers" style="border:none;">
                                <hr>
                                <button type="submit" onclick="getHobbiesValidation()" class="btn btn-primary d-block w-100 mt-3">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-hobbiesandintrests-modal-edit" aria-labelledby="work-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 5rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content" style="margin-bottom: 5rem;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Hobbies and
                            Interests</h5>
                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100"  action="javascript:void(0)" id="hobbylistEdit"  method="POST">
                                @csrf
                                @php
                                    if(isset($data['UserHobbyInterest']->hobbies[0])){
                                        $getHobby=explode(", ",$data['UserHobbyInterest']->hobbies);
                                    }else{
                                        $getHobby=[];
                                    }
                                @endphp
                                <span class="alert alert-danger" id="error_edit_hobbies_intrest" style="display:none">Please select atleast 1 hobby</span>
                                <select name="hobbies[]" id="choices-multiple-remove-button-edit" placeholder="Select your hobbies"  multiple onchange="getHobbiesValidationEdit()">
                                    @foreach ($data['UserHobbyList'] as $userHobbyList )
                                        <option value="{{ $userHobbyList->hobbies }}" @if(in_array($userHobbyList->hobbies,$getHobby)) selected  @endif   >{{ $userHobbyList->hobbies }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" name="hobbies" required class="form-control rounded"
                                    placeholder="Write about your hobbies"
                                    value="@if ($data['UserHobbyInterest']) {{ $data['UserHobbyInterest']->hobbies }} @else null @endif"
                                    style="border:none;"> --}}
                                <hr>
                                <input type="text" id="fav_tv_show" name="fav_tv_show"  class="form-control rounded" placeholder="Write Favorite TV Shows" style="border:none;">
                                <hr>
                                <input type="text" id="fav_movies" name="fav_movies"  class="form-control rounded" placeholder="Write Favorite Movies" style="border:none;">
                                <hr>
                                <input type="text" id="fav_games" name="fav_games"  class="form-control rounded" placeholder="Write Favorite Games" style="border:none;">
                                <hr>
                                <input type="text" id="fav_music" name="fav_music"  class="form-control rounded" placeholder="Write Favorite Music Bands / Artists" style="border:none;">
                                <hr>
                                <input type="text" id="fav_books" name="fav_books"  class="form-control rounded" placeholder="Write Favorite Books" style="border:none;">
                                <hr>
                                <input type="text" id="fav_writters" name="fav_writters"  class="form-control rounded" placeholder="Write Favorite Writers" style="border:none;">
                                <hr>
                                <button type="submit" onclick="getHobbiesValidationEdit()" class="btn btn-primary d-block w-100 mt-3">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-familymember-modal" aria-labelledby="work-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Add Family
                            Members</h5>
                        <a href="javascript:void(0);" class="lh-1"
                            data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100"  id="addfamilymemberForm" action="javascript:void(0)"  method="POST">
                                @csrf
                                <input type="hidden" class="form-control" name="type" value="familymember">
                                <span class="alert alert-danger" id="error_family_member_add" style="display:none">Please select family member</span>
                                <select class="form-control" name="family_member[]" id="choices-add-family-member"   multiple onchange="addFamilyMemberValidation()" >
                                    @foreach ($data['friends'] as $friends )
                                    <option value="{{ $friends->id }}" >{{ $friends->first_name }}</option>
                                    @endforeach
                                </select>

                                <label>Relationship</label>
                                <select class="form-control" name="relationship" id="relationship" required>
                                    <option value="" selected disabled>Select Relationship</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Father">Father</option>
                                    <option value="Brother">Brother</option>
                                    <option value="Sister">Sister</option>
                                    <option value="Wife">Wife</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
                                    <option value="Cousin">Cousin</option>
                                </select>
                                <button type="submit" onclick="addFamilyMemberValidation()" class="btn btn-primary d-block w-100 mt-3">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--edit form used -->
        <div class="modal fade" id="add-familymember-modal-edit" aria-labelledby="work-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Edit Family Members</h5>
                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100"  action="javascript:void(0)" id="familyRelationshipFormEdit" method="POST">
                                @csrf
                                <input type="hidden" class="form-control" name="type" value="familymember">
                                <input type="hidden" class="form-control" name="id" id="relationid">
                                <select class="form-control" name="family_member[]" id="choices-add-family-member"   multiple required>
                                    @foreach ($data['friends'] as $friends )
                                    <option value="{{ $friends->id }}" >{{ $friends->first_name }}</option>
                                    @endforeach
                                </select>

                                <label>Relationship</label>
                                <select class="form-control" name="relationship"
                                    id="familyrelation" required>
                                    <option value="" disabled>Select Relationship</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Father">Father</option>
                                    <option value="Brother">Brother</option>
                                    <option value="Sister">Sister</option>
                                    <option value="Wife">Wife</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
                                    <option value="Cousin">Cousin</option>
                                </select>
                                <button type="submit" class="btn btn-primary d-block w-100 mt-3">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-work-modal" aria-labelledby="work-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Add Work Experience</h5>
                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <!--Add work Experience From -->
                            <form class="post-text ms-3 w-100" action="javascript:void(0)"  id="workExpForm"  method="POST">
                                @csrf
                                <input type="hidden" class="form-control" name="type" value="work">
                                {{-- <input type="hidden" name="userId" value="{{$user->id}}" required class="form-control rounded" style="border:none;"> --}}
                                <input type="text" name="name" id="name" required class="form-control rounded" placeholder="Company" style="border:none;">
                                <hr>
                                <input type="text" name="title" id="title" required class="form-control rounded" placeholder="Position" style="border:none;">
                                <hr>
                                <input type="text" name="city" id="city" required class="form-control rounded" placeholder="City/Town" style="border:none;">
                                <hr>
                                <label>I'm currently working</label>
                                <input class="form-check-input" type="checkbox" name="current_status" value="" id="current_status_working">
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>From</label>
                                        <select class="form-control" name="from_year" id="workStartYear" required>
                                            <option value="" selected disabled>Select Year From</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>To</label>
                                        <select class="form-control" name="to_year" id="workEndYear" required>
                                            <option value="" selected disabled>Select Year To</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary d-block w-100 mt-3">Add Work</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-work-modal-edit" aria-labelledby="work-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Edit Work Experience</h5>
                        <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100"  action="javascript:void(0)" id="aboutInformationUpdateForm" method="POST">
                                @csrf
                                <input type="hidden" class="form-control" name="type" value="work">
                                <input type="hidden" class="form-control" name="id" id="workId">
                                {{-- <input type="hidden" name="userId" value="{{$user->id}}" required class="form-control rounded" style="border:none;"> --}}
                                <input type="text" name="name" id="workName" required class="form-control rounded" placeholder="Company" style="border:none;" value="">
                                <hr>
                                <input type="text" name="title" id="workTitle" required class="form-control rounded" placeholder="Position" style="border:none;" value="">
                                <hr>
                                <input type="text" name="city" id="workCity" required class="form-control rounded" placeholder="City/Town" style="border:none;" value="">
                                <hr>
                                <label>I currently working</label>
                                <input class="form-check-input" type="checkbox" name="current_status" id="current_status_working_update">
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>From</label>
                                        <select class="form-control" name="from_year" id="workStartYearUpdate" required>
                                            <option value="" disabled>Select Year From</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6" id="hidetoselect">
                                        <label>To</label>
                                        <select class="form-control" name="to_year" id="workEndYearUpdate" required>
                                            <option value="" disabled>Select Year To</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary d-block w-100 mt-3">Add Work</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-professional-skills" aria-labelledby="work-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Add
                            Professional Skills</h5>
                        <a href="javascript:void(0);" class="lh-1"
                            data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100" action="javascript:void(0)" id="addprofskillForm"  method="POST">
                                @csrf
                                <input type="hidden" class="form-control"
                                    name="type" value="skill">
                                {{-- <input type="text" name="name" required class="form-control rounded" placeholder="Add Skill" style="border:none;"> --}}
                                <input type="text" name="name" required
                                    class="form-control rounded js-example-basic-multiple"
                                    placeholder="Add Skill">
                                <button type="submit"
                                    class="btn btn-primary d-block w-100 mt-3">Add
                                    Professional Skill</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-professional-skills" aria-labelledby="work-modalLabel" aria-hidden="true"role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Edit
                            Professional Skills</h5>
                        <a href="javascript:void(0);" class="lh-1"
                            data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100"  action="javascript:void(0)" id="profskillupdateForm" method="POST">
                                @csrf
                                <input type="hidden" class="form-control"
                                    name="type" value="skill">
                                <input type="hidden" class="form-control"
                                    name="id" id="skillId"
                                    value="skill">
                                <input type="text" name="name"
                                    id="skillname" required
                                    class="form-control rounded js-example-basic-multiple"
                                    placeholder="Add Skill">
                                <button type="submit"
                                    class="btn btn-primary d-block w-100 mt-3">Add
                                    Professional Skill</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-college-data" aria-labelledby="work-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Add College
                        </h5>
                        <a href="javascript:void(0);" class="lh-1"
                            data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100" action="javascript:void(0)" id="collegForm" method="POST">
                                @csrf
                                <input type="hidden" class="form-control"
                                    name="type" value="education">
                                {{-- <input type="hidden" name="userId" value="{{$user->id}}" required class="form-control rounded" style="border:none;"> --}}
                                <select name="name" class="select2 js-data-college-example-ajax">
                                    <option value="" selected disabled>Search College</option>
                                </select>
                                <hr>
                                <input type="text" name="title" required
                                    class="form-control rounded"
                                    placeholder="Degree" style="border:none;">
                                <hr>
                                <input type="text" name="city" required
                                    class="form-control rounded"
                                    placeholder="City/Town"
                                    style="border:none;">
                                <hr>
                                <label>I'm currently studying</label>
                                <input class="form-check-input" type="checkbox"
                                    name="current_status" value=""
                                    id="current_status_education">
                                <hr>
                                <label>Time Period</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control"
                                            name="from_year" id="eduStartYear" required>
                                            <option value="" selected
                                                disabled>Select Year From</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control"
                                            name="to_year" id="eduEndYear" required>
                                            <option value="" selected
                                                disabled>Select Year To</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary d-block w-100 mt-3">Add
                                    College</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-college-data" aria-labelledby="work-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="work-modalLabel">Edit
                            College Details</h5>
                        <a href="javascript:void(0);" class="lh-1"
                            data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100"  action="javascript:void(0)" id="editcollogeupdateForm" method="POST">
                                @csrf
                                <input type="hidden" class="form-control"
                                    name="type" value="education">
                                <input type="hidden" class="form-control"
                                    name="id" id="eduId"
                                    value="education">
                                {{-- <input type="hidden" name="userId" value="{{$user->id}}" required class="form-control rounded" style="border:none;"> --}}
                                <select name="name" id="eduName" class="select2 js-edit-college-example-ajax">
                                </select>
                                <hr>
                                <input type="text" name="title"
                                    id="eduTitle" required
                                    class="form-control rounded"
                                    placeholder="Degree" style="border:none;">
                                <hr>
                                <input type="text" name="city"
                                    id="eduCity" required
                                    class="form-control rounded"
                                    placeholder="City/Town"
                                    style="border:none;">
                                <hr>
                                <label>I'm currently studying</label>
                                <input class="form-check-input" type="checkbox"
                                    name="current_status"
                                    id="current_status_education_update">
                                <hr>
                                <label>Time Period</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control"
                                            name="from_year"
                                            id="eduStartYearUpdate">
                                            <option value="" disabled>Select
                                                Year From</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6" id="hidetoselectedu">
                                        <select class="form-control"
                                            name="to_year"
                                            id="eduEndYearUpdate">
                                            <option value="" disabled>Select
                                                Year To</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary d-block w-100 mt-3">Edit
                                    College Details</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add-places-modal" tabindex="-1" aria-labelledby="places-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="places-modalLabel">Add Place
                            you lived</h5>
                        <a href="javascript:void(0);" class="lh-1"
                            data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100" method="POST" id="placeyoulivedForm" action="javascript:void(0)" >
                                @csrf
                                <select name="currentCity" class="select2 js-data-place-example-ajax" id="place">
                                    <option value="" selected disabled>Search Current Town/City</option>
                                </select>
                                <hr>
                                <select name="homeTown" class="select2 js-data-place-example-ajax">
                                    <option value="" selected disabled>Search Home Town</option>
                                </select>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Moved on</p>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control"
                                            name="move_year" id="moveYear" required>
                                            <option value="" selected
                                                disabled >Select Year</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control"
                                            name="move_month" id="moveMonth" required>
                                            <option value="" selected
                                                disabled>Select Month</option>
                                            <option value="Jan">Jan</option>
                                            <option value="Feb">Feb</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="Sept">Sept</option>
                                            <option value="Oct">Oct</option>
                                            <option value="Nov">Nov</option>
                                            <option value="Dec">Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" data-bs-dismiss="modal"
                                    class="btn btn-primary d-block w-100 mt-3">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-places-modal" tabindex="-1" aria-labelledby="places-modalLabel" aria-hidden="true" role="dialog" style="margin-top: 10rem">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="places-modalLabel">Edit
                            Place you lived</h5>
                        <a href="javascript:void(0);" class="lh-1"
                            data-bs-dismiss="modal">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <form class="post-text ms-3 w-100"

                                method="POST"  action="javascript:void(0)" id="placeliveupd" >
                                @csrf
                                <input type="hidden" name="id"
                                    id="livedId" class="form-control">
                                <select name="currentCity" id="current-city" class="select2 js-edit-place-example-ajax">
                                </select>
                                <hr>
                                <select name="homeTown" id="home-town" class="select2 js-edit-place-example-ajax">
                                </select>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Moved on</p>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control"
                                            name="move_year"
                                            id="moveYearUpdate">
                                            <option value="" disabled>Select
                                                Year</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control"
                                            name="move_month"
                                            id="moveMonthUpdate">
                                            <option value="" disabled>Select
                                                Month</option>
                                            <option value="Jan">Jan</option>
                                            <option value="Feb">Feb</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="Sept">Sept</option>
                                            <option value="Oct">Oct</option>
                                            <option value="Nov">Nov</option>
                                            <option value="Dec">Dec</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" data-bs-dismiss="modal"
                                    class="btn btn-primary d-block w-100 mt-3">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="v-pills-work-tab" role="tabpanel" aria-labelledby="v-pills-work-tab">
            <h4 class="mb-3">Work</h4>
            <ul class="suggestions-lists m-0 p-0">
                <li class="d-flex mb-4 align-items-center">
                    @if ($data['self_profile'])
                        <div class="user-img img-fluid">
                            {{-- <span class="material-symbols-outlined md-18">add</span> --}}
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-work-modal" class="material-symbols-outlined md-18">
                                add
                            </a>
                        </div>
                        <div class="ms-3">
                            <h6>Add Work Place</h6>
                        </div>
                    @endif
                </li>
                <span id="userworklistload" ></span>

            </ul>
            <h4 class="mb-3">Professional Skills</h4>
            <ul class="suggestions-lists m-0 p-0">
                @if ($data['self_profile'])
                    <li class="d-flex mb-4 align-items-center">
                        <div class="user-img img-fluid">
                            {{-- <span class="material-symbols-outlined md-18">add</span> --}}
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-professional-skills" class="material-symbols-outlined md-18">
                                add
                            </a>
                        </div>
                        <div class="ms-3">
                            <h6>Add Professional Skills</h6>
                        </div>
                    </li>
                @endif
                <span id="userskillload"></span>

            </ul>
            <h4 class="mt-3 mb-3">College</h4>
            <ul class="suggestions-lists m-0 p-0">
                @if ($data['self_profile'])
                    <li class="d-flex mb-4 align-items-center">
                        <div class="user-img img-fluid">
                            <a href="#" data-bs-toggle="modal"
                                data-bs-target="#add-college-data"
                                class="material-symbols-outlined md-18">
                                add
                            </a>
                        </div>
                        <div class="ms-3">
                            <h6>Add College</h6>
                        </div>
                    </li>
                @endif

                    <span id="usercollegelistload"></span>
        </div>
        </li>
        </ul>
    </div>
    <div class="tab-pane fade" id="v-pills-lived-tab" role="tabpanel" aria-labelledby="v-pills-lived-tab">
        <h4 class="mb-3">Current City and Hometown</h4>
        <ul class="suggestions-lists m-0 p-0">
            <span id="userlivelistData"></span>
        </ul>
        @if ($data['self_profile'])
            <h4 class="mt-3 mb-3">Add Places Lived</h4>
            <ul class="suggestions-lists m-0 p-0">
                <li class="d-flex mb-4 align-items-center">
                    <div class="user-img img-fluid"><i class="ri-add-fill"></i>
                    </div>
                    <div class="user-img img-fluid">
                        <a href="#" data-bs-toggle="modal"
                            data-bs-target="#add-places-modal"
                            class="material-symbols-outlined md-18">
                            add
                        </a>
                    </div>
                    <div class="ms-3">
                        <h6>Add Place</h6>
                    </div>
                </li>
            </ul>
        @endif
    </div>
</div>
