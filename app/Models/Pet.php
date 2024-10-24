<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    // use HasFactory;

    protected $table = 'pets';

    protected $fillable = [ 'first_name','last_name','email','phone','thumbnail','pet_name','slug', 'pet_age', 'address', 'city', 'zip', 'state','country', 'description', 'pet_created_time', 'status','video'];

    protected $primaryKey = 'id';

    public function images()
    {
        return $this->hasMany('App\Models\PetsImage');
    }
}
