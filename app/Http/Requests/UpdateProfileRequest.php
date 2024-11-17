<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'username' => ['required', 'string', 'max:30',
                Rule::unique(User::class, 'username')->ignore($this->user()->id)],
            'password' => ['nullable', 'confirmed', Password::min(6)],
            'bio' => ['required', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation()
    {
        // Removes the password field if not provided
        if (! $this->filled('password')) {
            $this->request->remove('password');
        }
    }
}
