<?php 
session_start();

// Retrieve the booking details
$movie = htmlspecialchars($_POST['movie'] ?? '', ENT_QUOTES, 'UTF-8');
$time = htmlspecialchars($_POST['time'] ?? '', ENT_QUOTES, 'UTF-8');
$people = htmlspecialchars($_POST['people'] ?? '', ENT_QUOTES, 'UTF-8');
$seats = htmlspecialchars($_POST['selected-seats'] ?? '', ENT_QUOTES, 'UTF-8');
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
                <!-- Hidden inputs to pass booking details -->
                <input type="hidden" name="movie" value="<?php echo $movie; ?>">
                <input type="hidden" name="time" value="<?php echo $time; ?>">
                <input type="hidden" name="people" value="<?php echo $people; ?>">
                <input type="hidden" name="selected-seats" value="<?php echo $seats; ?>">

                <!-- Menu items for selecting snacks -->
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

                <!-- Submit button -->
                <button type="submit" class="btn">Proceed to Payment</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 CinemaHub. All rights reserved.</p>
    </footer>
</body>
</html>
