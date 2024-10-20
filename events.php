
<?php
require 'db.php';

// Create Event with capacity check
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'create') {
    $name = $_POST['name'];
    $event_date = $_POST['event_date'];
    $location_id = $_POST['location_id'];
    $capacity = $_POST['capacity'];

    // Check venue capacity before creating event
    $stmt = $pdo->prepare("SELECT COUNT(*) AS participant_count FROM participants WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['participant_count'] > $capacity) {
        echo json_encode(["message" => "Venue capacity exceeded. Event cannot be created."]);
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO events (name, event_date, location_id, capacity) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $event_date, $location_id, $capacity])) {
        echo json_encode(["message" => "Event created successfully"]);
    } else {
        echo json_encode(["message" => "Failed to create event"]);
    }
}

// Get All Events
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'get_all') {
    $stmt = $pdo->query("SELECT * FROM events");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($events);
}

// Get Events by Date (Filtering)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'get_by_date') {
    $event_date = $_GET['event_date'];
    $stmt = $pdo->prepare("SELECT * FROM events WHERE event_date = ?");
    $stmt->execute([$event_date]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($events);
}

// Update Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $event_date = $_POST['event_date'];

    $stmt = $pdo->prepare("UPDATE events SET name = ?, event_date = ? WHERE event_id = ?");
    if ($stmt->execute([$name, $event_date, $id])) {
        echo json_encode(["message" => "Event updated successfully"]);
    } else {
        echo json_encode(["message" => "Failed to update event"]);
    }
}

// Delete Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'delete') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM events WHERE event_id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(["message" => "Event deleted successfully"]);
    } else {
        echo json_encode(["message" => "Failed to delete event"]);
    }
}
?>
