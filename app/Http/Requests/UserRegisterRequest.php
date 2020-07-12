<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRegisterRequest extends FormRequest
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
          'email' => 'required|email|unique:users',
          'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
          'name.required' => 'El campo nombre es obligatorio',
          'email.required' => 'El campo correo es obligatorio',
          'email.email' => 'El campo correo tiene que ser de tipo correo electronico',
          'email.unique' => 'El campo correo debe ser unico',
          'password.required' => 'El campo contraseña es obligatorio'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 202));
    }
}
