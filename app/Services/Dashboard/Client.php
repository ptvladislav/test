<?php

namespace App\Services\Dashboard;
use App\Contracts\Finance\FinanceSystem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Transfer;
class Client implements FinanceSystem
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function showNicknameUser(){
        return $this->user->nickname;
    }

    public function showEmailUser(){
        $email = $this->user->email;

        $emailExplode   = explode("@",$email);
        $name = implode('@', array_slice($emailExplode, 0, count($emailExplode)-1));
        $length  = strlen($name);

        $hideEmail = substr($name,0, 1).str_repeat('*', $length - 2).$name{strlen($name)-1}."@".end($emailExplode);
        return $hideEmail;
    }

    public function showBalanceUser()
    {
        return $this->user->balance;
    }

    public function getUser(){
        return $this->user;
    }

    public function deposit($amount, $user = null){
        $this->plusBalance($amount, $user);
        $trn = new Transfer();
        $trn['amount'] = str_replace(',','.',$amount);;
        $trn['from_user_id'] = ($user != null ? $user['id'] : $this->user->id);
        $trn['to_user_id'] = ($user != null ? $user['id'] : $this->user->id);
        $trn['type'] = Transfer::STATUS_DEPOSIT;
        $trn->save();

        return ['type' => 'successPayment', 'message' => 'Your balance has been payment $'.$amount];

    }

    public function transfer($userId, $amount){
        if ($this->user['balance'] >= $amount && $userId != null && $userId != $this->user->id){
            $this->minusBalanceUser($amount);

            $trn = new Transfer();
            $trn['amount'] = str_replace(',','.',$amount);
            $trn['from_user_id'] = $this->user->id;
            $trn['to_user_id'] = $userId;
            $trn['type'] = Transfer::STATUS_WITHDRAW;
            $trn->save();

            return ['type' => 'transfer', 'message' => 'Your transfer transaction has been success'];
        }elseif ($userId == null){
            return ['type' => 'userNotFound', 'message' => 'User not found'];
        }elseif($userId == $this->user->id){
            return ['type' => 'transferError', 'message' => "You don't transfer to your account"];
        }

        return ['type' => 'lowBalance', 'message' => 'Your balance is low. Check your balance'];
    }

    private function plusBalance($amount, $user){

        $user = ($user == null ? $this->user: $user);

        $user['balance'] += str_replace(',','.',$amount);
        $user->save();

    }

    private function minusBalanceUser($amount)
    {
        $user = $this->user;
        $user['balance'] = $user['balance'] - str_replace(',','.',$amount);;
        $user->save();
    }

    public function getAll()
    {
        $clients = User::orderBy('id','desc')->take(5)->get();
        return $clients;
    }
}
