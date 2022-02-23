<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class UserDepositRequest extends FormRequest
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
            'amountDep' => 'required|between:0,99.99'
        ];
    }

    public function getCredentials()
    {
        if (Auth::user()){
            return Auth::user();
        }
        return false;
    }

    protected function failedValidation(Validator $validator)
    {
        return redirect()->back()->withErrors($validator->errors());
    }
}
