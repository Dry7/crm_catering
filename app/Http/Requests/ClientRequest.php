<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'user_id' => 'integer',
            'name' => 'required|string|max:255',
            'phone_work' => 'required|string|max:255',
            'phone_mobile' => 'string|max:255',
            'fio' => 'required|string|max:255',
            'job' => 'required|string|max:255',
            'birthday' => 'date',
            'email' => 'required|email',
            'events' => 'string',
            'site' => 'string|max:255',
            'address' => 'string',
            'description' => 'string',
            'hobby' => 'string'
        ];
    }
}
