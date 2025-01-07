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
    <title>Movies</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <h1>Welcome to Our Cinema!</h1>
        <a href="logout.php" class="btn">Logout</a>
    </header>
    <main>
        <div class="movie-list">
            <div class="movie-item" data-movie="Avengers: Endgame">
                <img src="endgame.jpg" alt="Avengers: Endgame">
                <h3>Avengers: Endgame</h3>
            </div>
            <div class="movie-item" data-movie="Inception">
                <img src="inception.jpg" alt="Inception">
                <h3>Inception</h3>
            </div>
        </div>
    </main>
</body>
</html>
