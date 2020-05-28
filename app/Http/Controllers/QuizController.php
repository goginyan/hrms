<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\JobApplicant;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Notifications\QuizAttached;
use App\Mail\QuizAttached as QuizAttachedMail;
use App\Notifications\QuizPassed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('quizzes.index')->with([
            'quizzes' => Quiz::all()
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
        $quizzes = Auth::user()->employee->quizzes();
        if ($request->has('active') && $request->active) {
            $quizzes = $quizzes->wherePivot('result', null);
        } elseif ($request->has('passed') && $request->passed) {
            $quizzes = $quizzes->wherePivot('result', '<>', null);
        }

        return view('quizzes.pass.index')->with([
            'quizzes' => $quizzes->where('active', true)->get(),
        ]);
    }

    /**
     * Show the list of quiz for view results
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reports()
    {
        return view('quizzes.reports.index')->with([
            'quizzes' => Quiz::with(['employees', 'applicants'])->get(),
        ]);
    }

    /**
     * Show the quiz result per quizable by scope (employees|applicants)
     *
     * @param Quiz   $quiz
     * @param string $scope ('employees'|'applicants')
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function reportsShow(Quiz $quiz, $scope)
    {
        if ($scope === 'applicants') {
            $quizables  = $quiz->applicants;
            $alterScope = 'employees';
        } else {
            $quizables  = $quiz->employees;
            $alterScope = 'applicants';
        }

        if ($quizables->count()) {
            return view('quizzes.reports.show')->with([
                'quiz'       => $quiz,
                'quizables'  => $quizables,
                'scope'      => $scope,
                'alterScope' => $alterScope
            ]);
        }

        return redirect()->route('quizzes.reports.index');
    }

    /**
     * Show the quiz result for the quizable (Employee|JobApplicant)
     *
     * @param Quiz   $quiz
     * @param string $scope
     * @param mixed  $quizable
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function reportsShowQuizable(Quiz $quiz, $scope, $quizable)
    {
        if ($scope === 'applicants') {
            $quizable = $quiz->applicants->where('id', $quizable)->first();
        } else {
            $quizable = $quiz->employees->where('id', $quizable)->first();
        }
        if ($quizable->pivot->details) {
            return view('quizzes.reports.show_quizable')->with([
                'quiz'     => $quiz,
                'quizable' => $quizable,
                'details'  => json_decode($quizable->pivot->details, true),
            ]);
        }

        return redirect()->route('quizzes.reports.show', [$quiz, $scope]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('quizzes.add')->with([
            'questions'     => Question::whereNull('survey_id')->get(),
            'questionTypes' => Question::$types,
            'departments'   => Department::with('employees')->get(),
            'applicants'    => JobApplicant::where('status', 'pending')->get()
        ]);
    }

    /**
     * Display the page where employee can pass the quiz
     *
     * @param \App\Models\Quiz $quiz
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function pass(Quiz $quiz)
    {
        $userQuiz = Auth::user()->employee->quizzes->where('id', $quiz->id)->first();
        if ($userQuiz && !$userQuiz->pivot->result) {
            return view('quizzes.pass.pass')->with([
                'quiz' => $quiz,
            ]);
        }

        return redirect()->route('quizzes.index.user');
    }

    /**
     * Display the page where applicant can pass the quiz
     *
     * @param \App\Models\Quiz $quiz
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function passPublic(Quiz $quiz, $token)
    {
        $applicant = $quiz->applicants()
                          ->wherePivot('token', $token)
                          ->firstOrFail();
        if ($applicant) {
            return view('quizzes.public.pass')->with([
                'quiz'      => $quiz,
                'applicant' => $applicant,
            ]);
        }

        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $questionsOrdering = json_decode($request->questions_ordering, true);
        $questionsList     = [];
        foreach ($request->questions as $question) {
            $index = array_search($question, $questionsOrdering);
            if ($index !== false) {
                $questionsList[$question] = ['sort_order' => ++$index];
            }
        }
        if (Auth::user()->isAdmin()) {
            $quiz = Quiz::create($request->all());
        } else {
            $quiz = Auth::user()->employee->createdQuizzes()->create($request->all());
        }
        $quiz->questions()->attach($questionsList);
        $quiz->employees()->attach($request->employees);
        $applicantsWithToken = [];
        foreach ($request->applicants as $applicant) {
            $applicantsWithToken[$applicant] = [
                'token' => bin2hex(random_bytes(32))
            ];
        }
        $quiz->applicants()->attach($applicantsWithToken);

        if ($quiz->active) {
            foreach ($quiz->employees as $employee) {
                $employee->user->notify(new QuizAttached($quiz));
            }
            foreach ($quiz->applicants as $applicant) {
                if ($applicant->email) {
                    Mail::to($applicant->email)->send(new QuizAttachedMail($quiz, $applicant->pivot->token));
                }
            }
        }

        return redirect()->route('quizzes.index');
    }

    /**
     * Get results data array for save in pivot table
     * check all answers and construct details array
     *
     * @param array $answersData
     *
     * @return array
     */
    public function getResults($answersData)
    {
        if (isset($answersData['_token'])) unset($answersData['_token']);
        $questionsCount    = count($answersData);
        $rightAnswersCount = 0;
        $details           = [];
        foreach ($answersData as $questionId => $answer) {
            $question             = Question::findOrFail($questionId);
            $result               = $question->checkAnswer($answer);
            $rightAnswersCount    += (int)$result;
            $details[$questionId] = [
                'result' => $result,
                'answer' => $answer
            ];
        }

        return [
            'result'  => number_format(($rightAnswersCount / $questionsCount) * 100),
            'details' => json_encode($details)
        ];
    }

    /**
     * Store the result of quiz for the employee
     *
     * @param Request $request
     * @param Quiz    $quiz
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeResults(Request $request, Quiz $quiz)
    {
        if (!Auth::user()->employee->quizzes->where('id', $quiz->id)->first()->pivot->result) {
            $pivotData = $this->getResults($request->all());
            Auth::user()->employee->quizzes()->updateExistingPivot($quiz->id, $pivotData);
        }

        return redirect()->route('quizzes.index.user');
    }

    /**
     * Store the result of quiz for the applicant
     *
     * @param Request      $request
     * @param Quiz         $quiz
     * @param JobApplicant $applicant
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePublic(Request $request, Quiz $quiz, JobApplicant $applicant)
    {
        if (!$applicant->quizzes->where('id', $quiz->id)->first()->pivot->result) {
            $pivotData = $this->getResults($request->all());
            $applicant->quizzes()->updateExistingPivot($quiz->id, $pivotData);
            $users = User::permission('manage quizzes')->get();
            foreach ($users as $user) {
                $user->notify(new QuizPassed($quiz, $applicant));
            }
        }

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Quiz $quiz
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Quiz $quiz)
    {
        return view('quizzes.show')->with([
            'quiz'          => $quiz->loadMissing(['questions', 'applicants', 'employees']),
            'questionTypes' => Question::$types,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Quiz $quiz
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Quiz $quiz)
    {
        return view('quizzes.edit')->with([
            'quiz'          => $quiz->loadMissing(['questions', 'applicants', 'employees']),
            'questions'     => Question::whereNull('survey_id')->get(),
            'questionTypes' => Question::$types,
            'departments'   => Department::with('employees')->get(),
            'applicants'    => JobApplicant::where('status', 'pending')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz         $quiz
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(Request $request, Quiz $quiz)
    {
        $questionsOrdering = json_decode($request->questions_ordering, true);
        $questionsList     = [];
        foreach ($request->questions as $question) {
            $index = array_search($question, $questionsOrdering);
            if ($index !== false) {
                $questionsList[$question] = ['sort_order' => ++$index];
            }
        }
        $quiz->questions()->sync($questionsList);
        $quiz->employees()->sync($request->employees);
        $applicantsWithToken = [];
        foreach ($request->applicants as $applicant) {
            $applicantsWithToken[$applicant] = [
                'token' => bin2hex(random_bytes(32))
            ];
        }
        $quiz->applicants()->sync($applicantsWithToken);

        if (!$quiz->active && $request->active) {
            foreach ($quiz->employees as $employee) {
                $employee->user->notify(new QuizAttached($quiz));
            }
            foreach ($quiz->applicants as $applicant) {
                if ($applicant->email) {
                    Mail::to($applicant->email)->send(new QuizAttachedMail($quiz, $applicant->pivot->token));
                }
            }
        }

        $quiz->update($request->all());

        return redirect()->route('quizzes.show', $quiz);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Quiz $quiz
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('quizzes.index');
    }
}
