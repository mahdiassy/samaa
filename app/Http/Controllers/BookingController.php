<?php

namespace App\Http\Controllers;

use App\Enums\BookingEnum;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $dir = "appointment.patient.";

    public function index()
    {
        $patient = Patient::where('user_id', auth()->user()->id)->first();
        $patientBookings = Booking::with(['doctor.user', 'patient.user'])
            ->where('patient_id', $patient->id)
            ->whereNotIn('status', [BookingEnum::PATIENT_CANCEL])
            ->paginate(9);
        return view($this->dir . "index", compact('patientBookings'));
    }

    // Booking
    public function calendar(Request $request)
    {
        $doctor = Doctor::find($request->id);
        //$availabilities = $doctor->availabilities()->whereDoesntHave('booking')->get();
        $availabilities = $doctor->availabilities()
            ->WhereDoesntHave('booking')
            ->orwhereHas('booking', function ($query) {
                $query->where('status', BookingEnum::PATIENT_CANCEL);
            })
            ->get();

        return view($this->dir . "calendar", compact('availabilities'));
    }

    public function addAppointment(Request $request)
    {
        if ((Booking::where('available_id', $request->id)->get())->isEmpty()) {
            $booking = new Booking;
            $patient = Patient::where('user_id', Auth::user()->id)->first();
            $booking->patient_id = $patient->id;
            $booking->available_id = $request->id;
            $booking->reason = $request->reason;
            $booking->status = BookingEnum::PENDING;
            $booking->save();
        } else {
            $booking = Booking::where('available_id', $request->id)->first();
            $patient = Patient::where('user_id', Auth::user()->id)->first();
            $booking->patient_id = $patient->id;
            $booking->reason = $request->reason;
            $booking->status = BookingEnum::PENDING;
            $booking->save();
        }
        return response()->json([
            'message' => '__("site.Successfully Added!")',
            'booking' => $patient->id,
        ]);
    }

    public function changeStatus($id, $status)
    {
        $availability = Availability::find($id);
        $booking = $availability->booking;
        $booking->status = $status;
        $booking->save();

        return redirect()->route('patients.booking.index')->with('status', [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Patient Canceled successfully")
        ]);
    }
}
