<?php
session_start();

// Ensure only logged-in admin can access
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Query to fetch all booking data with user details
$bookings_sql = "
    SELECT b.booking_id, u.username, b.movie, b.showtime, b.seats, b.total_price, b.payment_method, b.popcorn_qty, b.soda_qty, b.nachos_qty, b.snacks_cost, b.created_at
    FROM bookings b
    JOIN users u ON b.user_id = u.user_id
";
$bookings_result = $conn->query($bookings_sql);

// Query to fetch all inquiries from the contacts table
$inquiries_sql = "
    SELECT id, name, email, contact_number, enquiry, submitted_at
    FROM contacts
";
$inquiries_result = $conn->query($inquiries_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="admin2.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - CinemaHub</title>
    <link rel="stylesheet" href="admin2.css">
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <button class="btn-logout" onclick="window.location.href='logout.php';">Logout</button>
    </header>
    <main>
        <h2>All Bookings</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Movie</th>
                <th>Showtime</th>
                <th>Seats</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Snacks (Popcorn, Soda, Nachos)</th>
                <th>Snacks Cost</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($bookings_result->num_rows > 0) {
                while ($row = $bookings_result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['movie']); ?></td>
                <td><?php echo htmlspecialchars($row['showtime']); ?></td>
                <td><?php echo htmlspecialchars($row['seats']); ?></td>
                <td><?php echo "$" . number_format($row['total_price'], 2); ?></td>
                <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                <td><?php echo "{$row['popcorn_qty']} / {$row['soda_qty']} / {$row['nachos_qty']}"; ?></td>
                <td><?php echo "$" . number_format($row['snacks_cost'], 2); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td><a href="delete_booking.php?id=<?php echo htmlspecialchars($row['booking_id']); ?>" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a></td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='11'>No bookings found.</td></tr>";
            }
            ?>
        </table>

        <h2>All Inquiries</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Enquiry</th>
                <th>Submitted At</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($inquiries_result->num_rows > 0) {
                while ($row = $inquiries_result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                <td><?php echo htmlspecialchars($row['enquiry']); ?></td>
                <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
                <td><a href="delete_inquiry.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this inquiry?');">Delete</a></td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='7'>No inquiries found.</td></tr>";
            }
            ?>
        </table>
    </main>
</body>
</html>
