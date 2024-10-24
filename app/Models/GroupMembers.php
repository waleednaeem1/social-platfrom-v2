<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMembers extends Model
{
    use HasFactory;

    protected $table = 'vt_groups_members';

    protected $fillable = ['group_id','user_id','follow','status','created_at','updated_at'];

    public function getUser(){
        return $this->belongsTo(User::class, 'user_id')->where( 'soft_delete', '!=', 1);
    }
    public function getMembers(){
        return $this->belongsTo(GroupMembers::class, 'user_id');
    }
    public function getFollowRecord(){
        return $this->belongsTo(GroupFollow::class, 'user_id', 'user_id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class)->where('status', 'Y');
    }
}
