<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$router = $app['router'];
$routes = $router->getRoutes();
foreach ($routes as $route) {
    $uri = $route->uri();
    if (str_starts_with($uri, 'cart') || str_starts_with($uri, 'checkout') || str_starts_with($uri, 'orders')) {
        $action = $route->getAction();
        echo "URI: $uri\n";
        echo "  Name: " . ($route->getName() ?? '') . "\n";
        echo "  Action: ";
        if (isset($action['controller'])) {
            echo $action['controller'] . "\n";
        } else {
            echo json_encode($action) . "\n";
        }
    }
}

