<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\ChatBoxController;
use App\Http\Controllers\Api\FeedsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\CoursesCartController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\Security\RolePermission;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePagesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedModalController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\GroupFeedsController;
use App\Http\Controllers\GroupPagesController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PageFeedsController;
use App\Http\Controllers\PetOfTheMonthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// Route::get('/', [HomeController::class, 'index'])->name('index');
// Route::group(['middleware' => 'auth'], function () {

    // Permission Module
    // Route::get('/permission-role',[RolePermission::class, 'index'])->name('permission-role.list');
    // Route::post('/permission-role/store',[RolePermission::class, 'store'])->name('permission-role.store');
    // Route::resource('permission',PermissionController::class);
    // Route::resource('role', RoleController::class);


    // Route::get('/home', [HomeController::class, 'home'])->name('home');
// });
 // these pages show when user logout
 Route::get('privacypolicy', [HomeController::class, 'privacypolicylogout'])->name('logout.privacypolicy');
 Route::get('termsofuse', [HomeController::class, 'termsofservicelogout'])->name('logout.termsofservice');
 Route::get('aboutus', [HomeController::class, 'aboutuslogout'])->name('logout.aboutus');
 Route::get('customersupport', [HomeController::class, 'customerSupportlogout'])->name('logout.customersupport');

 
