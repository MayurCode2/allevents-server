<?php

require './db/dbcon.php';

// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "OPTIONS") {
    // Respond to preflight request
    http_response_code(200);
    exit;
} elseif ($requestMethod != "GET") {
    // Handle disallowed methods
    http_response_code(405);
    echo json_encode(["status" => 405, "message" => $requestMethod . ' Method Not Allowed']);
    exit;
}

// Handle the actual GET request
$eventList = getAllEvents();
echo $eventList;

function getAllEvents() {
    global $conn;

    $query = "SELECT * FROM events";
    $queryResult = mysqli_query($conn, $query);

    if (!$queryResult) {
        http_response_code(500);
        echo json_encode(["status" => 500, "message" => 'Internal Server Error']);
        exit;
    }

    $events = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);

    if (empty($events)) {
        http_response_code(404);
        echo json_encode(["status" => 404, "message" => 'No events to show']);
        exit;
    }

    http_response_code(200);
    echo json_encode(["status" => 200, "message" => 'Successfully fetched all events', "data" => $events]);
    exit;
}
?>
