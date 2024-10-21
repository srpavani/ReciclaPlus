<?php
namespace App\Controllers;

use App\Config\Database;
use App\Models\User;
use Exception;

class UserController {
    private $user;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->user = new User($db);
    }

    public function register($name, $email, $password) {
        // Sanitização
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['message' => 'Formato de e-mail inválido']);
            return;
        }

        if (strlen($password) < 8) {
            echo json_encode(['message' => 'A senha deve ter pelo menos 8 caracteres']);
            return;
        }

        // Validação de nome (opcional: verificar se contém apenas letras, etc.)
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            echo json_encode(['message' => 'Nome contém caracteres inválidos']);
            return;
        }

        $this->user->setName($name);
        $this->user->setEmail($email);
        $this->user->setPassword($password);



        if ($this->user->create($name, $email, $password)) {
            echo json_encode(['message' => 'Usuário Criado Com Sucesso']);
        } else {
            echo json_encode(['message' => 'Erro ao criar usuário']);
        }
    }

    

    public function login($email, $password) {
        try {
            // Sanitização de e-mail
            $email = htmlspecialchars(strip_tags($email));

            $result = $this->user->checkLogin($email, $password);
            if ($result) {
                echo json_encode(['message' => 'Login bem-sucedido', 'user' => $result]);
            } else {
                throw new Exception('Falha no login');
            }
        } catch (Exception $e) {
            echo json_encode(['message' => 'Login falhou']);
        }
    }
}
