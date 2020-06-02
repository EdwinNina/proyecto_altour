<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:1000'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre de la categoria es requerido',
            'image.required' => 'Imagen de la categoria es requerido',
            'image.image' => 'El archivo debe ser una imagen',
            'image.mimes' => 'La imagen debe ser jpg, jpeg y png',
            'image.max' => 'La imagen debe pesar menos de un 1 mega',
        ];
    }
}
