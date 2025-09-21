<?php

namespace App\Http\Requests;

use App\Enums\LeaveTypes;
use App\Enums\Priorities;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class EmployeeLeaveFormRequest extends FormRequest
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
            'title' => ['required'],
            'type' => ['required', new Enum(LeaveTypes::class)],
            'startDate' => ['required', 'date'],
            'endDate' => [
                'required_if:type,' . strtolower(LeaveTypes::ON_VACATION->value),
                'required_if:type,' . strtolower(LeaveTypes::URGENT_SITUATION->value)
            ],
            'priority' => [
                'required_if:type,' . strtolower(LeaveTypes::URGENT_SITUATION->value),
                new Enum(Priorities::class)
            ],
            'reason' => ['required', 'max:500'],
            'note' => ['nullable', 'max:300'],
        ];
    }
}