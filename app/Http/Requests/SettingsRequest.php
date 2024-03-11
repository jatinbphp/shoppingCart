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
            'address'       => 'max:500',
            'phone_number'  => '',
            'email_address' => 'email',
            'facebook_url'  => 'nullable|url',
            'twitter_url'   => 'nullable|url',
            'youtube_url'   => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url'  => 'nullable|url', 
            'header_menu'  => 'nullable',
            'footer_menu'  => 'nullable',             
        ];
    }
}
