@php
   $user = auth()->user();
@endphp
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

<x-app-layout>
    <div class="container">
        <div class="row">
           <div class="col-lg-9">
              <h3 style="margin-left: 4rem; margin-bottom:2rem">Create Page</h3>
              <div class="card" style="margin-left: 4rem">
                 <div class="card-body">
                    <div class="d-flex align-items-center">
                     <form class="post-text ms-3 w-100" action="{{ route('createPage') }}" method="" enctype="multipart/form-data" id="createPageFormSubmit">
                        @csrf
                        <input type="hidden" name="userId" value={{$user->id}} required class="form-control rounded" style="border:none;">
                        <input type="hidden" name="image_url" id="image_url" value="">
                        {{-- <label>Profile Image</label>
                        <input type="file" name="profileImage" id="profileImage" required class="form-control" accept="image/*" placeholder="Profile Image" style="border:none;">
                        <hr>
                        <label>Cover Image</label>
                        <input type="file" name="coverImage" id="coverImage" required class="form-control" accept="image/*" placeholder="Cover Image" style="border:none;">
                        <hr> --}}
                        <label class="form-label d-block mt-4">Page Name <span class="text-danger">*</span> </label>
                        <input type="text" name="pageName" required class="form-control rounded">
                        <label for="category" class="form-label d-block mt-4">Category <span class="text-danger">*</span></label>
                        <select name="category[]" id="category" class="form-control" multiple required>
                            @foreach ($data['pageCategories'] as $pageCategory)
                                <option value="{{ $pageCategory->category }}">{{ $pageCategory->category }}</option>
                            @endforeach
                        </select>
                        {{-- <input type="text" name="shortDescription" required class="form-control rounded" placeholder="Short Description" style="border:none;"> --}}
                        <label class="form-label d-block mt-4">Bio</label>
                        <textarea class="form-control" name="bio" aria-label="Bio"></textarea>
                        {{-- <label class="form-label d-block mt-4">Page Type<span class="text-danger">*</span></label>
                           <div class="form-check form-check-inline">
                                 <input class="form-check-input" required type="radio" name="pageType" id="inlineRadio10" value="Public">
                                 <label class="form-check-label" for="inlineRadio10"> Public</label>
                           </div>
                           <div class="form-check form-check-inline">
                                 <input class="form-check-input" type="radio" name="pageType" id="inlineRadio11" value="Private">
                                 <label class="form-check-label" for="inlineRadio11">Private</label>
                           </div>
                       <hr> --}}
                        <button type="submit" id="createPageButtonClick" class="btn btn-primary d-block w-100 mt-3">Create Page</button>
                     </form>
                 </div>
              </div>
           </div>
        </div>
     </div>
<script>
$(document).ready(function() {
    $('#category').select2({
        placeholder: 'Select category',
        allowClear: true,
        maximumSelectionLength: 3,
        language: {
            maximumSelected: function(maximum) {
                return "You can only select up to " + 3 + " categories";
            }
        }
    });
});
</script>
</x-app-layout>
