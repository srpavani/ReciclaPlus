<?php
require_once '../../vendor/autoload.php';

use App\Controllers\LocationsController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new LocationsController();
    $controller->getAllLocations();
} else {
    http_response_code(405); // Método não permitido
    echo json_encode(['message' => 'Method not allowed']);
}
