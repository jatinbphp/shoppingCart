<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderPlacedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'address_id' => 'required',
            'delivery_method' => 'required',
        ];

        if ($this->input('address_id')==0) {
            $additionalRules = [
                'title' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'company' => 'required',
                'mobile_phone' => 'required',
                'address_line1' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'pincode' => 'required',
            ];

            // Merge additional rules with the existing rules
            $rules = array_merge($rules, $additionalRules);
        }
        
        return $rules;
    }
}
