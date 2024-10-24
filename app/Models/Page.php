<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Searchable;

class Page extends Model
{
    use HasFactory, Searchable;

    protected $table = 'vt_pages';

    protected $fillable = ['admin_user_id','page_name','bio','category','profile_image','cover_image','total_members','total_post','page_type','status','created_at','updated_at'];

    public function getUser(){
        return $this->belongsTo(User::class, 'user_id')->where( 'soft_delete', '!=', 1);
    }
    public function pageAdminUser(){
        return $this->belongsTo(User::class, 'admin_user_id')->select('id','username')->where( 'soft_delete', '!=', 1);
    }
    public function pageMembers(){
        return $this->hasMany(PageMembers::class)->with('getUser:id,first_name,last_name,avatar_location,cover_image,username');
    }

    public function pageMembersData(){
        return $this->hasMany(PageMembers::class);
    }
}
