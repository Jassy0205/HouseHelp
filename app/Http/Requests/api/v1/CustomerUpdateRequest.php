<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'identification_card' => 'max:10|min:4|string|alpha_num:ascii',
            'name' => 'max:20|min:4|string|ascii', #|alpha:asc
            'lastname' => 'max:20|min:4|string|ascii',
            'phone' => '|max:10|min:10|string|alpha_num:ascii',
            'email' => 'max:255|min:8|unique:customers,email|string|ascii',
            'age' => 'digits:2,3',
            'gender' => 'max:10|min:1|string|ascii',
            'password' => 'string|min:8|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'identification_card.min' => 'El campo cedula debe tener una longitud minima de 4 dígitos',
            'identification_card.max' => 'El campo cedula debe tener una longitud maxima de 10 dígitos',
            
            'name.min' => 'El campo nombre debe tener una longitud minima de 4 dígitos',
            'name.max' => 'El campo nombre debe tener una longitud maxima de 20 dígitos',

            'lastname.min' => 'El campo apellido debe tener una longitud minima de 4 dígitos',
            'lastname.max' => 'El campo apellido debe tener una longitud maxima de 20 dígitos',

            'phone.min' => 'El campo teléfono debe tener una longitud de 10 dígitos',
            'phone.max' => 'El campo teléfono debe tener una longitud de 10 dígitos',

            'email.min' => 'El campo email debe tener una longitud minima de 8 dígitos',
            'age.digits' => 'El campo edad debe tener una longitud minima de 2, y maxima de 3 dígitos',

            'gender.max' => 'El campo genero debe tener una longitud maxima de 10 dígitos, si su caso es "No binario" ',
            'gender.min' => 'El campo genero debe tener una longitud minima de 1 dígito, si su caso es "F" o "M" ',

            'password.min' => 'El campo especificaciones debe tener una longitud maxima de 8 dígitos',
        ];
    }
}
