<?php

namespace App\Models;

use App\Http\Requests\TaskStoreRequest;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Notification;

/**
 * App\Models\Task
 *
 * @property int                                                                     $id
 * @property int                                                                     $author_id
 * @property int|null                                                                $assignee_id
 * @property string|null                                                             $assignee_type
 * @property string                                                                  $title
 * @property string                                                                  $description
 * @property array|null                                                              $attachments
 * @property string                                                                  $type
 * @property string                                                                  $status
 * @property string                                                                  $priority
 * @property string                                                                  $started_at
 * @property string                                                                  $finished_at
 * @property string                                                                  $deadline
 * @property int|null                                                                $duration
 * @property int|null                                                                $responsible_id
 * @property int|null                                                                $parent_id
 * @property string                                                                  $created_at
 * @property \Illuminate\Support\Carbon|null                                         $updated_at
 * @property \Illuminate\Support\Carbon|null                                         $deleted_at
 * @property-read Task|null                                                          $assignee
 * @property-read Employee                                                           $author
 * @property-read Collection|Task[]                                                  $children
 * @property-read int|null                                                           $children_count
 * @property-read Collection|Task[]                                                  $childrenRecursive
 * @property-read int|null                                                           $children_recursive_count
 * @property-read Task|null                                                          $parent
 * @property-read Employee|null                                                      $responsible
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static Builder|Task onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereAssigneeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereAssigneeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereResponsibleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @method static Builder|Task withTrashed()
 * @method static Builder|Task withoutTrashed()
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TimeTracker[] $trackers
 * @property-read int|null                                                           $trackers_count
 */
class Task extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'type',
        'deadline',
        'duration',
        'started_at',
        'finished_at',
        'status',
        'priority'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started_at',
        'finished_at',
        'deadline'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'attachments' => 'array',
        'duration' => 'integer'
    ];

    /**
     * Statuses of the tasks
     *
     * @var array
     */
    public static $statuses = [
        'new'         => 'New',
        'confirmed'   => 'Confirmed',
        'in_process'  => 'In Process',
        'in_testing'  => 'In Testing',
        'test_failed' => 'Test Failed',
        'done'        => 'Done',
        'closed'      => 'Closed',
    ];

    /**
     * Types of the tasks
     *
     * @var array
     */
    public static $types = [
        'task'    => 'Task',
        'bug'     => 'Bug',
        'feature' => 'Feature',
    ];

    /**
     * Priories of the tasks
     *
     * @var array
     */
    public static $priorities = [
        'normal' => 'Normal',
        'low'    => 'Low',
        'high'   => 'High',
        'urgent' => 'Urgent',
    ];

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

    /**
     * Accessor for started_at column
     *
     * @param string $started_at
     *
     * @return string
     */
    public function getStartedAtAttribute($started_at)
    {
        return $started_at ? Carbon::parse($started_at)->format('H:i d.m.Y') : null;
    }

    /**
     * Accessor for finished_at column
     *
     * @param string $finished_at
     *
     * @return string
     */
    public function getFinishedAtAttribute($finished_at)
    {
        return $finished_at ? Carbon::parse($finished_at)->format('H:i d.m.Y') : null;
    }

    /**
     * Accessor for deadline column
     *
     * @param string $deadline
     *
     * @return string
     */
    public function getDeadlineAttribute($deadline)
    {
        return $deadline ? Carbon::parse($deadline) : null;
    }

    /**
     * Get the author of the task
     *
     * @return BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get the assignee of the task
     *
     * @return MorphTo
     */
    public function assignee()
    {
        return $this->morphTo();
    }

    /**
     * Get the responsible employee of the task
     *
     * @return BelongsTo
     */
    public function responsible()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    /**
     * Get the parent of the task
     *
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Task');
    }

    /**
     * Get the children of the task
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Models\Task', 'parent_id');
    }

    /**
     * Get all descendants of the task, recursive
     *
     * @return HasMany
     */
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Get the time trackers of the task
     *
     * @return HasMany
     */
    public function trackers()
    {
        return $this->hasMany('App\Models\TimeTracker');
    }

    /**
     * Set the relations for the task
     *
     * @param TaskStoreRequest $request
     * @param Task             $task
     *
     * @return bool
     */
    public function updateRelations(TaskStoreRequest $request, $notification)
    {
        if ($request->assign_type == 'team') {
            $team = Team::find($request->assignee_team);
            $this->assignee()->associate($team);
            Notification::send($team->members, $notification);
        } else {
            $employee = Employee::find($request->assignee_employee);
            $this->assignee()->associate($employee);
            $employee->user->notify($notification);
        }
        $employee = Employee::find($request->responsible_id);
        $employee->user->notify($notification);
        $this->responsible()->associate($employee);
        if ($request->parent_id) {
            $this->parent()->associate(Task::find($request->parent_id));
        }

        return $this->save();
    }
}
