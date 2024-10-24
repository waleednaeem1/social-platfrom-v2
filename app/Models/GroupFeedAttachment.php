<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupFeedAttachment extends Model
{
    use HasFactory;

    protected $table = 'groups_feeds_attachments';
    protected $guarded = [];
}