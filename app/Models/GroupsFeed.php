<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupsFeed extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vt_groups_feeds';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getUser(){
        return $this->belongsTo(User::class, 'user_id')->where( 'soft_delete', '!=', 1);
    }

    public function comments(){
        $user = auth()->user();
        if(isset($user)){
            $blockedFriends = BlockedUser::where('user_id', $user->id)->pluck('blocked_user_id')->toArray();
            $blockedOtherFriends = BlockedUser::where('blocked_user_id', $user->id)->pluck('user_id')->toArray();
            return $this->hasMany(GroupFeedComment::class)->where('parent_id', 0)->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends));
        }else{
            return $this->hasMany(GroupFeedComment::class)->where('parent_id', 0);
        }
    }

    public function likes(){
        $user = auth()->user();
        if(isset($user)){
            $blockedFriends = BlockedUser::where('user_id', $user->id)->pluck('blocked_user_id')->toArray();
            $blockedOtherFriends = BlockedUser::where('blocked_user_id', $user->id)->pluck('user_id')->toArray();
            return $this->hasMany(GroupFeedLike::class)->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends));
        }else{
            return $this->hasMany(GroupFeedLike::class);
        }
    }
    public function attachments(){
        return $this->hasMany(GroupFeedAttachment::class);
    }

    public function groupDetails(){
        return $this->belongsTo(Group::class, 'group_id');
    }

    // public function shareFeed(){
    //     return $this->belongsTo(ShareFeed::class, 'groups_feed_id', 'id');
    // }

    public function shareFeed(){
        return $this->belongsTo(ShareFeed::class, 'share_feed_id', 'id');
    }
}