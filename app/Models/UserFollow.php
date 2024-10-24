<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getUserDetails(){
        return $this->belongsTo(Customer::class, 'following_user_id')->where( 'soft_delete', '!=', 1);
    }
    public function getUserDetailsFollowing(){
        return $this->belongsTo(User::class, 'following_user_id')->where( 'soft_delete', '!=', 1);
    }
    public function getUserDetailsFollowers(){
        return $this->belongsTo(User::class, 'user_id')->where( 'soft_delete', '!=', 1);
    }
    public function getFollowerDetails(){
        return $this->belongsTo(User::class, 'user_id', 'id')->where( 'soft_delete', '!=', 1);
    }
}
