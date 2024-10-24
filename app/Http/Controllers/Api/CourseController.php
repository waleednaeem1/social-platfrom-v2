<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\CourseEnrollment;

use App\Models\CartItem;

use App\Models\Team;

use App\Models\ShallowCourse;
use App\Models\ShallowCourseModule;
use App\Models\ShallowCourseModuleSection;
use App\Models\ShallowCourseModuleSectionEexercise;
use App\Models\ShallowQuizQuestion;
use App\Models\CourseModuleQuizAnswer;
use App\Models\ShallowQuizAnswer;
use App\Models\FeedBackModule;
use App\Models\User;

use App\Models\CourseCompletion;
use App\Models\ModuleCompletion;
use App\Models\SectionCompletion;
use App\Models\ExerciseCompletion;
use App\Models\CourseQuizResult;
use App\Models\QuizScore;

use App\Models\MarkingSubmission;
use App\Models\MarkingSubmissionResult;


class CourseController extends Controller
{
    public function courseCategories()
    {
        
        $data['course_categories'] = CourseCategory::whereHas('getSelectedCoursesColumns')->where('status', 'Y')->get(array('id','name','short_description','slug'));

        foreach($data['course_categories'] as $category)
        {
            $count[]= $category->getSelectedCoursesColumns->count();
            $enrollments[]= $category->enrolments($category->id);
            for ($i = 0 ; $i < count($data['course_categories']); $i++)
            {
                $category->course_count = $count[count($count)-1];
                $category->enrollments = $enrollments[count($enrollments)-1];
            }
        }
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function courseListing($slug, $user_id)
    {
        $data['course_categories'] = CourseCategory::whereHas('getSelectedCoursesColumns')->where('status', 'Y')->get(array('id','name','short_description','slug'));
        $data['category'] = CourseCategory::where('slug',$slug)->first(array('id','name','slug','meta_title','meta_keywords','meta_description'));

        if(!isset($data['category']) || $data['category'] == null){
            return response()->json(['msg' => 'Course categories not found!', 'success' => false], 201);
        }

        $data['course_list'] = Course::with('getCourseType')
            ->with(['getShallowCourseDataApi' => function ($query) use ($user_id) {
                $query->where('purchased_user_id', $user_id);
            }])
            ->with(['enrollmentsApi' => function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            }])
            ->where([['course_category_id',$data['category']->id],['status','Y']])
            ->orderBy('created_at', 'DESC')
            ->get(array('id','course_category_id','course_type_id','slug','user_id','title','thumbnail','meta_title','meta_keywords','meta_description','marking_user'));
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function courseEnrollment($course_slug, $customerId)
    {
        $customer_id = $customerId;
        $data['course'] = Course::where('slug', $course_slug)->first();
        if($customer_id != null){
            $checkEnrolledment = CourseEnrollment::where (['course_id' => $data['course']->id , 'user_id' => $customer_id])->first();
            $data['enrolled'] = $checkEnrolledment ? true :false;
            $checkAddToCart = CartItem::where(['course_id' => $data['course']->id ,'customer_id' => $customer_id])->first();
            $data['addToCart'] = $checkAddToCart ? true :false;
        }
        $data['category'] = $data['course']->category;
        $data['course_enrollment_detail'] = Course::with('getSelectedColumnsFromModules')->with('getSelectedColumnsOfinstructor')->where('slug',$course_slug)->orderBy('created_at', 'DESC')->get(array('id','course_category_id','course_type_id','slug','user_id','title','thumbnail'));
        unset($data['course']->category);
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function enrollCoach($course_slug, $user_id)
    {
        $userId = $user_id; 
        $data['allCoach'] = Team::with('user')->where(['added_by' => $userId, 'is_coach' => 1])->get();
        $data['courseSlug'] = $course_slug;
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function addToCart(Request $request)
    {   
        $user_id = $request->userId;
        $existing_item = CartItem::where([['customer_id', $user_id], ['course_id' ,$request->courseId]])->first();
        if($existing_item){
            return response()->json(['message' => 'Course already exists in the cart.', 'success' => false], 201);
        }
        $data = [
            'customer_id' => $user_id,
            'type' => 'course',
            'course_id' => $request->courseId,
            'quantity' => 1,
        ];
        $newCartItem = CartItem::create($data);
        return response()->json(['message' => 'Course added to shopping cart successfully.', 'success' => true], 200);
    }

    public function applyCoach(Request $request)
    {
        $user_id = $request->userId;
        $data = ShallowCourse::where(['slug'=> $request->courseSlug, 'purchased_user_id' => $user_id])->update(['coach_id' => $request->coachId]);
        if($data == 1){
            return ['success' => true,'message' => 'Coach applied successfully.','data' => $data];
        }else{
            return ['success' => false,'message' => 'Coach did not applied successfully.','data' => $data];
        }
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function courseDetail($cat_slug, $course_slug, $userId)
    {
        $data['category'] = CourseCategory::where('slug', $cat_slug)->get(array('id','name','slug'))->first();
        $user_id = $userId;

        $data['course'] = ShallowCourse::where(['slug' => $course_slug,'purchased_user_id' => $userId])->first(array('id','course_category_id','slug','course_type_id','purchased_user_id','title','thumbnail','short_description','general_guidance','is_24_7_support_service','is_practice_questions'));
        if(isset($data['course']) && $data['course'] != ''){
            
            $data['modules_list'] = ShallowCourseModule::with('sections.exercise','childSubModules.sub_modules.sections.exercise')->where('course_id', $data['course']->id)->where('status', '=', 'Y')->where('parent_id',0)->get(array('id','parent_course_module_id','course_id','parent_id','title','slug','status'));
            if(isset($user_id)){
                $user_enrollments = CourseEnrollment::where([['user_id', $user_id],['course_id', $data['course']->id]])->first();
                if($user_enrollments){
                    $data['course']->enrolled = true;
                    foreach ($data['modules_list'] as $modules_list){
                        $modules_list['is_free'] = 1;
                        $modules_list['allow_quiz'] = 1;
                    }
                }else{
                    $data['course']->enrolled = false;
                }
            }
            $is_course_complete=false;
            $percentage=0;
            $completed_courses=CourseCompletion::where([['user_id', $user_id],['course_id', $data['course']->id]])->count();
            if($completed_courses>0){
                $is_course_complete=true;
            }else{
                $totalModules= ShallowCourseModule::where(['course_id'=> $data['course']->id])->where('status', '=', 'Y')->count();
                $totalModulesCompleted=ModuleCompletion::where('course_id',$data['course']->id)->where('user_id', $userId)->count();
                if($totalModules!=$totalModulesCompleted){
                    $percentage=($totalModulesCompleted/$totalModules)*100;
                    $percentage=round($percentage);
                }
            }

            $data['is_course_complete']=$is_course_complete;
            $data['percentage']=($percentage) ;
        }
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function myCourses($userId)
    {
        $user = $userId;
        
        if(!$user || $user == null){
            return ['success' => false, 'message' => 'User doesn\'t exists'];
        }else{
            $data = CourseEnrollment::with(['course' => function ($query) {
                $query->with(['category' => function ($query) {
                    $query->select('id', 'slug');
                }]);
            }])->where('user_id', '=', $user)->get();

            return response()->json(['data' => $data, 'success' => true], 200);
        }
    }

    public function courseModuleDetail($cat_slug, $course_slug, $module_slug, $user_id)
    {
        $data['category'] = CourseCategory::where('slug', $cat_slug)->get(array('id','name','slug'))->first();

        $data['course'] = ShallowCourse::where(['slug' => $course_slug,'purchased_user_id' =>  $user_id])->first(array('id','slug','title'));

        $data['module'] = ShallowCourseModule::with('sections.exercise')->where(['course_id'=> $data['course']->id,'slug'=> $module_slug,'purchased_user_id' =>  $user_id])->where('status', '=', 'Y')->first();

        $all_modules=ShallowCourseModule::where(['course_id'=> $data['course']->id])->where('status', '=', 'Y');
        if($all_modules->count()>0){
            $total_modules=$all_modules->count();
            $current_module = array_search($data['module']->id, $all_modules->pluck('id')->toArray());
            $current_module++;
            $data['module_no']='Module '.$current_module.' of '.$total_modules.' in this course';
        }

        if(isset($user_id)){
            $user_enrollments = CourseEnrollment::where([['user_id', $user_id],['course_id', $data['course']->id]])->first();
            if($user_enrollments){
                $data['course']->enrolled = true;
            }else{
                $data['course']->enrolled = false;
            }
        }
        if(!isset($data['category']) || !isset($data['course'])){
            return response()->json('Course Category Not Found', 201);
        }

        $data['breadcrumbs']    = [];
        $parentSlug1    = "courses-categories";
        $parentSlugName1    = "Courses Categories";

        $parentSlug2    = "courses-categories/".$data['category']->slug;
        $parentSlugName2    = $data['category']->slug;

         $data['links']    = [];

        if(isset($data['module']['sections']) && !empty($data['module']['sections'][0]) ){
            $next_url= $parentSlug2.'/'.$data['course']->slug.'/'.$data['module']->slug.'/'.$data['module']['sections'][0]['slug'];
        }else{
            $module_id=$data['module']['id'];

            $module = ShallowCourseModule::where('course_id',$data['course']->id)->where('id','>',$module_id)->where('status', '=', 'Y')->first();
            if(isset($module)){
                $module_slug=$module->slug;
                $next_url= $parentSlug2.'/'.$data['course']->slug.'/'.$module_slug;
            }else{
                $next_url=$parentSlug2.'/'.$data['course']->slug;
            }
        }

        $module = ShallowCourseModule::where('course_id',$data['course']->id)->where('id','<',$data['module']->id)->where('status', '=', 'Y')->orderBy('id','desc')->first();

         if(isset($module) && !empty($module) ){
         $previous_link=$parentSlug2.'/'.$data['course']->slug.'/'.$module->slug;
         }else{
          $previous_link=$parentSlug2.'/'.$data['course']->slug;
        }

        array_push($data['links'], (array)['previous' =>  $previous_link]);
        array_push($data['links'], (array)['next' => $next_url]);


        $is_module_complete=false;
        $percentage=0;
        $totalSections = ShallowCourseModuleSection::where('course_module_id',$data['module']->id)->where('status', '=', 'Y')->count();
        $totalSectionComplete= SectionCompletion::where('module_id',$data['module']->id)->where('user_id', $user_id)->count();

        if($totalSections==$totalSectionComplete){
            $is_module_complete=true;
        }else{
            $percentage=($totalSectionComplete/$totalSections)*100;
            $percentage=round($percentage);
        }

        $data['is_module_complete']=$is_module_complete;
        $data['percentage']=$percentage;

        $data['page_type'] = "course_module_details";
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function courseModuleSectionDetail($cat_slug, $course_slug, $module_slug,$section_slug,$user_id)
    {
        
        $data['category'] = CourseCategory::where('slug', $cat_slug)->get(array('id','name','slug'))->first();
        $data['course'] = ShallowCourse::where(['slug' => $course_slug,'purchased_user_id' => $user_id])->first(array('id','slug','title'));
        $data['module'] = ShallowCourseModule::where('slug', $module_slug)->where('course_id',$data['course']->id)->where('purchased_user_id', $user_id)->first(array('id','slug','title'));

        $data['section'] = ShallowCourseModuleSection::with('exercise')->where(['slug'=> $section_slug,'purchased_user_id'=>$user_id,'course_module_id'=> $data['module']->id])->where('status', '=', 'Y')->first();

        $data['all_sections'] = ShallowCourseModuleSection::with('exercise')->where(['course_module_id'=> $data['module']->id,'purchased_user_id' => $user_id] )->where('status', '=', 'Y')->get();
        $all_modules=ShallowCourseModule::where(['course_id'=> $data['course']->id])->where('status', '=', 'Y');
        $all_sections = ShallowCourseModuleSection::where('course_module_id', $data['module']->id )->where('status', '=', 'Y');
        if($all_modules->count()>0){
            $total_modules=$all_modules->count();
            $current_module = array_search($data['module']->id, $all_modules->pluck('id')->toArray());
            $current_module++;
            $section_no='Module '.$current_module.' of '.$total_modules.' in this course';
            if($all_sections->count()>0){
                $total_sections=$all_sections->count();
                $current_section = array_search($data['section']->id, $all_sections->pluck('id')->toArray());
                $current_section++;
                $section_no.=': Section '.$current_section.' of '.$total_sections.' in this module';
                $data['section_no']=$section_no;
            }
        }
        if(isset($user_id)){
            $user_enrollments = CourseEnrollment::where([['user_id', $user_id],['course_id', $data['course']->id]])->first();
            if($user_enrollments){
                $data['course']->enrolled = true;
            }else{
                $data['course']->enrolled = false;
            }
        }

        if(!isset($data['category']) || !isset($data['course'])){
            return response()->json('Course Category Not Found', 201);
        }
        if(!isset($data['section'])){
            return response()->json('Section Not Found', 201);
        }

        $data['breadcrumbs']    = [];
        $parentSlug1    = "courses-categories";
        $parentSlugName1    = "Courses Categories";

        $parentSlug2    = "courses-categories/".$data['category']->slug;
        $parentSlugName2    =$data['category']->slug;

        $data['links']    = [];
        $previous_section_find = ShallowCourseModuleSection::where('course_module_id',$data['module']->id)->where('id','<',$data['section']->id)->orderBy('id', 'desc')->first();

        if(!empty($previous_section_find)){
            $exercise= ShallowCourseModuleSectionEexercise::where('course_module_section_id',$previous_section_find->id)->where('course_module_id',$data['module']['id'])->orderBy('id', 'desc')->first();
        }

        if(!empty($exercise)  && !empty($previous_section_find) ){
            $previous_url= $parentSlug2.'/'.$data['course']->slug.'/'.$data['module']->slug.'/'.$previous_section_find->slug.'/'.$exercise->slug;

         }else{
            $module_id=$data['module']['id'];
            $previous_section = ShallowCourseModuleSection::where('course_module_id',$module_id)->where('id','<',$data['section']->id)->orderBy('id', 'desc')->first();

            if(!empty( $previous_section)){
                $previous_url= $parentSlug2.'/'.$data['course']->slug.'/'.$data['module']->slug.'/'.$previous_section->slug;
            }else{
                $module_id=$data['module']['id'];
                $module = ShallowCourseModule::where('course_id',$data['course']->id)->where('id',$module_id)->where('status', '=', 'Y')->first();
                if(isset($module)){
                    $module_slug=$module->slug;
                    $previous_url= $parentSlug2.'/'.$data['course']->slug.'/'.$module_slug;
                }else{
                    $previous_url=$parentSlug2.'/'.$data['course']->slug;
                }
            }
        }

        array_push($data['links'], (array)['previous' =>  $previous_url]);
        if(isset($data['section']['exercise']) && !empty($data['section']['exercise'][0]) ){
            $next_url= $parentSlug2.'/'.$data['course']->slug.'/'.$data['module']->slug.'/'.$data['section']->slug.'/'.$data['section']['exercise'][0]['slug'];
        }else{
            $module_id=$data['module']['id'];
            $next_section = ShallowCourseModuleSection::where('course_module_id',$module_id)->where('id','>',$data['section']->id)->first();

            if(!empty( $next_section)){

            $next_url= $parentSlug2.'/'.$data['course']->slug.'/'.$data['module']->slug.'/'.$next_section->slug;

            }else{
                $module_id=$data['module']['id'];
                $module = ShallowCourseModule::where('course_id',$data['course']->id)->where('id','>',$module_id)->where('status', '=', 'Y')->first();
                if(isset($module)){
                    $module_slug=$module->slug;
                    $next_url= $parentSlug2.'/'.$data['course']->slug.'/'.$module_slug;
                }else{
                    $next_url= $parentSlug2.'/'.$data['course']->slug;
                }
            }
        }
        array_push($data['links'], (array)['next' =>  $next_url]);

        $percentage=0;
        $is_section_complete=false;
        $totalSectionExercises=ShallowCourseModuleSectionEexercise::where('course_module_section_id',$data['section']->id)->count();
        $totalExercisesComplete= ExerciseCompletion::where(['section_id' => $data['section']->id,'user_id' =>$user_id])->count();
        if($totalSectionExercises==$totalExercisesComplete){
            $is_section_complete=true;
        }else{
            $percentage=($totalExercisesComplete/$totalSectionExercises)*100;
            $percentage=round($percentage);
        }
        $data['is_section_complete'] =$is_section_complete;
        $data['percentage'] = $percentage;

        $data['page_type'] = "course_module_section_details";

        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function courseModuleSectionExerciseDetail($cat_slug, $course_slug, $module_slug,$section_slug,$exercise_slug, $user_id)
    {
        $data['category'] = CourseCategory::where('slug', $cat_slug)->get(array('id','name','slug'))->first();
        $data['course'] = ShallowCourse::where(['slug' => $course_slug,'purchased_user_id' => $user_id])->first(array('id','slug','title'));
        $data['module'] = ShallowCourseModule::where(['course_id'=> $data['course']->id,'slug'=> $module_slug,'purchased_user_id' =>  $user_id,'status' => 'Y'])->first();
        $data['section'] = ShallowCourseModuleSection::where(['course_module_id'=> $data['module']->id,'slug'=>$section_slug,'purchased_user_id' =>  $user_id,'status' => 'Y'] )->first();
        $data['exercise'] = ShallowCourseModuleSectionEexercise::with('questions.answers')->where(['slug'=> $exercise_slug,'purchased_user_id' =>  $user_id,'course_module_id'=>$data['module']->id,'course_module_section_id'=>$data['section']->id])->first();
        $data['all_exercise']= ShallowCourseModuleSectionEexercise::where(['slug'=> $exercise_slug,'purchased_user_id' =>  $user_id,'course_module_id'=>$data['module']->id,'course_module_section_id'=>$data['section']->id])->get();

        $all_modules=ShallowCourseModule::where(['course_id'=> $data['course']->id])->where('status', '=', 'Y');
        $all_sections = ShallowCourseModuleSection::where('course_module_id', $data['module']->id )->where('status', '=', 'Y');
        $all_exercise= ShallowCourseModuleSectionEexercise::where('course_module_section_id',$data['section']->id);

        if($all_modules->count()>0){
            $total_modules=$all_modules->count();
            $current_module = array_search($data['module']->id, $all_modules->pluck('id')->toArray());
            $current_module++;
            $exercise_no='Module '.$current_module.' of '.$total_modules.' in this course';

            if($all_sections->count()>0){
                $total_sections=$all_sections->count();
                $current_section = array_search($data['section']->id, $all_sections->pluck('id')->toArray());
                $current_section++;
                $exercise_no.=': Section '.$current_section.' of '.$total_sections.' in this module';
            }
            if($all_exercise->count()>0){
                $total_exercises=$all_exercise->count();

                $current_exercise = array_search($data['exercise']->id, $all_exercise->pluck('id')->toArray());
                $current_exercise++;
                $exercise_no.=': Exercise '. $current_exercise.' of '. $total_exercises.' in this section';
                $data['exercise_no']=$exercise_no;
            }
        }
        if(isset($user_id)){
            $user_enrollments = CourseEnrollment::where([['user_id', $user_id],['course_id', $data['course']->id]])->first();
            if($user_enrollments){
                $data['course']->enrolled = true;
            }else{
                $data['course']->enrolled = false;
            }
        }

        if(!isset($data['category']) || !isset($data['course'])){
            return response()->json('Course Category Not Found', 201);
        }
        if(!isset($data['exercise'])){
            return response()->json('Exercise Not Found', 201);
        }

        $data['breadcrumbs']    = [];
        $parentSlug1    = "courses-categories";
        $parentSlugName1    = "Courses Categories";

        $parentSlug2    = "courses-categories/". $data['category']->slug;
        $parentSlugName2    = $data['category']->slug;

        $data['links']    = [];

        $previous_exercise= ShallowCourseModuleSectionEexercise::where('id','<',$data['exercise']->id)->where('course_module_section_id',$data['section']->id)->orderBy('id', 'desc')->first();

        if(!empty($previous_exercise)){
            $previous_url= $parentSlug2.'/'.$data['course']->slug.'/'.$data['module']->slug.'/'.$data['section']->slug.'/'.$previous_exercise->slug;
        }else{
            
            $module_id=$data['module']['id'];
            
            $previous_section = ShallowCourseModuleSection::where('course_module_id',$module_id)->orderBy('id', 'desc')->where('id',$data['section']->id)->first();

            if(!empty( $previous_section)){
                $previous_url= $parentSlug2.'/'.$data['course']->slug.'/'.$data['module']->slug.'/'.$previous_section->slug;
            }else{
                $module_id=$data['module']['id'];
                
                $module = ShallowCourseModule::where('course_id',$data['course']->id)->where('id','<',$module_id)->where('status', '=', 'Y')->first();

                if(isset($module)){
                    $module_slug=$module->slug;
                    $previous_url= $parentSlug2.'/'.$data['course']->slug.'/'.$module_slug;
                }else{
                    $previous_url=$parentSlug2.'/'.$data['course']->slug;
                }
            }
        }
        array_push($data['links'], (array)['previous' =>  $previous_url]);

        $next_exercise= ShallowCourseModuleSectionEexercise::where('id','>',$data['exercise']->id)->where('course_module_section_id',$data['section']->id)->orderBy('id', 'asc')->first();
        if(isset($next_exercise) && !empty($next_exercise) ){
            $next_url= $parentSlug2.'/'.$data['course']->slug.'/'.$data['module']->slug.'/'.$data['section']->slug.'/'.$next_exercise->slug;
        }else{
            
            $module_id=$data['module']['id'];
            
            $next_section = ShallowCourseModuleSection::where('course_module_id',$module_id)->where('id','>',$data['section']->id)->first();
            if(!empty( $next_section)){
                $next_url= $parentSlug2.'/'.$data['course']->slug.'/'.$data['module']->slug.'/'.$next_section->slug;
            }else{
                
                $module_id=$data['module']['id'];
                
                $module = ShallowCourseModule::where('course_id',$data['course']->id)->where('id','>',$module_id)->where('status', '=', 'Y')->first();
                if(isset($module)){
                    $module_slug=$module->slug;
                    $next_url= $parentSlug2.'/'.$data['course']->slug.'/'.$module_slug;
                }else{
                    $next_url= $parentSlug2.'/'.$data['course']->slug;
                }
            }
        }
        array_push($data['links'], (array)['next' =>  $next_url]);
        $result=CourseQuizResult::where([['course_id',$data['course']->id],['module_id', $data['module']->id],['section_id', $data['section']->id],['exercise_id', $data['exercise']->id],['user_id', $user_id]  ])->first();
        $data['result']= $result;

         
         $is_last_exercise_count=1;
         $is_last_exercise=0;
         $is_diable=0;
         $courseQuiz=QuizScore::where(['module_id' => $data['module']->id,'exercise_id' =>  $data['exercise']->id,'user_id' => $user_id])->first();

        $status=$courseQuiz->status ?? 'fail';
        $lastExercise= ShallowCourseModuleSectionEexercise::where('course_module_section_id',$data['section']->id)->orderBy('id','desc')->first('id');
        if(!empty($lastExercise) && isset($lastExercise) && $lastExercise['id']== $data['exercise']->id ){
            $totalExercises= ExerciseCompletion::where(['section_id' => $data['section']->id,'exercise_id' =>  $data['exercise']->id,'user_id' => $user_id])->count();
            $is_last_exercise=1;
            if($totalExercises>0){
                $is_last_exercise_count=2;
            }
        }

        if(!empty($result) && $result->type==='mcq'){
            if($is_last_exercise==0 && $status === 'pass'){
                $is_diable=1;
            }else if ($is_last_exercise==1){
                if($status === 'pass' ||  $is_last_exercise_count==2 ){
                    $is_diable=1;
                }
            }
        }


        if(empty($result) && $is_diable=1 ){
            $is_diable=0;
        }

         if(!empty($result) && $result->type==='text' ){
            $is_diable=0;
        }

         $data['is_diable']=$is_diable;
         $data['page_type'] = "course_module_section_exercise_details";

        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function courseQuizSave(Request $request)
    {   
        $authUser = User::find($request->user_id);
        $is_file_upload=0;
        if($request->exercise_type==='file_upload'){
        $response=$this->uploadExerciseFile($request);
        $is_file_upload=1;
        }
        $quizes = $request->except('course_id','module_id','section_id','exercise_id','_token','next','questions','question_type');
        $question_type=$request->question_type;
         $all_exist=0;
         $only_mcq=0;
         $only_text=0;

        if(isset($question_type) && !empty($question_type) ){
            if(in_array('mcq',$question_type) && !in_array('feedback_mcq',$question_type) && ( in_array('reflective_question',$question_type)   || in_array('feedback_question_multiline',$question_type)  || in_array('reflective_question_multiline',$question_type)    ) )
            {
                $all_exist=1;
            }else if(in_array('feedback_mcq',$question_type) && !in_array('mcq',$question_type) && ( in_array('reflective_question',$question_type)   || in_array('feedback_question_multiline',$question_type)  || in_array('reflective_question_multiline',$question_type)    ) )
            {
                $all_exist=1;
            }else if(in_array('feedback_mcq',$question_type) && in_array('mcq',$question_type) && ( in_array('reflective_question',$question_type)   || in_array('feedback_question_multiline',$question_type)  || in_array('reflective_question_multiline',$question_type)    ) )
            {
                $all_exist=1;
            }else if(in_array('mcq',$question_type) || in_array('feedback_mcq',$question_type)  && !in_array('reflective_question',$question_type)  && !in_array('feedback_question_multiline',$question_type)  && !in_array('reflective_question_multiline',$question_type)   )
            {
                $only_mcq=1;
            }else if(!in_array('mcq',$question_type) && !in_array('feedback_mcq',$question_type)  && (in_array('reflective_question',$question_type)  || in_array('feedback_question_multiline',$question_type)  || in_array('reflective_question_multiline',$question_type)  ) )
            {
                $only_text=1;
            }
        }
        $is_last_exercise_count=1;
        $is_last_exercise=0;
        $status='';
        $total_quizes=0;
        $question_result=array();
        if($is_file_upload==0){

        $result=serialize($quizes);
        $total_quizes=count($quizes);

        if($only_mcq==1){
            //check for existing record
            $obtainedMarks = CourseModuleQuizAnswer::where([['user_id', $authUser->id],['module_id',$request->module_id] ,['section_id', $request->section_id],['exercise_id', $request->exercise_id] ])->get();
            if($obtainedMarks){
                foreach($obtainedMarks as $om){
                    $om->delete();
                }
            }
            $quiz=$request->except('course_id','module_id','section_id','exercise_id','_token','next','questions','question_type');
            $questions=$request->questions;
            $question_result=array();
            if(!empty($questions) &&   $total_quizes>0){
            for($i = 0 ; $i < count($questions) ; $i++){
                    $selected_options=$quiz[$questions[$i]] ;
                    $option = ShallowQuizAnswer::find($selected_options);
                    $is_true = 0;
                    if($option->is_true==1)
                    {
                        $is_true = 1;
                    }
                    $question_result[$i]=array('question_id'=> $questions[$i],'is_true'=>$is_true);
                    CourseModuleQuizAnswer::create([
                        'user_id' => $authUser->id,
                        'module_id' => $request->module_id,
                        'section_id' => $request->section_id ?? '',
                        'exercise_id' => $request->exercise_id ?? '',
                        'quiz_id' => $questions[$i],
                        'option_id' => $selected_options,
                        'is_true' => $is_true,
                        'total_marks'=>0,
                        'obtained_marks'=>0,
                    ]);
                }
            }
            if($total_quizes>0){
                $obtainedMarks = CourseModuleQuizAnswer::where([['user_id',$authUser->id],['module_id', $request->module_id],['is_true', '1']  ,['section_id', $request->section_id],['exercise_id', $request->exercise_id]   ])->count();
                $totalQuestions = ShallowQuizQuestion::where(['module_id' => $request->module_id, 'active' => 1,'exercise_id' => $request->exercise_id])->count();
                $score = (int)($obtainedMarks / $totalQuestions * 100);
                $status = $score >= 80 ? 'pass' : 'fail';
                $where = ['exercise_id' => $request->exercise_id,'user_id' =>$authUser->id,'section_id' => $request->section_id];
                QuizScore::updateOrCreate($where,[
                    'module_id' => $request->module_id,
                    'section_id' => $request->section_id ?? '',
                    'exercise_id' => $request->exercise_id ?? '',
                    'user_id' => $authUser->id,
                    'total_marks' => $totalQuestions,
                    'obtained_marks' => $obtainedMarks,
                    'status' => $status
                ]);
            }
        }

       }

        if($status==='pass' || $total_quizes==0  || $only_text==1 || $all_exist==1  || $is_file_upload==1 )
        {
            $total_questions=0;
            $total_correct_answers=0;
            $is_error=true;

            if($total_quizes>0){
                if($status==='pass'){
                    $type='mcq';
                }else if( $only_text==1){
                    $type='text';
                }else if( $all_exist==1){
                    $type='both';
                }
                if($type==='both'){
                  $questions=$request->questions;
                    if(!empty($questions) &&   $total_quizes>0){
                        for($i = 0 ; $i < count($questions) ; $i++){
                            $question=ShallowQuizQuestion::find($questions[$i]);
                            if($question->type==='mcq' || $question->type==='feedback_mcq'  ){
                                $selected_options=$quizes[$questions[$i]] ;
                                $option = ShallowQuizAnswer::find($selected_options);
                                $is_true = 0;
                                if($option->is_true==1)
                                {
                                    $is_true = 1;
                                    $total_correct_answers++;
                                }
                                $total_questions++;
                                $question_result[$i]=array('question_id'=> $questions[$i],'is_true'=>$is_true);
                            }
                        }
                        if($total_questions==$total_correct_answers){
                            $is_error=false;
                        }
                    }
                }

                $courseCoachId = null;
                $module=ShallowCourseModule::find( $request->module_id);
                $getMainShallowCourse = ShallowCourse::find($module->course_id);
                if(isset($getMainShallowCourse) && isset($getMainShallowCourse->coach_id)){
                    $courseCoachId = $getMainShallowCourse->coach_id;
                }
                if($module['is_feedback']==0){
                    $where = ['exercise_id' => $request->exercise_id,'section_id' => $request->section_id,'user_id' => $authUser->id];
                    CourseQuizResult::updateOrCreate($where,[
                        'course_id' => $request->get('course_id'),
                        'module_id' => $request->get('module_id'),
                        'section_id' => $request->section_id,
                        'exercise_id' => $request->exercise_id,
                        'coach_id'=>$courseCoachId,
                        'user_id'=>$authUser->id,
                        'result'=>$result,
                        'type'=>$type
                    ]);
                }
                else{
                    $where = ['exercise_id' => $request->exercise_id,'section_id' => $request->section_id,'user_id' => $authUser->id];
                    FeedBackModule::updateOrCreate($where,[
                        'course_id' => $request->get('course_id'),
                        'module_id' => $request->get('module_id'),
                        'section_id' => $request->section_id,
                        'exercise_id' => $request->exercise_id,
                        'user_id'=>$authUser->id,
                        'feedback_result'=>$result
                    ]);
                }
            }
            $lastExercise= ShallowCourseModuleSectionEexercise::where('course_module_section_id',$request->section_id)->orderBy('id','desc')->first('id');
            if(!empty($lastExercise) && isset($lastExercise) && $lastExercise['id']== $request->exercise_id ){
                $totalExercises= ExerciseCompletion::where(['section_id' => $request->section_id,'exercise_id' => $request->exercise_id,'user_id' =>$authUser->id])->count();
                $is_last_exercise=1;
                if($totalExercises>0){
                $is_last_exercise_count=2;
                }
            }

            $where = ['section_id' => $request->section_id,'exercise_id' => $request->exercise_id,'user_id' =>$authUser->id];
            ExerciseCompletion::updateOrCreate($where,[
                'section_id' => $request->section_id,
                'exercise_id' => $request->exercise_id,
                'course_id' => $request->course_id,
                'user_id'=>$authUser->id,
                'completion_status' => 1,
                'is_last_exercise_count' => $is_last_exercise_count,
            ]);

            $totalSectionExercise= ShallowCourseModuleSectionEexercise::where('course_module_section_id',$request->section_id)->count();
            $totalExerciseComplete= ExerciseCompletion::where('section_id',$request->section_id)->where('user_id',$authUser->id)->count();

            if($totalSectionExercise == $totalExerciseComplete){
                $where = ['section_id' => $request->section_id,'module_id' => $request->module_id,'user_id' =>$authUser->id];
                SectionCompletion::updateOrCreate($where,[
                    'section_id' => $request->section_id,
                    'module_id' => $request->module_id,
                    'user_id'=>$authUser->id,
                    'completion_status' => 1
                ]);


              $module=ShallowCourseModule::find( $request->module_id);

                //count how many sections completed of module
                $isModuleComplete=0;
                if($module->childSubModules->count()==0){
                        $totalModuleSections = ShallowCourseModuleSection::where('course_module_id', $request->module_id )->where('status', '=', 'Y')->count();
                        $totalSectionComplete= SectionCompletion::where('module_id',$request->module_id)->where('user_id',$authUser->id)->count();
                        if($totalModuleSections==$totalSectionComplete){
                            $isModuleComplete=1;
                        }
                }else{
                    $totalModuleSections = ShallowCourseModuleSection::where('course_module_id', $request->module_id )->where('status', '=', 'Y')->count();
                    $totalSectionComplete= SectionCompletion::where('module_id',$request->module_id)->where('user_id',$authUser->id)->count();
                    if(isset($module->childSubModules) && count($module->childSubModules) > 0){
                        foreach($module->childSubModules as $subModule){
                            $result=getChildModules($subModule);
                        }
                        if(isset($result) && !empty($result) ){
                            if(($totalModuleSections==$totalSectionComplete) && ($result['totalModules']==$result['totalModulesComplete'])  ){
                                $isModuleComplete=1;
                            }
                        }
                    }
                }


                if( $isModuleComplete==1){
                    $where = ['course_id' => $request->course_id,'module_id' => $request->module_id,'user_id' =>$authUser->id];
                    ModuleCompletion::updateOrCreate($where,[
                        'course_id' => $request->course_id,
                        'module_id' => $request->module_id,
                        'user_id'=>$authUser->id,
                        'completion_status' => 1
                    ]);
                    // count how many modules of course completed
                $total_modules=0;
                $modules_arr=array();
                $courseModules=ShallowCourseModule::with('sections.exercise')->where(['course_id'=> $request->course_id])->where('status', '=', 'Y')->get();
                foreach($courseModules as $subModule){

                if($subModule->sections->count()!=0){

                    foreach($subModule['sections'] as $section){

                        if(count($section['exercise'])!=0){

                         if(!in_array($subModule->id,$modules_arr)){

                           array_push($modules_arr,$subModule->id);
                        }

                      }

                     }

                   }
                 }

                   $total_modules= count($modules_arr);

                   $totalModulesComplete=ModuleCompletion::where('course_id',$request->course_id)->where('user_id',$authUser->id)->count();
                    if($total_modules==$totalModulesComplete){
                        $where = ['course_id' => $request->course_id,'user_id' =>$authUser->id];
                        CourseCompletion::updateOrCreate($where,[
                            'course_id' => $request->course_id,
                            'user_id'=>$authUser->id,
                            'completion_status' => 1
                        ]);
                        $exercise=ShallowCourseModuleSectionEexercise::find($request->exercise_id);
                        if($exercise){
                            // email to user that course is complete
                            $user= $authUser;
                            if($exercise->type==='quiz'){
                                $course = ShallowCourse::find($request->course_id);
                                $attach = $this->sendCourseCertificate($request->course_id, $request->user_id);
                                (new User())->courseCompleteEmail($user,$course->title, $attach);
                            }
                        }
                        $sectionCompleteDetail = [
                            'section_id' => $request->section_id,
                            'module_id' => $request->module_id,
                            'course_id' => $request->course_id,
                        ];

                      return ['success' => true,'sectionCompleteDetail' => $sectionCompleteDetail,'course_complete' => true];

                    }
                }
            }
            return ['success' => true,'next' =>  url($request->next), 'is_last_exercise_count' => $is_last_exercise_count,'is_last_exercise'=>$is_last_exercise,'only_text'=>$only_text,'data' =>json_encode($question_result),'only_mcq'=>$only_mcq ,'all_exist'=>$all_exist ,'is_error'=>$is_error];
        }
        return ['success' => false, 'data' =>json_encode($question_result) , 'is_last_exercise_count' => $is_last_exercise_count,'is_last_exercise'=>$is_last_exercise ,'next' =>  url($request->next) ,'only_text'=>$only_text ,'only_mcq'=>$only_mcq ,'all_exist'=>$all_exist];
    }

    public function uploadExerciseFile($request){
        $authUser = User::find($request->user_id);
        if($request->file('uploadDoc'))
        {

            $module = ShallowCourseModule::find($request->module_id);
            $exercise = ShallowCourseModuleSectionEexercise::find($request->exercise_id);
            $file = $request->file('uploadDoc');
            $course = ShallowCourse::find($request->course_id);
            $file_name = substr($request->file('uploadDoc')->getClientOriginalName(),0,-4);
            $ext = '.'.$request->file('uploadDoc')->getClientOriginalExtension();
            $completeFileName = @$course->id.'-'.$request->module_id.'-'. $request->section_id.'-'.$exercise->id.'-'.$file_name.$ext;

           if(app()->environment() == 'local'){
            $path = 'http://127.0.0.1:8002/up_data/shallow_courses/upload/'.$authUser->id;
            }else{
            $path = 'https://web.dvmcentral.com/up_data/shallow_courses/upload/'.$authUser->id;
           }

             if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $file->move($path, $completeFileName);
            $exercise->file = $completeFileName;
            $exercise->save();
            return $exercise;
        }
    }

    public function sendCourseCertificate($course_id, $user_id)
    {
            $fpdi = new FPDI;
            $user = User::find($user_id);
            $course = shallowCourse::find($course_id);

            $filePath = public_path("/storage/certificate/certificate.pdf");
            $outputFilePath = public_path("/storage/certificate/coursecertificate.pdf");
            //
            $pageWidth = 210;
            $pageHeight = 297;


            $count = $fpdi->setSourceFile($filePath);
              for ($i=1; $i <= $count; $i++)
               {

                   $template = $fpdi->importPage($i);
                   $size = $fpdi->getTemplateSize($template);
                   $fpdi->AddPage('L', [$pageWidth, $pageHeight]);
                   $fpdi->useTemplate($template);


                $cells = [
                    ['left' => 12.6, 'top' => 93, 'name' => 'CERTIFICATE OF COMPLETION', 'fontSize' => 30 ,'bold'=>'B'],
                    ['left' => 12.6, 'top' => 120, 'name' => 'AWARDED TO:', 'fontSize' => 8,'bold'=>'B'],
                    ['left' => 12.6, 'top' => 135, 'name' => $user->first_name.' '.$user->last_name, 'fontSize' => 16,'bold'=>'B'],
                    ['left' => 12.6, 'top' => 155, 'name' => $course->title , 'fontSize' => 28,'bold'=>'B'],
                    ['left' => 0, 'top' => 175, 'name' => 'Date of Completion: '.date('M,j Y'), 'fontSize' => 10,'bold'=>''],
                    ['left' => 230, 'top' => 55, 'name' => '4', 'fontSize' => 20,'bold'=>'B'],
                    ['left' => 230, 'top' => 70, 'name' => 'Hours of CPD', 'fontSize' => 10,'bold'=>'B'],

                ];
                foreach ($cells as $cell) {
                    $left = $cell['left'];
                    $top = $cell['top'];
                    $name = $cell['name'];
                    $fontSize = $cell['fontSize'];
                    $bold = $cell['bold'];

                    $fpdi->SetFont("helvetica", $bold, $fontSize);
                    $fpdi->SetTextColor(66,64,66);

                    $fpdi->SetX($left);
                    $fpdi->Cell(0, $top, $name, 0, 0, 'C');
                }

               }

                $fpdi->Output($outputFilePath, 'F');
                unset($fpdi);
                $course->email_sent ='Y';
                $course->save();

               return $outputFilePath;
    }

    public function marking($user_Id)
    {
        $data['completed_courses'] = CourseCompletion::with('user','course.completed_exercises')->get();
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function markingCourseDetail($id)
    {
        $data['course'] = CourseCompletion::with('user','course.modules.sections.completed_exercises.exercise.exercise_result')->where('id',$id)->first();
        foreach($data['course']['course']['modules'] as $key => $module)
        {
            $module['is_hide']=0;
            $totalSectionsHide=0;
            $totalSections=count($module['sections']);
            if(isset($module['sections'][$key]['completed_exercises']) && count($module['sections'][$key]['completed_exercises']) > 0)
            {
                foreach($module['sections'] as $key => $section)
                {
                    $section['is_hide']=0;
                    $totalExercises=count($section['completed_exercises']);
                    $total_marked_exercises=0;
                    foreach($section['completed_exercises'] as $index => $cExercise){
                        if(isset($cExercise) && isset($cExercise['exercise']) && count($cExercise['exercise']) > 0){
                            foreach ($cExercise['exercise'] as $exer){
                                if(isset($exer['exercise_result']->type)){
                                    if ($exer['exercise_result']->type == 'both' || $exer['exercise_result']->type == 'text'){
                                        $total_marked_exercises++;
                                    }
                                }
                            }
                        }
                    }
                    if($totalExercises==0 || $total_marked_exercises==0){
                        $section['is_hide']=1;
                        $totalSectionsHide++;
                    }
                }
            }
            if($totalSectionsHide==$totalSections){
                $module['is_hide']=1;
            }
        }
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function markingExerciseDetail($id)
    {
        $data['exercise'] = CourseQuizResult::with('exercise')->where('exercise_id',$id)->get();
        $unserializedData = unserialize($data['exercise'][0]->result);
        $newArray = [];
        foreach ($unserializedData as $key => $value) {
            $newArray[] = [
                'question' => $key,
                'answer' => $value
            ];
        }
        $data['exercise'][0]['result'] = $newArray;

        return response()->json(['data' => $data, 'success' => true], 200);
    }

    public function exerciseMark(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'course_id' => 'required',
            'section_id' => 'required',
            'module_id' => 'required',
            'exercise_id' => 'required',
            'course_user_id' => 'required',
        ]);
        
        $where = ['exercise_id' => $request->exercise_id,'marking_user_id' =>$request->user_id,'section_id' => $request->section_id];
            $markingSubmission=MarkingSubmission::updateOrCreate($where,[
            'course_id' => $request->course_id,
            'module_id' => $request->module_id,
            'section_id' => $request->section_id,
            'exercise_id' => $request->exercise_id,
            'marking_user_id' => $request->user_id,
            'course_user_id' => $request->course_user_id,
            'comments' => $request->comments,
        ]);

        $questions=$request->question_ids;
        $feedback=$request->feedback;
        $status=$request->status;
        if(isset($questions) && !empty($questions) ){
            for ($i = 0 ; $i < count($questions); $i++)
            {
                $question = $questions[$i];
                MarkingSubmissionResult::create([
                    'marking_submission_id' => $markingSubmission->id,
                    'question_id' =>$question,
                    'feedback' =>  $feedback[$i],
                    'status' => $status[$question]
                ]);
            }
        }
        $data['id'] = $request->course_id;
        return response()->json(['data' => $data, 'success' => true], 200);
    }

    
}
