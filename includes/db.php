<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Replace with your MySQL password if set
$database = 'cinema_booking';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
