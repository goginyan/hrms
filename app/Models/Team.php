<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Team
 *
 * @property int                                                                  $id
 * @property string                                                               $name
 * @property string|null                                                          $description
 * @property string|null                                                          $purpose
 * @property int|null                                                             $creator_id
 * @property Carbon|null                                                          $created_at
 * @property Carbon|null                                                          $updated_at
 * @property-read Collection|Employee[]                                           $admin
 * @property-read int|null                                                        $admin_count
 * @property-read Collection|Employee[]                                           $creator
 * @property-read int|null                                                        $creator_count
 * @property-read Collection|Employee[]                                           $leader
 * @property-read int|null                                                        $leader_count
 * @property-read Collection|Employee[]                                           $members
 * @property-read int|null                                                        $members_count
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team query()
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereCreatorId($value)
 * @method static Builder|Team whereDescription($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team wherePurpose($value)
 * @method static Builder|Team whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Task[]                                               $assignedTasks
 * @property-read int|null                                                        $assigned_tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[] $admins
 * @property-read int|null                                                        $admins_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[] $leaders
 * @property-read int|null                                                        $leaders_count
 */
class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'purpose',
    ];

    /**
     * The roles that are assignable
     * to the employees in team
     *
     * @var array
     */
    public static $roles = [
        'member' => 'Member',
        'lead'   => 'Leader',
        'admin'  => 'Administrator'
    ];

    /**
     * Get the employees of the team
     *
     * @return BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany('App\Models\Employee')->withPivot('role');
    }

    /**
     * Get the creator of the team
     *
     * @return BelongsToMany
     */
    public function creator()
    {
        return $this->members()->wherePivot('role', 'creator');
    }

    /**
     * Get the administrator of the team
     *
     * @return BelongsToMany
     */
    public function admins()
    {
        return $this->members()->wherePivot('role', 'admin');
    }

    /**
     * Get the leader of the team
     *
     * @return BelongsToMany
     */
    public function leaders()
    {
        return $this->members()->wherePivot('role', 'lead');
    }

    /**
     * Get the tasks assigned to the team
     *
     * @return MorphMany
     */
    public function assignedTasks()
    {
        return $this->morphMany('App\Models\Task', 'assignee');
    }
}
