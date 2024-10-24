<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $table = 'friends';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'friend_id',
        'created_at',
        'updated_at'
    ];
    public function getUserDataSelectedColumns(){
        return $this->belongsTo(Customer::class, 'friend_id')->select('id','first_name','last_name','name','username','avatar_location');
    }
    public function getuser(){
        return $this->belongsTo(User::class, 'friend_id')->select('id','first_name','last_name','cover_image','avatar_location', 'name','username', 'address')->where( 'soft_delete', '!=', 1);
    }
    public function getUserData(){
        return $this->belongsTo(User::class, 'friend_id')->where( 'soft_delete', '!=', 1);
    }

    public static function getfriendRecord($user_id, $friend_id)
    {
        $friend = Self::where(['user_id' => $user_id, 'friend_id' => $friend_id])->first();
        if($friend){
            return true;
        }else{
            false;
        }
    }
}
