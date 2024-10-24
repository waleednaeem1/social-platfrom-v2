//Create Album
$('#createAlbumFormSubmit').on('submit', function(e){
    e.preventDefault();
    // Disable submit button
    $('#createAlbumButtonClick').attr('disabled','disabled');
    $.ajax({
    url:'/createAlbum',
    method:$(this).attr('method'),
    data:new FormData(this),
    processData:false,
    dataType:'json',
    contentType:false
    }).done(function(response){
    $('#create-albums').removeClass('show');
    $('#create-albums').hide();
    $('#create-albums').attr("aria-modal","true");
    $('#create-albums').attr("role","dialog");
    $('#create-albums').removeAttr("aria-hidden");
    $('.modal-backdrop').removeClass("show");
    $('.modal-backdrop').hide();
    $('.theme-color-default').removeAttr("style");
    $('.theme-color-default').removeClass("show");
    $('#createAlbumFormSubmit')[0].reset();
    updateAlbumDiv(response.user_id);
    // Enable submit button
    $('#createAlbumButtonClick').removeAttr('disabled');
    });
});
// Add Photo in Album
$('#addPhotoAlbumFormSubmit').on('submit', function(e){
    e.preventDefault();
   // Disable submit button
   $('#addPhotoAlbumFormSubmit').attr('disabled','disabled');
    $.ajax({
       url:'/addPhotoAlbum',
       method:$(this).attr('method'),
       data:new FormData(this),
       processData:false,
       dataType:'json',
       contentType:false
    }).done(function(response){
       console.log(response);
       //  updateAddAlbumPhotoDiv(response.id);
    result='';
    response.images.forEach(function(image) {
    if(image.image_path != null && image.image_path !== ''){
        src = '/storage/images/album-img'+'/'+response.user_id+'/'+response.albumdata.album_name+'/'+image.image_path;
    }else{
        src = '/images/user/Users_40x40.png';
    }
    result += '<div class="col-lg-3 col-md-4 col-sm-6 user-images"><img style="margin-top:16px; object-fit: cover;" src="'+src+'" class="rounded" width="210px" height="210px" alt="Album main image"><a href="javascript:void(0);" onclick="deleteAlbumInnerPicture('+image.id+","+image.user_album_id+')" class="addimage-edit-btn material-symbols-outlined md-16" data-bs-toggle="tooltip" data-bs-placement="top" title="">delete</a></div>';
    });
    document.querySelector('.show_images').innerHTML = result;
    $('#add_photo_album').removeClass('show');
    $('#add_photo_album').hide();
    $('#add_photo_album').attr("aria-modal","true");
    $('#add_photo_album').attr("role","dialog");
    $('#add_photo_album').removeAttr("aria-hidden");
    $('.modal-backdrop').removeClass("show");
    $('.modal-backdrop').hide();
    $('.theme-color-default').removeAttr("style");
    $('.theme-color-default').removeClass("show");
    $('#addPhotoAlbumFormSubmit')[0].reset();

    // Enable submit button
    $('#addPhotoAlbumFormSubmit').removeAttr('disabled');
    });
});
// Update Album Div
function updateAlbumDiv(id){
    $("#ajaxuseralbumshow"+id).hide().load(" #ajaxuseralbumshow"+id+"> *").fadeIn(200);
}
// Update Add Album Photo Div
function updateAddAlbumPhotoDiv(id){
    $("#userAlbumImages"+id).hide().load(" #userAlbumImages"+id+"> *").fadeIn(200);
}
// Go Back to Album
function backToAlbum(id){
    $(".userAlbum").show();
    $("#createAlbum").show();
    $(".show_images").addClass('d-none');
    $(".show_pop_up_div").addClass('d-none');
    updateAlbumDiv(id);
}
// SHow Album Images
function showAlbumImages(albumId, userId){
    $.ajax({
        method: 'GET',
        url: '/showAlbumImages',
        data: {userId: userId, albumId :albumId},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {
        $(".userAlbum").hide();
        $("#createAlbum").hide();
        $(".show_images").removeClass('d-none');
        $(".show_pop_up_div").removeClass('d-none');
        result='';
        response.images.forEach(function(image) {
        if(image.image_path != null && image.image_path !== ''){
            src = '/storage/images/album-img'+'/'+response.user_id+'/'+ response.albumdata.album_name +'/'+image.image_path;
        }else{
            src = '/images/user/Users_40x40.png';
        }
        result += '<div class="col-lg-3 col-md-4 col-sm-6 user-images"><img style="margin-top:16px; object-fit: cover;" src="'+src+'" class="rounded" width="210px" height="210px" alt="Album main image"><a href="javascript:void(0);" onclick="deleteAlbumInnerPicture('+image.id+","+image.user_album_id+')" class="addimage-edit-btn material-symbols-outlined md-16" data-bs-toggle="tooltip" data-bs-placement="top" title="">delete</a></div>';
        });
        document.querySelector('.show_images').innerHTML = result;
        $("#addPhotoAlbumId").val(response.albumId);
    });
}
// --------------------------------------------------------------------------------------------------------------------------
function savePostLike(feedId, userId, type){
    $.ajax({
       method: 'POST',
       url: '/post-like',
       data: {feedId :feedId,userId: userId, type :type},
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    }).done(function (response) {
        var className = (response.feed.page_id) ? '-page-' : (response.feed.group_id) ? '-group-' : '';
        $(".span-like" + className + feedId).each(function() {
            var feedLikeBtn = $(this);

            if (feedLikeBtn.hasClass('material-symbols-outlined-filled') && feedLikeBtn.hasClass('text-primary')) {
              feedLikeBtn.removeClass('material-symbols-outlined-filled text-primary');
            } else {
              feedLikeBtn.addClass('material-symbols-outlined-filled text-primary');
            }
        });
        $(".span-likeCount" + className + feedId).each(function() {
            var feedLikeCount = $(this);
            if (response.feed.likes_count == 1) {
                feedLikeCount.html(response.feed.likes_count + ' like');
            } else if (response.feed.likes_count > 1) {
                feedLikeCount.html(response.feed.likes_count + ' likes');
            } else {
                feedLikeCount.html('');
            }

        });
    });
}

function saveGroupLike(feedId, userId, type, groupId){
    $.ajax({
       method: 'POST',
       url: '/group-post-like',
       data: {
          feedId : feedId,
          userId : userId,
          type : type,
          groupId: groupId
      },
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    }).done(function (response) {
        var className = (response.feed.page_id) ? '-page-' : (response.feed.group_id) ? '-group-' : '';
        $(".span-like" + className + feedId).each(function() {
            var feedLikeBtn = $(this);

            if (feedLikeBtn.hasClass('material-symbols-outlined-filled') && feedLikeBtn.hasClass('text-primary')) {
              feedLikeBtn.removeClass('material-symbols-outlined-filled text-primary');
            } else {
              feedLikeBtn.addClass('material-symbols-outlined-filled text-primary');
            }
        });
        $(".span-likeCount" + className + feedId).each(function() {
            var feedLikeCount = $(this);
            if (response.feed.likes_count == 1) {
                feedLikeCount.html(response.feed.likes_count + ' like');
            } else if (response.feed.likes_count > 1) {
                feedLikeCount.html(response.feed.likes_count + ' likes');
            } else {
                feedLikeCount.html('');
            }

        });
    });
}
function savePagePostLike(feedId, userId, type, pageId)
{
    $.ajax({
        method: 'POST',
        url: '/page-post-like',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            feedId : feedId,
            userId : userId,
            type : type,
            pageId: pageId
        },
    }).done(function (response) {
        var className = (response.feed.page_id) ? '-page-' : (response.feed.group_id) ? '-group-' : '';
        $(".span-like" + className + feedId).each(function() {
            var feedLikeBtn = $(this);

            if (feedLikeBtn.hasClass('material-symbols-outlined-filled') && feedLikeBtn.hasClass('text-primary')) {
              feedLikeBtn.removeClass('material-symbols-outlined-filled text-primary');
            } else {
              feedLikeBtn.addClass('material-symbols-outlined-filled text-primary');
            }
        });
        $(".span-likeCount" + className + feedId).each(function() {
            var feedLikeCount = $(this);
            if (response.feed.likes_count == 1) {
                feedLikeCount.html(response.feed.likes_count + ' like');
            } else if (response.feed.likes_count > 1) {
                feedLikeCount.html(response.feed.likes_count + ' likes');
            } else {
                feedLikeCount.html('');
            }

        });
    });
}


