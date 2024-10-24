<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareFeed extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'share_feed';

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
    
    public function shareFeedData()
    {
        return $this->belongsTo(Feed::class, 'feed_id', 'id');
    }
    
    public function shareGroupFeedData()
    {
        return $this->belongsTo(GroupsFeed::class, 'groups_feed_id', 'id');
    }
    
    public function sharePageFeedData()
    {
        return $this->belongsTo(PagesFeed::class, 'pages_feed_id', 'id');
    }
}
