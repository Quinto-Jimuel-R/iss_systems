<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VPNRequest extends FormRequest
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
            'employee_no' => ['required', 'string', 'max:255'],
            'employee_name' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'request_type' => ['required', Rule::in(['New Access', 'Extension'])],
            'purpose' => ['required', 'string', 'max:255'],
            'date_from' => ['required', 'date'],
            'date_to' => ['required', 'date', 'after_or_equal:date_from'],
            'location' => ['required', 'string', 'max:255'],
            'device_name' => ['required', 'string', 'max:255'],
            'asset_tag' => ['required', 'string', 'max:255'],
        ];
    }
}
