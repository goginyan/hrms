<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\EmployeeSalaryNonTaxableIncome
 *
 * @property int                   $id
 * @property int                   $employee_salary_id
 * @property int                   $non_taxable_income_id
 * @property float                 $amount
 * @property Carbon|null           $created_at
 * @property Carbon|null           $updated_at
 * @property-read EmployeeSalary   $employeeSalary
 * @property-read NonTaxableIncome $nonTaxableIncome
 * @method static Builder|EmployeeSalaryNonTaxableIncome newModelQuery()
 * @method static Builder|EmployeeSalaryNonTaxableIncome newQuery()
 * @method static Builder|EmployeeSalaryNonTaxableIncome query()
 * @method static Builder|EmployeeSalaryNonTaxableIncome whereAmount($value)
 * @method static Builder|EmployeeSalaryNonTaxableIncome whereCreatedAt($value)
 * @method static Builder|EmployeeSalaryNonTaxableIncome whereEmployeeSalaryId($value)
 * @method static Builder|EmployeeSalaryNonTaxableIncome whereId($value)
 * @method static Builder|EmployeeSalaryNonTaxableIncome whereNonTaxableIncomeId($value)
 * @method static Builder|EmployeeSalaryNonTaxableIncome whereUpdatedAt($value)
 * @mixin Eloquent
 */
class EmployeeSalaryNonTaxableIncome extends Model
{
    protected $fillable = ['employee_salary_id', 'non_taxable_income_id', 'amount'];

    public function nonTaxableIncome()
    {
        return $this->belongsTo(NonTaxableIncome::class, 'non_taxable_income_id');
    }

    public function employeeSalary()
    {
        return $this->belongsTo(EmployeeSalary::class, 'employee_salary_id');
    }
}
