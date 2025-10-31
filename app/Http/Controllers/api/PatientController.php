<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\api\ApiResponse;
use App\Models\Patient;
use App\Models\User;
use App\Services\File\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function __construct(protected FileUploadService $fileUploadService)
    {
    }
    public function index()
    {
        $patients = Patient::with(['user', 'country', 'language'])->paginate(9);
        return ApiResponse::successResponse($patients);
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
        $patient = new Patient;
        $patient->first_name = $request->first_name;
        $patient->last_name = $request->last_name;
        $patient->phone = $request->phone;
        $patient->address = $request->address;
        $patient->birthday =  $request->birthday;
        $patient->twitter = $request->twitter;
        $patient->facebook = $request->facebook;
        $patient->instagram = $request->instagram;

        $user = new User;
        $user->name = $request->first_name;
        $user->email= $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole($request->role);

        $patient->user_id = $user->id;

        if ($request->hasFile('image')) {
            $patient->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'patients'
            );
        }

        $patient->save();

        return ApiResponse::successResponse(true ,'Patient created successfully.' );
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            $error = 'Could not find Patient!';
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
            'email' => 'required|email|max:128|unique:users,email,' . $patient->user_id,
            'password' => 'nullable|string|min:8|max:128|confirmed',
            'role' => 'required|string|min:2|max:128',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return ApiResponse::unAuthorizedResponse($validator->errors());
        }

        $patient->first_name = $request->first_name ? $request->first_name : $patient->first_name;
        $patient->last_name = $request->last_name ? $request->last_name : $patient->last_name;
        $patient->phone = $request->phone ? $request->phone : $patient->phone;
        $patient->address = $request->address ? $request->address : $patient->address;
        $patient->birthday = $request->birthday ? $request->birthday : $patient->birthday;
        $patient->twitter = $request->twitter ? $request->twitter : $patient->twitter;
        $patient->facebook = $request->facebook ? $request->facebook : $patient->facebook;
        $patient->instagram = $request->instagram ? $request->instagram : $patient->instagram;

        $user = User::find($patient->user_id);
        $user->name = $request->first_name ? $request->first_name : $patient->first_name;
        $user->email= $request->email ? $request->email : $patient->email;
        $user->save();
        $user->syncRoles($request->role ? $request->role : $patient->role);

        if ($request->hasFile('image')) {
            $oldImagePath = $patient->image;
            $patient->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'patients',
                $oldImagePath
            );
        }

        $patient->save();

        return ApiResponse::successResponse(true ,'Patient Updated successfully.' );

    }

    public function destroy($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            $error = 'Could not find Patient!';
            return ApiResponse::notFoundResponse($error);
        }
        $user = User::find($patient->user_id);
        $user->delete();
        $patient->delete();
        return ApiResponse::successResponse(true ,'Patient deleted successfully.' );
    }

    public function show($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            $error = 'Could not find Patient!';
            return ApiResponse::notFoundResponse($error);
        }
        return ApiResponse::successResponse($patient);
    }
}
