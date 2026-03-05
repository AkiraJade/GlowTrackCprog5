<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResetPasswordsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset admin password
        $admin = User::where('email', 'admin@glowtrack.com')->first();
        if ($admin) {
            $admin->password = Hash::make('password');
            $admin->save();
            $this->command->info('Admin password reset to: password');
        }

        // Reset seller password
        $seller = User::where('email', 'sarah@glowtrack.com')->first();
        if ($seller) {
            $seller->password = Hash::make('password');
            $seller->save();
            $this->command->info('Seller password reset to: password');
        }

        // Reset customer password
        $customer = User::where('email', 'john@glowtrack.com')->first();
        if ($customer) {
            $customer->password = Hash::make('password');
            $customer->save();
            $this->command->info('Customer password reset to: password');
        }

        // Reset test admin passwords
        $testAdmins = [
            'superadmin@glowtrack.com' => 'admin123',
            'testadmin@glowtrack.com' => 'test123',
            'demo@glowtrack.com' => 'demo123',
        ];

        foreach ($testAdmins as $email => $password) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->password = Hash::make($password);
                $user->save();
                $this->command->info("Test admin {$email} password reset to: {$password}");
            }
        }

        $this->command->info('');
        $this->command->info('=== All Test Account Passwords Reset ===');
        $this->command->info('Admin: admin@glowtrack.com | password: password');
        $this->command->info('Seller: sarah@glowtrack.com | password: password');
        $this->command->info('Customer: john@glowtrack.com | password: password');
        $this->command->info('Test Admins:');
        $this->command->info('  - superadmin@glowtrack.com | password: admin123');
        $this->command->info('  - testadmin@glowtrack.com | password: test123');
        $this->command->info('  - demo@glowtrack.com | password: demo123');
    }
}
