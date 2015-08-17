<?php


use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    public function run() {
        \App\User::create([
            'name' => 'Fabian Henkel',
            'email' => 'f.henkel@sopamo.de',
            'password' => \Illuminate\Support\Facades\Hash::make('4w3s0m3')
        ]);
    }

}