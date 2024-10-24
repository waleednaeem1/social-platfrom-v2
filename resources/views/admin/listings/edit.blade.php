@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.user.store', $listings->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>@lang('Image')</label>
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                        style="background-image: url({{ getImage(getFilePath('listing') . '/' . @$listings->item_image, getFileSize('listing')) }})">
                                                        <button type="button" class="remove-image"><i
                                                                class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="avatar-edit mt-0">
                                                    <input type="file" class="profilePicUpload" name="item_image"
                                                        id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                    <label for="profilePicUpload1"
                                                        class="btn btn--success btn-block btn-lg">@lang('Upload')</label>
                                                    <small>@lang('Support Images'):
                                                        <b>@lang('jpeg'), @lang('jpg').</b> @lang(', resized into 400x400px')
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Name')</label>
                                            <input type="text" name="item_title" 
                                                class="form-control " required value="{{ $listings->item_title }}"
                                                />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Email')</label>
                                            <input type="text" name="item_email" 
                                                class="form-control " required value="{{ $listings->item_email }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Phone')</label>
                                            <input type="text" name="item_phone" 
                                                class="form-control " required value="{{ $listings->item_phone }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group select2-wrapper" id="select2-wrapper-catg">
                                            <label>@lang('Department')</label>
                                            <select class="select2-basic-one form-control" name="department_id" required>
                                                <option disabled selected>@lang('Select One')</option>
                                                @foreach ($departments as $department)
                                                    <option  value="{{ $department->id }}" @selected($department->id == $listings->department_id)>
                                                        {{ __($department->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group select2-wrapper" id="select2-wrapper-country">
                                            <label>@lang('Country')</label>
                                            <select class="select2-basic-one form-control" name="country" required id="country_id" >
                                                <option disabled selected>@lang('Select One')</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" @selected($country->id == $listings->country_id)>
                                                        {{ __($country->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group select2-wrapper" id="select2-wrapper-state">
                                            <label>@lang('State')</label>
                                            <select class="select2-basic-one form-control" name="state" required id="states">
                                                <option disabled selected>@lang('Select One')</option>
                                                @foreach ($states as $state)
                                                    <option  value="{{ $state->id }}" @selected($state->id == $listings->state_id )>
                                                        {{ __($state->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group select2-wrapper" id="select2-wrapper-city">
                                            <label>@lang('City')</label>
                                            <select class="select2-basic-one form-control" name="city" required id="cities">
                                                <option disabled selected>@lang('Select One')</option>
                                                @foreach ($cities as $city)
                                                    <option  value="{{ $city->id }}" @selected($city->id == $listings->city_id)>
                                                        {{ __($city->city_name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Postal Code')</label>
                                            <input type="text" name="item_postal_code" 
                                                class="form-control " required value="{{ $listings->item_postal_code }}" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>@lang('Address')</label>
                                            <input type="text" name="item_address" 
                                                class="form-control " required value="{{ $listings->item_address }}"
                                                />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Latitude')</label>
                                            <input type="text" name="item_lat" 
                                                class="form-control " required value="{{ $listings->item_lat }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Longitude')</label>
                                            <input type="text" name="item_lng" 
                                                class="form-control " required value="{{ $listings->item_lng }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Price')</label>
                                            <input type="number" name="item_price" 
                                                class="form-control " required value="{{ $listings->item_price }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Website')</label>
                                            <input type="text" name="item_website" 
                                                class="form-control " required value="{{ $listings->item_website }}" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Facebook')</label>
                                            <input type="text" name="item_social_facebook" 
                                                class="form-control " required value="{{ $listings->item_social_facebook }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Twitter')</label>
                                            <input type="text" name="item_social_twitter" 
                                                class="form-control " required value="{{ $listings->item_social_twitter }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('LinkedIn')</label>
                                            <input type="text" name="item_social_linkedin" 
                                                class="form-control " required value="{{ $listings->item_social_linkedin }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('WhatsApp')</label>
                                            <input type="text" name="item_social_whatsapp" 
                                                class="form-control " required value="{{ $listings->item_social_whatsapp }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Instagram')</label>
                                            <input type="text" name="item_social_instagram" 
                                                class="form-control " required value="{{ $listings->item_social_instagram }}" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label> @lang('Description')</label>
                                            <textarea name="item_description" class="form-control" rows="5">{{ $listings->item_description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-outline--primary"><i class="la la-undo"></i>
        @lang('Back') </a>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';
            $('.select2-multi-select').select2({
                dropdownParent: $('#select2-wrapper')
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        #select2-wrapper {
            position: relative;
        }
    </style>
@endpush
