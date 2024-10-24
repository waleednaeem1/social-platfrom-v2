<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blocked_users';

    protected $guarded = [];

    public function getUserDataSelectedColumns(){
        return $this->belongsTo(User::class, 'blocked_user_id', 'id')->select('id','first_name','last_name','name','username','avatar_location');
    }
}
