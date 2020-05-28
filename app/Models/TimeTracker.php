<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\TimeTracker
 *
 * @property int                             $id
 * @property string|null                     $comment
 * @property \Illuminate\Support\Carbon|null $finished_at
 * @property int                             $employee_id
 * @property int|null                        $task_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee       $employee
 * @property-read \App\Models\Task|null      $task
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeTracker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeTracker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeTracker query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeTracker whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeTracker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeTracker whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeTracker whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeTracker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeTracker whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeTracker whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int                             $duration
 * @property-read string                     $human_duration
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeTracker whereDuration($value)
 */
class TimeTracker extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment',
        'finished_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'finished_at',
    ];

    /**
     * Accessor for finished_at field
     *
     * @param $date
     *
     * @return Carbon|null
     */
    public function getFinishedAtAttribute($date)
    {
        return $date ? Carbon::parse($date) : null;
    }

    /**
     * Get the human readable duration of the tracker
     *
     * @return string
     */
    public function getHumanDurationAttribute()
    {
        $minutes = $this->duration % 60;
        $hours   = ($this->duration - $minutes) / 60;

        return ($hours > 0 ? "$hours " . __('hours') . " " : "") . "$minutes " . __('minutes');
    }

    /**
     * Get the employee of the time tracker
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get the task of the time tracker
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }
}
