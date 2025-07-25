<?php

namespace App\Http\Requests;

use App\Enums\JobTitles;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
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
        $user = $this->route('user');
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'password' => ['sometimes', 'confirmed', Password::defaults()],
            'phoneNumber' => ['required', 'numeric'],
            'jobTitle' => ['nullable', new Enum(JobTitles::class)],
            'address' => ['nullable'],
            'profilePhotoUrl' => ['nullable', 'file'],
            'salary' => ['required', 'numeric'],
        ];
    }
}