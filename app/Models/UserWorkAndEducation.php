<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkAndEducation extends Model
{
    use HasFactory;
    protected $table = 'user_work_and_educations';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','type','name', 'title', 'city', 'current_status', 'from_year', 'to_year'];
}
