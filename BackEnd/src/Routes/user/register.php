<?php
require_once '../../vendor/autoload.php';

use App\Controllers\UserController;

// Definir cabeçalhos da resposta
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar dados JSON da requisição
    $data = json_decode(file_get_contents("php://input"), true);

    // Criar instância do UserController e chamar o método register
    $controller = new UserController();
    $controller->register($data['name'], $data['email'], $data['password']);
} else {
    http_response_code(405); // Método não permitido
    echo json_encode(['message' => 'Method not allowed']);
}
