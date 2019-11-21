<?php

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'developer', 'default_user' => 0, 'login_destination' => '/admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        Role::insert($roles);
    }
}
