<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Question
 *
 * @property int                                                                  $id
 * @property string                                                               $text
 * @property string                                                               $type
 * @property array|null                                                           $answers
 * @property int                                                                  $survey_id
 * @property \Illuminate\Support\Carbon|null                                      $created_at
 * @property \Illuminate\Support\Carbon|null                                      $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[] $employees
 * @property-read int|null                                                        $employees_count
 * @property-read \App\Models\Survey                                              $survey
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null                                                          $title
 * @property array|null                                                           $right_answers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Quiz[]     $quizzes
 * @property-read int|null                                                        $quizzes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereRightAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereTitle($value)
 */
class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'text',
        'type',
        'answers',
        'right_answers',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'answers'       => 'array',
        'right_answers' => 'array',
    ];

    /**
     * Type of the questions
     *
     * @var array
     */
    public static $types = [
        'text'     => 'Text Field',
        'radio'    => 'Radio Buttons',
        'checkbox' => 'Multiple Choice',
        'range'    => 'Rating Scale'
    ];

    /**
     * Check is correct the user input answer for the question
     *
     * @param string|array $userAnswer
     *
     * @return bool
     */
    public function checkAnswer($userAnswer)
    {
        $rightAnswers = $this->right_answers;
        if (!is_array($userAnswer)) {
            $right = strtolower($rightAnswers[0]) == strtolower($userAnswer);
        } else {
            array_multisort($rightAnswers);
            array_multisort($userAnswer);
            $right = (serialize($rightAnswers) === serialize($userAnswer) && count($rightAnswers) == count($userAnswer));
        }

        return $right;
    }

    /**
     * Get the survey what assigned the question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo('App\Models\Survey');
    }

    /**
     * Get the employees who answered on the question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees()
    {
        return $this->belongsToMany('App\Models\Employee')->withPivot('answer');
    }

    /**
     * Get the employees who answered on the question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function quizzes()
    {
        return $this->belongsToMany('App\Models\Quiz');
    }
}
