<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetType extends Model
{
    // use HasFactory;

    protected $table = 'pet_type';

    // protected $fillable = [ 'id', 'user_id', 'name', 'age', 'age_in', 'breed', 'gender', 'weight', 'unit', 'slug', 'short_description', 'images', 'thumbnail', 'video', 'pet_type_id', 'previous_record', 'status', 'meta_title', 'meta_keywords', 'meta_description', 'created_at', 'updated_at'];

    protected $primaryKey = 'id';

    // public function images()
    // {
    //     return $this->hasMany(PetsImage::class,'pet_id');
    // }
}