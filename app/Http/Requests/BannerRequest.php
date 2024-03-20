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
            'image'         => 'required|mimes:jpeg,jpg,png,bmp|dimensions:min_width=1060,min_height=710',
        ]; 
        
        if ($this->isMethod('patch')) {
            $rules['image'] = 'mimes:jpeg,jpg,png,bmp';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'image.dimensions' => 'The :attribute must be exactly 1060 pixels wide and 710 pixels tall.',
        ];
    }
}
