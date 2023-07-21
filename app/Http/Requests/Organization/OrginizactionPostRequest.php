<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class OrginizactionPostRequest extends FormRequest
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

            'parent_id' => 'required|numeric',
            'above_id' =>  'required|numeric|exists:users,id',
            'user_id'   => 'required|numeric|exists:users,id',
            'level'     => 'nullable|numeric',
            'host_id'   => 'required|numeric|exists:hosts,id'
        ];
    }
}
