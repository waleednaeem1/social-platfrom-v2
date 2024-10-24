<?php

use App\Http\Controllers\Api\ChatBoxController;
use App\Http\Controllers\Api\NotificationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\FeedsController;
use App\Http\Controllers\Api\GroupFeedsController;
use App\Http\Controllers\Api\GroupsController;
use App\Http\Controllers\Api\HomePageController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\ReportFeedController;
use App\Http\Controllers\Api\UserInformationController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\AblumController;
use App\Http\Controllers\Api\CalenderController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FriendRequestController;
use App\Http\Controllers\Api\ProfilePrivacyController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\UserImagesController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CoursesCartController;
use App\Http\Controllers\Api\ResourcesController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\PetOfTheMonthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Devsinc API Routes
|--------------------------------------------------------------------------
*/

Route::get('/search-users', [UsersController::class, 'searchUsers']);
Route::get('/check-username-email/{slug}/{type}', [UsersController::class, 'checkUsernameEmail']);
Route::get('/feed-list/{user_id}', [FeedsController::class, 'getAllFeeds']);
Route::get('/feed-list-new/{user_id}', [FeedsController::class, 'getAllFeedsDuplicate']);
Route::get('/user-feed-list/{user_id}', [FeedsController::class, 'getUserFeeds']);
Route::get('/upcoming-birthdays/{user_id}', [FeedsController::class, 'upcomingBirthdays']);
Route::post('/create-feed', [FeedsController::class, 'createFeed']);
Route::get('/edit-feed/{feed_id}', [FeedsController::class, 'editFeed']);
Route::get('/delete-feed-attachments/{feed_id}', [FeedsController::class, 'deleteFeedAttachments']);
Route::post('/update-feed/{feed_id}', [FeedsController::class, 'updateFeed']);
Route::post('/update-share-feed/{feed_id}', [FeedsController::class, 'updateShareFeed']);
Route::post('/feed-like/save', [FeedsController::class, 'saveLike']);
Route::post('/feed-comment/save', [FeedsController::class, 'saveComment']);
Route::get('/view-profile-app/{user_id}', [ProfileController::class, 'getUserProfile']);
Route::get('/view-all-comments/{feed_id}/{user_id}', [FeedsController::class, 'viewAllComments']);
Route::get('/view-all-likes/{feed_id}', [FeedsController::class, 'viewAllLikes']);
Route::get('following-users-list/{id}',[FollowController::class, 'userFollowingList']);
Route::post('follow-user', [FollowController::class, 'followUser']);
Route::post('/remove-feed', [FeedsController::class, 'removeFeed']);
Route::get('/remove-story/{id}', [FeedsController::class, 'removeStory']);
Route::get('/remove-comment/{comment_id}', [FeedsController::class, 'removeComment']);
Route::get('friend-requests/{user_id}', [UsersController::class, 'getFriendRequests']);
Route::post('friend-requests/send', [UsersController::class, 'sendFriendRequest']);
Route::post('friend-request/submit', [UsersController::class, 'submitFriendRequest']);
Route::post('/comment-like/save', [FeedsController::class, 'saveLikeForComment']);
Route::get('/comment-like-users/{comment_id}/{checkUser?}', [FeedsController::class, 'commentLikeUsers']);
Route::post('/update-profile', [ProfileController::class, 'updateProfileApp']);
Route::post('/upload-feed-images', [FeedsController::class, 'uploadFeedImages']);
Route::post('/feed/add-to-favourite', [FeedsController::class, 'AddToFavFeed']);
Route::post('/feed/remove-from-favourite', [FeedsController::class, 'RemoveFromFavFeed']);
Route::get('friends-list/{user_id}', [UsersController::class, 'getAllFriends']);
Route::get('get-follow-requests/{user_id}', [FollowController::class, 'getFollowRequests']);
Route::post('follow-request/submit', [FollowController::class, 'submitFollowRequest']);
Route::post('remove-following-user', [FollowController::class, 'removeFollowingUser']);
Route::post('remove-follower-user', [FollowController::class, 'removeFollowerUser']);
Route::post('remove-friend', [UsersController::class, 'removeFriend']);
// Route::get('pages/{page}', [HomePageController::class, 'pages']);
Route::get('user/get-profile/{id}/{checkId?}', [ProfileController::class, 'getProfile']);
Route::get('get-feed-likes/{feed_id}', [FeedsController::class, 'getFeedLikes']);
Route::get('/favourite-feed-list/{user_id}', [FeedsController::class, 'getFavouriteFeeds']);
Route::post('/updateProfile', [ProfileController::class, 'updateProfile']);
Route::post('/upload-profile-picture', [ProfileController::class, 'uploadProfilePicture']);
Route::get('/get-profile/{id}/{checkId?}', [ProfileController::class, 'getProfile']);

