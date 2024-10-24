<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feed;
use App\Models\StoryViewed;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StoryController extends Controller
{
    public function viewedStories(Request $request){
        $user = User::find($request->user_id);
        $storiesArray = $request->stories;
        $userId = $request->user_id;
        if(!$user){
            return response()->json(['message' =>'User does not exists.', 'success' => false], 201);
        }
        if(isset($storiesArray) && count($storiesArray)>0){
            foreach($storiesArray as $storyId){
                $feed = Feed::find($storyId);
                if($feed && $feed->user_id != $userId){
                    StoryViewed::firstOrCreate([
                        'feed_id'=> $storyId,
                        'user_id'=> $userId
                    ]);
                }
            }
            return response()->json(['message' =>'Stories viewed sucessfully.', 'success' => true], 200);
        }else{
            return response()->json(['message' =>'Stories count is not greater than 0.', 'success' => false], 200);
        }
    }


public function storyViewedUsers($storyId)
{
    $stories = StoryViewed::where('feed_id', $storyId)->pluck('user_id')->toArray();
    $usersData = User::join('stories_viewed', 'users.id', '=', 'stories_viewed.user_id')
        ->whereIn('users.id', $stories)
        ->select([
            'users.id',
            'users.first_name',
            'users.last_name',
            'users.avatar_location',
            'users.cover_image',
            'users.username',
            \DB::raw('MAX(stories_viewed.created_at) as viewed_created_at'),
        ])
        ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.avatar_location', 'users.cover_image', 'users.username') // Include all selected columns in GROUP BY
        ->orderBy('viewed_created_at', 'desc')
        ->get();

    $usersData->map(function ($user) {
        $user->time = Carbon::parse($user->viewed_created_at)->diffForHumans();
        return $user;
    });

    return response()->json(['success' => true, 'data' => $usersData], 200);
}

    

}
