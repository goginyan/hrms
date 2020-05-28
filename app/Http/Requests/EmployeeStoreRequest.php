<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EmployeeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws \Exception
     */
    public function authorize()
    {
        return Auth::user()->hasAnyPermission(['create employees', 'update employees']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'  => 'required|between:2,190|string',
            'last_name'   => 'required|between:2,190|string',
            'email'       => 'sometimes|required|email|unique:users',
            'password'    => 'nullable|sometimes|confirmed|min:6',
            'department'  => 'required|exists:departments,id',
            'role'        => 'required|exists:roles,id',
            'paid_time'   => 'nullable|integer',
            'unpaid_time' => 'nullable|integer',
            'status'      => 'required|string',
            'manager'     => 'required|exists:employees,id'
        ];
    }
}
