<?php
namespace App\Models;

use PDO;

class User {
    private $conn;
    private $table_name = "users";

    private $id;
    private $name;
    private $email;
    private $password;
    private $is_admin = false;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function isAdmin() {
        return $this->is_admin;
    }

    public function setName($name) {
        $this->name = htmlspecialchars(strip_tags($name));
    }

    public function setEmail($email) {
        $this->email = htmlspecialchars(strip_tags($email));
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setIsAdmin($is_admin) {
        $this->is_admin = $is_admin;
    }

    public function create($name, $email, $password) {
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, is_admin) VALUES (:name, :email, :password, false)";
        $stmt = $this->conn->prepare($query);;
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function checkLogin($email, $password) {
        $query = "SELECT id, name, password, is_admin FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $row['password'])) {
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->password = $row['password'];
                $this->is_admin = $row['is_admin'];
                return true;
            }
        }
        return false;
    }
    
    

    
}
