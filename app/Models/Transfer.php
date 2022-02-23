<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    const STATUS_DEPOSIT = 1;
    const STATUS_WITHDRAW = 2;

    protected $fillable = [
        'amount', 'from_user_id', 'to_user_id', 'type'
    ];

    public static function statuses()
    {
        return [
            self::STATUS_DEPOSIT      => 'Deposit',
            self::STATUS_WITHDRAW => 'Withdraw',
        ];
    }

    public function getStatus()
    {
        $statuses = self::statuses();
        return $statuses[$this->type];
    }

    public function transferUser()
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    public function receivedUser()
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }


}
