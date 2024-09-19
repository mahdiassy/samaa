<?php

namespace App\Http\Controllers;

use App\Enums\Permissions;
use App\Models\Patient;
use App\Models\Therapy;
use App\Models\User;
use Dotenv\Store\File\Paths;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use JamesHeinrich\GetID3\GetID3;

class TherapyController extends Controller
{
    protected $dir = "therapy.";

    public function __construct()
    {
        $this->middleware('permission:' . Permissions::THERAPY_LIST)->only(['index']);
        $this->middleware('permission:' . Permissions::THERAPY_CREATE)->only(['create', 'store']);
        $this->middleware('permission:' . Permissions::THERAPY_SHOW)->only(['show', 'playlist']);
        $this->middleware('permission:' . Permissions::THERAPY_EDIT)->only(['edit', 'update']);
        $this->middleware('permission:' . Permissions::THERAPY_DELETE)->only(['destroy']);
    }

    public function index()
    {
        $patients = Patient::all();
        $therapies = $this->getTherapiesBasedRole();

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

        if ($request->has('image')) {
            $image = $request->file('image');
            $therapy->image = $this->storeFile($image, 'Doctor therapy');
        }
        if ($request->has('file')) {
            $file = $request->file('file');
            $therapy->file = $this->storeFileEncrypt($file, 'Doctor therapy');
        }
        $therapy->save();

        $therapies = $this->getTherapiesBasedRole();

        //$patient = Patient::find($request->patients);
        ///$therapy->patients()->sync($request->patients);
        $patient = Patient::find($request->patient_id);
        $therapy->patients()->sync($patient->id);

        return view($this->dir . "index", compact('therapies', 'patients'));
    }

    public function edit(Request $request, Therapy $therapy)
    {
        $patients = Patient::all();
        //dd($therapy->file ,Storage::disk('public')->url($therapy->file) );
        /*if (auth()->user()->hasRole('Admin')) {
            $therapy = $therapy;
        } elseif (auth()->user()->hasRole('Patient'))
            if ($therapy->patients()->where('patient_id', Patient::where('user_id', Auth::id())->first()->id)->first()) {
                $therapy = $therapy;
            }
        elseif (auth()->user()->hasRole('Doctor')) {
            if ($therapy->user_id == Auth::id()) {
                $therapy = $therapy;
            }
        }*/
        return view($this->dir . "edit", compact('therapy', 'patients'));
    }

    public function update(Request $request, Therapy $therapy)
    {
        $patients = Patient::all();
        $therapy->name = $request->name;
        $therapy->user_id = Auth::id();

        if ($request->has('image')) {
            $image = $request->file('image');
            $therapy->image = $this->storeFile($image, 'Doctor therapy');
        }

        if ($request->has('file')) {
            $file = $request->file('file');
            $therapy->file = $this->storeFileEncrypt($file, 'Doctor therapy');
        }
        $therapy->save();

        $therapies = $this->getTherapiesBasedRole();

        $patient = Patient::find($request->patient_id);
        $therapy->patients()->sync($patient->id);
        //$therapy->patients()->sync($request->patients);

        return view($this->dir . "index", compact('therapies', 'patients'));
    }

    public function show(Therapy $therapy)
    {
        //return view($this->dir . "show", compact('therapy'));
    }

    public function playlist()
    {
        return view($this->dir . "playlist");
    }

    public function destroy(Therapy $therapy)
    {
        $therapy->delete();
        return redirect()->route('therapy.index')->with('status', [
            'type' => 'success',
            'msg' => 'Therapy deleted successfully'
        ]);
    }

