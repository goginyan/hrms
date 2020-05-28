<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TimeOffStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'        => 'required|string',
            'paid'        => 'required|boolean',
            'started_at'  => 'required|date',
            'finished_at' => 'required|date',
            'reason'      => 'nullable|string',
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
            'started_at.required'  => 'Start datetime is required',
            'finished_at.required' => 'End datetime is required',
            'started_at.date'      => 'Start datetime must be a valid date',
            'finished_at.date'     => 'End datetime must be a valid date',
        ];
    }
}
