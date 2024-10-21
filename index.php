<?php
// Include required files for routing and access control
require_once(__DIR__ . '/routes.php');
require_once(__DIR__ . '/middleware/AccessControl.php');

// Access Control: Check if the request IP is whitelisted or blacklisted
AccessControl::checkAccess();  // Ensure this only blocks access if necessary

// Handle incoming requests and route them to the correct controller
$requestMethod = $_SERVER['REQUEST_METHOD'];  // Get the HTTP method (GET, POST, PUT, DELETE)
$requestUri = $_SERVER['REQUEST_URI'];  // Get the request URI

// Normalize the URI by trimming leading or trailing slashes
$requestUri = trim($requestUri, '/');

// Log request URI for debugging
error_log("Request URI: " . $requestUri);

// Set CORS headers (for cross-domain requests, if needed)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle API requests for events, participants, and locations
if (preg_match('/^api\/events\/?$/', $requestUri)) {
    // Route to EventController based on method
    if ($requestMethod == 'GET') {
        header("HTTP/1.0 200 OK");
        EventController::getAllEvents();
    } elseif ($requestMethod == 'POST') {
        header("HTTP/1.0 200 OK");
        EventController::createEvent();
    } elseif ($requestMethod == 'PUT' && preg_match('/^api\/events\/(\d+)$/', $requestUri, $matches)) {
        $id = $matches[1];  // Get event ID from URL
        header("HTTP/1.0 200 OK");
        EventController::updateEvent($id);
    } elseif ($requestMethod == 'DELETE' && preg_match('/^api\/events\/(\d+)$/', $requestUri, $matches)) {
        $id = $matches[1];  // Get event ID from URL
        header("HTTP/1.0 200 OK");
        EventController::deleteEvent($id);
    } else {
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['error' => 'Method not allowed']);
    }
} elseif (preg_match('/^api\/participants\/?$/', $requestUri)) {
    // Route to ParticipantController based on method
    if ($requestMethod == 'GET') {
        header("HTTP/1.0 200 OK");
        ParticipantController::getAllParticipants();
    } elseif ($requestMethod == 'POST') {
        header("HTTP/1.0 200 OK");
        ParticipantController::createParticipant();
    } elseif ($requestMethod == 'PUT' && preg_match('/^api\/participants\/(\d+)$/', $requestUri, $matches)) {
        header("HTTP/1.0 200 OK");
        ParticipantController::updateParticipant($matches[1]);
    } elseif ($requestMethod == 'DELETE' && preg_match('/^api\/participants\/(\d+)$/', $requestUri, $matches)) {
        header("HTTP/1.0 200 OK");
        ParticipantController::deleteParticipant($matches[1]);
    } else {
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['error' => 'Method not allowed']);
    }
} elseif (preg_match('/^api\/locations\/?$/', $requestUri)) {
    // Route to LocationController based on method
    if ($requestMethod == 'GET') {
        header("HTTP/1.0 200 OK");
        LocationController::getAllLocations();
    } elseif ($requestMethod == 'POST') {
        header("HTTP/1.0 200 OK");
        LocationController::createLocation();
    } elseif ($requestMethod == 'PUT' && preg_match('/^api\/locations\/(\d+)$/', $requestUri, $matches)) {
        header("HTTP/1.0 200 OK");
        LocationController::updateLocation($matches[1]);
    } elseif ($requestMethod == 'DELETE' && preg_match('/^api\/locations\/(\d+)$/', $requestUri, $matches)) {
        header("HTTP/1.0 200 OK");
        LocationController::deleteLocation($matches[1]);
    } else {
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['error' => 'Method not allowed']);
    }
} else {
    // Handle undefined routes
    header("Content-Type: application/json");
    header("HTTP/1.0 404 Not Found");
    echo json_encode(['error' => 'Resource not found']);
    error_log("No matching route for URI: " . $requestUri);
}

?>
