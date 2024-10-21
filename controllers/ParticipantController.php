<?php
require_once(__DIR__ . './../db/database.php');

class ParticipantController {
    public static function getAllParticipants() {
        global $db;
        $stmt = $db->query("SELECT * FROM participants");
        $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($participants);
    }

    public static function createParticipant() {
        global $db;
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("INSERT INTO participants (name, email, phone_number, status, registered_at) 
                              VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$data['name'], $data['email'], $data['phone_number'], $data['status']]);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Participant created']);
    }

    public static function updateParticipant($id) {
        global $db;
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("UPDATE participants SET name=?, email=?, phone_number=?, status=?, registered_at=NOW() WHERE participant_id=?");
        $stmt->execute([$data['name'], $data['email'], $data['phone_number'], $data['status'], $id]);
        echo json_encode(['message' => 'Participant updated']);
    }

    // Method to delete a participant
    public static function deleteParticipant($id) {
        global $db;
        $stmt = $db->prepare("DELETE FROM participants WHERE participant_id=?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Participant deleted']);
        } else {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Participant not found']);
        }
    }
}
?>
