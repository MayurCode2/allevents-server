<?php
require './db/dbcon.php';

function checkDateOrder($userDate, $eventDate) {
    $userInputDate = DateTime::createFromFormat('d/m/Y', $userDate);
    $eventStartDate = DateTime::createFromFormat('d/m/Y', $eventDate);

    return $userInputDate && $eventStartDate && $userInputDate <= $eventStartDate;
}

function filterEventsByDate($date, $events) {
    $filteredEvents = array();
    foreach ($events as $event) {
        if (checkDateOrder($date, $event['start_time'])) {
            $filteredEvents[] = $event;
        }
    }
    return $filteredEvents;
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "OPTIONS") {
    // Respond to preflight request
    http_response_code(200);
    exit;
} elseif ($requestMethod == "GET") {
    // Handle GET request to get all events
    $allEvents = getAllEvents();
    echo $allEvents;
    exit;
} elseif ($requestMethod == "POST") {
    // Handle POST request to filter events
    $inputData = json_decode(file_get_contents("php://input"), true);
    $selectedCity = isset($inputData['city']) ? $inputData['city'] : null;
    $selectedCategory = isset($inputData['category']) ? $inputData['category'] : null;
    $userSelectedDate = isset($inputData['date']) ? $inputData['date'] : null;

    $filteredEventList = fetchFilteredEventList($selectedCity, $selectedCategory, $userSelectedDate);
    echo $filteredEventList;
    exit;
} else {
    // Handle other disallowed methods
    http_response_code(405);
    echo json_encode(["status" => 405, "message" => $requestMethod . ' Method Not Allowed']);
    exit;
}

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

function fetchFilteredEventList($city, $category, $date) {
    global $conn;

    $query = "SELECT * FROM events WHERE 1";

    if ($city) {
        $query .= " AND LOWER(location) = LOWER('$city')";
    }
    if ($category) {
        $query .= " AND LOWER(category) = LOWER('$category')";
    }

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

    if ($date) {
        $filteredEvents = filterEventsByDate($date, $events);
    } else {
        http_response_code(200);
        echo json_encode(["status" => 200, "message" => 'Successfully fetched data', "data" => $events]);
        exit;
    }

    if (empty($filteredEvents) && $date) {
        http_response_code(404);
        echo json_encode(["status" => 404, "message" => 'No active or upcoming events on chosen date: ' . $date]);
        exit;
    } else {
        http_response_code(200);
        echo json_encode(["status" => 200, "message" => 'Successfully fetched data', "data" => $filteredEvents]);
        exit;
    }
}
?>
