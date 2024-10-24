<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CourseCategory;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Categories';
        $categories   = CourseCategory::searchable(['name'])->orderBy('name')->paginate(getPaginate());
        return view('admin.category.index', compact('pageTitle', 'categories'));
    }

    public function store(Request $request, $id = 0)
    {
        if ($id) {
            $category           = CourseCategory::findOrFail($id);
            $notification       = 'Category updated successfully';
        } else {
            $category           = new CourseCategory();
            $notification       = 'Category added successfully';
        }
        $category->name    = $request->name;
        $category->short_description    = $request->short_description;
        $category->slug = $this->slugify($request->name);
        $category->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }
}
