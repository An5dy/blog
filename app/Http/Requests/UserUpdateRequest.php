<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'username' => 'bail|string|max:255',
            'new_password' => 'bail|string|min:6|max:255|different:old_password|confirmed',
            'old_password' => 'bail|required|string|min:6|max:255',
        ];
    }
}
