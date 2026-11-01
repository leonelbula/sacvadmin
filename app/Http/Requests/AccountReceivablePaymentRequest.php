<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountReceivablePaymentRequest extends FormRequest
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
            'amount' => [
                'required',
                'numeric',
                'integer',
            ],
            'payment_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'payment_method' => [
                'required',
                'in:Efectivo,Transferencia,Tarjeta débito,Tarjeta crédito,Otro',
            ],
            'reference' => [
                'nullable',
                'string',
                'max:100',
            ],
            'observation' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }
}
