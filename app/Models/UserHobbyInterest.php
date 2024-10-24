<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHobbyInterest extends Model
{
    use HasFactory;
    protected $table = 'user_hobbies_interests';
    protected $guarded = [];
    protected $primaryKey = 'id';
}
