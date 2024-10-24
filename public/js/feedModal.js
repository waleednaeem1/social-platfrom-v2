function formatDate(dateString) {
    var daysAgo = Math.floor((new Date() - new Date(dateString)) / (1000 * 60 * 60 * 24));
    if (daysAgo <= 2) {
        if (daysAgo === 0) {
            var secondsAgo = Math.floor((new Date() - new Date(dateString)) / 1000);
            if (secondsAgo < 60) {
                return '1 minutes ago';
            } else if (secondsAgo < 3600) {
                var minutesAgo = Math.floor(secondsAgo / 60);
                return minutesAgo + ' minutes ago';
            } else {
                var hoursAgo = Math.floor(secondsAgo / 3600);
                return hoursAgo + ' hours ago';
            }
        } else if (daysAgo === 1) {
            return 'Yesterday';
        } else {
            return daysAgo + ' days ago';
        }
    } else {
        return new Date(dateString).toDateString();
    }
}

function emojiesComponent() {
    var $emojies =
                '<div class="comment-attagement d-flex">'+
                    '<div class="like-data">'+
                    '<div class="dropdown">'+
                        '<span class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">'+
                            '<a href="javascript:void(0);" class="material-symbols-outlined" style="border:none !important; padding-top:7px !important;">'+
                                'sentiment_satisfied'+
                            '</a>'+
                        '</span>'+
                        '<div class="dropdown-menu py-2 emojis">'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#x1F600;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128513;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128514;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128515;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128516;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128517;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128518;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128519;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128520;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128521;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128522;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128523;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128524;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128525;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128526;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128527;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128528;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128529;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128530;</a>'+
                            '<a class="ms-2 emojisStyle" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" style="font-size: 30px">&#128531;</a>'+
                        '</div>'+
                    '</div>'+
                    '</div>'+
                '</div>';
    return $emojies;
}

function modalFeedDelete(feedId) {

    $('#feedModalHeading').empty();
    $('#feedModalBodyContent').empty();
    var feedModalHeading = 'Delete Post?';
        $('#feedModalHeading').append(feedModalHeading);
    var feedModalBodyContent =
    '<div class="modal-body ">' +
        '<div class="d-flex align-items-center">' +
            '<p class="modal-title ms-3" id="unfollow-modalLabel">Do you want to delete post?</p>' +
        '</div>' +
    '</div>' +
    '<div class="modal-footer">' +
        '<div class="d-flex align-items-center">' +
            '<button data-bs-dismiss="modal" class="btn btn-primary me-2" onclick="deletePost(' + feedId + ')">Yes</button>' +
            '<span id="feedModalClose" type="button" class="btn btn-secondary me-2">No</span>' +
        '</div>' +
    '</div>';

    $('#feedModalBodyContent').append(feedModalBodyContent);
}

