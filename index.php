<?php include('includes/db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cinema Booking</title>
</head>
<body>
    <header>
        <div class="container">
            <h1>Cinema Booking</h1>
            <nav>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </nav>
        </div>
    </header>
    <main>
        <h2>Available Movies</h2>
        <div class="movies">
            <?php
            $result = $conn->query("SELECT * FROM movies");
            while ($row = $result->fetch_assoc()) {
                echo "<div class='movie'>";
                echo "<h3>{$row['title']}</h3>";
                echo "<p>{$row['description']}</p>";
                echo "<a href='book.php?id={$row['id']}'>Book Now</a>";
                echo "</div>";
            }
            ?>
        </div>
    </main>
    <script src="js/script.js"></script>
</body>
</html>
