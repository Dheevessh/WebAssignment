<?php
session_start();

// Retrieve the booking details
$movie = $_POST['movie'] ?? '';
$time = $_POST['time'] ?? '';
$people = $_POST['people'] ?? '';
$seats = $_POST['selected-seats'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CinemaHub - Snacks Menu</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="logo">CinemaHub</h1>
            <button class="btn" onclick="window.location.href='logout.php';">Logout</button>
        </div>
    </header>

    <main>
        <section class="menu-section">
            <h2>Snacks and Drinks</h2>
            <form id="menu-form" action="payment.php" method="POST">
                <input type="hidden" name="movie" value="<?php echo $movie; ?>">
                <input type="hidden" name="time" value="<?php echo $time; ?>">
                <input type="hidden" name="people" value="<?php echo $people; ?>">
                <input type="hidden" name="seats" value="<?php echo $seats; ?>">

                <div class="menu-item">
                    <label for="popcorn">Popcorn:</label>
                    <input type="number" name="popcorn" id="popcorn" min="0" max="10" value="0">
                </div>
                <div class="menu-item">
                    <label for="soda">Soda:</label>
                    <input type="number" name="soda" id="soda" min="0" max="10" value="0">
                </div>
                <div class="menu-item">
                    <label for="nachos">Nachos:</label>
                    <input type="number" name="nachos" id="nachos" min="0" max="10" value="0">
                </div>

                <button type="submit">Proceed to Payment</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 CinemaHub. All rights reserved.</p>
    </footer>
</body>
</html>
