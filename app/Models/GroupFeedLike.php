<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupFeedLike extends Model
{
    use HasFactory;

    protected $table = 'groups_feeds_likes';

    protected $fillable = ['user_id','groups_feed_id','like_type','status','created_at','updated_at'];

    public function getUserData(){
        return $this->belongsTo(User::class, 'user_id')->where( 'soft_delete', '!=', 1);
    }

    protected $hidden = [ 'created_at', 'updated_at' ];
}