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

class DoctorController extends Controller
{
    protected $dir = "doctor.";
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
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
        $doctor = new Doctor;
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->surname;
        $doctor->phone = $request->phone;
        $doctor->specialization = $request->specialization;
        $doctor->address = $request->address;
        $doctor->birthday = $request->birthday;
        $doctor->twitter = $request->twitter;
        $doctor->facebook = $request->facebook;
        $doctor->instagram = $request->instagram;

        $user = new User;
        $user->name = $request->first_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole('Doctor');

        $doctor->user_id = $user->id;

        // Upload profile image securely if provided
        if ($request->hasFile('image')) {
            $doctor->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'doctors'
            );
        }

        $doctor->save();

        return redirect()->route('doctor.index')->with('status', [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Doctor created successfully")
        ]);
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
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->last_name;
        $doctor->phone = $request->phone;
        $doctor->specialization = $request->specialization;
        $doctor->address = $request->address;
        $doctor->birthday = $request->birthday;
        $doctor->twitter = $request->twitter;
        $doctor->facebook = $request->facebook;
        $doctor->instagram = $request->instagram;

        $user = User::find($doctor->user_id);
        $user->name = $request->first_name;
        $user->email = $request->email;
        $user->save();
        $user->syncRoles('Doctor');

        // Upload new profile image if provided (using FileUploadService for security)
        if ($request->hasFile('image')) {
            $oldImagePath = $doctor->image;
            $doctor->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'doctors',
                $oldImagePath
            );
        }

        $doctor->save();

        return redirect()->back()->with('status', [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Doctor Profile updated successfully")
        ]);
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->surname;
        $doctor->phone = $request->phone;
        $doctor->specialization = $request->specialization;
        $doctor->address = $request->address;
        $doctor->birthday = $request->birthday;
        $doctor->twitter = $request->twitter;
        $doctor->facebook = $request->facebook;
        $doctor->instagram = $request->instagram;

        $user = User::find($doctor->user_id);
        $user->name = $request->first_name;
        $user->email = $request->email;
        
        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        $user->syncRoles('Doctor');

        // Upload new profile image if provided
        if ($request->hasFile('image')) {
            $oldImagePath = $doctor->image;
            $doctor->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'doctors',
                $oldImagePath
            );
        }

        $doctor->save();

        return redirect()->route('doctor.index')->with('status', [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Doctor updated successfully")
        ]);
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
