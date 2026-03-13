<?php

// Test script to debug photo upload issue
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

// Get the most recent user
$user = \App\Models\User::latest()->first();

if ($user) {
    echo "User found: " . $user->name . "\n";
    echo "User ID: " . $user->id . "\n";
    echo "Photo field: " . ($user->photo ?? 'NULL') . "\n";
    echo "Photo URL: " . $user->photo_url . "\n";
    
    // Check if photo file exists
    if ($user->photo) {
        $photoPath = public_path('storage/user_photos/' . $user->photo);
        echo "Photo file path: " . $photoPath . "\n";
        echo "File exists: " . (file_exists($photoPath) ? 'YES' : 'NO') . "\n";
    }
} else {
    echo "No users found in database\n";
}

// Check storage directory
$storageDir = public_path('storage/user_photos');
echo "Storage directory: " . $storageDir . "\n";
echo "Directory exists: " . (is_dir($storageDir) ? 'YES' : 'NO') . "\n";

if (is_dir($storageDir)) {
    $files = scandir($storageDir);
    echo "Files in storage:\n";
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "  - " . $file . "\n";
        }
    }
}

?>