function commentAppend(response, type, modalOpen = false){
    var feedModal = (modalOpen) ? '-modalOpen-' :  '';
    if(type == 'FeedCommentReply'){
        var replyBox = document.getElementById("comment-reply-box-" + feedModal + response.FeedComment[0].id);
        replyBox.classList.toggle("d-none");
        var className = (response.feed.page_id) ? '-page-' : (response.feed.group_id) ? '-group-' : '';
        var commentApnd =  processReplies(response.FeedCommentReply, response.feed, response.userAuthId, response.feed.get_user, response.FeedComment, modalOpen);
        $('.comment-list-'+className+response.feed.id+response.FeedComment[0].id).each(function() {
            $(this).append(commentApnd);
        });
    }
    if(type == 'FeedComment'){
        var className = (response.feed.page_id) ? '-page-' : (response.feed.group_id) ? '-group-' : '';
        var commentApnd =  processReplies(response.feedComment, response.feed, response.userAuthId, response.feed.get_user, replyGetReplies = null, modalOpen);
        $('.comment-section'+className+response.feed.id).each(function() {
            $(this).append(commentApnd);
        });
    }

    $(".span-commentCount" + className + response.feed.id).each(function() {
        var feedCommentCount = $(this);
        if (response.feed.comments_count == 1) {
            feedCommentCount.html(response.feed.comments_count + ' comment');
        } else if (response.feed.comments_count > 1) {
            feedCommentCount.html(response.feed.comments_count + ' comments');
        } else {
            feedCommentCount.html('');
        }

    });
}

