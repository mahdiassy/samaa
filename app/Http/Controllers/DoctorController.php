<?php

namespace App\Http\Controllers;

use App\Enums\BookingEnum;
use App\Enums\Permissions;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Services\File\FileUploadService;
use App\Services\User\UserRegistrationService;
use App\Services\Response\ResponseService;

class DoctorController extends Controller
{
    protected $dir = "doctor.";

    public function __construct(
        protected FileUploadService $fileUploadService,
        protected UserRegistrationService $userRegistrationService,
        protected ResponseService $responseService
    ) {
        $this->middleware('permission:' . Permissions::DOCTOR_LIST)->only(['index']);
        $this->middleware('permission:' . Permissions::DOCTOR_CREATE)->only(['create', 'store']);
        $this->middleware('permission:' . Permissions::DOCTOR_SHOW)->only(['show']);
        $this->middleware('permission:' . Permissions::DOCTOR_EDIT)->only(['edit', 'update']);
        $this->middleware('permission:' . Permissions::DOCTOR_DELETE)->only(['destroy']);
    }

    public function index()
    {
        $doctors = Doctor::paginate(9);
        return view($this->dir . "index", compact('doctors'));
    }

    public function create()
    {
        return view($this->dir . "create");
    }

    public function store(StoreDoctorRequest $request)
    {
        // Register doctor using service
        $doctor = $this->userRegistrationService->registerDoctor($request->validated());

        return $this->responseService->success(
            __("site.Doctor created successfully"),
            'doctor.index'
        );
    }

    public function edit(Request $request, Doctor $doctor)
    {
        return view($this->dir . "edit", compact('doctor'));
    }

    public function editProfile(Request $request, Doctor $doctor)
    {
        return view($this->dir . "profile", compact('doctor'));
    }

    public function updateProfile(Request $request, Doctor $doctor)
    {
        // Prepare data from request (convert old field names for backward compatibility)
        $data = $request->all();
        $data['surname'] = $data['last_name'] ?? $data['surname'] ?? null;

        // Update doctor using service
        $this->userRegistrationService->updateDoctor($doctor, $data);

        return $this->responseService->successBack(__("site.Doctor Profile updated successfully"));
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        // Update doctor using service
        $this->userRegistrationService->updateDoctor($doctor, $request->validated());

        return $this->responseService->success(
            __("site.Doctor updated successfully"),
            'doctor.index'
        );
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctor.index')->with('status', [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Doctor deleted successfully")
        ]);
    }

    public function show(Doctor $doctor)
    {
        return view($this->dir . "show", compact('doctor'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $doctors = Doctor::where('first_name', 'like', '%' . $query . '%')
        ->select('id', 'first_name')
        ->limit(10)
        ->get();

        return response()->json($doctors);
    }

    // Availabilities
    public function calendar()
    {
        $availabilities =  Auth::user()->doctor->availabilities->load('booking');
        //$availabilities =  Auth::user()->doctor->availabilities()->get();

        foreach ($availabilities as $key => $value) {
            if ($value->booking) {
                $patient = Patient::find($value->booking->patient_id);
                $user = User::find($patient->user_id);
                $user_name = $user->name;
                $value->booking->user_name = $user_name;
            }
        }
        return view("appointment.doctor.calendar", compact('availabilities'));
    }

    public function deleteTime($id)
    {
        $time = Availability::find($id);
        if (!$time->booking()->exists()) {
            $time->delete();
            return response()->json(['message' => 'deleted']);
        } else {
            return response()->json(['message' => 'no deleted']);
        }
    }

    public function addTimes(Request $request)
    {
        $doctor = Auth::user()->doctor;

        $addedTimes = [];
        $availabileTimes = '';

        foreach ($request->times as $time) {

            $availabileTimes = Availability::query()
                ->where('time', $time)
                ->where('doctor_id', $doctor->id)
                ->get();

            if (count($availabileTimes) == 0) {

                $addedTime = Availability::create([
                    'time' => $time,
                    'doctor_id' => $doctor->id,
                ]);
                $addedTimes[] = $addedTime;
            } else {
                $addedTimes;
            }
        }
        return response()->json([
            'message' => '__("site.Successfully Added!")',
            'added_times' => $addedTimes,
        ]);
    }

    public function patientBooking()
    {
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();

        $patientBookings = Booking::whereHas('availability', function ($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })->paginate(9);

        return view("appointment.doctor.index", compact('patientBookings'));
    }

    public function doctorChangeStatus($id, $status)
    {
        $availability = Availability::find($id);
        $booking = $availability->booking;
        $booking->status = $status;
        $booking->save();

        return redirect()->route('doctors.booking.index')->with('status', [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Doctor updated status successfully")
        ]);
    }
}
