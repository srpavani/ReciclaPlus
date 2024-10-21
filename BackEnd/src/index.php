<?php
require_once '../vendor/autoload.php';

use App\Controllers\LocationsController;
use App\Controllers\UserController;


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    // Considerando que você já tem uma lógica para lidar com POST data e router no index.php
    case '/api/register':
        $data = json_decode(file_get_contents("php://input"), true);
        $controller = new UserController();
        $controller->register($data['name'], $data['email'], $data['password']);
        break;
    case '/api/login':
        $data = json_decode(file_get_contents("php://input"), true);
        $controller = new UserController();
        $controller->login($data['email'], $data['password']);
        break;
    case '/api/locations':
        $controller = new LocationsController();
        $controller->getAllLocations();
        break;
    case '/api/addlocation':
        $controller = new LocationsController();
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->addLocation($data['name'], $data['latitude'], $data['longitude']);
        break;
    default:
        http_response_code(404);
        echo json_encode(array('message' => 'No route found.'));
        break;
}
