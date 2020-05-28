<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Event
 *
 * @property int                        $id
 * @property string                     $title
 * @property Carbon                     $start_date
 * @property Carbon|null                $end_date
 * @property string                     $location
 * @property string                     $description
 * @property string|null                $file
 * @property bool                       $reminder
 * @property int|null                   $creator_id
 * @property Carbon|null                $created_at
 * @property Carbon|null                $updated_at
 * @property-read Employee|null         $creator
 * @property-read Collection|Employee[] $members
 * @property-read int|null              $members_count
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereCreatorId($value)
 * @method static Builder|Event whereDescription($value)
 * @method static Builder|Event whereEndDate($value)
 * @method static Builder|Event whereFile($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereLocation($value)
 * @method static Builder|Event whereReminder($value)
 * @method static Builder|Event whereStartDate($value)
 * @method static Builder|Event whereTitle($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'location',
        'description',
        'start_date',
        'end_date',
        'reminder'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'reminder' => 'boolean',
    ];

    /**
     * Accessor for open_date attribute
     *
     * @param $date
     *
     * @return string
     */
    public function getStartDateAttribute($date)
    {
        return $date ? Carbon::parse($date) : null;
    }

    /**
     * Accessor for end_date attribute
     *
     * @param $date
     *
     * @return string
     */
    public function getEndDateAttribute($date)
    {
        return $date ? Carbon::parse($date) : null;
    }

    /**
     * Mutator for open_date attribute
     *
     * @param $date
     */
    public function setStartDateAttribute($date)
    {
        $this->attributes['start_date'] = $date ? Carbon::parse($date) : null;
    }

    /**
     * Mutator for end_date attribute
     *
     * @param $date
     */
    public function setEndDateAttribute($date)
    {
        $this->attributes['end_date'] = $date ? Carbon::parse($date) : null;
    }

    /**
     * Get the members/employees of the event
     *
     * @return BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany('App\Models\Employee', 'employee_event', 'event_id', 'employee_id');
    }

    /**
     * Get the creator/employee of the event
     *
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\Models\Employee');
    }
}
