<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestPost extends FormRequest
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
            'car_type_id' => 'required',
            'province_airport_id' => 'required',
            'pickup' => 'required',
            'budget' => 'required',
            'pickup_location' => 'required',
            'dropoff_location' => 'required',
        ];
    }
}
