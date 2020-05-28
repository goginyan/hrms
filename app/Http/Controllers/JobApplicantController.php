<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Vacancy;
use App\Models\JobApplicant;
use Illuminate\Http\Request;

class JobApplicantController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:manage interviews', ['except' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('applicants.index')->with([
            'applicants' => JobApplicant::with('vacancy')->get(),
            'statuses'   => JobApplicant::$statuses,
            'vacancies'  => Vacancy::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $vacancy = Vacancy::findOrFail((int)$request->vacancy);

        return view('applicants.add')->with([
            'vacancy'   => $vacancy,
            'countries' => countries(true),
            'sexes'     => Employee::$sexes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vacancy   = Vacancy::findOrFail((int)$request->vacancy);
        $applicant = $vacancy->applicants()->create($request->all());
        $applicant->updateAttachments($request);

        return redirect()->route('applicants.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\JobApplicant $applicant
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(JobApplicant $applicant)
    {
        return view('applicants.show')->with([
            'applicant' => $applicant,
            'sexes'     => Employee::$sexes,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\JobApplicant $applicant
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(JobApplicant $applicant)
    {
        return view('applicants.edit')->with([
            'applicant' => $applicant,
            'vacancy'   => $applicant->vacancy,
            'sexes'     => Employee::$sexes,
            'countries' => countries(true),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\JobApplicant $applicant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, JobApplicant $applicant)
    {
        if ($request->ajax()) {
            $applicant->status = $request->status;
            $applicant->save();

            return response()->json([
                'message'  => 'ok',
                'instance' => $applicant->jsonSerialize()
            ]);
        }

        $applicant->update($request->all());
        $applicant->updateAttachments($request);

        return redirect()->route('applicants.show', $applicant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\JobApplicant $applicant
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(JobApplicant $applicant)
    {
        $applicant->delete();

        return redirect()->route('applicants.index');
    }
}
