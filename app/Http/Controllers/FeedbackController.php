<?php

namespace App\Http\Controllers;

use App\Enums\Permissions;
use App\Models\Feedback;
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

    public function index(Request $request)
    {
        $searchTerm = trim((string) $request->get('q', ''));

        $feedbackQuery = Feedback::query()->latest();

        if ($searchTerm !== '') {
            $feedbackQuery->where(function ($query) use ($searchTerm) {
                $query->where('full_name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%")
                    ->orWhere('subject', 'like', "%{$searchTerm}%")
                    ->orWhere('message', 'like', "%{$searchTerm}%")
                    ->orWhere('feedback', 'like', "%{$searchTerm}%");
            });
        }

    $feedbacks = $feedbackQuery->paginate(9)->appends($request->query());

        $totalFeedback = Feedback::count();
        $recentFeedbackCount = Feedback::where('created_at', '>=', now()->subDays(7))->count();
        $uniqueSubjectsCount = Feedback::whereNotNull('subject')->distinct()->count('subject');
        $latestFeedback = Feedback::latest('created_at')->first();

        return view($this->dir . "index", compact(
            'feedbacks',
            'totalFeedback',
            'recentFeedbackCount',
            'uniqueSubjectsCount',
            'latestFeedback',
            'searchTerm'
        ));
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
        $feedback->full_name = $request->full_name;
        $feedback->email = $request->email;
        $feedback->feedback = $request->feedback;
        $feedback->date = $request->date;
        $feedback->subject = $request->subject;
        $feedback->cta_type = 'Feedback';
        $feedback->cta_source = $request->cta_source;
        $feedback->message = $request->message;

        $feedback->save();

        return redirect()->route('feedback')->with('status', [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Feedback created successfully")
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
            'title' =>  __("site.Success"),
            'msg' => __("site.Feedback deleted successfully")
        ]);
    }
}
