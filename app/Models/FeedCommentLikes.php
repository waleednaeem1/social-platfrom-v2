<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedCommentLikes extends Model
{
    use HasFactory;

    protected $table = 'comment_likes';

    protected $fillable = ['id','comment_id','user_id','like_type','status','created_at','updated_at'];

    public function getUserData(){
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $hidden = [ 'created_at', 'updated_at' ];
}
