<?php

use App\Models\ShallowCourseModuleSection;
use App\Models\SectionCompletion;
use App\Models\ModuleCompletion;

use App\Models\Frontend;
use App\Models\GeneralSetting;
use Carbon\Carbon;
use App\Lib\Captcha;
use App\Lib\ClientInfo;
use App\Lib\CurlRequest;
use App\Lib\FileManager;
use App\Notify\Notify;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

function removeSession($session){
    if(\Session::has($session)){
        \Session::forget($session);
    }
    return true;
}

function randomString($length,$type = 'token'){
    if($type == 'password')
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    elseif($type == 'username')
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    else
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $token = substr( str_shuffle( $chars ), 0, $length );
    return $token;
}

function activeRoute($route, $isClass = false): string
{
    $requestUrl = request()->fullUrl() === $route ? true : false;

    if($isClass) {
        return $requestUrl ? $isClass : '';
    } else {
        return $requestUrl ? 'active' : '';
    }
}

function checkRecordExist($table_list,$column_name,$id){
    if(count($table_list) > 0){
        foreach($table_list as $table){
            $check_data = \DB::table($table)->where($column_name,$id)->count();
            if($check_data > 0) return false ;
        }
        return true;
    }
    return true;
}

// Model file save to storage by spatie media library
function storeMediaFile($model,$file,$name)
{
    if($file) {
        $model->clearMediaCollection($name);
        if (is_array($file)){
            foreach ($file as $key => $value){
                $model->addMedia($value)->toMediaCollection($name);
            }
        }else{
            $model->addMedia($file)->toMediaCollection($name);
        }
    }
    return true;
}

// Model file get by storage by spatie media library
function getSingleMedia($model, $collection = 'image_icon',$skip=true)
{
    if (!\Auth::check() && $skip) {
        return asset('images/avatars/01.png');
    }
    if ($model !== null) {
        $media = $model->getFirstMedia($collection);
    }
    $imgurl= isset($media)?$media->getPath():'';
    if (file_exists($imgurl)) {
        return $media->getFullUrl();
    }
    else
    {
        switch ($collection) {
            case 'image_icon':
                $media = asset('images/avatars/01.png');
                break;
            case 'profile_image':
                $media = asset('images/avatars/01.png');
                break;
            default:
                $media = asset('images/common/add.png');
                break;
        }
        return $media;
    }
}

// File exist check
function getFileExistsCheck($media)
{
    $mediaCondition = false;
    if($media) {
        if($media->disk == 'public') {
            $mediaCondition = file_exists($media->getPath());
        } else {
            $mediaCondition = \Storage::disk($media->disk)->exists($media->getPath());
        }
    }
    return $mediaCondition;
}

function appName()
{
    return config('app.name', 'Devsinc');
}

$totalModulesComplete=0;
$totalModules=0;
function getChildModules($subModule)
{
    global $totalModulesComplete, $totalModules;
    $totalModules++;
    $totalModuleSections = ShallowCourseModuleSection::where('course_module_id', $subModule->id )->where('status', '=', 'Y')->count();
    $totalSectionComplete= SectionCompletion::where('module_id',$subModule->id )->where('user_id',auth()->user()->id)->count();
    if($totalModuleSections == $totalSectionComplete){
        $totalModulesComplete++;
    }
    if ($subModule->sub_modules){
        foreach ($subModule->sub_modules as $childModule)
        {
            getChildModules($childModule);
        }
    }
    return array('totalModules'=>$totalModules, 'totalModulesComplete'=> $totalModulesComplete );
}

function getModuleExercises($module,$type='')
{
        $totalSectionsHide=0;
        $totalModuleExercises=0;
        $totalSections=count($module['sections']);

        if($totalSections>0){
            foreach($module['sections'] as $key => $section)
            {
                $section['is_hide']=0;
                $total_marked_exercises=0;
                $totalExercises=count($section['completed_exercises']);
                if($totalExercises>0){
                  foreach($section['completed_exercises'] as $index => $cExercise){
                   if(isset($cExercise) && isset($cExercise['exercise'])){

                    if($cExercise['exercise']->type==='quiz' && isset($cExercise['exercise']['exercise_result']->type)){

                      if ($cExercise['exercise']['exercise_result']->type == 'both' || $cExercise['exercise']['exercise_result']->type == 'text')
                     {

                        $total_marked_exercises++;
                        $totalModuleExercises++;
                     }
                      }elseif($cExercise['exercise']->type==='file_upload'){

                        $total_marked_exercises++;
                        $totalModuleExercises++;
                     }

                    }
                  }

                }

                if($total_marked_exercises==0 || $totalExercises==0){
                        $section['is_hide']=1;
                        $totalSectionsHide++;
                }
            }
        }

        if($totalSectionsHide==$totalSections || $totalSections==0){
            $module->is_mark=1;
            if(!$type){
                $module->save();
            }
            $module['is_hide']=1;
            }else{
            $module['is_hide']=0;
        }
        return  $totalModuleExercises;
}

