<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Redeemable
 *
 * @property int                                                                  $id
 * @property string                                                               $title
 * @property string|null                                                          $description
 * @property string|null                                                          $image
 * @property int                                                                  $price
 * @property \Illuminate\Support\Carbon|null                                      $created_at
 * @property \Illuminate\Support\Carbon|null                                      $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[] $employees
 * @property-read int|null                                                        $employees_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redeemable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redeemable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redeemable query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redeemable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redeemable whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redeemable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redeemable whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redeemable wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redeemable whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Redeemable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Redeemable extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    /**
     * Get employees who redeemed the redeemable product or service
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees()
    {
        return $this->belongsToMany('App\Models\Employee')->withPivot('date');
    }
}
