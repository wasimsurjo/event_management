<?php
require_once(__DIR__ . './../db/database.php');

class LocationController {
    public static function getAllLocations() {
        global $db;
        $stmt = $db->query("SELECT * FROM locations");
        $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($locations);
    }

    public static function createLocation() {
        global $db;
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("INSERT INTO locations (name, capacity, address, city, postal_code, created_at, updated_at) 
                              VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$data['name'], $data['capacity'], $data['address'], $data['city'], $data['postal_code']]);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Location created']);
    }

    public static function updateLocation($id) {
        global $db;
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("UPDATE locations SET name=?, capacity=?, address=?, city=?, postal_code=?, updated_at=NOW() WHERE location_id=?");
        $stmt->execute([$data['name'], $data['capacity'], $data['address'], $data['city'], $data['postal_code'], $id]);
        echo json_encode(['message' => 'Location updated']);
    }

    // Method to delete a location
    public static function deleteLocation($id) {
        global $db;
        $stmt = $db->prepare("DELETE FROM locations WHERE location_id=?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Location deleted']);
        } else {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Location not found']);
        }
    }
}
?>
