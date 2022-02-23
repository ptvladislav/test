<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function store(UserLoginStoreRequest $request)
    {
        $cred = $request->getCredentials();

        if(!Auth::validate($cred)){
            return redirect()->route('login')
                ->withErrors(trans('auth.failed'));
        }

        $user = Auth::getProvider()->retrieveByCredentials($cred);

        Auth::login($user);

        return redirect()->route('user.info');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
