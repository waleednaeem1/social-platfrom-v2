{{-- user info and avatar --}}
@php
    $user = auth()->user();
@endphp
{{-- <img src="{{}}}" alt="" /> --}}
@if(isset($user->avatar_location) && $user->avatar_location !== '')
    <img src="{{ asset('storage/images/user/userProfileandCovers/'. $user->id.'/'.$user->avatar_location) }}" alt="userimg" class="avatar av-l chatify-d-flex" style="margin-left: 6rem" loading="lazy">
@else
    <div class="avatar av-l chatify-d-flex"></div>
@endif

{{-- <p class="info-name">{{ config('chatify.name') }}</p> --}}
<p class="info-name">{{$user->first_name.' '.$user->last_name}}</p>
<div class="messenger-infoView-btns">
    {{-- <a href="#" class="default"><i class="fas fa-camera"></i> default</a> --}}
    <a href="#" class="danger delete-conversation"><i class="fas fa-trash-alt"></i> Delete Conversation</a>
</div>
{{-- shared photos --}}
<div class="messenger-infoView-shared">
    <p class="messenger-title">shared photos</p>
    <div class="shared-photos-list"></div>
</div>
