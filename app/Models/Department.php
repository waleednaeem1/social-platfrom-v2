<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use Searchable;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
    // public function clinicsViseDoctors()
    // {
    //     return $this->hasMany(Doctor::class, 'department_id');
    // }
}