    public function fetchTherapies()
    {
        if (auth()->user()->hasRole('Admin')) {

            $therapies = Therapy::all()->map(function ($therapy) {
                $getID3 = new GetID3();
                $filePath = storage_path('app/public/' . decrypt($therapy->file));
                $fileInfo = $getID3->analyze($filePath);
                $duration = $fileInfo['playtime_string'];
                return [
                    'name' => $therapy->name,
                    'artist' => $therapy->user->name,
                    //'album' => $therapy->name,
                    //'album_id' => '12696106c5ee8d3575d14752011dd275',
                    'url' => Storage::url(decrypt($therapy->file)),
                    'live' => false,
                    'type' => 'direct',
                    'cover_art_url' =>  Storage::url($therapy->image),
                    'duration' => $duration,
                ];
            });
        } elseif (auth()->user()->hasRole('Doctor')) {
            $getTherapies = Therapy::where('user_id', Auth::id())
                ->orWhereHas('user', function ($query) {
                    $query->whereHas('roles', function ($roleQuery) {
                        $roleQuery->where('name', 'Admin');
                    });
                })
                ->get();
            $therapies = $getTherapies->map(function ($therapy) {
                $getID3 = new GetID3();
                $filePath = storage_path('app/public/' . decrypt($therapy->file));
                $fileInfo = $getID3->analyze($filePath);
                $duration = $fileInfo['playtime_string'];
                return [
                    'name' => $therapy->name,
                    'artist' => $therapy->user->name,
                    //'album' => $therapy->name,
                    //'album_id' => '12696106c5ee8d3575d14752011dd275',
                    'url' => Storage::url(decrypt($therapy->file)),
                    'live' => false,
                    'type' => 'direct',
                    'cover_art_url' =>  Storage::url($therapy->image),
                    'duration' => $duration,
                ];
            });
        } elseif (auth()->user()->hasRole('Patient')) {
            $user = Patient::where('user_id', Auth::id())->first();
            $therapyIds = DB::table('patient_therapy')
                ->where('patient_id', $user->id)
                ->pluck('therapy_id');
            $getTherapies = Therapy::whereIn('id', $therapyIds)->get();

            $therapies = $getTherapies->map(function ($therapy) {
                $getID3 = new GetID3();
                $filePath = storage_path('app/public/' . decrypt($therapy->file));
                $fileInfo = $getID3->analyze($filePath);
                $duration = $fileInfo['playtime_string'];
                return [
                    'name' => $therapy->name,
                    'artist' => $therapy->user->name,
                    //'album' => $therapy->name,
                    //'album_id' => '12696106c5ee8d3575d14752011dd275',
                    'url' => Storage::url(decrypt($therapy->file)),
                    'live' => false,
                    'type' => 'direct',
                    'cover_art_url' =>  Storage::url($therapy->image),
                    'duration' => $duration,
                ];
            });
        }

        return json_encode((object)["songs" => $therapies]);
    }

    public function getPeaks(Request $request)
    {
        $peaks_url = $request->input('peaks_url');

        if (!$peaks_url) {
            return response()->json(['error' => 'Peaks URL not provided'], 400);
        }

        $file_path = storage_path('app/public/' . basename($peaks_url));
        if (File::exists($file_path)) {
            $peaks_data = File::get($file_path);
            return response($peaks_data, 200)->header('Content-Type', 'application/json');
        } else {
            return "";
        }
    }

    public function savePeaks(Request $request)
    {
        $current_src = $request->input('current_src');
        $peaks = $request->input('peaks');

        if (!$current_src || !$peaks) {
            return response()->json(['status' => 'error', 'message' => 'Invalid data received'], 400);
        }

        $file_name = pathinfo($current_src, PATHINFO_FILENAME) . '.json';
        $file_path = storage_path('app/public/' . $file_name);

        if (File::put($file_path, $peaks)) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Unable to save peaks'], 500);
        }
    }

    public function getTherapiesBasedRole ()
    {
        $therapies = collect();
        if (auth()->user()->hasRole('Admin')) {
            $therapies = Therapy::paginate(9);
        } elseif (auth()->user()->hasRole('Doctor')) {
            //$therapies = Therapy::where('user_id', Auth::id())->paginate(9); /// edit
            $therapies = Therapy::where('user_id', Auth::id())
                ->orWhereHas('user', function ($query) {
                    $query->whereHas('roles', function ($roleQuery) {
                        $roleQuery->where('name', 'Admin');
                    });
                })
                ->paginate(9);
        } elseif (auth()->user()->hasRole('Patient')) {
            $user = Patient::where('user_id', Auth::id())->first();
            $therapyIds = DB::table('patient_therapy')
                ->where('patient_id', $user->id)
                ->pluck('therapy_id');

            $therapies = Therapy::whereIn('id', $therapyIds)->get();
        }
        return $therapies;
    }
}
