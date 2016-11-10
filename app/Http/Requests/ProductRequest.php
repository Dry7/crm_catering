<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'source'      => 'in:file,hand',
            'section1'    => 'integer',
            'section2'    => 'integer',
            'section3'    => 'integer',
            'section4'    => 'integer',
            'kitchen_id'  => 'integer',
            'type_id'     => 'integer',
            'name'        => 'required|string|max:255',
            'name_ут'     => 'string|max:255',
            'weight'      => 'required|integer|min:0',
            'price'       => 'numeric',
            'photography' => 'image'
        ];
    }
}
