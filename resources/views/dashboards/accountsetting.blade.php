<x-app-layout>
<div class="container">
@php
    $user = auth()->user();
@endphp
        <div class="row">
            <div class="col-x-8 m-0 py-0 rem-div-1">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Account Setting</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="accountSettingsuccess"></div>
                                <div class="acc-edit">
                                    <form action="{{ route('users.update',$users->id ?? '') }}" class="update-form" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" class="form-control" id="accountSetting" name="type" value="accountSetting">
                                        <div class="form-group">
                                        <label for="username" class="form-label">Username:</label>
                                        <input disabled type="text" class="form-control" id="username" name="username" value="{{$user->username}}">
                                        </div>
                                        <div class="form-group">
                                        <label for="email" class="form-label">Primary Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" readonly>
                                        </div>
                                        <div class="form-group">
                                        <label for="altemail" class="form-label">Alternate Email:</label>
                                        <input type="email" class="form-control" id="altemail" name="altemail"  value="{{$users->altemail}}">
                                        <div id="alt_email"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block form-label">Languages:</label>
                                            {{-- <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" name="language_eng" value="1" {{ old('language_eng') == 1 ? 'checked' : '' }} @if($users->language_eng == '1') checked @endif id="english">
                                                <label class="form-check-label" for="english">English</label>
                                            </div> --}}
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" name="language_french" value="1" {{ old('language_french') == 1 ? 'checked' : '' }} @if($users->language_french == '1') checked @endif id="french">
                                                <label class="form-check-label" for="french">French</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" name="language_chinese" value="1" {{ old('language_chinese') == 1 ? 'checked' : '' }} @if($users->language_chinese == '1') checked @endif id="hindi">
                                                <label class="form-check-label" for="hindi">Chinese</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" name="language_spanish" value="1" {{ old('language_spanish') == 1 ? 'checked' : '' }} @if($users->language_spanish == '1') checked @endif id="spanish">
                                                <label class="form-check-label" for="spanish">Spanish</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" name="language_arabic" value="1" {{ old('language_arabic') == 1 ? 'checked' : '' }} @if($users->language_arabic == '1') checked @endif id="arabic">
                                                <label class="form-check-label" for="arabic">Arabic</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" name="language_italian" value="1" {{ old('language_italian') == 1 ? 'checked' : '' }} @if($users->language_italian == '1') checked @endif id="italian">
                                                <label class="form-check-label" for="italian">Italian</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                                        {{-- <button type="reset" class="btn bg-soft-danger">Cancel</button> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Social Media</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="socialLinkSuccess"></div>
                            <div class="acc-edit">
                                <form action="{{ route('users.update',$users->id ?? '') }}" method="POST" class="update-form">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" class="form-control" id="socialLink" name="type" value="socialLink">
                                    <div class="form-group">
                                        <label for="facebook" class="form-label">Facebook:</label>
                                        <input type="url" class="form-control" id="facebook" name="facebook_link" value="{{$users->facebook_link}}">
                                    </div>
                                    <div class="form-group">
                                    <label for="twitter" class="form-label">Twitter:</label>
                                    <input type="url" class="form-control" id="twitter" name="twitter_link" value="{{$users->twitter_link}}">
                                    </div>
                                    <div class="form-group">
                                    <label for="google" class="form-label">Google +:</label>
                                    <input type="url" class="form-control" id="google" name="google_link" value="{{$users->google_link}}">
                                    </div>
                                    <div class="form-group">
                                    <label for="instagram" class="form-label">Instagram:</label>
                                    <input type="url" class="form-control" id="instagram" name="instagram_link" value="{{$users->instagram_link}}">
                                    </div>
                                    <div class="form-group">
                                    <label for="youtube" class="form-label">You Tube:</label>
                                    <input type="url" class="form-control" id="youtube" name="youtube_link" value="{{$users->youtube_link}}">
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    {{-- <button type="reset" class="btn bg-soft-danger">Cancel</button> --}}
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script></script>
