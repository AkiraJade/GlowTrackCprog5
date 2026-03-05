<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DebugOrdersSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== DEBUG: Orders and Users ===');
        
        // Show all users
        $users = User::all();
        $this->command->info('Users in database:');
        foreach ($users as $user) {
            $this->command->info("  ID: {$user->id} | Email: {$user->email} | Role: {$user->role}");
        }
        
        // Show all orders
        $orders = Order::all();
        $this->command->info('Orders in database:');
        foreach ($orders as $order) {
            $this->command->info("  Order ID: {$order->id} | User ID: {$order->user_id} | Status: {$order->status}");
        }
        
        // Check if customer has orders
        $customer = User::where('email', 'john@glowtrack.com')->first();
        if ($customer) {
            $customerOrders = Order::where('user_id', $customer->id)->get();
            $this->command->info("Customer john@glowtrack.com (ID: {$customer->id}) has {$customerOrders->count()} orders:");
            foreach ($customerOrders as $order) {
                $this->command->info("  Order #{$order->id} | Status: {$order->status}");
            }
        }
    }
}
