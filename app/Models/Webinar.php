<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function events()
    {
        return $this->belongsTo(Events::class, 'event_id', 'id');
    }

    public function speaker()
    {
        return $this->belongsToMany(Speaker::class, 'speaker_webinar');
    }

    public function webinar_registrations()
    {
        return $this->belongsTo(WebinarRegistration::class, 'webinar_id');
    }
    
}
