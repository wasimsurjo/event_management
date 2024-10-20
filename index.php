<?php
// Include required files for routing and access control
require 'routes.php';
require '/middleware/AccessControl.php';

// Access Control: Check if the request IP is whitelisted or blacklisted
AccessControl::checkAccess();

// Handle incoming requests and route them to the correct controller

$requestMethod = $_SERVER['REQUEST_METHOD'];  // Get the HTTP method (GET, POST, PUT, DELETE)
$requestUri = $_SERVER['REQUEST_URI'];  // Get the request URI

// Normalize the URI by trimming leading or trailing slashes
$requestUri = trim($requestUri, '/');

// Handle API requests for events, participants, and locations
if (preg_match('/^api\/events$/', $requestUri)) {
    // Route to EventController based on method
    if ($requestMethod == 'GET') {
        EventController::getAllEvents();
    } elseif ($requestMethod == 'POST') {
        EventController::createEvent();
    } elseif ($requestMethod == 'PUT' && preg_match('/^api\/events\/(\d+)$/', $requestUri, $matches)) {
        $id = $matches[1];  // Get event ID from URL
        EventController::updateEvent($id);
    } elseif ($requestMethod == 'DELETE' && preg_match('/^api\/events\/(\d+)$/', $requestUri, $matches)) {
        $id = $matches[1];  // Get event ID from URL
        EventController::deleteEvent($id);
    } else {
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['error' => 'Method not allowed']);
    }
} elseif (preg_match('/^api\/participants$/', $requestUri)) {
    // Route to ParticipantController based on method
    if ($requestMethod == 'GET') {
        ParticipantController::getAllParticipants();
    } elseif ($requestMethod == 'POST') {
        ParticipantController::createParticipant();
    } else {
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['error' => 'Method not allowed']);
    }
} elseif (preg_match('/^api\/locations$/', $requestUri)) {
    // Route to LocationController based on method
    if ($requestMethod == 'GET') {
        LocationController::getAllLocations();
    } elseif ($requestMethod == 'POST') {
        LocationController::createLocation();
    } else {
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['error' => 'Method not allowed']);
    }
} else {
    // Handle undefined routes
    header("HTTP/1.0 404 Not Found");
    echo json_encode(['error' => 'Resource not found']);
}

?>