Route::post('/report-feed', [ReportFeedController::class, 'reportUserFeed']);
Route::get('/feed-report-types', [ReportFeedController::class, 'reportTypes']);
Route::get('/search-friends', [UsersController::class, 'searchFriends']);
Route::get('/blocked-users-list/{user_id}', [UsersController::class, 'blockedUsersList']);
Route::get('delete-message/{message_id}/{user_id}', [ChatBoxController::class, 'deleteMessage']);
Route::get('delete-chat/{chat_id}', [ChatBoxController::class, 'deleteChat']);
Route::get('get-feed-likes/{feed_id}', [FeedsController::class, 'getFeedLikes']);
Route::get('vt-chat-user-list/{user_id}', [ChatBoxController::class, 'getChatUserList']);
Route::get('user-chat-details/{chat_id}/{user_id?}', [ChatBoxController::class, 'user_chat_list']);
Route::post('vt-chat-box/send-message', [ChatBoxController::class, 'storeChat']);
Route::get('all-chat-read/{user_id}', [ChatBoxController::class, 'chatreadbadge']);
Route::get('/group-list/{userId?}', [GroupsController::class, 'groupListing']);
Route::post('/create-group', [GroupsController::class, 'createGroup']);
Route::get('/group-details/{groupId}/{userId?}', [GroupsController::class, 'groupDetails']);
Route::post('/create-group-post', [GroupFeedsController::class, 'createGroupPost']);
Route::post('/upload-group-feed-images', [GroupFeedsController::class, 'uploadGroupFeedImages']);
Route::post('join-group',[GroupsController::class,'joinGroup']);
Route::get('/group-feed-list/{group_id}/{user_id?}', [GroupFeedsController::class, 'getAllGroupFeeds']);
Route::get('/delete-group/{group_id}/{user_id}', [GroupsController::class, 'deleteGroup']);
Route::post('/upload-group-images', [GroupsController::class, 'uploadGroupMainImages']);
Route::post('leave-group',[GroupsController::class,'leaveGroup']);
Route::get('user-joined-groups/{id}',[GroupsController::class,'UserJoinedGroups']);
Route::post('save-hobbies-interests',[UserInformationController::class,'saveHobbiesAndInterests']);
Route::post('update-hobbies-interests',[UserInformationController::class,'updateHobbiesAndInterests']);
Route::get('get-hobbies-interests/{id}',[UserInformationController::class,'getHobbiesAndInterests']);
Route::post('like-group-post',[GroupFeedsController::class,'likeGroupPost']);
Route::post('comment-group-post',[GroupFeedsController::class,'commentGroupPost']);
Route::post('like-group-post-comment',[GroupFeedsController::class,'likeGroupPostComment']);
Route::get('/group-comment-like-users/{comment_id}/{checkUser?}', [GroupFeedsController::class, 'groupCommentLikeUsers']);
Route::get('/view-group-feed-comments/{group_feed_id}/{user_id}', [GroupFeedsController::class, 'viewAllGroupFeedComments']);
Route::get('/view-group-feed-likes/{group_feed_id}', [GroupFeedsController::class, 'viewAllGroupFeedLikes']);
Route::post('/approve-group-request',[GroupsController::class,'approveGroupRequest']);
Route::post('/reject-group-request',[GroupsController::class,'rejectGroupRequest']);
Route::post('/remove-member',[GroupsController::class,'removeMember']);
Route::post('update-living-place',[UserInformationController::class,'updatePlacedYouLived']);
Route::post('save-living-place',[UserInformationController::class,'savePlacedYouLived']);
Route::get('view-living-place/{userId}',[UserInformationController::class,'getPlacedYouLived']);
Route::post('save-work-education',[UserInformationController::class,'saveWorkAndEducation']);
Route::post('update-work-education',[UserInformationController::class,'updateWorkAndEducation']);
Route::get('view-work-education/{userId}',[UserInformationController::class,'getWorkAndEducation']);
Route::post('save-relationship-details',[UserInformationController::class,'saveRelationshipDetails']);
Route::post('update-relationship-details',[UserInformationController::class,'updateRelationshipDetails']);
Route::get('view-relationship-details/{userId}',[UserInformationController::class,'getRelationshipDetails']);
Route::get('/remove-groupfeed-comment/{comment_id}', [GroupFeedsController::class, 'removeGroupFeedComment']);
Route::post('save-social-details',[UserInformationController::class,'saveSocialDetails']);
Route::get('view-social-details/{userId}',[UserInformationController::class,'getSocialDetails']);
Route::get('get-user-notifications/{userId}',[NotificationsController::class,'getUserNotifications']);
Route::get('delete-group-feed/{feedId}/{groupId}/{userId}', [GroupFeedsController::class, 'deleteGroupFeed']);
Route::get('add-group-participant/{groupId}/{adminUserId}/{userId}', [GroupsController::class, 'addGroupParticipant']);
Route::get('remove-group-participant/{groupId}/{adminUserId}/{userId}', [GroupsController::class, 'removeGroupParticipant']);
Route::get('view-group-participant/{groupId}', [GroupsController::class, 'viewGroupParticipant']);
Route::get('view-other-user-about/{userId}', [UserInformationController::class, 'viewOtherUserAbout']);
Route::get('get-followers/{user_id}/{other_user_id?}', [FollowController::class, 'getFollowers']);
Route::get('get-followings/{user_id}/{other_user_id?}', [FollowController::class, 'getFollowings']);
Route::get('allow-user/{email}',[UsersController::class,'allowUser']);
Route::get('delete-user-about/{id}/{type}',[UserInformationController::class,'deleteUserAbout']);
Route::post('/block-user', [UsersController::class, 'blockuser']);
Route::get('/pages/{user_id?}', [PagesController::class, 'viewPages']);
Route::get('/page-detail/{id}/{userId?}', [PagesController::class, 'pageDetail']);
Route::post('create-page',[PagesController::class,'createPage']);
Route::post('like-page',[PagesController::class,'likePage']);
Route::post('create-page-feed',[PagesController::class,'createPageFeed']);
Route::post('upload-page-feed-images',[PagesController::class,'uploadPageFeedImages']);
Route::post('page-post-like',[PagesController::class,'likePagePost']);
Route::post('comment-page-post',[PagesController::class,'commentPagePost']);
Route::post('create-album',[AblumController::class,'createAlbum']);
Route::post('upload-album-images',[AblumController::class,'uploadAblumImages']);
Route::post('add-album-photo',[AblumController::class,'addPhotoToAlbum']);
Route::get('album-image-listing/{album_id}/{user_id}',[AblumController::class,'showAlbumImages']);
Route::post('update-ownstatus',[UserInformationController::class,'updateOwnStatus']);
Route::get('user-all-images/{user_id}',[UserInformationController::class,'getUserProfileImagesAndCovers']);
Route::get('hobbies-listing',[UserInformationController::class,'getHobbiesList']);
Route::get('/all-profile-details/{profile_user_id}/{viewing_user_id}',[ProfileController::class,'getAllProfileDetails']);
Route::post('/change-profile-privacy',[ProfilePrivacyController::class,'changeProfilePrivacy']);
Route::get('user-joined-pages/{id}',[PagesController::class,'UserJoinedPages']);
Route::post('/upload-page-images', [PagesController::class, 'uploadPageImageAndCover']);
Route::post('page-unlike',[PagesController::class,'unlikePage']);
Route::post('/page-feed-comment-like', [PagesController::class, 'saveLikeForPageFeedComment']);
Route::get('/page-comment-like-users/{comment_id}/{checkUser?}', [PagesController::class, 'pageCommentLikeUsers']);
Route::post('/change-privacy',[ProfilePrivacyController::class,'changeAccountPrivacy']);
Route::get('/get-account-privacy/{user_id}',[ProfilePrivacyController::class,'getAccountPrivacy']);
Route::post('/set-notification-viewed',[NotificationsController::class,'setNotificationViewed']);
Route::post('contact-support',[ContactController::class,'userContactSupport']);
Route::get('/get-specific-feed/{id}/{type}/{userId}',[NotificationsController::class,'getSpecificFeedForNotification']);
Route::get('/remove-notification/{id}',[NotificationsController::class,'removeNotification']);
Route::get('/all-notification-read/{user_id}',[NotificationsController::class,'readNotificationAll']);
Route::post('unfollow-group', [GroupsController::class, 'unFollowGroup']);
Route::post('update-group-details', [GroupsController::class, 'updateGroupDetails']);
Route::get('remove-requests/{user_id}', [UsersController::class, 'removeRequests']);
Route::get('pages-categories', [PagesController::class, 'pagesCategories']);
Route::get('/friends/{user_id}/{other_user_id?}',[UsersController::class, 'getFriendsList']);
Route::get('/friendrequest/{user_id}',[UsersController::class, 'getFriendRequest']);
Route::get('/get-profile-pics/{user_id}',[UserImagesController::class, 'getAllProfilePics']);
Route::get('/get-cover-pics/{user_id}',[UserImagesController::class, 'getAllCoverPics']);
Route::post('/respond-group-request',[GroupsController::class, 'respondGroupRequest']);
Route::get('/page-feed-like-list/{feed_id}',[PagesController::class, 'pageFeedLikeList']);
Route::get('/group-feed-like-list/{feed_id}',[GroupFeedsController::class, 'groupFeedLikeList']);
Route::post('delete-album',[AblumController::class,'deleteAlbum']);
Route::get('delete-album-image/{image_id}/{type}',[AblumController::class,'deleteAlbumImage']);
Route::get('user-all-albums/{user_id}',[AblumController::class,'userAllAlbums']);
Route::get('user-single-album/{user_id}/{album_id}',[AblumController::class,'singleAlbums']);
Route::get('hide-from-timeline/{feed_id}',[FeedsController::class,'hidePost']);
Route::get('delete-all-album/{user_id}',[AblumController::class,'deleteAllAlbum']);
Route::post('viewed-friend-requests',[FriendRequestController::class,'viewedFriendRequests']);
Route::get('/page-feed-comment-list/{feed_id}/{user_id}',[PagesController::class, 'pageFeedCommentList']);
Route::get('/read-chat/{chat_id}',[ChatBoxController::class, 'readChat']);
Route::get('/recently-added-friends/{user_id}',[UserInformationController::class, 'recentlyAddedFriends']);
Route::get('/suggested-pages/{user_id}',[PagesController::class, 'suggestedPages']);
Route::get('/suggested-groups/{user_id}',[GroupsController::class, 'suggestedGroups']);
Route::post('/viewed-stories',[StoryController::class, 'viewedStories']);
Route::get('/story-viewed-users/{story_id}',[StoryController::class, 'storyViewedUsers']);
Route::get('delete-page-feed/{feedId}/{pageId}/{userId}', [PagesController::class, 'deletePageFeed']);
Route::get('/remove-pagefeed-comment/{comment_id}', [PagesController::class, 'removePageFeedComment']);
Route::get('delete-page/{pageId}/{userId}', [PagesController::class, 'deletePage']);

