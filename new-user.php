<?php
error_reporting(0);

require './db/dbcon.php';

// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "POST" || $requestMethod == "OPTIONS") {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $userInput = saveUser($_POST);
    } else {
        $userInput = saveUser($inputData);
    }
    echo $userInput;
} else {
    http_response_code(405);
    echo json_encode(["status" => 405, "message" => $requestMethod . ' Method Not Allowed']);
}

function saveUser($userInput) {
    global $conn;

    $name = mysqli_real_escape_string($conn, $userInput['name']);
    $email = mysqli_real_escape_string($conn, $userInput['email']);

    if (
        !isset($userInput['name']) ||
        !isset($userInput['email'])
    ) {
        http_response_code(400);
        echo json_encode(["status" => 400, "message" => 'Invalid Input']);
    } else {
        $query = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            http_response_code(201);
            echo json_encode(["status" => 201, "message" => 'User added successfully']);
        } else {
            http_response_code(500);
            echo json_encode(["status" => 500, "message" => 'Internal Server Error']);
        }
    }
}
?>
