<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHobbies extends Model
{
    use HasFactory;
    protected $table = 'user_hobbies';
    protected $fillable = ['hobbies','status', 'created_at', 'updated_at'];
}
