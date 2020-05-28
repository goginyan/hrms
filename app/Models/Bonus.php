<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Bonus
 *
 * @property int         $id
 * @property string      $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Bonus newModelQuery()
 * @method static Builder|Bonus newQuery()
 * @method static Builder|Bonus query()
 * @method static Builder|Bonus whereCreatedAt($value)
 * @method static Builder|Bonus whereId($value)
 * @method static Builder|Bonus whereName($value)
 * @method static Builder|Bonus whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Bonus extends Model
{
    protected $fillable = ['name'];
}
