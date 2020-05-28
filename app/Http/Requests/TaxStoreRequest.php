<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxStoreRequest extends FormRequest
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
        $rules['name'] = 'required|string';

        foreach ($this->request->get('intervals') as $key => $val) {
            $rules['intervals.' . $key . '.start'] = 'required|numeric';
            $rules['intervals.' . $key . '.end']   = 'required|numeric|gt:intervals.' . $key . '.start';
        }

        return $rules;
    }
}
