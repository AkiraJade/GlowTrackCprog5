<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update admin account
        User::updateOrCreate(
            ['email' => 'admin@glowtrack.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@glowtrack.com',
                'phone' => '+1234567890',
                'address' => '123 Admin Street, Admin City, AC 12345',
                'role' => 'admin',
                'password' => Hash::make('password'), // Default password: password
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin account created successfully!');
        $this->command->info('Email: admin@glowtrack.com');
        $this->command->info('Password: password');
    }
}
