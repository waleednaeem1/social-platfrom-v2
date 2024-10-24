<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Location;
use App\Models\NewsPost;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $pageTitle = 'All News';
        $allNews   = NewsPost::searchable(['name'])->orderBy('name')->paginate(getPaginate());
        return view('admin.news.index', compact('pageTitle', 'allNews'));
    }

    public function store(Request $request, $id = 0)
    {
        // $imageValidation = $id ? 'nullable' : 'required';

        // $request->validate([
        //     'name'       => 'required|max:40|unique:news,id,'.$id,
        //     'heading_content'    => 'required|max:255',
        //     'image_thumbnail'      => ["$imageValidation", new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        // ]);

        if ($id) {
            $news           = NewsPost::findOrFail($id);
            $notification       = 'News updated successfully';
        } else {
            $news           = new NewsPost();
            $notification       = 'News added successfully';
        }

        // if ($request->hasFile('image')) {
            
        //     try {
        //         $news->image_thumbnail = fileUploader($request->image_thumbnail, getFilePath('news'), getFileSize('news'), @$news->image_thumbnail);
        //     } catch (\Exception $exp) {
        //         $notify[] = ['error', 'Couldn\'t upload category image'];
        //         return back()->withNotify($notify);
        //     }
        // }

        $news->name    = $request->name;
        $news->heading_content = $request->heading_content;
        $news->short_content = $request->short_content;
        $news->full_content = $request->full_content;
        
        $news->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function location()
    {
        $pageTitle = 'All Locations';
        $locations   = Location::searchable(['name'])->orderBy('name')->paginate(getPaginate());
        return view('admin.location.index', compact('pageTitle', 'locations'));
    }

    public function locationStore(Request $request, $id = 0)
    {
        $request->validate([
            'name'       => 'required|unique:locations|max:40'
        ]);

        if ($id) {
            $location           = Location::findOrFail($id);
            $notification       = 'Location updated successfully';
        } else {
            $location           = new Location();
            $notification       = 'Location added successfully';
        }

        $location->name    = $request->name;
        $location->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }
}
