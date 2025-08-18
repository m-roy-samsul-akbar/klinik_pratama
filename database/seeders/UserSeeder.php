<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $dokterRole = Role::where('name', 'dokter')->first();

        if (!$adminRole || !$dokterRole) {
            throw new \Exception('Role admin atau dokter tidak ditemukan di tabel roles');
        }

        // Buat user admin
        User::firstOrCreate(
            ['email' => 'admin@klinik.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@klinik.com',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );

        // Buat user dokter
        User::firstOrCreate(
            ['email' => 'dokter@klinik.com'],
            [
                'name' => 'Dr. Ahmad Pratama',
                'email' => 'dokter@klinik.com',
                'password' => Hash::make('dokter123'),
                'role_id' => $dokterRole->id,
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );
    }
}