<?php

namespace App\Http\Requests;

use App\Enums\Departments;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class SlackNotificationRequest extends FormRequest
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
            'assignedDepartmentChannels' => ['required', 'array', 'min:1'],
            'assignedDepartmentChannels.*.channelId' => ['required'],
            'assignedDepartmentChannels.*.channelName' => ['required'],
            'assignedDepartmentChannels.*.department' => ['required', new Enum(Departments::class)],
        ];
    }

    function messages()
    {
        return [
            'assignedDepartmentChannels' => 'You have to at least assign one department to one channel',
            'assignedDepartmentChannels.*.channelId' => 'Please add at least one product',
            'assignedDepartmentChannels.*.channelName' => 'The provided sku is invalid',
            'assignedDepartmentChannels.*.department' => 'Quantity field is required',
        ];
    }
}