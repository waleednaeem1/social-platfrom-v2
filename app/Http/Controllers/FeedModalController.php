<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PagesFeed;
use App\Models\PageFeedAttachment;
use App\Models\GroupsFeed;
use App\Models\Friend;
use App\Models\FeedAttachment;
use App\Models\GroupFeedAttachment;
use App\Models\Feed;
use App\Models\FriendRequest;

class FeedModalController extends Controller
{
    public function feedDataGetModal(Request $request){
        if($request->slug == 'newsFeedLikes'){
            
            $data['userAuthId'] = auth()->user()->id;

            if($request->feedDetail == 'pageDetails'){
                $data['feeds'] = PagesFeed::with('getUser')->with('likes.getUserData')->with('pageDetails')->where(['id' => $request->feedId])->first();
            }
            elseif($request->feedDetail == 'groupDetails'){
                $data['feeds'] = GroupsFeed::with('getUser')->with('groupDetails')->with('likes.getUserData')->where(['id' => $request->feedId])->first();
            }
            elseif($request->feedDetail == 'profileFeed'){
                $data['feeds'] = Feed::with('getUser')->with('likes.getUserData')->with('comments.commentLikes')->where(['id' => $request->feedId])->first();
            }else{
                return response()->json(['success' => false, ], 201);
            }

            $datauserLikeFriend = [];
            $datauserLikeFriendRequest = [];
            foreach($data['feeds']['likes'] as $key => $likeFriendUser){
                $datauserLikeFriend[$key] = Friend::whereIn('user_id', [$likeFriendUser->user_id, auth()->user()->id])->whereIn('friend_id', [$likeFriendUser->user_id, auth()->user()->id])->first();
                $datauserLikeFriendRequest[$key] = FriendRequest::whereIn('user_id', [$likeFriendUser->user_id, auth()->user()->id])->whereIn('friend_id', [$likeFriendUser->user_id, auth()->user()->id])->where('status', 'pending')->first();
            }
            $data['friendList'] = $datauserLikeFriend;
            $data['friendRequestList'] = $datauserLikeFriendRequest;

            // dd($data);

            return response()->json(['success' => true, 'postType' => $request->slug, 'data' => $data]);
        }
        if($request->slug == 'newsFeedComments'){
            $data['userAuthId'] = auth()->user()->id;
            if($request->feedDetail == 'pageDetails'){
                $data['feeds'] = PagesFeed::with('getUser')->with('attachments')->with('comments.getUserData')->with('comments.getReplies.getUserData')->with('comments.commentLikes')->with('likes.getUserData')->with('pageDetails')->where(['id' => $request->feedId])->first();
            }
            elseif($request->feedDetail == 'groupDetails'){
                $data['feeds'] = GroupsFeed::with('getUser')->with('attachments')->with('comments.getUserData')->with('comments.getReplies.getUserData')->with('comments.commentLikes')->with('groupDetails')->with('likes.getUserData')->where(['id' => $request->feedId])->first();
            }
            elseif($request->feedDetail == 'profileFeed'){
                $data['feeds'] = Feed::with('getUser')->with('attachments')->with('comments.getUserData')->with('comments.getReplies')->with('likes.getUserData')->with('comments.commentLikes')->where(['id' => $request->feedId])->first();
            }else{
                return response()->json(['success' => false, ], 201);
            }

            return response()->json(['success' => true, 'postType' => $request->slug, 'data' => $data]);
        }
        if($request->slug == 'editFeed' || $request->slug == 'shareFeed'){
            if($request->feedDetail == 'pageDetails'){
                $formAction = 'createGroupAndPagePost';
                $feedType = 'pagefeed';
                $data['userAuthId'] = auth()->user()->id;
                $data['userAuth'] = auth()->user();
                $data['feeds'] = PagesFeed::with('getUser')->with('attachments')->with('pageDetails')->where(['id' => $request->feedId])->first();
                return response()->json(['success' => true, 'postType' => $request->slug, 'data' => $data, 'formAction' => $formAction, 'feedType' => $feedType]);
            }
            elseif($request->feedDetail == 'groupDetails'){
                $feedType = 'groupfeed';
                $formAction = 'createGroupAndPagePost';
                $data['userAuthId'] = auth()->user()->id;
                $data['userAuth'] = auth()->user();
                $data['feeds'] = GroupsFeed::with('getUser')->with('attachments')->where(['id' => $request->feedId])->first();
                return response()->json(['success' => true, 'postType' => $request->slug, 'data' => $data, 'formAction' => $formAction, 'feedType' => $feedType]);
            }
            elseif($request->feedDetail == 'profileFeed'){
                $feedType = 'profilefeed';
                $formAction = 'createProfileTimelineFeed';
                $data['userAuthId'] = auth()->user()->id;
                $data['userAuth'] = auth()->user();
                $data['feeds'] = Feed::with('getUser')->with('attachments')->where(['id' => $request->feedId])->first();
                return response()->json(['success' => true, 'postType' => $request->slug, 'data' => $data, 'formAction' => $formAction, 'feedType' => $feedType]);
            }else{
                return response()->json(['success' => false, 'postType' => null, 'data' => null, 'formAction' => null, 'feedType' => null]);
            }
        }
    }

    public function deleteFeedAttachments(Request $request)
    {
        $feedAttachmentId = $request->feedAttachmentId;
        $typeAttachment = $request->typeAttachment;
        if($typeAttachment == 'pageAttachment'){
            $data['feeds'] = PageFeedAttachment::find($feedAttachmentId);
            $data['feeds']->delete();
            $feed_id = $data['feeds']->pages_feed_id;
            $feedType = 'pagefeed';
        }
        elseif($typeAttachment == 'groupAttachment'){
            $data['feeds'] = GroupFeedAttachment::find($feedAttachmentId);
            $data['feeds']->delete();
            $feed_id = $data['feeds']->groups_feed_id;
            $feedType = 'groupfeed';
        }else{
            $data['feeds'] = FeedAttachment::find($feedAttachmentId);
            $data['feeds']->delete();
            $feed_id = $data['feeds']->feed_id;
            $feedType = 'profilefeed';
        }
        return response()->json(['success' => true, 'data' =>$data, 'message' => 'Feed attachment deleted successfully.', 'feedType' => $feedType, 'feed_id' => $feed_id], 200);
    }
    
}
