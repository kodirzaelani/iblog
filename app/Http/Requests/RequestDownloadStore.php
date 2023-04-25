<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestDownloadStore extends FormRequest
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
            'attach'      => 'mimes:pdf',
            'title'               => 'required|min:2|unique:downloads,title',
            'downloadcategory_id' => 'required',
            'description'         => 'required',
        ];
    }
}
