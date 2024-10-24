<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlaceLive extends Model
{
    use HasFactory;
    protected $table = 'user_place_lives';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','current_city', 'home_town', 'move_year', 'move_month'];
}
