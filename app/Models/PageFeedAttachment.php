<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageFeedAttachment extends Model
{
    use HasFactory;

    protected $table = 'pages_feeds_attachments';
    protected $guarded = [];
}