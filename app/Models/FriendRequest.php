<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;
    protected $table = 'friend_request';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function getRequestSender(){
        return $this->belongsTo(User::class, 'user_id')->select(['id','first_name', 'last_name','username','avatar_location' ])->where( 'soft_delete', '!=', 1);
    }
    public function getuser(){
        return $this->belongsTo(User::class, 'friend_id')->select(['id','first_name', 'last_name','username','avatar_location' ])->where( 'soft_delete', '!=', 1);
    }

    public static function getfriendRequestRecord($user_id, $friend_id)
    {
        $friend = Self::where(['user_id' => $user_id, 'friend_id' => $friend_id])->where('status', 'pending')->first();
        if($friend){
            return true;
        }else{
            false;
        }
    }
}
