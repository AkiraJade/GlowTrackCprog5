<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

// Find or create a customer user
$user = User::where('role', 'customer')->first();
if (! $user) {
    $user = User::factory()->create([ 'role' => 'customer' ]);
}

// Find a product with stock
$product = Product::where('quantity', '>', 0)->first();
if (! $product) {
    echo "No product with stock available.\n";
    exit(1);
}

// Login the user
Auth::loginUsingId($user->id);

// Add to cart
$request = Request::create('/cart/add/'.$product->id, 'POST', ['quantity' => 1]);
$request->setLaravelSession($app['session.store']);

$cartController = new App\Http\Controllers\CartController();
$response = $cartController->add($request, $product);

echo "Add to cart response status: " . ($response->getStatusCode() ?? 'N/A') . "\n";

// Simulate checkout
$checkoutRequest = Request::create('/checkout/process', 'POST', [
    'shipping_address' => '123 Test St',
    'city' => 'Testville',
    'state' => 'TS',
    'postal_code' => '12345',
    'phone' => '1234567890',
    'payment_method' => 'cod',
]);
$checkoutRequest->setLaravelSession($app['session.store']);

// Print most recent order for user
$checkoutController = new App\Http\Controllers\CheckoutController();
try {
    $response2 = $checkoutController->process($checkoutRequest);
    if ($response2 instanceof Illuminate\Http\RedirectResponse) {
        echo "Checkout redirected to: " . $response2->getTargetUrl() . "\n";
    } else {
        echo "Checkout response: " . get_class($response2) . "\n";
    }
} catch (\Throwable $e) {
    echo "Checkout exception: " . get_class($e) . " - " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

// Print most recent order for user
$order = App\Models\Order::where('user_id', $user->id)->latest()->first();
if ($order) {
    echo "Order created: ID={$order->id} total={$order->total_amount} status={$order->status}\n";
} else {
    echo "No order created.\n";
}

