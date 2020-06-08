<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceRequest extends FormRequest
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
            'address' => 'required|max:100',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' =>  'required|image|mimes:jpeg,jpg,png|max:1000'
        ];
    }

    public function messages(){
        return [
            'category_id.required' => 'La categoria es requerida',
            'name.required' => 'El nombre del atractivo es requerido',
            'name.max' => 'El nombre no debe tener mas de 100 caracteres',
            'description.required' => 'El campo de descripcion es requerido',
            'address.required' => 'El campo de direccion es requerido',
            'address.max' => 'La direccion no debe tener mas de 100 caracteres',
            'latitude.required' => 'El campo de latitud es requerido',
            'longitude.required' => 'El campo de latitude es requerido',
            'image.required' => 'Imagen del atractivo es requerido',
            'image.image' => 'El archivo debe ser una imagen',
            'image.mimes' => 'La imagen debe ser jpg, jpeg y png',
            'image.max' => 'La imagen debe pesar menos de un 1 mega',
        ];
    }
}
