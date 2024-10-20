
<?php
// index.php - Main Router

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/events':
        require 'events.php';
        break;
    case '/participants':
        require 'participants.php';
        break;
    case '/middleware':
        require 'middleware.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Not Found']);
        break;
}
?>
