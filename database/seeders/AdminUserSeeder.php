<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        AdminUser::create([
            'name' => 'Super Admin',
            'email' => 'admin@legianmedical.com',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        AdminUser::create([
            'name' => 'Admin Staff',
            'email' => 'staff@legianmedical.com',
            'username' => 'staff',
            'password' => Hash::make('staff123'),
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}

