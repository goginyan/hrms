<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'title'       => 'required|string|min:2',
            'start_date'  => 'required|date',
            'end_date'    => 'date|nullable',
            'description' => 'string|nullable',
            'location'    => 'required|string',
            'file'        => 'file|nullable',
            'members'     => 'required|array',
            'members.*'   => 'exists:employees,id',
        ];
    }
}
