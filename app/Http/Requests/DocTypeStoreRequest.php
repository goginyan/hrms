<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DocTypeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws \Exception
     */
    public function authorize()
    {
        return Auth::user()->hasAnyPermission(['create doc-types', 'update doc-types']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'required|string|min:2',
            'display_name'   => 'required|string|min:2',
            'fields_types'   => 'required|array',
            'fields_types.*' => 'required|exists:doc_fields,id',
            'fields_names'   => 'required|array',
            'fields_names.*' => 'required|string|min:2',
            'approveRoles'   => 'required|array',
            'approveRoles.*' => 'required|distinct|exists:roles,id',
            'createRoles'    => 'required|array',
            'createRoles.*'  => 'required|distinct|exists:roles,id',
            'sequence'       => 'required|array',
            'sequence.*'     => 'required|distinct',
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
            'fields_names.*.required' => 'The label is required'
        ];
    }
}
