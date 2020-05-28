<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\Document
 *
 * @property int                             $id
 * @property int                             $author_id
 * @property int|null                        $type_id
 * @property int|null                        $waiting_id
 * @property array                           $fields
 * @property bool                            $approved
 * @property string|null                     $comment
 * @property int|null                        $rejected_by
 * @property string                          $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Employee                   $author
 * @property-read bool                       $rejected
 * @property-read Employee|null              $rejectedBy
 * @property-read DocType|null               $type
 * @property-read Employee|null              $waiting
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static Builder|Document onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereRejectedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereWaitingId($value)
 * @method static Builder|Document withTrashed()
 * @method static Builder|Document withoutTrashed()
 * @mixin Eloquent
 */
class Document extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fields',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fields'   => 'array',
        'approved' => 'boolean',
    ];

    /**
     * The attributes that are dynamically appending.
     *
     * @var array
     */
    protected $appends = [
        'rejected'
    ];

    /**
     * Accessor of the dynamic reject field
     *
     * @return bool
     */
    public function getRejectedAttribute()
    {
        return (!$this->approved && $this->rejectedBy);
    }

    /**
     * Get the author of the document
     *
     * @return BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get the employee who rejected the document
     *
     * @return BelongsTo
     */
    public function rejectedBy()
    {
        return $this->belongsTo('App\Models\Employee', 'rejected_by');
    }

    /**
     * Get the employee, whom waiting approval of document
     *
     * @return BelongsTo
     */
    public function waiting()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get the docType of document
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Models\DocType');
    }

    /**
     * Accessor for created_at column
     *
     * @param string $created_at
     *
     * @return string
     */
    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->format('H:i d.m.Y');
    }
}
