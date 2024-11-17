<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdatePostRequest extends FormRequest
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
            'content' => ['required', 'string'],
            'image' => [
                'nullable',
                File::image()->max(2 * 1024),
                'mimetypes:image/jpeg,image/png,image/jpg',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'image' => [
                'max' => 'Post image must not be greater than 2 mb.',
            ],
        ];
    }
}
