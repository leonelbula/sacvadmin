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
            'department' => 'required',
            'city' => 'required|',
            'state'=>'boolean'
        ];
    }
}
