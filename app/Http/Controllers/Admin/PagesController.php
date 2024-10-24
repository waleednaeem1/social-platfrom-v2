<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PagesFeed;
use App\Models\PageFeedAttachment;
use App\Models\PageMembers;
use App\Models\BlockedUser;
use App\Models\Notifications;
use App\Models\PageRequests;
use Illuminate\Support\Facades\DB;


class PagesController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Pages';
        $pages   = Page::searchable(['page_name'])->orderBy('page_name')->paginate(getPaginate());
        return view('admin.pages.index', compact('pageTitle', 'pages'));
    }

    public function leavePage(Request $request)
    {
        $pageMember = PageMembers::where(['user_id'=> $request->userId,'page_id'=> $request->pageId])->first();
        if ($pageMember) {
            $deleteMember =  $pageMember->delete();
        }
        if($request->type == 'detailpage'){
            return redirect()->route('pagedetail',['id' => $request->pageId]);
        }
        return response()->json(['memberDeleted' => $deleteMember], 200);
    }

    public function unlike_page(Request $request)
    {
        $page = Page::where(['id'=> $request->pageId])->first();
        if($page && $page->page_type !== 'Private'){
            $pageMember = PageMembers::where(['user_id'=> $request->userId,'page_id'=> $request->pageId])->first();
            $deleteMember =  $pageMember->delete();
            return response()->json(['message' => 'unlike successfully','alreadyLiked' => 0,'Private' => 0], 200);
        }else{
            $pageRequest = PageRequests::where(['user_id'=> $request->userId,'page_id'=> $request->pageId])->first();
            $pageRequest =  $pageRequest->delete();
            return response()->json(['message' => 'Page Member Request Deleted','alreadyLiked' => 0,'Private' => 1], 200);
        }
        if($request->type == 'detailpage'){
            return redirect()->route('pagedetail',['id' => $request->pageId]);
        }
        return redirect()->route('pagedetail',['id' => $request->pageId]);
    }

    public function pages()
    {
        $user = auth()->user();
        $data['pages'] = Page::with('pageMembers')->where(['status' => 'Y'])->get();
        return view('dashboards.page',compact('data'));
    }

    public function createPages()
    {
        $data['pageCategories'] = DB::table('page_categories')->get();
        return view('page.page',compact('data'));
    }

    public function createPage(Request $request)
    {
        $allcategories = implode(', ',$request->category);
        $page = [
            'admin_user_id' => auth()->user()->id,
            'page_name' => $request->pageName,
            'category' => $allcategories,
            'bio' => $request->bio,
        ];

        $newPage = Page::create($page);
        $newPageId = Page::orderBy('id', 'desc')->first();
        $pageMember = [
            'page_id' => $newPage->id,
            'user_id' => auth()->user()->id,
            'status' => 'Y',
        ];
        $member = PageMembers::create($pageMember);
        return response()->json(['message' => 'Page Created!', 'pageId' => $newPageId->id], 200);
        // return redirect()->route('pagedetail',['id' => $newPage->id])->withFlashSuccess(__('Page Created Successfully.'));
    }

    public function editPage($id)
    {
        $user = auth()->user();
        $blockedFriends = BlockedUser::Where('user_id', $user->id)->pluck( 'blocked_user_id')->toArray();
        $blockedOtherFriends = BlockedUser::Where('blocked_user_id', $user->id)->pluck( 'user_id')->toArray();

        $data['pageDetail'] = Page::with(['pageMembers' => function ($query) use ($blockedFriends, $blockedOtherFriends) {
            $query->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends));
        }])->where(['status' => 'Y', 'id' => $id])->get();

        $data['checkMember'] = PageMembers::where(['user_id'=> auth()->user()->id,'page_id'=>$id])->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends))->first();
        $data['checkMemberCount'] = PageMembers::where(['page_id'=>$id])->count();
        return view('dashboards.pageedit',compact('data'));
    }

    public function deletePage($id)
    {
        $pageFeeds = PagesFeed::where('page_id', $id)->get();
        if(isset($pageFeeds)){
            $feedIds = $pageFeeds->pluck('id')->toArray();
            $feedAttachments = PageFeedAttachment::whereIn('pages_feed_id', $feedIds)->delete();
            $pageFeeds = PagesFeed::whereIn('id', $feedIds)->delete();
        }
        Notifications::where(['page_id'=> $id])->whereIn('notification_type', ['like_page', 'page_feed_like', 'page_feed_comment', 'page_feed_comment_like'])->delete();
        $page = Page::find($id)->delete();
        return redirect()->route('home')->withFlashSuccess(__('Page Deleted Successfully.'));
    }

    public function likePage(Request $request)
    {
        $check = PageMembers::where(['page_id'=> $request->pageId,'user_id'=> $request->userId])->first();
        if($check){
            if($request->type == 'detailpage'){
                return redirect()->route('pagedetail',['id' => $request->pageId]);
            }
            return response()->json(['message' => ' You have already liked this page.','alreadyLiked' => 1], 200);
        }else{
            $pageData = Page::find($request->pageId);
            if($pageData->page_type == 'Private'){
                $pageRequestCheck = PageRequests::where(['user_id'=>$request->userId, 'page_id'=>$request->pageId, 'status'=>'pending'])->first();
                if(!isset($pageRequestCheck)){
                    $data = [
                        'user_id' => $request->userId,
                        'admin_user_id' => $pageData->admin_user_id,
                        'page_id' => $request->pageId,
                        'status' => 'pending',
                    ];
                    $groupRequestsData = PageRequests::create($data);

                    $notificationMessage = ' like request for the '.$pageData->page_name.' page. ';
                    Notifications::sendPrivatepageNotification($pageData->admin_user_id, auth()->user()->id, $request->pageId, 'pagedetail/'.$request->pageId, 'Like Request Private Page', 'like_page_private_request', $notificationMessage);
                }
                return response()->json(['message' => 'Request Sent. You will be added as a member when admin will approve it.','alreadyLiked' => 0,'Private' => 1], 200);
            }
            else{
                $pageMembers = new PageMembers;
                $pageMembers->page_id = $request->pageId;
                $pageMembers->user_id = $request->userId;
                $pageMembers->status = 'Y';
                $pageMembers->save();


                $notificationMessage = ' liked the '.$pageData->page_name.' page. ';
                Notifications::sendLikePageNotification($pageData->admin_user_id, auth()->user()->id, $request->pageId, 'pagedetail/'.$request->pageId, 'Like Page', 'like_page', $notificationMessage);
                if($request->type == 'detailpage'){
                    return redirect()->route('pagedetail',['id' => $request->pageId]);
                }
            }




            return response()->json(['message' => 'Page liked successfully.','alreadyLiked' => 0,'Private' => 0], 200);
        }
    }

    public function pagedetail(Request $request)
    {
        $user = auth()->user();
        $blockedFriends = BlockedUser::Where('user_id', $user->id)->pluck( 'blocked_user_id')->toArray();
        $blockedOtherFriends = BlockedUser::Where('blocked_user_id', $user->id)->pluck( 'user_id')->toArray();

        $data['pageDetail'] = Page::with(['pageMembers' => function ($query) use ($blockedFriends, $blockedOtherFriends) {
            $query->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends));
        }])->where(['status' => 'Y', 'id' => $request->id])->get();
        if($data['pageDetail']->isEmpty()){
            return view('pages.error',compact('data'));
        }
        $data['checkMember'] = PageMembers::where(['user_id'=> auth()->user()->id,'page_id'=>$request->id])->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends))->first();
        $data['checkMemberCount'] = PageMembers::where(['page_id'=>$request->id])->count();
        $index = 0;
        $data['feeds'] = PagesFeed::with('getUser:id,first_name,last_name,avatar_location,cover_image,username')->with('attachments')->with('comments.getUserData')->with('comments.getReplies.getUserData')->with('comments.commentLikes')->with('likes.getUserData')->where(['status' => 'Y', 'page_id' => $request->id, 'is_deleted' => 0])->orderBy('created_at', 'DESC')->get();
        $data['pageName'] = 'pageDetail';
        return view('dashboards.pagedetail',compact('data'));
    }
}
