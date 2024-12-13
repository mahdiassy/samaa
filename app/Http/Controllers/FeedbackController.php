<?php

namespace App\Http\Controllers;

use App\Enums\Permissions;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    protected $dir = "feedback.";

    public function __construct()
    {
        $this->middleware('permission:' . Permissions::FEEDBACK_LIST)->only(['index']);
        $this->middleware('permission:' . Permissions::FEEDBACK_CREATE)->only(['create', 'store']);
        $this->middleware('permission:' . Permissions::FEEDBACK_SHOW)->only(['show']);
        $this->middleware('permission:' . Permissions::FEEDBACK_DELETE)->only(['destroy']);
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $feedbacks = Feedback::paginate(9);
        } else {
            $feedbacks = Feedback::where('patient_id', Auth::user()->patient->id)->paginate(9);
        }
        return view($this->dir . "index", compact('feedbacks'));
    }

    public function create()
    {
        $lastFeedback = Feedback::latest()->first();
        if ($lastFeedback == null)
            $newFeedback = 1;
        else $newFeedback = $lastFeedback->id + 1;
        return view($this->dir . "create", compact('newFeedback'));
    }

    public function store(Request $request)
    {
        $feedback = new Feedback;
        $feedback->patient_id = Auth::user()->patient->id;
        $feedback->feedback = $request->feedback;
        $feedback->date = $request->date;
        $feedback->improvement = $request->improvement;
        $feedback->note = $request->note;

        $feedback->save();

        return redirect()->route('feedback-list')->with('status', [
            'type' => 'success',
            'msg' => '__("site.Feedback created successfully")'
        ]);
    }

    public function show(Feedback $feedback)
    {
        return view($this->dir . "show", compact('feedback'));
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedback-list')->with('status', [
            'type' => 'success',
            'msg' => '__("site.Feedback deleted successfully")'
        ]);
    }
}
