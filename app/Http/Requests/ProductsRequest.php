<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            'nombre'=>'required|max:500',
            'codigo'='required',
            'existencia'=>'required',
            'costo'=>'required',
            'precio_Venta'=>'required',
            'bussine_id'=>'required',
            'category_id'=>'required',
            'iva'=>'required',
            'clave_unidad'=>'required',
            'clave_producto'=>'required'
        ];
    }
}
