<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    protected $dir = "blog.";

    public function list()
    {
        $blogs = Blog::paginate(6);
        return view($this->dir . "list", compact('blogs'));
    }

    public function index(Request $request)
    {
        $blogs = Blog::paginate(10);

        return view($this->dir . "index", compact('blogs'));
    }

    public function create()
    {
        return view($this->dir . "create");
    }

    public function store(Request $request)
    {
        try {
            $blog = new blog;
            $blog->title = $request->title;
            $blog->description = $request->description;
            $blog->user_id = Auth::user()->id;

            if ($request->has('image')) {
                $image = $request->file('image');
                $blog->image = $this->storeFile($image, 'Blog');
            }
            $blog->save();

            return redirect()->route('blog.list')->with('status', [
                'type' => 'success',
                'title' =>  __("site.Success"),
                'msg' => __("site.Blog created successfully")
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            dd($e);
        }

        return redirect()->back();
    }

    public function edit(Blog $blog)
    {
        return view($this->dir . "edit", compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        try {
            $blog->title = $request->title;
            $blog->description = $request->description;
            $blog->user_id = Auth::user()->id;

            if ($request->has('image')) {
                $image = $request->file('image');
                $blog->image = $this->storeFile($image, 'Blog');
            }
            $blog->save();

            return redirect()->route('blog.list')->with('status', [
                'type' => 'success',
                'title' =>  __("site.Success"),
                'msg' => __("site.Blog updated successfully")
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            dd($e);
        }

        return redirect()->back();
    }

    public function show(Blog $blog)
    {
        return view($this->dir . "show", compact('blog'));
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blog.list')->with('status', [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Blog deleted successfully")
        ]);
    }
}
