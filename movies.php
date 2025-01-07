<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit;
}

// Check if the user is logged in or proceeding as a guest
$isLoggedIn = isset($_SESSION['user']);
$isGuest = isset($_SESSION['guest']) && $_SESSION['guest'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CinemaHub - Movies</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="logo">CinemaHub</h1>
            <nav>
                <?php if ($isLoggedIn): ?>
                    <p>Welcome, <?php echo $_SESSION['user']; ?>!</p>
                    <button class="btn" onclick="window.location.href='logout.php';">Logout</button>
                <?php elseif ($isGuest): ?>
                    <button class="btn" onclick="window.location.href='login.php';">Login</button>
                    <button class="btn" onclick="window.location.href='register.php';">Register</button>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <section class="movie-section">
            <h2>Available Movies</h2>
            <div class="movie-list">
                <!-- Example movies (these can be dynamically loaded later) -->
                <?php
                $movies = ["Movie 1", "Movie 2", "Movie 3", "Movie 4", "Movie 5"];
                foreach ($movies as $movie) {
                    echo "
                        <div class='movie-item'>
                            <img src='{$movie}.jpg' alt='{$movie}' class='movie-poster' onclick='selectMovie(\"{$movie}\", this)'>
                            <h3>{$movie}</h3>
                        </div>
                    ";
                }
                ?>
            </div>
        </section>

        <section id="seat-selection" class="hidden">
            <h2>Select Your Show</h2>
            <form id="booking-form" action="menu.php" method="POST">
                <input type="hidden" name="movie" id="selected-movie" value="">
                <input type="hidden" name="showtime_id" id="selected-showtime-id" value="">

                <h3>Available Time Slots:</h3>
                <div class="time-bubbles">
                    <span class="time-slot" id="time-1" onclick="selectTime('10:00 AM', 1)">10:00 AM</span>
                    <span class="time-slot" id="time-2" onclick="selectTime('01:00 PM', 2)">01:00 PM</span>
                    <span class="time-slot" id="time-3" onclick="selectTime('04:00 PM', 3)">04:00 PM</span>
                    <span class="time-slot" id="time-4" onclick="selectTime('07:00 PM', 4)">07:00 PM</span>
                </div>
                <input type="hidden" name="time" id="selected-time" required>

                <label for="people">Number of People:</label>
                <input type="number" name="people" id="people" min="1" max="10" required>

                <h3>Select Seats:</h3>
                <div class="seat-map">
                    <?php
                    // Render a 10x5 grid of seats
                    for ($row = 1; $row <= 10; $row++) {
                        echo '<div class="seat-row">';
                        for ($col = 1; $col <= 5; $col++) {
                            $seatId = chr(64 + $row) . $col; // Seat IDs like A1, B1, etc.
                            echo "<div class='seat available' id='$seatId' onclick='selectSeat(\"$seatId\")'>$seatId</div>";
                        }
                        echo '</div>';
                    }
                    ?>
                </div>

                <input type="hidden" name="selected-seats" id="selected-seats" required>

                <button type="submit">Next</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 CinemaHub. All rights reserved.</p>
    </footer>

    <script>
        let selectedSeats = [];
        let selectedTime = "";
        let selectedMovie = "";
        let showtimeId = "";

        function selectMovie(movie, element) {
            selectedMovie = movie;
            document.getElementById('selected-movie').value = movie;
            
            // Remove previously selected movie styling
            const movieItems = document.querySelectorAll('.movie-item');
            movieItems.forEach(item => item.classList.remove('selected'));

            // Apply new selection styling
            element.closest('.movie-item').classList.add('selected');
            alert(`You selected ${movie}`);
        }

        function selectTime(time, id) {
            selectedTime = time;
            showtimeId = id;
            document.getElementById('selected-time').value = time;
            document.getElementById('selected-showtime-id').value = showtimeId;

            // Remove previously selected showtime styling
            const timeSlots = document.querySelectorAll('.time-slot');
            timeSlots.forEach(slot => slot.classList.remove('selected'));

            // Apply new selection styling
            document.getElementById(`time-${id}`).classList.add('selected');
            alert(`You selected ${time}`);
        }

        function selectSeat(seatId) {
            const seat = document.getElementById(seatId);
            if (selectedSeats.includes(seatId)) {
                // Deselect seat
                selectedSeats = selectedSeats.filter(s => s !== seatId);
                seat.classList.remove('selected');
            } else {
                // Select seat
                selectedSeats.push(seatId);
                seat.classList.add('selected');
            }
            document.getElementById('selected-seats').value = selectedSeats.join(', ');
        }
    </script>
</body>
</html>
