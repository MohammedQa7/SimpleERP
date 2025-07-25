<?php

namespace App\Http\Requests;

use App\Enums\JobTitles;
use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class EmployeeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Password::defaults()],
            'phoneNumber' => ['required', 'numeric'],
            'jobTitle' => ['nullable', new Enum(JobTitles::class)],
            'department' => ['required', 'string'],
            'address' => ['nullable'],
            'avatar' => ['file', 'nullable'],
            'salary' => ['required', 'numeric'],
        ];
    }
}