<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Tax
 *
 * @property int                           $id
 * @property string                        $name
 * @property Carbon|null                   $created_at
 * @property Carbon|null                   $updated_at
 * @property-read Collection|TaxInterval[] $taxIntervals
 * @property-read int|null                 $tax_intervals_count
 * @method static Builder|Tax newModelQuery()
 * @method static Builder|Tax newQuery()
 * @method static Builder|Tax query()
 * @method static Builder|Tax whereCreatedAt($value)
 * @method static Builder|Tax whereId($value)
 * @method static Builder|Tax whereName($value)
 * @method static Builder|Tax whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Tax extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function taxIntervals()
    {
        return $this->hasMany(TaxInterval::class, 'tax_id');
    }
}
