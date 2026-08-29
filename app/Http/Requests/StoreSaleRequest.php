<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreSaleRequest extends FormRequest
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
            // Validaciones de la cabecera (Sale)
            'customer_id'       => ['required', 'integer', 'exists:customers,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            'date_sale'         => ['required', 'date_format:Y-m-d'],
            'payment_form'      => ['required', 'string', Rule::in(['counted', 'credit'])],
            'plazo'             => ['required_if:payment_form,credit', 'nullable', 'integer', 'min:1'],
            'observation'       => ['nullable', 'string', 'max:500'],
            'total'             => ['required', 'numeric', 'min:0'],
            'subtotal'          => ['required', 'numeric', 'min:0'],
            'taxes'             => ['required', 'numeric', 'min:0'],

            // Validaciones en cascada del carrito de compras (DetailSale)
            'products'          => ['required', 'array', 'min:1'],
            'products.*.id'     => ['required', 'integer', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'products.*.price'  => ['required', 'numeric', 'min:0'],
            'products.*.cost'   => ['required', 'numeric', 'min:0'],
            'products.*.tax'    => ['required', 'numeric', 'min:0'], // El porcentaje (ej: 11)
        ];
    }
     public function messages(): array
    {
        return [
            'customer_id.exists'         => 'El cliente seleccionado no es válido.',
            'payment_form.in'            => 'La forma de pago debe ser "counted" (contado) o "credit" (crédito).',
            'plazo.required_if'          => 'El plazo en días es obligatorio cuando la venta es a crédito.',
            'products.required'          => 'Debe añadir al menos un producto a la venta.',
            'products.*.id.exists'       => 'Uno de los productos seleccionados no existe en el sistema.',
            'products.*.quantity.min'    => 'La cantidad de cada producto debe ser mínimo 1.',
            'products.*.price.min'       => 'El precio de venta no puede ser negativo.',
        ];
    }
}
