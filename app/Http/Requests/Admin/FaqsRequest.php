<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['nullable', 'integer', 'exists:faqs,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'lang' => ['required', 'string', 'size:2'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El título es obligatorio',
            'title.min' => 'El mínimo de caracteres permitidos para el título son 3',
            'title.max' => 'El máximo de caracteres permitidos para el título son 64',
            'title.regex' => 'Sólo se aceptan letras para el título',
            'description.required' => 'La descripción es obligatoria',
            'description.max' => 'El máximo de caracteres permitidos para la descripción son 255',
            'lang.required' => 'El idioma es obligatorio',
            'lang.size' => 'El idioma debe tener 2 o más caracteres',
            'lang.oversize' => 'El idioma debe tener menos de 10 caracteres',
        ];
    }
}