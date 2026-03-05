<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('role', 'customer')->first();
if (! $user) { echo "No customer user\n"; exit;
}
$carts = App\Models\Cart::where('user_id', $user->id)->with('product')->get();
echo "User ID: {$user->id} ({$user->name})\n";
echo "Cart count: " . $carts->count() . "\n";
foreach ($carts as $c) {
    echo "- Product: {$c->product->id} - {$c->product->name} | qty={$c->quantity} price={$c->price}\n";
}

$orders = App\Models\Order::where('user_id', $user->id)->get();
echo "Orders count: " . $orders->count() . "\n";
foreach ($orders as $o) {
    echo "- Order {$o->id} total {$o->total_amount} status {$o->status}\n";
}
