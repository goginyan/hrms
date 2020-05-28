<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CalendarSetting
 *
 * @property int         $id
 * @property string      $assignedTasksColor
 * @property string      $createdTasksColor
 * @property int         $employee_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CalendarSetting newModelQuery()
 * @method static Builder|CalendarSetting newQuery()
 * @method static Builder|CalendarSetting query()
 * @method static Builder|CalendarSetting whereAssignedTasksColor($value)
 * @method static Builder|CalendarSetting whereCreatedAt($value)
 * @method static Builder|CalendarSetting whereCreatedTasksColor($value)
 * @method static Builder|CalendarSetting whereEmployeeId($value)
 * @method static Builder|CalendarSetting whereId($value)
 * @method static Builder|CalendarSetting whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string      $assigned_tasks_color
 * @property string      $created_tasks_color
 */
class CalendarSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assigned_tasks_color',
        'created_tasks_color',
        'employee_id'
    ];
}
