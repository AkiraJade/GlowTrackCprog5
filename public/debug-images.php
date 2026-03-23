<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

echo "<h2>Product Image Debug</h2>";

$products = Product::take(2)->get();

foreach ($products as $product) {
    echo "<h3>Product: {$product->name}</h3>";
    
    // Test photo_url accessor
    echo "<p><strong>photo_url accessor:</strong> {$product->photo_url}</p>";
    
    // Test manual path building
    if ($product->photo) {
        $photoPath = $product->photo;
        if (!str_contains($photoPath, '/')) {
            $photoPath = 'products/' . $photoPath;
        }
        $manualUrl = asset('storage/' . $photoPath);
        echo "<p><strong>manual URL:</strong> {$manualUrl}</p>";
        
        // Test file existence
        $fullPath = storage_path('app/public/' . $photoPath);
        echo "<p><strong>file exists:</strong> " . (file_exists($fullPath) ? 'YES' : 'NO') . "</p>";
        echo "<p><strong>full path:</strong> {$fullPath}</p>";
        
        // Test if public storage file exists
        $publicPath = public_path('storage/' . $photoPath);
        echo "<p><strong>public file exists:</strong> " . (file_exists($publicPath) ? 'YES' : 'NO') . "</p>";
        echo "<p><strong>public path:</strong> {$publicPath}</p>";
        
        // Test actual HTML img tag
        echo "<p><strong>Test image:</strong></p>";
        echo "<img src='{$manualUrl}' width='50' height='50' style='border: 1px solid red;' onerror='this.style.border=\"2px solid blue\"; console.log(\"Failed: {$manualUrl}\");'>";
    }
    
    echo "<hr>";
}

?>
