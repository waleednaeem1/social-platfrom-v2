<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupFeedComment extends Model
{
    use HasFactory;

    protected $table = 'groups_feeds_comments';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = ['user_id','groups_feed_id','parent_id','comment','status','created_at','updated_at'];

    protected $appends = ['time'];

    public function getTimeAttribute(){ 
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getUserData(){
        return $this->belongsTo(User::class, 'user_id')->where( 'soft_delete', '!=', 1);
    }

    public function commentLikes(){
        return $this->hasMany(GroupFeedCommentLikes::class, 'comment_id');
    }

    public function getReplies(){
        $user = auth()->user();
        if(isset($user)){
            $blockedFriends = BlockedUser::where('user_id', $user->id)->pluck('blocked_user_id')->toArray();
            $blockedOtherFriends = BlockedUser::where('blocked_user_id', $user->id)->pluck('user_id')->toArray();
            return $this->hasMany(GroupFeedComment::class, 'parent_id', 'id')->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends))->with('commentLikes');
        }else{
            return $this->hasMany(GroupFeedComment::class, 'parent_id', 'id');
        }
    }

    public function groupFeedCommentReplies(){
        return $this->getReplies()->with('groupFeedCommentReplies')->with('getUserData:id,first_name,last_name,avatar_location,username');
    }
    
}