<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class RatingUpdateRequest extends FormRequest
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
            'star' => 'digits:1',
            'comment' => 'max:300',
        ];
    }

    public function messages(): array
    {
        return [
            'comment.max' => 'El campo comentario debe tener una longitud maxima de 300 dígitos',

            'star.digits' => 'El campo estrella debe tener una longitud de 1 dígito',
        ];
    }
}
