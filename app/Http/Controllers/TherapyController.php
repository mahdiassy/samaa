<?php

namespace App\Http\Controllers;

use App\Enums\Permissions;
use App\Models\Patient;
use App\Models\Therapy;
use App\Models\User;
use Dotenv\Store\File\Paths;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TherapyController extends Controller
{
    protected $dir = "therapy.";

    public function __construct()
    {
        $this->middleware('permission:' . Permissions::THERAPY_LIST)->only(['index']);
        $this->middleware('permission:' . Permissions::THERAPY_CREATE)->only(['create', 'store']);
        $this->middleware('permission:' . Permissions::THERAPY_SHOW)->only(['show']);
        $this->middleware('permission:' . Permissions::THERAPY_EDIT)->only(['edit', 'update']);
        $this->middleware('permission:' . Permissions::THERAPY_DELETE)->only(['destroy']);
    }

    public function index()
    {
        $patients = Patient::all();
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
        return view($this->dir . "index", compact('therapies', 'patients'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view($this->dir . "index", compact('patients'));
    }

    public function store(Request $request)
    {
        $patients = Patient::all();

        $therapy = new Therapy;
        $therapy->name = $request->name;
        $therapy->user_id = Auth::id();

        if ($request->has('file')) {
            $file = $request->file('file');
            $therapy->file = $this->storeFileEncrypt($file, 'Doctor therapy');
        }
        $therapy->save();

        $therapies = Therapy::where('user_id', Auth::id())->get();

        //$patient = Patient::find($request->patients);
        ///$therapy->patients()->sync($request->patients);
        $patient = Patient::find($request->patient_id);
        $therapy->patients()->sync($patient->id);

        return view($this->dir . "index", compact('therapies', 'patients'));
    }

    public function edit(Request $request, Therapy $therapy)
    {
        $patients = Patient::all();
        if (auth()->user()->hasRole('Admin')) {
            $therapy = $therapy;
        } elseif (auth()->user()->hasRole('Patient'))
            if ($therapy->patients()->where('patient_id', Patient::where('user_id', Auth::id())->first()->id)->first()) {
                $therapy = $therapy;
            }
        elseif (auth()->user()->hasRole('Doctor')) {
            if ($therapy->user_id == Auth::id()) {
                $therapy = $therapy;
            }
        }
        return view($this->dir . "edit", compact('therapy', 'patients'));
    }

    public function update(Request $request, Therapy $therapy)
    {
        $patients = Patient::all();
        $therapy->name = encrypt($request->name);
        $therapy->user_id = Auth::id();

        if ($request->has('file')) {
            $file = $request->file('file');
            $therapy->file = $this->storeFileEncrypt($file, 'Doctor therapy');
        }
        $therapy->save();

        $therapies = Therapy::where('user_id', Auth::id())->get();

        $patient = Patient::find($request->patient_id);
        $therapy->patients()->sync($patient->id);
        //$therapy->patients()->sync($request->patients);

        return view($this->dir . "index", compact('therapies', 'patients'));
    }

    public function show(Therapy $therapy)
    {
        return view($this->dir . "show", compact('therapy'));
    }

    public function destroy(Therapy $therapy)
    {
        $therapy->delete();
        return redirect()->route('therapy.index')->with('status', [
            'type' => 'success',
            'msg' => 'Therapy deleted successfully'
        ]);
    }
}
