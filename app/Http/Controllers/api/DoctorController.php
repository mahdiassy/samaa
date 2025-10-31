<?php

namespace App\Http\Controllers\api;

use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Http\Controllers\api\ApiResponse;
use App\Models\Doctor;
use App\Models\User;
use App\Services\File\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function __construct(protected FileUploadService $fileUploadService)
    {
    }
    public function index()
    {
        $doctors = Doctor::paginate(9);
        return ApiResponse::successResponse($doctors);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:128',
            'last_name' => 'nullable|string|min:2|max:128',
            'phone' => 'nullable|string|min:2|max:128',
            'address' => 'nullable|string|min:2|max:128',
            'birthday' => 'nullable|date',
            'twitter' => 'nullable|string|max:128',
            'facebook' => 'nullable|string|max:128',
            'instagram' => 'nullable|string|max:128',
            'email' => 'required|email|max:128|unique:users,email,' . $request->id,
            'password' => 'nullable|string|min:8|max:128|confirmed',
            'role' => 'required|string|min:2|max:128',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return ApiResponse::unAuthorizedResponse($validator->errors());
        }
        $doctor = new Doctor;
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->last_name;
        $doctor->phone = $request->phone;
        $doctor->address = $request->address;
        $doctor->birthday =  $request->birthday;
        $doctor->twitter = $request->twitter;
        $doctor->facebook = $request->facebook;
        $doctor->instagram = $request->instagram;

        $user = new User;
        $user->name = $request->first_name;
        $user->email= $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole($request->role);

        $doctor->user_id = $user->id;

        if ($request->hasFile('image')) {
            $doctor->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'doctors'
            );
        }

        $doctor->save();

        return ApiResponse::successResponse(true ,'Doctor created successfully.' );
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            $error = 'Could not find Doctor!';
            return ApiResponse::notFoundResponse($error);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:128',
            'last_name' => 'nullable|string|min:2|max:128',
            'phone' => 'nullable|string|min:2|max:128',
            'address' => 'nullable|string|min:2|max:128',
            'birthday' => 'nullable|date',
            'twitter' => 'nullable|string|max:128',
            'facebook' => 'nullable|string|max:128',
            'instagram' => 'nullable|string|max:128',
            'email' => 'required|email|max:128|unique:users,email,' . $doctor->user_id,
            'password' => 'nullable|string|min:8|max:128|confirmed',
            'role' => 'required|string|min:2|max:128',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return ApiResponse::unAuthorizedResponse($validator->errors());
        }

        $doctor->first_name = $request->first_name ? $request->first_name : $doctor->first_name;
        $doctor->last_name = $request->last_name ? $request->last_name : $doctor->last_name;
        $doctor->phone = $request->phone ? $request->phone : $doctor->phone;
        $doctor->address = $request->address ? $request->address : $doctor->address;
        $doctor->birthday = $request->birthday ? $request->birthday : $doctor->birthday;
        $doctor->twitter = $request->twitter ? $request->twitter : $doctor->twitter;
        $doctor->facebook = $request->facebook ? $request->facebook : $doctor->facebook;
        $doctor->instagram = $request->instagram ? $request->instagram : $doctor->instagram;

        $user = User::find($doctor->user_id);
        $user->name = $request->first_name ? $request->first_name : $doctor->first_name;
        $user->email= $request->email ? $request->email : $doctor->email;
        $user->save();
        $user->syncRoles($request->role ? $request->role : $doctor->role);

        if ($request->hasFile('image')) {
            $oldImagePath = $doctor->image;
            $doctor->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'doctors',
                $oldImagePath
            );
        }

        $doctor->save();

        return ApiResponse::successResponse(true ,'Doctor Updated successfully.' );

    }

    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            $error = 'Could not find Doctor!';
            return ApiResponse::notFoundResponse($error);
        }
        $user = User::find($doctor->user_id);
        $user->delete();
        $doctor->delete();
        return ApiResponse::successResponse(true ,'Doctor deleted successfully.' );
    }

    public function show($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            $error = 'Could not find Doctor!';
            return ApiResponse::notFoundResponse($error);
        }
        return ApiResponse::successResponse($doctor);
    }
}
