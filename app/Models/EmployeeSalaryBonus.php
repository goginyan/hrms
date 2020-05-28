<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\EmployeeSalaryBonus
 *
 * @property int                 $id
 * @property int                 $employee_salary_id
 * @property int                 $bonus_id
 * @property float               $amount
 * @property Carbon|null         $created_at
 * @property Carbon|null         $updated_at
 * @property-read Bonus          $bonus
 * @property-read EmployeeSalary $employeeSalary
 * @method static Builder|EmployeeSalaryBonus newModelQuery()
 * @method static Builder|EmployeeSalaryBonus newQuery()
 * @method static Builder|EmployeeSalaryBonus query()
 * @method static Builder|EmployeeSalaryBonus whereAmount($value)
 * @method static Builder|EmployeeSalaryBonus whereBonusId($value)
 * @method static Builder|EmployeeSalaryBonus whereCreatedAt($value)
 * @method static Builder|EmployeeSalaryBonus whereEmployeeSalaryId($value)
 * @method static Builder|EmployeeSalaryBonus whereId($value)
 * @method static Builder|EmployeeSalaryBonus whereUpdatedAt($value)
 * @mixin Eloquent
 */
class EmployeeSalaryBonus extends Model
{
    protected $fillable = ['employee_salary_id', 'bonus_id', 'amount'];

    public function bonus()
    {
        return $this->belongsTo(Bonus::class, 'bonus_id');
    }

    public function employeeSalary()
    {
        return $this->belongsTo(EmployeeSalary::class, 'employee_salary_id');
    }
}
