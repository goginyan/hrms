<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
            'title'             => 'sometimes|string|min:2',
            'description'       => 'required|string|min:2',
            'parent_id'         => 'exists:tasks,id|nullable',
            'assign_type'       => 'required|string',
            'assignee_employee' => 'sometimes|exists:employees,id',
            'assignee_team'     => 'sometimes|exists:teams,id',
            'responsible_id'    => 'required|exists:employees,id',
            'attachments'       => 'array',
            'attachments.*'     => 'file',
            'type'              => 'string',
            'priority'          => 'string',
            'duration'          => 'integer|nullable',
            'deadline'          => 'date|nullable',
        ];
    }
}
