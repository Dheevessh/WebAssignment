<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie = $_POST['movie'];
    $time = $_POST['time'];
    $seats = $_POST['seats'];
    $seat_selection = $_POST['seat-selection'];

    $sql = "INSERT INTO bookings (movie, time, seats, seat_selection) VALUES ('$movie', '$time', '$seats', '$seat_selection')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}
?>
