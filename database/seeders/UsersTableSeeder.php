<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::create([
            'name' => 'kushal', 
            'email' => 'kushaljindal92@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
