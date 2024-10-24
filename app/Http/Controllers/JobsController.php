<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\CandidateAppliedJob;
use App\Models\CandidateJobQuestionAnswer;
use App\Models\Country;
use App\Models\VendorJob;
use App\Models\Customer;
use App\Models\EducationLevel;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\JobWishlist;
use App\Models\JobWorkingTime;
use App\Models\SalaryType;
use App\Models\State;
use App\Models\Vendor;
use App\Models\Page;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class JobsController extends Controller
{
    public function listing()
    {
        $data['job_detail'] = VendorJob::where('application_end_time', '>=', time())->with(['vendor:id,name,slug,logo'])->with(['country:id,name'])->with(['state:id,name'])->with(['salary_type_:id,name'])->with('job_working_time')->with(['minimum_education_level:id,name'])->get();
        $data['job_category'] = JobCategory::all();
        $data['job_type'] = JobWorkingTime::all();
        return view('jobs.list',compact('data'));
    }

    public function jobDetail($slug)
    {
        $data['breadcrumbs']    = [];
        // $data['job_detail'] = VendorJob::where('slug', $slug)->first();
        $query = VendorJob::with(['vendor:id,name,phone,email,user'])->with(['country:id,name'])->with(['state:id,name'])->with(['salary_type_:id,name'])->with('job_working_time')->with(['minimum_education_level:id,name'])->where('slug', $slug);

        $data['education_list_for_jobs'] = EducationLevel::all();
        $data['job_detail'] = $query->with('application_prefrences', function($jc_q) {$jc_q->with('communication_settings');})->first(); 
       
        //getting job_types
        foreach ( $data['job_detail']->job_types as $key => $job_type){
            $data['job_detail']->job_types[$key] = @$job_type->job_type;
            $data['job_detail']->job_types[$key]  = @$job_type->job_type; 
            // for ( $i = 0 ; $i < count($data['job_detail']->job_types) ; $i++){
            //     unset($data['job_detail']->job_types[$key][$i]); 
            // }
        }
        //getting job_category
        foreach ( $data['job_detail']->job_categories as $key => $job_category){
            $data['job_detail']->job_categories[$key] = @$job_category->category;
            $data['job_detail']->job_categories[$key]  = @$job_category->category;
            // for ( $i = 0 ; $i < count($data['job_detail']->job_categories) ; $i++){
            //     unset($data['job_detail']->job_categories[$key][$i]); 
            // }
        }
        
        //converting varchar date format to user readable format
        if(isset($data['job_detail']))
        {
            $data['job_detail']->application_start_time = date('M d, Y', $data['job_detail']->application_start_time);
            $data['job_detail']->application_end_time = date('M d, Y', $data['job_detail']->application_end_time);
            $jobTitle = $data['job_detail']->title;
            $jobSlug = $data['job_detail']->slug;
            if(isset($data['job_detail']->application_prefrences)){
                $data['job_detail']->application_prefrences->application_deadline = date('M d, Y', $data['job_detail']->application_prefrences->application_deadline);
                $data['job_detail']->application_prefrences->decline_time = date('M d, Y', $data['job_detail']->application_prefrences->decline_time);
            }
        }
        
        // $data['education_levels'] = EducationLevel::all();
        $data['page_type'] = "job_detail";
        
        $parentSlug    = "jobs";
        
        array_push($data['breadcrumbs'], (array)['name' => "Jobs", 'link' => $parentSlug]);
        array_push($data['breadcrumbs'], (array)['name' => $jobTitle]);

        return response()->json($data, 200);
    }

    public function apply(Request $request)
    {   
        try{
            
            $date = date('d-m-y h:i:s');
            $filename = '';
            if ($request->file('resume_file')) {
                $request->validate([
                    'resume_file' => 'required|mimes:pdf,docx,doc|max:4096'
                ]);
                $file = $request->file('resume_file');
                $filename = date('Ymdis') . '.' . $file->getClientOriginalExtension();
                $file_path = 'up_data/jobs/user/' . $request->customer_id . '/';
                $file_path = $this->createDirectory($file_path);
                $file->move(public_path($file_path), $filename);
            }else{
                return response()->json(['success' => false, 'message' => 'Resume file is required'], 201);
            }
            CandidateAppliedJob::create([
                'years_of_experience' => $request->years_of_experience,
                'resume_file' => @$filename,
                'vendor_job_id' => $request->vendor_job_id,
                'customer_id' => $request->customer_id,
                'status' => 0,
                'applied_time' => $date,
                'education_level_id' => $request->education_level_id,
            ]);

            $quetion_id = $request['quetion_id'];
            $answer = $request['answer'];

            foreach ($request->quetion_id as $key => $quetion) {
                $quetion = new CandidateJobQuestionAnswer();
                $quetion->quetion_id =  $quetion_id[$key];
                $quetion->answer =  $answer[$key];
                $quetion->customer_id = $request->customer_id;
                $quetion->save();
                $answer = $request['answer'];
            }
            return response()->json(['success' => true, 'message' => 'Job applied successfully'], 200);

        } catch (\Throwable $th) {
            return response()->json(['success' => false,'message' =>$th->getMessage(),],201);
        }  
    }

    public function filterJobs(Request $request)
    {
        $data['job_detail'] = Self::filter($request->all());
        return response()->json($data, 200);
    }
    public static function filter($filter = [])
    {
        $query = VendorJob::where('application_end_time', '>=', time())->with(['vendor:id,name'])->with(['country:id,name'])->with(['state:id,name'])->with(['salary_type_:id,name'])->with('job_working_time')->with(['minimum_education_level:id,name']);
        if ($filter != null) {
            if (@$filter['categories']) {
                $query->whereHas("job_categories", function($jc_q) use ($filter) {
                    $jc_q->whereHas("category" , function($q) use ($filter) {
                        $q->where(function($cat_q) use ($filter){
                            foreach($filter['categories'] as $cat)
                            {
                                if($cat!==false)
                                { 
                                    $cat_q->orWhere('category_id', 'Like', '%'.$cat.'%');
                                }
                            }
                        });
                    });
                });
            }
            

            if (@$filter['types']) {
            
                $query->whereHas("job_types", function($job_types) use ($filter) {
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

            if (@$filter['vendors']) {
                $query->where(function($country_q) use ($filter) {
                    foreach($filter['vendors'] as $vendor)
                    {
                        if($vendor!==false)
                        {
                            $country_q->orWhere('vendor_id', $vendor);
                        }
                    }
                });
            }

            if (@$filter['countries']) {
                $query->Where(function ($subQ) use ($filter) {
                    foreach ($filter['countries'] as $country_id) {
                        if ($country_id !== false) {
                            $subQ->orWhere('country_id', $country_id);
                        }
                    }
                });
            }

            if (@$filter['states']) {
                $query->where(function ($subQ) use ($filter) {
                    foreach ($filter['states'] as $state) {
                        if ($state !== false) {
                            $subQ->orWhere('state_id', $state);
                        }
                    }
                });
            }

            if (@$filter['working_time']) {
                $query->where(function ($subQ) use ($filter) {
                    foreach ($filter['working_time'] as $time) {
                        if ($time !== false) {
                            $subQ->orWhere('working_time_id', $time);
                        }
                    }
                });
            }

            if (@$filter['educations']) {
                $query->where(function ($subQ) use ($filter) {
                    foreach ($filter['educations'] as $edu) {
                        if ($edu !== false) {
                            $subQ->orWhere('minimum_education_level_id', $edu);
                        }
                    }
                });
            }

            if (@$filter['salary_types']) {
                $query->where(function ($subQ) use ($filter) {
                    foreach ($filter['salary_types'] as $salary_type) {
                        if ($salary_type !== false) {
                            $subQ->orWhere('salary_type', $salary_type);
                        }
                    }
                });
            }

            if (@$filter['salary_range']) {
                $query->where(function ($subQ) use ($filter) {
                    if (@$filter['salary_range'][0]) {
                        $subQ->where('salary', '>=', $filter['salary_range'][0]);
                    }
                    if (@$filter['salary_range'][1]) {
                        $subQ->where('salary', '<=', $filter['salary_range'][1]);
                    }
                });
            }

            if (@$filter['hiring']) {
                if($filter['hiring'][0] == 1 || $filter['hiring'][0] == 0){
                    $query->where('urgent_hiring', $filter['hiring']);
                }
              
            }
        }else{
            $data['job_detail'] = VendorJob::where('application_end_time', '>=', time())->with(['vendor:id,name'])->with(['country:id,name'])->with(['state:id,name'])->with(['salary_type_:id,name'])->with('job_working_time')->with(['minimum_education_level:id,name'])->get();
        }    
        $data['job_detail'] = $query->get();
        //for fetching jobs category and job type
        foreach ($data['job_detail'] as $job_detail) {
            $job_data =  VendorJob::where('id', $job_detail->id)->first();
            foreach ($job_data->job_types as $key => $jt) {
                $job_detail->job_types[$key] = $jt->job_type;
            }
            foreach ($job_data->job_categories as $key =>  $jc) {
                $job_detail->job_categories[$key] = $jc->category;
            }
            $job_detail->application_start_time = date('M d, Y', $job_detail->application_start_time);
            $job_detail->application_end_time = date('M d, Y', $job_detail->application_end_time);
            $job_detail->created_time = date('M d, Y', $job_detail->created_time);
        }
        return $data['job_detail'];
    }

    public function searchJobs(Request $request)
    {
        $query = VendorJob::with(['vendor:id,name'])->with(['country:id,name'])->with(['state:id,name'])->with(['salary_type_:id,name'])->with('job_working_time')->with(['minimum_education_level:id,name']);
        if (trim($request->search) == null)
            $request->search = null;

        $search = trim($request->search);
        if ($request->search != null) {
            $query->where(function ($q) use ($search) {

                $q->orWhere('title', 'LIKE', '%' . $search . '%')->where('application_end_time', '>=', time());
                $q->orWhere('city', 'LIKE', '%' . $search . '%')->where('application_end_time', '>=', time());
                // $q->orWhere('description', 'LIKE', '%' . $search . '%');
            });
            $query->orWhereHas('vendor', function ($query) use ($search) { 
                $query->where('name', 'like', $search.'%')->where('application_end_time', '>=', time());
            });
            $query->orWhereHas('state', function ($query) use ($search) { 
                $query->where('name', 'like', $search.'%')->where('application_end_time', '>=', time()); 
            });
            $query->orWhereHas('salary_type_', function ($query) use ($search) {
                $query->where('name', 'like', $search.'%')->where('application_end_time', '>=', time());
            });
            $query->orWhereHas('country', function($query) use ($search) {
                $query->where('name', 'like', $search.'%')->where('application_end_time', '>=', time());
            });
            $query->orWhereHas('job_working_time', function($query) use ($search) {
                $query->where('name', 'like', $search.'%')->where('application_end_time', '>=', time());
            });
            $query->orWhereHas('minimum_education_level', function($query) use ($search) {
                $query->where('name', 'like', $search.'%')->where('application_end_time', '>=', time());
            });
            $query->orWhereHas('job_categories', function($subQuery) use ($search) {
                $subQuery->whereHas('category', function($q) use ($search) {
                    $q->where('name', 'like', $search.'%')->where('application_end_time', '>=', time());
                });
            });
            $query->orWhereHas('job_types', function($subQuery) use ($search) {
                $subQuery->whereHas('job_type', function($q) use ($search) {
                    $q->where('name', 'like', $search.'%')->where('application_end_time', '>=', time());
                });
            });
            $data['job_detail'] = $query->get();
        }else{
            $data['job_detail'] = VendorJob::where('application_end_time', '>=', time())->with(['vendor:id,name'])->with(['country:id,name'])->with(['state:id,name'])->with(['salary_type_:id,name'])->with('job_working_time')->with(['minimum_education_level:id,name'])->get();
        }
        //for fetching jobs category and job type
        foreach ($data['job_detail'] as $job_detail) {
            $job_data =  VendorJob::where('id', $job_detail->id)->first();
            foreach ($job_data->job_types as $key => $jt) {
                $job_detail->job_types[$key] = $jt->job_type;
            }
            foreach ($job_data->job_categories as $key =>  $jc) {
                $job_detail->job_categories[$key] = $jc->category;
            }
            $job_detail->application_start_time = date('M d, Y', $job_detail->application_start_time);
            $job_detail->application_end_time = date('M d, Y', $job_detail->application_end_time);
            $job_detail->created_time = date('M d, Y', $job_detail->created_time);
        }
        $data['page_type']    = 'job_list';
        return response()->json($data, 200);
    }

    public function jobDelete($id){
        $job = VendorJob::find($id);
        if($job){
            $job->delete();
            return response()->json(['message' => 'job deleted suceesfully'], 200);
        }
    }
}