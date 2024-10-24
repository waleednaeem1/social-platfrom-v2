<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteFeed extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getFeedData(){
        return $this->belongsTo(Feed::class, 'feed_id');
    }
    public function getUser(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getGroupFeedData(){
        return $this->belongsTo(GroupsFeed::class, 'feed_id');
    }
    public function getPageFeedData(){
        return $this->belongsTo(PagesFeed::class, 'feed_id');
    }
}
