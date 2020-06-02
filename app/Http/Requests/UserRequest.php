<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,'. Auth::id(),
            'password' => 'required',
            'role_id' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El campo de nombre de usuario es requerido',
            'email.required' => 'El campo de correo electronico es requerido',
            'email.email' => 'El correo electronico debe ser un correo valido',
            'email.required' => 'El correo electronico debe ser unico',
            'password.required' => 'El campo contraseña es requerido',
            'role_id.required' => 'El rol del usuario es requerido'
        ];
    }
}
