<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserAddressesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'company' => 'nullable|string|max:50',
            'mobile_phone' => 'required|min:10|max:10|regex:/[0-9]{9}/', 
            'address_line1' => 'required|string|max:100',
            'address_line2' => 'nullable|string|max:100',
            'pincode' => 'required|regex:/^[0-9]{3,7}$/',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'country' => 'required|string|max:50',
        ];
    }
}
