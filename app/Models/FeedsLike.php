<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedsLike extends Model
{
    use HasFactory;

    protected $table = 'feeds_likes';

    protected $fillable = ['user_id','feed_id','like_type','status','created_at','updated_at'];

    public function getUserData(){
        return $this->belongsTo(User::class, 'user_id')->where( 'soft_delete', '!=', 1);
    }

    protected $hidden = [ 'created_at', 'updated_at' ];
}
