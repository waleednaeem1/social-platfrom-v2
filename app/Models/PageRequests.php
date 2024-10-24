<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageRequests extends Model
{
    use HasFactory;

    protected $table = 'vt_page_requests';

    protected $fillable = ['user_id','admin_user_id','page_id','status','created_at','updated_at'];
}