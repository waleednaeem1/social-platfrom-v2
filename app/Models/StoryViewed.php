<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryViewed extends Model
{
    use HasFactory;

    protected $table = 'stories_viewed';

    protected $guarded = [];
}
