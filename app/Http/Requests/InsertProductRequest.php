<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertProductRequest extends FormRequest
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
            'product' => 'required',
            'category' => 'required',
            'stock' => 'required|min:0',
            'shop' => 'required',
            'price' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/'
        ];
    }
}
