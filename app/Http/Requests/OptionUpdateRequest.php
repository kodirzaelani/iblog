<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionUpdateRequest extends FormRequest
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
            'logo'           => 'image|mimes:jpeg,jpg,png|max:1200',
            'favicon'           => 'image|mimes:png|max:600',
            // 'webname'           => 'required',
            // 'tagline'           => 'required',
            // 'siteurl'           => 'required',
            // 'homeurl'           => 'required',
            // 'description'    => 'required|max:350',
        ];
    }
}
