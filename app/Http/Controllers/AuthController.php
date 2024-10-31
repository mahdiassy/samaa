<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Language;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DateTime;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    protected $dir = "auth.";

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view($this->dir . "login");
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()
                ->intended(route('dashboard'))
                ->with('status', [
                    'type' => 'success',
                    'msg' => 'Successfully Logged-in'
                ]);
        }
        return redirect()->route('dashboard')->with('success', 'success');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        $countries = Country::all();
        $languages = Language::all();
        return view($this->dir . "register", compact('countries', 'languages'));
    }

    public function registerPatient(Request $request)
    {
        try {
            $patient = new Patient;
            $patient->first_name = $request->first_name;
            $patient->last_name = null;
            $patient->phone = $request->phone;
            $patient->address = $request->address;
            $patient->birthday = $request->birthday;
            $patient->country_id = $request->country;
            $patient->language_id = $request->language;
            $patient->gender = $request->gender;
            $patient->blood_type = $request->blood_type;
            $patient->weight = $request->weight;
            $patient->height = $request->height;
            $patient->is_smoker = $request->smoker;
            $patient->twitter = null;
            $patient->facebook = null;
            $patient->instagram = null;

            $user = new User;
            $user->name = $request->first_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $user->assignRole('Patient');

            $patient->user_id = $user->id;

            if ($request->has('image')) {
                $image = $request->file('image');
                $patient->image = $this->storeFile($image, 'Patient image');
            } else {
                $patient->image = '/avatar1.png';
            }

            $patient->save();

            Auth::guard()->login($user);

            return redirect()->route('dashboard')->with('success', 'success');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                Session::flash('error', 'This email is already registered.');
            } else {
                throw $e;
            }
        }

        return redirect()->back();
    }
}
