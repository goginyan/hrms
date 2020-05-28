<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\TaxInterval
 *
 * @property int         $id
 * @property int         $tax_id
 * @property float       $start
 * @property float       $end
 * @property float       $rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Tax    $tax
 * @method static Builder|TaxInterval newModelQuery()
 * @method static Builder|TaxInterval newQuery()
 * @method static Builder|TaxInterval query()
 * @method static Builder|TaxInterval whereCreatedAt($value)
 * @method static Builder|TaxInterval whereEnd($value)
 * @method static Builder|TaxInterval whereId($value)
 * @method static Builder|TaxInterval whereRate($value)
 * @method static Builder|TaxInterval whereStart($value)
 * @method static Builder|TaxInterval whereTaxId($value)
 * @method static Builder|TaxInterval whereUpdatedAt($value)
 * @mixin Eloquent
 */
class TaxInterval extends Model
{
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }
}
