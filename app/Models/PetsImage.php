<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetsImage extends Model
{
    use HasFactory;
    protected $table = 'pets_images';

    protected $primaryKey = 'id';
}
