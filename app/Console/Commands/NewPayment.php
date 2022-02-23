<?php

namespace App\Console\Commands;


use App\Models\User;
use App\Services\Dashboard\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class NewPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new-payment {username} {amount}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $username = $this->argument('username');
        $amount = $this->argument('amount');

        $data = array(
            'nickname' => $username,
            'amount'  => $amount
        );

        $rules = array(
            'nickname' => 'required|min:6|max:32|regex:/^[a-zA-Z]+$/u',
            'amount'  => 'required|integer',
        );

        $validator = \Validator::make($data, $rules);

        if ($validator->fails()) {
            $messages = $validator->messages();
            $this->error('ERROR ->'.$messages);
            return;
        }

        $findUser = User::where('nickname', $username)->first();
        if ($findUser){
            App::make(Client::class)->deposit($amount, $findUser);
            $this->info('Deposit Successful');
        }else{
            $this->info('User not Found');
        }
    }
}
