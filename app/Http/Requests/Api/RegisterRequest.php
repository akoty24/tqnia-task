<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        'name' => 'required|string',
        'mobile_number' => 'required|unique:users|numeric',
        'password' => 'required|min:6',
        'password_confirmation' => 'required|same:password',
        
        ];
    }
}
