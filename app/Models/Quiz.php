<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Quiz
 *
 * @property int                                                                      $id
 * @property string                                                                   $title
 * @property string|null                                                              $description
 * @property int|null                                                                 $author_id
 * @property bool                                                                     $active
 * @property \Illuminate\Support\Carbon|null                                          $expired_at
 * @property \Illuminate\Support\Carbon|null                                          $created_at
 * @property \Illuminate\Support\Carbon|null                                          $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobApplicant[] $applicants
 * @property-read int|null                                                            $applicants_count
 * @property-read \App\Models\Employee|null                                           $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[]     $employees
 * @property-read int|null                                                            $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[]     $questions
 * @property-read int|null                                                            $questions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quiz newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quiz newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quiz query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quiz whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quiz whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quiz whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quiz whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quiz whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quiz whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quiz whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Quiz whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Quiz extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'active',
        'expired_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expired_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];


    /**
     * Get the author|Employee of the survey
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get the questions in the survey
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany('App\Models\Question')->withPivot('sort_order')->orderBy('question_quiz.sort_order');
    }

    /**
     * Get the applicants whom attached the quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function applicants()
    {
        return $this->morphedByMany('App\Models\JobApplicant', 'quizable')->withPivot(['result', 'token', 'details']);
    }

    /**
     * Get the employees whom attached the quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function employees()
    {
        return $this->morphedByMany('App\Models\Employee', 'quizable')->withPivot(['result', 'details']);
    }
}