// Courses
Route::get('/courses-categories', [CourseController::class, 'courseCategories']); // Course Categories Listing
Route::get('/course-listing/{slug}/{user_id}', [CourseController::class, 'courseListing']); // Course Listing
Route::get('/course/{course_slug}/enrollment/{customer_id}', [CourseController::class, 'courseEnrollment']); // Check User Course Enrollment Exist Or Not
Route::get('/coach/{course_slug}/enrollment/{user_id}', [CourseController::class, 'enrollCoach']);

Route::get('/courses-categories/{cat_slug}/{course_slug}/{user_id}', [CourseController::class, 'courseDetail']); // Purchased Course after Detail Course Information
Route::get('/courses-categories/{cat_slug}/{course_slug}/{module_slug}/{user_id}', [CourseController::class, 'courseModuleDetail']); // Purchased Course after Detail Course Module Information
Route::get('/courses-categories/{cat_slug}/{course_slug}/{module_slug}/{section_slug}/{user_id}', [CourseController::class, 'courseModuleSectionDetail']); // Purchased Course after Detail Course Module Section Information
Route::get('courses-categories/{cat_slug}/{course_slug}/{module_slug}/{section_slug}/{exercise_slug}/{user_id}', [CourseController::class, 'courseModuleSectionExerciseDetail']); // Purchased Course after Detail Course Module Section Exercise Information & All Questions

