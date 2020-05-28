<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SettingsStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasPermissionTo('manage settings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => 'required|string|min:2',
            'company_logo' => 'file',
            'language'     => 'required|string|min:2',
            'timezone'     => 'required|string|min:3',
            'email'        => 'sometimes|email|unique:users',
            'password'     => 'nullable|string|min:4',
            'mail_from'    => 'required|email',
            'mail_name'    => 'required|string|min:3',
        ];
    }
}
