<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reward
 *
 * @property int                             $id
 * @property string                          $text
 * @property int                             $recognizer_id
 * @property int|null                        $rewarded_id
 * @property int                             $points
 * @property bool                            $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee       $recognizer
 * @property-read \App\Models\Employee|null  $rewarded
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereRecognizerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereRewardedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reward whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Reward extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text',
        'points',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Get the recognizer|employee of the reward
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recognizer()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get the rewarded employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rewarded()
    {
        return $this->belongsTo('App\Models\Employee');
    }
}
