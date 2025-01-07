<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cinema_booking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Return the connection if needed elsewhere
// return $conn;
?>
