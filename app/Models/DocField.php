<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\DocField
 *
 * @property int                       $id
 * @property string                    $name
 * @property string                    $partial
 * @property Carbon|null               $created_at
 * @property Carbon|null               $updated_at
 * @property-read Collection|DocType[] $docTypes
 * @property-read int|null             $doc_types_count
 * @method static Builder|DocField newModelQuery()
 * @method static Builder|DocField newQuery()
 * @method static Builder|DocField query()
 * @method static Builder|DocField whereCreatedAt($value)
 * @method static Builder|DocField whereId($value)
 * @method static Builder|DocField whereName($value)
 * @method static Builder|DocField wherePartial($value)
 * @method static Builder|DocField whereUpdatedAt($value)
 * @mixin Eloquent
 */
class DocField extends Model
{
    /**
     * Get the doc_types where the field attached
     *
     * @return HasMany
     */
    public function docTypes()
    {
        return $this->hasMany('App\Models\DocType');
    }
}
