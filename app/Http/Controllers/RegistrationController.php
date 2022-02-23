<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function store(UserRegisterStoreRequest $request)
    {
        $request->validated();
        $user = $this->create($request);
        Auth::login($user);
        return redirect()->route('user.info');
    }

    protected function create($data){
        return User::create([
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
