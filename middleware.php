
<?php
require 'db.php';

// Add to Blacklist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'add_blacklist') {
    $ip_address = $_POST['ip_address'];

    $stmt = $pdo->prepare("INSERT INTO blacklist (ip_address) VALUES (?)");
    if ($stmt->execute([$ip_address])) {
        echo json_encode(["message" => "IP added to blacklist"]);
    } else {
        echo json_encode(["message" => "Failed to add IP to blacklist"]);
    }
}

// Remove from Blacklist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'remove_blacklist') {
    $ip_address = $_POST['ip_address'];

    $stmt = $pdo->prepare("DELETE FROM blacklist WHERE ip_address = ?");
    if ($stmt->execute([$ip_address])) {
        echo json_encode(["message" => "IP removed from blacklist"]);
    } else {
        echo json_encode(["message" => "Failed to remove IP from blacklist"]);
    }
}

// Add to Whitelist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'add_whitelist') {
    $ip_address = $_POST['ip_address'];

    $stmt = $pdo->prepare("INSERT INTO whitelist (ip_address) VALUES (?)");
    if ($stmt->execute([$ip_address])) {
        echo json_encode(["message" => "IP added to whitelist"]);
    } else {
        echo json_encode(["message" => "Failed to add IP to whitelist"]);
    }
}

// Remove from Whitelist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'remove_whitelist') {
    $ip_address = $_POST['ip_address'];

    $stmt = $pdo->prepare("DELETE FROM whitelist WHERE ip_address = ?");
    if ($stmt->execute([$ip_address])) {
        echo json_encode(["message" => "IP removed from whitelist"]);
    } else {
        echo json_encode(["message" => "Failed to remove IP from whitelist"]);
    }
}
?>
