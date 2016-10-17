<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'user_id' => 'required|integer|min:1',
            'status_id' => 'required|integer|min:1',
            'client_id' => 'required|integer|min:1',
            'date' => 'required|date',
            'format_id' => 'required|integer|min:1',
            'persons' => 'integer',
            'tables' => 'integer',
            'place_id' => 'integer',
            'staff' => 'integer',
            'meeting' => 'date_format:H:i',
            'main' => 'date_format:H:i',
            'hot_snacks' => 'date_format:H:i',
            'sorbet' => 'date_format:H:i',
            'hot' => 'date_format:H:i',
            'dessert' => 'date_format:H:i'
        ];
    }
}
