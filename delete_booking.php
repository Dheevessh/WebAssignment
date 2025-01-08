<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID

    // Delete the record from the database
    $sql = "DELETE FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin.php?message=Booking deleted successfully.");
        exit;
    } else {
        echo "Error deleting booking: " . $conn->error;
    }
} else {
    header("Location: admin.php");
    exit;
}
?>
