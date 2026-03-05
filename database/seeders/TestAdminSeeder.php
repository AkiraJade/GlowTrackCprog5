<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestAdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create multiple test admin accounts
        $admins = [
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@glowtrack.com',
                'phone' => '+1234567899',
                'address' => '999 Super Admin Avenue, Admin City, AC 99999',
                'password' => 'admin123',
            ],
            [
                'name' => 'Test Admin',
                'username' => 'testadmin',
                'email' => 'testadmin@glowtrack.com',
                'phone' => '+1234567888',
                'address' => '888 Test Admin Road, Admin City, AC 88888',
                'password' => 'test123',
            ],
            [
                'name' => 'Demo Admin',
                'username' => 'demo',
                'email' => 'demo@glowtrack.com',
                'phone' => '+1234567777',
                'address' => '777 Demo Admin Lane, Admin City, AC 77777',
                'password' => 'demo123',
            ],
        ];

        foreach ($admins as $adminData) {
            User::updateOrCreate(
                ['email' => $adminData['email']],
                [
                    'name' => $adminData['name'],
                    'username' => $adminData['username'],
                    'email' => $adminData['email'],
                    'phone' => $adminData['phone'],
                    'address' => $adminData['address'],
                    'role' => 'admin',
                    'password' => Hash::make($adminData['password']),
                    'email_verified_at' => now(),
                ]
            );

            $this->command->info("Admin account '{$adminData['name']}' created successfully!");
        }

        $this->command->info('');
        $this->command->info('=== Test Admin Accounts ===');
        foreach ($admins as $adminData) {
            $this->command->info("Email: {$adminData['email']} | Password: {$adminData['password']}");
        }
    }
}