Route::post('course/quiz/save', [CourseController::class, 'courseQuizSave']); // Submit MCQ to Course Exercise


Route::get('/my-courses/{user_id}', [CourseController::class, 'myCourses']); // User purchased course
Route::post('/courses/addToCart', [CourseController::class, 'addToCart']); // Course add to cart

// Apply Couch
Route::post('/course/applyCoach', [CourseController::class, 'applyCoach']);

// User Cart
Route::get('/cart/{user_id}', [CoursesCartController::class, 'index']);
Route::post('/courses/delete', [CoursesCartController::class, 'deleteCartItems']);
Route::post('/purchaseCourse', [CoursesCartController::class, 'purchaseCourse']);
Route::post('/applyCoupon', [CoursesCartController::class, 'applyCoupon']);

// User Teams
Route::get('/team/{user_id}', [TeamController::class, 'index']);

Route::post('/team/add-colleague', [TeamController::class, 'addColleague']);
Route::get('/team/change-coach/{id}/{user_id}', [TeamController::class, 'changeCoach']);
Route::get('/team/profile/detail/{id}', [TeamController::class, 'profileDetail']);
Route::post('/team/user/restore', [TeamController::class, 'restoreUser']); // User assign/Unassign From Course
Route::post('/team/user/profile/edit', [TeamController::class, 'teamUserEdit']);
Route::post('/team/user/profile/update', [TeamController::class, 'teamUserUpdate']);

