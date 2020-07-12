<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProductImageRequest extends FormRequest
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
          'image.*' => 'required|mimes:jpeg,gif,png,jpg',
          'product_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
          'image.required' => 'El campo imagen es obligatorio',
          'image.mimes' => 'El campo imagen tiene que ser de tipo imagen',
          'product_id.required' => 'El campo producto es obligatorio',
          'product_id.integer' => 'El campo producto tiene formato incorrecto'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 202));
    }
}
