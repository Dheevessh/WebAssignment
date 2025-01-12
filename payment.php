<?php
session_start();
include 'db.php'; // Include the database connection

if (isset($_POST['payment_complete'])) {
    // Ensure user is logged in
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        header("Location: login.php");
        exit;
    }

    // Retrieve form data
    $movie = $_POST['movie'] ?? '';
    $time = $_POST['time'] ?? '';
    $people = $_POST['people'] ?? 0;
    $seats = $_POST['selected-seats'] ?? '';
    $paymentMethod = $_POST['payment_method'] ?? '';

    // Snack quantities and cost calculations
    $popcorn = $_POST['popcorn'] ?? 0;
    $soda = $_POST['soda'] ?? 0;
    $nachos = $_POST['nachos'] ?? 0;
    $totalSnacksCost = $popcorn * 5 + $soda * 3 + $nachos * 4;

    // Calculate total cost (seats cost $10 per person)
    $totalSeatCost = $people * 10;
    $totalPrice = $totalSnacksCost + $totalSeatCost;

    // Insert booking details into the database (cinema_booking database)
    $sql = "INSERT INTO bookings 
    (user_id, movie, showtime, people, seats, total_price, payment_method, popcorn_qty, soda_qty, nachos_qty, snacks_cost) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
$stmt->bind_param("issisisiidi", 
    $userId, 
    $movie, 
    $time, 
    $people, 
    $seats, 
    $totalPrice, 
    $paymentMethod, 
    $popcorn, 
    $soda, 
    $nachos, 
    $totalSnacksCost
);

if ($stmt->execute()) {
    header("Location: confirmation.php?success=1");
    exit;
} else {
    echo "Error: Unable to process your payment. Please try again later.";
}
} else {
echo "Error: Could not prepare the statement.";
}


    // Close the statement and connection
    $stmt->close();
    $conn->close();
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
            <form method="POST" action="payment.php">
                <!-- Hidden inputs to pass booking details -->
                <input type="hidden" name="movie" value="<?php echo htmlspecialchars($_POST['movie'] ?? ''); ?>">
                <input type="hidden" name="time" value="<?php echo htmlspecialchars($_POST['time'] ?? ''); ?>">
                <input type="hidden" name="people" value="<?php echo htmlspecialchars($_POST['people'] ?? 0); ?>">
                <input type="hidden" name="selected-seats" value="<?php echo htmlspecialchars($_POST['selected-seats'] ?? ''); ?>">

                <!-- Snack selections (pre-filled) -->
                <h3>Selected Snacks:</h3>
                <p>Popcorn: <?php echo htmlspecialchars($_POST['popcorn'] ?? 0); ?></p>
                <p>Soda: <?php echo htmlspecialchars($_POST['soda'] ?? 0); ?></p>
                <p>Nachos: <?php echo htmlspecialchars($_POST['nachos'] ?? 0); ?></p>

                <!-- Payment Method selection -->
                <h3>Select Payment Method:</h3>
                <input type="radio" id="online_banking" name="payment_method" value="Online Banking" required>
                <label for="online_banking">Online Banking</label><br>
                <input type="radio" id="card" name="payment_method" value="Card">
                <label for="card">Card</label><br>

                <button type="submit" name="payment_complete" class="btn">Complete Payment</button>
            </form>
            <button class="btn" onclick="window.location.href='movies.php';">Back to Movies</button>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 CinemaHub. All rights reserved.</p>
    </footer>
</body>
</html>
