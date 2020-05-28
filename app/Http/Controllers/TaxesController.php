<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxStoreRequest;
use App\Models\Tax;
use App\Models\TaxInterval;
use Illuminate\Http\Request;

class TaxesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $taxes = Tax::all();

        return view('taxes.index', compact('taxes'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('taxes.add');
    }

    /**
     * @param TaxStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaxStoreRequest $request)
    {
        $tax = Tax::create($request->only(['name']));
        foreach ($request->intervals as $interval) {
            $taxInterval        = new TaxInterval();
            $taxInterval->start = $interval['start'];
            $taxInterval->end   = $interval['end'];
            $taxInterval->rate  = $interval['rate'];
            $taxInterval->tax()->associate($tax);
            $taxInterval->save();
        }

        return redirect()->route('taxes.edit', compact('tax'));
    }

    /**
     * @param Tax $tax
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Tax $tax)
    {
        return view('taxes.edit', compact('tax'));
    }

    /**
     * @param Tax             $tax
     * @param TaxStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Tax $tax, TaxStoreRequest $request)
    {
        $tax->update($request->toArray());

        $tax->taxIntervals()->delete();

        foreach ($request->intervals as $interval) {
            $taxInterval        = new TaxInterval();
            $taxInterval->start = $interval['start'];
            $taxInterval->end   = $interval['end'];
            $taxInterval->rate  = $interval['rate'];
            $taxInterval->tax()->associate($tax);
            $taxInterval->save();
        }

        return back();
    }

    /**
     * @param Tax $tax
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Tax $tax)
    {
        $tax->delete();

        return back();
    }
}
