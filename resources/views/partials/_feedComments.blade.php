@php
    use App\Models\GroupMembers;
    $user = auth()->user();
    $Class = optional($feed->pageDetails)->id ? '-page-' : (optional($feed->groupDetails)->id ? '-group-' : '');
@endphp
<div class="comment-area mt-3" id="comment-area{{$Class.$feed->id}}" >
    <div class="">
        <div class="like-block position-relative d-flex justify-content-between align-items-center" id="UpdateLikeCommentCount{{$Class.$feed->id}}" >
            <div class="d-flex align-items-center">
                <div class="total-like-block ms-2 me-3">
                    <div class="dropdown">
                        <span class="span-likeCount{{$Class.$feed->id}}"
                            @if (isset(optional($feed->pageDetails)->id)) 
                                onclick="openModalFeedLike('{{ $feed->id }}', 'newsFeedLikes', 'pageDetails')" 
                            @elseif(isset(optional($feed->groupDetails)->id))
                                onclick="openModalFeedLike('{{ $feed->id }}', 'newsFeedLikes', 'groupDetails')" 
                            @else
                                onclick="openModalFeedLike('{{ $feed->id }}', 'newsFeedLikes', 'profileFeed')" 
                            @endif 
                            style="cursor: pointer;"
                        >
                            {{$feed->likes_count == 0 ? '' : ($feed->likes_count <= 1 ? $feed->likes_count.' Like' : $feed->likes_count.' Likes')}}
                        </span>
                    </div>
                </div>
            </div>
            <div class="total-comment-block">
                <span class="span-commentCount{{$Class.$feed->id}}"
                    @if (isset(optional($feed->pageDetails)->id)) 
                        onclick="openModalFeedLike('{{ $feed->id }}', 'newsFeedComments', 'pageDetails')" 
                    @elseif(isset(optional($feed->groupDetails)->id))
                        onclick="openModalFeedLike('{{ $feed->id }}', 'newsFeedComments', 'groupDetails')" 
                    @else
                        onclick="openModalFeedLike('{{ $feed->id }}', 'newsFeedComments', 'profileFeed')" 
                    @endif
                    style="cursor: pointer;"
                >
                    {{$feed->comments_count == 0 ? '' : ($feed->comments_count <= 1 ? $feed->comments_count.' Comment' : $feed->comments_count.' Comments')}}
                </span>                
            </div>
        </div>
    </div>
    <hr>
    <div class="like-block justify-content-around position-relative d-flex align-items-center" id="total-like-block{{$Class.$feed->id}}">
       <div class="total-like-block d-flex align-items-center feather-icon mt-2 mt-md-0">
            @if(isset($feed['likes']) && $feed['likes']->pluck('user_id')->contains(auth()->user()->id))
                <span class="d-flex" 
                    @if(isset(optional($feed->pageDetails)->id) )
                        onclick="savePagePostLike({{$feed->id}}, {{$user->id}}, 'like', {{$data['pageDetail'][0]->id}})"
                    @elseif(isset(optional($feed->groupDetails)->id))
                        onclick="saveGroupLike({{$feed->id}}, {{$user->id}}, 'like', {{$data['groupDetail'][0]->id}})"
                    @else
                        onclick="savePostLike({{$feed->id}}, {{$user->id}}, 'like')" 
                    @endif
                    href="javascript:void(0);"
                >
                    <span class="material-symbols-outlined material-symbols-outlined-filled text-primary pe-2 span-like{{$Class.$feed->id}}">thumb_up</span>Like
                </span>
            @else
                <span class="d-flex" 
                    @if(isset(optional($feed->pageDetails)->id) )
                        onclick="savePagePostLike({{$feed->id}}, {{$user->id}}, 'like', {{$data['pageDetail'][0]->id}})"
                    @elseif(isset(optional($feed->groupDetails)->id))
                        onclick="saveGroupLike({{$feed->id}}, {{$user->id}}, 'like', {{$data['groupDetail'][0]->id}})"
                    @else
                        onclick="savePostLike({{$feed->id}}, {{$user->id}}, 'like')" 
                    @endif
                    href="javascript:void(0);"
                >
                    <span class="material-symbols-outlined md-18 pe-2 span-like{{$Class.$feed->id}}">thumb_up</span> Like
                </span>
            @endif 
       </div>
       <div class="total-comment-block d-flex align-items-center feather-icon mt-2 mt-md-0">
            <span class="material-symbols-outlined md-18">chat_bubble</span>
            <span class="ms-1 dropdown-toggle" onclick="commentInputFocus({{$feed->id}},'{{$Class}}')">Comment</span>
       </div>
       <div class="share-block d-flex align-items-center feather-icon mt-2 mt-md-0">

            <div class="dropdown">
                <span class="d-flex alighn-items-center justify-content-center" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                    {{-- <span class="material-symbols-outlined md-18">
                        share
                    </span> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="22px" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 120 120" style="enable-background:new 0 0 120 120;" xml:space="preserve">
                        <g>
                            <g>
                                <path class="st0" d="M67.47,15.66l43.8,43.8l-43.8,44.13V78.71v-4.56l-4.54-0.42c-0.17-0.02-1.76-0.16-4.37-0.16    c-9.11,0-35.09,1.87-51.17,21.72c1.38-12.2,5.23-27.39,15.2-38.5c9.33-10.4,22.75-15.67,39.88-15.67h5v-5V15.66 M62.47,3.59v32.54    c-69.31,0-60.43,80.29-60.43,80.29C12.34,81.6,46.86,78.58,58.56,78.58c2.46,0,3.91,0.13,3.91,0.13v37.01l55.86-56.28L62.47,3.59    L62.47,3.59z"/>
                            </g>
                        </g>
                    </svg>
                    <span class="ms-1">@if($feed->share_count == 0 ) Share @elseif ($feed->share_count <=1) {{$feed->share_count}} Share @else {{$feed->share_count}} Shares @endif</span>
                </span>
            
                <div class="dropdown-menu m-0 p-0">
                    @if(!isset(optional($feed->pageDetails)->id) && !isset(optional($feed->groupDetails)->id))
                        <div class="dropdown-item px-0 d-flex align-items-top" >
                            <div class="data ms-2">
                                <a
                                    @if (isset(optional($feed->pageDetails)->id))
                                        onclick="openModalFeedLike('{{ $feed->id }}', 'shareFeed', 'pageDetails')"
                                    @elseif(isset(optional($feed->groupDetails)->id))
                                        onclick="openModalFeedLike('{{ $feed->id }}', 'shareFeed', 'groupDetails')"
                                    @else
                                        onclick="openModalFeedLike('{{ $feed->id }}', 'shareFeed', 'profileFeed')"
                                    @endif 
                                    href="javascript:void(0);" 
                                    class="d-flex items-center align-items-center "
                                >
                                    <svg class="a2a_svg" fill="#777d74" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" ><g><rect fill="none" height="24" width="24"/></g><g><path d="M22,3l-1.67,1.67L18.67,3L17,4.67L15.33,3l-1.66,1.67L12,3l-1.67,1.67L8.67,3L7,4.67L5.33,3L3.67,4.67L2,3v16 c0,1.1,0.9,2,2,2l16,0c1.1,0,2-0.9,2-2V3z M11,19H4v-6h7V19z M20,19h-7v-2h7V19z M20,15h-7v-2h7V15z M20,11H4V8h16V11z"/></g></svg>
                                    NewsFeed
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="dropdown-item px-0 d-flex align-items-top" >
                        <div class="data ms-2">
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="{{ route('feedDetail', base64_encode('feed_'.$Class.'_'.$feed->id)) }}" data-a2a-title="{{$feed->post}}">
                                <a class="a2a_button_facebook d-flex items-center align-items-center">
                                    <svg class="a2a_svg" fill="#777d74" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg>
                                    Facebook
                                </a>
                            </div> 
                        </div>
                    </div>
                    <div class="dropdown-item px-0 d-flex align-items-top" >
                        <div class="data ms-2">
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="{{ route('feedDetail', base64_encode('feed_'.$Class.'_'.$feed->id)) }}" data-a2a-title="{{$feed->post}}">
                                <a class="a2a_button_twitter d-flex items-center align-items-center">
                                    <svg class="a2a_svg" fill="#777d74" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                                    Twitter
                                </a> 
                            </div>
                        </div>
                    </div>
                    {{-- <div class="dropdown-item px-0 d-flex align-items-top" >
                        <div class="data ms-2">
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="{{ route('feedDetail', base64_encode('feed_'.$Class.'_'.$feed->id)) }}" data-a2a-title="{{$feed->post}}">
                                <a class="a2a_button_instagram d-flex items-center align-items-center">
                                    <svg class="a2a_svg" fill="#777d74" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                                    Instagram
                                </a> 
                            </div>
                        </div>
                    </div> --}}
                    <div class="dropdown-item px-0 d-flex align-items-top" >
                        <div class="data ms-2">
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="{{ route('feedDetail', base64_encode('feed_'.$Class.'_'.$feed->id)) }}" data-a2a-title="{{$feed->post}}">
                                <a class="a2a_button_linkedin d-flex items-center align-items-center">
                                    <svg class="a2a_svg" fill="#777d74" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>
                                    Linkedin
                                </a> 
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-item px-0 d-flex align-items-top" >
                        <div class="data ms-2">
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="{{ route('feedDetail', base64_encode('feed_'.$Class.'_'.$feed->id)) }}" data-a2a-title="{{$feed->post}}">
                                <a class="a2a_button_whatsapp d-flex items-center align-items-center">
                                    <svg class="a2a_svg" fill="#777d74" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                                    Whatsapp
                                </a> 
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-item px-0 d-flex align-items-top" >
                        <div class="data ms-2">
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                <a class=" d-flex items-center align-items-center" onclick="copyShareLink('{{ route('feedDetail', base64_encode('feed_'.$Class.'_'.$feed->id)) }}')">
                                    <svg class="a2a_svg" xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960" fill="#777d74" ><path d="M360-240q-33 0-56.5-23.5T280-320v-480q0-33 23.5-56.5T360-880h360q33 0 56.5 23.5T800-800v480q0 33-23.5 56.5T720-240H360Zm0-80h360v-480H360v480ZM200-80q-33 0-56.5-23.5T120-160v-560h80v560h440v80H200Zm160-240v-480 480Z"/></svg>
                                    Copy Link
                                </a> 
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
            
       </div>
    </div>
    <hr>
    <ul class="post-comments list-inline p-0 m-0" id="UpdateCommentsPostDiv{{$Class.$feed->id}}">
        @php 
            $feedCount = $feed['comments']->count();
            $feed['comments'] = $feed['comments']->sortByDesc('created_at')->take(2);
            $feed['comments'] = $feed['comments']->sortBy('created_at');
        @endphp
        <div class="comment-section{{$Class.$feed->id}}">
            @foreach ($feed['comments'] as $key => $comm)
                <div class="comment-list-{{$Class.$feed->id.$comm->id}}">
                    @if (isset($comm['getUserData']))
                        <li class="mb-2 comment-li-{{$Class.$feed->id.$comm->id}}">
                            <div class="d-flex">
                                <div class="user-img">
                                    @php 
                                        $file_path = public_path('storage/images/user/userProfileandCovers/'. $comm['getUserData']->id.'/'.$comm['getUserData']->avatar_location);
                                    @endphp
                                    @if(isset($comm['getUserData']->avatar_location) && $comm['getUserData']->avatar_location !== '' && is_file($file_path))
                                        <img src="{{ asset('storage/images/user/userProfileandCovers/'. $comm['getUserData']->id.'/'.$comm['getUserData']->avatar_location) }}" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">
                                    @else
                                        <img src="{{asset('images/user/Users_60x60.png')}}" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">
                                    @endif
                                </div>
                                <div class="comment-data-block ms-3">
                                    <div class="bg-soft-light px-2 py-1 rounded-3">
                                        @if(isset($comm['getUserData']->username) && $comm['getUserData']->username !== '')
                                            <a class="comment-reply-user text-body" href="{{route('user-profile',  ['username' => $comm['getUserData']->username])}}">
                                                <h6>{{$comm['getUserData']->first_name.' '.$comm['getUserData']->last_name}}</h6>
                                            </a>
                                        @else
                                            <h6>{{$comm['getUserData']->first_name.' '.$comm['getUserData']->last_name}}</h6>
                                        @endif
                                        <p class="mb-0 text-dark">{{$comm->comment}}</p>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center comment-activity" >
                                        @if(isset(optional($feed->pageDetails)->id) )
                                        <!--Page Feed comment -->
                                            <a id="comment-like-button" class="comment-reply-user span-like{{$Class.$feed->id.$comm->id}} {{ ($comm->commentLikes->pluck('user_id')->contains(auth()->user()->id) ? 'text-primary' : 'text-dark') }}" onclick="saveCommentLikePage({{$feed->id}}, {{$comm->id}}, {{$user->id}}, {{optional($feed->pageDetails)->id}})" href="javascript:void(0);">
                                                @if($comm->likes_count == 0 ) Like @elseif ($comm->likes_count <=1) {{$comm->likes_count}} Like @else {{$comm->likes_count}} Likes @endif
                                            </a>
                                            <a href="javascript:void(0);" class="comment-reply-user text-dark" onclick="toggleReplyBox({{$comm->id}}, '{{$Class}}')">reply</a>
                                            @if($user->id == $comm['getUserData']->id || $feed['getUser']->id == $user->id)
                                                <a href="javascript:void(0);" class="comment-reply-user text-dark" onclick="deleteGroupPagesFeedComment({{$feed->id}}, {{$comm->id}}, {{$user->id}},{{optional($feed->pageDetails)->id}},'page')">delete</a>
                                            @endif
                                        @elseif(isset(optional($feed->groupDetails)->id))
                                        <!--Page Group Feed Comment -->
                                            <a id="comment-like-button" class="comment-reply-user span-like{{$Class.$feed->id.$comm->id}} {{ ($comm->commentLikes->pluck('user_id')->contains(auth()->user()->id) ? 'text-primary' : 'text-dark') }}" onclick="saveGroupCommentLike({{$feed->id}}, {{$comm->id}}, {{$user->id}}, {{optional($feed->groupDetails)->id}})" href="javascript:void(0);">
                                                @if($comm->likes_count == 0 ) Like @elseif ($comm->likes_count <= 1) {{$comm->likes_count}} Like @else {{$comm->likes_count}} Likes @endif
                                            </a>
                                            <a class="comment-reply-user text-dark" href="javascript:void(0);" onclick="toggleReplyBox({{$comm->id}}, '{{$Class}}')">reply</a>
                                            @if($user->id == $comm['getUserData']->id || $feed['getUser']->id == $user->id || $feed->groupDetails->admin_user_id == $user->id)
                                                <a class="comment-reply-user text-dark" href="javascript:void(0);" onclick="deleteGroupPagesFeedComment({{$feed->id}}, {{$comm->id}}, {{$user->id}},{{optional($feed->groupDetails)->id}},'group')">delete</a>
                                            @endif
                                        @else
                                        <!--Profile Feed comment reply -->
                                            <a class=" comment-reply-user span-like{{$Class.$feed->id.$comm->id}} {{ ($comm->commentLikes->pluck('user_id')->contains(auth()->user()->id) ? 'text-primary' : 'text-dark') }} " id="comment-like-button" onclick="saveCommentLike({{$feed->id}}, {{$comm->id}}, {{$user->id}})" href="javascript:void(0);">
                                                @if($comm->likes_count == 0 ) Like @elseif ($comm->likes_count <=1) {{$comm->likes_count}} Like @else {{$comm->likes_count}} Likes @endif
                                            </a>
                                            <a class="text-dark comment-reply-user" href="javascript:void(0);" onclick="toggleReplyBox({{$comm->id}})">reply</a>
                                            @if($user->id == $comm['getUserData']->id || $feed['getUser']->id == $user->id)
                                                <a class="text-dark comment-reply-user" href="javascript:void(0);" onclick="deleteFeedComment({{$feed->id}}, {{$comm->id}}, {{$user->id}})">delete</a>
                                            @endif
                                        @endif
                                        <span> {{$comm->created_at->diffForHumans()}} </span>
                                    </div>
                                    <div class="comment-reply-box d-none new-comment-emoji d-flex" id="comment-reply-box-{{$comm->id}}">
                                        <input type="hidden" name="parentCommentId" id="parentCommentId{{$comm->id}}" value="{{$comm->id}}">
                                        @if(isset(optional($feed->pageDetails)->id) )
                                            <input type="text" name="comment" id="comment-input-reply{{$Class.$comm->id}}" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, {{$feed->id}}, {{$comm->id}}, {{optional($feed->pageDetails)->id}},'page')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">
                                        @elseif(isset(optional($feed->groupDetails)->id))
                                            <input type="text" name="comment" id="comment-input-reply{{$Class.$comm->id}}" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, {{$feed->id}}, {{$comm->id}}, {{optional($feed->groupDetails)->id}},'group')" class="form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">
                                        @else
                                            <input type="text" name="comment" id="comment-input-reply{{$comm->id}}" onkeyup="saveCommentReply(event.keyCode, {{$feed->id}}, {{$comm->id}})" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">
                                        @endif
                                        @include('partials._emoji')
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if (isset($comm['getReplies']))
                        <ul class="get-replies">
                            @php 
                                $comm['getReplies'] = $comm['getReplies']->sortByDesc('created_at')->take(2);
                                $comm['getReplies'] = $comm['getReplies']->sortBy('created_at');
                            @endphp
                            @foreach ($comm['getReplies'] as $key => $reply)
                                <div class="comment-section{{$Class.$feed->id.$reply->id}} comment-list-{{$Class.$feed->id.$reply->id}}">
                                    @if(isset($reply['getUserData']))
                                        <li class="mb-2 comment-li-{{$Class.$feed->id.$reply->id}}">
                                            <div class="d-flex">
                                                <div class="user-img">
                                                    @php 
                                                        $file_path = public_path('storage/images/user/userProfileandCovers/'. $reply['getUserData']->id.'/'.$reply['getUserData']->avatar_location);
                                                    @endphp
                                                    @if(isset($reply['getUserData']->avatar_location) && $reply['getUserData']->avatar_location !== '' && is_file($file_path))
                                                        <img src="{{ asset('storage/images/user/userProfileandCovers/'. $reply['getUserData']->id.'/'.$reply['getUserData']->avatar_location) }}" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">
                                                    @else
                                                        <img src="{{asset('images/user/Users_60x60.png')}}" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">
                                                    @endif
                                                </div>
                                                <div class="comment-data-block ms-3">
                                                    <div class="bg-soft-light px-2 py-1 rounded-3">
                                                        @if(isset($reply['getUserData']->username) && $reply['getUserData']->username !== '')
                                                            <a href="{{route('user-profile',  ['username' => $reply['getUserData']->username])}}" class="">
                                                                <h6>{{$reply['getUserData']->first_name.' '.$reply['getUserData']->last_name}}</h6>
                                                            </a>
                                                        @else
                                                            <h6>{{$reply['getUserData']->first_name.' '.$reply['getUserData']->last_name}}</h6>
                                                        @endif
                                                        <p class="mb-0 text-dark">
                                                            @for ($i = 0; $i < count($feed['comments']) ; $i++)
                                                                @if(count($feed['comments']) > 0)
                                                                    @if(@$feed['comments'][$i]->id == @$reply->parent_id && @$feed['comments'][$i]['getUserData']->id !== $reply['getUserData']->id)
                                                                        @if(isset($feed['comments'][$i]['getUserData']->username) && $feed['comments'][$i]['getUserData']->username !== '')
                                                                            <a style="font-weight: bold;" href="{{route('user-profile',  ['username' => $feed['comments'][$i]['getUserData']->username])}}" class="comment-reply-user text-body">
                                                                                    {{$feed['comments'][$i]['getUserData']->first_name.' '.$feed['comments'][$i]['getUserData']->last_name}}
                                                                            </a>
                                                                        @else
                                                                            {{@$feed['comments'][$i]['getUserData']->first_name.' '.@$feed['comments'][$i]['getUserData']->last_name}}
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                            &nbsp;{{$reply->comment}}
                                                        </p>
                                                    </div>
                                                    <div class="d-flex flex-wrap align-items-center comment-activity">
                                                        @if(isset(optional($feed->pageDetails)->id) )
                                                        <!--Page Feed comment -->
                                                            <a id="comment-like-button" class=" comment-reply-user span-like{{$Class.$feed->id.$reply->id}} {{ ($reply->commentLikes->pluck('user_id')->contains(auth()->user()->id) ? 'text-primary' : 'text-dark') }}" onclick="saveCommentLikePage({{$feed->id}}, {{$reply->id}}, {{$user->id}}, {{optional($feed->pageDetails)->id}})" href="javascript:void(0);">@if($reply->likes_count == 0 ) Like @elseif ($reply->likes_count <=1) {{$reply->likes_count}} Like @else {{$reply->likes_count}} Likes @endif</a>
                                                            <a href="javascript:void(0);" class="text-dark comment-reply-user" onclick="toggleReplyBox({{$reply->id}}, '{{$Class}}')">reply</a>
                                                            @if($user->id == $reply['getUserData']->id || $feed['getUser']->id == $user->id)
                                                                <a href="javascript:void(0);" class="text-dark comment-reply-user" onclick="deleteGroupPagesFeedComment({{$feed->id}}, {{$reply->id}}, {{$user->id}},{{optional($feed->pageDetails)->id}},'page')">delete</a>
                                                            @endif
                                                        @elseif(isset(optional($feed->groupDetails)->id))
                                                        <!--Page Group Feed Comment -->
                                                            <a id="comment-like-button" class="comment-reply-user span-like{{$Class.$feed->id.$reply->id}} {{ ($reply->commentLikes->pluck('user_id')->contains(auth()->user()->id) ? 'text-primary' : 'text-dark') }}" onclick="saveGroupCommentLike({{$feed->id}}, {{$reply->id}}, {{$user->id}}, {{optional($feed->groupDetails)->id}})" href="javascript:void(0);">
                                                                @if($reply->likes_count == 0 ) Like @elseif ($reply->likes_count <= 1) {{$reply->likes_count}} Like @else {{$reply->likes_count}} Likes @endif
                                                            </a>
                                                            <a class="comment-reply-user text-dark" href="javascript:void(0);" onclick="toggleReplyBox({{$reply->id}}, '{{$Class}}')">reply</a>
                                                            @if($user->id == $reply['getUserData']->id || $feed['getUser']->id == $user->id || $feed->groupDetails->admin_user_id == $user->id)
                                                                <a class="comment-reply-user text-dark" href="javascript:void(0);" onclick="deleteGroupPagesFeedComment({{$feed->id}}, {{$reply->id}}, {{$user->id}},{{optional($feed->groupDetails)->id}},'group')">delete</a>
                                                            @endif
                                                        @else
                                                        <!--Profile Feed comment reply -->
                                                            <a class=" comment-reply-user span-like{{$Class.$feed->id.$reply->id}} {{ ($reply->commentLikes->pluck('user_id')->contains(auth()->user()->id) ? 'text-primary' : 'text-dark') }}" id="comment-like-button" onclick="saveCommentLike({{$feed->id}}, {{$reply->id}}, {{$user->id}})" href="javascript:void(0);">
                                                                @if($reply->likes_count == 0 ) Like @elseif ($reply->likes_count <=1) {{$reply->likes_count}} Like @else {{$reply->likes_count}} Likes @endif
                                                            </a>
                                                            <a class="text-dark comment-reply-user" href="javascript:void(0);" onclick="toggleReplyBox({{$reply->id}})">reply</a>
                                                            @if($user->id == $reply['getUserData']->id || $feed['getUser']->id == $user->id)
                                                                <a class="text-dark comment-reply-user" href="javascript:void(0);" onclick="deleteFeedComment({{$feed->id}}, {{$reply->id}}, {{$user->id}})">delete</a>
                                                            @endif
                                                        @endif
                                                        <span> {{$reply->created_at->diffForHumans()}} </span>
                                                    </div>
                                                    <div class="comment-reply-box d-none new-comment-emoji d-flex" id="comment-reply-box-{{$reply->id}}">
                                                        <input type="hidden" name="parentCommentId" id="parentCommentId{{$reply->id}}" value="{{$reply->id}}">
                                                        @if(isset(optional($feed->pageDetails)->id) )
                                                            <input type="text" name="comment" id="comment-input-reply{{$Class.$reply->id}}" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, {{$feed->id}}, {{$reply->id}}, {{optional($feed->pageDetails)->id}},'page')" class=" form-control rounded feed-comment" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">
                                                        @elseif(isset(optional($feed->groupDetails)->id))
                                                            <input type="text" name="comment" id="comment-input-reply{{$Class.$reply->id}}" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, {{$feed->id}}, {{$reply->id}}, {{optional($feed->groupDetails)->id}},'group')" class="form-control rounded feed-comment" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">
                                                        @else
                                                            <input type="text" name="comment" id="comment-input-reply{{$reply->id}}" onkeyup="saveCommentReply(event.keyCode, {{$feed->id}}, {{$reply->id}})" class=" form-control rounded feed-comment" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">
                                                        @endif
                                                        @include('partials._emoji')
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @include('partials._parent_comment', ['reply' => $reply , 'getRepliesUserChild' => $comm['getReplies']])
                                    @endif
                                </div>
                            @endforeach
                        </ul>
                    @endif
                </div>
           @endforeach
        </div>
       @if ( $feedCount >= 3)
            <span class="view-more-comments-{{ $feed->id }}"
                @if (isset(optional($feed->pageDetails)->id)) 
                    onclick="openModalFeedLike('{{ $feed->id }}', 'newsFeedComments', 'pageDetails')" 
                @elseif(isset(optional($feed->groupDetails)->id))
                    onclick="openModalFeedLike('{{ $feed->id }}', 'newsFeedComments', 'groupDetails')" 
                @else
                    onclick="openModalFeedLike('{{ $feed->id }}', 'newsFeedComments', 'profileFeed')" 
                @endif
                style="cursor: pointer;"
            >
            View more comments
            </span>
        @endif
    </ul>
    <!--check the Group members count -->
    @php
        $checkGroupMember = count(GroupMembers::where(['group_id' => optional($feed->groupDetails)->id, 'user_id' => $user->id])->get());
    @endphp
    <!-- end check the Group members-->

    <div class="comment-text d-flex align-items-center mt-3 new-comment-emoji">
        <input type="hidden" value="{{$feed->id}}" id="feedId{{$feed->id}}" name="feedId" class="form-control rounded">
        <input type="hidden" value="{{$user->id}}" id="userId{{$feed->id}}" name="userId" class="form-control rounded">
        @csrf
        @if(isset(optional($feed->pageDetails)->id) )
            <input type="hidden" value="{{optional($feed->pageDetails)->id}}" id="pageId{{optional($feed->pageDetails)->id}}" name="groupId" class="form-control rounded">
            <input type="text" name="comment" id="comment-input{{$Class.$feed->id}}" onkeyup="savePageComment(event.keyCode, {{$feed->id}}, {{optional($feed->pageDetails)->id}})" class="form-control rounded feed-comment" placeholder="Enter Your Comment" style="margin-right: -32px !important;">
        @elseif(isset(optional($feed->groupDetails)->id))
            <input type="hidden" value="{{optional($feed->groupDetails)->id}}" id="groupId{{optional($feed->groupDetails)->id}}" name="groupId" class="form-control rounded">
            @if($checkGroupMember == 1 || ($checkGroupMember == 0 && optional($feed->groupDetails)->group_type) == 'Public')
                <input type="text" name="comment" id="comment-input{{$Class.$feed->id}}" onkeyup="saveGroupComment(event.keyCode, {{$feed->id}}, {{optional($feed->groupDetails)->id}})" class="form-control rounded feed-comment" placeholder="Enter Your Comment" style="margin-right: -32px !important;">
            @endif
        @else
            <input type="text" name="comment" id="comment-input{{$feed->id}}" onkeyup="saveComment(event.keyCode, {{$feed->id}})" class="form-control rounded feed-comment" placeholder="Enter Your Comment" style="margin-right: -32px !important;">
        @endif
        @include('partials._emoji')
    </div>
 </div>