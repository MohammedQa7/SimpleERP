<?php

namespace App\Http\Requests;

use App\Enums\InvoiceStatus;
use App\Enums\PaymentMethods;
use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PaymentTransactionRequest extends FormRequest
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
            'invoiceNumber' => [
                'required',
                'exists:invoices,invoice_number',
                function ($attribute, $value, $fail) {
                    $invoice = Invoice::where('invoice_number', $value)->firstOrFail();
                    if ($invoice->status->value !== InvoiceStatus::PENDING->value) {
                        $fail('The selected invoice number is already paid or not valid for payment.');
                    }
                }
            ],
            'attachments' => ['required', 'array'],
            'attachments.*' => ['required'],
            'notes' => ['nullable', 'max:1000'],
            'paymentMethod' => ['required', new Enum(PaymentMethods::class)],
        ];
    }
}