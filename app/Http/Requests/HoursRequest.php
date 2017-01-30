<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class HoursRequest extends Request
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
            'bsit' => 'required|min:300|max:600|integer',
            'bit' => 'required|min:300|max:600|integer'
        ];
    }
}
