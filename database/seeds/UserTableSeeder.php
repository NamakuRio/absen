<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'username' => 'coffeedev',
            'name' => 'Coffee Developer',
            'email' => 'coffeedev@coffedev.com',
            'password' => bcrypt('coffeedev'),
            'phone' => '628990125338',
        ];

        $create_user = User::create($user);
        $create_user->assignRole('developer');

    }
}
