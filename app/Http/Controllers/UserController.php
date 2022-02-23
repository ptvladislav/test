<?php

namespace App\Http\Controllers;

use App\Contracts\Finance\FinanceSystem;
use App\Services\Dashboard\Client;
use App\Services\Dashboard\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function info(FinanceSystem $user)
    {
        $nickname = $user->showNicknameUser();
        $email = $user->showEmailUser();
        $balance = $user->showBalanceUser();
        $withdrawHistory = App::make(Withdraw::class)->showHistoryTransaction();
        $allUsers = App::make(Client::class)->getAll();

        return view('home', [
            'nickname' => $nickname,
            'email' => $email,
            'balance' => $balance,
            'withdraws' => $withdrawHistory,
            'allUsers' => $allUsers,
            ]);
    }
}
