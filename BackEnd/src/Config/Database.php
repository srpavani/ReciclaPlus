<?php
namespace App\Config;

use PDO;

class Database {
    private $host = 'localhost';
    private $db_name = 'db_recycle';
    private $username = 'root';
    private $password = '';

    public function getConnection() {
        $conn = null;
        try {
            $conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $conn;
    }
}