function saveComment(keyword, feed_id, modalOpen = null) {
    var feedModal = (modalOpen) ? '-modalOpen-' : '';
    let userId = document.getElementById('userId' + feedModal + feed_id).value;
    let feedId = document.getElementById('feedId' + feedModal + feed_id).value;
    let comment = document.getElementById('comment-input' + feedModal+ feed_id).value;
    var commentDisable = document.getElementById('comment-input' + feedModal+  feed_id);
    if (event.keyCode === 13 && comment !== '' ) {
       commentDisable.disabled = true;
        $.ajax({
            method: 'POST',
            url: '/comments-store',
            data: {
                userId: userId,
                feedId: feedId,
                comment: comment
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            commentDisable.disabled = false;
            document.getElementById('comment-input'+ feedModal + feed_id).value="";
            commentAppend(response, type = 'FeedComment', modalOpen);
        });
    }
}

function savePageComment(keyword,feed_id,pageId, modalOpen = null) {
    var feedModal = (modalOpen) ? '-modalOpen-' : '';
    let userId = document.getElementById('userId' + feedModal + feed_id).value;
    let feedId = document.getElementById('feedId'+ feedModal + feed_id).value;
    let comment = document.getElementById('comment-input-page-'+ feedModal + feed_id).value;
    var commentDisable = document.getElementById('comment-input-page-'+ feedModal + feed_id);

    if(event.keyCode === 13 && comment !== ''){
        commentDisable.disabled = true;
        $.ajax({
            method: 'POST',
            url: '/page-comments-store',
            data: {userId: userId, feedId :feedId, comment :comment, pageId:pageId},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (response) {
            commentDisable.disabled = false;
            document.getElementById('comment-input-page-'+ feedModal + feed_id).value="";
            commentAppend(response, type = 'FeedComment', modalOpen);
        });
    }
 }

function saveGroupComment(keyword,feed_id,groupId, modalOpen = null) {
    var feedModal = (modalOpen) ? '-modalOpen-' : '';
    let userId = document.getElementById('userId' + feedModal + feed_id).value;
    let feedId = document.getElementById('feedId' + feedModal + feed_id).value;
    let comment = document.getElementById('comment-input-group-' + feedModal + feed_id).value;
    var commentDisable = document.getElementById('comment-input-group-' + feedModal + feed_id);
    if(event.keyCode === 13 && comment !== ''){
        commentDisable.disabled = true;
        $.ajax({
            method: 'POST',
            url: '/group-comments-store',
            data: {userId: userId, feedId :feedId, comment :comment, groupId:groupId},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (response) {
            commentDisable.disabled = false;
            document.getElementById('comment-input-group-' + feedModal + feed_id).value="";
            commentAppend(response, type = 'FeedComment', modalOpen);
        });
    }
}

function toggleReplyBox(commentId, type,  modalOpen = null) {
    var feedModal = (modalOpen) ? '-modalOpen-' : '';
    // var className = (type == 'page') ? '-page-' : '-group-';
    var replyBox = document.getElementById("comment-reply-box-" +feedModal+commentId);
    const commentReplyBox = document.getElementById("comment-reply-box-"+feedModal+commentId).children[1].id;
    setTimeout(() => document.getElementById(commentReplyBox).focus(), 0);
    replyBox.classList.toggle("d-none");
}

function saveCommentReply(keyCode, feedId, parentCommentId=null, modalOpen = null) {
    var feedModal = (modalOpen) ? '-modalOpen-' : '';
    var comment = document.getElementById('comment-input-reply'+feedModal+parentCommentId).value;
    var commentDisable = document.getElementById('comment-input-reply'+feedModal+parentCommentId);
    if(keyCode === 13 && comment !== ''){
        commentDisable.disabled = true;
        $.ajax({
        method: 'POST',
        url: '/saveCommentsReply',
        data: {feedId :feedId, comment :comment, parentCommentId:parentCommentId},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        }).done(function (response) {
            commentDisable.disabled = false;
            document.getElementById('comment-input-reply'+feedModal+parentCommentId).value="";
            commentAppend(response, type = 'FeedCommentReply', modalOpen);
        });
    }
}

function saveGroupsPagesCommentsReply(keyCode, feedId, parentCommentId, groupId, type, modalOpen = null) {
    var feedModal = (modalOpen) ? '-modalOpen-' : '';
    var className = (type == 'page') ? '-page-' : '-group-';
    var comment = document.getElementById('comment-input-reply'+feedModal+className+parentCommentId).value;
    var commentDisable = document.getElementById('comment-input-reply'+feedModal+className+parentCommentId);
    if(keyCode === 13 && comment !== ''){
        commentDisable.disabled = true;
        $.ajax({
           method: 'POST',
           url: '/saveGroupsPagesCommentsReply',
           data: {feedId :feedId, comment :comment, parentCommentId:parentCommentId, groupId, type : className},
           headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        }).done(function (response) {
          commentDisable.disabled = false;
          document.getElementById('comment-input-reply'+feedModal+className+parentCommentId).value="";
          commentAppend(response, type = 'FeedCommentReply', modalOpen);
        });
    }
}

function saveCommentLike(feedId,commentId,userId) {
    $.ajax({
       method: 'POST',
       url: '/saveCommentLike',
       data: {userId: userId, feedId :feedId, commentId :commentId},
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    }).done(function (response) {
        saveCommentlikeUpdate(response, feedId, commentId);
    });
 }

function saveCommentLikePage(feedId,commentId,userId,pageId)
{
    $.ajax({
        method: 'post',
        url: '/likePagePostComment/' + feedId + '/' + userId + '/like/' + commentId + '/' + pageId,
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function (response) {
        saveCommentlikeUpdate(response, feedId, commentId);
    });
}

function saveGroupCommentLike(feedId,commentId,userId,groupId)
   {
    $.ajax({
       method: 'POST',
       url: '/saveGroupCommentLike',
       data: {userId: userId, feedId :feedId, commentId :commentId, groupId:groupId},
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    }).done(function (response) {
        saveCommentlikeUpdate(response, feedId, commentId);
    });
   }
function saveCommentlikeUpdate(response, feedId, commentId){
    var className = (response.feed.page_id) ? '-page-' : (response.feed.group_id) ? '-group-' : '';
    $(".span-like" + className + feedId + commentId).each(function() {
        var feedLikeBtn = $(this);
        if (feedLikeBtn.hasClass('text-primary')) {
            feedLikeBtn.removeClass('text-primary');
            feedLikeBtn.addClass('text-dark');
        } else {
            feedLikeBtn.removeClass('text-dark');
            feedLikeBtn.addClass('text-primary');
        }
        if (response.comment.likes_count == 1) {
            feedLikeBtn.html(response.comment.likes_count + ' like');
        } else if (response.comment.likes_count > 1) {
            feedLikeBtn.html(response.comment.likes_count + ' likes');
        } else {
            feedLikeBtn.html('like');
        }
    });
}


function copySignature() {
    // Create a temporary div element
    var tempElement = document.createElement("div");

    // Set the innerHTML of the div to the HTML content of the signature
    tempElement.innerHTML = document.getElementById("signatureContent").innerHTML;

    // Append the div to the body (it must be appended to be selected)
    document.body.appendChild(tempElement);

    // Create a range and select the div content
    var range = document.createRange();
    range.selectNodeContents(tempElement);
    var selection = window.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);

    // Copy the selected content to the clipboard
    document.execCommand("copy");

    // Remove the temporary div
    document.body.removeChild(tempElement);

    // Alert the user that the signature has been copied
    alert("Signature copied to clipboard!");
}



// --------------------------------------------------------------------------------------------------------------------------

function deleteFeedComment(feedId, commentId, userId) {
    $.ajax({
        method: 'POST',
        url: '/deleteFeedComment',
        data: {
            userId: userId,
            feedId: feedId,
            commentId: commentId
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {
        deleteFeedCommentHide(response);
    }).fail(function(xhr, textStatus, errorThrown) {
        console.error('Error deleting comment ' + commentId + ':', errorThrown);
    });
}

function deleteGroupPagesFeedComment(feedId, commentId, userId, groupId, type) {
    var className = (type == 'page') ? '-page-' : '-group-';
    $.ajax({
        method: 'POST',
        url: '/deleteGroupPagesFeedComment',
        data: {
            userId: userId,
            feedId: feedId,
            commentId: commentId,
            sectionId: groupId,
            type: type,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {
        deleteFeedCommentHide(response);
    }).fail(function(xhr, textStatus, errorThrown) {
        console.error('Error deleting comment ' + commentId + ':', errorThrown);
    });
}

function deleteFeedCommentHide(response){
    var className = (response.feed.page_id) ? '-page-' : (response.feed.group_id) ? '-group-' : '';
    console.log(className, response);
    $('.comment-list-' + className + response.feed.id + response.comment.id).each(function() {
        $(this).remove();
    });

    if(response.feed.comments_count < 2){
        $('view-more-comments-'+response.feed.id).hide();
    }

    $(".span-commentCount" + className + response.feed.id).each(function() {
        var feedCommentCount = $(this);
        if (response.feed.comments_count == 1) {
            feedCommentCount.html(response.feed.comments_count + ' comment');
        } else if (response.feed.comments_count > 1) {
            feedCommentCount.html(response.feed.comments_count + ' comments');
        } else {
            feedCommentCount.html('');
        }

    });
}
// --------------------------------------------------------------------------------------------------------------------------

// Create Page Form

$('#createPageFormSubmit').on('submit', function(e){

    e.preventDefault();
    // Disable submit button
    $('#createPageButtonClick').attr('disabled','disabled');
    $.ajax({
    url:'/createPage',
    method:'POST',
    data:new FormData(this),
    processData:false,
    dataType:'json',
    contentType:false
    }).done(function(response){
    // Enable submit button
    $('#createPageButtonClick').removeAttr('disabled');

    // Redirect to groupdetail with dynamic pageId value
    document.getElementById("createPageFormSubmit").reset();
    window.location.href = '/pagedetail/' + response.pageId;
    });
});

// Create Signature Form

$('#createSignatureFormSubmit').on('submit', function(e){

    e.preventDefault();
    // Disable submit button
    $('#createPageButtonClick').attr('disabled','disabled');
    $.ajax({
    url:'/createSignature',
    method:'POST',
    data:new FormData(this),
    processData:false,
    dataType:'json',
    contentType:false
    }).done(function(response){
    // Enable submit button
    // alert("signture created");
    // console.log("hi ther waleed");
    return false;
    // $('#createPageButtonClick').removeAttr('disabled');

    // Redirect to groupdetail with dynamic pageId value
    // document.getElementById("createPageFormSubmit").reset();
    // window.location.href = '/pagedetail/' + response.pageId;
    });
});

$('form.update-form').submit(function(event) {
    event.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
      type: 'POST',
      url: $(this).attr('action'),
      data: formData,
      processData:false,
      dataType:'json',
      beforeSend:function(){
        $(document).find('span.error-text').text('');
        },
      success: function(response) {
        if(response.type == 'personalInformation'){
            if(response.error == true && response.errortype == 'username'){
                $('#username-error').show();
                document.querySelector('#username-error').innerHTML = '<div class="text-danger">' + response.message + '</div>';
                $('#personalInformationSuccess').hide();
                $('#dob-error').hide();
            }
            if(response.error == true && response.errortype == 'dob'){
                $('#dob-error').show();
                document.querySelector('#dob-error').innerHTML = '<div class="text-danger">' + response.message + '</div>';
                $('#personalInformationSuccess').hide();
                $('#username-error').hide();
            }
            if (response.success == true) {
                $('#personalInformationSuccess').show();
                document.querySelector('#personalInformationSuccess').innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                $('#username-error').hide();
                $('#dob-error').hide();
                setTimeout(function() {
                    $('#personalInformationSuccess').hide();
                }, 3000);
            }
        }
        if(response.type == 'accountSetting'){
            if(response.error == true){
                $('#alt_email').show();
                document.querySelector('#alt_email').innerHTML = '<div class="text-danger">' + response.message + '</div>';
                $('#accountSettingsuccess').hide();
                $('#socialLinkSuccess').hide();
                const inputField = document.querySelector('#altemail');
                inputField.addEventListener('click', function() {
                    $('#alt_email').hide();
                });
            }
            if (response.success == true) {
                $('#accountSettingsuccess').show();
                document.querySelector('#accountSettingsuccess').innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                setTimeout(function() {
                    $('#accountSettingsuccess').hide();
                }, 3000);
                $('#alt_email').hide();
                $('#socialLinkSuccess').hide();
            }
        }
        if(response.type == 'socialLink'){
            if (response.success == true) {
                $('#socialLinkSuccess').show();
                document.querySelector('#socialLinkSuccess').innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                setTimeout(function() {
                    $('#socialLinkSuccess').hide();
                }, 3000);
                $('#accountSettingsuccess').hide();
                $('#alt_email').hide();
            }
        }
        if(response.type == 'manageContact'){
            if (response.success == true) {
                document.querySelector('#manageContactSuccess').innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                setTimeout(function() {
                    $('#manageContactSuccess').hide();
                }, 3000);
            }
        }
        if(response.type == 'privacySetting'){
            if (response.success == true) {
                document.querySelector('#privacySettingSuccess').innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                setTimeout(function() {
                    $('#privacySettingSuccess').hide();
                }, 3000);
            }
        }
        if(response.type == 'changePassword'){
            if (response.success == true) {
                if(response.status == 0){
                    $.each(response.error, function(prefix, val){
                      $('span.'+prefix+'_error').text(val[0]);
                    });
                  }else{
                    $('#changePasswordAdminForm')[0].reset();
                    //alert(data.msg);
                    // location.reload();
                    document.querySelector('#changePasswordSuccess').innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    setTimeout(function() {
                        $('#changePasswordSuccess').hide();
                    }, 3000);
                }
            }
        }
      },
      error: function(xhr, status, error) {
        console.log('Error', response);

      }
    });
  });


// --------------------------------------------------------------


// newsfeed, timeline, page and group Comment focus

function commentInputFocus(feedId, className = null){
    const selectComment = document.getElementById("comment-input"+className+feedId);
    const selectCommentModal = document.getElementById("comment-input-modalOpen-"+className+feedId);
    selectComment.focus();
    selectCommentModal.focus();
}

// -------------------------------------------------------------------

// Newsfeed and time delete post
function deletePost(feedId) {
    $.ajax({
        url: '/deletePost/' + feedId,
        method: 'GET',
        data: {
            feedId : feedId
         },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {
        $(".updateFeed").hide().load(" .updateFeed"+"> *").fadeIn(0);
        document.querySelector(".modal-backdrop").style.display = "none";
    });
}

// ------------------------------------------------------------

// Group and Page delete post
function deleteGroupPagePost(feedId, Id, userId, type) {
    $.ajax({
        url: '/deleteGroupPagePost/' + feedId + '/' + Id + '/' + userId,
        method: 'GET',
        data: {
            feedId : feedId,
            Id : Id,
            type : type,
            userId : userId
         },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {

        var pendingFeedApproveUser = $('.pending-feed-approve-user-'+feedId);
        if(pendingFeedApproveUser.length)
            pendingFeedApproveUser.addClass('d-none');

        var pendingFeedApprove = $('.pending-feed-approve-'+feedId);
        if(pendingFeedApprove.length)
            pendingFeedApprove.addClass('d-none')

        if(response.data.feedEnd == true)
            $('.approve-feed-end').removeClass('d-none')

        var notificationURL = "notificationDetails";
        var feedDetailURL = "feed-detail";
        if (window.location.href.indexOf(notificationURL) !== -1 ||  window.location.href.indexOf(feedDetailURL) !== -1) {
            window.history.back();
        }

        var updateNewsFeed = $(".updateNewsFeed");
        if(updateNewsFeed.length)
            updateNewsFeed.hide().load(" .updateNewsFeed"+"> *").fadeIn(0);
        

        var feedApprovals = $(".feedApprovals");
        if(feedApprovals.length){
            feedApprovals.hide().load(" .feedApprovals"+"> *").fadeIn(0);
            $('.feedApprovals-nav').addClass('active');
        }
        
    });
}

$(document).on("click", ".emojisStyle", function() {
    var inputField = $(this).closest(".new-comment-emoji").find(".feed-comment");
    inputField.focus();
    inputField.val(inputField.val() + $(this).html());
    console.log(inputField);
 });


 //------------------------------------------------------------------------------------------

 //news feed function


function enrollCourse(slug)
{
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': csrfToken
       }
    });
    // Send AJAX request
    $.ajax({
       url: '/course/' + slug + '/enrollment',
       type: 'POST',
       data: { slug: slug },
       success: function(response) {
            console.log(response);
            // Display modal and set image src
            $('#enrollCourse').modal('show');
            $('#enrolled-course-thumbnail').attr('src', 'https://web.dvmcentral.com/up_data/courses/thumbnails/' + response.course.thumbnail);
            $('#enrollCourseTitle').text(response.course.title);
            $('#enrollCoursePrice').text('$'+response.course.price_original);
            $('#enrollCourseDescription').text(response.course.short_description);
            //   $('#enrollCourseModule').text(response.course.total_modules);

            $("#alreadyEnrolled").hide(0);
            $("#alreadyinCart").hide(0);
            $("#addToCartBtnDiv").hide(0);

            $("#addToCartBtn").removeClass();
            $("#addToCartBtn").addClass('btn btn-primary addToCartBtn_'+response.course.id);
            $('.addToCartBtn_'+response.course.id).text('Add to Cart');

            if(response.enrolled == true){
                $("#alreadyEnrolled").show(0);
                $("#alreadyinCart").hide(0);
                $("#addToCartBtnDiv").hide(0);
            }
            else if(response.addToCart == false){
                $("#addToCartBtnDiv").show(0);
                $("#alreadyEnrolled").hide(0);
                $("#alreadyinCart").hide(0);
                var courseId = response.course.id;
                var addToCartBtn = $('#addToCartBtn');
                addToCartBtn.attr('onclick', 'addToCart(' + courseId + ')');
            }else{
                $("#alreadyinCart").show(0);
                $("#alreadyEnrolled").hide(0);
                $("#addToCartBtnDiv").hide(0);
            }
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
    });
}
function enrollCoach(slug)
{
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': csrfToken
       }
    });
    // Send AJAX request
    $.ajax({
        url: '/coach/' + slug + '/enrollment',
       type: 'GET',
       data: { slug: slug },
        success: function(response) {
            console.log(response);
            var selectElement = $('#coach-select');
            selectElement.empty();
            var button = document.querySelector('.applyCoach');
            if(response.allCoach.length > 0){
                $.each(response.allCoach, function(index, coach) {
                    var option = $('<option></option>').attr('value', coach.user.id).text(coach.user.name);
                    selectElement.append(option);
                });
                button.removeAttribute('disabled');
                $('#courseSlug').val(response.courseSlug);
            }
            else{
                button.setAttribute('disabled', 'disabled');
                showError("Assign any of your team member as Coach first");
            }
            $('#enrollCoach').modal('show');
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
    });
}

$(document).on('click', '.applyCoach', function() {
    var coachId = $('#coach-select').val();
    var courseSlug = $('#courseSlug').val();
    // Access the form data
    var formData = {
        coachId: coachId,
        courseSlug: courseSlug,
        // Add more properties as needed
    };
    // console.log(formData);
    // return false;

    // Perform AJAX request
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    $.ajax({
        url: '/course/apply-coach-request',
        type: 'POST',
        data: formData,
        success: function(response) {
            if(response.success == true){console.log('true',response.message)
                document.getElementById('error-message').innerHTML = response.message;
                document.getElementById('error-message').style.display = 'block';
                document.getElementById('error-message').style.backgroundColor = 'whitesmoke';
                document.getElementById('error-message').style.color = '#3f6d5f';
                // $('#enrollCoach').modal('hide');
                $(".updateFeed").hide().load(" .updateFeed"+"> *").fadeIn(0);
            }
            else{
                showError(response.message);
            }
            console.log(response);
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
});



function addToCart(courseId)
{
    //var addToCartButton = document.getElementById("addToCartBtn");
      var addToCartButton = $('.addToCartBtn_'+courseId);
        // $("#addToCartBtn").addClass('btn btn-primary addToCartBtn_'+response.course.id);

      // Disable the button
      addToCartButton.disabled = true;
      // Change the button text
      addToCartButton.innerHTML = "Adding...";

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
    $.ajax({
        url: '/courses/addToCart',
        type: 'POST',
        data: { courseId: courseId },
        success: function(response) {
            console.log(response);
            if (response.success) {
                // Update the button text and appearance
                addToCartButton.text("Added!");
                /* addToCartButton.classList.remove("btn-primary");
                addToCartButton.classList.add("btn-success"); */
                addToCartButton.removeClass("btn-primary");
                addToCartButton.addClass("btn-success");
             }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

function removeFromCart(cart_item)
{
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': csrfToken
       }
    });


     $.ajax({
        url: '/courses/delete',
        type: 'POST',
        data: { cart_item: cart_item },
        success: function(response) {

            $('#cartItemId-' + cart_item).hide();
            $(".updateCartList").hide().load(" .updateCartList"+"> *").fadeIn(0);

        $('#cartItemId-' + cart_item).removeClass('course_card');
          if($('.course_card').length==0){
          $('.coupon_model').text('Cart is empty');
           }

        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

$('#payment-form').on('submit', function(e){
    e.preventDefault();
    var form = $(this);
    var submitButton = form.find('button[type="submit"]');
    // Disable submit button
    submitButton.attr('disabled', 'disabled');
    var formData = new FormData(form[0]);
    $.ajax({
       url:'/purchaseCourse',
       method:$(this).attr('method'),
       data:new FormData(this),
       processData:false,
       dataType:'json',
       contentType:false
    }).done(function(response){
       console.log(response);
       if (response.success) {
            form[0].reset();
            jQuery('#payment').removeClass('show');
            jQuery('#cart').removeClass('show');
            jQuery('#courseCartHeading').removeClass('show');
            jQuery('#success').addClass('show');
        } else {
            showError(response.message);
        }
    });
});

function showError(message) {
    // Show the error message and scroll to the top of the page
    var errorMessageContainer = $('#error-message');
    errorMessageContainer.text(message);
    errorMessageContainer.show();
    $('html, body').animate({ scrollTop: 0 }, 'fast');
}

function applyCoupon() {
    var couponCode = $('#couponInput').val();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
    $.ajax({
        url: '/applyCoupon',
        method: 'POST',
        data: {
            coupon: couponCode
        },
        success: function(response) {
            console.log(response);
            if(response.success == true){
                var couponDiscountPercentage = response.couponData.discount;
                var totalCartPrice = parseFloat($("#totalCartPrice").data("total-price"));

                // Calculate the coupon discount amount
                var couponDiscount = (totalCartPrice * couponDiscountPercentage) / 100;
                // Calculate the updated cart price
                var updatedCartPrice = totalCartPrice - couponDiscount;
                // Update the coupon discount and remaining cart price in the HTML
                $('#totalCouponDiscount').text("$" + couponDiscount.toFixed(2));
                $('#totalCartPrice').html("<strong>$" + updatedCartPrice.toFixed(2) + "</strong>");
                $('#finalCartPrice').html("<strong>$" + updatedCartPrice.toFixed(2) + "</strong>");

                // Update the hidden fields
                $('#couponDiscountPercent').val(couponDiscountPercentage);
                $('#totalCartPriceToPay').val(updatedCartPrice);

                $('#couponModal').modal('hide');
            }
            else{
                $('#couponError').text(response.message).show().css('color', 'red');
                setTimeout(function() {
                    $('#couponError').text('');
                }, 3000);
            }
        },
        error: function(xhr, status, error) {
        // Handle the error response
        console.error(xhr.responseText);
        }
    });
}


    // Amir@01-06-2023 add colleages by ajax

        $('#addColleageForm').submit(function(e) {
           e.preventDefault();
           var form = $(this);
           // Remove element
           $("input[name*='first_name']").next().remove();
           $("input[name*='last_name']").next().remove();
           $("input[name*='email']").next().remove();
           $("input[name*='username']").next().remove();
           //
           var formData = $(this).serialize();

           $.ajax({
                 url:'/team/add-colleague',
                 type: 'POST',
                 data: formData,
                 success: function(response) {
                    form[0].reset();
                    alertConfirmModule(response.msg,icon = 'success');
                    toogle_add_colleague();
                    appendTrTable(response.data);
                 },
                 error: function(err) {console.log('err',form)
                    $.each(err.responseJSON.errors, function (key, value) {
                      handleErrors(key, value);
                   });
                 console.log(err.responseText);
                }
           });
        });
     //
     function appendTrTable(team)
     {
        $( "#nav-tabContent" ).load(window.location.href + " #nav-tabContent" );
        var tableTr = `<tr class="table_tr">
        <td><b>${team.user?.name}</b>
            <br>${team.user.learning_role.name}
        </td>
        <td>`;

        if (team.is_coach === '1') {
            tableTr += `<a href="/team/change-coach/${team.id}">Remove Coach Access</a>`;
        } else {
            tableTr += `<a href="/team/change-coach/${team.id}">Assign Coach Access</a>`;
        }

        tableTr += `
            </td>
            <td>
                <a href="/courses-categories" class="btn btn-primary d-block" style="width: auto;height: 42px; padding-top: 0.5rem;">Browse Courses</a>
            </td>
            <td>
                <a href="/events" class="btn btn-primary d-block" style="width: auto;height: 42px; padding-top: 0.5rem;">Browse Events</a>
            </td>
            <td>
                <a href="/team/profile/detail/${team.id}">Profile</a>
            </td>
        </tr>`;

       $('#datatable tr:last').after(tableTr);

     }
     // for display the error message
     function handleErrors(key, value){
        $("input[name*='" + key+"']").next().remove();
        $("input[name*='" + key+"']").after('<span class="error text-danger">'+value[0]+'</span>');
     }
     // alert Module
     function alertConfirmModule(msg,icon)
     {
        Swal.fire({
              text: msg,
              icon: icon,
           });
     }
     // Amir@end code of colleges
     // for open confirm modal
     function confirmAlertTeam(elm) {
        $("#team_id").val(elm.value);
        $("#reassignuser").modal('show');
     }
     function confirmAssignToTeam() {
        var team_id = $("#team_id").val();

        $.ajax({
                 url:"/team/user/restore/"+team_id,
                 type: 'GET',
                 success: function(response) {
                    alertConfirmModule(response.msg,icon = 'success');
                    $("#removeTeam-"+team_id).remove();
                    $("#reassignuser").modal('hide');
                    appendTrTable(response.data)
                 },
                 error: function(response) {
                    alertConfirmModule("something went wrong",icon = 'error');
                    console.log(response.responseText);
                 }
           });
     }
     function confrmAssignUserToTeam(elm,id) {

            $("#status").val(elm.value);
            $("#team_id").val(id);
        if(elm.value == 'unassign')
        {
            $(".modal-title").text("Unassign User");
            $(".modal-body").text("Are you sure you want to unassign this user from team?");
            $("#delete_user").modal("show");

        }else if(elm.value == 'assign')
        {
            $(".modal-title").text("Reassign User");
            $(".modal-body").text("Are you sure you want to reassign this user to the team?");
            $("#delete_user").modal("show");
        }

    }
    function assignOrReassignUserToTeam() {

        var team_id = $("#team_id").val();
        var status = $("#status").val();

            $.ajax({
                    url: '/team/user/restore/'+team_id,
                    type: 'GET',
                    data: {status:status},
                    success: function(response) {
                        $("#delete_user").modal("hide");
                        $("#confirmAssignReassignToTeam").val(response.status);
                        $("#confirmAssignReassignToTeam").text(response.title);
                        alertConfirmModule(response.msg,icon = 'success');

                    },
                    error: function(response) {
                        alertConfirmModule("something went wrong",icon = 'error');
                        console.log(response.responseText);

                    }
                });

    }

     // code for phone pattren
     $('.phone').on('input', function(event) {
           var input = event.target.value;
           var regex = /[^a-zA-Z0-9]/g;
           if (regex.test(input)) {
               event.target.value = input.replace(regex, '');
           }
           $(this).val(formatPhoneNumber($(this).val()));
       });

       function formatPhoneNumber(input) {
           var phoneNumberCheck = document.getElementById("phoneNumber");
           var checkregex = /[^a-zA-Z0-9]/g;
           var phoneNumber = input.replace(checkregex, "");
           var regex = /^([a-zA-Z0-9]{3})([a-zA-Z0-9]{3})([a-zA-Z0-9]{4})$/;
           if (regex.test(input)) {
               phoneNumberCheck.setCustomValidity("");
               return input.replace(regex, '($1) $2-$3');
           } else {
               if(phoneNumber.length < 10 || phoneNumber.length > 11){
                   event.preventDefault();
                   phoneNumberCheck.setCustomValidity("Phone number must be between 10 and 11 digits");
                   return input;
               }else{
                   phoneNumberCheck.setCustomValidity("");
                   return input;
               }
           }
       }

       function coachAccessChange(id){
            $.ajax({
                url: '/team/change-coach/'+id,
                type: 'GET',
                data: {status:status},
                success: function(response) {
                    alertConfirmModule(response.msg,icon = 'success');
                    $( "#nav-tabContent" ).load(window.location.href + " #nav-tabContent" );

                },
                error: function(response) {
                    alertConfirmModule("something went wrong",icon = 'error');
                    console.log(response.responseText);

                }
            });
       }



$(document).ready(function() {
    var searchKeywords = $('#search_input_value').val();
    if (searchKeywords) {
        $('#search_input_put_value').val(searchKeywords);
    }
});

$(document).ready(function() {
    $("select.js-data-place-example-ajax").select2({
        theme: "classic",
        tags: true,
        dropdownParent: $("#add-places-modal"),
        ajax: {
                        url: 'https://secure.geonames.org/searchJSON',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            var data = {
                                name_startsWith: params.term,
                                orderby:'relevance',
                                maxRows: 1000,
                                username: 'attiqueurrehman'
                            };
                            return data;
                        },
                        processResults: function(data) {
                            var options = [];
                            if (data.geonames.length > 0) {
                                data.geonames.forEach(geoname => {
                                    var combinedPlace = geoname.name + ", " + geoname.adminName1 + ", " + geoname.countryName;
                                        var option = {
                                            id: combinedPlace,
                                            text: combinedPlace,
                                        };
                                        console.log(option);
                                        options.push(option);

                                });
                            } else {
                                console.log('No place found.');
                            }
                            return {
                                results: options
                            };
                        }
                    },
                    language: {
                        inputTooShort: function() {
                            return "Enter your city.";
                        }
                    }
    })

    $("select.js-edit-place-example-ajax").select2({
        theme: "classic",
        tags: true,
        dropdownParent: $("#edit-places-modal"),
        ajax: {
                        url: 'https://secure.geonames.org/searchJSON',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            var data = {
                                name_startsWith: params.term,
                                orderby:'relevance',
                                maxRows: 1000,
                                username: 'attiqueurrehman'
                            };
                            return data;
                        },
                        processResults: function(data) {
                            var options = [];
                            if (data.geonames.length > 0) {
                                data.geonames.forEach(geoname => {
                                    var combinedPlace = geoname.name + ", " + geoname.adminName1 + ", " + geoname.countryName;
                                        var option = {
                                            id: combinedPlace,
                                            text: combinedPlace,
                                        };
                                        console.log(option);
                                        options.push(option);

                                });
                            } else {
                                console.log('No place found.');
                            }
                            return {
                                results: options
                            };
                        }
                    },
                    language: {
                        inputTooShort: function() {
                            return "Enter your city.";
                        }
                    }
    })

    $("select.js-data-college-example-ajax").select2({
        theme: "classic",
        tags: true,
        dropdownParent: $("#add-college-data"),
        ajax: {
                        url: 'https://secure.geonames.org/searchJSON',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            var data = {
                                name_startsWith: params.term,
                                featureCode: 'UNIP',
                                featureCode: 'UNIV',
                                featureCode: 'SCHC',
                                featureCode: 'SCH',
                                orderby:'relevance',
                                maxRows: 1000,
                                username: 'attiqueurrehman'
                            };
                            return data;
                        },
                        processResults: function(data) {
                            var options = [];
                            if (data.geonames.length > 0) {
                                data.geonames.forEach(geoname => {
                                    var combinedPlace = geoname.name + ", " + geoname.adminName1 + ", " + geoname.countryName;
                                        var option = {
                                            id: geoname.name,
                                            text: combinedPlace,
                                        };
                                        console.log(option);
                                        options.push(option);

                                });
                            } else {
                                console.log('No college found.');
                            }
                            return {
                                results: options
                            };
                        }
                    },
                    language: {
                        inputTooShort: function() {
                            return "Enter your city.";
                        }
                    }
    })

    $("select.js-edit-college-example-ajax").select2({
        theme: "classic",
        tags: true,
        dropdownParent: $("#edit-college-data"),
        ajax: {
                        url: 'https://secure.geonames.org/searchJSON',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            var data = {
                                name_startsWith: params.term,
                                featureCode: 'UNIP',
                                featureCode: 'UNIV',
                                featureCode: 'SCHC',
                                featureCode: 'SCH',
                                orderby:'relevance',
                                maxRows: 1000,
                                username: 'attiqueurrehman'
                            };
                            return data;
                        },
                        processResults: function(data) {
                            var options = [];
                            if (data.geonames.length > 0) {
                                data.geonames.forEach(geoname => {
                                    var combinedPlace = geoname.name + ", " + geoname.adminName1 + ", " + geoname.countryName;
                                        var option = {
                                            id: geoname.name,
                                            text: combinedPlace,
                                        };
                                        console.log(option);
                                        options.push(option);

                                });
                            } else {
                                console.log('No college found.');
                            }
                            return {
                                results: options
                            };
                        }
                    },
                    language: {
                        inputTooShort: function() {
                            return "Enter your city.";
                        }
                    }
    })
    $(document).on('select2:open', () => {
        document.querySelector('.select2-container--open .select2-search__field').focus();
    });
})
// Function to check if an video element is in the viewport
function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }
  function debounce(func, delay) {
    let timer;
    return function() {
      clearTimeout(timer);
      timer = setTimeout(func, delay);
    };
  }
  function handleScroll() {
    const videos = document.querySelectorAll('.newsfeed-video-play');

    videos.forEach(video => {
      const rect = video.getBoundingClientRect();
      const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
      const videoTop = rect.top;
      const videoBottom = rect.bottom;
      const videoHeight = rect.height;

      const topThreshold = viewportHeight * 0.2;
      const bottomThreshold = viewportHeight * 0.8;

      if (videoTop >= bottomThreshold || videoBottom <= topThreshold) {
        video.pause();
      } else {
        video.play();
      }
    });
  }
  const debouncedScrollHandler = debounce(handleScroll, 100);
  window.addEventListener('scroll', debouncedScrollHandler);
  $('#add-hobbiesandintrests-modal-edit').on('show.bs.modal', function() {
    $.ajax({
        method: 'GET',
        url: '/hobbyAndInterestEditData',
    }).done(function(response) {
        document.getElementById('fav_tv_show').value = response.fav_tv_show
        document.getElementById('fav_movies').value = response.fav_movies
        document.getElementById('fav_games').value = response.fav_games
        document.getElementById('fav_music').value = response.fav_music
        document.getElementById('fav_books').value = response.fav_books
        document.getElementById('fav_writters').value = response.fav_writters
    });
});

function approveFeed(feedId) {
    $.ajax({
        url: '/approve-feed/' + feedId,
        method: 'get',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {
        var feedApprovals = $(".feedApprovals");
        if(feedApprovals.length){
            feedApprovals.hide().load(" .feedApprovals"+"> *").fadeIn(0);
            $('.feedApprovals-nav').addClass('active');
        }

        var pendingFeedApprove = $('.pending-feed-approve-'+feedId);
        if(pendingFeedApprove.length)
            pendingFeedApprove.addClass('d-none')

        var pendingFeedApproveUser = $('.pending-feed-approve-user-'+feedId);
        if(pendingFeedApproveUser.length)
            pendingFeedApproveUser.addClass('d-none')
        
            console.log(response);
        if(response.feed.feedEnd == true)
            $('.approve-feed-end').removeClass('d-none')
        console.log($('.approve-feed-end'));
        $(".update-newsfeed-approve").hide().load(" .update-newsfeed-approve"+"> *").fadeIn(0);
    });
}
function goToPhotos(){
    $("#timeline-title-hide").removeClass("active");
    $("#timeline-title-hide").removeClass("show");
    $("#show-photos").addClass("active");
    $("#show-photos").addClass("show");
    $("#timeline").removeClass("active");
    $("#timeline").removeClass("show");
    $("#photos").addClass("active");
    $("#photos").addClass("show");
}
function goToFriends(){
    $("#timeline-title-hide").removeClass("active");
    $("#timeline-title-hide").removeClass("show");
    $("#show-friends").addClass("active");
    $("#show-friends").addClass("show");
    $("#timeline").removeClass("active");
    $("#timeline").removeClass("show");
    $("#friendsTab").addClass("active");
    $("#friendsTab").addClass("show");
}
$('.add_edit_schedule_event').on('submit', function(e){
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url:$(this).attr('action'),
        method:$(this).attr('method'),
        data:new FormData(this),
        processData:false,
        dataType:'json',
        contentType:false,
        success: function(response) {
            $('#add-edit-event-modal').removeClass('show');
            $('#add-edit-event-modal').hide();
            $('#add-edit-event-modal').attr("aria-modal","true");
            $('#add-edit-event-modal').attr("role","dialog");
            $('#add-edit-event-modal').removeAttr("aria-hidden");
            $('.modal-backdrop').removeClass("show");
            $('.modal-backdrop').hide();
            $('.theme-color-default').removeAttr("style");
            $('.theme-color-default').removeClass("show");
            $('.add_edit_schedule_event')[0].reset();
            $(".updateSchedule").hide().load(" .updateSchedule"+"> *").fadeIn(0);
        },
    })
});
function editScheduleEvent(schedule){
    $('#event-modalLabel').html("Edit Schedule");
    $('#event-buttonLabel').html("Update Schedule");
    $('#eventName').val(schedule.event_name);
    $('#schedule_id').val(schedule.id);
    $('#eventDate').val(schedule.event_date);
    $('#location').val(schedule.address);
    $('#startTime').val(schedule.event_start_time);
    $('#description').val(schedule.description);
}
function addScheduleEvent(){
    $('#event-modalLabel').html("Add Schedule");
    $('#event-buttonLabel').html("Add Schedule");
    $('#eventName').val('');
    $('#schedule_id').val('');
    $('#eventDate').val('');
    $('#location').val('');
    $('#startTime').val('');
    $('#description').val('');
}

function deleteScheduleEvent(id){
    $.ajax({
        method: 'GET',
        url: '/deleteScheduleEvent/' + id,
        data: {id:id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {
        if(response.status == true){
            $(".updateSchedule").hide().load(" .updateSchedule"+"> *").fadeIn(0);
        }
    });
}

function checkImageExtensions() {
    var profileImage = $("#profile-image")[0];
    var coverImage = $("#cover-image")[0];
    var errorMessageProfile = $("#error-profile");
    var errorMessageCover = $("#error-profile");
    
    if(profileImage == undefined){
        var fileInput = coverImage;
    }else{
        var fileInput = profileImage;
    }

    if (fileInput.files.length != 0) {
        var file = fileInput.files[0];
        var fileName = file.name;
        var allowedExtensions = [".png", ".jpeg", ".jpg"];
        var fileExtension = fileName.substr(fileName.lastIndexOf('.'));

        if (allowedExtensions.indexOf(fileExtension.toLowerCase()) === -1) {
            if(profileImage == undefined)
                errorMessageCover.text("Please select a valid image (PNG, JPG, JPEG).");
            
            errorMessageProfile.text("Please select a valid image (PNG, JPG, JPEG).");
        } else {
            errorMessageProfile.text(""); 
            errorMessageCover.text(""); 
        }
    }
}

function selectOption(petId) {
    $('#'+petId).prop('checked', true);
}
function validateForm() {
    // Get all radio buttons with the name 'petofthemonth'
    var radioButtons = document.getElementsByName('petofthemonth');
    var isChecked = false;

    // Loop through radio buttons to check if at least one is selected
    for (var i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            isChecked = true;
            break;
        }
    }

    // Display a custom error message if no radio button is selected
    if (!isChecked) {
        // Create a div element for the error message
        var errorMessage = document.createElement('div');
        errorMessage.className = 'custom-error';
        errorMessage.textContent = 'Please select a pet of the month!';

        // Set the color to red
        errorMessage.style.color = 'red';

        // Insert the error message before the form (you can customize this part based on your HTML structure)
        var form = document.getElementById('yourForm');
        form.parentNode.insertBefore(errorMessage, form);

        // Hide the error message after 2 seconds
        setTimeout(function() {
            errorMessage.style.display = 'none';
        }, 1500);

        // Prevent form submission
        return false;
    }

    // If everything is good, allow the form to be submitted
    return true;
}


$('.vottingForm').on('submit', function(e){
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url:$(this).attr('action'),
        method:$(this).attr('method'),
        data:new FormData(this),
        processData:false,
        dataType:'json',
        contentType:false,
        success: function(response) {
            console.log(response);
            if(response.success == true){
                var successMessage = document.createElement('div');
                successMessage.className = 'custom-success';
                successMessage.textContent = response.message;
                var form = document.getElementById('yourForm');
                form.parentNode.insertBefore(successMessage, form);
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 1500);
            }else{
                var errorMessage = document.createElement('div');
                errorMessage.className = 'custom-success';
                errorMessage.textContent = response.message;
                var form = document.getElementById('yourForm');
                form.parentNode.insertBefore(errorMessage, form);
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 1500);
            }
            $(".radio-list").hide().load(" .radio-list"+"> *").fadeIn(0);
        },
    })
});