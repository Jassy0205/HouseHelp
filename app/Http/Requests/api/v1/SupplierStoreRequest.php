<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class SupplierStoreRequest extends FormRequest
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
            'name' => 'required|max:45|min:4|string|ascii',
            'owner' => 'required|max:40|min:8|string|ascii',
            'phone' => 'required|max:10|min:10|string|alpha_num:ascii',
            'email' => 'required|max:255|min:8|unique:suppliers,email|string|ascii',
            'description' => 'required|max:300|ascii',
            'password' => 'required|string|min:8|max:255|ascii'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es requerido',
            'name.min' => 'El campo nombre debe tener una longitud minima de 4 dígitos',
            'name.max' => 'El campo nombre debe tener una longitud maxima de 20 dígitos',

            'owner.required' => 'El campo propietario es requerido',
            'owner.min' => 'El campo propietario debe tener una longitud minima de 8 dígitos',
            'owner.max' => 'El campo propietario debe tener una longitud maxima de 40 dígitos',
            
            'phone.required' => 'El campo teléfono es requerido',
            'phone.min' => 'El campo teléfono debe tener una longitud de 10 dígitos',
            'phone.max' => 'El campo teléfono debe tener una longitud de 10 dígitos',

            'email.required' => 'El campo email es requerido',
            'email.unique' => 'El email ingresado ya existe',
            'email.min' => 'El campo email debe tener una longitud minima de 8 dígitos',

            'description.required' => 'El campo descripción es requerido',
            'description.max' => 'El campo descripción debe tener una longitud maxima de 300 dígitos',

            'password.required' => 'El campo contraseña es requerido',
            'password.min' => 'El campo especificaciones debe tener una longitud minima de 8 dígitos',
        ];
    }
}
