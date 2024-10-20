
<?php
require 'db.php';

// Create Participant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'create') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $event_id = $_POST['event_id'];

    $stmt = $pdo->prepare("INSERT INTO participants (name, email, event_id) VALUES (?, ?, ?)");
    if ($stmt->execute([$name, $email, $event_id])) {
        echo json_encode(["message" => "Participant registered successfully"]);
    } else {
        echo json_encode(["message" => "Failed to register participant"]);
    }
}

// Get All Participants
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'get_all') {
    $stmt = $pdo->query("SELECT * FROM participants");
    $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($participants);
}

// Update Participant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE participants SET name = ?, email = ? WHERE participant_id = ?");
    if ($stmt->execute([$name, $email, $id])) {
        echo json_encode(["message" => "Participant updated successfully"]);
    } else {
        echo json_encode(["message" => "Failed to update participant"]);
    }
}

// Delete Participant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'delete') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM participants WHERE participant_id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(["message" => "Participant deleted successfully"]);
    } else {
        echo json_encode(["message" => "Failed to delete participant"]);
    }
}
?>
