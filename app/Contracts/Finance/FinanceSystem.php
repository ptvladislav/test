<?php

namespace App\Contracts\Finance;

interface FinanceSystem{
     public function showNicknameUser();
     public function showEmailUser();
     public function showBalanceUser();
     public function getUser();
}
