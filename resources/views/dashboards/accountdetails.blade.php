<x-app-layout>
    <div id="content-page" class="content-page">
        <div class="container">
            <h2 style="margin-bottom: 2rem;">Hello @if($user){{$user->first_name.' '. $user->last_name}}@else User @endif</h2>
            <div class="d-grid gap-3 d-grid-template-1fr-19 grid-cols-3">
                <div class="card mb-0" >
                    <div class="align-items-center card-body d-flex">
                        <span class="material-symbols-outlined">
                            line_style
                        </span>
                        <div class="ms-3">
                            <a href="{{route('user-profile',  ['username' => $user->username])}}" class="mb-0 h6">
                            My Profile
                            </a>
                        </div>
                    </div>
                    <div class="align-items-center card-body d-flex ">
                        <span class="material-symbols-outlined">
                            edit_note
                        </span>
                        <div class="ms-3">
                            <a href="{{route('profileedit')}}" class="mb-0 h6">
                            Edit Profile
                            </a>
                        </div>
                    </div>
                    <div class="align-items-center card-body d-flex ">
                        <span class="material-symbols-outlined">
                            manage_accounts
                        </span>
                        <div class="ms-3">
                            <a href="{{route('accountsetting')}}" class="mb-0 h6">
                            Account Settings
                            </a>
                        </div>
                    </div>
                    <div class="align-items-center card-body d-flex ">
                        <span class="material-symbols-outlined">
                            lock
                        </span>
                        <div class="ms-3">
                            <a href="{{route('privacysetting')}}" class="mb-0 h6">
                            Privacy Settings
                            </a>
                        </div>
                    </div>
                    <div class="align-items-center card-body d-flex ">
                        <span class="material-symbols-outlined">
                            Settings
                        </span>
                        <div class="ms-3">
                            <a href="{{route('generalsetting')}}" class="mb-0 h6">
                            General Settings
                            </a>
                        </div>
                    </div>
                    <div class="align-items-center card-body d-flex ">
                        <span class="material-symbols-outlined">
                            login
                        </span>
                        <div class="ms-3"><form method="POST" action="{{route('logout')}}">
                            @csrf
                            <a href="javascript:void(0)" class="mb-0 h6"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                                {{ __('Sign out') }}
                            </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
