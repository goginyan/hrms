<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RoleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws \Exception
     */
    public function authorize()
    {
        return Auth::user()->hasAnyPermission(['create roles', 'update roles']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'sometimes|min:2|string|unique:roles',
            'display_name'  => 'required|min:2|string',
            'parent'        => 'nullable|exists:roles,id',
            'permissions'   => 'array',
            'permissions.*' => 'exists:permissions,name',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'permissions.*.exists' => 'The permissions are invalid'
        ];
    }
}
