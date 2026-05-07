<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@booking.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1',
        ]);

        // Create Owner Users
        User::create([
            'name' => 'Owner 1',
            'email' => 'owner1@booking.test',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'status' => 'active',
            'phone' => '081234567891',
            'address' => 'Jl. Owner No. 1',
        ]);

        User::create([
            'name' => 'Owner 2',
            'email' => 'owner2@booking.test',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'status' => 'active',
            'phone' => '081234567892',
            'address' => 'Jl. Owner No. 2',
        ]);

        // Create Customer Users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Customer $i",
                'email' => "customer{$i}@booking.test",
                'password' => bcrypt('password'),
                'role' => 'customer',
                'status' => 'active',
                'phone' => "0812345678" . str_pad($i, 2, '0', STR_PAD_LEFT),
                'address' => "Jl. Customer No. $i",
            ]);
        }
    }
}
