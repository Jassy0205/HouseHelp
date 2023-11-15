<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class LocationStoreRequest extends FormRequest
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
            'city' => 'required|max:20|min:4|string|ascii', #|alpha:asc
            'department' => 'required|max:20|min:4|string|ascii',
            'address' => 'required|max:15|string|ascii',
            'neighborhood' => 'required|max:15|string|ascii',
            'specifications' => 'max:20|string|ascii',
        ];
    }

    public function messages(): array
    {
        return [
            'city.required' => 'El campo ciudad es requerido',
            'city.min' => 'El campo ciudad debe tener una longitud minima de 4 dígitos',
            'city.max' => 'El campo ciudad debe tener una longitud maxima de 20 dígitos',

            'department.required' => 'El campo departamento es requerido',
            'department.min' => 'El campo departamento debe tener una longitud minima de 4 dígitos',
            'department.max' => 'El campo departamento debe tener una longitud maxima de 20 dígitos',

            'address.required' => 'El campo dirección es requerido',
            'address.max' => 'El campo dirección debe tener una longitud maxima de 15 dígitos',

            'neighborhood.required' => 'El campo barrio es requerido',
            'neighborhood.max' => 'El campo barrio debe tener una longitud maxima de 15 dígitos',

            'specifications.max' => 'El campo especificaciones debe tener una longitud maxima de 20 dígitos',
        ];
    }
}
