<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestFotoUpdate extends FormRequest
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
            'title'           => 'required',
            'excerpt'         => 'required|max:350',
            'album_id'         => 'required',
        ];
    }
}
