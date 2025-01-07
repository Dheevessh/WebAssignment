<?php include('includes/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Book Movie</title>
</head>
<body>
    <header>
        <div class="container">
            <h1>Book Your Seat</h1>
        </div>
    </header>
    <main>
        <form action="book.php" method="post">
            <label for="movie">Select Movie:</label>
            <select name="movie" id="movie">
                <?php
                $result = $conn->query("SELECT * FROM movies");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['title']}</option>";
                }
                ?>
            </select>
            <label for="time">Select Time:</label>
            <input type="time" name="time" id="time" required>
            <label for="seats">Select Seats:</label>
            <input type="number" name="seats" id="seats" min="1" max="10" required>
            <button type="submit">Book Now</button>
        </form>
    </main>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movie = $_POST['movie'];
    $time = $_POST['time'];
    $seats = $_POST['seats'];

    $stmt = $conn->prepare("INSERT INTO bookings (movie_id, time, seats) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $movie, $time, $seats);
    $stmt->execute();

    echo "Booking successful!";
}
?>
