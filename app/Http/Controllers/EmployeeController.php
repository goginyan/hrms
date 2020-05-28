<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('employee.index')->with([
            'employees' => Employee::with(['department', 'user.roles'])->get()
        ]);
    }

    /**
     * Get the avatar of the employee for ajax request in notifications
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function avatars(Request $request)
    {
        if ($request->ajax()) {
            $employee = Employee::findOrFail($request->employee);

            return \response()->json([
                'id'     => $employee->id,
                'name'   => $employee->full_name,
                'avatar' => $employee->avatar
            ]);
        }

        return redirect()->route('dashboard');
    }

    /**
     * Display a detail listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details()
    {
        $employees      = Employee::with(['department', 'user.roles', 'employeeSalary'])->get();
        $employeesArray = [];
        foreach ($employees as $employee) {
            $employeesArray[] = [
                "id"          => $employee->id,
                "fullName"    => $employee->fullName,
                "patronymic"  => $employee->patronymic,
                "age"         => $employee->age,
                "gender"      => $employee->sex,
                "nationality" => $employee->nationality,
                "department"  => $employee->department->name,
                "jobTitle"    => $employee->role,
                "salary"      => $employee->currentSalary ?? 0,
                "paidTime"    => $employee->paid_time,
                "unpaidTime"  => $employee->unpaid_time,
                "recruited"   => $employee->created_at->format('d.m.Y')
            ];
        }

        return view('employee.details')->with([
            'employees'     => $employees,
            'employeesJson' => json_encode($employeesArray)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('employee.add')->with([
            'departments' => Department::all(),
            'roles'       => Role::all(),
            'statuses'    => Employee::$statuses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EmployeeStoreRequest $request)
    {
        $role     = Role::find($request->role);
        $user     = $role->users()->create($request->all());
        $employee = $user->employee()->create($request->all());
        $employee->department()->associate(Department::find($request->department));
        $employee->manager()->associate(Employee::find($request->manager));
        $employee->save();
        $user->sendEmailVerificationNotification();

        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Employee $employee)
    {
        return view('employee.show')->with([
            'employee' => $employee->loadMissing(['department', 'user.roles']),
            'statuses' => Employee::$statuses,
            'managers' => Employee::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Employee $employee
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Employee $employee)
    {
        return view('employee.edit')->with([
            'departments' => Department::all(),
            'roles'       => Role::all(),
            'employee'    => $employee->loadMissing(['department', 'user.roles', 'manager']),
            'statuses'    => Employee::$statuses,
            'managers'    => Employee::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeStoreRequest $request
     * @param Employee             $employee
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EmployeeStoreRequest $request, Employee $employee)
    {
        $employee->user->removeRole($employee->user->role);
        $employee->user->assignRole(Role::find($request->role));
        if (empty($request->password)) {
            $request->request->remove('password');
        }
        $employee->user->update($request->all());
        $employee->department()->dissociate();
        $employee->department()->associate(Department::find($request->department));
        $employee->manager()->dissociate();
        $employee->manager()->associate(Employee::find($request->manager));
        $employee->update($request->all());
        $employee->save();

        return redirect()->route('employees.show', ['employee' => $employee->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index');
    }
}
