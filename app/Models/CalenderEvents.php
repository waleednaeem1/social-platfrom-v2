<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalenderEvents extends Model
{
    use HasFactory;

    protected $table = 'vt_events';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = ['user_id','event_name','address','description','other_requirements','event_image','event_start_time','event_date','status','created_at','updated_at'];

}