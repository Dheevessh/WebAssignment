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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';

    // Retrieve form inputs
    $movie = $_POST['movie'];
    $time = $_POST['time'];
    $people = $_POST['people'];
    $selectedSeats = $_POST['selected-seats'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session

    // Prepare and bind statement
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, movie, time, people, seats) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $user_id, $movie, $time, $people, $selectedSeats);

    // Execute and handle the result
    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CinemaHub - Movies</title>
    <link rel="stylesheet" href="styles1.css">
    <script src="script.js" defer></script>
    <style>
        .hidden { display: none; }
        .selected { background-color: #4caf50; color: white; }
        .seat { width: 30px; height: 30px; border: 1px solid #ccc; margin: 5px; text-align: center; cursor: pointer; }
        .seat.selected { background-color: #4caf50; color: white; }
        .time-slot { cursor: pointer; padding: 10px; border: 1px solid #ccc; border-radius: 20px; margin: 5px; display: inline-block; }
        .time-slot.selected { background-color: #4caf50; color: white; }
    </style>
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
    <button class="btn" onclick="window.location.href='contact.php';">Contact Us</button>
</nav>
    </header>

    <main>
        <section class="movie-section">
            <h2>Available Movies</h2>
            <div class="movie-list">
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
        <input type="hidden" name="movie" id="selected-movie" value="">
    <input type="hidden" name="time" id="selected-time" value="">
    <input type="hidden" name="selected-seats" id="selected-seats" value="">
    <input type="hidden" name="people" id="people" value="">

    
        <h3>Available Time Slots:</h3>
        <div class="time-bubbles">
            <span class="time-slot" id="time-1" onclick="selectTime('10:00 AM', 1)">10:00 AM</span>
            <span class="time-slot" id="time-2" onclick="selectTime('01:00 PM', 2)">01:00 PM</span>
            <span class="time-slot" id="time-3" onclick="selectTime('04:00 PM', 3)">04:00 PM</span>
            <span class="time-slot" id="time-4" onclick="selectTime('07:00 PM', 4)">07:00 PM</span>
        </div>
        <input type="hidden" name="time" id="selected-time" required>

        <label for="people">Number of People:</label>
        <input type="number" name="people" id="people" min="1" max="10" required readonly>

        <h3>Select Seats:</h3>
        <div class="seat-map">
            <?php
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

            // Show seat-selection section
            document.getElementById('seat-selection').classList.remove('hidden');
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

            // Update people count
            document.getElementById('people').value = selectedSeats.length;
        }
    </script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<section id="contact" class="section">
        <h2>Contact Me</h2>
		<p>Feel free to reach out to me via the form below or connect on :</p>
            <div class="social-icons">
                <a href="https://www.facebook.com/share/JrjZpezD3VM854bg/" class="social-button facebook"><i class="fab fa-facebook"></i> Facebook</a>
                <a href="https://x.com/nyetafiq" class="social-button twitter"><i class="fab fa-twitter"></i> Twitter</a>
                <a href="https://www.instagram.com/think.about_hazz?igsh=MXZxbGc2MWg2bTRwZw==" class="social-button instagram"><i class="fab fa-instagram"></i> Instagram</a>
                <a href="https://wa.link/slsumm" class="social-button whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            </div>
    </section>


</body>
</html>
