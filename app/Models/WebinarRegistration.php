<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarRegistration extends Model
{
    use HasFactory;
    protected $table = 'webinar_registrations';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function webinar()
    {
        return $this->belongsTo(Webinar::class, 'webinar_id');
    }
}
