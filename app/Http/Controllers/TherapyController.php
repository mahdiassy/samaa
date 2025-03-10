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
use App\Events\MusicControlEvent;
use App\Models\Album;
use App\Models\Disease;
use App\Models\Therapeutic_area;

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

    public function controlMusic(Request $request)
    {
        $data = [
            'action' => $request->action,
            'track' => $request->track,
        ];

        broadcast(new MusicControlEvent($data))->toOthers();

        return response()->json(['message' => 'Music control updated successfully.']);
    }

    public function showSession($id)
    {
        return view('sessions.session', compact('id'));
    }
    public function index()
    {
        $patients = Patient::all();
        $therapies = $this->getTherapiesBasedRole();

        return view($this->dir . "index", compact('therapies', 'patients'));
    }

    public function admin_therapy_create()
    {
        $albums = Album::all();
        return view($this->dir . "admin-create", compact('albums'));
    }

    public function admin_therapy_store(Request $request)
    {
        $albumName = $request->album_name;

        $album = Album::firstOrCreate(['name' => $albumName]);

        $therapy = new Therapy;
        $therapy->name = $request->name;
        $therapy->album_id = $album->id;
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

        $status = [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Therapy Created successfully")
        ];

        return redirect()->route('therapy.index')->with('status', $status);
    }

    public function create(Patient $patient)
    {
        $albums = Album::all();
        return view($this->dir . "create", compact('patient','albums'));
    }

    public function store(Request $request)
    {
        $albumName = $request->album_name;

        $album = Album::firstOrCreate(['name' => $albumName]);

        $therapy = new Therapy;
        $therapy->name = $request->name;
        $therapy->album_id = $album->id;
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

        $patient = Patient::find($request->patient_id);
        $therapy->patients()->sync($patient->id);

        $status = [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Therapy Created successfully")
        ];

        return redirect()->route('therapy.index')->with('status', $status);
    }

    public function edit(Request $request, Therapy $therapy)
    {
        //$patients = Patient::all();
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
        $albums = Album::all();
        return view($this->dir . "edit", compact('therapy','albums'));
    }

    public function update(Request $request, Therapy $therapy)
    {
        $albumName = $request->album_name;

        $album = Album::firstOrCreate(['name' => $albumName]);

        $patients = Patient::all();
        $therapy->name = $request->name;
        $therapy->album_id = $album->id;
        if (Auth::user()->hasRole('Doctor')) {
            $therapy->user_id = Auth::id();
        }

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

        if($request->patient_id){
            $patient = Patient::find($request->patient_id);
            $therapy->patients()->sync($patient->id);
            //$therapy->patients()->sync($request->patients);
        }

        $status = [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Therapy Updated successfully")
        ];

        return redirect()->route('therapy.index')->with(compact('therapies', 'patients'))->with('status', $status);
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
            'title' =>  __("site.Success"),
            'msg' => __("site.Therapy deleted successfully")
        ]);
    }

    public function fetchTherapies()
    {
        if (auth()->user()->hasRole('Admin')) {

            $therapies = Therapy::all()->map(function ($therapy) {
                $getID3 = new GetID3();
                $filePath = storage_path('app/public/Doctor therapy/' . decrypt($therapy->file));
                $fileInfo = $getID3->analyze($filePath);
                $duration = $fileInfo['playtime_string'];
                return [
                    'name' => $therapy->name,
                    'artist' => $therapy->user->name,
                    'album' => $therapy->album->name,
                    'album_id' => $therapy->album->id,
                    'url' => Storage::url('Doctor therapy/' . decrypt($therapy->file)),
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
                $filePath = storage_path('app/public/Doctor therapy/' . decrypt($therapy->file));
                $fileInfo = $getID3->analyze($filePath);
                $duration = $fileInfo['playtime_string'];
                return [
                    'name' => $therapy->name,
                    'artist' => $therapy->user->name,
                    'album' => $therapy->album->name,
                    'album_id' => $therapy->album->id,
                    'url' => Storage::url('Doctor therapy/' . decrypt($therapy->file)),
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
            //$getTherapies = Therapy::whereIn('id', $therapyIds)->get();
            $getTherapies = Therapy::whereIn('id', $therapyIds)
                ->orWhereHas('user', function ($query) {
                    $query->whereHas('roles', function ($roleQuery) {
                        $roleQuery->where('name', 'Admin');
                    });
                })->get();
            $therapies = $getTherapies->map(function ($therapy) {
                $getID3 = new GetID3();
                $filePath = storage_path('app/public/Doctor therapy/' . decrypt($therapy->file));
                $fileInfo = $getID3->analyze($filePath);
                $duration = $fileInfo['playtime_string'];
                return [
                    'name' => $therapy->name,
                    'artist' => $therapy->user->name,
                    'album' => $therapy->album->name,
                    'album_id' => $therapy->album->id,
                    'url' => Storage::url('Doctor therapy/' . decrypt($therapy->file)),
                    'live' => false,
                    'type' => 'direct',
                    'cover_art_url' =>  Storage::url($therapy->image),
                    'duration' => $duration,
                ];
            });
        }

        $albums = Album::with('therapies')->get();

        return json_encode((object)["songs" => $therapies,"albums" => $albums]);
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

    public function getTherapiesBasedRole()
    {
        $therapies = collect();
        if (auth()->user()->hasRole('Admin')) {
            $therapies = Therapy::paginate(9);
        } elseif (auth()->user()->hasRole('Doctor')) {
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

            //$therapies = Therapy::whereIn('id', $therapyIds)->paginate(9);
            $therapies = Therapy::whereIn('id', $therapyIds)
                ->orWhereHas('user', function ($query) {
                    $query->whereHas('roles', function ($roleQuery) {
                        $roleQuery->where('name', 'Admin');
                    });
                })->paginate(9);

        }
        return $therapies;
    }

    public function getDiseases($id)
    {
        $diseases = Disease::where('therapeutic_area_id', $id)->get(['id', 'name']);

        return response()->json([
            'diseases' => $diseases
        ]);
    }

}
