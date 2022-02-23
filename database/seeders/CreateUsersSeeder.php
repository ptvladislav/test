<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = [
            'admin',
            'Attractive',
            'Autoerotic',
            'Appealing',
            'Pointless',
            'Considerable',
            'Compelling'
        ];

        foreach ($name as $item){
            $user = new User();
            $user['nickname'] = $item;
            $user['email'] = $item."@mail.com";
            $user['password'] = Hash::make('12345678');
            $user['balance'] = rand(100, 1500);
            $user->save();
        }
    }
}
