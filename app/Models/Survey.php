<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Survey
 *
 * @property-read \App\Models\Employee                                            $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[] $employees
 * @property-read int|null                                                        $employees_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Survey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Survey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Survey query()
 * @mixin \Eloquent
 * @property int                                                                  $id
 * @property string                                                               $title
 * @property string|null                                                          $description
 * @property int|null                                                             $author_id
 * @property bool                                                                 $active
 * @property \Illuminate\Support\Carbon|null                                      $expired_at
 * @property \Illuminate\Support\Carbon|null                                      $created_at
 * @property \Illuminate\Support\Carbon|null                                      $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read int|null                                                        $questions_count
 * @property-read \App\Models\Report                                              $report
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Survey whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Survey whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Survey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Survey whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Survey whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Survey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Survey whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Survey whereUpdatedAt($value)
 */
class Survey extends Model
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
     * Get the employees, whom attached the survey
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees()
    {
        return $this->belongsToMany('App\Models\Employee')->withPivot('status');
    }

    /**
     * Get the questions in the survey
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    /**
     * Get the report created from the survey
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function report()
    {
        return $this->hasOne('App\Models\Report');
    }
}
