<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFamilyRelationship extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','type','relationship', 'family_member'];

    public function userDetails()
    {
        return $this->belongsTo(User::class, 'family_member')->select('id','avatar_location', 'username', 'first_name', 'last_name')->where( 'soft_delete', '!=', 1);
    }
}
