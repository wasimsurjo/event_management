<?php
require_once(__DIR__ . './../db/database.php');

class EventController {
    public static function getAllEvents() {
        global $db;
        $stmt = $db->query("SELECT * FROM events");
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($events);
    }

    public static function createEvent() {
        global $db;
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("INSERT INTO events (name, event_date, description, organizer_name, location_id, capacity, is_active, created_at, updated_at) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$data['name'], $data['event_date'], $data['description'], $data['organizer_name'], $data['location_id'], $data['capacity'], $data['is_active']]);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Event created']);
    }

    public static function updateEvent($id) {
        global $db;
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("UPDATE events SET name=?, event_date=?, description=?, organizer_name=?, location_id=?, capacity=?, is_active=?, updated_at=NOW() WHERE event_id=?");
        $stmt->execute([$data['name'], $data['event_date'], $data['description'], $data['organizer_name'], $data['location_id'], $data['capacity'], $data['is_active'], $id]);
        echo json_encode(['message' => 'Event updated']);
    }

    public static function deleteEvent($id) {
        global $db;
        $stmt = $db->prepare("DELETE FROM events WHERE event_id=?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Event deleted']);
    }
}
?>
