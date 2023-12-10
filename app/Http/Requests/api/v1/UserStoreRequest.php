<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'identification_card' => 'required|max:10|min:4|string|alpha_num:ascii',
            'name' => 'required|max:20|min:4|string|ascii', #|alpha:asc
            'lastname' => 'required|max:20|min:4|string|ascii',
            'phone' => 'required|max:10|min:10|string|alpha_num:ascii',
            'email' => 'required|max:255|min:8|string|ascii',
            'age' => 'required|digits:2,3',
            'gender' => 'required|max:10|min:1|string|ascii',
            'password' => 'required|string|min:8|max:255',
            'type' => 'required|in:cliente,admin'
        ];
    }

    public function messages(): array
    {
        return [
            'identification_card.required' => 'El campo cedula es requerido',
            'identification_card.min' => 'El campo cedula debe tener una longitud minima de 4 dígitos',
            'identification_card.max' => 'El campo cedula debe tener una longitud maxima de 10 dígitos',

            'name.required' => 'El campo nombre es requerido',
            'name.min' => 'El campo nombre debe tener una longitud minima de 4 dígitos',
            'name.max' => 'El campo nombre debe tener una longitud maxima de 20 dígitos',

            'lastname.required' => 'El campo apellido es requerido',
            'lastname.min' => 'El campo apellido debe tener una longitud minima de 4 dígitos',
            'lastname.max' => 'El campo apellido debe tener una longitud maxima de 20 dígitos',

            'email.required' => 'El campo email es requerido',
            'email.unique' => 'El email ingresado ya existe',
            'email.min' => 'El campo email debe tener una longitud minima de 8 dígitos',

            'phone.required' => 'El campo teléfono es requerido',
            'phone.min' => 'El campo teléfono debe tener una longitud de 10 dígitos',
            'phone.max' => 'El campo teléfono debe tener una longitud de 10 dígitos',

            'age.required' => 'El campo edad es requerido',
            'age.digits' => 'El campo edad debe tener una longitud minima de 2, y maxima de 3 dígitos',

            'gender.required' => 'El campo genero es requerido',
            'gender.max' => 'El campo genero debe tener una longitud maxima de 10 dígitos, si su caso es "No binario" ',
            'gender.min' => 'El campo genero debe tener una longitud minima de 1 dígito, si su caso es "F" o "M" ',

            'password.required' => 'El campo contraseña es requerido',
            'password.min' => 'El campo contraseña debe tener una longitud maxima de 8 dígitos',

            'type.required' => 'El campo tipo de usuario es requerido',
        ];
    }
}