function searchMarkingResult($value, $key, $array) {
    foreach ($array as $k => $val) {
        if ($val[$key] == $value) {
            return $val;
        }
    }
    return null;
}

function countModuleExercises($course){
    $modules=ModuleCompletion::where(['course_id'=>$course->id,'is_mark'=>0])->get();
    $total_exercises=0;
    foreach($modules as $key=>$module){
        $total= getModuleExercises($module);
        if($total>0){
            $total_exercises=$total;
        }
    }
    return $total_exercises;
}


function menuActive($routeName, $type = null, $param = null)
{
    if ($type == 3) $class = 'side-menu--open';
    elseif ($type == 2) $class = 'sidebar-submenu__open';
    else $class = 'active';

    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) return $class;
        }
    } elseif (request()->routeIs($routeName)) {
        if ($param) {
            $routeParam = array_values(@request()->route()->parameters ?? []);
            if (strtolower(@$routeParam[0]) == strtolower($param)) return $class;
            else return;
        }
        return $class;
    }
}

function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}

function getPageSections($arr = false)
{
    $jsonUrl = resource_path('views/') . str_replace('.', '/', activeTemplate()) . 'sections.json';
    $sections = json_decode(file_get_contents($jsonUrl));
    if ($arr) {
        $sections = json_decode(file_get_contents($jsonUrl), true);
        ksort($sections);
    }
    return $sections;
}

function activeTemplate($asset = false)
{
    $general = gs();
    $template = $general->active_template;
    if ($asset) return 'assets/templates/' . $template . '/';
    return 'templates.' . $template . '.';
}

function activeTemplateName()
{
    $general = gs();
    $template = $general->active_template;
    return $template;
}
function gs()
{
    $general = Cache::get('GeneralSetting');
    if (!$general) {
        $general = GeneralSetting::first();
        Cache::put('GeneralSetting', $general);
    }
    return $general;
}

function systemDetails()
{
    $system['name'] = 'devsinc social';
    $system['version'] = '2.0';
    $system['build_version'] = '4.4.1';
    return $system;
}

function showAmount($amount, $decimal = 2, $separate = true, $exceptZeros = false)
{
    $separator = '';
    if ($separate) {
        $separator = ',';
    }
    $printAmount = number_format($amount, $decimal, '.', $separator);
    if ($exceptZeros) {
        $exp = explode('.', $printAmount);
        if ($exp[1] * 1 == 0) {
            $printAmount = $exp[0];
        } else {
            $printAmount = rtrim($printAmount, '0');
        }
    }
    return $printAmount;
}

function getImage($image, $size = null)
{
    $clean = '';
    if (file_exists($image) && is_file($image)) {
        return asset($image) . $clean;
    }
    // if ($size) {
    //     return route('placeholder.image', $size);
    // }
    return asset('assets/images/default.png');
}

function getPaginate($paginate = 20)
{
    return $paginate;
}

function paginateLinks($data)
{
    return $data->appends(request()->all())->links();
}

function fileUploader($file, $location, $size = null, $old = null, $thumb = null)
{
    $fileManager = new FileManager($file);
    $fileManager->path = $location;
    $fileManager->size = $size;
    $fileManager->old = $old;
    $fileManager->thumb = $thumb;
    $fileManager->upload();
    return $fileManager->filename;
}

function fileManager()
{
    return new FileManager();
}

function getFilePath($key)
{
    return fileManager()->$key()->path;
}

function getFileSize($key)
{
    return fileManager()->$key()->size;
}

function getFileExt($key)
{
    return fileManager()->$key()->extensions;
}

function strLimit($title = null, $length = 10)
{
    return Str::limit($title, $length);
}

function showDateTime($date, $format = 'Y-m-d h:i A')
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->translatedFormat($format);
}

if (! function_exists('to_route')) {
    /**
     * Create a new redirect response to a named route.
     *
     * @param  string  $route
     * @param  mixed  $parameters
     * @param  int  $status
     * @param  array  $headers
     * @return \Illuminate\Http\RedirectResponse
     */
    function to_route($route, $parameters = [], $status = 302, $headers = [])
    {
        return redirect()->route($route, $parameters, $status, $headers);
    }
}

