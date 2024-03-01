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
            'address'       => 'required|max:500',
            'phone_number'  => 'required|min:10|max:10|regex:/[0-9]{9}/',
            'email_address' => 'required|email',
            'facebook_url'  => 'required|max:100|url',
            'twitter_url'   => 'required|max:100|url',
            'youtube_url'   => 'required|max:100|url',
            'instagram_url' => 'required|max:100|url',
            'linkedin_url'  => 'required|max:100|url',            
        ];
    }
}
