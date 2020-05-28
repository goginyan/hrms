<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Vacancy;
use App\Models\User;
use App\Notifications\VacancyPublished;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('vacancies.index')->with([
            'vacancies' => Vacancy::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function create()
    {
        $countries  = countries(true);
        $currencies = [];
        foreach ($countries as $country) {
            if (!$country['currency']) {
                continue;
            }
            foreach ($country['currency'] as $currency) {
                if (!$currency['iso_4217_code']) {
                    continue;
                }
                $currencies[$currency['iso_4217_code']] = $currency['iso_4217_name'];
            }
        }

        return view('vacancies.add')->with([
            'statuses'   => Vacancy::$statuses,
            'employees'  => Employee::all(),
            'countries'  => $countries,
            'currencies' => Collection::make($currencies)->unique()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $vacancy = Vacancy::create($request->all());
        \Notification::send(User::all(), new VacancyPublished($vacancy));

        return redirect()->route('vacancies.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Vacancy $vacancy
     *
     * @return Response
     */
    public function edit(Vacancy $vacancy)
    {
        $countries  = countries(true);
        $currencies = [];
        foreach ($countries as $country) {
            if (!$country['currency']) {
                continue;
            }
            foreach ($country['currency'] as $currency) {
                if (!$currency['iso_4217_code']) {
                    continue;
                }
                $currencies[$currency['iso_4217_code']] = $currency['iso_4217_name'];
            }
        }

        return view('vacancies.edit')->with([
            'vacancy'    => $vacancy,
            'statuses'   => Vacancy::$statuses,
            'employees'  => Employee::all(),
            'countries'  => $countries,
            'currencies' => Collection::make($currencies)->unique()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Vacancy $vacancy
     *
     * @return Response
     */
    public function update(Request $request, Vacancy $vacancy)
    {
        $vacancy->update($request->all());
        $vacancy->published = !!$request->published;
        $vacancy->save();

        return redirect()->route('vacancies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Vacancy $vacancy
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return redirect()->route('vacancies.index');
    }
}
