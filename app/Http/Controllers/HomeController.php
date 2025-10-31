<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function home()
    {
        $blogs = Blog::latest()->take(3)->get();
        $response = response()->view("layouts.home", compact('blogs'));
        $response->header('Content-Type', 'text/html; charset=UTF-8');
        return $response;
    }

    public function index()
    {
        return view("layouts.dashboard");
    }

    public function contactUs()
    {
        return view("layouts.contact-us");
    }

    public function storeContactUsForm(\App\Http\Requests\Feedback\StoreFeedbackRequest $request)
    {
        try {
            // Request is automatically validated by StoreFeedbackRequest
            
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

            return redirect()->back()->with('status', [
                'type' => 'success',
                'title' => __("site.Success"),
                'msg' => __("site.Feedback created successfully"),
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('status', [
                'type' => 'error',
                'title' => __("site.Error"),
                'msg' => __("site.Error"),
            ]);
        }
    }

    public function aboutUs()
    {
        return view("layouts.about-us");
    }

    public function howItWork()
    {
        return view("layouts.how-it-work");
    }

    public function Therapists()
    {
        return view("layouts.Therapists");
    }
}
