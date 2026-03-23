<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h2>Storage Link Test</h2>";

// Test if storage link works
$storageLink = public_path('storage');
$target = storage_path('app/public');

echo "<p>Storage link exists: " . (is_link($storageLink) ? 'YES' : 'NO') . "</p>";
echo "<p>Storage link target: " . readlink($storageLink) . "</p>";
echo "<p>Expected target: {$target}</p>";

// Test file access
$testFile = 'products/7jwjq3AlvXMOMbAWb85WReZLNsOZ5zHAlcPkTvy9.jpg';
$fullPath = storage_path('app/public/' . $testFile);
$publicPath = public_path('storage/' . $testFile);

echo "<h3>File Test</h3>";
echo "<p>Storage file exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "</p>";
echo "<p>Public file exists: " . (file_exists($publicPath) ? 'YES' : 'NO') . "</p>";
echo "<p>Storage path: {$fullPath}</p>";
echo "<p>Public path: {$publicPath}</p>";

// Test URL generation
echo "<h3>URL Test</h3>";
$url1 = asset('storage/' . $testFile);
$url2 = url('/storage/' . $testFile);
echo "<p>Asset URL: {$url1}</p>";
echo "<p>Direct URL: {$url2}</p>";

// Test image display
echo "<h3>Image Display Test</h3>";
echo "<p>Image via asset():</p>";
echo "<img src='{$url1}' width='100' height='100' onerror='console.log(\"Asset failed\"); this.style.border=\"2px solid red\"'>";
echo "<p>Image via url():</p>";
echo "<img src='{$url2}' width='100' height='100' onerror='console.log(\"URL failed\"); this.style.border=\"2px solid blue\"'>";

?>
