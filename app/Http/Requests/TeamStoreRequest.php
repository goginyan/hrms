<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'sometimes|string|min:2',
            'purpose'     => 'sometimes|string|min:2',
            'description' => 'string|nullable',
            'members'     => 'sometimes|array',
            'members.*'   => 'integer|exists:employees,id',
            'roles'       => 'sometimes|array',
            'roles.*'     => 'string|min:2'
        ];
    }
}
