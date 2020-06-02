<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
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
            'attractive_id' => 'required',
            'name' => 'required|max:100',
            'description' => 'required',
            'instructor' => 'required|max:100',
            'cost' => 'required|numeric',
            'date_start' => 'required',
            'date_end' => 'required',
        ];
    }

    public function messages(){
        return [
            'attractive_id.required' => 'El campo del atractivo es requerido',
            'name.required' => 'El nombre de la actividad es requerida',
            'name.max' => 'El nombre no debe tener mas de 100 caracteres',
            'description.required' => 'El campo de descripción es requerido',
            'instructor.required' => 'El campo nombre de guía es requerido',
            'instructor.max' => 'La nombre del guía no debe tener mas de 100 caracteres',
            'cost.required' => 'El campo del costo es requerido',
            'cost.numeric' => 'El costo solo no debe incluir letras o simbolos requerido',
            'date_start.required' => 'El campo de fecha de inicio es requerido',
            'date_end.required' => 'El campo de fecha de finalización es requerido',
        ];
    }}
