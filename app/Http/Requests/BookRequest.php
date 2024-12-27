<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => 'required|max:200', 
            'author' => 'required|max:120', 
            'date_publication' => ['required', 'date'], 
            'gender' => ['required', 'max:100'], 
            'category' => ['required', 'max:100']
        ];
    }

     /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título no puede tener más de 200 caracteres.',
            'author.required' => 'El autor es obligatorio.',
            'author.max' => 'El autor no puede tener más de 120 caracteres.',
            'date_publication.required' => 'La fecha de publicación es obligatoria.',
            'date_publication.date' => 'La fecha de publicación debe ser una fecha válida.',
            'gender.required' => 'El género es obligatorio.',
            'gender.max' => 'El género no puede tener más de 100 caracteres.',
            'category.required' => 'La categoría es obligatoria.',
            'category.max' => 'La categoría no puede tener más de 100 caracteres.',
        ];
    }
}
