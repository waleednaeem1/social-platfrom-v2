<style>
    .modal {
    --bs-modal-width: 800px !important;
}
</style>
<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                {{-- <div class="card-header d-flex justify-content-between" style="margin-bottom: 3rem">
                    <div class="header-title">
                        <h4 class="card-title">Pet of the Month
                            <span>
                                <button type="button" class="btn btn-primary me-2 ml-4" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl" style="margin-left: 690px;">Share Your Pet</button>
                            </span>
                        </h4>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">My Pets</h4>
                            </div>
                            <button type="button" class="btn btn-primary me-2 ml-4" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl">Add Your Pet Details</button>
                        </div>
                    </div>
                </div>
                <div class="row" id="petOfTheMonth">
                    @if(count($data['pets']) > 0)
                        @foreach($data['pets'] as $pet)
                        {{-- @dd($pet['images'][0]->pet_image); --}}
                            <div class="col-md-6">
                                <div class="card-body profile-page p-0">
                                    <div class="profile-header-image">
                                        <div class="profile-info p-2">
                                            <div class="user-detail">
                                                <a href="{{route('pet.petdetail',  ['id' => $pet->id])}}" >
                                                    <div class="profile-detail">
                                                        @if(isset($pet['petAttachments'][0]->attachment) && $pet['petAttachments'][0]->attachment !== '')
                                                            <div class="align-items-center d-flex justify-content-center">
                                                                <div class="rounded-circle" style="background-image: url({{asset('up_data/pets-of-the-month/'.auth()->user()->id.'//images/').'/'.$pet['petAttachments'][0]->attachment}}); background-size: cover; background-position: center; background-repeat: no-repeat; width: 250px !important; height: 250px !important;">
                                                                    <img src="{{asset('up_data/pets-of-the-month/frame/frame3.png')}}" style="width:250px; height:250px;" />
                                                                </div>
                                                            </div>
                                                        @else
                                                            <img src="{{asset('images/user/Users_150x150.png')}}" alt="frame" />
                                                        @endif
                                                        {{-- <h2 style="color:blueviolet; text-align:center; padding-top: 10px;">{{$pet->pet_name}}</h2> --}}
                                                        <div class="d-flex justify-content-around mt-3">
                                                            <form id="{{$pet->id}}" class="update-on-ajax" action="{{ route('pet.petBadgeRequest', $pet->slug)}}" method="post">
                                                                @csrf
                                                                <button class="btn btn-primary pet-badge-btn-{{$pet->id}}" type="submit"> Request Badge </button>
                                                            </form>
                                                            {{-- @if (isset($pet['getUser']) && $pet['getUser']->pet_parent == 'yes')
                                                                @php
                                                                    $currentDate = now();
                                                                    $startOfMonth = now()->startOfMonth();
                                                                    $endOf20thDay = now()->startOfMonth()->addDays(20);
                                                                @endphp

                                                                @if ($currentDate >= $startOfMonth && $currentDate <= $endOf20thDay)
                                                                    <form action="{{ route('pet.petOfTheMonthRequest', $pet->id)}}" method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="user_id" value="{{$pet->user_id}}">
                                                                        <button class="btn btn-primary" type="submit"> Request for Pet of the Month </button>
                                                                    </form>
                                                                @endif
                                                            @endif --}}
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h2 style="color:blueviolet; text-align:center;">No pet available.</h2>
                    @endif
                </div>
                <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"   aria-hidden="true" style="top: 6%">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="cover_spin_ProfilePhotoUpdate"></div>
                            <div class="modal-header">
                                <h5 class="modal-title">Add Your Pet Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <form class="update-on-ajax update-on-ajax-reset" action="{{ route('pet.sharePet') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <div class=" row align-items-center">
                                            <div class="form-group col-sm-6">
                                                <label for="name"  class="form-label">Pet Name:</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control" id="name" minlength="2" name="name" placeholder="Pet name" maxlength="14" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="last_name" class="form-label">Species:</label><span class="text-danger">*</span>
                                                <select class="form-control" name="pet_type_id" required>
                                                    <option value="" selected disabled >@lang('Select one option')</option>
                                                    @foreach ($pet_type as $pet )
                                                        <option value="{{ $pet->id }}" >{{ $pet->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Breed(optional)</label>
                                                <input type="text" class="form-control" id="breed" name="breed" placeholder="@lang('Breed')" value="{{ old('breed') }}"  autocomplete="off">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Gender</label>
                                                <select class="form-control" name="gender" required>
                                                    <option value="" selected>@lang('Select gender')</option>
                                                    <option value="male">@lang('Male')</option>
                                                    <option value="female">@lang('Female')</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Weight</label>
                                                <input type="text" min="0" class="form-control" id="weight" name="weight" placeholder="@lang('Weight')" value="{{ old('weight') }}"  autocomplete="off" required minlength="0" maxlength="5" pattern="^[0-9.]+$" title="Please use only integers or a period (.)">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <div class="btn-group btn-radio-group" data-toggle="buttons">
                                                    <label class="btn cmn-btn border-0 active rounded">
                                                        <input type="radio" name="unit" id="option1" autocomplete="off" checked value="lbs"> lbs
                                                    </label>
                                                    <label class="btn cmn-btn border-0 rounded">
                                                        <input type="radio" name="unit" id="option2" autocomplete="off" value="kg" > kg
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Age</label>
                                                <input type="text" id="age" name="age" class="form-control" placeholder="@lang('Age')" value="{{ old('age') }}" autocomplete="off" minlength="0" maxlength="4" required pattern="^[0-9.]+$" title="Please use only integers or a period (.)">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <div class="btn-group btn-radio-group" data-toggle="buttons">
                                                    <label class="btn cmn-btn active border-0 rounded">
                                                        <input type="radio" name="age_in" id="option1" autocomplete="off" checked value="year"> year
                                                    </label>
                                                    <label class="btn cmn-btn border-0 rounded">
                                                        <input type="radio" name="age_in" id="option2" autocomplete="off" value="month"> month
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Image</label>
                                                <input type="file" class="form-control" id="images" multiple name="images[]" placeholder="@lang('Image')" value="{{ old('image') }}" required accept=".jpeg, .jpg, .png">
                                                <div class="image-error text-danger"></div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Video</label>
                                                <input type="file" class="form-control" id="video" name="video[]" multiple placeholder="@lang('Video')" value="{{ old('video') }}" requidanger accept="video/mp4,video/x-m4v,video/*">
                                                <div class="vedio-error text-danger"></div>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label class="form-label">Short Description</label>
                                                <textarea rows="4" placeholder="@lang('Short Description')" class="form-control" id="short_description" name="short_description">{{ old('short_description') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" >Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('input[type="file"]').change(function () {
                var inputId = $(this).attr('id');
                var file = $(this)[0].files[0];

                if (file) {
                    var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (inputId === 'images' && !allowedTypes.includes(file.type)) {
                        $('.image-error').html('Please select a valid image file jpg, jpeg, png etc.');
                        $(this).val(''); 
                    }
                    else if (inputId === 'video' && !file.type.startsWith('video/')) {
                        $('.vedio-error').html('Please select a valid video file.');
                        $(this).val(''); 
                    }
                    else {
                        $('.image-error').html('');
                        $('.vedio-error').html('');
                    }
                }
            });
        });

        $(document).on('submit', 'form.update-on-ajax', function(e) {
            var id = $(this).attr('id');
            
            if(id == undefined)
                $('.cover_spin_ProfilePhotoUpdate').show();

            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(response) {
                    if (response.type === 'petBadgeRequest') {
                        var button = $('.pet-badge-btn-'+id);
                        button.html('Request Sent Successfully');
                        button.removeClass('btn-primary');
                        button.addClass('btn-success');
                        button.prop('disabled', true);
                        return;
                    }else{
                        $("#petOfTheMonth").hide().load(" #petOfTheMonth"+"> *").fadeIn(0);
                        $('.cover_spin_ProfilePhotoUpdate').hide();
                    }
                },
                complete: function() {
                    if(id == undefined){
                        $('.bd-example-modal-xl').modal('hide');
                        $('.update-on-ajax-reset')[0].reset();
                    }
                },
            
            });

        });
    </script>
</x-app-layout>
