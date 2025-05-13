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
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(6);
        return view($this->dir . "list", compact('blogs'));
    }

    public function index(Request $request)
    {
        $locale = app()->getLocale();

        $query = Blog::query();

        if ($request->filled('title')) {
            $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(title, '$.\"$locale\"'))) LIKE ?", ['%' . strtolower($request->title) . '%']);
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(8)->appends([
            'title' => $request->title,
        ]);
        $last_blogs = Blog::latest()->limit(3)->get();

        return view($this->dir . "index", compact('blogs', 'last_blogs'));
    }

    public function create()
    {
        return view($this->dir . "create");
    }

    public function store(Request $request)
    {
        try {
            $blog = new blog;
            $titles = [];
            $descriptions = [];

            foreach (config('app.locales') as $locale) {
                $titles[$locale] = $request->input("title_$locale");
                $descriptions[$locale] = $request->input("description_$locale");
            }

            $blog = new Blog;
            $blog->title = json_encode($titles);
            $blog->description = json_encode($descriptions, JSON_UNESCAPED_UNICODE);

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
            $titles = [];
            $descriptions = [];

            foreach (config('app.locales') as $locale) {
                $titles[$locale] = $request->input("title_$locale");
                $descriptions[$locale] = $request->input("description_$locale");
            }

            $blog->title = json_encode($titles);
            $blog->description = json_encode($descriptions, JSON_UNESCAPED_UNICODE);
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
        $descriptions = json_decode($blog->description, true);
        $titles = json_decode($blog->title, true);
        $currentDescription = $descriptions[app()->getLocale()] ?? '';
        $currentTitle = $titles[app()->getLocale()] ?? '';

        $last_blogs = Blog::latest()->limit(3)->get();
        return view($this->dir . "show", compact('blog','last_blogs','currentDescription','currentTitle'));
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
