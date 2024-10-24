<x-app-layout>
        <div class="container">
            <div class="row">
                <div class="col-x-8 m-0 py-0 rem-div-1">
                    <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Privacy Setting</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="privacySettingSuccess"></div>
                    <form class="update-form" action="{{ route('users.privacy') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" class="form-control" id="personalInformation" name="type" value="privacySetting">
                            <div class="acc-privacy">
                                <div class="data-privacy">
                                    <h4 class="mb-2">Account Privacy</h4>
                                    <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" id="acc-private" name="account_privacy" value="1" {{ old('account_privacy') == 1 ? 'checked' : '' }} @if($users->account_privacy == '1') checked @endif>
                                    <label class="form-check-label privacy-status mb-2" for="acc-private">Private Account</label>
                                    </div>
                                    <p>You have the option of creating a public or private account. Anyone can access a public account and view what you share. Click on the checkbox to set your account to private so that only your friends and followers can view your profile and account.</p>
                                </div>
                                {{-- <hr>
                                <div class="data-privacy">
                                    <h4 class="mb-2">Activity Status</h4>
                                    <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" id="activety" name="activity_status" value="1" {{ old('activity_status') == 1 ? 'checked' : '' }} @if($users->activity_status == '1') checked @endif>
                                    <label class="form-check-label privacy-status mb-2" for="activety">Show Activity Status</label>
                                    </div>
                                    <p>You can choose whether or not you want others to know you are active. When you hide your active status, others will not know when you are online. Click on the checkbox to make your activity visible so that others can approach you when you're online.</p>
                                </div> --}}
                                <hr>
                                <div class="data-privacy">
                                    <h4 class="mb-2"> Newsfeeds (Timeline)</h4>
                                    <div class="form-check form-check-inline">

                                    {{-- <label class="form-check-label privacy-status mb-2" for="story">Allow Sharing (Timeline)</label> --}}
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="public" name="story_sharing" class="form-check-input" value="public" @if($users->story_sharing == 'public') checked @endif>
                                            <label class="form-check-label" for="public"> Public </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-2">
                                            <input type="radio" id="onlyme" name="story_sharing" class="form-check-input" value="only_me" @if($users->story_sharing == 'only_me') checked @endif>
                                            <label class="form-check-label" for="only_me"> Only Me </label>
                                        </div>
                                    </div>
                                    <p>A public account feeds can be viewed by anyone, while followers can only view a private account's feeds. You can always control who sees your it by checking the box to make it public.</p>
                                </div>
                                {{-- <hr>
                                <div class="data-privacy">
                                    <h4 class="mb-2"> Photo Of You </h4>
                                    <div class="custom-control custom-radio">
                                    <input type="radio" id="automatically" name="photo_of_you" class="form-check-input" value="automatically"  @if($users->photo_of_you == 'automatically') checked @endif>
                                    <label class="form-check-label" for="automatically"> Add Automatically</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-2">
                                    <input type="radio" id="manualy" name="photo_of_you" class="form-check-input" value="manualy" @if($users->photo_of_you == 'manualy') checked @endif>
                                    <label class="form-check-label" for="manualy"> Add Manualy</label>
                                    </div>
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                                </div> --}}
                                <hr>
                                <div class="data-privacy">
                                    <h4 class="mb-2"> Your Profile (About Section) </h4>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="public" name="your_profile" class="form-check-input" value="public" @if($users->your_profile == 'public') checked @endif>
                                        <label class="form-check-label" for="public"> Public </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="friend" name="your_profile" class="form-check-input" value="friend" @if($users->your_profile == 'friend') checked @endif>
                                        <label class="form-check-label" for="friend"> Friend </label>
                                    </div>
                                    {{-- <div class="custom-control custom-radio">
                                        <input type="radio" id="spfriend" name="your_profile" class="form-check-input" value="specific_friend" @if($users->your_profile == 'specific_friend') checked @endif>
                                        <label class="form-check-label" for="specific_friend"> Specific Friend </label>
                                    </div> --}}
                                    <div class="custom-control custom-radio mb-2">
                                        <input type="radio" id="onlyme" name="your_profile" class="form-check-input" value="only_me" @if($users->your_profile == 'only_me') checked @endif>
                                        <label class="form-check-label" for="only_me"> Only Me </label>
                                    </div>
                                    <p>Choose who can view the information on your profile. You can make your personal data, profile, and other information private by limiting who can see it.</p>
                                </div>
                                <hr>
                                <div class="data-privacy">
                                    <h4 class="mb-2"> Messages </h4>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="anyone" name="your_message" class="form-check-input" value="anyone" @if($users->your_message == 'anyone') checked @endif>
                                        <label class="form-check-label" for="anyone"> Anyone </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="friend" name="your_message" class="form-check-input" value="friend" @if($users->your_message == 'friend') checked @endif>
                                        <label class="form-check-label" for="friend"> Friend </label>
                                    </div>
                                    <p>Choose who can send you message. You can stop any user who is not a friend to send you message by limiting it to only friend.</p>
                                </div>
                                <hr>
                                <div class="data-privacy">
                                    <h4 class="mb-2"> Notifications </h4>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="enable" name="login_notification" class="form-check-input" value="enable" @if($users->content_notification == 'enable') checked @endif>
                                        <label class="form-check-label" for="enable"> Enable </label>
                                    </div>
                                    <div class="custom-control custom-radio mb-2">
                                        <input type="radio" id="disable" name="login_notification" class="form-check-input" value="disable" @if($users->content_notification == 'disable') checked @endif>
                                        <label class="form-check-label" for="disable"> Disable </label>
                                    </div>
                                    <p>If you enable notifications, you will receive notification related to your account content. You can, however, disable the notification if you want to avoid this inconvenience.</p>
                                </div>
                                <hr>
                                <div class="data-privacy">
                                    <h4 class="mb-2">Privacy Help</h4>
                                    <a href="{{route('footer.customersupport')}}"><i class="ri-customer-service-2-line me-2"></i>Support</a>
                                </div>
                            </div>
                            <button type="submit" onclick="scrollToTop()" class="btn btn-primary me-2 my-4">Update Privacy Setting</button>
                       </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>
