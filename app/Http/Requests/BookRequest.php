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
            'gender' => ['required', 'max:10'], 
            'category' => ['required', 'max:10'],
            'id_library' => ['required', 'exists:libraries,id_library'],
        ];
    }
}
