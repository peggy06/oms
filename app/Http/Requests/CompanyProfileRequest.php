<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CompanyProfileRequest extends Request
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
            'tech_area'     => 'required',
            'comp_sup'      => 'required',
            'comp_contact'  => 'required',
            'sched_on'      => 'required',
            'sched_off'     => 'required'
        ];
    }
}
