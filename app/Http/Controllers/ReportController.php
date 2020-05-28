<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Report;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Searchable\Search;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('reports.index')->with([
            'reports' => Report::all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Report $report
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Request $request, Report $report)
    {
        $employees = Employee::with([
            'department',
            'user.roles',
            'employeeSalary'
        ]);
        if ($request->hasAny(['department', 'role', 'status']) && $request->ajax()) {
            if ($request->department) {
                $employees = $employees->whereHas('department', function (Builder $query) use ($request) {
                    $query->where('id', $request->department);
                });
            }
            if ($request->role) {
                $employees = $employees->whereHas('user', function (Builder $query) use ($request) {
                    $query->role($request->role);
                });
            }
            if ($request->status) {
                $employees = $employees->where('status', $request->status);
            }
        }
        $employees      = $employees->get();
        $employeesArray = [];
        foreach ($employees as $employee) {
            $emp = [];
            foreach ($report->fields as $field) {
                if (is_array($field)) {
                    if ($employee->questions->where('id', $field['id'])->first()) {
                        $answer      = $employee->questions->where('id', $field['id'])->first()->pivot->answer;
                        $answerArray = json_decode($answer, true);
                        $text        = json_last_error() === JSON_ERROR_NONE && is_array($answerArray) ? implode(", ", $answerArray) : $answer;
                    } else {
                        $text = null;
                    }
                    $emp[$field['text']] = $text;
                } else {
                    $emp[$field] = $employee->getAttribute($field);
                }
            }
            $employeesArray[] = $emp;
        }

        if ($request->ajax()) {
            return response()->json($employeesArray);
        }

        return view('reports.show')->with([
            'report'      => $report,
            'employees'   => $employeesArray,
            'reportJson'  => json_encode($employeesArray),
            'departments' => Department::all(),
            'statuses'    => Employee::$statuses,
            'roles'       => Role::all()
        ]);
    }

    /**
     * Search the specified resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $searchResults = (new Search())
            ->registerModel(Report::class, 'title')
            ->search($request->search);

        return response()->json($searchResults->jsonSerialize());
    }
}
