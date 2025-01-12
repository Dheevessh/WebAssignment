<?php 
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$isLoggedIn = isset($_SESSION['user']);
$isGuest = isset($_SESSION['guest']) && $_SESSION['guest'] === true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';

    $movie = $_POST['movie'];
    $time = $_POST['time'];
    $people = $_POST['people'];
    $selectedSeats = $_POST['selected-seats'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, movie, time, people, seats) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $user_id, $movie, $time, $people, $selectedSeats);

    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

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
        .seat { 
            width: 30px; 
            height: 30px; 
            border: 1px solid #ccc; 
            margin: 5px; 
            text-align: center; 
            cursor: pointer; 
        }
        .seat.selected { background-color: #4caf50; color: white; }
        .seat.unavailable { background-color: #d9534f; cursor: not-allowed; }
        .time-slot { 
            cursor: pointer; 
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 20px; 
            margin: 5px; 
            display: inline-block; 
        }
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
    </div>
</header>

<main>
    <section class="movie-section">
        <h2>Available Movies</h2>
        <div class="movie-list">
            <?php
            $movies = [
                "Inception" => "inception.jpg",
                "Avengers" => "avengers.jpg",
                "Moana" => "moana.jpg",
                "Coco" => "coco.jpg",
                "Interstellar" => "interstellar.jpg"
            ];
            foreach ($movies as $movie => $poster) {
                echo "
                    <div class='movie-item'>
                        <img src='{$poster}' alt='{$movie}' class='movie-poster' onclick='selectMovie(\"{$movie}\")'>
                        <h3>{$movie}</h3>
                    </div>
                ";
            }
            ?>
        </div>
    </section>

    <section id="seat-selection" class="hidden">
        <h2>Select Your Show</h2>
        <form id="booking-form" action="payment.php" method="POST">
            <input type="hidden" name="movie" id="selected-movie" value="">
            <input type="hidden" name="time" id="selected-time" value="">
            <input type="hidden" name="people" id="people" value="">
            <input type="hidden" name="selected-seats" id="selected-seats" value="">

            <h3>Available Time Slots:</h3>
            <div class="time-bubbles">
                <span class="time-slot" onclick="selectTime('10:00 AM')">10:00 AM</span>
                <span class="time-slot" onclick="selectTime('01:00 PM')">01:00 PM</span>
                <span class="time-slot" onclick="selectTime('04:00 PM')">04:00 PM</span>
                <span class="time-slot" onclick="selectTime('07:00 PM')">07:00 PM</span>
            </div>

            <label for="people-input">Number of People:</label>
            <input type="number" name="people" id="people-input" min="1" max="10" required>

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

            <button type="submit">Next</button>
        </form>
    </section>
</main>

<script>
function selectMovie(movie) {
    document.getElementById('selected-movie').value = movie;
    document.getElementById('seat-selection').classList.remove('hidden');
}

function selectTime(time) {
    document.getElementById('selected-time').value = time;
    // Add color change logic
    document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
    event.target.classList.add('selected');
}

function selectSeat(seatId) {
    const seatElement = document.getElementById(seatId);
    const selectedSeatsInput = document.getElementById('selected-seats');
    let currentSeats = selectedSeatsInput.value ? selectedSeatsInput.value.split(',') : [];

    if (currentSeats.includes(seatId)) {
        currentSeats = currentSeats.filter(seat => seat !== seatId);
        seatElement.classList.remove('selected');
    } else {
        currentSeats.push(seatId);
        seatElement.classList.add('selected');
    }

    selectedSeatsInput.value = currentSeats.join(',');
}

document.getElementById('people-input').addEventListener('input', function() {
    document.getElementById('people').value = this.value;
});
</script>

<footer>
    <p>&copy; 2025 CinemaHub. All rights reserved.</p>
</footer>
</body>
</html>
