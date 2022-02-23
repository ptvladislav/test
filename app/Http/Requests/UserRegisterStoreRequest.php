<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterStoreRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'nickname' => 'required|min:6|max:32|regex:/^[a-zA-Z]+$/u|unique:users',
            'password' => 'required|confirmed|min:8'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
       return redirect()->back()->withErrors($validator->errors());
    }
}
