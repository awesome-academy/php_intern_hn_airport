<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractDriverPost extends FormRequest
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
            'phone' => 'required|regex:/(0)[0-9]{9}/|max:10',
            'car_plate' => 'required',
            'car_name' => 'required',
            'avatar' => 'image',
        ];
    }
}
