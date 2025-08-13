<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'identification_card' => 'required',
            'address' => 'required|string',
            'Departament' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email',
            'description'=>'string',
            'credit_amount' => 'string',
        ];
    }
}
