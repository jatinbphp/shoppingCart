<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
   
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
        return [
            'address' => 'max:500',
            'phone_number' => 'required',
            'email_address' => 'required|email',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url', 
            'header_menu_categories' => 'required|nullable',
            'footer_menu_categories' => 'required|nullable',
            'breadcrumb_image' => 'mimes:jpeg,jpg,png,bmp|dimensions:min_width=1060,min_height=710',
            'image' => 'mimes:jpeg,jpg,png,bmp|dimensions:min_width=1060,min_height=710',
            'first_title' => 'required',
            'second_title' => 'required',
            'content' => 'required',
        ];

        if ($this->isMethod('patch')) {
            $rules['breadcrumb_image'] = 'mimes:jpeg,jpg,png,bmp|dimensions:min_width=1060,min_height=710';
            $rules['image'] = 'mimes:jpeg,jpg,png,bmp|dimensions:min_width=1060,min_height=710';
        }
    }

    public function messages(): array
    {
        return [
            'breadcrumb_image.dimensions' => 'The :attribute must be exactly 1060 pixels wide and 710 pixels tall.',
            'image.dimensions' => 'The :attribute must be exactly 1060 pixels wide and 710 pixels tall.',
        ];
    }
}
