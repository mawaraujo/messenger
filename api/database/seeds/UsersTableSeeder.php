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
            'chat_status' => 'En casa',
            'email' => 'admin@support.com',
            'password' => bcrypt('support')
        ]);

        User::create([
            'name' => 'tester',
            'chat_status' => 'Trabajando',
            'email' => 'tester@support.com',
            'password' => bcrypt('support')
        ]);

        User::create([
            'name' => 'Milton',
            'chat_status' => 'Jugando videosjuegos',
            'email' => 'milton@support.com',
            'password' => bcrypt('support')
        ]);
    }
}
