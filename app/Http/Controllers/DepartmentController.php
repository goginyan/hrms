<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Models\Department;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('department.index')->with([
            'departments' => Department::whereNull('parent_id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $departments = Department::all();

        return view('department.add')->with([
            'departments' => $departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentStoreRequest $request
     *
     * @return Response
     */
    public function store(DepartmentStoreRequest $request)
    {
        if (!empty($request->parent_id)) {
            $parent = Department::find($request->parent_id);
            $parent->children()->create($request->all());
        } else {
            Department::create($request->all());
        }

        return redirect(route('departments.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Department $department
     *
     * @return Response
     */
    public function edit(Department $department)
    {
        $departments = Department::all();

        return view('department.edit')->with([
            'department'  => $department,
            'departments' => $departments
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DepartmentStoreRequest $request
     * @param Department             $department
     *
     * @return Response
     */
    public function update(DepartmentStoreRequest $request, Department $department)
    {
        $department->name        = $request->name;
        $department->description = $request->description;
        $department->parent()->dissociate();
        $department->parent()->associate(Department::find($request->parent_id));
        $department->save();

        return redirect(route('departments.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Department $department
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->back();
    }
}
