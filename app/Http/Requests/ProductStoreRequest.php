<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name' => 'required|string',
          'description' => 'required|string',
          'category' => 'nullable',
          'quantity' => 'nullable|integer',
          'date_available' => 'required|date',
          'price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
          'user_id' => 'nullable',
          'path' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
          'name.required' => 'El campo nombre es obligatorio',
          'name.string' => 'El campo nombre tiene formato incorrecto',
          'description.required' => 'El campo descripcion es obligatorio',
          'description.string' => 'El campo descripcion tiene formato incorrecto',
          'date_available.required' => 'El fecha es obligatorio',
          'date_available.date' => 'El campo fecha tiene formato incorrecto',
          'quantity.integer' => 'El campo cantidad tiene formato incorrecto',
          'price.regex' => 'El campo precio tiene formato incorrecto'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 202));
    }
}
