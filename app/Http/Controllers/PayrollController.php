<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\EmployeeSalaryBonus;
use App\Models\EmployeeSalaryNonTaxableIncome;
use App\Models\EmployeeSalaryTax;
use App\Models\NonTaxableIncome;
use App\Models\Tax;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $months = EmployeeSalary::groupBy('month')->select('month')->get()->toArray();

        return view('payroll.index', compact('months'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pickMonth()
    {
        return view('payroll.pick_month');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generatePayroll(Request $request)
    {
        $month               = $request->month;
        $employees           = Employee::all();
        $taxes               = Tax::all();
        $bonuses             = Bonus::all();
        $non_taxable_incomes = NonTaxableIncome::all();

        return view('payroll.generate', compact('employees', 'taxes', 'bonuses', 'non_taxable_incomes', 'month'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $month = $request->month;
        foreach ($request->employee as $index => $value) {
            $employeeSalary                 = EmployeeSalary::firstOrNew(['employee_id' => $index, 'month' => $month]);
            $employeeSalary->salary         = $value['salary'];
            $employeeSalary->total_bonuses  = $value['total_bonuses'];
            $employeeSalary->taxable_income = $value['taxable_income'];
            $employeeSalary->total_taxes    = $value['total_taxes'];
            $employeeSalary->total_nti      = $value['total_nti'];
            $employeeSalary->total_nti      = $value['total_nti'];
            $employeeSalary->income         = $value['income'];
            $employeeSalary->save();

            // preparing taxes
            $taxes = [];

            if (isset($value['tax']) && is_array($value['tax'])) {
                foreach ($value['tax'] as $id => $amount) {
                    $taxes[] = new EmployeeSalaryTax([
                        'employee_salary_id' => $employeeSalary->id,
                        'tax_id'             => $id,
                        'amount'             => $amount
                    ]);
                }
            }
            // synchronize taxes
            $employeeSalary->taxes()->delete();
            $employeeSalary->taxes()->saveMany($taxes);

            // preparing bonuses
            $bonuses = [];
            if (isset($value['bonus']) && is_array($value['bonus'])) {
                foreach ($value['bonus'] as $id => $amount) {
                    $bonuses[] = new EmployeeSalaryBonus([
                        'employee_salary_id' => $employeeSalary->id,
                        'bonus_id'           => $id,
                        'amount'             => $amount
                    ]);
                }
            }
            // synchronize bonuses
            $employeeSalary->bonuses()->delete();
            $employeeSalary->bonuses()->saveMany($bonuses);

            // preparing non taxable incomes
            $ntIncomes = [];
            if (isset($value['non_taxable_income']) && is_array($value['non_taxable_income'])) {
                foreach ($value['non_taxable_income'] as $id => $amount) {
                    $ntIncomes[] = new EmployeeSalaryNonTaxableIncome([
                        'employee_salary_id'    => $employeeSalary->id,
                        'non_taxable_income_id' => $id,
                        'amount'                => $amount
                    ]);
                }
            }

            // synchronize non taxable incomes
            $employeeSalary->nonTaxableIncomes()->delete();
            $employeeSalary->nonTaxableIncomes()->saveMany($ntIncomes);
        }

        return redirect()->route('payroll.index');
    }

    /**
     * @param string $month
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($month)
    {
        $employees           = Employee::all();
        $taxes               = Tax::all();
        $bonuses             = Bonus::all();
        $non_taxable_incomes = NonTaxableIncome::all();

        return view('payroll.show', compact('employees', 'taxes', 'bonuses', 'non_taxable_incomes', 'month'));
    }

    /**
     * @param mixed $employee_id
     * @param mixed $tax_id
     * @param mixed $salary
     *
     * @return array
     */
    public function calculateTaxDetails($employee_id, $tax_id, $salary)
    {
        $tax      = Tax::find($tax_id);
        $employee = Employee::find($employee_id);

        return $employee->calculateTaxDetails($tax, $salary);
    }
}
