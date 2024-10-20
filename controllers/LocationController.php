<?php
require_once '/../db/database.php';

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
}
?>