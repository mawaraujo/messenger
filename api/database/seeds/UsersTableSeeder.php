<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@support.com',
            'password' => bcrypt('support')
        ]);

        User::create([
            'name' => 'tester',
            'email' => 'tester@support.com',
            'password' => bcrypt('support')
        ]);

        User::create([
            'name' => 'Milton',
            'email' => 'milton@support.com',
            'password' => bcrypt('support')
        ]);
    }
}
