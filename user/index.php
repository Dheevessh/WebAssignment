<?php
include 'includes/db.php';

$query = "SELECT * FROM movies";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Booking System</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>
    <header>
        <div class="navbar">
            <h1>Cinema Booking</h1>
            <div class="auth-buttons">
                <a href="user/login.php" class="btn">Login</a>
                <a href="user/register.php" class="btn">Register</a>
            </div>
        </div>
    </header>
    <main>
        <section class="movies">
            <h2>Now Showing</h2>
            <div class="movie-grid">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="movie-card">
                        <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['title']; ?>">
                        <h3><?php echo $row['title']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                        <a href="book.php?movie_id=<?php echo $row['id']; ?>" class="btn">Book Now</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>
</body>
</html>