<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class Departments extends Controller
{
    public function index()
    {

        $departments = Department::with('childrenRecursive')->whereNull('parent_id')->get();

        return view('department.index', compact('departments'));
    }

    public function add()
    {
        $departments = Department::all();

        return view('department.add', compact('departments'));
    }

    public function create(Request $request)
    {
        $department = new Department();

        $department->name = $request->name;
        $department->description = $request->description;
        if ($request->parent_id) {
            $department->parent_id = $request->parent_id;
        }

        $department->save();

        return redirect(route('departments'));
    }

    public function edit($id)
    {
        $department = Department::find($id);

        if ($department) {
            $departments = Department::all();
            return view('department.edit', compact('departments', 'department'));
        } else {
            return abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        if ($department) {
            $department->name = $request->name;
            $department->description = $request->description;
            $department->parent_id = $request->parent_id;
            $department->save();

            return redirect()->back();
        } else {
            return abort(404);
        }
    }
}
