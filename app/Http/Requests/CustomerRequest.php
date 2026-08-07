<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'full_name' => 'required|string',
            'identification' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required|string',
            'credit_amount' => 'integer',
            'departament_id' => 'required|exists:departaments,id',
            'city_id' => 'required|exists:cities,id',
            'customer_tribute_id' => 'required|exists:customer_tributes,id',
            'identification_document_id' => 'required|exists:identity_documents,id',
            'responsibilities' => 'required',
            'organization_type_id' => 'required|exists:organization_types,id',
            'state' => 'boolean'
        ];
    }

    public function attributes(): array
    {
        return [
            'full_name' => 'nombre completo',
            'identification' => 'identificación',
            'identification_document_id' => 'tipo de documento',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
            'departament_id' => 'departamento',
            'city_id' => 'ciudad',
            'address' => 'dirección',
            'customer_tribute_id' => 'Tipo de Responsabilidad Fiscal',
            'organization_type_id' => 'tipo de organización',
            'credit_amount' => 'cupo de crédito',
            'responsibilities' => 'Responsable de IVA',
            'state' => 'estado',
        ];
    }


    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser un texto.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'email' => 'El campo :attribute debe ser un correo electrónico válido.',
            'max' => 'El campo :attribute no puede tener más de :max caracteres.',
            'min' => 'El campo :attribute debe ser mayor o igual a :min.',
            'exists' => 'El :attribute seleccionado no es válido.',
            'unique' => 'El :attribute ya se encuentra registrado.',
            'boolean' => 'El campo :attribute no es válido.',
        ];
    }
}
