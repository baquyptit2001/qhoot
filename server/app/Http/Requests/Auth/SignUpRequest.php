<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|bail|required|string|email|max:255|unique:users',
            'password' => 'sometimes|bail|required|string|min:8|confirmed',
            'phone' => 'sometimes|bail|nullable|string|max:255',
            'address' => 'sometimes|bail|nullable|string|max:255',
        ];
    }
}
