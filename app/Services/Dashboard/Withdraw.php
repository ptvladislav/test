<?php


namespace App\Services\Dashboard;


use App\Contracts\Finance\FinanceSystem;

class Withdraw
{
    protected $system;

    function __construct(FinanceSystem $system)
    {
        $this->system = $system;
    }

    public function showHistoryTransaction(){
       return $this->system->getUser()->transfers()->orderBy('id', 'DESC')->get();
    }
}
