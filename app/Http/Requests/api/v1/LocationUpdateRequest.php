<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class LocationUpdateRequest extends FormRequest
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
            'city' => 'max:20|min:4|string|ascii', #|alpha:asc
            'department' => 'max:20|min:4|string|ascii',
            'address' => 'max:15|string|ascii',
            'neighborhood' => 'max:15|string|ascii',
            'specifications' => 'max:20|string|ascii',
        ];
    }

    public function messages(): array
    {
        return [
            'city.min' => 'El campo ciudad debe tener una longitud minima de 4 dígitos',
            'city.max' => 'El campo ciudad debe tener una longitud maxima de 20 dígitos',

            'department.min' => 'El campo departamento debe tener una longitud minima de 4 dígitos',
            'department.max' => 'El campo departamento debe tener una longitud maxima de 20 dígitos',

            'address.max' => 'El campo dirección debe tener una longitud maxima de 15 dígitos',

            'neighborhood.max' => 'El campo barrio debe tener una longitud maxima de 15 dígitos',

            'specifications.max' => 'El campo especificaciones debe tener una longitud maxima de 20 dígitos',
        ];
    }
}
