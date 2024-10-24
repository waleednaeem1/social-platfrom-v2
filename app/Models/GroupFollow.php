<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupFollow extends Model
{
    use HasFactory;

    protected $table = 'group_follows';

    protected $fillable = ['group_id','user_id','created_at','updated_at'];
}
