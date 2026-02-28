<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;

$user = App\Models\User::where('role', 'customer')->first();
if (! $user) { echo "No customer user\n"; exit; }

Auth::loginUsingId($user->id);

$cartItems = App\Models\Cart::where('user_id', $user->id)->with('product')->get();
if ($cartItems->isEmpty()) { echo "Cart empty\n"; exit; }

$subtotal = $cartItems->sum(function($item){ return $item->price * $item->quantity; });
$shipping = 10.00;
$tax = $subtotal * 0.08;
$total = $subtotal + $shipping + $tax;

// create order
$order = App\Models\Order::create([
    'user_id' => $user->id,
    'total_amount' => $total,
    'status' => 'confirmed',
    'shipping_address' => '123 Test St',
    'city' => 'Testville',
    'state' => 'TS',
    'postal_code' => '12345',
    'phone' => '1234567890',
    'payment_method' => 'cod',
    'order_date' => now(),
]);

foreach ($cartItems as $cartItem) {
    App\Models\OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $cartItem->product_id,
        'quantity' => $cartItem->quantity,
        'price' => $cartItem->price,
        'total' => $cartItem->price * $cartItem->quantity,
    ]);
}

App\Models\Cart::where('user_id', $user->id)->delete();

echo "Manual order created ID={$order->id} total={$order->total_amount}\n";
