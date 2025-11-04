<?php

namespace App\Http\Controllers;

use App\Enums\Permissions;
use App\Models\Patient;
use App\Models\Therapy;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use JamesHeinrich\GetID3\GetID3;
use App\Events\MusicControlEvent;
use App\Models\Album;
use App\Models\Disease;
use App\Models\Therapeutic_area;
use App\Http\Requests\Therapy\StoreTherapyRequest;
use App\Http\Requests\Therapy\UpdateTherapyRequest;
use App\Services\File\FileUploadService;
use App\Services\Therapy\TherapyAccessService;
use App\Services\Response\ResponseService;

class TherapyController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService,
        protected TherapyAccessService $therapyAccessService,
        protected ResponseService $responseService
    ) {
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
        $patients = Patient::with('user')->get();
        $therapies = $this->therapyAccessService->getTherapiesForUser(Auth::user());

        return view("therapy.index", compact('therapies', 'patients'));
    }

    public function admin_therapy_create()
    {
        $albums = Album::all();
        return view("therapy.admin-create", compact('albums'));
    }

    public function admin_therapy_store(Request $request)
    {
        // Validate file size for audio files
        if ($request->has('file')) {
            $file = $request->file('file');
            $maxSize = config('upload.max_audio_size', 100 * 1024 * 1024); // 100MB
            
            if ($file->getSize() > $maxSize) {
                $status = [
                    'type' => 'error',
                    'title' => __('site.Error'),
                    'msg' => __('site.File size exceeds maximum allowed size of 100MB')
                ];
                return redirect()->back()->with('status', $status)->withInput();
            }
        }

        $albumName = $request->album_name;

        $album = Album::firstOrCreate(['name' => $albumName]);

        $therapy = new Therapy;
        $therapy->name = $request->name;
        $therapy->album_id = $album->id;
        $therapy->user_id = Auth::id();

        // Upload image securely if provided
        if ($request->hasFile('image')) {
            $therapy->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'therapies'
            );
        }

        // Upload encrypted audio file if provided
        if ($request->hasFile('file')) {
            $therapy->file = $this->fileUploadService->uploadEncryptedAudio(
                $request->file('file'),
                'therapies'
            );
        }
        
        $therapy->save();

        return $this->responseService->success(
            __("site.Therapy Created successfully"),
            'therapy.index'
        );
    }

    public function create(Patient $patient)
    {
        $albums = Album::all();
        return view("therapy.create", compact('patient','albums'));
    }

    public function store(StoreTherapyRequest $request)
    {
        $albumName = $request->album_name;

        $album = Album::firstOrCreate(['name' => $albumName]);

        $therapy = new Therapy;
        $therapy->name = $request->name;
        $therapy->album_id = $album->id;
        $therapy->user_id = Auth::id();

        // Upload cover image if provided
        if ($request->hasFile('image')) {
            $therapy->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'therapies'
            );
        }

        // Upload and encrypt audio file
        if ($request->hasFile('file')) {
            $therapy->file = $this->fileUploadService->uploadEncryptedAudio(
                $request->file('file'),
                'therapies'
            );
        }

        $therapy->save();

        // Attach patient if provided
        if ($request->patient_id) {
            $patient = Patient::find($request->patient_id);
            if ($patient) {
                $therapy->patients()->sync($patient->id);
            }
        }

        $status = [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Therapy Created successfully")
        ];

        return redirect()->route('therapy.index')->with('status', $status);
    }

    public function edit(Request $request, Therapy $therapy)
    {
        $albums = Album::all();
        return view("therapy.edit", compact('therapy','albums'));
    }

    public function update(UpdateTherapyRequest $request, Therapy $therapy)
    {
        $albumName = $request->album_name;

        $album = Album::firstOrCreate(['name' => $albumName]);

        $patients = Patient::all();
        $therapy->name = $request->name;
        $therapy->album_id = $album->id;
        if (Auth::user()->hasRole('Doctor')) {
            $therapy->user_id = Auth::id();
        }

        // Upload new cover image if provided
        if ($request->hasFile('image')) {
            $oldImagePath = $therapy->image;
            $therapy->image = $this->fileUploadService->uploadImage(
                $request->file('image'),
                'therapies',
                $oldImagePath
            );
        }

        // Upload new encrypted audio file if provided
        if ($request->hasFile('file')) {
            $oldFilePath = $therapy->file;
            $therapy->file = $this->fileUploadService->uploadEncryptedAudio(
                $request->file('file'),
                'therapies',
                $oldFilePath
            );
        }
        $therapy->save();

        if($request->patient_id){
            $patient = Patient::find($request->patient_id);
            $this->therapyAccessService->assignTherapyToPatients($therapy, $patient);
        }

        $status = [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Therapy Updated successfully")
        ];

        return redirect()->route('therapy.index')->with('status', $status);
    }

    public function show(Therapy $therapy)
    {
        return view("therapy.show", compact('therapy'));
    }

    public function playlist()
    {
        return view("therapy.playlist");
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
                    'url' => route('therapy.audio', $therapy->id),
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
                    'url' => route('therapy.audio', $therapy->id),
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
                    'url' => route('therapy.audio', $therapy->id),
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

    public function getDiseases($id)
    {
        $diseases = Disease::where('therapeutic_area_id', $id)->get(['id', 'name']);

        return response()->json([
            'diseases' => $diseases
        ]);
    }

    public function getAudio(Therapy $therapy)
    {
        try {
            // Decrypt the file path
            $decryptedFile = decrypt($therapy->file);
            
            // Get the full file path
            $filePath = storage_path('app/public/Doctor therapy/' . $decryptedFile);
            
            // Check if file exists
            if (!file_exists($filePath)) {
                return response()->json(['error' => 'Audio file not found'], 404);
            }
            
            // Get file info
            $fileInfo = pathinfo($filePath);
            $mimeType = mime_content_type($filePath);
            
            // Return the file with proper headers
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $therapy->name . '.' . $fileInfo['extension'] . '"',
                'Cache-Control' => 'public, max-age=3600',
            ]);
            
        } catch (\Exception $e) {
            Log::error('Audio file error: ' . $e->getMessage());
            return response()->json(['error' => 'Error loading audio file'], 500);
        }
    }

}
