<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class ContractUpdateRequest extends FormRequest
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
            'price' => 'digits:5,8|decimal:1,3',
            'description' => 'max:500|min:10|string|ascii',
        ];
    }

    public function messages(): array
    {
        return [
            'price.digits' => 'El campo precio debe tener una longitud minima de 5 y maxima de 8 digitos enteros',
            'price.decimal' => 'El campo precio debe tener una longitud minima de 1 y maxima de 3 decimales',

            'description.min' => 'El campo descripción debe tener una longitud minima de 10 dígitos',
            'description.max' => 'El campo descripción debe tener una longitud maxima de 500 dígitos',
        ];
    }
}
