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
    <link rel="stylesheet" href="menu.css">
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
                    <img src="popcorn.jpg" alt="Popcorn" class="snack-image">
                    <label for="popcorn">Popcorn (RM5)</label>
                    <div class="snack-quantity">
                        <input type="number" name="popcorn" id="popcorn" value="0" min="0" class="snack-amount" required>
                    </div>
                </div>

                <div class="menu-item">
                    <img src="images/soda.jpg" alt="Soda" class="snack-image">
                    <label for="soda">Soda (RM3)</label>
                    <div class="snack-quantity">
                        <input type="number" name="soda" id="soda" value="0" min="0" class="snack-amount" required>
                    </div>
                </div>

                <div class="menu-item">
                    <img src="images/nachos.jpg" alt="Nachos" class="snack-image">
                    <label for="nachos">Nachos (RM4)</label>
                    <div class="snack-quantity">
                        <input type="number" name="nachos" id="nachos" value="0" min="0" class="snack-amount" required>
                    </div>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn">Proceed to Payment</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 CinemaHub. All rights reserved.</p>
    </footer>

    <script>
        // JavaScript to handle snack quantity changes
        document.getElementById('popcorn-plus').addEventListener('click', function() {
            var input = document.getElementById('popcorn');
            var value = parseInt(input.value);
            if (value < 10) input.value = value + 1;
        });

        document.getElementById('popcorn-minus').addEventListener('click', function() {
            var input = document.getElementById('popcorn');
            var value = parseInt(input.value);
            if (value > 0) input.value = value - 1;
        });

        document.getElementById('soda-plus').addEventListener('click', function() {
            var input = document.getElementById('soda');
            var value = parseInt(input.value);
            if (value < 10) input.value = value + 1;
        });

        document.getElementById('soda-minus').addEventListener('click', function() {
            var input = document.getElementById('soda');
            var value = parseInt(input.value);
            if (value > 0) input.value = value - 1;
        });

        document.getElementById('nachos-plus').addEventListener('click', function() {
            var input = document.getElementById('nachos');
            var value = parseInt(input.value);
            if (value < 10) input.value = value + 1;
        });

        document.getElementById('nachos-minus').addEventListener('click', function() {
            var input = document.getElementById('nachos');
            var value = parseInt(input.value);
            if (value > 0) input.value = value - 1;
        });
    </script>
</body>
</html>