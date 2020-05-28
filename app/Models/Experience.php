<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Experience
 *
 * @property int                             $id
 * @property string                          $name
 * @property string                          $position
 * @property string|null                     $description
 * @property string                          $date_from
 * @property string                          $date_to
 * @property int                             $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Employee                   $employee
 * @method static Builder|Experience newModelQuery()
 * @method static Builder|Experience newQuery()
 * @method static Builder|Experience query()
 * @method static Builder|Experience whereCreatedAt($value)
 * @method static Builder|Experience whereDateFrom($value)
 * @method static Builder|Experience whereDateTo($value)
 * @method static Builder|Experience whereDescription($value)
 * @method static Builder|Experience whereEmployeeId($value)
 * @method static Builder|Experience whereId($value)
 * @method static Builder|Experience whereName($value)
 * @method static Builder|Experience wherePosition($value)
 * @method static Builder|Experience whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Experience extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'position',
        'description',
        'date_from',
        'date_to',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_from',
        'date_to',
    ];

    /**
     * Accessor for date_from column
     *
     * @param string $dateFrom
     *
     * @return string
     */
    public function getDateFromAttribute($dateFrom)
    {
        return $dateFrom ? Carbon::parse($dateFrom)->format('d.m.Y') : null;
    }

    /**
     * Accessor for date_to column
     *
     * @param string $dateTo
     *
     * @return string|null
     */
    public function getDateToAttribute($dateTo)
    {
        return $dateTo ? Carbon::parse($dateTo)->format('d.m.Y') : null;
    }

    /**
     * Mutator for date_from column
     *
     * @param string $dateFrom
     */
    public function setDateFromAttribute($dateFrom)
    {
        $this->attributes['date_from'] = $dateFrom ? Carbon::parse($dateFrom) : null;
    }

    /**
     * Mutator for date_to column
     *
     * @param string $dateTo
     */
    public function setDateToAttribute($dateTo)
    {
        $this->attributes['date_to'] = $dateTo ? Carbon::parse($dateTo) : null;
    }

    /**
     * Get the employee that owns the experience.
     *
     * @return BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }
}
