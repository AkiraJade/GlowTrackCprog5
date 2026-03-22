<!DOCTYPE html>
<html>
<head>
    <title>Asset Test</title>
</head>
<body>
    <h1>Asset URL Test</h1>
    
    <h2>APP_URL: {{ config('app.url') }}</h2>
    <h2>Asset Helper Test:</h2>
    <img src="{{ asset('storage/user_photos/default-avatar.jpg') }}" alt="Test" style="width: 100px; height: 100px; border: 1px solid #ccc;">
    
    <h2>Storage URL Test:</h2>
    <img src="{{ url('/storage/user_photos/default-avatar.jpg') }}" alt="Test" style="width: 100px; height: 100px; border: 1px solid #ccc;">
    
    <h2>Direct Storage Path:</h2>
    <img src="/storage/user_photos/default-avatar.jpg" alt="Test" style="width: 100px; height: 100px; border: 1px solid #ccc;">
</body>
</html>
