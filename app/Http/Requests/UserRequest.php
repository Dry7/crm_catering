<?php

namespace App\Http\Requests;

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
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:users,username,' . $this->id . '|max:255',
            'password' => 'required|max:255',
            'job' => 'required|in:admin,manager,cook',
            'surname' => 'string|max:255',
            'name' => 'string|max:255',
            'patronymic' => 'string|max:255',
            'email' => 'email',
            'active' => 'boolean',
            'work_hours' => 'boolean',
        ];
    }
}
