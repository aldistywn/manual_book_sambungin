<?php

header("Content-Type: application/json");

$basePath = "/Manual Book Sambungin/website";
$uri = urldecode($_SERVER['REQUEST_URI']);
$uri = str_replace($basePath, "", $uri);
$method = $_SERVER['REQUEST_METHOD'];

// remove query string
$uri = explode("?", $uri)[0];

// routing
if ($uri === '/api/modules' && $method === 'GET') {
    require 'modules.php';
    getModules();
    return;
}

if ($uri === '/api/modules' && $method === 'POST') {
    require 'modules.php';
    createModule();
    return;
}

if (preg_match('#^/api/modules/(\d+)$#', $uri, $matches)) {
    if ($method === 'DELETE') {
        require 'modules.php';
        deleteModule($matches[1]);
        return;
    }
}

if (preg_match('#^/api/modules/(\d+)/steps$#', $uri, $matches)) {
    require 'steps.php';
    getSteps($matches[1]);
    return;
}

http_response_code(404);
echo json_encode(["error" => "Not Found"]);