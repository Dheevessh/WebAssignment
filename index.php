<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Booking System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="logo">CinemaHub</h1>
            <nav>
                <button class="btn" onclick="window.location.href='login.php';">Login</button>
                <button class="btn" onclick="window.location.href='register.php';">Register</button>
            </nav>
        </div>
    </header>

    <main>
        <!-- Section to display movies -->
        <section class="movie-section">
            <h2>Available Movies</h2>
            <div class="movie-list">
                <div class="movie-item" data-movie="Avengers">
                    <img src="images/avengers.jpg" alt="Avengers" class="movie-btn">
                    <h3>Avengers</h3>
                </div>
                <div class="movie-item" data-movie="Inception">
                    <img src="images/inception.jpg" alt="Inception" class="movie-btn">
                    <h3>Inception</h3>
                </div>
                <div class="movie-item" data-movie="Titanic">
                    <img src="images/titanic.jpg" alt="Titanic" class="movie-btn">
                    <h3>Titanic</h3>
                </div>
            </div>
        </section>

        <!-- Section for seat selection -->
        <section id="seat-selection-section" style="display: none;">
            <h2>Select Your Seats</h2>
            <div class="seat-grid">
                <!-- Dynamically created grid of seats -->
            </div>
            <button id="next-to-menu" class="btn" disabled>Next</button>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 CinemaHub. All rights reserved.</p>
    </footer>
</body>
</html>
