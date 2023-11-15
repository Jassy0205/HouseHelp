<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
            'name' => 'max:45|min:4|string|ascii',
            'owner' => 'max:40|min:8|string|ascii',
            'phone' => 'digits:10',
            'email' => 'max:255|min:8|unique:suppliers,email|string|ascii',
            'description' => 'max:300',
            'password' => 'string|min:8|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => 'El campo nombre debe tener una longitud minima de 4 dígitos',
            'name.max' => 'El campo nombre debe tener una longitud maxima de 20 dígitos',

            'owner.min' => 'El campo propietario debe tener una longitud minima de 8 dígitos',
            'owner.max' => 'El campo propietario debe tener una longitud maxima de 40 dígitos',
            
            'phone.digits' => 'El campo teléfono debe tener una longitud de 10 dígitos',

            'email.min' => 'El campo email debe tener una longitud minima de 8 dígitos',

            'description.max' => 'El campo descripción debe tener una longitud maxima de 300 dígitos',

            'password.min' => 'El campo especificaciones debe tener una longitud minima de 8 dígitos',
        ];
    }
}
