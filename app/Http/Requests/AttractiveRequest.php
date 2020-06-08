<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttractiveRequest extends FormRequest
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
            'category_id' => 'required',
            'name' => 'required|max:100',
            'description' => 'required',
            'image' =>  'required|image|mimes:jpeg,jpg,png|max:1000'
        ];
    }

    public function messages(){
        return [
            'category_id.required' => 'La categoria es requerida',
            'name.required' => 'El nombre del atractivo es requerido',
            'name.max' => 'El nombre no debe tener mas de 100 caracteres',
            'description.required' => 'El campo de descripcion es requerido',
            'image.required' => 'Imagen del atractivo es requerido',
            'image.image' => 'El archivo debe ser una imagen',
            'image.mimes' => 'La imagen debe ser jpg, jpeg y png',
            'image.max' => 'La imagen debe pesar menos de un 1 mega',
        ];
    }
}