function openModalFeedLike(feedId, slug, feedDetail = null){
    $('.cover_spin').hide();
    $('#feedModalHeading').empty();
    $('#feedModalBodyContent').empty();

    if(slug == 'newsFeedComments' || slug == 'editFeed' || slug == 'shareFeed'){
        document.querySelector(".feed_likes_modal_loder").classList.remove('d-none');
        document.querySelector("#feed_likes_modal_popup").classList.add('show');
        document.querySelector("#feed_likes_modal_popup").style.display = "block";
    }

    var feedModalHeader = document.querySelector("#feedModalHeader");
    if (!feedModalHeader.classList.contains('d-none')) {
        feedModalHeader.classList.add('d-none');
    }
    var body = document.body;
        body.style.overflow = 'hidden';
        body.style.pointerEvents = 'none';

    $.ajax({
        method: 'Post',
        url: '/feed-data-modal',
        data: {feedId, slug, feedDetail},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function (response) {
        console.log(response.postType, response.data);
        var responseFeed = response.data.feeds;
        var responseFeedUser =  response.data.feeds.get_user;
        var userAuthId = response.data.userAuthId;
        var userAuth = response.data.userAuth;
        if(response.postType == 'newsFeedLikes'){
            document.querySelector("#feedModalHeader").classList.remove('d-none');
            if(responseFeed.page_details != null){
                var feedModalHeading = responseFeed.page_details.page_name+"'s post";
            }else if(responseFeed.group_details != null){
                var feedModalHeading = responseFeed.group_details.group_name+"'s post";
            }else{
                var feedModalHeading = responseFeedUser.first_name + ' '+ responseFeedUser.last_name+"'s post";
            }
            $('#feedModalHeading').append(feedModalHeading);

            responseFeed.likes.forEach(function(like, key) {
                var feedModalBodyContent =
                '<input id="feedModalPageFeed" type="hidden" value="'+ responseFeed.page_id +'">'+
                '<input id="feedModalGroupFeed" type="hidden" value="'+ responseFeed.group_id +'">'+
                '<input id="feedModalNewsFeed" type="hidden" value="'+ responseFeed.id +'">'+
                '<div class="d-flex align-items-center justify-content-between">'+
                    '<a class="align-items-baseline d-flex" href="/profile/' + like.get_user_data.username + '">' +
                        '    <div class="user-img me-2">' +
                        '        ' + (like.get_user_data && like.get_user_data.avatar_location ?
                        '            <img src="/storage/images/user/userProfileandCovers/' + like.get_user_data.id + '/' + like.get_user_data.avatar_location + '" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">' :
                        '            <img src="/images/user/Users_60x60.png" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">') +
                        '    </div>' +
                        '    <p>' + like.get_user_data.first_name + ' ' + like.get_user_data.last_name + '</p>' +
                    '</a>';
                    if(response.data.friendRequestList[key] != null && userAuthId != like.get_user_data.id){
                        feedModalBodyContent +=
                        '<a onclick="addToFriendUser(\'' + like.get_user_data.username + '\')" href="javascript:void(0);" class="btn btn-primary px-2 py-1 fs-6 d-flex align-items-center d-none addToFriend_'+like.get_user_data.username+'">'+
                            '<i class="material-symbols-outlined me-2">add</i>'+
                            'Add Friend'+
                        '</a>'+
                        '<a onclick="cancelRequestUser(\'' + like.get_user_data.username + '\')" href="javascript:void(0);" class="btn btn-primary px-2 py-1 fs-6 cancelRequest_'+like.get_user_data.username+'">Cancel Request</a>';
                    }else if(response.data.friendList[key] == null && userAuthId != like.get_user_data.id){
                        feedModalBodyContent +=
                        '<a onclick="addToFriendUser(\'' + like.get_user_data.username + '\')" href="javascript:void(0);" class="btn btn-primary px-2 py-1 fs-6 d-flex align-items-center addToFriend_'+like.get_user_data.username+'">'+
                            '<i class="material-symbols-outlined me-2">add</i>'+
                            'Add Friend'+
                        '</a>'+
                        '<a onclick="cancelRequestUser(\'' + like.get_user_data.username + '\')" href="javascript:void(0);" class="btn btn-primary px-2 py-1 fs-6 d-none cancelRequest_'+like.get_user_data.username+'">Cancel Request</a>';
                    }else if(userAuthId != like.get_user_data.id){
                        feedModalBodyContent +=
                        '<button action="#" onclick="createAndFetchChats('+0+',' + like.get_user_data.id + ')" type="submit" class="btn btn-primary px-2 py-1 fs-6 d-flex align-items-center">Message</button>';
                    }else{

                    }
                '</div>';

                $('#feedModalBodyContent').append(feedModalBodyContent);
                document.querySelector("#feed_likes_modal_popup").classList.add('show');
                document.querySelector("#feed_likes_modal_popup").style.display = "block";
            });
        }
        if(response.postType == 'newsFeedComments'){

            document.querySelector(".feed_likes_modal_loder").classList.add('d-none');
            document.querySelector("#feedModalHeader").classList.remove('d-none');
            var feedModalHeading = responseFeedUser.first_name +' ' +responseFeedUser.last_name+"'s post";
            $('#feedModalHeading').append(feedModalHeading);
            var feedModalOnClick = (responseFeed.page_id) ? 'onclick="openModalFeedLike('+ responseFeed.id + ', \'editFeed\', \'pageDetails\')"' : (responseFeed.group_id) ? 'onclick="openModalFeedLike('+ responseFeed.id + ', \'editFeed\', \'groupDetails\')"' :  'onclick="openModalFeedLike('+ responseFeed.id + ', \'editFeed\', \'profileFeed\')"' ;
            var feedModalBodyContent =
            '<input id="feedModalPageFeed" type="hidden" value="'+ responseFeed.page_id +'">'+
            '<input id="feedModalGroupFeed" type="hidden" value="'+ responseFeed.group_id +'">'+
            '<input id="feedModalNewsFeed" type="hidden" value="'+ responseFeed.id +'">'+
            '<div class="user-post-data">' +
                '<div class="d-flex justify-content-between">' +
                    '<div class="me-3">' +
                        (responseFeedUser.avatar_location && responseFeedUser.avatar_location !== '' ?
                            '<img class="avatar-60 rounded-circle" src="/storage/images/user/userProfileandCovers/' + responseFeedUser.id + '/' + responseFeedUser.avatar_location + '" width="60px" height="60px" alt="" loading="lazy">' :
                            '<img class="rounded-circle" src="/images/user/Users_60x60.png" alt="" loading="lazy">') +
                    '</div>' +
                    '<div class="w-100">'+
                        '<div class="d-flex justify-content-between flex-wrap">'+
                            '<div class="">'+
                                (responseFeedUser.username && responseFeedUser.username !== '' ?
                                    '<a href="profile/'+ responseFeedUser.username +'" class="">'+
                                        '<h5 class="mb-0 d-inline-block">'+ responseFeedUser.first_name +' '+ responseFeedUser.last_name +'</h5>'+
                                    '</a>' :
                                    '<h5 class="mb-0 d-inline-block">'+ responseFeedUser.first_name +' '+  responseFeedUser.last_name +'</h5>')+
                                '<p class="mb-0">'+formatDate(responseFeed.created_at)+'</p>'+
                            '</div>'+
                            '<div class="card-post-toolbar">' +
                                '<div class="dropdown">' +
                                    '<span class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">' +
                                    '<span class="material-symbols-outlined">' +
                                        'more_horiz' +
                                    '</span>' +
                                    '</span>' +
                                    '<div class="dropdown-menu m-0 p-0">' +
                                        (responseFeedUser.id == userAuthId ?
                                            (responseFeed.page_details == null && responseFeed.group_details == null ?
                                            '<a href="javascript:void(0);" class="dropdown-item p-3" onclick="savePost('+responseFeed.id+')" action="javascript:void();" role="button">' +
                                                '<div class="d-flex align-items-top">' +
                                                    '<i class="ri-delete-bin-7-line h4"></i>' +
                                                    '<div class="data ms-2">' +
                                                        '<p class="mb-0">Add this post to your favorites</p>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</a>' :
                                            '')+
                                            '<a href="javascript:void(0);" class="dropdown-item p-3" '+ feedModalOnClick +' action="javascript:void();" role="button">' +
                                                '<div class="d-flex align-items-top">' +
                                                    '<i class="ri-delete-bin-7-line h4"></i>' +
                                                    '<div class="data ms-2">' +
                                                        '<p class="mb-0">Edit Post</p>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</a>'+
                                            '<a href="javascript:void(0);" class="dropdown-item p-3" onclick="modalFeedDelete('+responseFeed.id+')" action="javascript:void();" role="button">' +
                                                '<div class="d-flex align-items-top">' +
                                                    '<i class="ri-delete-bin-7-line h4"></i>' +
                                                    '<div class="data ms-2">' +
                                                        '<p class="mb-0">Delete</p>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</a>' :
                                        '')+
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            '<div class="mt-3">'+
                (responseFeed.post != null && responseFeed.post != 'null' ?
                '<p class="ps-2">'+ responseFeed.post +'</p>':
                '')+
            '</div>';
            feedModalBodyContent +=
            '<div class="user-post">'+
                '<div class=" d-grid grid-rows-2 grid-flow-col gap-3">'+
                    '<div class="row-span-2 row-span-md-1">';
                        if (responseFeed.attachments.length === 1) {
                            if (responseFeed.attachments[0].attachment_type === 'video') {
                                feedModalBodyContent +=
                                '<div class="grid1">' +
                                    '<video class="w-100 h-100" controls>' +
                                        '<source src="/storage/images/feed-img/' + responseFeedUser.id + '/' + responseFeed.attachments[0].attachment + '">' +
                                    '</video>' +
                                '</div>';
                            } else {
                                feedModalBodyContent +=
                                '<div class="grid1">' +
                                    '<a data-fslightbox="gallery-' + responseFeed.id + '" href="/storage/images/feed-img/' + responseFeedUser.id + '/' + responseFeed.attachments[0].attachment + '">' +
                                        '<img src="/storage/images/feed-img/' + responseFeedUser.id + '/' + responseFeed.attachments[0].attachment + '" alt="post-image" class="img-fluid rounded w-100" loading="lazy">' +
                                    '</a>' +
                                '</div>';
                            }
                        } else if (responseFeed.attachments.length === 2) {
                            feedModalBodyContent +=
                            '<div class="grid2">';
                                let index = 0;
                                responseFeed.attachments.forEach(function (image) {
                                    if (index === 2) {
                                        return;
                                    }
                                    if (image.attachment_type === 'image') {
                                        feedModalBodyContent +=
                                        '<a data-fslightbox="gallery-' + responseFeed.id + '" href="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '">' +
                                            '<img src="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '" alt="post2-image" class="img-fluid rounded w-100" loading="lazy">' +
                                        '</a>';
                                    } else {
                                        feedModalBodyContent +=
                                        '<a data-fslightbox="gallery-' + responseFeed.id + '" href="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '">' +
                                            '<video class="w-100 h-100" controls>' +
                                                '<source src="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '">' +
                                            '</video>' +
                                        '</a>';
                                    }
                                    index++;
                                });
                            feedModalBodyContent +=
                            '</div>';
                        } else if (responseFeed.attachments.length > 2) {
                            let remainingAttachmentCount = responseFeed.attachments.length - 2;
                            let index = 0;
                            feedModalBodyContent +=
                            '<div class="grid2" id="graterThanTwoImageMainDiv-' + responseFeed.id + '">';
                                responseFeed.attachments.forEach(function (image) {
                                    if (index === 2) {
                                        return;
                                    }
                                    if (index === 1) {
                                        if (image.attachment_type === 'image') {
                                            feedModalBodyContent +=
                                            '<a data-fslightbox="gallery-' + responseFeed.id + '" href="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '">' +
                                                '<div class="image_overlay-wrapper">' +
                                                    '<div class="image_overlay rounded" onclick="showAllImages(' + responseFeed.id + ',' + responseFeed.attachments + ',' + responseFeedUser.id + ',/storage/images/feed-img/)">+'
                                                        + remainingAttachmentCount +
                                                    '</div>' +
                                                    '<img src="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '" alt="post3-image" class="img-fluid rounded w-100" loading="lazy">' +
                                                '</div>' +
                                            '</a>';
                                        } else {
                                            feedModalBodyContent +=
                                            '<a data-fslightbox="gallery-' + responseFeed.id + '" href="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '">' +
                                                '<div class="image_overlay-wrapper">' +
                                                    '<div class="image_overlay rounded" onclick="showAllImages(' + responseFeed.id + ',' + responseFeed.attachments + ',' + responseFeedUser.id + ',/storage/images/feed-img/)">+'
                                                        + remainingAttachmentCount +
                                                    '</div>' +
                                                    '<video class="w-100 h-100" controls>' +
                                                        '<source src="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '">' +
                                                    '</video>' +
                                                '</div>' +
                                            '</a>';
                                        }
                                    } else {
                                        if (image.attachment_type === 'image') {
                                            feedModalBodyContent +=
                                            '<a data-fslightbox="gallery-' + responseFeed.id + '" href="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '">' +
                                                '<div class="image_overlay-wrapper">' +
                                                    '<img src="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '" alt="post3-image" class="img-fluid rounded w-100" loading="lazy">' +
                                                '</div>' +
                                            '</a>';
                                        } else {
                                            feedModalBodyContent +=
                                            '<a data-fslightbox="gallery-' + responseFeed.id + '" href="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '">' +
                                                '<div class="image_overlay-wrapper">' +
                                                    '<video class="w-100 h-100" controls>' +
                                                        '<source src="/storage/images/feed-img/' + responseFeedUser.id + '/' + image.attachment + '">' +
                                                    '</video>' +
                                                '</div>' +
                                            '</a>';
                                        }
                                    }
                                    index++;
                                });
                            feedModalBodyContent +=
                            '</div>';
                        }
                        feedModalBodyContent +=
                    '</div>'+
                '</div>'+
            '</div>'+

            '<hr>';
            var className = (responseFeed.page_id) ? '-page-' : (responseFeed.group_id) ? '-group-' : '';
            feedModalBodyContent +=
            '<div class="comment-area mt-3" id="comment-area'+responseFeed.id+'" style="margin-bottom:45px;">'+
                '<div id="UpdateLikeCommentCount'+responseFeed.id+'">'+
                    '<div class="like-block position-relative d-flex justify-content-between align-items-center">'+
                        '<div class="d-flex align-items-center">'+
                            '<div class="total-like-block ms-2 me-3">'+
                                '<span class="span-likeCount'+className+responseFeed.id+'"';
                                    var feedModalOnClick = (responseFeed.page_id) ? 'onclick="openModalFeedLike('+ responseFeed.id + ', \'newsFeedLikes\', \'pageDetails\')"' : (responseFeed.group_id) ? 'onclick="openModalFeedLike('+ responseFeed.id + ', \'newsFeedLikes\', \'groupDetails\')"' :  'onclick="openModalFeedLike('+ responseFeed.id + ', \'newsFeedLikes\', \'profileFeed\')"' ;
                                    feedModalBodyContent +=
                                    feedModalOnClick+
                                    'action="javascript:void();"'+
                                '>';
                                    if(responseFeed.likes_count != 0) {
                                        var likeCount = (responseFeed.likes_count == 0) ? '' : (responseFeed.likes_count <= 1) ? ' Like ' :  ' Likes ' ;
                                        feedModalBodyContent += responseFeed.likes_count + likeCount;
                                    }
                                    feedModalBodyContent +=
                                '</span>'+
                            '</div>'+
                        '</div>'+
                        '<div class="total-comment-block">';
                            var commentsCount = (responseFeed.comments_count == 0) ? '' : (responseFeed.comments_count <= 1) ? ' Comment' :  ' Comments' ;
                            if(responseFeed.comments_count != 0 ){
                                feedModalBodyContent +=
                                '<span class="span-commentCount'+className+responseFeed.id+'"';
                                    var feedModalOnClick = (responseFeed.page_id) ? 'onclick="openModalFeedLike('+ responseFeed.id + ', \'newsFeedComments\', \'pageDetails\')"' : (responseFeed.group_id) ? 'onclick="openModalFeedLike('+ responseFeed.id + ', \'newsFeedComments\', \'groupDetails\')"' :  'onclick="openModalFeedLike('+ responseFeed.id + ', \'newsFeedComments\', \'profileFeed\')"' ;
                                    feedModalBodyContent += feedModalOnClick+
                                    'action="javascript:void();"'+
                                '> '+
                                    responseFeed.comments_count + commentsCount +
                                '</span>';
                            }
                        feedModalBodyContent +=
                        '</div>'+
                    '</div>'+
                    '<hr>'+
                    '<div class="like-block justify-content-around position-relative d-flex align-items-center">'+
                        '<div class="total-like-block d-flex align-items-center feather-icon mt-2 mt-md-0">';
                            var CheckAuthlike = responseFeed.likes;
                            var containsCurrentUser = CheckAuthlike.some(function(like) {
                                return like.user_id === userAuthId;
                            });
                            var savePostLikeOnClick = (responseFeed.page_id) ? 'onclick="savePagePostLike(' + responseFeed.id + ', ' + userAuthId + ', \'like\', '+ responseFeed.page_id +')"'
                                              : (responseFeed.group_id) ? 'onclick="saveGroupLike(' + responseFeed.id + ', ' + userAuthId + ', \'like\', '+ responseFeed.group_id +')"'
                                              :  'onclick="savePostLike(' + responseFeed.id + ', ' + userAuthId + ', \'like\')"' ;
                            if(containsCurrentUser == true){
                                feedModalBodyContent +='<span class="d-flex" '+savePostLikeOnClick+' href="javascript:void(0);"><span class="material-symbols-outlined material-symbols-outlined-filled text-primary pe-2 span-like'+className+responseFeed.id+'">thumb_up</span>Like</span>';
                            }else{
                                feedModalBodyContent +='<span class="d-flex" '+savePostLikeOnClick+' href="javascript:void(0);"><span class="material-symbols-outlined md-18 pe-2 span-like'+className+responseFeed.id+'">thumb_up</span> Like</span>';
                            }
                        feedModalBodyContent +=
                        '</div>'+
                        '<div class="total-comment-block d-flex align-items-center feather-icon mt-2 mt-md-0">'+
                            '<span class="material-symbols-outlined md-18">chat_bubble</span>'+
                            '<span class="ms-1 dropdown-toggle" onclick="commentInputFocus('+ responseFeed.id +', \''+className+'\')"><b>Comment</b></span>'+
                        '</div>'+
                        '<div class="share-block d-flex align-items-center feather-icon mt-2 mt-md-0">'+
                            '<a href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#share-btn" aria-controls="share-btn" class="d-flex align-items-center">'+
                                '<svg xmlns="http://www.w3.org/2000/svg" width="22px" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 120 120" style="enable-background:new 0 0 120 120;" xml:space="preserve"><g><g><path class="st0" d="M67.47,15.66l43.8,43.8l-43.8,44.13V78.71v-4.56l-4.54-0.42c-0.17-0.02-1.76-0.16-4.37-0.16 c-9.11,0-35.09,1.87-51.17,21.72c1.38-12.2,5.23-27.39,15.2-38.5c9.33-10.4,22.75-15.67,39.88-15.67h5v-5V15.66 M62.47,3.59v32.54 c-69.31,0-60.43,80.29-60.43,80.29C12.34,81.6,46.86,78.58,58.56,78.58c2.46,0,3.91,0.13,3.91,0.13v37.01l55.86-56.28L62.47,3.59 L62.47,3.59z"/></g></g></svg>'+
                                '<span style="font-weight:bold;" class="ms-1">';
                                    var shareText = (responseFeed.share_count <= 1 && responseFeed.share_count != 0) ? ' Share ' :  ' Shares ' ;
                                    var shareCount = (responseFeed.share_count == 0) ? '' : responseFeed.share_count ;
                                    feedModalBodyContent += shareCount + shareText +
                                '</span>'+
                            '</a>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<hr>'+
                '<ul class="post-comments p-0 m-0 comment-section'+className+responseFeed.id+'" id="UpdateCommentsPostDiv_' + responseFeed.id + '">';
                    responseFeed.comments.forEach(function (comm) {
                        feedModalBodyContent +=
                        '<div class="comment-list-'+className + responseFeed.id + comm.id+'">'+
                            '<li class="mb-2 comment-li-'+className + responseFeed.id + comm.id+'">' +
                                '<div class="d-flex mb-2">' +
                                    '<div class="user-img">';
                                        if (comm.get_user_data.avatar_location && comm.get_user_data.avatar_location !== '') {
                                            feedModalBodyContent +=
                                            '<img src="/storage/images/user/userProfileandCovers/' + comm.get_user_data.id + '/' + comm.get_user_data.avatar_location + '" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">';
                                        } else {
                                            feedModalBodyContent +=
                                            '<img src="/images/user/Users_60x60.png" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">';
                                        }

                                    feedModalBodyContent +=
                                    '</div>' +
                                    '<div class="comment-data-block ms-3">'+
                                        '<div class="bg-soft-light px-2 py-1 rounded-3">';
                                            if (comm.get_user_data.username && comm.get_user_data.username !== '') {
                                                feedModalBodyContent +=
                                                '<a href="/profile/'+comm.get_user_data.username+'" class=""><h6>' + comm.get_user_data.first_name + ' ' + comm.get_user_data.last_name + '</h6></a>';
                                            } else {
                                                feedModalBodyContent +=
                                                '<h6>' + comm.get_user_data.first_name + ' ' + comm.get_user_data.last_name + '</h6>';
                                            }
                                            feedModalBodyContent +='<p class="mb-0 text-dark">' + comm.comment + '</p>'+
                                        '</div>'+
                                        '<div class="d-flex flex-wrap align-items-center comment-activity">';
                                            var CheckAuthlike = comm.comment_likes;
                                            var containsCurrentUser = CheckAuthlike.some(function(like) {
                                                return like.user_id === userAuthId;
                                            });
                                            feedModalBodyContent +=
                                            '<a id="comment-like-button" class="comment-reply-user span-like'+className+responseFeed.id+comm.id+' ' + (containsCurrentUser == true ? 'text-primary' : 'text-dark') + '"';
                                                var saveCommentLike = (responseFeed.page_id) ? 'onclick="saveCommentLikePage(' + responseFeed.id + ', ' + comm.id + ', ' + userAuthId + ', ' + responseFeed.page_id + ')"'
                                                                    : (responseFeed.group_id) ? 'onclick="saveGroupCommentLike(' + responseFeed.id + ', ' + comm.id + ', ' + userAuthId + ', ' + responseFeed.group_id + ')"'
                                                                    :  'onclick="saveCommentLike(' + responseFeed.id + ', ' + comm.id + ', ' + userAuthId + ')"' ;
                                                feedModalBodyContent += saveCommentLike+
                                                'href="javascript:void(0);"'+
                                                '>';
                                                var commentLikeText = (comm.likes_count == 1 || comm.likes_count == 0) ? ' Like ' :  ' Likes ' ;
                                                var commentLikeCount = (comm.likes_count == 0) ? '' : comm.likes_count + ' ' ;
                                                feedModalBodyContent += commentLikeCount + commentLikeText +
                                            '</a>'+
                                            '<a class="comment-reply-user text-dark" href="javascript:void(0);"';
                                                var modalOpen = true;
                                                var toggleCommentReplyBox = (responseFeed.page_id) ? 'onclick="toggleReplyBox(' + comm.id + ', \'-page-\', '+modalOpen+')"'
                                                                        : (responseFeed.group_id) ? 'onclick="toggleReplyBox(' + comm.id + ', \'-group-\', '+modalOpen+')"'
                                                                        :  'onclick="toggleReplyBox(' + comm.id + ', '+modalOpen+')"' ;
                                                feedModalBodyContent += toggleCommentReplyBox+
                                            '>reply</a>';
                                            if (userAuthId == comm.get_user_data.id || responseFeedUser.id == userAuthId) {
                                                feedModalBodyContent +=
                                                '<a class="comment-reply-user text-dark" href="javascript:void(0);"';
                                                var toggleCommentReplyBox = (responseFeed.page_id) ? 'onclick="deleteGroupPagesFeedComment(' + responseFeed.id + ', ' + comm.id + ', ' + userAuthId + ', ' + responseFeed.page_id + ', \'page\')"'
                                                                        : (responseFeed.group_id) ? 'onclick="deleteGroupPagesFeedComment(' + responseFeed.id + ', ' + comm.id + ', ' + userAuthId + ', ' + responseFeed.group_id + ', \'group\')"'
                                                                        :  'onclick="deleteFeedComment(' + responseFeed.id + ', ' + comm.id + ', ' + userAuthId + ')"' ;
                                                    feedModalBodyContent += toggleCommentReplyBox+
                                                '>delete</a>';
                                            }

                                            feedModalBodyContent +=
                                            '<span>' + formatDate(comm.created_at) + '</span>' +
                                        '</div>' +

                                        '<div class="comment-reply-box new-comment-emoji d-flex d-none" id="comment-reply-box--modalOpen-' + comm.id + '">' +
                                            '<input type="hidden" name="parentCommentId" id="parentCommentId' + comm.id + '" value="' + comm.id + '">';
                                            var modalOpen = true;
                                            if(responseFeed.page_id){
                                                feedModalBodyContent += '<input type="text" name="comment" id="comment-input-reply-page--modalOpen-' + comm.id + '" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, ' + responseFeed.id + ', ' + comm.id + ', ' + responseFeed.page_id + ', \'-page-\', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                            }else if(responseFeed.group_id){
                                                feedModalBodyContent += '<input type="text" name="comment" id="comment-input-reply-group--modalOpen-' + comm.id + '" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, ' + responseFeed.id + ', ' + comm.id + ', ' + responseFeed.group_id + ', \'-group-\', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                            }else{
                                                feedModalBodyContent += '<input type="text" name="comment" id="comment-input-reply-modalOpen-' + comm.id + '" onkeyup="saveCommentReply(event.keyCode, ' + responseFeed.id + ', ' + comm.id + ', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                            }
                                        feedModalBodyContent +=
                                        '</div>' +
                                    '</div>' +
                                '</div>' ;
                                if (comm.get_replies) {
                                    feedModalBodyContent +=
                                    '<ul class="get-replies">';
                                        comm.get_replies.forEach(function (reply) {
                                            feedModalBodyContent +='<div class="comment-list-'+className + responseFeed.id + reply.id+'">';
                                                if (reply.get_user_data) {
                                                    feedModalBodyContent +=
                                                    '<li class="mb-2 comment-li-'+className + responseFeed.id + reply.id+'">' +
                                                        '<div class="d-flex mb-2">' +
                                                            '<div class="user-img">';
                                                                if (reply.get_user_data.avatar_location && reply.get_user_data.avatar_location !== '') {
                                                                    feedModalBodyContent +=
                                                                        '<img src="/storage/images/user/userProfileandCovers/'+reply.get_user_data.id +'/'+ reply.get_user_data.avatar_location+'" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">';
                                                                } else {
                                                                    feedModalBodyContent +=
                                                                        '<img src="/images/user/Users_60x60.png" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">';
                                                                }

                                                            feedModalBodyContent +=
                                                            '</div>' +
                                                            '<div class="comment-data-block ms-3">'+
                                                                '<div class="bg-soft-light px-2 py-1 rounded-3">';
                                                                    if (reply.get_user_data.username && reply.get_user_data.username !== '') {
                                                                        feedModalBodyContent +=
                                                                            '<a href="/profile/'+reply.get_user_data.username+'" class="">' +
                                                                                '<h6>' + reply.get_user_data.first_name + ' ' + reply.get_user_data.last_name + '</h6>' +
                                                                            '</a>';
                                                                    } else {
                                                                        feedModalBodyContent +=
                                                                        '<h6>' + reply.get_user_data.first_name + ' ' + reply.get_user_data.last_name + '</h6>';
                                                                    }
                                                                    feedModalBodyContent +=
                                                                    '<p class="mb-0 text-dark">';
                                                                        for (var i = 0; i < responseFeed.comments.length; i++) {
                                                                            if (responseFeed.comments.length > 0 && responseFeed.comments[i].get_user_data) {
                                                                                if (responseFeed.comments[i].id == reply.parent_id && responseFeed.comments[i]['get_user_data'].id !== reply['get_user_data'].id) {
                                                                                    if (responseFeed.comments[i]['get_user_data'].username && responseFeed.comments[i]['get_user_data'].username !== '') {
                                                                                        feedModalBodyContent +=
                                                                                            '<a style="font-weight: bold;" href="/profile/'+responseFeed.comments[i]['get_user_data'].username+'" class="text-body">' +
                                                                                                responseFeed.comments[i]['get_user_data'].first_name + ' ' + responseFeed.comments[i]['get_user_data'].last_name +
                                                                                            '</a>';
                                                                                    } else {
                                                                                        feedModalBodyContent +=
                                                                                            responseFeed.comments[i]['get_user_data'].first_name + ' ' + responseFeed.comments[i]['get_user_data'].last_name;
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        feedModalBodyContent +=
                                                                        '&nbsp;' + reply.comment +
                                                                    '</p>' +
                                                                '</div>'+
                                                                '<div class="d-flex flex-wrap align-items-center comment-activity">';
                                                                    var CheckAuthlike = reply.comment_likes;
                                                                    var containsCurrentUser = CheckAuthlike.some(function(like) {
                                                                        return like.user_id === userAuthId;
                                                                    });
                                                                    feedModalBodyContent +=
                                                                    '<a id="comment-like-button" class="comment-reply-user span-like'+className+responseFeed.id+reply.id+' ' + (containsCurrentUser == true ? 'text-primary' : 'text-dark') + '"';
                                                                        var saveCommentLike = (responseFeed.page_id) ? 'onclick="saveCommentLikePage(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.page_id + ')"'
                                                                                            : (responseFeed.group_id) ? 'onclick="saveGroupCommentLike(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.group_id + ')"'
                                                                                            :  'onclick="saveCommentLike(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ')"' ;
                                                                        feedModalBodyContent += saveCommentLike+
                                                                        'href="javascript:void(0);">';
                                                                        var replyLikeText = (reply.likes_count == 1 || reply.likes_count == 0) ? ' Like ' :  ' Likes ' ;
                                                                        var replyLikeCount = (reply.likes_count == 0) ? '' : reply.likes_count + ' ' ;
                                                                        feedModalBodyContent += replyLikeCount + replyLikeText +
                                                                    '</a>' +
                                                                    '<a class="comment-reply-user text-dark" href="javascript:void(0);"';
                                                                        var modalOpen = true;
                                                                        var toggleCommentReplyBox = (responseFeed.page_id) ? 'onclick="toggleReplyBox(' + reply.id + ', \'-page-\', '+modalOpen+')"'
                                                                                                : (responseFeed.group_id) ? 'onclick="toggleReplyBox(' + reply.id + ', \'-group-\', '+modalOpen+')"'
                                                                                                :  'onclick="toggleReplyBox(' + reply.id + ', '+modalOpen+')"' ;
                                                                        feedModalBodyContent += toggleCommentReplyBox+
                                                                        '>reply</a>';

                                                                    if (userAuthId == reply.get_user_data.id || responseFeedUser.id == userAuthId) {
                                                                        feedModalBodyContent +=
                                                                            '<a class="comment-reply-user text-dark" href="javascript:void(0);"';
                                                                                var toggleCommentReplyBox = (responseFeed.page_id) ? 'onclick="deleteFeedComment(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.page_id + ', \'page\')"'
                                                                                                        : (responseFeed.group_id) ? 'onclick="deleteFeedComment(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.group_id + ', \'group\')"'
                                                                                                        :  'onclick="deleteFeedComment(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ')"' ;
                                                                                feedModalBodyContent += toggleCommentReplyBox+
                                                                            '>delete</a>';
                                                                    }

                                                                    feedModalBodyContent +=
                                                                    '<span>' + formatDate(reply.created_at) + '</span>' +
                                                                '</div>' +
                                                                '<div class="comment-reply-box new-comment-emoji d-flex d-none" id="comment-reply-box--modalOpen-' + reply.id + '">' +
                                                                    '<input type="hidden" name="parentCommentId" id="parentCommentId' + reply.id + '" value="' + reply.id + '">';
                                                                    var modalOpen = true;
                                                                    if(responseFeed.page_id){
                                                                        feedModalBodyContent += '<input type="text" name="comment" id="comment-input-reply-page--modalOpen-' + reply.id + '" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, ' + responseFeed.id + ', ' + reply.id + ', ' + responseFeed.page_id + ', \'-page-\', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                                                    }else if(responseFeed.group_id){
                                                                        feedModalBodyContent += '<input type="text" name="comment" id="comment-input-reply-group--modalOpen-' + reply.id + '" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, ' + responseFeed.id + ', ' + reply.id + ', ' + responseFeed.group_id + ', \'-group-\', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                                                    }else{
                                                                        feedModalBodyContent += '<input type="text" name="comment" id="comment-input-reply-modalOpen-' + reply.id + '" onkeyup="saveCommentReply(event.keyCode, ' + responseFeed.id + ', ' + reply.id + ', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                                                    }
                                                                feedModalBodyContent +=
                                                                '</div>' +
                                                            '</div>' +
                                                        '</div>';
                                                        if (reply.get_replies) {
                                                            var replyGetReplies = reply.get_replies;
                                                            feedModalBodyContent +=
                                                            '<ul class="get-replies">';
                                                                reply.get_replies.forEach(function (reply) {
                                                                    feedModalBodyContent +=
                                                                    '<div class="comment-list-'+className + responseFeed.id + reply.id+'">';
                                                                        if (reply.get_user_data) {
                                                                            feedModalBodyContent +=
                                                                            '<li class="mb-2 comment-li-'+className + responseFeed.id + reply.id+'">' +
                                                                                '<div class="d-flex mb-2">' +
                                                                                    '<div class="user-img">';
                                                                                        if (reply.get_user_data.avatar_location && reply.get_user_data.avatar_location !== '') {
                                                                                            feedModalBodyContent +=
                                                                                                '<img src="/storage/images/user/userProfileandCovers/'+reply.get_user_data.id +'/'+ reply.get_user_data.avatar_location+'" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">';
                                                                                        } else {
                                                                                            feedModalBodyContent +=
                                                                                                '<img src="/images/user/Users_60x60.png" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">';
                                                                                        }

                                                                                    feedModalBodyContent +=
                                                                                    '</div>' +
                                                                                    '<div class="comment-data-block ms-3">'+
                                                                                        '<div class="bg-soft-light px-2 py-1 rounded-3">';
                                                                                            if (reply.get_user_data.username && reply.get_user_data.username !== '') {
                                                                                                feedModalBodyContent +=
                                                                                                    '<a href="/profile/'+reply.get_user_data.username+'" class="">' +
                                                                                                        '<h6>' + reply.get_user_data.first_name + ' ' + reply.get_user_data.last_name + '</h6>' +
                                                                                                    '</a>';
                                                                                            } else {
                                                                                                feedModalBodyContent +=
                                                                                                '<h6>' + reply.get_user_data.first_name + ' ' + reply.get_user_data.last_name + '</h6>';
                                                                                            }
                                                                                            feedModalBodyContent +=
                                                                                            '<p class="mb-0 text-dark">';
                                                                                                for (var i = 0; i < comm.get_replies.length; i++) {
                                                                                                    if (comm.get_replies.length > 0 && comm.get_replies[i].get_user_data) {
                                                                                                        if (comm.get_replies[i].id == reply.parent_id && comm.get_replies[i]['get_user_data'].id !== reply['get_user_data'].id) {
                                                                                                            if (comm.get_replies[i]['get_user_data'].username && comm.get_replies[i]['get_user_data'].username !== '') {
                                                                                                                feedModalBodyContent +=
                                                                                                                    '<a style="font-weight: bold;" href="/profile/'+comm.get_replies[i]['get_user_data'].username+'" class="text-body">' +
                                                                                                                        comm.get_replies[i]['get_user_data'].first_name + ' ' + comm.get_replies[i]['get_user_data'].last_name +
                                                                                                                    '</a>';
                                                                                                            } else {
                                                                                                                feedModalBodyContent +=
                                                                                                                    comm.get_replies[i]['get_user_data'].first_name + ' ' + comm.get_replies[i]['get_user_data'].last_name;
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                                feedModalBodyContent +=
                                                                                                '&nbsp;' + reply.comment +
                                                                                            '</p>' +
                                                                                        '</div>'+
                                                                                        '<div class="d-flex flex-wrap align-items-center comment-activity">';
                                                                                            var CheckAuthlike = reply.comment_likes;
                                                                                            var containsCurrentUser = CheckAuthlike.some(function(like) {
                                                                                                return like.user_id === userAuthId;
                                                                                            });
                                                                                            feedModalBodyContent +=
                                                                                            '<a id="comment-like-button"  class="comment-reply-user span-like'+className+responseFeed.id+reply.id+' ' + (containsCurrentUser == true ? 'text-primary' : 'text-dark') + '"';
                                                                                                var saveCommentLike = (responseFeed.page_id) ? 'onclick="saveCommentLikePage(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.page_id + ')"'
                                                                                                                    : (responseFeed.group_id) ? 'onclick="saveGroupCommentLike(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.group_id + ')"'
                                                                                                                    :  'onclick="saveCommentLike(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ')"' ;
                                                                                                feedModalBodyContent += saveCommentLike+
                                                                                                'href="javascript:void(0);">';
                                                                                                var replyLikeText = (reply.likes_count == 1 || reply.likes_count == 0) ? ' Like ' :  ' Likes ' ;
                                                                                                var replyLikeCount = (reply.likes_count == 0) ? '' : reply.likes_count + ' ' ;
                                                                                                feedModalBodyContent += replyLikeCount + replyLikeText +
                                                                                            '</a>' +
                                                                                            '<a href="javascript:void(0);"  class="comment-reply-user text-dark"';
                                                                                                var modalOpen = true;
                                                                                                var toggleCommentReplyBox = (responseFeed.page_id) ? 'onclick="toggleReplyBox(' + reply.id + ', \'-page-\', '+modalOpen+')"'
                                                                                                                        : (responseFeed.group_id) ? 'onclick="toggleReplyBox(' + reply.id + ', \'-group-\', '+modalOpen+')"'
                                                                                                                        :  'onclick="toggleReplyBox(' + reply.id + ', '+modalOpen+')"' ;
                                                                                                feedModalBodyContent += toggleCommentReplyBox+
                                                                                            '>reply</a>';

                                                                                            if (userAuthId == reply.get_user_data.id || responseFeedUser.id == userAuthId) {
                                                                                                feedModalBodyContent +=
                                                                                                    '<a href="javascript:void(0);"  class="comment-reply-user text-dark"';
                                                                                                        var toggleCommentReplyBox = (responseFeed.page_id) ? 'onclick="deleteFeedComment(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.page_id + ', \'page\')"'
                                                                                                                                : (responseFeed.group_id) ? 'onclick="deleteFeedComment(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.group_id + ', \'group\')"'
                                                                                                                                :  'onclick="deleteFeedComment(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ')"' ;
                                                                                                        feedModalBodyContent += toggleCommentReplyBox+
                                                                                                    '>delete</a>';
                                                                                            }

                                                                                            feedModalBodyContent +=
                                                                                            '<span>' + formatDate(reply.created_at) + '</span>' +
                                                                                        '</div>' +
                                                                                        '<div class="comment-reply-box new-comment-emoji d-flex d-none" id="comment-reply-box--modalOpen-' + reply.id + '">' +
                                                                                            '<input type="hidden" name="parentCommentId" id="parentCommentId' + reply.id + '" value="' + reply.id + '">';
                                                                                            var modalOpen = true;
                                                                                            if(responseFeed.page_id){
                                                                                                feedModalBodyContent += '<input type="text" name="comment" id="comment-input-reply-page--modalOpen-' + reply.id + '" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, ' + responseFeed.id + ', ' + reply.id + ', ' + responseFeed.page_id + ', \'-page-\', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                                                                            }else if(responseFeed.group_id){
                                                                                                feedModalBodyContent += '<input type="text" name="comment" id="comment-input-reply-group--modalOpen-' + reply.id + '" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, ' + responseFeed.id + ', ' + reply.id + ', ' + responseFeed.group_id + ', \'-group-\', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                                                                            }else{
                                                                                                feedModalBodyContent += '<input type="text" name="comment" id="comment-input-reply-modalOpen-' + reply.id + '" onkeyup="saveCommentReply(event.keyCode, ' + responseFeed.id + ', ' + reply.id + ', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                                                                            }
                                                                                        feedModalBodyContent +=
                                                                                        '</div>' +
                                                                                    '</div>' +
                                                                                '</div>' +
                                                                            '</li>';
                                                                        }
                                                                        if (reply.get_replies && reply.get_replies.length > 0) {
                                                                            feedModalBodyContent += processReplies(reply.get_replies, responseFeed, userAuthId, responseFeedUser, replyGetReplies);
                                                                        }
                                                                    feedModalBodyContent +='</div>';
                                                                });
                                                            feedModalBodyContent +=
                                                            '</ul>';
                                                        }
                                                    feedModalBodyContent +=
                                                    '</li>';
                                                }
                                            feedModalBodyContent +='</div>';
                                        });
                                    feedModalBodyContent +=
                                    '</ul>';
                                }
                            feedModalBodyContent +=
                            '</li>'+
                        '</div>';
                    });
                feedModalBodyContent +=
                '</ul>'
                '<hr>';
                feedModalBodyContent +=
                '<div class="comment-text d-flex align-items-center mt-3 new-comment-emoji d-flex" style="position:fixed; bottom: 2rem; z-index: 5; width: 100%; max-width: 560px; padding: 1rem 0; background-color: white;">'+
                    '<input type="hidden" value='+ responseFeed.id +' name="feedId" id="feedId-modalOpen-'+ responseFeed.id +'" class="form-control rounded">'+
                    '<input type="hidden" value='+ userAuthId +' name="userId" id="userId-modalOpen-'+ responseFeed.id +'" class="form-control rounded">';
                    var modalOpen = true;
                    if(responseFeed.page_id){
                        feedModalBodyContent +=
                        '<input type="text" name="comment" id="comment-input-page--modalOpen-'+ responseFeed.id +'" onkeyup="savePageComment(event.keyCode, '+ responseFeed.id +', '+ responseFeed.page_id +', '+modalOpen+')" class="form-control rounded feed-comment" placeholder="Enter Your Comment" style="margin-right: -32px !important;">';
                    }else if(responseFeed.group_id){
                        feedModalBodyContent +=
                        '<input type="text" name="comment" id="comment-input-group--modalOpen-'+ responseFeed.id +'" onkeyup="saveGroupComment(event.keyCode, '+ responseFeed.id +', '+ responseFeed.group_id +', '+modalOpen+')" class="form-control rounded feed-comment" placeholder="Enter Your Comment" style="margin-right: -32px !important;">';
                    }else{
                        feedModalBodyContent +=
                        '<input type="text" name="comment" id="comment-input-modalOpen-'+ responseFeed.id +'" onkeyup="saveComment(event.keyCode, '+ responseFeed.id +', '+modalOpen+')" class="form-control rounded  feed-comment"  placeholder="Enter Your Comment" style="margin-right: -32px !important;">' ;
                    }
                    emojiesComponent();
                '</div>'+
            '</div>';
            $('#feedModalBodyContent').append(feedModalBodyContent);
        }
        if(response.postType == 'editFeed'){
            document.querySelector(".feed_likes_modal_loder").classList.add('d-none');
            document.querySelector("#feedModalHeader").classList.remove('d-none');
            var feedModalHeading = "Edit post";
            $('#feedModalHeading').append(feedModalHeading);
            var feedModalBodyContent =
                '<input id="feedModalPageFeed" type="hidden" value="'+ responseFeed.page_id +'">'+
                '<input id="feedModalGroupFeed" type="hidden" value="'+ responseFeed.group_id +'">'+
                '<input id="feedModalNewsFeed" type="hidden" value="'+ responseFeed.id +'">'+
                '<div class="modal-body">'+
                    '<form method="post" action="/'+response.formAction+'" class="update-on-ajax w-100 my-3 " enctype="multipart/form-data">'+
                        '<div class="d-flex">'+
                            '<div class="user-img">' +
                                (responseFeedUser.avatar_location && responseFeedUser.avatar_location !== '' ?
                                    '<img class="avatar-60 rounded-circle" src="/storage/images/user/userProfileandCovers/' + responseFeedUser.id + '/' + responseFeedUser.avatar_location + '" width="60px" height="60px" alt="" loading="lazy">' :
                                    '<img class="rounded-circle" src="/images/user/Users_60x60.png" alt="" loading="lazy">') +
                            '</div>'+
                            '<div class="flex-input">';
                                var postData = (responseFeed.post == 'null' || responseFeed.post == null ) ? '' : responseFeed.post;
                                feedModalBodyContent +=
                                '<input type="text" name="postData" class="form-control rounded" id="postText" value="'+postData+'" placeholder="Write something here..." style="border:none;">'+
                            '</div>'+
                        '</div>'+
                        '<input type="hidden" class="form-control rounded" value="'+responseFeedUser.id+'" name="userId" style="border:none;">'+
                        '<input type="hidden" class="form-control rounded" value="'+responseFeed.id+'" name="feed_id">'+
                        '<input type="hidden" class="form-control rounded" value="'+response.feedType+'" name="type">'+
                        '<input type="hidden" class="form-control rounded feedAttachmentIds" value="" name="feed_attachment_ids">'+
                        '<input type="hidden" class="form-control rounded" value="editPost" name="formType">'+
                        '<hr>'+
                        '<ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">'+
                            '<li>'+
                                '<input type="file" multiple name="profileImage[]" id="profileImagePostEditFeed" class="form-control fileInputGetOldValuesEditFeed" accept="image/*,video/mp4,video/x-m4v,video/*" placeholder="Profile Image" style="border:none;" onclick="addMoreFilesEditFeed()" onchange="previewImagesEditFeed()">'+
                                '<div id="previewModalFeedEdit" class="p-2" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 8px; overflow-y: auto; max-height: 300px;min-width: 500px;">';

                                    responseFeed.attachments.forEach(function (feedAttachments) {
                                        feedModalBodyContent +=
                                            '<div class="editPostAttachmentsDelete'+feedAttachments.id+'" style="position: relative;">';
                                                var typeAttachment = (responseFeed.page_id) ? 'pageAttachment' : (responseFeed.group_id) ? 'groupAttachment' :  'feedAttachment' ;
                                                feedModalBodyContent +=
                                                '<span class="btn" onclick="deleteFeedAttachments('+feedAttachments.id+', \''+typeAttachment+'\')" title="delete image" id="0" style="position: absolute; top: 15px; right: 15px; color: rgb(232, 228, 237); margin-top: 11px; background-color: rgb(18, 17, 17); font-weight: 600; border-radius: 50%; border: 2px solid rgb(232, 228, 237); padding:1px 6px 0px 6px; z-index: 1;">X</span>';
                                                if(responseFeed.page_id){
                                                    if (feedAttachments.attachment_type === 'video') {
                                                        feedModalBodyContent += '<video class="w-100 h-100" controls><source src="/storage/images/page-img/'+ responseFeed.page_id + '/' + feedAttachments.attachment + '"></video>';
                                                    } else {
                                                        feedModalBodyContent += '<img src="/storage/images/page-img/'+ responseFeed.page_id + '/' + feedAttachments.attachment + '" style="margin-top: 1rem; width: 100%; height: 100%; object-fit: cover;">';
                                                    }
                                                }
                                                else if(responseFeed.group_id){
                                                    if (feedAttachments.attachment_type === 'video') {
                                                        feedModalBodyContent += '<video class="w-100 h-100" controls><source src="/storage/images/group-img/'+ responseFeed.group_id + '/' + feedAttachments.attachment + '"></video>';
                                                    } else {
                                                        feedModalBodyContent += '<img src="/storage/images/group-img/'+ responseFeed.group_id + '/' + feedAttachments.attachment + '" style="margin-top: 1rem; width: 100%; height: 100%; object-fit: cover;">';
                                                    }
                                                }
                                                else{
                                                    if (feedAttachments.attachment_type === 'video') {
                                                        feedModalBodyContent += '<video class="w-100 h-100" controls><source src="/storage/images/feed-img/' + responseFeedUser.id + '/' + feedAttachments.attachment + '"></video>';
                                                    } else {
                                                        feedModalBodyContent += '<img src="/storage/images/feed-img/' + responseFeedUser.id + '/' + feedAttachments.attachment + '" style="margin-top: 1rem; width: 100%; height: 100%; object-fit: cover;">';
                                                    }
                                                }
                                            feedModalBodyContent +=
                                            '</div>';
                                    });

                                feedModalBodyContent +=
                                '</div>'+
                            '</li>'+
                        '</ul>'+
                        '<button type="submit" class="btn btn-primary d-block w-100 mt-3">Post</button>'+
                    '</form>'+
                '</div>';
            $('#feedModalBodyContent').append(feedModalBodyContent);
        }
        if(response.postType == 'shareFeed'){
            document.querySelector(".feed_likes_modal_loder").classList.add('d-none');
            document.querySelector("#feedModalHeader").classList.remove('d-none');
            var feedModalHeading = "Share post";
            $('#feedModalHeading').append(feedModalHeading);
            var feedModalBodyContent =
                '<input id="feedModalPageFeed" type="hidden" value="'+ responseFeed.page_id +'">'+
                '<input id="feedModalGroupFeed" type="hidden" value="'+ responseFeed.group_id +'">'+
                '<input id="feedModalNewsFeed" type="hidden" value="'+ responseFeed.id +'">'+
                '<div class="modal-body">'+
                    '<form method="post" action="/'+response.formAction+'" class="update-on-ajax w-100 my-3 " enctype="multipart/form-data">'+
                        '<div class="d-flex">'+
                            '<div class="user-img">' +
                                (userAuth.avatar_location && userAuth.avatar_location !== '' ?
                                    '<img class="avatar-60 rounded-circle" src="/storage/images/user/userProfileandCovers/' + userAuth.id + '/' + userAuth.avatar_location + '" width="60px" height="60px" alt="" loading="lazy">' :
                                    '<img class="rounded-circle" src="/images/user/Users_60x60.png" alt="" loading="lazy">') +
                            '</div>'+
                            '<div class="flex-input">';
                                var postData = (responseFeed.post == 'null' || responseFeed.post == null ) ? '' : responseFeed.post;
                                feedModalBodyContent +=
                                '<input type="text" name="postData" class="form-control rounded" id="postText" value="" placeholder="Write something here..." style="border:none;">'+
                            '</div>'+
                        '</div>'+
                        '<input type="hidden" class="form-control rounded" value="'+responseFeedUser.id+'" name="userId" style="border:none;">'+
                        '<input type="hidden" class="form-control rounded" value="'+responseFeed.id+'" name="feed_id">'+
                        '<input type="hidden" class="form-control rounded" value="'+response.feedType+'" name="feedType">'+
                        '<input type="hidden" class="form-control rounded" value="'+response.feedType+'" name="type">';
                        var inputName = (responseFeed.page_id) ? 'pageId' : (responseFeed.group_id) ? 'groupId' : '';
                        var inputValue = (responseFeed.page_id) ? responseFeed.page_id : (responseFeed.group_id) ? responseFeed.group_id : '';
                        feedModalBodyContent +=
                        '<input type="hidden" class="form-control rounded" value="'+inputValue+'" name="'+ inputName +'">'+
                        '<input type="hidden" class="form-control rounded" value="sharePost" name="formType">'+
                        '<hr>'+
                        '<div class="user-post-data card p-2 border">' +
                            '<div class="d-flex justify-content-between">' +
                                '<ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">'+
                                    '<li>'+
                                        '<div id="previewModalFeedEdit" class="p-2" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 8px; overflow-y: auto; max-height: 300px;min-width: 500px;">';

                                            responseFeed.attachments.forEach(function (feedAttachments) {
                                                feedModalBodyContent +=
                                                    '<div class="editPostAttachmentsDelete'+feedAttachments.id+'" style="position: relative;">';
                                                        var typeAttachment = (responseFeed.page_id) ? 'pageAttachment' : (responseFeed.group_id) ? 'groupAttachment' :  'feedAttachment' ;
                                                        if (feedAttachments.attachment_type === 'video') {
                                                            feedModalBodyContent += '<video class="w-100 h-100" controls><source src="/storage/images/feed-img/' + responseFeedUser.id + '/' + feedAttachments.attachment + '"></video>';
                                                        } else {
                                                            feedModalBodyContent += '<img src="/storage/images/feed-img/' + responseFeedUser.id + '/' + feedAttachments.attachment + '" style="margin-top: 1rem; width: 100%; height: 100%; object-fit: cover;">';
                                                        }
                                                    feedModalBodyContent +=
                                                    '</div>';
                                            });

                                        feedModalBodyContent +=
                                        '</div>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>' +
                            '<div class="user-post-data pt-2">' +
                                '<div class="d-flex justify-content-between">' +
                                    '<div class="me-3">' +
                                        (responseFeedUser.avatar_location && responseFeedUser.avatar_location !== '' ?
                                            '<img class="avatar-60 rounded-circle" src="/storage/images/user/userProfileandCovers/' + responseFeedUser.id + '/' + responseFeedUser.avatar_location + '" width="60px" height="60px" alt="" loading="lazy">' :
                                            '<img class="rounded-circle" src="/images/user/Users_60x60.png" alt="" loading="lazy">') +
                                    '</div>' +
                                    '<div class="w-100">'+
                                        '<div class="d-flex justify-content-between flex-wrap">'+
                                            '<div class="">'+
                                                (responseFeedUser.username && responseFeedUser.username !== '' ?
                                                    '<a href="profile/'+ responseFeedUser.username +'" class="">'+
                                                        '<h5 class="mb-0 d-inline-block">'+ responseFeedUser.first_name +' '+ responseFeedUser.last_name +'</h5>'+
                                                    '</a>' :
                                                    '<h5 class="mb-0 d-inline-block">'+ responseFeedUser.first_name +' '+  responseFeedUser.last_name +'</h5>')+
                                                '<p class="mb-0">'+formatDate(responseFeed.created_at)+'</p>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="mt-3 ms-5">'+
                                    (responseFeed.post != null && responseFeed.post != 'null' ?
                                    '<p class="ps-5">'+ responseFeed.post +'</p>':
                                    '')+
                                '</div>'+
                            '</div>'+
                        '</div>' +
                        '<button type="submit" class="btn btn-primary d-block w-100 mt-3">Post</button>'+
                    '</form>'+
                '</div>';
            $('#feedModalBodyContent').append(feedModalBodyContent);
        }
    });
}

function processReplies(replies, responseFeed, userAuthId, responseFeedUser, replyGetReplies = null, modalOpen = false) {
    var $nestedReplies = '';
    var replyGetRepliesUser = replyGetReplies;
    var className = (responseFeed.page_id) ? '-page-' : (responseFeed.group_id) ? '-group-' : '';
    var feedModal = (modalOpen) ? '-modalOpen-' :  '';
    replies.forEach(function (reply) {
        $nestedReplies +=
        '<div class="comment-list-'+className + responseFeed.id + reply.id+'">';
            if (replies[0].get_user_data) {
                $nestedReplies +=
                '<div class="comment-section'+className+responseFeed.id+reply.id+'">'+
                    '<li class="mb-2 comment-li-'+className+responseFeed.id+reply.id+'">' +
                        '<div class="d-flex mb-2">' +
                            '<div class="user-img">';
                                if (reply.get_user_data.avatar_location && reply.get_user_data.avatar_location !== '') {
                                    $nestedReplies +=
                                        '<img src="/storage/images/user/userProfileandCovers/'+reply.get_user_data.id +'/'+ reply.get_user_data.avatar_location+'" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">';
                                } else {
                                    $nestedReplies +=
                                        '<img src="/images/user/Users_60x60.png" alt="userimg" class="avatar-35 rounded-circle" loading="lazy">';
                                }

                            $nestedReplies +=
                            '</div>' +
                            '<div class="comment-data-block ms-3">';
                                $nestedReplies +=
                                '<div class="bg-soft-light px-2 py-1 rounded-3">';
                                    if (reply.get_user_data.username && reply.get_user_data.username !== '') {
                                        $nestedReplies +=
                                            '<a href="/profile/'+reply.get_user_data.username+'" class="">' +
                                                '<h6>' + reply.get_user_data.first_name + ' ' + reply.get_user_data.last_name + '</h6>' +
                                            '</a>';
                                    } else {
                                        $nestedReplies +=
                                        '<h6>' + reply.get_user_data.first_name + ' ' + reply.get_user_data.last_name + '</h6>';
                                    }
                                    $nestedReplies +=
                                    '<p class="mb-0 text-dark">';
                                        if(replyGetRepliesUser){
                                            for (var i = 0; i < replyGetRepliesUser.length; i++) {
                                                if (replyGetRepliesUser.length > 0 && replyGetRepliesUser[i].get_user_data) {
                                                    if (replyGetRepliesUser[i].id == reply.parent_id && replyGetRepliesUser[i]['get_user_data'].id !== reply['get_user_data'].id) {
                                                        if (replyGetRepliesUser[i]['get_user_data'].username && replyGetRepliesUser[i]['get_user_data'].username !== '') {
                                                            $nestedReplies +=
                                                                '<a style="font-weight: bold;" href="/profile/'+replyGetRepliesUser[i]['get_user_data'].username+'" class="text-body">' +
                                                                    replyGetRepliesUser[i]['get_user_data'].first_name + ' ' + replyGetRepliesUser[i]['get_user_data'].last_name +
                                                                '</a>';
                                                        } else {
                                                            $nestedReplies +=
                                                                replyGetRepliesUser[i]['get_user_data'].first_name + ' ' + replyGetRepliesUser[i]['get_user_data'].last_name;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $nestedReplies +=
                                        '&nbsp;' + reply.comment +
                                    '</p>' +
                                '</div>'+
                                '<div class="d-flex flex-wrap align-items-center comment-activity">';
                                    var CheckAuthlike = reply.comment_likes;
                                    if(CheckAuthlike){
                                        var containsCurrentUser = CheckAuthlike.some(function(like) {
                                            return like.user_id === userAuthId;
                                        });
                                    }else{
                                        var containsCurrentUser = false;
                                    }
                                    $nestedReplies +=
                                    '<a id="comment-like-button" class="comment-reply-user span-like'+className+responseFeed.id+reply.id+' '+ (containsCurrentUser == true ? 'text-primary' : 'text-dark') + '"';
                                        var saveCommentLike = (responseFeed.page_id) ? 'onclick="saveCommentLikePage(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.page_id + ')"'
                                                            : (responseFeed.group_id) ? 'onclick="saveGroupCommentLike(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.group_id + ')"'
                                                            :  'onclick="saveCommentLike(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ')"' ;
                                        $nestedReplies += saveCommentLike+
                                        'href="javascript:void(0);">';
                                        var replyLikeText = (reply.likes_count == 1 || reply.likes_count == 0) ? ' Like ' :  ' Likes ' ;
                                        var replyLikeCount = (reply.likes_count == 0) ? '' : reply.likes_count + ' ' ;
                                        $nestedReplies += replyLikeCount + replyLikeText +
                                    '</a>' +
                                    '<a class="text-dark comment-reply-user" href="javascript:void(0);"';
                                        var toggleCommentReplyBox = (responseFeed.page_id) ? 'onclick="toggleReplyBox(' + reply.id + ', \'-page-\', '+modalOpen+')"'
                                                                : (responseFeed.group_id) ? 'onclick="toggleReplyBox(' + reply.id + ', \'-group-\', '+modalOpen+')"'
                                                                :  'onclick="toggleReplyBox(' + reply.id + ', '+modalOpen+')"' ;
                                        $nestedReplies += toggleCommentReplyBox+
                                        '>reply</a>';
                                    if (userAuthId == reply.get_user_data.id || responseFeedUser.id == userAuthId) {
                                        $nestedReplies +=
                                            '<a class="text-dark comment-reply-user" href="javascript:void(0);"';
                                                var toggleCommentReplyBox = (responseFeed.page_id) ? 'onclick="deleteGroupPagesFeedComment(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.page_id + ', \'page\')"'
                                                                        : (responseFeed.group_id) ? 'onclick="deleteGroupPagesFeedComment(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ', ' + responseFeed.group_id + ', \'group\')"'
                                                                        :  'onclick="deleteFeedComment(' + responseFeed.id + ', ' + reply.id + ', ' + userAuthId + ')"' ;
                                                                        $nestedReplies += toggleCommentReplyBox+
                                            '>delete</a>';
                                    }

                                    $nestedReplies +=
                                    '<span>' + formatDate(reply.created_at) + '</span>' +
                                '</div>';
                                $nestedReplies +=
                                '<div class="comment-reply-box new-comment-emoji d-flex d-none" id="comment-reply-box-' + feedModal + reply.id + '">' +
                                    '<input type="hidden" name="parentCommentId" id="parentCommentId' + reply.id + '" value="' + reply.id + '">';
                                    if(responseFeed.page_id){
                                        $nestedReplies += '<input type="text" name="comment" id="comment-input-reply'+ feedModal +'-page-'  + reply.id + '" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, ' + responseFeed.id + ', ' + reply.id + ', ' + responseFeed.page_id + ', \'page\', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                    }else if(responseFeed.group_id){
                                        $nestedReplies += '<input type="text" name="comment" id="comment-input-reply'+ feedModal +'-group-' + reply.id + '" onkeyup="saveGroupsPagesCommentsReply(event.keyCode, ' + responseFeed.id + ', ' + reply.id + ', ' + responseFeed.group_id + ', \'group\', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                    }else{
                                        $nestedReplies += '<input type="text" name="comment" id="comment-input-reply' + feedModal + reply.id + '" onkeyup="saveCommentReply(event.keyCode, ' + responseFeed.id + ', ' + reply.id + ', '+modalOpen+')" class=" form-control rounded feed-comment text-dark" style="width: 450px; margin-right: -32px !important;" placeholder="Enter Your Reply">' ;
                                    }
                                $nestedReplies +=
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</li>'+
                '</div>';
                var replyGetReplies = replies;
                if(reply.get_replies){
                    $nestedReplies += processReplies(reply.get_replies, responseFeed, userAuthId, responseFeedUser, replyGetReplies);
                }
            }
        $nestedReplies +='</div>';
    });
    return $nestedReplies;
}
$(document).ready(function() {
    $('#feedModalClose').click(function(event) {
        $('.cover_spin').show();
        RsPageId = document.querySelector("#feedModalPageFeed").value;
        RsGroupId = document.querySelector("#feedModalGroupFeed").value;
        RsFeedId = document.querySelector("#feedModalNewsFeed").value;

        if(!RsPageId && RsPageId == undefined && RsPageId == 'undefined'){
            RsPageId = null;
        }
        if(!RsGroupId && RsGroupId == undefined && RsGroupId == 'undefined'){
            RsGroupId = null;
        }

        var response = {
            RsGroupId: RsGroupId,
            RsPageId: RsPageId,
            RsFeedId: RsFeedId
        };

        loadeUpdatedData(response);
    });
});
function closeFeedModal(){
    modalFeedPopup = document.querySelector("#feed_likes_modal_popup");
    modalFeedPopupHeader = document.querySelector("#feedModalHeader").classList.add('d-none');
    modalFeedPopup.classList.remove('show');  modalFeedPopup.style.display = "none";
    var body = document.body;
    body.style.overflow = 'auto';
    body.style.pointerEvents = 'auto';

}

function deleteFeedAttachments(feedAttachmentId, typeAttachment){
    
    var element = document.querySelector('.editPostAttachmentsDelete' + feedAttachmentId);
    var elementInput = document.querySelector('.feedAttachmentIds');
    console.log(elementInput);

    if (element && elementInput) {
        element.classList.add('d-none');
        elementInput.value += feedAttachmentId+','; // Use the += operator to concatenate the value
        console.log(elementInput.value);
    }

}

// Preview Content Of input And Add New data in old Data

function previewImagesEditFeed() {
    var inputODI = document.getElementsByClassName("fileInputGetOldValuesEditFeed");
    var newFilesODI = inputODI[0].files;
    var allFilesODI = existingFilesEditFeed.concat(Array.from(newFilesODI));
    var dataTransferODI = new DataTransfer();
    allFilesODI.forEach(function (file) {
        dataTransferODI.items.add(file);
    });
    inputODI[0].files = dataTransferODI.files;
    existingFilesEditFeed = [];

    var preview = document.querySelector('#previewModalFeedEdit');
    var files = document.querySelector('input[type=file]')
        .files;
    var index = 0;
    for (var i = 0; i < files.length; i++) {
        let file = files[i];
        var index = i;


        let reader = new FileReader();
        (function (index) {
            reader.onload = function (event) {
                var element;
                if (file.type.match('video.*')) {
                    let preview = document.getElementById('previewModalFeedEdit');


                    var div = document.createElement('div')
                    var button = document.createElement('button')
                    div.style.position = "relative";
                    button.textContent = "X"
                    button.id = file.lastModified;
                    button.title = "delete image"
                    button.style.position = "absolute";
                    button.style.top = "15px";
                    button.style.right = "15px";
                    button.style.color = "#e8e4ed";
                    button.style.marginTop = "11px";
                    button.style.backgroundColor = "#121111";
                    button.style.fontWeight = "600";
                    button.style.borderRadius = "50%";
                    button.style.border = "solid #e8e4ed 2px";
                    button.style.zIndex = "999";
                    button.style.width = "28px";

                    let element = document.createElement('video');
                    element.classList.add('custom-video');
                    element.style.marginTop = "1rem";
                    element.style.width = '100%';
                    element.style.height = '100%';
                    element.style.objectFit = 'cover';
                    element.className = 'rounded-2';
                    element.src = URL.createObjectURL(file);

                    let elementButton = document.createElement('span');
                    elementButton.classList.add('play-pause-button');
                    elementButton.onclick = function (e) {
                        e.preventDefault();

                        let video = this.parentElement.querySelector('.custom-video');
                        let playPauseButton = this.parentElement.querySelector('.play-pause-button');
                        if (video.paused) {
                            video.play();
                            playPauseButton.style.backgroundImage = 'url("data:image/svg+xml,%3Csvg style=\'color: rgb(140, 104, 205)\' viewBox=\'0 0 1024 1024\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath fill=\'rgb(140, 104, 205)\' d=\'M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm0 832a384 384 0 0 0 0-768 384 384 0 0 0 0 768zm-96-544q32 0 32 32v256q0 32-32 32t-32-32V384q0-32 32-32zm192 0q32 0 32 32v256q0 32-32 32t-32-32V384q0-32 32-32z\'%3E%3C/path%3E%3C/svg%3E")';
                        } else {
                            video.pause();
                            playPauseButton.style.backgroundImage = "url('data:image/svg+xml,%3Csvg style=\'color: rgb(140, 104, 205)\' xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'currentColor\' class=\'bi bi-play\' viewBox=\'0 0 16 16\'%3E%3Cpath d=\'M10.804 8 5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z\' fill=\'rgb(140, 104, 205)\'%3E%3C/path%3E%3C/svg%3E')";
                        }
                    };

                    button.addEventListener('click', (evt) => {
                        var sourceInput = document.querySelector('input[type=file]');
                        var destinationInput = document.querySelector('input[type=file]');
                        var files = sourceInput.files;
                        files = Array.from(files);
                        files.splice(evt.target.lastModified, 1);
                        var dataTransfer = new DataTransfer();
                        for (let i = 0; i < files.length; i++) {
                            var file = files[i];
                            dataTransfer.items.add(file);
                        }
                        destinationInput.files = dataTransfer.files
                        preview.removeChild(div)
                    })
                    let videoContainer = document.createElement('div');
                    videoContainer.classList.add('video-container');
                    div.appendChild(button)
                    div.appendChild(element);
                    div.appendChild(elementButton);
                    div.appendChild(videoContainer)
                    preview.appendChild(div)

                } else {
                    var div = document.createElement('div')
                    var button = document.createElement('button')
                    div.style.position = "relative";
                    button.textContent = "X"
                    button.title = "delete image"
                    button.id = file.lastModified;
                    button.style.position = "absolute";
                    button.style.top = "15px";
                    button.style.right = "15px";
                    button.style.color = "#e8e4ed";
                    button.style.marginTop = "11px";
                    button.style.backgroundColor = "#121111";
                    button.style.fontWeight = "600";
                    button.style.borderRadius = "50%";
                    button.style.border = "solid #e8e4ed 2px";
                    button.style.width = "28px";

                    element = document.createElement('img');
                    element.src = event.target.result;
                    element.style.marginTop = "1rem";
                    element.style.width = '100%';
                    element.style.height = '100%';
                    element.style.objectFit = 'cover';
                    element.className = 'rounded-2';
                    button.addEventListener('click', (evt) => {
                        var sourceInput = document.querySelector('input[type=file]');
                        var destinationInput = document.querySelector('input[type=file]');
                        var files = sourceInput.files;
                        files = Array.from(files);
                        files.splice(evt.target.lastModified, 1);
                        var dataTransfer = new DataTransfer();
                        for (let i = 0; i < files.length; i++) {
                            var file = files[i];
                            dataTransfer.items.add(file);
                        }
                        destinationInput.files = dataTransfer.files
                        preview.removeChild(div)
                        previewImages();
                    })
                    div.appendChild(button)
                    div.appendChild(element)
                    preview.appendChild(div)
                }
            };
        })(index);
        reader.readAsDataURL(file);
    }
}

var existingFilesEditFeed = [];
function addMoreFilesEditFeed() {

    var input = document.getElementsByClassName("fileInputGetOldValuesEditFeed");
    var newFiles = input[0].files;
    var allFiles = existingFilesEditFeed.concat(Array.from(newFiles));
    var dataTransfer = new DataTransfer();

    allFiles.forEach(function (file) {
        dataTransfer.items.add(file);
    });

    input[0].files = dataTransfer.files;
    existingFilesEditFeed = allFiles;

}

// End

$(document).on('submit', 'form.update-on-ajax', function(e) {
    $('.cover_spin').show();
    e.preventDefault();

    if ($(this).data('isSubmitting')) {
        return;
    }

    $(this).data('isSubmitting', true);

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
        beforeSend: function() {
        },
        success: function(response) {

            var response = {
                RsGroupId: response.data.group_id,
                RsPageId: response.data.page_id,
                RsFeedId: response.data.id
            };
            if(!response.RsPageId){
                RsPageId = null;
            }
            if(!response.RsGroupId){
                RsGroupId = null;
            }
            loadeUpdatedData(response);
        },
        error: function(xhr, status, error) {
        },
        complete: function() {
            $(this).data('isSubmitting', false);
        }
    });

});

function loadeUpdatedData(response){
    if ($(this).data('isSubmitting') == false) {
        return;
    }
    $(this).data('isSubmitting', true);
    $.ajax({
        url: window.location.href,
        type: "GET",
        data: { UpdatedData: true },
        dataType: "html",
        beforeSend: function() {
            closeFeedModal();
        },
        success: function (loadeFeed) {
            var className = (response.RsPageId) ? '-page-' : (response.RsGroupId) ? '-group-' : '';
            var extractedData = $(loadeFeed).find(".feed-id" + className + response.RsFeedId).html();
            $(".feed-id" + className + response.RsFeedId).empty();
            $(".feed-id" + className + response.RsFeedId).append(extractedData);
        },
        error: function (jqXHR, textStatus, errorThrown) {

        },
        complete: function() {
            $(this).data('isSubmitting', false);
        }
    });
}

