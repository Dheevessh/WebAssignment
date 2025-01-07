<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = 1; // Replace with session user ID
    $showtime_id = $_POST['showtime_id'];
    $seats = $_POST['seats'];
    $price_per_seat = 10.00; // Example price
    $total_price = $seats * $price_per_seat;

    $query = "INSERT INTO bookings (user_id, showtime_id, seats, total_price, payment_status) VALUES (?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iiid', $user_id, $showtime_id, $seats, $total_price);
    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$movie_id = $_GET['movie_id'];
$query = "SELECT * FROM showtimes WHERE movie_id = $movie_id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Tickets</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <form method="POST">
        <label for="showtime">Select Showtime:</label>
        <select name="showtime_id" id="showtime" required>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['show_date'] . ' - ' . $row['show_time']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <label for="seats">Number of Seats:</label>
        <input type="number" name="seats" id="seats" min="1" required>
        <button type="submit" class="btn">Confirm Booking</button>
    </form>
</body>
</html>