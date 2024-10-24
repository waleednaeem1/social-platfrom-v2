@php
   $user = auth()->user();
@endphp
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

<x-app-layout>
    <div class="container">
        <div class="row">
           <div class="col-lg-9">
              <h3 style="margin-left: 4rem">Create Group</h3>
              <div class="card" style="margin-left: 4rem">
                 <div class="card-body">
                    <div class="d-flex align-items-center">
                     <form class="post-text ms-3 w-100" action="" method="" enctype="multipart/form-data" id="createGroupFormSubmit">
                        @csrf
                        {{-- <input type="hidden" name="userId" value={{$user->id}} required class="form-control rounded" style="border:none;"> --}}
                        <input type="hidden" name="image_url" id="image_url" value="">
                        {{-- <label>Profile Image</label>
                        <input type="file" name="profileImage" id="profileImage" required class="form-control" accept="image/*" placeholder="Profile Image" style="border:none;">
                        <hr>
                        <label>Cover Image</label>
                        <input type="file" name="coverImage" id="coverImage" required class="form-control" accept="image/*" placeholder="Cover Image" style="border:none;">
                        <hr> --}}
                        <input type="text" name="groupName" required class="form-control rounded" placeholder="Group Name" style="border:none;">
                        <hr>
                        <input type="text" name="shortDescription" required class="form-control rounded" placeholder="Short Description" style="border:none;">
                        <hr>
                        <label class="form-label d-block mt-4">Group Type<span class="text-danger">*</span></label>
                           <div class="form-check form-check-inline">
                                 <input class="form-check-input" required type="radio" name="groupType" id="inlineRadio10" value="Public">
                                 <label class="form-check-label" for="inlineRadio10"> Public</label>
                           </div>
                           <div class="form-check form-check-inline">
                                 <input class="form-check-input" type="radio" name="groupType" id="inlineRadio11" value="Private">
                                 <label class="form-check-label" for="inlineRadio11">Private</label>
                           </div>
                       <hr>
                        <button type="submit" id="createGroupButtonClick" class="btn btn-primary d-block w-100 mt-3">Create Group</button>
                     </form>
                 </div>
              </div>
           </div>
        </div>
     </div>
     <script>
        $('#createGroupFormSubmit').on('submit', function(e){

        e.preventDefault();
        // Disable submit button
        $('#createGroupButtonClick').attr('disabled','disabled');

        $.ajax({
        url:'/createGroup',
        method:'POST',
        data:new FormData(this),
        processData:false,
        dataType:'json',
        contentType:false
        }).done(function(response){
        console.log(response.groupId);
        // Enable submit button
        $('#createGroupButtonClick').removeAttr('disabled');
         document.getElementById("createGroupFormSubmit").reset();
        // Redirect to groupdetail with dynamic groupId value
        window.location.href = '/groupdetail/' + response.groupId;
        });
        });
     </script>
</x-app-layout>
