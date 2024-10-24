@php
    use App\Models\GroupMembers;
    use App\Models\FeedReport;

    if (!isset(optional($feed->groupDetails)->id)) 
    {
        $checkReportPost = count(FeedReport::where(['feed_id' => $feed->id, 'reported_user_id' => $user->id, 'post_type' => 'feed'])->get());
    } else {
        $checkReportPost = count(FeedReport::where(['feed_id' => $feed->id, 'reported_user_id' => $user->id, 'post_type' => 'group'])->get());
    }
@endphp
@if ($checkReportPost < 1)

    @if (isset($feed) && isset($feed['getUser']))
        @php $Class = optional($feed->pageDetails)->id ? '-page-' : (optional($feed->groupDetails)->id ? '-group-' : ''); @endphp
        <div class="col-sm-12 feed-id{{ $Class.$feed->id }}">
            <div class="card card-block card-stretch">
                <div class="card-body">
                    <div class="user-post-data">
                        <div class="d-flex justify-content-between">
                            <div class="me-3">
                                <!--if feed is equal to page -->
                                @if ($feed->page_id && $feed->share_feed_id == null)
                                    @if (isset(optional($feed->pageDetails)->profile_image) && optional($feed->pageDetails)->profile_image !== '')
                                        <img class="avatar-60 rounded-circle" src="{{ asset('storage/images/page-img/' . optional($feed->pageDetails)->id . '/' . optional($feed->pageDetails)->profile_image) }}" width="60px" height="60px" alt="" loading="lazy">
                                        @if (isset($feed['getUser']->avatar_location) && $feed['getUser']->avatar_location !== '' && is_file(public_path('storage/images/user/userProfileandCovers/'.$feed['getUser']->id.'/'.$feed['getUser']->avatar_location)))
                                            <div style="text-align: right; margin-top: -2rem;"><a href="{{ route('user-profile', ['username' => $feed['getUser']->username]) }}"><img class="avatar-30 rounded-circle" src="{{ asset('storage/images/user/userProfileandCovers/' . $feed['getUser']->id . '/' . $feed['getUser']->avatar_location) }}" alt="" loading="lazy"></a></div>
                                        @else
                                            <div style="text-align: right; margin-top: -2rem;"><a href="{{ route('user-profile', ['username' => $feed['getUser']->username]) }}"><img class="avatar-30 img-fluid this" src="{{ asset('images/user/Users_60x60.png') }}" alt="" loading="lazy"></a></div>
                                        @endif
                                    @else
                                        <img src="{{ asset('images/user/pageProfile.png') }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                    @endif
                                    <!--if post not equal to page -->
                                @else
                                    @if (isset($feed['getUser']->avatar_location) && $feed['getUser']->avatar_location !== '' && is_file(public_path('storage/images/user/userProfileandCovers/'.$feed['getUser']->id.'/'.$feed['getUser']->avatar_location)))
                                        <img class="avatar-60 rounded-circle" src="{{ asset('storage/images/user/userProfileandCovers/' . $feed['getUser']->id . '/' . $feed['getUser']->avatar_location) }}" alt="" loading="lazy">
                                    @else
                                        <img class="img-fluid" src="{{ asset('images/user/Users_60x60.png') }}" alt="" loading="lazy">
                                    @endif
                                @endif
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <div class="">
                                        @if (isset($feed['getUser']))
                                            @if (isset($feed['getUser']->username) && $feed['getUser']->username !== '')
                                                @if (isset(optional($feed->groupDetails)->id) && !isset($data['allMembers']))
                                                    <div class="info" style="margin-left: 0rem">
                                                        <h4 style="font-size:18px;width:auto;font-weight:bold;"><a href="{{ url('groupdetail/' . optional($feed->groupDetails)->id) }}"> {{ ucfirst(optional($feed->groupDetails)->group_name) }}</a></h4>
                                                    </div>
                                                    <p class="mb-0"><a href="{{ route('user-profile', ['username' => $feed['getUser']->username]) }}">{{$feed['getUser']->first_name . ' ' . $feed['getUser']->last_name. ' - '}}</a> {{ $feed->created_at->diffForHumans() }}</p>
                                                @elseif (isset(optional($feed->pageDetails)->id) && $feed->share_feed_id == null)
                                                    <div class="info" style="margin-left: 0rem">
                                                        <h4 style="font-size:18px;width:auto;font-weight:bold;"><a href="{{ url('pagedetail/' . optional($feed->pageDetails)->id) }}"> {{ ucfirst(optional($feed->pageDetails)->page_name) }}</a></h4>
                                                    </div>
                                                    <p class="mb-0"><a href="{{ route('user-profile', ['username' => $feed['getUser']->username]) }}">{{$feed['getUser']->first_name . ' ' . $feed['getUser']->last_name. ' - '}}</a> {{ $feed->created_at->diffForHumans() }}</p>
                                                @else
                                                    <a href="{{ route('user-profile', ['username' => $feed['getUser']->username]) }}" class="">
                                                        <h5 class="mb-0 d-inline-block">{{ $feed['getUser']->first_name . ' ' . $feed['getUser']->last_name }}</h5>
                                                    </a>
                                                    <p class="mb-0">{{ $feed->created_at->diffForHumans() }}</p>
                                                @endif
                                            @else
                                                <h5 class="mb-0 d-inline-block">{{ $feed['getUser']->first_name . ' ' . $feed['getUser']->last_name }}</h5>
                                            @endif
                                        @endif
                                        {{-- <p class="mb-0">{{ $feed->created_at->diffForHumans() }}</p> --}}
                                    </div>
                                    @if (isset($feed['getUser']) && $feed->approve_feed != 'N')
                                        <div class="card-post-toolbar">
                                            <div class="dropdown">
                                                <!--Add Faviourt -->
                                                {{-- @if (!isset(optional($feed->groupDetails)->id)) --}}
                                                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                    <span class="material-symbols-outlined">
                                                        more_horiz
                                                    </span>
                                                </span>

                                                <div class="dropdown-menu m-0 p-0">
                                                    @if ($feed->getFavFeed)
                                                        @php
                                                            $isFavorite = $feed->getFavFeed()->where(['feed_id' => $feed->id, 'user_id' => $user->id])->first();
                                                        @endphp
                                                        @if (isset($isFavorite))
                                                            <div class="dropdown-item p-3 d-flex align-items-top" id="removePostDiv_{{ $feed->id }}">
                                                                <i class="ri-save-line h4"></i>
                                                                <div class="data ms-2">
                                                                    <a href="javascript:void(0);" onclick="removePost({{ $feed->id }})">
                                                                        <p class="mb-0">Remove this post from your favorites</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="dropdown-item p-3 d-flex align-items-top d-none" id="savePostDiv_{{ $feed->id }}">
                                                                <i class="ri-save-line h4"></i>
                                                                <div class="data ms-2">
                                                                    <a href="javascript:void(0);" onclick="savePost({{ $feed->id }})">
                                                                        <p class="mb-0">Add this post to your favorites</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="dropdown-item p-3 d-flex align-items-top" id="savePostDiv_{{ $feed->id }}">
                                                                <i class="ri-save-line h4"></i>
                                                                <div class="data ms-2">
                                                                    <a href="javascript:void(0);" onclick="savePost({{ $feed->id }})">
                                                                        <p class="mb-0">Add this post to your favorites</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="dropdown-item p-3 d-flex align-items-top d-none" id="removePostDiv_{{ $feed->id }}">
                                                                <i class="ri-save-line h4"></i>
                                                                <div class="data ms-2">
                                                                    <a href="javascript:void(0);" onclick="removePost({{ $feed->id }})">
                                                                        <p class="mb-0">Remove this post from your favorites</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if (auth()->user()->id !== $feed['getUser']->id)
                                                        <a class="dropdown-item p-3 btn" data-bs-toggle="modal" data-bs-target="#seeing-modal_{{ $feed->id }}" action="javascript:void();">
                                                            <div class="d-flex align-items-top">
                                                                <i class="ri-pencil-line h4"></i>
                                                                <div class="data ms-2">
                                                                    <p class="mb-0">Why you're seeing this post</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a class="dropdown-item p-3 btn" data-bs-toggle="modal" data-bs-target="#report-spam-modal_{{ $feed->id }}" action="javascript:void();">
                                                            <div class="d-flex align-items-top">
                                                                <i class="ri-pencil-line h4"></i>
                                                                <div class="data ms-2">
                                                                    <p class="mb-0">Report Post</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                    @if (auth()->user()->id == $feed['getUser']->id)
                                                        <span
                                                            @if (isset(optional($feed->pageDetails)->id))
                                                                onclick="openModalFeedLike('{{ $feed->id }}', 'editFeed', 'pageDetails')"
                                                            @elseif(isset(optional($feed->groupDetails)->id))
                                                                onclick="openModalFeedLike('{{ $feed->id }}', 'editFeed', 'groupDetails')"
                                                            @else
                                                                onclick="openModalFeedLike('{{ $feed->id }}', 'editFeed', 'profileFeed')"
                                                            @endif
                                                            style="cursor: pointer;"
                                                        >
                                                            <div class="dropdown-item p-3 d-flex align-items-top">
                                                                <div class="data ms-2">
                                                                    <p class="mb-0">Edit post</p>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    @endif
                                                    @if (isset(optional($feed->groupDetails)->id) && auth()->user()->id == $feed['getUser']->id || optional($feed->groupDetails)->admin_user_id == auth()->user()->id || isset(optional($feed->pageDetails)->id) && optional($feed->pageDetails)->admin_user_id == auth()->user()->id)
                                                        <a href="javascript:void(0);" class="dropdown-item p-3" data-bs-toggle="modal" data-bs-target="#delete-post-group-{{$feed->id}}" action="javascript:void();" role="button">
                                                            <div class="d-flex align-items-top">
                                                                <i class="ri-delete-bin-7-line h4"></i>
                                                                <div class="data ms-2">
                                                                    <p class="mb-0">Delete</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                    @if($feed['getUser']->id == auth()->user()->id && !isset(optional($feed->groupDetails)->id)  && !isset(optional($feed->pageDetails)->id))
                                                        <a href="javascript:void(0);" class="dropdown-item p-3" data-bs-toggle="modal" data-bs-target="#delete-post-{{$feed->id}}" action="javascript:void();" role="button">
                                                            <div class="d-flex align-items-top">
                                                                <i class="ri-delete-bin-7-line h4"></i>
                                                                <div class="data ms-2">
                                                                    <p class="mb-0">Delete</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!--End Delete Group Post Modal -->
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if(isset(optional($feed->pageDetails)->id) && isset($feed->shareFeed->sharePageFeedData))
                        @php
                            $feed->shareFeed->shareFeedData = $feed->shareFeed->sharePageFeedData;
                        @endphp
                    @elseif(isset(optional($feed->groupDetails)->id) && isset($feed->shareFeed->shareGroupFeedData))
                        @php
                            $feed->shareFeed->shareFeedData = $feed->shareFeed->shareGroupFeedData;
                        @endphp
                    @else
                    @endif
                    <div class="mt-3">
                        @if (isset($feed->post) && $feed->post != null && $feed->post != 'null')
                            <p class="ps-2">{{ $feed->post }}</p>
                        @elseif(isset($feed->shareFeed->post) && $feed->shareFeed->post != null && $feed->shareFeed->post != 'null')
                            <p class="ps-2">{{ $feed->shareFeed->post }}</p>
                        @endif
                    </div>
                    @if(isset($feed->shareFeed->shareFeedData->attachments))
                        @php
                            $feed['attachments'] = $feed->shareFeed->shareFeedData->attachments;
                            $feed['getUser'] = $feed->shareFeed->shareFeedData->getUser;
                            if(isset(optional($feed->pageDetails)->id) && isset($feed->shareFeed->sharePageFeedData)){
                                $feed->pageDetails = $feed->shareFeed->shareFeedData->pageDetails;
                            }
                            elseif(isset(optional($feed->groupDetails)->id) && isset($feed->shareFeed->shareGroupFeedData)){
                                $feed->groupDetails = $feed->shareFeed->shareFeedData->groupDetails;
                            }
                        @endphp
                        <div class="card pt-2 p-3 border">
                            <div class="user-post-data mt-3">
                                <div class="d-flex justify-content-between">
                                    <div class="me-3">
                                        <!--if feed is equal to page -->
                                        @if ($feed->shareFeed->shareFeedData->page_id)
                                            @if (isset(optional($feed->shareFeed->shareFeedData->pageDetails)->profile_image) && optional($feed->shareFeed->shareFeedData->pageDetails)->profile_image !== '')
                                                <img class="avatar-60 rounded-circle" src="{{ asset('storage/images/page-img/' . optional($feed->shareFeed->shareFeedData->pageDetails)->id . '/' . optional($feed->shareFeed->shareFeedData->pageDetails)->profile_image) }}" width="60px" height="60px" alt="" loading="lazy">
                                            @else
                                                <img src="{{ asset('images/user/pageProfile.png') }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                            @endif
                                            <!--if post not equal to page -->
                                        @else
                                            @if (isset($feed->shareFeed->shareFeedData['getUser']->avatar_location) && $feed->shareFeed->shareFeedData['getUser']->avatar_location !== ''  && is_file(public_path('storage/images/user/userProfileandCovers/'.$feed->shareFeed->shareFeedData['getUser']->id.'/'.$feed->shareFeed->shareFeedData['getUser']->avatar_location)))
                                                <img class="avatar-60 rounded-circle" src="{{ asset('storage/images/user/userProfileandCovers/' . $feed->shareFeed->shareFeedData['getUser']->id . '/' . $feed->shareFeed->shareFeedData['getUser']->avatar_location) }}" alt="" loading="lazy">
                                            @else
                                                <img class="img-fluid" src="{{ asset('images/user/Users_60x60.png') }}" alt="" loading="lazy">
                                            @endif
                                        @endif
                                    </div>
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between">
                                            <div class="">
                                                @if (isset($feed->shareFeed->shareFeedData['getUser']))
                                                    @if (isset($feed->shareFeed->shareFeedData['getUser']->username) && $feed->shareFeed->shareFeedData['getUser']->username !== '')
                                                        @if (isset(optional($feed->shareFeed->shareFeedData->groupDetails)->id) && !isset($data['allMembers']))
                                                            <div class="info" style="margin-left: 0rem">
                                                                <h4 style="font-size:18px;width:auto;font-weight:bold;"><a href="{{ url('groupdetail/' . optional($feed->shareFeed->shareFeedData->groupDetails)->id) }}"> {{ ucfirst(optional($feed->shareFeed->shareFeedData->groupDetails)->group_name) }}</a></h4>
                                                            </div>
                                                        @endif
                            
                                                        @if (isset(optional($feed->shareFeed->shareFeedData->pageDetails)->id))
                                                            <div class="info" style="margin-left: 0rem">
                                                                <h4 style="font-size:18px;width:auto;font-weight:bold;"><a href="{{ url('pagedetail/' . optional($feed->shareFeed->shareFeedData->pageDetails)->id) }}"> {{ ucfirst(optional($feed->shareFeed->shareFeedData->pageDetails)->page_name) }}</a></h4>
                                                            </div>
                                                        @endif
                            
                                                        @if (!isset(optional($feed->shareFeed->shareFeedData->pageDetails)->id))
                                                            <a href="{{ route('user-profile', ['username' => $feed->shareFeed->shareFeedData['getUser']->username]) }}" class="">
                                                                <h5 class="mb-0 d-inline-block">{{ $feed->shareFeed->shareFeedData['getUser']->first_name . ' ' . $feed->shareFeed->shareFeedData['getUser']->last_name }}</h5>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <h5 class="mb-0 d-inline-block">{{ $feed->shareFeed->shareFeedData['getUser']->first_name . ' ' . $feed->shareFeed->shareFeedData['getUser']->last_name }}</h5>
                                                    @endif
                                                @endif
                                                <p class="mb-0">{{ $feed->shareFeed->shareFeedData->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                @if (isset($feed->shareFeed->shareFeedData->post) && $feed->shareFeed->shareFeedData->post != null && $feed->shareFeed->shareFeedData->post != 'null')
                                    <p class="ps-2">{{ $feed->shareFeed->shareFeedData->post }}</p>
                                @endif
                            </div>
                    @endif
                    @if (isset($feed['attachments'][0]->attachment) && !isset($data['shareFeed']))
                        <!--hide the report post -->
                        <div class="user-post ">
                            <a href="{{ route('feedDetail', base64_encode('feed_'.$Class.'_'.$feed->id)) }}">
                                <div class=" d-grid grid-rows-2 grid-flow-col gap-3">
                                    <div class="row-span-2 row-span-md-1">
                                        @if (isset($feed['getUser']))
                                            @if (count($feed['attachments']) == 1)
                                                @if ($feed['attachments'][0]->attachment_type == 'video')
                                                    <div class="grid1">
                                                        {{-- <iframe frameborder="1" class="vedioAuto" width="624" height="345" src="{{asset('storage/images/feed-img/'.$feed['getUser']->id.'/'.$feed['attachments'][0]->attachment)}}" allowfullscreen controls autoplay="false" preload="none" muted></iframe> --}}
                                                        <video id="newsfeed-video" class="newsfeed-video-play w-100" style="height: 400px !important; max-height: 400px !important; min-height: 400px !important;" controls>
                                                            @if (isset(optional($feed->pageDetails)->id))
                                                                <source src="{{ asset('storage/images/page-img/' . optional($feed->pageDetails)->id . '/' . $feed['attachments'][0]->attachment) }}">
                                                            @elseif (isset(optional($feed->groupDetails)->id))
                                                                <source src="{{ asset('storage/images/group-img/' . optional($feed->groupDetails)->id . '/' . $feed['attachments'][0]->attachment) }}">
                                                            @else
                                                                <source src="{{ asset('storage/images/feed-img/' . $feed['getUser']->id . '/' . $feed['attachments'][0]->attachment) }}">
                                                            @endif
                                                        </video>
                                                    </div>
                                                @else
                                                    <div class="grid1">
                                                        @if (isset(optional($feed->groupDetails)->id))
                                                            <img style="cursor: pointer;" src="{{ asset('storage/images/group-img/' . optional($feed->groupDetails)->id . '/' . $feed['attachments'][0]->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                        @elseif(isset(optional($feed->pageDetails)->id))
                                                            <img style="cursor: pointer;" src="{{ asset('storage/images/page-img/' . optional($feed->pageDetails)->id . '/' . $feed['attachments'][0]->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                        @else
                                                            <img style="cursor: pointer;" src="{{ asset('storage/images/feed-img/' . $feed['getUser']->id . '/' . $feed['attachments'][0]->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                        @endif

                                                    </div>
                                                @endif
                                            @elseif(count($feed['attachments']) == 2)
                                                @php
                                                    $index = 0;
                                                @endphp
                                                <div class="grid2">
                                                    @foreach ($feed['attachments'] as $image)
                                                        @if ($index == 2)
                                                            @php
                                                                continue;
                                                            @endphp
                                                        @endif

                                                        @if ($image->attachment_type == 'video')
                                                            <div class="grid1">
                                                                <video class="w-100" style="height: 400px !important; max-height: 400px !important; min-height: 400px !important;" controls>
                                                                    @if (isset(optional($feed->pageDetails)->id))
                                                                        <source src="{{ asset('storage/images/page-img/' . optional($feed->pageDetails)->id . '/' . $image->attachment) }}">
                                                                    @elseif (isset(optional($feed->groupDetails)->id))
                                                                        <source src="{{ asset('storage/images/group-img/' . optional($feed->groupDetails)->id . '/' . $image->attachment) }}">
                                                                    @else
                                                                        <source src="{{ asset('storage/images/feed-img/' . $feed['getUser']->id . '/' . $image->attachment) }}">
                                                                    @endif
                                                                </video>
                                                            </div>
                                                        @else
                                                            <div class="grid1">
                                                                @if (isset(optional($feed->groupDetails)->id))
                                                                    <img src="{{ asset('storage/images/group-img/' . optional($feed->groupDetails)->id . '/' . $image->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                                @elseif(isset(optional($feed->pageDetails)->id))
                                                                    <img src="{{ asset('storage/images/page-img/' . optional($feed->pageDetails)->id . '/' . $image->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                                @else
                                                                    <img src="{{ asset('storage/images/feed-img/' . $feed['getUser']->id . '/' . $image->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                                @endif

                                                            </div>
                                                        @endif
                                                        @php
                                                            $index++;
                                                        @endphp
                                                    @endforeach
                                                </div>
                                            @elseif(count($feed['attachments']) > 2)
                                                @php
                                                    $remainingAttachmentCount = count($feed['attachments']) - 2;
                                                    $index = 0;
                                                @endphp
                                                <div class="grid2" id="graterThanTwoImageMainDiv-{{ $feed->id }}">
                                                    @foreach ($feed['attachments'] as $image)
                                                        @if ($index == 2)
                                                            @php
                                                                continue;
                                                            @endphp
                                                        @endif
                                                        @if ($index == 1)
                                                            @if ($image->attachment_type == 'image')
                                                                @if (isset(optional($feed->pageDetails)->id))
                                                                    <div class="image_overlay-wrapper">
                                                                        <div class="image_overlay rounded" >+{{ $remainingAttachmentCount }}</div>
                                                                        <img src="{{ asset('storage/images/page-img/' . optional($feed->pageDetails)->id . '/' . $image->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                                    </div>
                                                                @elseif (isset(optional($feed->groupDetails)->id))
                                                                    <div class="image_overlay-wrapper">
                                                                        <div class="image_overlay rounded" >+{{ $remainingAttachmentCount }}</div>
                                                                        <img src="{{ asset('storage/images/group-img/' . optional($feed->groupDetails)->id . '/' . $image->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                                    </div>
                                                                @else
                                                                    <div class="image_overlay-wrapper">
                                                                        <div class="image_overlay rounded">+{{ $remainingAttachmentCount }}</div>
                                                                        <img src="{{ asset('storage/images/feed-img/' . $feed['getUser']->id . '/' . $image->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                                    </div>
                                                                @endif
                                                            @else
                                                                @if (isset(optional($feed->pageDetails)->id))
                                                                    <div class="image_overlay-wrapper">
                                                                        <div class="image_overlay rounded">+{{ $remainingAttachmentCount }}</div>
                                                                        <video class="w-100" style="height: 400px !important; max-height: 400px !important; min-height: 400px !important;" controls autoplay="false">
                                                                            <source src="{{ asset('storage/images/page-img/' . optional($feed->pageDetails)->id . '/' . $image->attachment) }}">
                                                                        </video>
                                                                    </div>
                                                                @elseif (isset(optional($feed->groupDetails)->id))
                                                                    <div class="image_overlay-wrapper">
                                                                        <div class="image_overlay rounded">+{{ $remainingAttachmentCount }}</div>
                                                                        <video class="w-100" style="height: 400px !important; max-height: 400px !important; min-height: 400px !important;" controls autoplay="false">
                                                                            <source src="{{ asset('storage/images/group-img/' . optional($feed->groupDetails)->id . '/' . $image->attachment) }}">
                                                                        </video>
                                                                    </div>
                                                                @else
                                                                    <div class="image_overlay-wrapper">
                                                                        <div class="image_overlay rounded">+{{ $remainingAttachmentCount }}</div>
                                                                        <video class="w-100" style="height: 400px !important; max-height: 400px !important; min-height: 400px !important;" controls autoplay="false">
                                                                            <source src="{{ asset('storage/images/feed-img/' . $feed['getUser']->id . '/' . $image->attachment) }}">
                                                                        </video>
                                                                    </div>
                                                                @endif
                                                            @endif;
                                                        @else
                                                            @if ($image->attachment_type == 'image')
                                                                @if (isset(optional($feed->pageDetails)->id))
                                                                    <div class="image_overlay-wrapper">
                                                                        <img src="{{ asset('storage/images/page-img/' . optional($feed->pageDetails)->id . '/' . $image->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                                    </div>
                                                                @elseif (isset(optional($feed->groupDetails)->id))
                                                                    <div class="image_overlay-wrapper">
                                                                        <img src="{{ asset('storage/images/group-img/' . optional($feed->groupDetails)->id . '/' . $image->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                                    </div>
                                                                @else
                                                                    <div class="image_overlay-wrapper">
                                                                        <div class=" rounded"></div>
                                                                        <img src="{{ asset('storage/images/feed-img/' . $feed['getUser']->id . '/' . $image->attachment) }}" alt="post-image" class="img-fluid rounded w-100" loading="lazy">
                                                                    </div>
                                                                @endif
                                                            @else
                                                                @if (isset(optional($feed->pageDetails)->id))
                                                                    <video class="w-100" style="height: 400px !important; max-height: 400px !important; min-height: 400px !important;" controls autoplay="false">
                                                                        <source src="{{ asset('storage/images/page-img/' . optional($feed->pageDetails)->id . '/' . $image->attachment) }}">
                                                                    </video>
                                                                @elseif (isset(optional($feed->groupDetails)->id))
                                                                    <video class="w-100" style="height: 400px !important; max-height: 400px !important; min-height: 400px !important;" controls autoplay="false">
                                                                        <source src="{{ asset('storage/images/group-img/' . optional($feed->groupDetails)->id . '/' . $image->attachment) }}">
                                                                    </video>
                                                                @else
                                                                    <video class="w-100" style="height: 400px !important; max-height: 400px !important; min-height: 400px !important;" controls autoplay="false">
                                                                        <source src="{{ asset('storage/images/feed-img/' . $feed['getUser']->id . '/' . $image->attachment) }}">
                                                                    </video>
                                                                @endif
                                                            @endif
                                                        @endif
                                                        @php
                                                            $index++;
                                                        @endphp
                                                    @endforeach
                                                </div>
                                            @endif
                                            <!--endif of more than2  -->
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @elseif(count($feed['attachments']) > 0 && isset($data['shareFeed']))
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($feed['attachments'] as $key => $attachments)
                                                <div class="carousel-item @if($key == '0') active @endif">
                                                    @if ($feed['attachments'][$key]->attachment_type == 'video')
                                                        <div class="grid1">
                                                            <video id="newsfeed-video" class="w-100" controls style="max-height: 60vh !important; min-height: 60vh !important;">
                                                                @if (isset(optional($feed->pageDetails)->id))
                                                                    <source src="{{ asset('storage/images/page-img/' . optional($feed->pageDetails)->id . '/' . $feed['attachments'][$key]->attachment) }}">
                                                                @elseif (isset(optional($feed->groupDetails)->id))
                                                                    <source src="{{ asset('storage/images/group-img/' . optional($feed->groupDetails)->id . '/' . $feed['attachments'][$key]->attachment) }}">
                                                                @else
                                                                    <source src="{{ asset('storage/images/feed-img/' . $feed['getUser']->id . '/' . $feed['attachments'][$key]->attachment) }}">
                                                                @endif
                                                            </video>
                                                        </div>
                                                    @else
                                                        <div class="grid1">
                                                            @if (isset(optional($feed->groupDetails)->id))
                                                                <img style="cursor: default;" src="{{ asset('storage/images/group-img/' . optional($feed->groupDetails)->id . '/' . $feed['attachments'][$key]->attachment) }}" alt="post-image" class="img-fluid rounded w-100" style="max-height: 60vh !important; min-height: 60vh !important;" loading="lazy">
                                                            @elseif(isset(optional($feed->pageDetails)->id))
                                                                <img style="cursor: default;" src="{{ asset('storage/images/page-img/' . optional($feed->pageDetails)->id . '/' . $feed['attachments'][$key]->attachment) }}" alt="post-image" class="img-fluid rounded w-100" style="max-height: 60vh !important; min-height: 60vh !important;" loading="lazy">
                                                            @else
                                                                <img style="cursor: default;" src="{{ asset('storage/images/feed-img/' . $feed['getUser']->id . '/' . $feed['attachments'][$key]->attachment) }}" alt="post-image" class="img-fluid rounded w-100" style="max-height: 60vh !important; min-height: 60vh !important;" loading="lazy">
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        @if(isset($feed['attachments']) && count($feed['attachments']) >= 2 )
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" style="height: fit-content; margin:auto">
                                                <span class="carousel-control-prev-icon" aria-hidden="true" style="width: 50px; height: 50px; border-radius: 50%; background-color: white; color: var(--bs-primary);"></span>
                                                <span class="material-symbols-outlined" style="position: absolute; left: 44%; color:var(--bs-primary)">arrow_back_ios</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" style="height: fit-content; margin:auto">
                                                <span class="carousel-control-next-icon" aria-hidden="true" style="width: 50px; height: 50px; border-radius: 50%; background-color: white; color: var(--bs-primary);"></span>
                                                <span class="material-symbols-outlined" style="position: absolute; right: 42%; color:var(--bs-primary)">arrow_forward_ios</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($feed->shareFeed->shareFeedData->attachments))
                        </div>
                    @endif
                    @if($feed->approve_feed == 'N')
                        <div class="col-12 mt-3 px-3">
                            <div class="d-flex align-items-center">
                                @if($data['groupDetail'][0]->admin_user_id == $user->id)
                                    <button  class="btn btn-primary w-100 me-2" href="javascript:void(0);" role="button" onclick="approveFeed({{$feed->id}})">Approve</button>
                                @endif
                                <button  class="btn btn-danger w-100 me-2" data-bs-toggle="modal" data-bs-target="#delete-post-group-{{$feed->id}}">@if($data['groupDetail'][0]->admin_user_id == $user->id) Decline @else Remove @endif</button>
                            </div>
                        </div>
                    @else
                        @include('partials/_feedComments')
                    @endif

                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="delete-post-{{$feed->id}}" tabindex="-1" style="min-height: 400px; margin-top:10rem" aria-labelledby="delete-post" aria-hidden="true">
        <div class="modal-dialog   modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header" style="align-items: flex-start;">
                    <div class="modal-title text-dark" style="font-weight: bold;">
                        Delete Post?
                    </div>
                    <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>
                <div class="modal-body ">
                    <div class="d-flex align-items-center">
                        <p class="modal-title ms-3 " id="unfollow-modalLabel">Do you want to delete post?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center">
                        <button data-bs-dismiss="modal" class="btn btn-primary me-2" onclick="deletePost({{ $feed->id }})">Yes</button>
                        <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Delete Group Post Modal    -->
    <div class="modal fade" id="delete-post-group-{{ $feed->id }}" tabindex="-1" style="margin-top:5rem;" aria-labelledby="story-modalLabel" aria-hidden="true">
        <div class="modal-dialog   modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header" style="align-items: flex-start;">
                    <div class="modal-title text-dark" style="font-weight: bold;">
                        Delete Post?
                    </div>
                    <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>
                <div class="modal-body ">
                    <div class="d-flex align-items-center">
                        <p class="modal-title ms-3 " id="unfollow-modalLabel-group">Do you want to delete post?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center">
                        <button data-bs-dismiss="modal" class="btn btn-primary me-2" 
                            onclick="
                                @if(isset(optional($feed->groupDetails)->id))
                                    deleteGroupPagePost({{ $feed->id }},{{ optional($feed->groupDetails)->id }},{{ $feed->user_id }}, 'group')
                                @elseif(isset(optional($feed->pageDetails)->id))
                                    deleteGroupPagePost({{ $feed->id }},{{ optional($feed->pageDetails)->id }},{{ $feed->user_id }}, 'page')
                                @endif
                            ">Yes</button>
                        <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Delete Page Post Modal    -->
    <div class="modal fade" id="delete-post-page-{{ $feed->id }}" tabindex="-1" style="margin-top:5rem;" aria-labelledby="story-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header" style="align-items: flex-start;">
                    <div class="modal-title text-dark" style="font-weight: bold;">
                        Delete Post?
                    </div>
                    <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>
                <div class="modal-body ">
                    <div class="d-flex align-items-center">
                        <p class="modal-title ms-3 " id="unfollow-modalLabel-group">Do you want to delete post?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center">
                        <button data-bs-dismiss="modal" class="btn btn-primary me-2" onclick="deleteGroupPagePost({{ $feed->id }},{{ optional($feed->pageDetails)->id }},{{ $feed->user_id }}, 'page')">Yes</button>
                        <button data-bs-dismiss="modal" class="btn btn-secondary me-2">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Report Spam Modal Below    -->
    <div class="modal fade" id="report-spam-modal_{{ $feed->id }}" tabindex="-1" style="margin-top:5rem;" aria-labelledby="story-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-groupCreatePost">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="post-modalLabel">Why are your reporting this post ?</h5>
                    <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>
                <div class="modal-body">
                    <p>Your report is anonymous, except if you're reporting an intellectual property infringement. If someone is in immediate danger, call the local emergency services - don't wait.</p>
                    <div class="d-flex align-items-center">
                        @if (isset($feed['getUser']->id) && isset($feed->id))
                            <form method="GET" action="{{ route('reportFeed', ['reported_user_id' => auth()->user()->id, 'feed_user_id' => $feed['getUser']->id, 'feed_id' => $feed->id]) }}" class="post-text ms-3 w-100" action="javascript:void();" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="reported_user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="feed_user_id" value="{{ $feed['getUser']->id }}">
                                @if (isset(optional($feed->groupDetails)->id))
                                    <input type="hidden" name="post_type" value="group">
                                @elseif(isset(optional($feed->pageDetails)->id))
                                    <input type="hidden" name="post_type" value="page">
                                @else
                                    <input type="hidden" name="post_type" value="feed">
                                @endif
                                <input type="hidden" name="feed_id" value="{{ $feed->id }}">
                                <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                                    <li class="col-md-6 mb-3">
                                        <input type="radio" name="feed_reported_type_id" checked value="1">
                                        <label for="spam">Its spam</label><br>
                                        <input type="radio" name="feed_reported_type_id" value="2">
                                        <label for="adult">Adult content</label><br>
                                        <input type="radio" name="feed_reported_type_id" value="3">
                                        <label for="javascript">Hate Speech</label><br>
                                        <input type="radio" name="feed_reported_type_id" value="4">
                                        <label for="scam">Scam of Fraud</label><br>
                                        <input type="radio" name="feed_reported_type_id" value="5">
                                        <label for="violance">Violence or Dangerous</label><br>
                                        <input type="radio" name="feed_reported_type_id" value="6">
                                        <label for="javascript">Something Else</label>
                                    </li>
                                </ul>
                                <div class="container-fluid"><button type="submit" class="btn btn-primary d-block w-30 mt-3">Report</button></div>
                            </form>
                        @endif
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <!-- End Report Spam Modal Here  Code End here-->
    <!-- Why Seeing Modal Below    -->
    <div class="modal fade" id="seeing-modal_{{ $feed->id }}" tabindex="-1" aria-labelledby="seeing-modalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top:10rem;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Why you're seeing this post?</h5>
                    <a href="javascript:void(0);" class="lh-1" data-bs-dismiss="modal">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>
                <div class="modal-body">
                    <p>Posts are shown in feed based on many things, that includes your activity on Devsinc.</p>
                    <div class="d-flex align-items-center">
                        @if (isset($feed['getUser']->id) && isset($feed->id))
                            @if (isset($feed['getUser']->username) && $feed['getUser']->username !== '')
                                <a href="{{ route('user-profile', ['username' => $feed['getUser']->username]) }}">
                                    @if (isset($feed['getUser']->avatar_location) && $feed['getUser']->avatar_location !== '' && is_file(public_path('storage/images/user/userProfileandCovers/'.$feed['getUser']->id.'/'.$feed['getUser']->avatar_location)))
                                        <img src="{{ asset('storage/images/user/userProfileandCovers/' . $feed['getUser']->id . '/' . $feed['getUser']->avatar_location) }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                    @else
                                        <img src="{{ asset('images/user/Users_60x60.png') }}" alt="profile-img" class="avatar-45 rounded-circle" />
                                    @endif
                                </a>
                                <span class="requestUserName" style="color:black">Because you follow</span>
                                <a href="{{ route('user-profile', ['username' => $feed['getUser']->username]) }}">
                                    <span class="requestUserName" style="color:red">{{ $feed['getUser']->first_name . ' ' . $feed['getUser']->last_name }}</span>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Why Seeing Modal Below Here  Code End here-->
@endif