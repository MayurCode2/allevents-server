<?php 


$host = "localhost";
$username = "root";
$password = "";
$dbname = "allevents";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// creating events table to store all events

$lowerTableName = 'events';

$tableCheckQuery = "SHOW TABLES LIKE '$lowerTableName'";
$tableExistsResult = mysqli_query($conn, $tableCheckQuery);
$tableExists = mysqli_num_rows($tableExistsResult); 

if (!$tableExists) {
    $createTableQuery = "
    CREATE TABLE $lowerTableName (
        id INT AUTO_INCREMENT PRIMARY KEY,
        event_name VARCHAR(255) NOT NULL,
        start_time VARCHAR(255) NOT NULL,
        end_time VARCHAR(255) NOT NULL,
        location VARCHAR(255) NOT NULL,
        description VARCHAR(1000),
        category VARCHAR(255),
        banner_image VARCHAR(500)
    )";
    mysqli_query($conn, $createTableQuery);
}

// creating users table to store user

$lowerTableName = 'users';

$tableCheckQuery = "SHOW TABLES LIKE '$lowerTableName'";
$tableExistsResult = mysqli_query($conn, $tableCheckQuery);
$tableExists = mysqli_num_rows($tableExistsResult); 

if (!$tableExists) {
    $createTableQuery = "
    CREATE TABLE $lowerTableName (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL
    )";
    mysqli_query($conn, $createTableQuery);
}
?>
