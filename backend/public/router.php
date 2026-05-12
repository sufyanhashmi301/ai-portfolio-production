<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/api/health') {
    require __DIR__ . '/../app/Http/Controllers/Api/HealthController.php';
    $controller = new App\Http\Controllers\Api\HealthController();
    $payload = $controller();
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($payload);
    return;
}

http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['message' => 'Not Found']);
