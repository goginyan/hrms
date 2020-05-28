<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use Illuminate\Http\Request;

class BonusesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $bonuses = Bonus::all();

        return view('bonuses.index', compact('bonuses'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('bonuses.add');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $bonus = Bonus::create($request->only(['name']));

        return redirect()->route('bonuses.edit', compact('bonus'));
    }

    /**
     * @param Bonus $bonus
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Bonus $bonus)
    {
        return view('bonuses.edit', compact('bonus'));
    }

    /**
     * @param Bonus   $bonus
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Bonus $bonus, Request $request)
    {
        $bonus->name = $request->name;
        $bonus->save();

        return back();
    }

    /**
     * @param Bonus $bonus
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Bonus $bonus)
    {
        $bonus->delete();

        return back();
    }
}
