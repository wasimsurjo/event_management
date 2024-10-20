<?php
require_once '/../db/database.php';

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
}
?>