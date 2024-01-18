<?php

use Illuminate\Database\Seeder;
use App\Models\User;

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
            'name' => 'Админ',
            'login' => 'admin',
            'role' => 'admin',
            'password' => '1234567',
        ]);
    }
}
