<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalActionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Whether the user is the current approver is checked in the controller.
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
            'id' => ['required', 'integer'],
            'action' => ['required', 'in:approve,disapprove'],
            'remarks' => ['required_if:action,disapprove', 'nullable', 'string', 'max:255'],
        ];
    }
}