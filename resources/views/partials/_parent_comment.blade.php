@php 
	$nestedReplies = $reply->getReplies;
	$Class = optional($feed->pageDetails)->id ? '-page-' : (optional($feed->groupDetails)->id ? '-group-' : '');
@endphp
@if (isset($nestedReplies))
	@php
		$nestedReplies = $nestedReplies->sortByDesc('created_at')->take(2);
		$nestedReplies = $nestedReplies->sortBy('created_at');
	@endphp
	@foreach ($nestedReplies as $parentComment)
		<div class="comment-section{{$Class.$feed->id.$parentComment->id}} comment-list-{{$Class.$feed->id.$parentComment->id}}">
			@if(isset($parentComment->getUserData))
				@php $parentComment->getUserData @endphp
				<li class="mb-2 comment-li-{{$Class.$feed->id.$parentComment->id}}" style="margin-left:2rem;">
					<div class="d-flex">
						<div class="user-img">
							@php 
								$file_path = public_path('storage/images/user/userProfileandCovers/'. $comm['getUserData']->id.'/'.$comm['getUserData']->avatar_location);
							@endphp
							@if(isset($parentComment->getUserData->avatar_location) && $parentComment->getUserData->avatar_location !== ''&& is_file($file_path))
									<img src="{{ asset('storage/images/user/userProfileandCovers/'. $parentComment->getUserData->id.'/'.$parentComment->getUserData->avatar_location) }}" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">
							@else
									<img src="{{asset('images/user/Users_60x60.png')}}" alt="userimg" class="avatar-35 rounded-circle img-fluid" loading="lazy">
							@endif
						</div>
						<div class="comment-data-block ms-3">
							<div class="bg-soft-light px-2 py-1 rounded-3">
								@if(isset($parentComment->getUserData->username) && $parentComment->getUserData->username !== '')
									<a href="{{route('user-profile',  ['username' => $parentComment->getUserData->username])}}" class="">
										<h6>{{$parentComment->getUserData->first_name.' '.$parentComment->getUserData->last_name}}</h6>
									</a>
								@else
									<h6>{{$parentComment->getUserData->first_name.' '.$parentComment->getUserData->last_name}}</h6>
								@endif
								<p class="mb-0 text-dark">
									@for ($i = 0; $i < count($getRepliesUserChild) ; $i++)
										@if(count($getRepliesUserChild) > 0 && isset($getRepliesUserChild[$i]->getUserData))
											@if($getRepliesUserChild[$i]->id == $parentComment->parent_id && $getRepliesUserChild[$i]->getUserData->id !== $parentComment->getUserData->id)
												@if(isset($getRepliesUserChild[$i]->getUserData->username) && $getRepliesUserChild[$i]->getUserData->username !== '')
													<a class="comment-reply-user text-body" style="font-weight: bold;" href="{{route('user-profile',  ['username' => $getRepliesUserChild[$i]->getUserData->username])}}" class="">
														{{$getRepliesUserChild[$i]->getUserData->first_name.' '.$getRepliesUserChild[$i]->getUserData->last_name}}
													</a>
												@else
													{{$getRepliesUserChild[$i]->getUserData->first_name.' '.$getRepliesUserChild[$i]->getUserData->last_name}}
												@endif
											@endif
										@endif
									@endfor
									{{$parentComment->comment}}
								</p>
							</div>
							<div class="d-flex flex-wrap align-items-center comment-activity">
								@if(isset(optional($feed->pageDetails)->id))
									<a id="comment-like-button" class="comment-reply-user span-like{{$Class.$feed->id.$parentComment->id}} {{ ($parentComment->commentLikes->pluck('user_id')->contains(auth()->user()->id) ? 'text-primary' : 'text-dark') }}" onclick="saveCommentLikePage({{$feed->id}}, {{$parentComment->id}}, {{$user->id}}, {{optional($feed->pageDetails)->id}})" href="javascript:void(0);">
										@if($parentComment->likes_count == 0 ) Like @elseif ($parentComment->likes_count <=1) {{$parentComment->likes_count}} Like @else {{$parentComment->likes_count}} Likes @endif
									</a>
									<a class="comment-reply-user text-dark" href="javascript:void(0);" onclick="toggleReplyBox({{$parentComment->id}}, '{{$Class}}')">reply</a>
									@if($user->id == $parentComment->getUserData->id || $feed['getUser']->id == $user->id)
										<a class="comment-reply-user text-dark" href="javascript:void(0);" onclick="deleteGroupPagesFeedComment({{$feed->id}}, {{$parentComment->id}}, {{$user->id}},{{optional($feed->pageDetails)->id}},'page')">delete</a>
									@endif
								@elseif(isset(optional($feed->groupDetails)->id))
									<a class="comment-reply-user span-like{{$Class.$feed->id.$parentComment->id}} {{ ($parentComment->commentLikes->pluck('user_id')->contains(auth()->user()->id) ? 'text-primary' : 'text-dark') }}" id="comment-like-button" onclick="saveGroupCommentLike({{$feed->id}}, {{$parentComment->id}}, {{$user->id}}, {{optional($feed->groupDetails)->id}})" href="javascript:void(0);">
										@if($parentComment->likes_count == 0 ) Like @elseif ($parentComment->likes_count <=1) {{$parentComment->likes_count}} Like @else {{$parentComment->likes_count}} Likes @endif
									</a>
									<a class="comment-reply-user text-dark" href="javascript:void(0);" onclick="toggleReplyBox({{$parentComment->id}}, '{{$Class}}')">reply</a>
									@if($user->id == $parentComment->getUserData->id || $feed['getUser']->id == $user->id || $data['groupDetail'][0]->admin_user_id == $user->id)
										<a class="comment-reply-user text-dark" href="javascript:void(0);" onclick="deleteGroupPagesFeedComment({{$feed->id}}, {{$parentComment->id}}, {{$user->id}},{{optional($feed->groupDetails)->id}},'group')">delete</a>
									@endif
								@else 
									<a class="comment-reply-user span-like{{$Class.$feed->id.$parentComment->id}} {{ ($parentComment->commentLikes->pluck('user_id')->contains(auth()->user()->id) ? 'text-primary' : 'text-dark') }}" id="comment-like-button" onclick="saveCommentLike({{$feed->id}}, {{$parentComment->id}}, {{$user->id}})" href="javascript:void(0);">
										@if($parentComment->likes_count == 0 ) Like @elseif ($parentComment->likes_count <=1) {{$parentComment->likes_count}} Like @else {{$parentComment->likes_count}} Likes @endif
									</a>
									<a class="comment-reply-user text-dark" href="javascript:void(0);" onclick="toggleReplyBox({{$parentComment->id}})">reply</a>
									@if($user->id == $parentComment->getUserData->id || $feed['getUser']->id == $user->id)
										<a class="comment-reply-user text-dark" href="javascript:void(0);" onclick="deleteFeedComment({{$feed->id}}, {{$parentComment->id}}, {{$user->id}})">delete</a>
									@endif
								@endif 
								<span> {{$parentComment->created_at->diffForHumans()}} </span>
							</div>
							<div class="comment-reply-box d-none new-comment-emoji d-flex" id="comment-reply-box-{{$parentComment->id}}">
								<input type="hidden" name="parentCommentId" id="parentCommentId{{$parentComment->id}}" value="{{$parentComment->id}}">
								@if(isset(optional($feed->pageDetails)->id) )
									<input type="text" name="comment" id="comment-input-reply{{$Class.$parentComment->id}}" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, {{$feed->id}}, {{$parentComment->id}}, {{optional($feed->pageDetails)->id}},'page')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">
								@elseif(isset(optional($feed->groupDetails)->id))
									<input type="text" name="comment" id="comment-input-reply{{$Class.$parentComment->id}}" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, {{$feed->id}}, {{$parentComment->id}}, {{optional($feed->groupDetails)->id}},'group')" class="form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">
								@else
									<input type="text" name="comment" id="comment-input-reply{{$parentComment->id}}" onkeyup="saveCommentReply(event.keyCode, {{$feed->id}}, {{$parentComment->id}})" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">
								@endif
								@include('partials._emoji')
							</div>
						</div>
					</div>
				</li>
				@include('partials._parent_comment', ['reply' => $parentComment, 'getRepliesUserChild' => $nestedReplies])
			@endif
		</div>
	@endforeach
@endif
									