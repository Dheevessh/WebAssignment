<?php
session_start();

// Ensure only logged-in admin can access
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Query to fetch all booking data with movie and user details
$sql = "
    SELECT b.id, u.username AS user, b.movie, b.seats, b.snacks_cost, b.payment_method
    FROM bookings b
    JOIN users u ON b.user_id = u.id
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
    </header>
    <main>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Movie</th>
                <th>Seats</th>
                <th>Snacks Cost</th>
                <th>Payment Method</th>
                <th>Actions</th>
            </tr>
            <?php
            // Loop through each row and display the data in a table
            while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user']; ?></td>
                <td><?php echo $row['movie']; ?></td>
                <td><?php echo $row['seats']; ?></td>
                <td><?php echo "$" . number_format($row['snacks_cost'], 2); ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><a href="delete_booking.php?id=<?php echo $row['id']; ?>">Cancel</a></td>
            </tr>
            <?php
            }
            ?>
        </table>
    </main>
</body>
</html>
