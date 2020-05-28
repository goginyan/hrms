<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Education
 *
 * @property int                             $id
 * @property string                          $name
 * @property string|null                     $degree
 * @property string|null                     $department
 * @property string                          $specialization
 * @property string                          $date_from
 * @property string                          $date_to
 * @property int                             $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Employee                   $employee
 * @method static Builder|Education newModelQuery()
 * @method static Builder|Education newQuery()
 * @method static Builder|Education query()
 * @method static Builder|Education whereCreatedAt($value)
 * @method static Builder|Education whereDateFrom($value)
 * @method static Builder|Education whereDateTo($value)
 * @method static Builder|Education whereDegree($value)
 * @method static Builder|Education whereDepartment($value)
 * @method static Builder|Education whereEmployeeId($value)
 * @method static Builder|Education whereId($value)
 * @method static Builder|Education whereName($value)
 * @method static Builder|Education whereSpecialization($value)
 * @method static Builder|Education whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Education extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'degree',
        'department',
        'specialization',
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
     * Degrees of the educations
     *
     * @var array
     */
    public static $degrees = [
        'bachelor' => 'Bachelor',
        'master'   => 'Master',
        'phd'      => 'Ph.D.',
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
     * Get the employee that owns the education.
     *
     * @return BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }
}
