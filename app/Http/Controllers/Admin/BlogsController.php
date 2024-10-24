<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Location;
use App\Models\BlogPost;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Blogs';
        $blogs   = BlogPost::searchable(['name'])->orderBy('name')->paginate(getPaginate());
        return view('admin.blog.index', compact('pageTitle', 'blogs'));
    }

    public function store(Request $request, $id = 0)
    {
        // $imageValidation = $id ? 'nullable' : 'required';

        // $request->validate([
        //     'name'       => 'required|max:40|unique:blogs,id,'.$id,
        //     'heading_content'    => 'required|max:255',
        //     'image_thumbnail'      => ["$imageValidation", new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        // ]);

        if ($id) {
            $blogs           = BlogPost::findOrFail($id);
            $notification       = 'Blog updated successfully';
        } else {
            $blogs           = new BlogPost();
            $notification       = 'Blog added successfully';
        }

        // if ($request->hasFile('image')) {
        //     try {
        //         $blogs->image_thumbnail = fileUploader($request->image, getFilePath('blogs'), getFileSize('blogs'), @$blogs->image_thumbnail);
        //     } catch (\Exception $exp) {
        //         $notify[] = ['error', 'Couldn\'t upload blog image'];
        //         return back()->withNotify($notify);
        //     }
        // }

        $blogs->name    = $request->name;
        $blogs->heading_content = $request->heading_content;
        $blogs->short_content = $request->short_content;
        $blogs->full_content = $request->full_content;
        $blogs->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    // public function location()
    // {
    //     $pageTitle = 'All Locations';
    //     $locations   = Location::searchable(['name'])->orderBy('name')->paginate(getPaginate());
    //     return view('admin.location.index', compact('pageTitle', 'locations'));
    // }

    // public function locationStore(Request $request, $id = 0)
    // {
    //     $request->validate([
    //         'name'       => 'required|unique:locations|max:40'
    //     ]);

    //     if ($id) {
    //         $location           = Location::findOrFail($id);
    //         $notification       = 'Location updated successfully';
    //     } else {
    //         $location           = new Location();
    //         $notification       = 'Location added successfully';
    //     }

    //     $location->name    = $request->name;
    //     $location->save();
    //     $notify[] = ['success', $notification];
    //     return back()->withNotify($notify);
    // }
}
