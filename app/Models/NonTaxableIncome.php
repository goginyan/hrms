<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\NonTaxableIncome
 *
 * @property int         $id
 * @property string      $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|NonTaxableIncome newModelQuery()
 * @method static Builder|NonTaxableIncome newQuery()
 * @method static Builder|NonTaxableIncome query()
 * @method static Builder|NonTaxableIncome whereCreatedAt($value)
 * @method static Builder|NonTaxableIncome whereId($value)
 * @method static Builder|NonTaxableIncome whereName($value)
 * @method static Builder|NonTaxableIncome whereUpdatedAt($value)
 * @mixin Eloquent
 */
class NonTaxableIncome extends Model
{
    protected $fillable = ['name'];
}
