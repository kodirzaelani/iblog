<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationStoreRequest extends FormRequest
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
            'image'           => 'image|mimes:jpeg,jpg,png|max:1500',
            'title'           => 'required|unique:organizations,title',
            // 'description'     => 'required',
            'pergub_id'     => 'required',
            'urut'         => 'required|numeric|unique:organizations,urut',
        ];
    }
}
