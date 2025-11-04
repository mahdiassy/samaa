<?php

namespace App\Http\Controllers\api;

use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Http\Controllers\api\ApiResponse;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Therapy;
use App\Models\User;
use App\Services\File\FileUploadService;
use App\Services\Therapy\TherapyAccessService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TherapyController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService,
        protected TherapyAccessService $therapyAccessService
    ) {
    }

    /*public function __construct()
    {
        $this->middleware('permission:' . Permissions::THERAPY_LIST)->only(['index']);
        $this->middleware('permission:' . Permissions::THERAPY_CREATE)->only(['create', 'store']);
        $this->middleware('permission:' . Permissions::THERAPY_SHOW)->only(['show']);
        $this->middleware('permission:' . Permissions::THERAPY_EDIT)->only(['edit', 'update']);
        $this->middleware('permission:' . Permissions::THERAPY_DELETE)->only(['destroy']);
    }*/

    public function index()
    {
        $therapies = $this->therapyAccessService->getAllTherapiesForUser(Auth::user());
        return ApiResponse::successResponse($therapies);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:128',
            'patient_id' => 'required|string|min:1|max:128',
            'image' => 'file|mimes:jpg,png,svg',
            'file' => 'required|file|mimes:mp3,wav,ogg',
        ]);
        if ($validator->fails()) {
            return ApiResponse::unAuthorizedResponse($validator->errors());
        }
        $therapy = new Therapy;
        $therapy->name = $request->name;
        $therapy->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $therapy->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'therapies'
            );
        }
        
        if ($request->hasFile('file')) {
            $therapy->file = $this->fileUploadService->uploadEncryptedAudio(
                $request->file('file'),
                'therapies'
            );
        }
        
        $therapy->save();

        $patient = Patient::find($request->patient_id);
        $this->therapyAccessService->assignTherapyToPatients($therapy, $patient);

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
            'image' => 'file|mimes:jpg,png,svg',
            'patient_id' => 'string|min:1|max:128',
        ]);
        if ($validator->fails()) {
            return ApiResponse::unAuthorizedResponse($validator->errors());
        }
        $therapy->name = $request->name ? $request->name : $therapy->name;
        $therapy->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $oldImagePath = $therapy->image;
            $therapy->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'therapies',
                $oldImagePath
            );
        }
        
        if ($request->hasFile('file')) {
            $oldFilePath = $therapy->file;
            $therapy->file = $this->fileUploadService->uploadEncryptedAudio(
                $request->file('file'),
                'therapies',
                $oldFilePath
            );
        }
        
        $therapy->save();

        $patient = Patient::find($request->patient_id);
        $this->therapyAccessService->assignTherapyToPatients($therapy, $patient);

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
