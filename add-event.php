<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS, GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require './db/dbcon.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "POST") {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $eventInput = saveEvent($_POST);
    } else {
        $eventInput = saveEvent($inputData);
    }
    echo $eventInput;
} else if ($requestMethod == "OPTIONS") {
    // Respond to the preflight request
    header('HTTP/1.1 200 OK');
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',
    ];
    http_response_code(405);
    echo json_encode($data);
}

function saveEvent($eventInput) {
    global $conn;
    $event_name = mysqli_real_escape_string($conn, $eventInput['event_name']);
    $start_time = mysqli_real_escape_string($conn, $eventInput['start_time']);
    $end_time = mysqli_real_escape_string($conn, $eventInput['end_time']);
    $location = mysqli_real_escape_string($conn, $eventInput['location']);
    $description = mysqli_real_escape_string($conn, $eventInput['description']);
    $category = mysqli_real_escape_string($conn, $eventInput['category']);
    $banner_image = mysqli_real_escape_string($conn, $eventInput['banner_image']);

    if (
        !isset($eventInput['event_name']) ||
        !isset($eventInput['start_time']) ||
        !isset($eventInput['end_time']) ||
        !isset($eventInput['location']) ||
        !isset($eventInput['description']) ||
        !isset($eventInput['category']) ||
        !isset($eventInput['banner_image'])
    ) {
        $data = [
            'status' => 400,
            'message' => 'Invalid Input',
        ];
        http_response_code(400);
        return json_encode($data);
    } else {
        $query = "INSERT INTO events (event_name, start_time, end_time, location, description, category, banner_image) VALUES ('$event_name', '$start_time', '$end_time', '$location', '$description', '$category', '$banner_image')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status' => 201,
                'message' => 'Added successfully',
            ];
            http_response_code(201);
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            http_response_code(500);
            return json_encode($data);
        }
    }
}
?>
