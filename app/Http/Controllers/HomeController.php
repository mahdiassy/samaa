<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $dir = "layouts.";

    public function index() {
        return view($this->dir . "dashboard");
    }
}
