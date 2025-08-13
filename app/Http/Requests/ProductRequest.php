<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:150',
            'cost' => 'required',
            'price' => 'required',
            'utility' => 'required',
            'minimum_amount' => 'required',
            'amount' => 'required',
            'category_id' => 'required',
            'tax_value' =>'required',
            'state'=> 'required',
            'taxes_id' =>'required',
            'product_type_id'=>'required'
        ];
    }
}
