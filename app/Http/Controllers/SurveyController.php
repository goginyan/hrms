<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Question;
use App\Models\Survey;
use App\Notifications\SurveyAttached;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('surveys.index')->with([
            'surveys'     => Survey::all(),
            'departments' => Department::all(),
        ]);
    }

    /**
     * Display a listing of the resource for the employee.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userIndex(Request $request)
    {
        $surveys = Auth::user()->employee->surveys();
        if ($request->has('active') && $request->active) {
            $surveys = $surveys->wherePivot('status', 'active');
        } elseif ($request->has('passed') && $request->passed) {
            $surveys = $surveys->wherePivot('status', 'done');
        }

        return view('surveys.pass.index')->with([
            'surveys' => $surveys->get(),
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
        if (Auth::user()->isAdmin()) {
            $survey = Survey::create($request->all());
        } else {
            $survey = Auth::user()->employee->createdSurveys()->create($request->all());
        }
        $survey->employees()->attach($request->employees);

        return redirect()->route('surveys.edit', $survey);
    }

    /**
     * Add questions to the survey
     *
     * @param Survey $survey
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Survey $survey)
    {
        return view('surveys.edit')->with([
            'survey' => $survey,
            'types'  => Question::$types,
        ]);
    }

    /**
     * Send notifications to attached employees
     *
     * @param Survey $survey
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function execute(Survey $survey)
    {
        if ($survey->active) {
            foreach ($survey->employees as $employee) {
                $employee->user->notify(new SurveyAttached($survey));
            }
            $survey->report()->create([
                'title'    => $survey->title . ' ' . __('Survey'),
                'fields'   => array_merge([
                    'fullName',
                    'departmentName',
                ], $survey->questions->toArray()),
                'ordering' => 'desc',
            ]);
        }

        return redirect()->route('surveys.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Survey $survey
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Survey $survey)
    {
        return view('surveys.show')->with([
            'survey'      => $survey,
            'departments' => Department::all()
        ]);
    }

    /**
     * Display the page where user can pass the survey.
     *
     * @param \App\Models\Survey $survey
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function pass(Survey $survey)
    {
        $userSurvey = Auth::user()->employee->surveys->where('id', $survey->id)->first();
        if ($userSurvey && $userSurvey->pivot->status === 'active') {
            return view('surveys.pass.pass')->with([
                'survey' => $survey,
            ]);
        }

        return redirect()->route('surveys.index.user');
    }

    /**
     * Store the result of survey
     *
     * @param Request $request
     * @param Survey  $survey
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeResults(Request $request, Survey $survey)
    {
        $answersData = $request->all();
        unset($answersData['_token']);
        $answersData = array_map(function ($answer) {
            return is_array($answer) ? ['answer' => json_encode($answer)] : ['answer' => $answer];
        }, $answersData);
        Auth::user()->employee->questions()->sync($answersData);
        Auth::user()->employee->surveys()->updateExistingPivot($survey->id, ['status' => 'done']);

        return redirect()->route('surveys.index.user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey       $survey
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Survey $survey)
    {
        if (!$survey->active) {
            $survey->update($request->all());
            $survey->employees()->sync($request->employees);
        }

        return redirect()->route('surveys.show', $survey);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Survey $survey
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Survey $survey)
    {
        $survey->report->delete();
        $survey->delete();

        return redirect()->route('surveys.index');
    }
}
