<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@transshipbrokerage.ky',
            'user_type' => 'Admin',
            'user_role' => '1',
            'password' => Hash::make('Admin#000;')
        ]);
    }
}
