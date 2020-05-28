<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\TimeOff
 *
 * @property int                             $id
 * @property string                          $type
 * @property bool                            $paid
 * @property string                          $reason
 * @property Carbon|null                     $started_at
 * @property Carbon|null                     $finished_at
 * @property int                             $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool                            $approved
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TimeOff whereApproved($value)
 * @property-read \App\Models\Employee       $employee
 * @property-read float|int                  $duration
 */
class TimeOff extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'paid',
        'reason',
        'started_at',
        'finished_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'paid'     => 'boolean',
        'approved' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'finished_at',
        'started_at',
    ];

    /**
     * Types of the time-offs
     *
     * @var array
     */
    public static $types = [
        'day_off'     => 'Day Off',
        'urgent'      => 'Urgent Matter',
        'vacation'    => 'Vacation',
        'sick'        => 'Sick',
        'bereavement' => 'Bereavement',
        'family'      => 'Family',
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
     * Accessor for finished_at field
     *
     * @param $date
     *
     * @return Carbon|null
     */
    public function getStartedAtAttribute($date)
    {
        return $date ? Carbon::parse($date) : null;
    }

    /**
     * Get the duration in days for the time-off
     *
     * @return float|int
     */
    public function getDurationAttribute()
    {
        $start = $this->started_at;
        $end   = $this->finished_at;
        switch ($this->type) {
            case 'day_off':
                $duration = 1;
                break;
            case 'vacation':
                $duration = $start->diffInDaysFiltered(function (Carbon $date) {
                    return !$date->isWeekend();
                }, $end->addDay());
                break;
            default:
                $days  = $start->diffInDaysFiltered(function (Carbon $date) {
                    return !$date->isWeekend();
                }, $end->subDay());
                $hours = $start->diffInHoursFiltered(function (Carbon $date) {
                    return !$date->isWeekend();
                }, $end->addDay());
                $duration = $hours - $days * 24;
                $duration = $duration / 8 + $days;
                break;
        }

        return $duration;
    }

    /**
     * Get the employee of the time-off
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }
}
