<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageMembers extends Model
{
    use HasFactory;

    protected $table = 'vt_pages_members';

    protected $fillable = ['page_id','user_id','status','created_at','updated_at'];

    public function getUser(){
        return $this->belongsTo(User::class, 'user_id')->where( 'soft_delete', '!=', 1);
    }
    public function getMembers(){
        return $this->belongsTo(GroupMembers::class, 'user_id');
    }
    public function page()
    {
        return $this->belongsTo(Page::class)->where( 'status', 'Y');
    }
}