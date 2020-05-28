<?php

namespace App\Http\Controllers\PublicPart;

use App\Mail\JobApplicationForm;
use App\Models\Employee;
use App\Models\Vacancy;
use App\Models\JobApplicant;
use App\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CareersController extends Controller
{
    /**
     * Show the Careers page with available vacancies
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('public.careers.index')->with([
            'vacancies' => Vacancy::all()
        ]);
    }

    /**
     * Show the specified vacancy
     *
     * @param Vacancy $vacancy
     *
     * @return Factory|RedirectResponse|View
     */
    public function show(Vacancy $vacancy)
    {
        if (!$vacancy->published) {
            return redirect()->route('careers.index');
        }

        return view('public.careers.show')->with([
            'vacancy' => $vacancy
        ]);
    }

    /**
     * Show the application form of the vacancy
     *
     * @param Vacancy $vacancy
     *
     * @return Factory|RedirectResponse|View
     */
    public function apply(Vacancy $vacancy)
    {
        if (!$vacancy->with_form) {
            return redirect()->route('careers.show', ['vacancy' => $vacancy->id]);
        }

        return view('public.careers.apply')->with([
            'vacancy'   => $vacancy,
            'countries' => countries(true),
            'sexes'     => Employee::$sexes
        ]);
    }

    /**
     * Store application form in database
     *
     * @param Request $request
     * @param Vacancy $vacancy
     *
     * @return RedirectResponse
     */
    public function store(Request $request, Vacancy $vacancy)
    {
        $applicant = $vacancy->applicants()->create($request->all());
        $applicant->updateAttachments($request);
        $hr       = Role::whereName('hr')->first()->users->first();
        $receiver = $hr ? $hr : Role::whereName('root')->first()->users->first();
        Mail::to($receiver)->send(new JobApplicationForm($applicant));

        return redirect()->route('careers.index');
    }
}