Route::group(['middleware' => ['auth', 'PreventBackHistory']], function () {
  Route::get('/', [HomeController::class, 'home'])->name('home');
// Profile
  // Route::get('/user_list',[HomeController::class, 'user_list'])->name('userlist');
  Route::get('/friends/{user_id}',[FriendsController::class, 'getFriends']);
  Route::get('/friendrequest/{user_id}',[FriendsController::class, 'getFriendRequest']);
  // Route::get('/friends/{user_id}',[FriendsController::class, 'getAllFriends']);
  Route::get('/verified',[UserController::class, 'verifiedUser']);
  Route::get('/searched-users-list',[UserController::class, 'searchResult'])->name('search.users');
  Route::resource('/users', UserController::class);
  Route::post('/user-delete', [UserController::class, 'delete'])->name('users.delete');
  Route::post('/user-privacy', [UserController::class, 'privacy'])->name('users.privacy');
  Route::get('/getUserData', [UserController::class,'getUserData'])->name('getUserData');
  Route::get('search-results', [UserController::class, 'searchUsers'])->name('search-results');
  Route::get('user-delete/{id}',[UserController::class,'deleteRequest'])->name('user.delete');
  Route::get('user-confirm/{id}',[UserController::class,'acceptRequest'])->name('user.confirm');
  Route::get('unFriend/{username}',[UserController::class,'unFriend'])->name('unFriend');
  Route::get('addToFriend/{username}',[UserController::class,'addToFriend'])->name('addToFriend');
  Route::get('cancelRequest/{username}',[UserController::class,'cancelRequest'])->name('cancelRequest');
  Route::get('followUser/{username}',[UserController::class,'followUser'])->name('followUser');
  Route::get('unfollowUser/{username}',[UserController::class,'unfollowUser'])->name('unfollowUser');
  Route::get('blockFriend/{username}',[UserController::class,'blockFriend'])->name('blockFriend');
  Route::get('unblockFriend/{username}',[UserController::class,'unblockFriend'])->name('unblockFriend');
  // Dashboard Routes
  // Route::get('/search-users', [UserController::class, 'searchUsers'])->name('user.search');

  Route::Post('feed-data-modal', [FeedModalController::class, 'feedDataGetModal']);
  Route::Post('delete-feed-attachments', [FeedModalController::class, 'deleteFeedAttachments'])->name('deleteFeedAttachments');

// Not Define
  Route::get('/changePassword', [UserController::class,'showchangepasswordget'])->name('changepasswordget');
  Route::put('/changePassword/{id}', [UserController::class,'changepasswordpost'])->name('changepasswordpost');
  Route::get('image-crop-group', [HomeController::class, "imageCropGroup"]);
  Route::get('getAllFeeds', [HomeController::class, 'getAllFeeds'])->name('getAllFeeds');
  Route::get('image-crop', [HomeController::class, "imageCrop"]);
  Route::get('page', [HomeController::class, 'page'])->name('page');

// End Not Define

  //Profile
  Route::get('userlist', [ProfileController::class, 'userlist'])->name('userlist');
  Route::get('showAlbumImages',[ProfileController::class,'showAlbumImages'])->name('showAlbumImages');
  Route::post('createAlbum',[ProfileController::class,'createAlbum'])->name('createAlbum');
  Route::post('addPhotoAlbum',[ProfileController::class,'addPhotoAlbum'])->name('addPhotoAlbum');
  Route::post('deleteAlbum/{albumId}', [ProfileController::class, 'deleteAlbum'])->name('deleteAlbum');
  Route::post('deleteAlbumInnerPicture/{imagId}/{albumId}', [ProfileController::class, 'deleteAlbumInnerPicture'])->name('deleteAlbumInnerPicture');
  Route::post('getFamilyMember',[ProfileController::class,'getFamilyMember'])->name('getFamilyMember');
  Route::post('getWorkPlace',[ProfileController::class,'getWorkPlace'])->name('getWorkPlace');
  Route::post('getProfessionalSkill',[ProfileController::class,'getProfessionalSkill'])->name('getProfessionalSkill');
  Route::post('getCollegeDetails',[ProfileController::class,'getCollegeDetails'])->name('getCollegeDetails');
  Route::post('image-crop', [ProfileController::class, "imageCropPost"])->name("imageCrop");
  Route::post('getLivedPlaces',[ProfileController::class,'getLivedPlaces'])->name('getLivedPlaces');
  Route::post('deletePicture/{imagId}', [ProfileController::class, 'deletePicture'])->name('deletePicture');
  Route::post('aboutInformation',[ProfileController::class,'aboutInformation'])->name('user.aboutInformation');
  Route::post('aboutInformationUpdate',[ProfileController::class,'aboutInformationUpdate'])->name('user.aboutInformationUpdate');
  Route::post('placeLivesUpdate',[ProfileController::class,'placeLivesUpdate'])->name('user.placeLivesUpdate');
  Route::post('placeLives',[ProfileController::class,'placeLives'])->name('user.placeLives');
  Route::post('familyRelationship',[ProfileController::class,'familyRelationship'])->name('user.familyRelationship');
  Route::post('hobbyAndInterest',[ProfileController::class,'hobbyAndInterest'])->name('user.hobbyAndInterest');
  Route::post('hobbyAndInterestEdit',[ProfileController::class,'hobbyAndInterestEdit'])->name('user.hobbyAndInterestEdit');
  Route::get('hobbyAndInterestEditData',[ProfileController::class,'hobbyAndInterestEditData'])->name('user.hobbyAndInterestEditData');
  Route::post('familyRelationshipEdit',[ProfileController::class,'familyRelationshipEdit'])->name('user.familyRelationshipEdit');
  Route::post('familyRelationshipeditsingle',[ProfileController::class,'familyRelationshipEditSingle'])->name('user.familyRelationshipeditsingle');
  Route::get('userhobbylist/{username}', [ProfileController::class, 'userHobbyList'])->name('userhobbylist');
  Route::get('usercollegelist/{username}', [ProfileController::class, 'userCollegeList'])->name('usercollegelist');
  Route::get('userworklist/{username}', [ProfileController::class, 'userWorkEdu'])->name('userworklist');
  Route::get('userlivelist/{username}', [ProfileController::class, 'userLiveList'])->name('userlivelist');
  Route::get('userfamilymemberlist/{username}', [ProfileController::class, 'userFamilyMemberList'])->name('userfamilymemberlist');
  Route::get('userstatuslist/{username}', [ProfileController::class, 'userstatusList'])->name('userstatuslist');
  Route::get('userprofskilllist/{username}', [ProfileController::class, 'userProfSkill'])->name('userprofskilllist');
  Route::get('profile/{username}', [ProfileController::class, 'profile'])->name('user-profile');
  Route::get('favoriteFeeds', [ProfileController::class, 'favoriteFeeds'])->name('user.favoriteFeeds');
  // Route::get('/feed-report-types', [ProfileController::class, 'reportTypes']);
  Route::get('profileedit', [ProfileController::class, 'profileedit'])->name('profileedit');
  Route::get('delProfileData/{id}/{type}',[ProfileController::class,'delProfileData'])->name('delProfileData');
  Route::get('get-states', [ProfileController::class, 'get_states'])->name('get-states');
  Route::get('accountsetting', [ProfileController::class, 'accountsetting'])->name('accountsetting');
  Route::get('privacysetting', [ProfileController::class, 'privacysetting'])->name('privacysetting');
  Route::get('generalsetting', [ProfileController::class, 'generalsetting'])->name('generalsetting');
  Route::get('friendlist', [UserController::class, 'friendlist'])->name('friendlist');
  Route::post('change-password',[ProfileController::class,'changePassword'])->name('adminChangePassword');
  Route::get('change-password',[ProfileController::class,'changePasswordSuccess']);
  Route::get('friendrequestreadbadge', [ProfileController::class, 'friendrequestreadbadge'])->name('friendrequestreadbadge');
  Route::get('friendrequest', [ProfileController::class, 'friendrequest'])->name('friendrequest');
// End Profile

// Group
  Route::post('join-group',[GroupsController::class,'joinGroup'])->name('join-group');
  Route::post('unfollowGroupMember',[GroupsController::class,'unfollowGroupMember'])->name('unfollowGroupMember');
  Route::post('followGroupMember',[GroupsController::class,'followGroupMember'])->name('followGroupMember');
  Route::post('approveGroupRequest/{requestedUserId}/{groupId}/{adminUserId}',[GroupsController::class,'approveGroupRequest'])->name('approveGroupRequest');
  Route::post('rejectGroupRequest/{requestedUserId}/{groupId}/{adminUserId}',[GroupsController::class,'rejectGroupRequest'])->name('rejectGroupRequest');
  Route::post('removeMember/{requestedUserId}/{groupId}/{adminUserId}',[GroupsController::class,'removeMember'])->name('removeMember');
  Route::post('leave-group',[GroupsController::class,'leave_group'])->name('leave-group');
  Route::post('leaveGroup',[GroupsController::class,'leaveGroup'])->name('leaveGroup');
  Route::post('createGroup',[GroupsController::class,'createGroup'])->name('createGroup');
  Route::post('/deleteGroup/{id}',[GroupsController::class,'deleteGroup'])->name('deleteGroup');
  Route::get('group', [GroupsController::class, 'group'])->name('group-1');
  Route::get('groupdetail/{id}', [GroupsController::class, 'groupdetail'])->name('groupdetail');
  Route::post('updateGroupProfilePicture',[GroupsController::class,'updateGroupProfilePicture'])->name('user.updateGroupProfilePicture');
  
  Route::post('group-comments-store',[GroupFeedsController::class,'groupCommentsStore'])->name('group-comments.store');
  Route::post('/saveGroupCommentLike',[GroupFeedsController::class,'saveGroupCommentLike'])->name('saveGroupCommentLike.like');
  Route::post('group-post-like',[GroupFeedsController::class,'likeGroupPost'])->name('grouppost.like');
  Route::get('post-comment-like/{feedId}/{userId}/{type}/{commentId}/{groupId}',[GroupFeedsController::class,'likeGroupPostComment'])->name('groupPostComment.like');
  Route::get('approve-feed/{feedId}',[GroupFeedsController::class,'approveFeed'])->name('approveFeed');
  Route::post('groupsCommentsStore',[GroupFeedsController::class,'storeGroupComments'])->name('groupsComments.store');
  Route::post('image-crop-group', [GroupFeedsController::class, "imageCropGroupPost"])->name("imageCropGroup");
// End group

//  Notification
  Route::get('notification', [NotificationController::class, 'notification'])->name('notification');
  Route::get('notificationreadbadge', [NotificationController::class, 'notificationreadbadge'])->name('notificationreadbadge');
  Route::get('readnotification/{id}', [NotificationController::class, 'readNotification'])->name('readNotification');
  Route::get('notificationDetails/{id}', [NotificationController::class, 'notificationDetails'])->name('notificationDetails');
  Route::get('delete-notification/{id}', [NotificationController::class, 'deleteNotification'])->name('deleteNotification');
  Route::get('get-badge-data-bodyheader', [NotificationController::class, 'getBadgeDataBodyheader'])->name('get-badge-data-bodyheader');
// End Notification

  Route::get('feed-detail/{id}', [NotificationController::class, 'shareFeed'])->name('feedDetail');

// Combine Groups And Pages Function
  Route::post('saveGroupsPagesCommentsReply',[GroupPagesController::class,'saveGroupsPagesCommentsReply'])->name('saveGroupsPagesCommentsReply');
  Route::post('/deleteGroupPagesFeedComment',[GroupPagesController::class,'deleteGroupPagesFeedComment'])->name('deleteGroupPagesFeedComment');
  Route::post('createGroupAndPagePost',[GroupPagesController::class,'createGroupAndPagePost'])->name('createGroupAndPagePost');
  Route::get('deleteGroupPagePost/{feedId}/{groupId}/{userId}', [GroupPagesController::class, 'deleteGroupPagePost'])->name('deleteGroupPagePost');
// End Combine Groups And Pages Function

// Profile Feeds
  Route::post('post-like',[FeedController::class,'likePost'])->name('post.like');
  Route::post('comments-store',[FeedController::class,'storeComments'])->name('comments.store');
  Route::post('/comment-like',[FeedController::class,'likePostComment'])->name('postComment.like');
  Route::post('/saveCommentLike',[FeedController::class,'saveCommentLike'])->name('saveCommentLike.like');
  Route::post('saveCommentsReply',[FeedController::class,'saveCommentsReply'])->name('saveCommentsReply');
  Route::post('/deleteFeedComment',[FeedController::class,'deleteFeedComment'])->name('deleteFeedComment');
  Route::post('createPost',[FeedController::class,'createPost'])->name('user.createPost');
  Route::get('deletePost/{feedId}', [FeedController::class, 'deletePost'])->name('deletePost');
  Route::get('savePost/{feedId}', [FeedController::class, 'savePost'])->name('savePost');
  Route::get('removePost/{feedId}', [FeedController::class, 'removePost'])->name('removePost');
  Route::get('hidePost/{feedId}', [FeedController::class, 'hidePost'])->name('hidePost');
  Route::post('createProfileTimelineFeed',[FeedController::class,'createProfileTimelineFeed'])->name('createProfileTimelineFeed');
  Route::get('reportFeed', [FeedController::class, 'reportFeed'])->name('reportFeed');
// End Profile Feed

// Chat
  Route::get('chats', [ChatController::class, 'chats'])->name('chats');
  Route::post('storeChat',[ChatController::class,'storeChat'])->name('storeChat');
  Route::post('fetchChats',[ChatController::class,'fetchChats'])->name('fetchChats');
  Route::post('createAndFetchChats',[ChatController::class,'createAndFetchChats'])->name('createAndFetchChats');
  Route::get('delete-message/{message_id}', [ChatController::class, 'deleteMessage']);
  Route::get('chatreadbadge', [ChatController::class, 'chatreadbadge'])->name('chatreadbadge');
// End Chat

// Pages
  Route::post('leavePage',[PagesController::class,'leavePage'])->name('leavePage');
  Route::post('leave-page',[PagesController::class,'unlike_page'])->name('leave-page');
  Route::post('createPage',[PagesController::class,'createPage'])->name('createPage');
  Route::post('like-page',[PagesController::class,'likePage'])->name('like-page');
  Route::get('/editPage/{id}',[PagesController::class,'editPage'])->name('editPage');
  Route::post('/deletePage/{id}',[PagesController::class,'deletePage'])->name('deletePage');
  Route::get('pages', [PagesController::class, 'pages'])->name('pages');
  Route::get('createPages', [PagesController::class, 'createPages'])->name('page.create');
  Route::get('pagedetail/{id}', [PagesController::class, 'pagedetail'])->name('pagedetail');

  Route::post('createPagePost',[PageFeedsController::class,'createPagePost'])->name('user.createPagePost');
  Route::post('page-post-like',[PageFeedsController::class,'likePagePost'])->name('pagepost.like');
  Route::post('page-comments-store',[PageFeedsController::class,'pageCommentsStore'])->name('page-comments.store');
  Route::post('likePagePostComment/{feedId}/{userId}/{type}/{commentId}/{pageId}',[PageFeedsController::class,'likePagePostComment'])->name('pagePostComment.like');
  Route::post('image-crop-page', [PageFeedsController::class, "imageCropPagePost"])->name("imageCropPage");
// End Pages

  Route::post('addEvent',[HomeController::class,'addEvent'])->name('user.addEvent');
  Route::get('deleteScheduleEvent/{id}',[HomeController::class,'deleteScheduleEvent']);
  Route::post('registerWebinar',[HomeController::class,'registerWebinar'])->name('user.registerWebinar');

  Route::get('friendprofile', [HomeController::class, 'friendprofile'])->name('friendprofile');
  Route::get('newsfeed', [HomePagesController::class, 'newsfeed'])->name('newsfeed');
  Route::group(['prefix' => 'group'], function() {
    Route::get('create', [HomeController::class, 'createGroups'])->name('group.create');
  });
  Route::get('proimg', [HomeController::class, 'proimg'])->name('proimg');
  Route::get('provideos', [HomeController::class, 'provideos'])->name('provideos');
  Route::get('profilevent', [HomeController::class, 'profilevent'])->name('profilevent');
  Route::get('profilebadges', [HomeController::class, 'profilebadges'])->name('profilebadges');
  Route::get('profileforum', [HomeController::class, 'profileforum'])->name('profileforum');
  Route::get('accountDetails', [HomeController::class, 'accountDetails'])->name('accountDetails');
  Route::get('file', [HomeController::class, 'file'])->name('file');
  Route::get('todo', [HomeController::class, 'todo'])->name('todo');
  Route::get('calendar', [HomeController::class, 'calender'])->name('calender');
  Route::get('birthday', [HomeController::class, 'birthday'])->name('birthday');
  Route::get('weather', [HomeController::class, 'weather'])->name('weather');
  Route::get('music', [HomeController::class, 'music'])->name('music');
  Route::get('grid', [HomeController::class, 'grid'])->name('grid');
  Route::get('list', [HomeController::class, 'list'])->name('list');
  Route::get('detail', [HomeController::class, 'detail'])->name('detail');
  Route::get('checkout', [HomeController::class, 'checkout'])->name('checkout');
  Route::get('email', [HomeController::class, 'email'])->name('email');
  Route::get('emailcompose', [HomeController::class, 'emailcompose'])->name('emailcompose');
  Route::get('uielements', [HomeController::class, 'uielements'])->name('uielements');
  Route::get('uikit', [HomeController::class, 'uikit'])->name('uikit');
  Route::get('uicolor', [HomeController::class, 'uicolor'])->name('uicolor');
  Route::get('uitypo', [HomeController::class, 'uitypo'])->name('uitypo');
  Route::get('uialert', [HomeController::class, 'uialert'])->name('uialert');
  Route::get('uibadges', [HomeController::class, 'uibadges'])->name('uibadges');
  Route::get('uibreadcrumb', [HomeController::class, 'uibreadcrumb'])->name('uibreadcrumb');
  Route::get('uibutton', [HomeController::class, 'uibutton'])->name('uibutton');
  Route::get('uicard', [HomeController::class, 'uicard'])->name('uicard');
  Route::get('uicarousel', [HomeController::class, 'uicarousel'])->name('uicarousel');
  Route::get('uiemvideo', [HomeController::class, 'uiemvideo'])->name('uiemvideo');
  Route::get('uigrid', [HomeController::class, 'uigrid'])->name('uigrid');
  Route::get('uimages', [HomeController::class, 'uimages'])->name('uimages');
  Route::get('uilistitems', [HomeController::class, 'uilistitems'])->name('uilistitems');
  Route::get('uimodal', [HomeController::class, 'uimodal'])->name('uimodal');
  Route::get('uinotification', [HomeController::class, 'uinotification'])->name('uinotification');
  Route::get('uipagation', [HomeController::class, 'uipagation'])->name('uipagation');
  Route::get('uipopovers', [HomeController::class, 'uipopovers'])->name('uipopovers');
  Route::get('uiprogressbars', [HomeController::class, 'uiprogressbars'])->name('uiprogressbars');
  Route::get('uitabs', [HomeController::class, 'uitabs'])->name('uitabs');
  Route::get('uitooltips', [HomeController::class, 'uitooltips'])->name('uitooltips');
  Route::get('form', [HomeController::class, 'form'])->name('form');
  Route::get('formlayout', [HomeController::class, 'formlayout'])->name('formlayout');
  Route::get('formvalidation', [HomeController::class, 'formvalidation'])->name('formvalidation');
  Route::get('formswitch', [HomeController::class, 'formswitch'])->name('formswitch');
  Route::get('formcheckbox', [HomeController::class, 'formcheckbox'])->name('formcheckbox');
  Route::get('formradio', [HomeController::class, 'formradio'])->name('formradio');
  Route::get('wizard', [HomeController::class, 'wizard'])->name('wizard');
  Route::get('formwizard', [HomeController::class, 'formwizard'])->name('formwizard');
  Route::get('formwizardvalidate', [HomeController::class, 'formwizardvalidate'])->name('formwizardvalidate');
  Route::get('formwizardvertical', [HomeController::class, 'formwizardvertical'])->name('formwizardvertical');

  Route::get('table', [HomeController::class, 'table'])->name('table');
  Route::get('tablebasic', [HomeController::class, 'tablebasic'])->name('tablebasic');
  Route::get('datatable', [HomeController::class, 'datatable'])->name('datatable');
  Route::get('tableedit', [HomeController::class, 'tableedit'])->name('tableedit');

  Route::get('icon', [HomeController::class, 'icon'])->name('icon');
  Route::get('iconfontawsome', [HomeController::class, 'iconfontawsome'])->name('iconfontawsome');
  Route::get('iconlineawsome', [HomeController::class, 'iconlineawsome'])->name('iconlineawsome');
  Route::get('iconremixon', [HomeController::class, 'iconremixon'])->name('iconremixon');
  Route::get('iconmaterial', [HomeController::class, 'iconmaterial'])->name('iconmaterial');
  Route::get('authenticate', [HomeController::class, 'authenticate'])->name('authenticate');
  Route::get('signin', [HomeController::class, 'signin'])->name('signin');
  Route::get('signup', [HomeController::class, 'signup'])->name('signup');
  Route::get('pagerecover', [HomeController::class, 'pagerecover'])->name('pagerecover');
  Route::get('pageconfirmail', [HomeController::class, 'pageconfirmail'])->name('pageconfirmail');
  Route::get('lockscreen', [HomeController::class, 'extrapage'])->name('extrapage');
  Route::get('extrapage', [HomeController::class, 'lockscreen'])->name('lockscreen');
  Route::get('timeline', [HomeController::class, 'timeline'])->name('timeline');
  Route::get('invoice', [HomeController::class, 'invoice'])->name('invoice');
  Route::get('blankpage', [HomeController::class, 'blankpage'])->name('blankpage');
  Route::get('adminpage', [HomeController::class, 'adminpage'])->name('adminpage');
  Route::get('error', [HomeController::class, 'error'])->name('error');
  Route::get('error500', [HomeController::class, 'error500'])->name('error500');
  Route::get('pricing', [HomeController::class, 'pricing'])->name('pricing');
  Route::get('pricingone', [HomeController::class, 'pricingone'])->name('pricingone');
  Route::get('maintenance', [HomeController::class, 'maintenance'])->name('maintenance');
  Route::get('comingsoon', [HomeController::class, 'comingsoon'])->name('comingsoon');
  Route::get('faq', [HomeController::class, 'faq'])->name('faq');
  Route::get('withoutrightsidebar', [HomeController::class, 'withoutrightsidebar'])->name('withoutrightsidebar');
  Route::get('withoutleftsidebar', [HomeController::class, 'withoutleftsidebar'])->name('withoutleftsidebar');



  //blog page route
  Route::group(['prefix' => 'blog'], function() {
  Route::get('bloggrid', [HomeController::class, 'bloggrid'])->name('blog.bloggrid');
  Route::get('bloglist', [HomeController::class, 'bloglist'])->name('blog.bloglist');
  Route::get('blogdetail/{slug}', [HomeController::class, 'blogDetail'])->name('blog.blogdetail');
  });

  //blog page route
  Route::group(['prefix' => 'news'], function() {
    Route::get('newslist', [HomeController::class, 'newslist'])->name('news.newslist');
    Route::get('newsdetail/{slug}', [HomeController::class, 'newsDetail'])->name('news.newsdetail');
  });
  //Courses
  Route::get('courses-categories', [CoursesController::class, 'courseCategories'])->name('courses.categories');
  // for download certificate
  Route::post('courses-categories/certificate-download', [CoursesController::class, 'courseCertificateDownload'])->name('courseCertificateDownload');
  //
  Route::get('courses-categories/{slug}', [CoursesController::class, 'coursesList'])->name('coursesList');
  Route::post('/course/{course_slug}/enrollment', [CoursesController::class, 'courseEnrollment'])->name('courseEnrollment');
  Route::get('/coach/{course_slug}/enrollment', [CoursesController::class, 'enrollCoach'])->name('enrollCoach');
  Route::post('/courses/addToCart', [CoursesCartController::class, 'addToCart'])->name('addToCart');
  Route::get('/course/applyCoach/{course_slug}/{coach_id}/{user_id}', [CoursesController::class, 'applyCoach'])->name('applyCoach');
  Route::post('/course/apply-coach-request', [CoursesController::class, 'applyCoachRequestToAdmin'])->name('applyCoachRequest');
  Route::get('courses-categories/{cat_slug}/{course_slug}', [CoursesController::class, 'courseDetail'])->name('courseDetail');
  // Route::get('courses-categories/{cat_id}/{course_id}', [CoursesController::class, 'courseDetail'])->name('courseDetail');
  Route::get('courses-categories/{cat_slug}/{course_slug}/{module_slug}', [CoursesController::class, 'courseModuleDetail'])->name('courseModuleDetail');
  Route::get('courses-categories/{cat_slug}/{course_slug}/{module_slug}/{section_slug}', [CoursesController::class, 'courseModuleSectionDetail'])->name('courseModuleSectionDetail');
  Route::get('courses-categories/{cat_slug}/{course_slug}/{module_slug}/{section_slug}/{exercise_slug}/{parent_course_module_section_id?}', [CoursesController::class, 'courseModuleSectionExcerciseDetail'])->name('courseModuleSectionExcerciseDetail');
  Route::post('upload-exercise-file', [CoursesController::class, 'uploadExerciseFile'])->name('uploadExerciseFile');


  Route::get('my-courses', [CoursesController::class, 'myCourses'])->name('myCourses');

  Route::post('course/quiz/save', [CoursesController::class, 'courseQuizSave'])->name('courseQuizSave');

  Route::get('courses-marking-list', [CoursesController::class, 'marking'])->name('marking');
  Route::get('courses-marking-detail/{id}', [CoursesController::class, 'markingCourseDetail'])->name('markingCourseDetail');
  Route::get('exercise-marking-detail/{exercise_id}/{marking_submission_id?}', [CoursesController::class, 'markingExerciseDetail'])->name('markingExerciseDetail');
  Route::post('exercise-marking-save', [CoursesController::class, 'exerciseMark'])->name('exerciseMark');

  //Cart
  Route::get('/cart', [CoursesCartController::class, 'index'])->name('cart');
  Route::post('/courses/delete', [CoursesCartController::class, 'deleteCartItems'])->name('deleteCartItems');
  Route::post('/purchaseCourse', [CoursesCartController::class, 'purchaseCourse'])->name('purchaseCourse');
  Route::post('/applyCoupon', [CoursesCartController::class, 'applyCoupon'])->name('applyCoupon');

  //Events
  Route::get('events', [EventsController::class, 'index'])->name('events');
  Route::get('events/{id}', [EventsController::class, 'details'])->name('event.details');

  //Invoice
  Route::get('my-invoices', [InvoiceController::class, 'invoices'])->name('my-invoices');
  Route::get('invoice/{id}', [InvoiceController::class, 'details'])->name('invoice.details');


  //Jobs
  Route::get('jobs', [JobsController::class, 'listing'])->name('jobs');

  //Stock

  Route::get('stock', [HomeController::class, 'stock'])->name('stock');

  //Appointment

  Route::get('doctors', [HomeController::class, 'appointment'])->name('doctors');


  Route::get('webinars', [HomeController::class, 'webinars'])->name('webinars');
  Route::get('myWebinars', [HomeController::class, 'myWebinars'])->name('myWebinars');
  Route::get('webinardetail/{slug}', [HomeController::class, 'webinarDetail'])->name('webinar.webinardetail');

  Route::get('speakers', [HomeController::class, 'speakers'])->name('speakers');
  Route::get('speakerdetail/{slug}', [HomeController::class, 'speakerDetail'])->name('speaker.speakerdetail');

  Route::get('signature', [HomeController::class, 'signature'])->name('signature');
  Route::post('createSignature',[HomeController::class,'createSignature'])->name('createSignature');
  
  Route::get('my-pets', [PetOfTheMonthController::class, 'index'])->name('my-pets');
  Route::get('pet-of-the-month', [PetOfTheMonthController::class, 'petOfTheMonth'])->name('pet-of-the-month');
  Route::get('petdetail/{id}', [PetOfTheMonthController::class, 'petDetail'])->name('pet.petdetail');
  Route::post('sharePet', [PetOfTheMonthController::class, 'sharePet'])->name('pet.sharePet');
  Route::post('pet-badge-request/{slug}', [PetOfTheMonthController::class, 'petBadgeRequest'])->name('pet.petBadgeRequest');
  Route::post('pet-of-the-month-request/{id}', [PetOfTheMonthController::class, 'petOfTheMonthRequest'])->name('pet.petOfTheMonthRequest');
  Route::post('pet-polling', [PetOfTheMonthController::class, 'petPolling'])->name('pet.polling');



  //Team
  Route::get('team', [TeamController::class, 'index'])->name('team');
  Route::post('team/add-colleague', [TeamController::class, 'addColleague'])->name('team.addColleague');
  Route::get('team/change-coach/{id}', [TeamController::class, 'changeCoach'])->name('team.changeCoach');
  Route::get('team/profile/detail/{id}', [TeamController::class, 'profileDetail'])->name('team.profileDetail');
  // Route::get('team/user/remove/{id}', [TeamController::class, 'removeUser'])->name('team.removeUser');
  Route::get('team/user/restore/{id}', [TeamController::class, 'restoreUser'])->name('team.restoreUser'); //for restore team

  //store page route
  Route::group(['prefix' => 'store'], function() {
    Route::get('grid', [HomeController::class, 'grid'])->name('store.grid');
    Route::get('list', [HomeController::class, 'list'])->name('store.list');
    Route::get('detail', [HomeController::class, 'detail'])->name('store.detail');
    Route::get('checkout', [HomeController::class, 'checkout'])->name('store.checkout');
  });

  //mail pages route
  Route::group(['prefix' => 'mailbox'], function() {
    Route::get('email', [HomeController::class, 'email'])->name('mailbox.email');
    Route::get('emailcompose', [HomeController::class, 'emailcompose'])->name('mailbox.emailcompose');
  });
  //market pages route
  Route::group(['prefix' => 'market'], function() {
    Route::get('market1', [HomeController::class, 'market1'])->name('market.market1');
    Route::get('market2', [HomeController::class, 'market2'])->name('market.market2');
  });
  Route::group(['prefix' => 'profile'], function() {
    Route::get('profile1', [HomeController::class, 'profile1'])->name('profile.profile1');
    Route::get('profile2', [HomeController::class, 'profile2'])->name('profile.profile2');
    Route::get('profile3', [HomeController::class, 'profile3'])->name('profile.profile3');
  });

  //ui pages
  Route::group(['prefix' => 'ui'], function() {
    //form pages
    Route::get('formcheckbox', [HomeController::class, 'formcheckbox'])->name('ui.formcheckbox');
    Route::get('formlayout', [HomeController::class, 'formlayout'])->name('ui.formlayout');
    Route::get('formradio', [HomeController::class, 'formradio'])->name('ui.formradio');
    Route::get('formswitch', [HomeController::class, 'formswitch'])->name('ui.formswitch');
    Route::get('formvalidation', [HomeController::class, 'formvalidation'])->name('ui.formvalidation');

    //wizard pages
    Route::get('formwizard', [HomeController::class, 'formwizard'])->name('ui.formwizard');
    Route::get('formwizardvalidate', [HomeController::class, 'formwizardvalidate'])->name('ui.formwizardvalidate');
    Route::get('formwizardvertical', [HomeController::class, 'formwizardvertical'])->name('ui.formwizardvertical');

    //table pages
    Route::get('tablebasic', [HomeController::class, 'tablebasic'])->name('ui.tablebasic');
    Route::get('datatable', [HomeController::class, 'datatable'])->name('ui.datatable');
    Route::get('tableedit', [HomeController::class, 'tableedit'])->name('ui.tableedit');

    //icon pages
    Route::get('iconfontawsome', [HomeController::class, 'iconfontawsome'])->name('ui.iconfontawsome');
    Route::get('iconlineawsome', [HomeController::class, 'iconlineawsome'])->name('ui.iconlineawsome');
    Route::get('iconremixon', [HomeController::class, 'iconremixon'])->name('ui.iconremixon');

    //uipages
    Route::get('uitypography', [HomeController::class, 'uitypography'])->name('ui.uitypography');
    Route::get('uialert', [HomeController::class, 'uialert'])->name('ui.uialert');
    Route::get('uicolor', [HomeController::class, 'uicolor'])->name('ui.uicolor');
    Route::get('uibadges', [HomeController::class, 'uibadges'])->name('ui.uibadges');
    Route::get('uibreadcrumb', [HomeController::class, 'uibreadcrumb'])->name('ui.uibreadcrumb');
    Route::get('uibutton', [HomeController::class, 'uibutton'])->name('ui.uibutton');
    Route::get('uicard', [HomeController::class, 'uicard'])->name('ui.uicard');
    Route::get('uicarousel', [HomeController::class, 'uicarousel'])->name('ui.uicarousel');
    Route::get('uigrid', [HomeController::class, 'uigrid'])->name('ui.uigrid');
    Route::get('uiemvideo', [HomeController::class, 'uiemvideo'])->name('ui.uiemvideo');
    Route::get('uiimages', [HomeController::class, 'uiimages'])->name('ui.uiimages');
    Route::get('uilistitems', [HomeController::class, 'uilistitems'])->name('ui.uilistitems');
    Route::get('uimodal', [HomeController::class, 'uimodal'])->name('ui.uimodal');
    Route::get('uinotification', [HomeController::class, 'uinotification'])->name('ui.uinotification');
    Route::get('uipagination', [HomeController::class, 'uipagination'])->name('ui.uipagination');
    Route::get('uipopovers', [HomeController::class, 'uipopovers'])->name('ui.uipopovers');
    Route::get('uiprogressbars', [HomeController::class, 'uiprogressbars'])->name('ui.uiprogressbars');
    Route::get('uitabs', [HomeController::class, 'uitabs'])->name('ui.uitabs');
    Route::get('uitooltips', [HomeController::class, 'uitooltips'])->name('ui.uitooltips');
  });

  //pages
  Route::group(['prefix' => 'pages'], function() {
    //page
    Route::get('signin', [HomeController::class, 'signin'])->name('pages.signin');
    Route::get('signup', [HomeController::class, 'signup'])->name('pages.signup');
    Route::get('pagerecover', [HomeController::class, 'pagerecover'])->name('pages.pagerecover');
    Route::get('pageconfirmail', [HomeController::class, 'pageconfirmail'])->name('pages.pageconfirmail');
    Route::get('lockscreen', [HomeController::class, 'lockscreen'])->name('pages.lockscreen');

    //extrapage
    Route::get('timeline', [HomeController::class, 'timeline'])->name('pages.timeline');
    Route::get('invoice', [HomeController::class, 'invoice'])->name('pages.invoice');
    Route::get('blankpage', [HomeController::class, 'blankpage'])->name('pages.blankpage');
    Route::get('error', [HomeController::class, 'error'])->name('pages.error');
    Route::get('error500', [HomeController::class, 'error500'])->name('pages.error500');
    Route::get('pricing', [HomeController::class, 'pricing'])->name('pages.pricing');
    Route::get('pricingone', [HomeController::class, 'pricingone'])->name('pages.pricingone');
    Route::get('maintenance', [HomeController::class, 'maintenance'])->name('pages.maintenance');
    Route::get('comingsoon', [HomeController::class, 'comingsoon'])->name('pages.comingsoon');
    Route::get('faq', [HomeController::class, 'faq'])->name('pages.faq');
  });


  Route::get('all-clear', function () {
    Artisan::call('optimize:clear');
    Artisan::call('optimize');

    Artisan::call('route:cache');
    Artisan::call('route:clear');

    Artisan::call('view:clear');

    Artisan::call('config:cache');
    Artisan::call('config:clear');

    Artisan::call('cache:clear');
    dd("All commands run and data cleared");
  });
  Route::get('privacy-policy', [HomeController::class, 'privacypolicy'])->name('footer.privacypolicy');
  Route::get('terms-of-use', [HomeController::class, 'termsofservice'])->name('footer.termsofservice');
  Route::get('about-us', [HomeController::class, 'aboutus'])->name('footer.aboutus');
  Route::get('our-vision', [HomeController::class, 'ourvision'])->name('footer.ourvision');
  Route::get('customer-support', [HomeController::class, 'customerSupport'])->name('footer.customersupport');
});
//footer pages
  // Route::group(['prefix' => 'terms'], function() {
    
    // });
    Route::post('contactSupport',[HomeController::class,'contactSupport'])->name('user.contactSupport');
    Route::get('allow-user/{email}',[UserController::class,'allowUser'])->name('user.allowuser');
//modules
if (file_exists(__DIR__.'/modules/chat.php')) require __DIR__.'/modules/chat.php';


Route::fallback(function () {
  return view('pages.error');
});
