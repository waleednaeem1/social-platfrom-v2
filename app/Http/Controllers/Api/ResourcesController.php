<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\NewsPost;
use App\Models\Speaker;
use App\Models\WebinarRegistration;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function bloglist()
    {
        $date = date('Y-m-d');
        $blogList = BlogPost::where('status', 'Y')->where('publish_date', '<=', $date)->select('id','name','slug','short_content','image_thumbnail','publish_date','meta_title','meta_keywords','meta_description')->orderBy('publish_date', 'desc')->get();
        return response()->json(['success' => true, 'blog_list'=> $blogList],200);
        
    }

    public function blogDetail($slug)
    {
        $date = date('Y-m-d');
        $data['post'] = BlogPost::where('status', 'Y')->where('publish_date', '<=', $date)->where('slug', $slug)->first();
        if ($data['post']) {
            $data['recent_posts'] = BlogPost::where('status', 'Y')->where([['publish_date', '<=', $date],['id', '!=', $data['post']->id]])->orderBy('publish_date', 'desc')->paginate(8);
        }  
        return response()->json(['success' => true, 'blog'=> $data],200);
    }

    public function newslist()
    {
        $data['news'] = NewsPost::where('status', 'Y')->select('id','name','slug','image_thumbnail','publish_date','top_image_banner','meta_title','meta_keywords','meta_description')->orderBy('publish_date', 'DESC')->get();

        return response()->json(['success' => true, 'news'=> $data['news']],200);
    }

    public function newsDetail($slug)
    {
        /* Fetching Specific news details */
        $data['news'] = NewsPost::where([['slug', $slug],['status', 'Y']])->first();
        /* Fetching Recent News in DESC order with limit 5 */
        if($data['news']) {
            $data['recentNews'] = NewsPost::where([['status', 'Y'],['id', '!=', $data['news']->id]])->orderBy('publish_date', 'DESC')->limit(5)->get();
        }    
        return response()->json(['success' => true, 'news'=> $data],200);
    }

    public function myWebinars($email)
    {
        $data['myWebinars'] = WebinarRegistration::with('webinar')->where(['email' => $email])->get();
        return response()->json(['success' => true, 'my_webinars'=> $data['myWebinars']],200);
    }

    public function speakers()
    {
        $data['speakers'] = Speaker::with('webinarSpeakers')->where('status', 'Y')->select('id','slug','first_name','last_name', 'credentials', 'institute', 'job_title', 'profile','meta_title','meta_keywords','meta_description','sm_facebook','sm_linkedin','sm_twitter','sm_instagram','sm_pinterest','sm_youtube','sm_vimeo')->get();
        return response()->json(['success' => true, 'speakers'=> $data['speakers'] ],200);
    }

    public function speakerDetail($slug)
    {
        $data['speaker'] = Speaker::with('webinarSpeakers')->where('slug', $slug)->get();
        return response()->json(['success' => true, 'speakers'=> $data['speaker']],200);
    }
}
