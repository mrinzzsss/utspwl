<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::truncate();

        User::insert([
            [
                'name'       => 'Admin',
                'email'      => 'admin@mpl.com',
                'role'       => 'admin',
                'password'   => Hash::make('admin'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Manajemen',
                'email'      => 'manajemen@mpl.com',
                'role'       => 'manajemen',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Wasit',
                'email'      => 'wasit@mpl.com',
                'role'       => 'wasit',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('✅ Users seeded: admin@mpl.com / manajemen@mpl.com / wasit@mpl.com (password: password)');
    }
}
