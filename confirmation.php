<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Check if the success parameter is set in the URL
$success = $_GET['success'] ?? null;

// If no success parameter, redirect to the movies page
if ($success !== '1') {
    header("Location: movies.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - CinemaHub</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="logo">CinemaHub</h1>
        </div>
    </header>

    <main>
        <section class="confirmation-section">
            <h2>Thank You!</h2>
            <p>Your booking and payment were successful.</p>
            <p>We look forward to welcoming you to CinemaHub!</p>
            <button class="btn" onclick="window.location.href='movies.php';">Back to Movies</button>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 CinemaHub. All rights reserved.</p>
    </footer>
</body>
</html>
