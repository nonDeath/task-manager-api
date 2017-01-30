<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'first_name' => 'User',
                'last_name' => 'Test',
                'email' => 'test@test.com',
                'password' => app('hash')->make('secret')
            ]
        );
    }
}
