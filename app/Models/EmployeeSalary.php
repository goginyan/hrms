<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\EmployeeSalary
 *
 * @property int                                              $id
 * @property int                                              $employee_id
 * @property float                                            $salary
 * @property float                                            $total_bonuses
 * @property float                                            $taxable_income
 * @property float                                            $total_taxes
 * @property float                                            $total_nti
 * @property float                                            $income
 * @property string                                           $month
 * @property string                                           $status
 * @property Carbon|null                                      $created_at
 * @property Carbon|null                                      $updated_at
 * @property-read Collection|EmployeeSalaryBonus[]            $bonuses
 * @property-read int|null                                    $bonuses_count
 * @property-read Employee                                    $employee
 * @property-read Collection|EmployeeSalaryNonTaxableIncome[] $nonTaxableIncomes
 * @property-read int|null                                    $non_taxable_incomes_count
 * @property-read Collection|EmployeeSalaryTax[]              $taxes
 * @property-read int|null                                    $taxes_count
 * @method static Builder|EmployeeSalary newModelQuery()
 * @method static Builder|EmployeeSalary newQuery()
 * @method static Builder|EmployeeSalary query()
 * @method static Builder|EmployeeSalary whereCreatedAt($value)
 * @method static Builder|EmployeeSalary whereEmployeeId($value)
 * @method static Builder|EmployeeSalary whereId($value)
 * @method static Builder|EmployeeSalary whereIncome($value)
 * @method static Builder|EmployeeSalary whereMonth($value)
 * @method static Builder|EmployeeSalary whereSalary($value)
 * @method static Builder|EmployeeSalary whereStatus($value)
 * @method static Builder|EmployeeSalary whereTaxableIncome($value)
 * @method static Builder|EmployeeSalary whereTotalBonuses($value)
 * @method static Builder|EmployeeSalary whereTotalNti($value)
 * @method static Builder|EmployeeSalary whereTotalTaxes($value)
 * @method static Builder|EmployeeSalary whereUpdatedAt($value)
 * @mixin Eloquent
 */
class EmployeeSalary extends Model
{
    protected $fillable = [
        'employee_id',
        'salary',
        'total_bonuses',
        'taxable_income',
        'total_taxes',
        'total_nti',
        'income',
        'month',
        'status'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function taxes()
    {
        return $this->hasMany(EmployeeSalaryTax::class, 'employee_salary_id');
    }

    public function bonuses()
    {
        return $this->hasMany(EmployeeSalaryBonus::class, 'employee_salary_id');
    }

    public function nonTaxableIncomes()
    {
        return $this->hasMany(EmployeeSalaryNonTaxableIncome::class, 'employee_salary_id');
    }
}
