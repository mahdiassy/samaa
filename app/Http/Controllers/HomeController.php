<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $dir = "layouts.";

    public function index() {
        return view($this->dir . "dashboard");
    }

    public function aboutUs() {
        $doctors = Doctor::orderBy('id', 'desc')->take(2)->get();
        return view($this->dir . "about-us", compact('doctors'));
    }
}
