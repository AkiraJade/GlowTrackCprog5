<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VerifiedCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating verified customer accounts...');

        // Create verified customer accounts for testing
        $verifiedCustomers = [
            [
                'name' => 'Jane Doe',
                'username' => 'jane_doe',
                'email' => 'jane@example.com',
                'phone' => '+1234567890',
                'address' => '123 Main St, New York, NY 10001',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subMonths(6),
            ],
            [
                'name' => 'John Smith',
                'username' => 'john_smith',
                'email' => 'john@example.com',
                'phone' => '+0987654321',
                'address' => '456 Oak Ave, Los Angeles, CA 90001',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'email_verified_at' => Carbon::now()->subDays(30),
                'created_at' => Carbon::now()->subMonths(3),
            ],
            [
                'name' => 'Emily Johnson',
                'username' => 'emily_j',
                'email' => 'emily@example.com',
                'phone' => '+1122334455',
                'address' => '789 Pine Rd, Chicago, IL 60007',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'email_verified_at' => Carbon::now()->subDays(15),
                'created_at' => Carbon::now()->subMonths(2),
            ],
            [
                'name' => 'Michael Brown',
                'username' => 'michael_b',
                'email' => 'michael@example.com',
                'phone' => '+5544332211',
                'address' => '321 Elm St, Houston, TX 77001',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'email_verified_at' => Carbon::now()->subDays(7),
                'created_at' => Carbon::now()->subMonths(1),
            ],
            [
                'name' => 'Sarah Wilson',
                'username' => 'sarah_w',
                'email' => 'sarah@example.com',
                'phone' => '+9988776655',
                'address' => '654 Maple Dr, Phoenix, AZ 85001',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'email_verified_at' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subWeeks(2),
            ],
        ];

        foreach ($verifiedCustomers as $customer) {
            // Check if user already exists
            $existingUser = User::where('email', $customer['email'])->first();
            
            if (!$existingUser) {
                User::create($customer);
                $this->command->info("Created verified customer: {$customer['name']} ({$customer['email']})");
            } else {
                // Update existing user to be verified
                $existingUser->update([
                    'email_verified_at' => $customer['email_verified_at'],
                    'password' => $customer['password'], // Update password to known value
                ]);
                $this->command->info("Updated existing customer to verified: {$existingUser->name} ({$existingUser->email})");
            }
        }

        $this->command->info('Verified customer accounts created successfully!');
    }
}
