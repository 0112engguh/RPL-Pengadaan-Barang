<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@sipbarang.local',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        User::create([
            'name' => 'Staff Unit Kerja',
            'email' => 'staff@sipbarang.local',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'unit_kerja' => 'IT Support',
        ]);

        User::create([
            'name' => 'Approver / Manajer',
            'email' => 'approver@sipbarang.local',
            'password' => Hash::make('password'),
            'role' => 'approver',
        ]);

        User::create([
            'name' => 'Staff Pengadaan',
            'email' => 'procurement@sipbarang.local',
            'password' => Hash::make('password'),
            'role' => 'procurement',
        ]);

        $vendor = Vendor::create([
            'name' => 'PT Sumber Makmur',
            'contact_person' => 'Budi Santoso',
            'phone' => '081234567890',
            'email' => 'vendor@sipbarang.local',
            'address' => 'Jl. Industri No. 1, Jakarta',
        ]);

        User::create([
            'name' => 'Vendor Portal',
            'email' => 'vendor@sipbarang.local',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'vendor_id' => $vendor->id,
        ]);
    }
}
