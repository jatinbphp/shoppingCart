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
            'title'         => 'required|max:50',
            'subtitle'      => 'required|max:50',
            'description'   => 'required|max:500',
            'status'        => 'required',
            'image'         => "array",
            'image.*'       => "image|mimes:jpeg,jpg,png,gif",
        ]; 
        
        $rules['image']   .= ($this->isMethod('patch') && $this->has('hidden_image')) ? '|nullable' : '|required';
        $rules['image.*'] .= ($this->isMethod('patch') && $this->has('hidden_image')) ? '|nullable' : '|required';

        return $rules;
    }

    public function messages(): array
    {
        return [
            // 'image.required' => 'The banner image field is required',
        ];
    }
}
