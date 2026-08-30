<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => [
                'required',
                'string',
                'max:255',
            ],

            'total' => [
                'required',
                'integer',
                'min:1',
            ],

            'date' => [
                'required',
                'date',
            ],

            'delivered_to' => [
                'required',
                'string',
                'max:255',
            ],

            'hour' => [
                'required',
                'date_format:H:i',
            ],

            'observation' => [
                'nullable',
                'string',
            ],

            'payment_method_id' => [
                'required',
                'integer',
                'exists:payment_methods,id',
            ],

            'type_expense_id' => [
                'required',
                'integer',
                'exists:type_expenses,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' =>
                'La descripción del gasto es obligatoria.',

            'total.required' =>
                'El valor del gasto es obligatorio.',

            'total.integer' =>
                'El valor del gasto debe ser un número entero.',

            'total.min' =>
                'El valor del gasto debe ser mayor que cero.',

            'date.required' =>
                'La fecha del gasto es obligatoria.',

            'date.date' =>
                'La fecha del gasto no es válida.',

            'delivered_to.required' =>
                'El campo entregado a es obligatorio.',

            'hour.required' =>
                'La hora del gasto es obligatoria.',

            'hour.date_format' =>
                'La hora debe tener el formato HH:MM.',

            'payment_method_id.required' =>
                'Debes seleccionar un método de pago.',

            'payment_method_id.exists' =>
                'El método de pago seleccionado no existe.',

            'type_expense_id.required' =>
                'Debes seleccionar un tipo de gasto.',

            'type_expense_id.exists' =>
                'El tipo de gasto seleccionado no existe.',
        ];
    }
}

