<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Survey;
use foo\bar;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    /**
     * Show the quiz-questions list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('quizzes.questions.index')->with([
            'questions' => Question::whereNull('survey_id')->get(),
            'types' => Question::$types
        ]);
    }

    /**
     * Show form for creating a quiz-question
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('quizzes.questions.add')->with([
            'types' => Question::$types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Survey                   $survey
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Survey $survey)
    {
        $data = $request->all();
        if ($data['type'] === 'range') {
            if (!empty($data['answers']) && is_array($data['answers']) && count($data['answers']) > 2) {
                $data['answers'] = array_slice($data['answers'], 0, 2);
            }
            $data['answers']    = isset($data['answers']) && is_array($data['answers']) ? $data['answers'] : [];
            $data['answers'][0] = isset($data['answers'][0]) && is_numeric($data['answers'][0]) ? $data['answers'][0] : 0;
            $data['answers'][1] = isset($data['answers'][1]) && is_numeric($data['answers'][1]) ? $data['answers'][1] : 100;
        }
        if (!$survey->exists) {
            if ($data['type'] === 'text') {
                $data['right_answers'] = [
                    $data['right_answer']
                ];
            }
            Question::create($data);

            return redirect()->route('quiz.questions.index');
        }
        $survey->questions()->create($data);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Survey               $survey
     * @param \App\Models\Question $question
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Survey $survey, Question $question)
    {
        return view('surveys.questions.show')->with([
            'question' => $question,
            'survey'   => $survey,
            'types'    => Question::$types,
        ]);
    }

    /**
     * Display the quiz-question
     *
     * @param Question $question
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showForQuiz(Question $question)
    {
        return view('quizzes.questions.show')->with([
            'question' => $question,
            'types' => Question::$types
        ]);
    }

    /**
     * Show form for edit the quiz-question
     *
     * @param Question $question
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Question $question)
    {
        return view('quizzes.questions.edit')->with([
            'question' => $question,
            'types' => Question::$types
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Question     $question
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Question $question)
    {
        $data = $request->all();
        if ($data['type'] === 'range') {
            if (!empty($data['answers']) && is_array($data['answers']) && count($data['answers']) > 2) {
                $data['answers'] = array_slice($data['answers'], 0, 2);
            }
            $data['answers']    = isset($data['answers']) && is_array($data['answers']) ? $data['answers'] : [];
            $data['answers'][0] = isset($data['answers'][0]) && is_numeric($data['answers'][0]) ? $data['answers'][0] : 0;
            $data['answers'][1] = isset($data['answers'][1]) && is_numeric($data['answers'][1]) ? $data['answers'][1] : 100;
        }
        if ($request->has('right_answers') || $request->has('right_answer')) {
            if ($data['type'] === 'text') {
                $data['right_answers'] = [
                    $data['right_answer']
                ];
            }
            $question->update($data);

            return redirect()->route('quiz.questions.show', $question);
        }
        $question->update($data);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Survey               $survey
     * @param \App\Models\Question $question
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Survey $survey, Question $question)
    {
        $question->delete();

        return redirect()->route('surveys.edit', $survey);
    }

    /**
     * Remove the quiz-question from storage.
     *
     * @param \App\Models\Question $question
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroyForQuiz(Question $question)
    {
        $question->delete();

        return redirect()->route('quiz.questions.index');
    }
}
