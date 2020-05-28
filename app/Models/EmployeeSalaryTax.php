<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\EmployeeSalaryTax
 *
 * @property int                 $id
 * @property int                 $employee_salary_id
 * @property int                 $tax_id
 * @property float               $amount
 * @property Carbon|null         $created_at
 * @property Carbon|null         $updated_at
 * @property-read EmployeeSalary $employeeSalary
 * @property-read Tax            $tax
 * @method static Builder|EmployeeSalaryTax newModelQuery()
 * @method static Builder|EmployeeSalaryTax newQuery()
 * @method static Builder|EmployeeSalaryTax query()
 * @method static Builder|EmployeeSalaryTax whereAmount($value)
 * @method static Builder|EmployeeSalaryTax whereCreatedAt($value)
 * @method static Builder|EmployeeSalaryTax whereEmployeeSalaryId($value)
 * @method static Builder|EmployeeSalaryTax whereId($value)
 * @method static Builder|EmployeeSalaryTax whereTaxId($value)
 * @method static Builder|EmployeeSalaryTax whereUpdatedAt($value)
 * @mixin Eloquent
 */
class EmployeeSalaryTax extends Model
{
    protected $fillable = ['employee_salary_id', 'tax_id', 'amount'];

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function employeeSalary()
    {
        return $this->belongsTo(EmployeeSalary::class, 'employee_salary_id');
    }
}
