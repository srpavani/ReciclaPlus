<?php
require_once '../../vendor/autoload.php';

use App\Controllers\UserController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $controller = new UserController();
    $controller->login($data['email'], $data['password']);
} else {
    http_response_code(405); // Método não permitido
    echo json_encode(['message' => 'Method not allowed']);
}
