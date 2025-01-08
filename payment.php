<?php
session_start();
include 'db.php'; // Include the database connection

// Check if the form is submitted
if (isset($_POST['payment_complete'])) {
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
    $people = $_POST['people'] ?? 0;
    $seats = $_POST['selected-seats'] ?? '';
    $paymentMethod = $_POST['payment_method'] ?? '';

    // Calculate total price and snacks cost (example calculation logic)
    $popcorn = $_POST['popcorn'] ?? 0;
    $soda = $_POST['soda'] ?? 0;
    $nachos = $_POST['nachos'] ?? 0;
    $totalSnacksCost = ($popcorn * 5) + ($soda * 3) + ($nachos * 4);
    $seatCost = 10;
    $totalSeatCost = $people * $seatCost;
    $totalPrice = $totalSnacksCost + $totalSeatCost;

    // Insert the booking into the database
    $paymentMethod = $_POST['payment_method'] ?? '';

    $sql = "INSERT INTO bookings (user_id, movie, time, people, seats, total_price, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issiiis", $userId, $movie, $time, $people, $seats, $totalPrice, $paymentMethod);
    
    $stmt->execute();

    if ($stmt->execute()) {
        $paymentSuccess = true;
        // Redirect to a confirmation page or display a success message
        header("Location: confirmation.php?success=1");
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }
}

?>

<!-- HTML for the payment form -->
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
