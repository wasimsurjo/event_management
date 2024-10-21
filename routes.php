<?php
require_once(__DIR__ . '/controllers/EventController.php');
require_once(__DIR__ . '/controllers/LocationController.php');
require_once(__DIR__ . '/controllers/ParticipantController.php');

$requestUri = $_SERVER['REQUEST_URI'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/api\/events$/', $requestUri)) {
    EventController::getAllEvents();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && preg_match('/^\/api\/events$/', $requestUri)) {
    EventController::createEvent();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/^\/api\/events\/(\d+)$/', $requestUri, $matches)) {
    EventController::updateEvent($matches[1]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/^\/api\/events\/(\d+)$/', $requestUri, $matches)) {
    EventController::deleteEvent($matches[1]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/api\/locations$/', $requestUri)) {
    LocationController::getAllLocations();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && preg_match('/^\/api\/locations$/', $requestUri)) {
    LocationController::createLocation();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/^\/api\/locations\/(\d+)$/', $requestUri, $matches)) {
    LocationController::updateLocation($matches[1]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/^\/api\/locations\/(\d+)$/', $requestUri, $matches)) {
    LocationController::deleteLocation($matches[1]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/api\/participants$/', $requestUri)) {
    ParticipantController::getAllParticipants();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && preg_match('/^\/api\/participants$/', $requestUri)) {
    ParticipantController::createParticipant();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/^\/api\/participants\/(\d+)$/', $requestUri, $matches)) {
    ParticipantController::updateParticipant($matches[1]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/^\/api\/participants\/(\d+)$/', $requestUri, $matches)) {
    ParticipantController::deleteParticipant($matches[1]);
} else {
    header("HTTP/1.0 404 Not Found");
    echo json_encode(['error' => 'Route not found']);
}
?>
