<?php
session_start();

// Ensure only logged-in admin can access
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Query to fetch all booking data with user details
$sql = "
    SELECT b.id, u.username AS user, b.movie, b.time, b.seats, b.total_price, b.payment_method
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
    <title>Admin Panel - CinemaHub</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        header {
            background-color: #343a40;
            color: white;
            padding: 1rem 2rem;
            text-align: center;
        }

        main {
            padding: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background-color: white;
        }

        table th, table td {
            padding: 1rem;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        table th {
            background-color: #6c757d;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #dc3545;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn-logout {
            margin-top: 1rem;
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }
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
                <th>Actions</th>
            </tr>
            <?php
            // Loop through each row and display the data in a table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['user']); ?></td>
                <td><?php echo htmlspecialchars($row['movie']); ?></td>
                <td><?php echo htmlspecialchars($row['time']); ?></td>
                <td><?php echo htmlspecialchars($row['seats']); ?></td>
                <td><?php echo "$" . number_format($row['total_price'], 2); ?></td>
                <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                <td><a href="delete_booking.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a></td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='8'>No bookings found.</td></tr>";
            }
            ?>
        </table>
    </main>
</body>
</html>
