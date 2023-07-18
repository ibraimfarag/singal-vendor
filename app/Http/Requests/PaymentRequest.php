<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return  true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = $this->payment_method == 'Stripe' ? 'required' : '';

        return [
            'card'  => $data,
            'cvc'   => $data,
            'month' => $data,
            'year'  => $data
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'card.required'   =>  __('Card field is required.'),
            'cvc.required'    =>  __('Cvc field is required.'),
            'month.required'  =>  __('Month field is required.'),
            'year.required'   =>  __('Year field is required.')
        ];
    }

}
