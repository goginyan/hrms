<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('role.index')->with([
            'roles' => Role::whereNull('parent_id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('role.add')->with([
            'permissions' => Permission::all()->pluck('name'),
            'roles' => Role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleStoreRequest $request)
    {
        $role = Role::create($request->all());
        $role->syncPermissions($request->permissions);
        $role->parent()->associate(Role::find($request->parent));
        $role->save();

        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
    public function edit(Role $role)
    {
        return view('role.edit')->with([
            'permissions' => Permission::all()->pluck('name'),
            'role'        => $role,
            'roles'       => Role::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleStoreRequest $request
     * @param Role             $role
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleStoreRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->syncPermissions($request->permissions);
        $role->parent()->associate($request->parent);
        $role->save();

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index');
    }

    /**
     * Get the organization structure
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function structure()
    {
        $employees = Employee::whereNull('manager_id')->get();

        return view('role.structure')->with([
            'employees' => $employees
        ]);
    }
}
