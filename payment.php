<?php
session_start();
include 'db.php'; // Include the database connection

// Retrieve user_id from session
$userId = $_SESSION['user_id'] ?? null;

// If user_id is not found in the session, redirect to login page
if (!$userId) {
    header("Location: login.php");
    exit;
}

// Retrieve the booking details and snacks from the POST request
$movie = $_POST['movie'] ?? '';
$time = $_POST['time'] ?? '';
$people = $_POST['people'] ?? '';
$seats = (int)($_POST['seats'] ?? 0); // Ensure seats is an integer

// Retrieve snack quantities
$popcorn = (int)($_POST['popcorn'] ?? 0); // Ensure popcorn is an integer
$soda = (int)($_POST['soda'] ?? 0);       // Ensure soda is an integer
$nachos = (int)($_POST['nachos'] ?? 0);     // Ensure nachos is an integer

// Calculate total snacks cost
$popcornCost = $popcorn * 5;
$sodaCost = $soda * 3;
$nachosCost = $nachos * 4;
$totalSnacksCost = $popcornCost + $sodaCost + $nachosCost;

// Assume seat cost is $10 per person
$seatCost = 10;
$totalSeatCost = $seats * $seatCost;

// Calculate total price (seats + snacks)
$totalPrice = $totalSnacksCost + $totalSeatCost;

// Retrieve showtime_id based on the movie and time
$sqlShowtime = "SELECT id FROM showtimes WHERE show_time = ? AND movie_id = (SELECT id FROM movies WHERE title = ?)";
$stmtShowtime = $conn->prepare($sqlShowtime);
$stmtShowtime->bind_param("ss", $time, $movie);
$stmtShowtime->execute();
$resultShowtime = $stmtShowtime->get_result();

// Check if the showtime exists
if ($resultShowtime->num_rows > 0) {
    $showtime = $resultShowtime->fetch_assoc();
    $showtimeId = $showtime['id']; // Get the showtime_id

    // Handle form submission for payment
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_complete'])) {
        $paymentMethod = $_POST['payment_method'] ?? '';

        // Prepare SQL to insert booking data into the database
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, showtime_id, seats, movie, show_time, snacks_cost, payment_method, total_price, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("iiissdsd", $userId, $showtimeId, $seats, $movie, $time, $totalSnacksCost, $paymentMethod, $totalPrice);

        if ($stmt->execute()) {
            // Set flag for successful payment
            $paymentSuccess = true;
        } else {
            $error = "Error storing booking data!";
        }
    }
} else {
    $error = "Invalid movie or showtime!";
}
?>

<!-- HTML for the payment form (same as before) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CinemaHub - Payment</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // JavaScript to show pop-up if payment is successful
        window.onload = function() {
            <?php if (isset($paymentSuccess) && $paymentSuccess): ?>
                alert("Thank you for your purchase!");
            <?php endif; ?>
        };
    </script>
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="logo">CinemaHub</h1>
            <button class="btn" onclick="window.location.href='logout.php';">Logout</button>
        </div>
    </header>

    <main>
        <section class="confirmation-section">
            <h2>Payment Details</h2>
            <form method="POST">
                <h3>Booking Details:</h3>
                <ul>
                    <li><strong>Movie:</strong> <?php echo htmlspecialchars($movie); ?></li>
                    <li><strong>Showtime:</strong> <?php echo htmlspecialchars($time); ?></li>
                    <li><strong>Number of People:</strong> <?php echo htmlspecialchars($people); ?></li>
                    <li><strong>Seats:</strong> <?php echo htmlspecialchars($seats); ?></li>
                </ul>

                <h3>Snacks and Drinks:</h3>
                <ul>
                    <li><strong>Popcorn:</strong> <?php echo htmlspecialchars($popcorn); ?> x $5 = $<?php echo htmlspecialchars($popcornCost); ?></li>
                    <li><strong>Soda:</strong> <?php echo htmlspecialchars($soda); ?> x $3 = $<?php echo htmlspecialchars($sodaCost); ?></li>
                    <li><strong>Nachos:</strong> <?php echo htmlspecialchars($nachos); ?> x $4 = $<?php echo htmlspecialchars($nachosCost); ?></li>
                </ul>

                <h3>Total Cost:</h3>
                <p><strong>$<?php echo htmlspecialchars($totalPrice); ?></strong> (seats and snacks).</p>

                <h3>Select Payment Method:</h3>
                <input type="radio" id="online_banking" name="payment_method" value="Online Banking" required>
                <label for="online_banking">Online Banking</label><br>
                <input type="radio" id="card" name="payment_method" value="Card">
                <label for="card">Card</label><br>

                <button type="submit" name="payment_complete" class="btn">Payment Complete</button>
            </form>

            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

            <button class="btn" onclick="window.location.href='movies.php';">Back to Movies</button>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 CinemaHub. All rights reserved.</p>
    </footer>
</body>
</html>