Route::get('/courses-marking-list/{user_id}', [CourseController::class, 'marking']);
Route::get('/courses-marking-detail/{id}', [CourseController::class, 'markingCourseDetail']);
Route::get('/exercise-marking-detail/{id}', [CourseController::class, 'markingExerciseDetail']);
Route::post('/exercise-marking-save', [CourseController::class, 'exerciseMark']);

// Add Pets
    Route::post('/add-pet', [PetOfTheMonthController::class, 'addPet']);
    Route::get('/my-pets/{userId}', [PetOfTheMonthController::class, 'index']);
    Route::get('/pet-of-the-month', [PetOfTheMonthController::class, 'petOfTheMonthdata']);
    Route::get('/pet-detail/{slug}', [PetOfTheMonthController::class, 'petDetail']);
    Route::get('/pet-badge-request/{slug}', [PetOfTheMonthController::class, 'petBadgeRequest']);
    Route::get('/delete-mypet/{id}', [PetOfTheMonthController::class, 'deleteMyPet']);
    Route::post('/update-pet', [PetOfTheMonthController::class, 'updatePet']);

//blog page route
Route::group(['prefix' => 'blog'], function() {
    Route::get('blog-list', [ResourcesController::class, 'bloglist']);
    Route::get('blog-detail/{slug}', [ResourcesController::class, 'blogDetail']);
});

Route::group(['prefix' => 'news'], function() {
    Route::get('news-list', [ResourcesController::class, 'newslist']);
    Route::get('news-detail/{slug}', [ResourcesController::class, 'newsDetail']);
});
Route::get('speakers', [ResourcesController::class, 'speakers']);
Route::get('speaker-detail/{slug}', [ResourcesController::class, 'speakerDetail']);
Route::get('my-webinars/{email}', [ResourcesController::class, 'myWebinars']);

//events APis
Route::get('get-calender-event/{user_id}/{date}', [CalenderController::class, 'calender']);
Route::post('save-calender-event',[CalenderController::class,'addEvent']);
Route::get('delete-calender-event/{event_id}',[CalenderController::class,'deleteScheduleEvent']);
