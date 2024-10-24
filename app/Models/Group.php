<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Searchable;

class Group extends Model
{
    use HasFactory, Searchable;


    protected $table = 'vt_groups';

    protected $fillable = ['admin_user_id','group_name','short_description','profile_image','cover_image','total_members','total_post','group_type','status','created_at','updated_at'];

    public function getUser(){
        return $this->belongsTo(User::class, 'user_id')->where( 'soft_delete', '!=', 1);
    }
    public function groupAdminUser(){
        return $this->belongsTo(User::class, 'admin_user_id')->select('id','username')->where( 'soft_delete', '!=', 1);
    }

    public function groupMembers(){
        return $this->hasMany(GroupMembers::class)->with('getUser:id,first_name,last_name,avatar_location,cover_image,username');
    }

    public function groupMembersData(){
        return $this->hasMany(GroupMembers::class);
    }
    
    public function privateGroupRequest(){
        return $this->hasMany(GroupRequests::class);
    }
    public function getGroupAdmin(){
        return $this->belongsTo(User::class, 'admin_user_id')->where( 'soft_delete', '!=', 1)->get();

    }
}