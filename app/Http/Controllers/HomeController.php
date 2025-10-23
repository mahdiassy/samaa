<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    protected $dir = "layouts.";

    public function home()
    {
        $blogs = Blog::latest()->take(3)->get();
        $response = response()->view($this->dir . "home", compact('blogs'));
        $response->header('Content-Type', 'text/html; charset=UTF-8');
        return $response;
    }

    public function index()
    {
        return view($this->dir . "dashboard");
    }

    public function contactUs()
    {
        return view($this->dir . "contact-us");
    }

    public function storeContactUsForm(Request $request)
    {
        try {
            $feedback = new Feedback();
            if($request->full_name){
                $feedback->full_name = $request->full_name;
            }else{
                $feedback->full_name = $request->first_name.' '.$request->surname;
            }
            $feedback->email = $request->email;
            $feedback->date = now();
            $feedback->subject = $request->subject;
            $feedback->message = $request->message;
            $feedback->cta_type = 'Feedback';
            $feedback->cta_source = $request->cta_source;
            $feedback->save();

            Session::flash('success', __("site.Feedback created successfully"));

            return redirect()->back();

        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash('error', __("site.Error"));
        }
    }

    public function aboutUs()
    {
        return view($this->dir . "about-us");
    }

    public function howItWork()
    {
        return view($this->dir . "how-it-work");
    }

    public function therapists()
    {
        return view($this->dir . "Therapists");
    }
}
