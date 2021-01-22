<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Title' => 'required|min:1|max:255',
            'Released' => 'required|min:4|max:255',
            'Genre' => 'required|min:4|max:255',

        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [

                'title.required' => 'Please provide title name which is between 1 and 255 characters.',
            'genre.required' => 'Please provide valid genre which is between 4 and 255 characters.',
            'name.required' => 'Please provide valid name which is between 4 and 8 characters.'
        ];
    }
}
