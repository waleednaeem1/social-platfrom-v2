<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowRequest extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'follow_requests';
    public function getRequestSender(){
        return $this->belongsTo(Customer::class, 'friend_id')->select(['id','first_name', 'last_name','username','avatar_location' ]);
    }
}
