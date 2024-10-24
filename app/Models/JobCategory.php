<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_categories';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function get_category($id)
    {
        $category = self::select('name')
            ->where('id', $id)
            ->first();
        return $category['name'];
    }

    public function job_categories()
    {
        return $this->hasMany(VendorJobCategory::class, 'category_id');
    }

    public static function getJobs()
    {
        $categories = JobCategory::whereHas('job_categories', function ($q) {
            $q->whereHas('vendor_job', function ($job) {
                $job->where([['application_end_time', '>=', time()],['process', 4]]);
            });
        })->get();
        return $categories;
    }
}
