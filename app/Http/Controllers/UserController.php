<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $dir = "auth.";

    public function get_user($id) {
        $user = User::find($id)->load('roles');
        return $user;
    }

    public function changePassword()
    {
        return view($this->dir . "change_password");
    }

    public function changePasswordSaved(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('status', [
                'type' => 'error',
                'title' =>  __("site.Error"),
                'msg' => __("site.The old password is incorrect")
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('status', [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Password updated successfully")
        ]);
    }
}
