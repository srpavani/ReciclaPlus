<?php
namespace App\Controllers;

use App\Models\Location;
use App\Config\Database;
use PDO;



class LocationsController {
    private $location;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->location = new Location($db);
    }

    public function getAllLocations() {
        header('Content-Type: application/json');
        try {
            $stmt = $this->location->read();
            $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($locations);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error retrieving locations: ' . $e->getMessage()]);
        }
    }

    public function addLocation($name, $latitude, $longitude) {
        header('Content-Type: application/json');

        // Sanitização
        $name = htmlspecialchars(strip_tags($name));
        $latitude = filter_var($latitude, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $longitude = filter_var($longitude, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Validação
        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid latitude or longitude']);
            return;
        }

        // Atribuição segura
        $this->location->name = $name;
        $this->location->latitude = $latitude;
        $this->location->longitude = $longitude;

        try {
            if ($this->location->create()) {
                http_response_code(201); // HTTP status code 201 means "Created"
                echo json_encode(['message' => 'Location Added Successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to Add Location']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error adding location: ' . $e->getMessage()]);
        }
    }
}
