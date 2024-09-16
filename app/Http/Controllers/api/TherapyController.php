<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\api\ApiResponse;
use App\Models\Doctor;
use App\Models\Therapy;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TherapyController extends Controller
{
    public function index()
    {
        $therapies = collect();
        if (auth()->user()->hasRole('Admin')) {
            $therapies = Therapy::paginate(9);
        } elseif (auth()->user()->hasRole('Doctor')) {
            $therapies = Therapy::where('user_id', Auth::id())->paginate(9);
        } elseif (auth()->user()->hasRole('Patient')) {
            $user = Patient::where('user_id', Auth::id())->first();
            $therapyIds = DB::table('patient_therapy')
                ->where('patient_id', $user->id)
                ->pluck('therapy_id');

            $therapies = Therapy::whereIn('id', $therapyIds)->get();
        }
        return ApiResponse::successResponse($therapies);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:128',
            'file' => 'required|file|mimes:mp3,wav,ogg',
        ]);
        if ($validator->fails()) {
            return ApiResponse::unAuthorizedResponse($validator->errors());
        }
        $therapy = new Therapy;
        $therapy->name = $request->name;
        $therapy->user_id = Auth::id();

        if ($request->has('file')) {
            $file = $request->file('file');
            $therapy->file = $this->storeFileEncrypt($file, 'Doctor therapy');
        }
        $therapy->save();

        return ApiResponse::successResponse(true ,'Doctor created Therapy successfully.' );
    }

    public function update(Request $request, $id)
    {
        $therapy = Therapy::find($id);
        if (!$therapy) {
            $error = 'Could not find Therapy!';
            return ApiResponse::notFoundResponse($error);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|min:2|max:128',
            'file' => 'file|mimes:mp3,wav,ogg',
        ]);
        if ($validator->fails()) {
            return ApiResponse::unAuthorizedResponse($validator->errors());
        }
        $therapy->name = $request->name ? $request->name : $therapy->name;
        $therapy->user_id = Auth::id();

        if ($request->has('file')) {
            $file = $request->file('file');
            $therapy->file = $this->storeFileEncrypt($file, 'Doctor therapy');
        }
        $therapy->save();

        return ApiResponse::successResponse(true ,'Doctor Updated Therapy successfully.' );
    }

    public function destroy($id)
    {
        $therapy = Therapy::find($id);
        if (!$therapy) {
            $error = 'Could not find Therapy!';
            return ApiResponse::notFoundResponse($error);
        }
        $therapy->delete();
        return ApiResponse::successResponse(true ,'Therapy deleted successfully.' );
    }

    public function show($id)
    {
        $therapy = Therapy::find($id);
        if (!$therapy) {
            $error = 'Could not find Therapy!';
            return ApiResponse::notFoundResponse($error);
        }
        return ApiResponse::successResponse($therapy);
    }

}
