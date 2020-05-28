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
 * App\Models\ProfileFormField
 *
 * @property int                        $id
 * @property string|null                $column
 * @property string                     $label
 * @property bool                       $active
 * @property bool                       $required
 * @property int                        $type_id
 * @property Carbon|null                $created_at
 * @property Carbon|null                $updated_at
 * @property-read Collection|Employee[] $employee
 * @property-read int|null              $employee_count
 * @property-read mixed                 $protected
 * @property-read DocField              $type
 * @method static Builder|ProfileFormField newModelQuery()
 * @method static Builder|ProfileFormField newQuery()
 * @method static Builder|ProfileFormField query()
 * @method static Builder|ProfileFormField whereActive($value)
 * @method static Builder|ProfileFormField whereColumn($value)
 * @method static Builder|ProfileFormField whereCreatedAt($value)
 * @method static Builder|ProfileFormField whereId($value)
 * @method static Builder|ProfileFormField whereLabel($value)
 * @method static Builder|ProfileFormField whereRequired($value)
 * @method static Builder|ProfileFormField whereTypeId($value)
 * @method static Builder|ProfileFormField whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string                     $form_name
 * @method static Builder|ProfileFormField whereFormName($value)
 * @property int                        $is_protected
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfileFormField whereIsProtected($value)
 */
class ProfileFormField extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'column',
        'form_name'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'required' => 'boolean',
        'active'   => 'boolean',
    ];

    /**
     * Get the type of the formField
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Models\DocField');
    }

    /**
     * Get the employee who owns the field
     *
     * @return BelongsToMany
     */
    public function employee()
    {
        return $this->belongsToMany('App\Models\Employee')->withPivot('data');
    }
}
