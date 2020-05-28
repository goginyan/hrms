<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * App\Models\Report
 *
 * @property int                             $id
 * @property string                          $title
 * @property array                           $fields
 * @property bool                            $has_chart
 * @property string                          $order_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereHasChart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereOrderBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string                          $order_column
 * @property string                          $ordering
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereOrdering($value)
 * @property int|null                        $survey_id
 * @property-read \App\Models\Survey|null    $survey
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereSurveyId($value)
 */
class Report extends Model implements Searchable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'fields',
        'has_chart',
        'order_by',
        'ordering'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fields'    => 'array',
        'has_chart' => 'boolean'
    ];

    /**
     * Need for get search results for the posts
     *
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $url = route('reports.show', $this->id);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    /**
     * Get the survey, from which was created the report
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo('App\Models\Survey');
    }
}
