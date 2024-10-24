<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VendorJob extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function salary_type_()
    {
        return $this->belongsTo(SalaryType::class, 'salary_type');
    }

    public function job_categories()
    {
        return $this->hasMany(VendorJobCategory::class, 'job_id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class)->where(['status' => 'Y' , 'vendor_type' => 1 ,'activated_account'=>'Y','blocked_account'=>'N' ]);
    }

    public function job_types()
    {
        return $this->hasMany(VendorJobType::class, 'job_id');
    }

    public function job_working_time()
    {
        return $this->belongsTo(JobWorkingTime::class, 'working_time_id');
    }

    public function application_prefrences()
    {
        return $this->hasOne(VendorJobApplicationPrefrence::class, 'vendor_job_id');
    }

    public function application_questions()
    {
        return $this->hasMany(VendorJobApplicationQuestion::class, 'job_id');
    }

    public static function getCurrentRunningJobPosting()
    {
        return self::where([ ['process' ,'!=', 4], 'vendor_id' => Auth::user()->vendor->id])->first();
    }

    public function minimum_education_level()
    {
        return $this->belongsTo(EducationLevel::class, 'minimum_education_level_id');
    }

    public function getAppliedUser($job_id)
    {
        $user_id = Auth::user()->id;
        return CandidateAppliedJob::where([['vendor_job_id' , $job_id],['customer_id' , $user_id]])->first();
    }

    public function userWishlist()
    {
        if(@auth()->user()->id)
        {
            return $this->hasOne(JobWishlist::class, 'job_id')->where('user_id',auth()->user()->id);
        }
        return false;
    }

    public static function filter($filter=[])
    {
        $jobs = self::where([['application_end_time', '>=', time()],['process', 4]]);

        if(@$filter['search'])
        {
            $jobs->where(function($job_search) use ($filter){
                if($filter['search']!==false)
                {
                    $searchArray = explode(' ', $filter['search']);
                    foreach($searchArray as $search)
                    {
                        if(@$search)
                        {
                            $job_search->orWhere('title', 'LIKE','%'.$search.'%');
                            $job_search->orWhere('city', 'LIKE','%'.$search.'%');
                            $job_search->orWhere('description', 'LIKE','%'.$search.'%');
                        }
                    }
                }
            });

            // $jobs->with(["job_categories" => function($jc_q) use ($filter) {
            //     $jc_q->with(["category" => function($q) use ($filter) {
            //         $q->where(function($jcs_q) use ($filter){
            //             if($filter['search']!==false)
            //             {
            //                 $jcs_q->orWhere('name', 'LIKE','%'.$filter['search'].'%');
            //             }
            //         });
            //     }]);
            // }]);
        }
        
        if(@$filter['multi_categories'])
        {
            $jobs->whereHas("job_categories", function($jc_q) use ($filter) {
                $jc_q->whereHas("category" , function($q) use ($filter) {
                    $q->where(function($cat_q) use ($filter){
                        foreach($filter['multi_categories'] as $cat)
                        {
                            if($cat!==false)
                            {
                                $cat_q->orWhere('name', 'Like', '%'.$cat.'%');
                            }
                        }
                    });
                });
            });
        }

        if(@$filter['categories'])
        {
            $jobs->whereHas("job_categories", function($q) use ($filter) {
                $q->where(function($cat_q) use ($filter){
                    foreach($filter['categories'] as $cat)
                    {
                        if($cat!==false)
                        {
                            $cat_q->orWhere('category_id', $cat);
                        }
                    }
                });
            });
        }

        if(@$filter['types'])
        {
            $jobs->whereHas("job_types", function($job_types) use ($filter) {
                $job_types->where(function($type_q) use ($filter){
                    foreach($filter['types'] as $type)
                    {
                        if($type!==false)
                        {
                            $type_q->orWhere('job_type_id', $type);
                        }
                    }
                });
            });
        }

        if(@$filter['vendors'])
        {
            $jobs->where(function($country_q) use ($filter) {
                foreach($filter['vendors'] as $vendor)
                {
                    if($vendor!==false)
                    {
                        $country_q->orWhere('vendor_id', $vendor);
                    }
                }
            });
        }

        if(@$filter['countries'])
        {
            $jobs->where(function($country_q) use ($filter) {
                foreach($filter['countries'] as $country_id)
                {
                    if($country_id!==false)
                    {
                        $country_q->orWhere('country_id', $country_id);
                    }
                }
            });
        }

        if(@$filter['states'])
        {
            $jobs->where(function($stats_q) use ($filter) {
                foreach($filter['states'] as $state)
                {
                    if($state!==false)
                    {
                        $stats_q->orWhere('state_id', $state);
                    }
                }
            });
        }

        if(@$filter['working_time'])
        {
            $jobs->where(function($working_q) use ($filter) {
                foreach($filter['working_time'] as $time)
                {
                    if($time!==false)
                    {
                        $working_q->orWhere('working_time_id', $time);
                    }
                }
            });
        }

        if(@$filter['educations'])
        {
            $jobs->where(function($edu_q) use ($filter) {
                foreach($filter['educations'] as $edu)
                {
                    if($edu!==false)
                    {
                        $edu_q->orWhere('minimum_education_level_id', '>=', $edu);
                    }
                }
            });
        }

        if(@$filter['salary_types'])
        {
            $jobs->where(function($salary_type_q) use ($filter) {
                foreach($filter['salary_types'] as $salary_type)
                {
                    if($salary_type!==false)
                    {
                        $salary_type_q->orWhere('salary_type', $salary_type);
                    }
                }
            });
        }

        if(@$filter['salary_range'])
        {
            $jobs->where(function($salary_range_q) use ($filter) {
                if(@$filter['salary_range'][0])
                {
                    $salary_range_q->where('salary', '>=', $filter['salary_range'][0]);
                }
                if(@$filter['salary_range'][1])
                {
                    $salary_range_q->where('salary', '<=', $filter['salary_range'][1]);
                }
            });
        }

        if(@$filter['urgent_hiring'])
        {
            $jobs->where('urgent_hiring', $filter['urgent_hiring']);
        }

        return $jobs->get();
    }
}
