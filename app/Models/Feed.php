<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feeds';

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
    public function getFeedUser(){
        return $this->belongsTo(User::class, 'user_id')->select('id','avatar_location', 'username', 'first_name', 'last_name')->where( 'soft_delete', '!=', 1);
    }

    public function comments(){
        $user = auth()->user();
        if(isset($user)){
            $blockedFriends = BlockedUser::where('user_id', $user->id)->pluck('blocked_user_id')->toArray();
            $blockedOtherFriends = BlockedUser::where('blocked_user_id', $user->id)->pluck('user_id')->toArray();
    
            return $this->hasMany(FeedComment::class)->where('parent_id', 0)->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends));
        }else{
            return $this->hasMany(FeedComment::class)->where('parent_id', 0);
        }
    }

    public function likes(){
        $user = auth()->user();
        if(isset($user)){
            $blockedFriends = BlockedUser::where('user_id', $user->id)->pluck('blocked_user_id')->toArray();
            $blockedOtherFriends = BlockedUser::where('blocked_user_id', $user->id)->pluck('user_id')->toArray();

            return $this->hasMany(FeedsLike::class)->whereNotIn('user_id', array_merge($blockedFriends, $blockedOtherFriends));
        }else{
            return $this->hasMany(FeedsLike::class);
        }
        
    }
    public function attachments(){
        return $this->hasMany(FeedAttachment::class);
    }
    
    public function getFavFeed(){
        return $this->hasMany(FavouriteFeed::class, 'feed_id');
    }
    public function getReportFeed(){
        return $this->hasMany(FeedReport::class, 'feed_id');
    }
    public function blockedUser()
    {
        return $this->belongsTo(BlockedUser::class, 'user_id', 'blocked_user_id');
    }
    
    public function shareFeed(){
        return $this->belongsTo(ShareFeed::class);
    }
}
