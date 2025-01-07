<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CinemaHub - Welcome</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="logo">CinemaHub</h1>
        </div>
    </header>

    <main>
        <!-- Welcome Section -->
        <section class="welcome-section">
            <h2>Welcome to CinemaHub</h2>
            <p>Experience the best cinema experience with easy ticket booking, snack selection, and seamless seat selection.</p>
            <div class="options">
                <button class="btn" onclick="window.location.href='login.php';">Login</button>
                <button class="btn" onclick="window.location.href='register.php';">Register</button>
                <button class="btn" onclick="window.location.href='movies.php';">Proceed as Guest</button>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 CinemaHub. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
session_start();
$_SESSION['guest'] = true;
header("Location: movies.php");
?>