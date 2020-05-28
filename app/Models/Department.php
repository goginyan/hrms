<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Department
 *
 * @property int                          $id
 * @property int|null                     $parent_id
 * @property string                       $name
 * @property string|null                  $description
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property-read Collection|Department[] $children
 * @property-read int|null                $children_count
 * @property-read Collection|Department[] $childrenRecursive
 * @property-read int|null                $children_recursive_count
 * @property-read Collection|Employee[]   $employees
 * @property-read int|null                $employees_count
 * @property-read Department|null         $parent
 * @method static Builder|Department newModelQuery()
 * @method static Builder|Department newQuery()
 * @method static Builder|Department query()
 * @method static Builder|Department whereCreatedAt($value)
 * @method static Builder|Department whereDescription($value)
 * @method static Builder|Department whereId($value)
 * @method static Builder|Department whereName($value)
 * @method static Builder|Department whereParentId($value)
 * @method static Builder|Department whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Department extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the employees of the department
     *
     * @return HasMany
     */
    public function employees()
    {
        return $this->hasMany('App\Models\Employee');
    }

    /**
     * Get the parent of the department
     *
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Department');
    }

    /**
     * Get the children of the department
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Models\Department', 'parent_id');
    }

    /**
     * Get all descendants of the department, recursive
     *
     * @return HasMany
     */
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }


}
