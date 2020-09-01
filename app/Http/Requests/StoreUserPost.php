<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserPost extends FormRequest
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
            'name' => 'required|max:30',
            'password' => 'required|confirmed',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users|regex:/(0)[0-9]{9}/|max:10',
        ];
    }
}
