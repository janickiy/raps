<?php



use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Админ',
            'login' => 'admin',
            'role' => 'admin',
            'password' => '1234567',
        ]);
    }
}
