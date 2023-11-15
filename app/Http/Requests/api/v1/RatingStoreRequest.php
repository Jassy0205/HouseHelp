<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class RatingStoreRequest extends FormRequest
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
            'star' => 'required|digits:1',
            'comment' => 'required|max:300|ascii',
        ];
    }

    public function messages(): array
    {
        return [
            'comment.required' => 'El campo comentario es requerido',
            'comment.max' => 'El campo comentario debe tener una longitud maxima de 300 dígitos',

            'star.required' => 'El campo estrella es requerido',
            'star.digits' => 'El campo estrella debe tener una longitud de 1 dígito',
        ];
    }
}
