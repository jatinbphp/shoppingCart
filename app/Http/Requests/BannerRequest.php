<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title'         => 'required',
            'subtitle'      => 'required',
            'description'   => 'required',
            'status'        => 'required',
            'image'         => 'required|mimes:jpeg,jpg,png,bmp',
        ]; 
        
        if ($this->isMethod('patch')) {
            $rules['image'] = 'mimes:jpeg,jpg,png,bmp';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            // 'image.required' => 'The banner image field is required',
        ];
    }
}
