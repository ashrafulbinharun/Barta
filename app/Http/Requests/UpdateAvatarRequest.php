<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateAvatarRequest extends FormRequest
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
        return [
            'avatar' => [
                'required',
                File::image()->max(1024),
                'mimetypes:image/jpeg,image/png,image/jpg',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'avatar' => [
                'max' => 'Profile avatar must not be greater than 1 mb',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'avatar' => 'profile avatar',
        ];
    }
}