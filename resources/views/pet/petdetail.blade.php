<x-app-layout>

    <div class="container">
        <div class="row">
            <div class="col-x-7 col-lg-7 col-xl-9 m-0 py-0 rem-div-1">
                <div class="row">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">{{ $data['pet'][0]->pet_name . ' Details' }}</h4>
                            </div>
                            <div>
                                <a href="javascript:void(0)"><button type="button" class="btn btn-primary me-2 ml-4" data-bs-toggle="modal" data-bs-target=".editMyPet">Edit</button></a>
                                <a href="/my-pets"><button type="button" class="btn btn-primary me-2 ml-4">Back</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade editMyPet" tabindex="-1" role="dialog"   aria-hidden="true" style="top: 6%">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="cover_spin_PetDetailsUpdate"></div>
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Your Pet Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <form class="update-on-ajax" action="{{ route('pet.sharePet') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="petId" value="{{$data['pet'][0]->id}}">
                                        <div class=" row align-items-center">
                                            <div class="form-group col-sm-6">
                                                <label for="name"  class="form-label">Pet Name:</label><span class="text-danger">*</span>
                                                <input type="text" class="form-control" id="name" minlength="2" name="name" placeholder="Pet name" maxlength="14" value="{{$data['pet'][0]->name}}" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="last_name" class="form-label">Species:</label><span class="text-danger">*</span>
                                                <select class="form-control" name="pet_type_id" required>
                                                    <option value="" selected disabled >@lang('Select one option')</option>
                                                    @foreach ($all_pet_types as $pet )
                                                        <option value="{{ $pet->id }}" {{ $data['pet'][0]->pet_type_id == $pet->id ? 'selected' : '' }}>{{ $pet->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Breed(optional)</label>
                                                <input type="text" class="form-control" id="breed" name="breed" placeholder="@lang('Breed')" value="{{$data['pet'][0]->breed}}"  autocomplete="off">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Gender</label>
                                                <select class="form-control" name="gender" required>
                                                    <option value="" selected>@lang('Select gender')</option>
                                                    <option value="male" {{ $data['pet'][0]->gender == 'male' ? 'selected' : '' }}>@lang('Male')</option>
                                                    <option value="female" {{ $data['pet'][0]->gender == 'female' ? 'selected' : '' }}>@lang('Female')</option>
                                                </select>
                                            </div>                                            
                                            <div class="form-group col-sm-6">
                                                <label>Weight</label>
                                                <input type="text" min="0" class="form-control" id="weight" name="weight" placeholder="@lang('Weight')" value="{{$data['pet'][0]->weight}}"  autocomplete="off" required minlength="0" maxlength="5" pattern="^[0-9.]+$" title="Please use only integers or a period (.)">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <div class="btn-group btn-radio-group" data-toggle="buttons">
                                                    <label class="btn cmn-btn border-0 {{ $data['pet'][0]->unit == 'lbs' ? 'active' : '' }} rounded">
                                                        <input type="radio" name="unit" id="option1" autocomplete="off" value="lbs" {{ $data['pet'][0]->unit == 'lbs' ? 'checked' : '' }}> lbs
                                                    </label>
                                                    <label class="btn cmn-btn border-0 {{ $data['pet'][0]->unit == 'kg' ? 'active' : '' }} rounded">
                                                        <input type="radio" name="unit" id="option2" autocomplete="off" value="kg" {{ $data['pet'][0]->unit == 'kg' ? 'checked' : '' }}> kg
                                                    </label>
                                                </div>
                                            </div>                                            
                                            <div class="form-group col-sm-6">
                                                <label>Age</label>
                                                <input type="text" id="age" name="age" class="form-control" placeholder="@lang('Age')" value="{{$data['pet'][0]->age}}" autocomplete="off" minlength="0" maxlength="4" required pattern="^[0-9.]+$" title="Please use only integers or a period (.)">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <div class="btn-group btn-radio-group" data-toggle="buttons">
                                                    <label class="btn cmn-btn active border-0 rounded">
                                                        <input type="radio" name="age_in" id="option1" autocomplete="off" {{ $data['pet'][0]->age_in == 'year' ? 'checked' : '' }} value="year"> year
                                                    </label>
                                                    <label class="btn cmn-btn border-0 rounded">
                                                        <input type="radio" name="age_in" id="option2" autocomplete="off" {{ $data['pet'][0]->age_in == 'month' ? 'checked' : '' }} value="month"> month
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label class="form-label">Short Description</label>
                                                <textarea rows="4" placeholder="@lang('Short Description')" class="form-control" id="short_description" name="short_description">{{ $data['pet'][0]->short_description }}</textarea>
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
                <div class="alert alert-success updatePetMessage d-none" role="alert">
                  </div>
                <div class="row updatepetdetails">
                    <div class="card">
                        <div class="px-1 py-3 row">
                            <div class="col-md-5 d-flex justify-content-center">
                                <img class="rounded-2 " width="250" height="250" src="{{ asset('up_data/pets-of-the-month/'.auth()->user()->id.'//images/') . '/' . $data['pet'][0]['petAttachments'][0]->attachment }}"/>
                            </div>
                            <div class="col-md-7 px-5">
                                <div>
                                    <span style="font-size: 18px; font-weight: 600;">Name: </span>
                                    {{ $data['pet'][0]->name }}
                                </div>
                                <div>
                                    <span style="font-size: 18px; font-weight: 600;">Age: </span>
                                    {{ $data['pet'][0]->age .' '. $data['pet'][0]->age_in }}
                                </div>
                                <div>
                                    <span style="font-size: 18px; font-weight: 600;">Species: </span>
                                    {{ $species }}
                                </div>
                                @if(isset( $data['pet'][0]->breed) &&  $data['pet'][0]->breed != '' &&  $data['pet'][0]->breed != null)
                                    <div>
                                        <span style="font-size: 18px; font-weight: 600;">Breed: </span>
                                        {{ $data['pet'][0]->breed }}
                                    </div>
                                @endif
                                <div>
                                    <span style="font-size: 18px; font-weight: 600;">Gender: </span>
                                    {{ $data['pet'][0]->gender }}
                                </div>
                                <div>
                                    <span style="font-size: 18px; font-weight: 600;">Weight: </span>
                                    {{ $data['pet'][0]->weight .' '. $data['pet'][0]->unit}}
                                </div>
                                <div>
                                    <span style="font-size: 18px; font-weight: 600;">Slug: </span>
                                    {{ $data['pet'][0]->slug }}
                                </div>
                                @if(isset( $data['pet'][0]->short_description) &&  $data['pet'][0]->short_description != '' &&  $data['pet'][0]->short_description != null)
                                    <div>
                                        <span style="font-size: 18px; font-weight: 600;">Short Description: </span>
                                        {{ $data['pet'][0]->short_description }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card row">
                    <div class="col-md-12" style="background-color: #ffffff; padding-top:2rem;">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                @foreach ($data['pet'][0]['petAttachments'] as $key => $attachment)    
                                    @if($attachment->attachment_type == 'image' && $key != 0)
                                        <button class="nav-link active" id="nav-image-tab" data-bs-toggle="tab" data-bs-target="#nav-image" type="button" role="tab" aria-controls="nav-image" aria-selected="false">Images</button>
                                        @php $active = true; @endphp
                                        @break
                                    @endif
                                @endforeach
                                @foreach ($data['pet'][0]['petAttachments'] as $key => $attachment)
                                    @if($attachment->attachment_type == 'video')
                                        <button class="nav-link @if(!isset($active)) active @endif" id="nav-video-tab" data-bs-toggle="tab" data-bs-target="#nav-video" type="button" role="tab" aria-controls="nav-video" aria-selected="false">Videos</button>
                                    @break
                                    @endif
                                @endforeach
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade active show" id="nav-image" role="tabpanel" aria-labelledby="nav-image-tab"
                                tabindex="0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="blog-thumb p-3">
                                            <div class="row">
                                                @foreach ($data['pet'][0]['petAttachments'] as $key => $image)    
                                                    @if($image->attachment_type == 'image' && $key != 0)
                                                        <div class="col-4 mb-4">
                                                            <img class="rounded-2" style="object-fit: cover;" width="100%" height="250" src="{{ asset('up_data/pets-of-the-month/'.auth()->user()->id.'//images/') . '/' . $image->attachment }}"/>
                                                            {{-- <a href="javascript:void(0);" onclick="" class="material-symbols-outlined deletePetIcon">delete</a> --}}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!isset($active)) active show @endif" id="nav-video" role="tabpanel" aria-labelledby="nav-video-tab"
                                tabindex="0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row blog-thumb p-3">
                                            @foreach ($data['pet'][0]['petAttachments'] as $video)  
                                                @if($video->attachment_type == 'video')
                                                    <div class="col-sm-6 col-12 mb-4">  
                                                        <video class="rounded-3 w-100" controls="" height="auto" style="height: 400px">
                                                            <source src="{{ asset('up_data/pets-of-the-month/'.auth()->user()->id.'//videos/') . '/' . $video->attachment }}">
                                                        </video>
                                                    </div>
                                                @endif
                                            @endforeach
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
    <script>
        $(document).on('submit', 'form.update-on-ajax', function(e) {
            var id = $(this).attr('id');
            
            if(id == undefined)
                $('.cover_spin_PetDetailsUpdate').show();

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
                    if(response.status === 'updated'){
                        $('.updatePetMessage').text(response.message);
                        $('.updatePetMessage').removeClass('d-none');
                        setTimeout(function() {
                            $('.updatePetMessage').addClass('d-none');
                        }, 2000);
                        $(".updatepetdetails").hide().load(" .updatepetdetails"+"> *").fadeIn(0);
                        $('.cover_spin_PetDetailsUpdate').hide();
                    }
                },
                complete: function() {
                    if(id == undefined){
                        $('.editMyPet').modal('hide');
                    }
                },
            
            });

        });
    </script>
</x-app-layout>
