<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'speakers';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    //protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'first_name','last_name','email','job_title','institute','about', 'profile', 'profession', 'classification', 'specialty', 'employer_type', 'practice_role', 'vets_in_practice', 'techs_in_practice',
                            'practice_revenue', 'practices_in_group', 'credentials', 'website', 'phone', 'mobile', 'address', 'city', 'state', 'zip', 'country', 'sm_facebook', 'sm_linkedin', 'sm_twitter', 'sm_instagram',
                            'sm_pinterest', 'sm_youtube', 'sm_vimeo', 'status' , 'slug'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'created_at', 'updated_at' ];

    /**
     * The attribute types will be define here, it's required to return data to API in correct types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
    ];

    public function webinars()
    {
        return $this->belongsToMany(Webinar::class, 'speaker_webinar');
    }
    public function webinarSpeakers()
    {
        return $this->belongsToMany(Webinar::class, 'speaker_webinar')->where([['show_in_app', 1],['webinar_type', 'website'],['status', 'Y'],['start_date', '>=', date('y-m-d h:i:s')]]);
        // ->select('id','name','image','event_id','start_date','end_date','location',[pivot('speaker_id','webinar_id')])
    }

    // public function speakerWebinar()
    // {
    //     return $this->belongsToMany(SpeakerWebinar::class);
    // }
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function pluckSpeaker()
    {
        $query = self::where('status','Y');

        $query->select('id', 'first_name', 'last_name');

        $query->orderBy('first_name', 'asc');

        $result = $query->get()->toArray();

        $return = [];

        foreach($result as $row)
        {
            $return[$row['id']] = $row['first_name'] . ' ' . $row['last_name'] ;
        }

        return $return;
    }

    public function speakerfile()
    {
        return $this->hasMany(SpeakerFiles::class);
    }
}