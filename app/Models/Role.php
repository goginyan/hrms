<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\RefreshesPermissionCache;

/**
 * App\Models\Role
 *
 * @property int                                                                                  $id
 * @property string                                                                               $name
 * @property string                                                                               $display_name
 * @property string|null                                                                          $description
 * @property int|null                                                                             $parent_id
 * @property Carbon|null                                                                          $created_at
 * @property Carbon|null                                                                          $updated_at
 * @property-read Collection|Role[]                                                               $children
 * @property-read int|null                                                                        $children_count
 * @property-read Collection|Role[]                                                               $childrenRecursive
 * @property-read int|null                                                                        $children_recursive_count
 * @property-read Collection|DocType[]                                                            $docTypes
 * @property-read int|null                                                                        $doc_types_count
 * @property-read Role|null                                                                       $parent
 * @property-read Collection|User[]                                                               $users
 * @property-read int|null                                                                        $users_count
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereDescription($value)
 * @method static Builder|Role whereDisplayName($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereParentId($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string                                                                               $guard_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null                                                                        $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereGuardName($value)
 */
class Role extends \Spatie\Permission\Models\Role
{

    public function __construct(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.defaults.guard');

        parent::__construct($attributes);

        $this->setTable(config('permission.table_names.roles'));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'guard_name'
    ];

    /**
     * Get docTypes which the role must approve
     *
     * @return MorphToMany
     */
    public function docTypes()
    {
        return $this->morphToMany('App\Models\DocType', 'role', 'doc_type_role');
    }

    /**
     * Get the parent role of the role
     *
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Get the children of the role
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Models\Role', 'parent_id');
    }

    /**
     * Get all descendants of the role, recursive
     *
     * @return HasMany
     */
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
}
