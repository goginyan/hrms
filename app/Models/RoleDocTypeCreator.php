<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;

/**
 * Class RoleDocTypeCreator
 * Extends the Role Model
 * For polymorphic relation
 * With DocType Model
 *
 * @package App\Models
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
 * @property-read Collection|DocType[]                                                            $createDocTypes
 * @property-read int|null                                                                        $create_doc_types_count
 * @property-read Collection|DocType[]                                                            $docTypes
 * @property-read int|null                                                                        $doc_types_count
 * @property-read Role|null                                                                       $parent
 * @property-read Collection|User[]                                                               $users
 * @property-read int|null                                                                        $users_count
 * @method static Builder|RoleDocTypeCreator newModelQuery()
 * @method static Builder|RoleDocTypeCreator newQuery()
 * @method static Builder|RoleDocTypeCreator query()
 * @method static Builder|RoleDocTypeCreator whereCreatedAt($value)
 * @method static Builder|RoleDocTypeCreator whereDescription($value)
 * @method static Builder|RoleDocTypeCreator whereDisplayName($value)
 * @method static Builder|RoleDocTypeCreator whereId($value)
 * @method static Builder|RoleDocTypeCreator whereName($value)
 * @method static Builder|RoleDocTypeCreator whereParentId($value)
 * @method static Builder|RoleDocTypeCreator whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string                                                                               $guard_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null                                                                        $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleDocTypeCreator whereGuardName($value)
 */
class RoleDocTypeCreator extends Role
{

    public function __construct(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.defaults.guard');

        parent::__construct($attributes);

        $this->setTable(config('permission.table_names.roles'));
    }

    /**
     * Call parent boot method for extending
     */
    public static function boot()
    {
        parent::boot();
    }

    /**
     * Get docTypes which the user with this role can create
     *
     * @return MorphToMany
     */
    public function createDocTypes()
    {
        return $this->morphToMany('App\Models\DocType', 'role', 'doc_type_role');
    }
}
