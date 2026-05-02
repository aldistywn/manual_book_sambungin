<?php

$envPath = __DIR__ . '/../../.env';

function env($key) {
    global $envPath;
    if (!file_exists($envPath)) {
        http_response_code(500);
        echo json_encode(["error" => ".env file not found"]);
        exit;
    }

    $lines = file($envPath);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (!str_contains($line, '=')) continue;

        list($k, $v) = explode('=', $line, 2);
        if (trim($k) === $key) {
            return trim($v);
        }
    }
    return null;
}

$conn = new mysqli(
    env('DB_HOST'),
    env('DB_USER'),
    env('DB_PASS'),
    env('DB_NAME'),
    (int) env('DB_PORT')
);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}