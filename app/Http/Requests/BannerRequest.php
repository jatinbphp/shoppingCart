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
            'image'         => 'image|mimes:jpeg,jpg,png,gif',
            'status'        => 'required',
        ]; 
        
        $rules['image'] .= ($this->isMethod('patch') && $this->has('hidden_image')) ? '|nullable' : '|required';

        return $rules;
    }
}
