<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAlbumImage extends Model
{
    use HasFactory;
    protected $table = 'user_album_images';
    protected $primaryKey = 'id';
    protected $fillable = ['user_album_id','image_path','status','is_deleted','created_at','updated_at'];
}
