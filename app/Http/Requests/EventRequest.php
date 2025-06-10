<?php

namespace App\Http\Requests;

use App\Enums\Priorities;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class EventRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:400'],
            'description' => ['nullable', 'string', 'max:1000'],
            'startDate' => ['required', 'date'],
            'startsAt' => ['required', 'date'],
            'endsAt' => ['required', 'date'],
            'attendances' => ['required', 'array'],
            'attendances.*' => ['required', 'exists:users,account_code'],
            'priority' => ['required', new Enum(Priorities::class)],
        ];
    }
}