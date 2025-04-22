<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Feedback;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    protected $dir = "layouts.";

    public function home()
    {
        return view($this->dir . "home");
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
        $existingUser = User::where('email', $request->email)->first();

        if (!$existingUser) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make("password");
            $user->save();

            $patient = new Patient;
            $patient->user_id = $user->id;
            $patient->first_name = $request->name;
            $patient->country_id = 1;
            $patient->language_id = 1;
            $patient->save();

            $user->assignRole('Patient');

            $feedback = new Feedback();
            $feedback->user_id = $user->id;
            $feedback->feedback = null;
            $feedback->date = now();
            $feedback->subject = $request->subject;
            $feedback->improvement = null;
            $feedback->note = $request->message;
            $feedback->save();

            Session::flash('success', __("site.Feedback created successfully"));
            return redirect()->back();
        }

        if (!Auth::check()) {
            Session::flash('error', __("site.The email already exists. Please log in to submit feedback."));
            return redirect()->back();
        }

        if (Auth::user()->email === $request->email) {
            $feedback = new Feedback();
            $feedback->user_id = Auth::user()->id;
            $feedback->feedback = null;
            $feedback->date = now();
            $feedback->subject = $request->subject;
            $feedback->improvement = null;
            $feedback->note = $request->message;
            $feedback->save();

            Session::flash('success', __("site.Feedback created successfully"));

            return redirect()->back();
        }

        Session::flash('error', __("site.This email is associated with another account."));
        return redirect()->back();
    }

    public function aboutUs()
    {
        $doctors = Doctor::orderBy('id', 'desc')->take(2)->get();
        $allUsers = User::count();
        $patientsCount = Patient::count();
        $doctorsCount = Doctor::count();
        return view($this->dir . "about-us", compact('doctors', 'doctorsCount', 'patientsCount', 'doctorsCount', 'allUsers'));
    }
}
