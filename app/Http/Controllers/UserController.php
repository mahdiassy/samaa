<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get_user($id) {
        $user = User::find($id)->load('roles');
        return $user;
    }
}
