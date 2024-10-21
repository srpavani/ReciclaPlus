<?php
namespace App\Models;

class Location {
    private $conn;
    private $table_name = "locations";

    public $id;
    public $name;
    public $latitude;
    public $longitude;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT id, name, latitude, longitude FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, latitude=:latitude, longitude=:longitude";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
