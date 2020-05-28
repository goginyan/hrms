<?php

namespace App\Http\Controllers;

use App\Models\NonTaxableIncome;
use Illuminate\Http\Request;

class NonTaxableIncomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $non_taxable_incomes = NonTaxableIncome::all();

        return view('non_taxable_incomes.index', compact('non_taxable_incomes'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('non_taxable_incomes.add');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $non_taxable_income = NonTaxableIncome::create($request->only(['name']));

        return redirect()->route('non_taxable_income.edit', compact('non_taxable_income'));
    }

    /**
     * @param NonTaxableIncome $non_taxable_income
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(NonTaxableIncome $non_taxable_income)
    {
        return view('non_taxable_incomes.edit', compact('non_taxable_income'));
    }

    /**
     * @param NonTaxableIncome $non_taxable_income
     * @param Request          $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(NonTaxableIncome $non_taxable_income, Request $request)
    {
        $non_taxable_income->name = $request->name;
        $non_taxable_income->save();

        return back();
    }

    /**
     * @param NonTaxableIncome $non_taxable_income
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(NonTaxableIncome $non_taxable_income)
    {
        $non_taxable_income->delete();

        return back();
    }
}
