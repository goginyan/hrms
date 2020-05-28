<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\DocType
 *
 * @property int                                  $id
 * @property string                               $name
 * @property string                               $display_name
 * @property int                                  $author_id
 * @property Carbon|null                          $created_at
 * @property Carbon|null                          $updated_at
 * @property-read Collection|Role[]               $approveRoles
 * @property-read int|null                        $approve_roles_count
 * @property-read User                            $author
 * @property-read Collection|RoleDocTypeCreator[] $createRoles
 * @property-read int|null                        $create_roles_count
 * @property-read Collection|DocField[]           $fields
 * @property-read int|null                        $fields_count
 * @method static Builder|DocType newModelQuery()
 * @method static Builder|DocType newQuery()
 * @method static Builder|DocType query()
 * @method static Builder|DocType whereAuthorId($value)
 * @method static Builder|DocType whereCreatedAt($value)
 * @method static Builder|DocType whereDisplayName($value)
 * @method static Builder|DocType whereId($value)
 * @method static Builder|DocType whereName($value)
 * @method static Builder|DocType whereUpdatedAt($value)
 * @mixin Eloquent
 */
class DocType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name'
    ];

    /**
     * Get the author of the DocType
     *
     * @return BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the attached fields of the doc_type
     *
     * @return BelongsToMany
     */
    public function fields()
    {
        return $this->belongsToMany('App\Models\DocField')->withPivot(['field_name', 'order'])->orderBy('order');
    }

    /**
     * Get roles which must approve the docType
     *
     * @return MorphToMany
     */
    public function approveRoles()
    {
        return $this->morphedByMany('App\Models\Role', 'role', 'doc_type_role')->withPivot('sequence')->orderBy('sequence');
    }

    /**
     * Get roles which create the docType
     *
     * @return MorphToMany
     */
    public function createRoles()
    {
        return $this->morphedByMany('App\Models\RoleDocTypeCreator', 'role', 'doc_type_role');
    }
}
