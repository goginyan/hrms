<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * App\Models\BlogPost
 *
 * @property int                                                                 $id
 * @property string                                                              $title
 * @property string                                                              $text
 * @property string|null                                                         $image
 * @property int                                                                 $author_id
 * @property \Illuminate\Support\Carbon|null                                     $created_at
 * @property \Illuminate\Support\Carbon|null                                     $updated_at
 * @property \Illuminate\Support\Carbon|null                                     $deleted_at
 * @property-read \App\Models\Employee                                           $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[]     $tags
 * @property-read int|null                                                       $tags_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogPost newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BlogPost onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogPost query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogPost whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogPost whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogPost whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogPost whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogPost whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BlogPost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BlogPost withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BlogPost withoutTrashed()
 * @mixin \Eloquent
 * @property-read string                                                         $preview
 */
class BlogPost extends Model implements Searchable
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'text',
    ];

    /**
     * Get the author of the blog post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get the tags of the blog post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }

    /**
     * Get the blog post preview
     *
     * @return string
     */
    public function getPreviewAttribute()
    {
        return Str::limit($this->text, 100);

    }

    /**
     * Need for get search results for the posts
     *
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $url = route('blog.show', $this->id);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    /**
     * Overwrite parent toArray() for include in search author full Name
     *
     * @return array
     */
    public function toArray()
    {
        $attrArray           = $this->attributesToArray();
        $attrArray['author'] = $this->author->full_name;

        return $attrArray;
    }
}
