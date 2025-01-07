<?php
include 'db.php';

$sql = "SELECT * FROM bookings";
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
                <th>Snacks</th>
                <th>Payment</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user']; ?></td>
                <td><?php echo $row['movie']; ?></td>
                <td><?php echo $row['seats']; ?></td>
                <td><?php echo $row['snacks']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><a href="delete_booking.php?id=<?php echo $row['id']; ?>">Cancel</a></td>
            </tr>
            <?php } ?>
        </table>
    <
