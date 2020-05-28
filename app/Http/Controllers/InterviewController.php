<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Interview;
use App\Models\JobApplicant;
use App\Models\Vacancy;
use App\Notifications\InterviewEnded;
use App\Notifications\InterviewFeedbackReady;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:manage interviews', ['except' => ['show', 'createFeedback', 'storeFeedback']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $interviews = Interview::with(['vacancy', 'applicant', 'organizer'])
                               ->where('planned_at', '>', today())
                               ->orderBy('planned_at', 'asc')
                               ->get();

        return view('interviews.index')->with([
            'interviews' => $interviews,
            'statuses'   => Interview::$statuses,
            'vacancies'  => Vacancy::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $vacancy = Vacancy::findOrFail((int)$request->vacancy);

        return view('interviews.add')->with([
            'vacancy'     => $vacancy,
            'candidates'  => $vacancy->applicants->where('status', 'candidate'),
            'departments' => Department::with('employees')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $organizer = Auth::user();
        $vacancy   = Vacancy::findOrFail($request->vacancy_id);
        $applicant = JobApplicant::findOrFail($request->applicant_id);
        if ($organizer->isAdmin()) {
            $interview = Interview::create($request->all());
        } else {
            $interview = $organizer->employee->organizedInterviews()->create($request->all());
        }
        $interview->vacancy()->associate($vacancy);
        $interview->applicant()->associate($applicant);
        $interview->members()->attach($request->members);
        $interview->status = 'active';
        $interview->save();

        $interview->notifyAll();

        return redirect()->route('interviews.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Interview $interview
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Interview $interview)
    {
        return view('interviews.show')->with([
            'interview' => $interview,
            'statuses' => Interview::$statuses
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Interview $interview
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Interview $interview)
    {
        return view('interviews.edit')->with([
            'interview'   => $interview,
            'candidates'  => $interview->vacancy->applicants->where('status', 'candidate'),
            'departments' => Department::with('employees')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Interview    $interview
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Interview $interview)
    {
        if ($request->ajax()) {
            $interview->status = $request->status;
            $interview->save();
            if ($interview->status === 'pending') {
                foreach ($interview->members as $member) {
                    $user = $member->user;
                    $user->notify(new InterviewEnded($interview));
                }
            }

            return response()->json([
                'message'  => 'ok',
                'instance' => $interview->jsonSerialize()
            ]);
        }
        $vacancy   = Vacancy::findOrFail($request->vacancy_id);
        $applicant = JobApplicant::findOrFail($request->applicant_id);
        $interview->update($request->all());
        $interview->vacancy()->dissociate();
        $interview->vacancy()->associate($vacancy);
        $interview->applicant()->dissociate();
        $interview->applicant()->associate($applicant);
        $interview->members()->sync($request->members);
        $interview->status = 'active';
        $interview->save();

        $interview->notifyAll();

        return redirect()->route('interviews.show', $interview);
    }

    /**
     * Show feedback leaving form for interview member
     *
     * @param Interview $interview
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createFeedback(Interview $interview)
    {
        $member   = Auth::user()->employee;
        $feedback = [
            'rate'    => $interview->members()->where('employee_id', $member->id)->withPivot('feedback_rate')->first()->pivot->feedback_rate,
            'comment' => $interview->members()->where('employee_id', $member->id)->withPivot('feedback_comment')->first()->pivot->feedback_comment,
        ];

        return view('interviews.feedback.form')->with([
            'interview' => $interview,
            'feedback'  => $feedback
        ]);
    }

    /**
     * Store the current user feedback of the interview
     * Change status of the interview to done if all feedbacks are leaved
     *
     * @param Request   $request
     * @param Interview $interview
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFeedback(Request $request, Interview $interview)
    {
        $member = Auth::user()->employee;
        $interview->members()->updateExistingPivot($member->id, $request->except('_token'));
        $feedbacks = $interview->members()
                               ->wherePivot('feedback_rate', null)
                               ->orWherePivot('feedback_comment', null)
                               ->where('interview_id', $interview->id) //need because orWherePivot broke sql and reset interviews.id filter
                               ->get();
        if ($feedbacks->count() == 0 && $interview->status === 'pending') {
            $interview->status = 'done';
            $interview->save();
            $interview->organizer->user->notify(new InterviewFeedbackReady($interview));
        }

        return redirect()->route('interviews.show', $interview);
    }

    public function showFeedback(Interview $interview)
    {
        return view('interviews.feedback.show')->with([
            'interview' => $interview,
            'members'   => $interview->members()->withPivot(['feedback_rate', 'feedback_comment'])->get(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Interview $interview
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Interview $interview)
    {
        $interview->delete();

        return redirect()->route('interviews.index');
    }
}
