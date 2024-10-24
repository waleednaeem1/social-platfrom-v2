<?php

namespace App\Models;

use App\Models\Auth\User;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vendors';

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
    protected $fillable = [ 'business_type','user','contact_name','email','address','city', 'state', 
    'zip_code', 'country_id', 'phone', 'name', 'slug', 'logo', 'header_image', 'tax_percentage', 
    'percentage_from_sales', 'publishable_key', 'secret_key', 'client_account_id', 'activated_account', 
    'blocked_account', 'virtual_booth_url', 'vendor_type', 'sell_from', 
    'sp_category_id', 'sp_preferred', 'sp_deal','sp_rating', 'sp_website', 'sp_short_details', 'sp_details', 
    'status', 'site_url','sales_module_access','jobs_module_access','courses_module_access','service_provider_module_access' ];

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

    public static $vendor_type = [
        '1' => 'Seller',
        '2' => 'Service Provider',
    ];

    public static $sell_from = [
        '1' => 'DVM Marketplace',
        '2' => 'Vendor Own Website',
    ];

    public static $service_provider_categories = [
        1 => 'Telemedicine',
        2 => 'Recruiting and Hiring',
        3 => 'Practice Management Systems',
        4 => 'Customer Communication Service',
        5 => 'Marketing, Design, Branding',
        6 => 'Consultants',
        7 => 'Credit Card Processors',
        8 => 'Payroll',
        9 => 'Controlled Substance Destruction',
        10 => 'Pet Insurance',
        11 => 'Continuing Education',
        12 => 'Staffing',
        13 => 'Pet Parent Financing',
    ];
    public static $service_provider_categories_data = [
        ['id' => '1', 'name' => 'Telemedicine'],
        ['id' => '2', 'name' => 'Recruiting and Hiring'],
        ['id' => '3', 'name' => 'Practice Management Systems'],
        ['id' => '4', 'name' => 'Customer Communication Service'],
        ['id' => '5', 'name' => 'Marketing, Design, Branding'],
        ['id' => '6', 'name' => 'Consultants'],
        ['id' => '7', 'name' => 'Credit Card Processors'],
        ['id' => '8', 'name' => 'Payroll'],
        ['id' => '9', 'name' => 'Controlled Substance Destruction'],
        ['id' => '10', 'name' => 'Pet Insurance'],
        ['id' => '11', 'name' => 'Continuing Education'],
        ['id' => '12', 'name' => 'Staffing'],
        ['id' => '13', 'name' => 'Pet Parent Financing'],
    ];

    public function slugs()
    {
        return $this->morphMany('App\Models\Slug', 'sluggable');
    }

    public static function get_business_type($vendor_id) // Vendor ID is basically ID of users table, Users with type of Vendor will have link with Vendors and Business Types
    {
        $vendor = self::where('user', $vendor_id)->first();
        if($vendor)
            $business_type = $vendor->business_type;
        else
            $business_type = 0;

        return $business_type;
    }

    public static function get_store_name_slug($vendor_id) // Vendor ID is basically ID of users table, Users with type of Vendor will have link with Vendors and Business Types
    {
        $vendor = self::where('id', $vendor_id)->first();
        if($vendor)
        {
            $name = $vendor->name;
            $slug = $vendor->slug;
            $store = ['name' => $name, 'slug' => $slug];
        }
        else
            $store = null;

        return $store;
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function get_vendor_orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public static function get_vendor($id)
    {
        return self::find($id);
    }

    public function business_types()
    {
        return $this->belongsTo(BusinessType::class, 'business_type', 'id');
    }
    public function getVendorCountry()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function vendor_user()
    {
        return $this->belongsTo(User::class, 'user');
    }
    public function vendor_coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function vendor_user_details()
    {
        return $this->belongsTo(User::class, 'user')->select('id', 'name');
    }
    
    public function get_company_name($vendor_id){
        $company = self::select('name')->where('id', $vendor_id)->first();
        return $company['name'];
    }
    public function getVendorJobs(){
        return $this->belongsTo(VendorJob::class, 'user');
    }

    public static function vendor_rating($vendor_id)
    {
        $rating = Review::whereHas('product', function ($query) use($vendor_id) {
            $query->where('vendor_id','=',$vendor_id);
        })->where([
            ['rating','!=',0],
            ['status','=','Y']
        ])->select(DB::raw('SUM(rating)/COUNT(*) as Rating'))->first();
        return $rating->Rating;
    }

    public function is_follow()
    {
        return $this->hasOne(Follow::class, 'vendor_id')->where('user_id', Auth::user()->id);
    }

    public function getFollowers($vendor_id)
    {
        $getFollowers = Follow::where('vendor_id' , $vendor_id)->count();
        return $getFollowers;
    }

    public function getServiceProviders(array $filter = [])
    {
        $query = self::where('vendor_type', '=', 2)->where('status' , 'Y');

        if(isset($filter['cat_id']))
            $query->where(['sp_category_id' => $filter['cat_id']]);
        if(isset($filter['show']))
        {
            if($filter['show'] == 'deals')
                $query->where('sp_deal', '!=', '');    
            else
                $query->where(['sp_preferred' => 'Y']);    
        }   
        if (isset($filter['keywords'])) {
            $query->where(function ($query) use ($filter) {
                $query->orWhere('name', 'like', '%' . $filter['keywords'] . '%');
                $query->orWhere('sp_short_details', 'like', '%' . $filter['keywords'] . '%');
                $query->orWhere('sp_details', 'like', '%' . $filter['keywords'] . '%');
            });
        }

        $query->orderBy('sp_preferred', 'asc');

        $filter['limit'] = 25;
        $result = $query->paginate($filter['limit']);
        return $result;
    }

    public static function getServiceProviderCategoryWiseCount($cat_id)
    {
        return self::where(['vendor_type' => '2', 'status' => 'Y', 'sp_category_id' => $cat_id])->count();
    }
}