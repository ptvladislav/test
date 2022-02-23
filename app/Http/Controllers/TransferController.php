<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDepositRequest;
use App\Http\Requests\UserTransferToUserRequest;
use App\Services\Dashboard\Client;
use Illuminate\Support\Facades\App;

class TransferController extends Controller
{
    public function transfer(UserTransferToUserRequest $request)
    {
        $request->validated();
        $recipientUser = $request->getCredentials();

        $newTransfer = App::make(Client::class)->transfer($recipientUser['id'], $request['amount']);
        return redirect()->back()->with($newTransfer['type'], $newTransfer['message']);

    }

    public function deposit(UserDepositRequest $request)
    {
        $request->validated();
        $request->getCredentials();

        $deposit = App::make(Client::class)->deposit($request['amountDep']);
        return redirect()->back()->with($deposit['type'], $deposit['message']);
    }
}
