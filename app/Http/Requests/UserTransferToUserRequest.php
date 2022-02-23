<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class UserTransferToUserRequest extends FormRequest
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
            'transferUser' => 'required',
            'amount' => 'required|between:0,99.99'
        ];
    }

    public function getCredentials()
    {
        $user = $this->get('transferUser');

        if ($this->isUser($user)){
            return $this->isUser($user);
        }
        return false;
    }

    private function isUser($item)
    {
        $factory = $this->container->make(ValidationFactory::class);

        $isNickName = $factory->make(
            ['username' => $item],
            ['username' => 'email']
        )->fails();

        $user = false;
        if ($isNickName){
            $user = User::where('nickname', $item)->first();
        }else{
            $user = User::where('email', $item)->first();
        }
        return $user;
    }

    protected function failedValidation(Validator $validator)
    {
        return redirect()->back()->withErrors($validator->errors());
    }
}
