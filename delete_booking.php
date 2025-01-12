<?php
session_start();

// Ensure only logged-in admin can access
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Check if the booking ID is provided
if (isset($_GET['id'])) {
    $bookingId = $_GET['id'];

    // Prepare the SQL DELETE query to remove the booking from the database
    $sql = "DELETE FROM bookings WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the booking ID parameter
        $stmt->bind_param("i", $bookingId);

        // Execute the query
        if ($stmt->execute()) {
            // Successfully deleted the booking
            echo "Booking deleted successfully.";
            header("Location: admin.php"); // Redirect to the admin panel after successful deletion
            exit;
        } else {
            // Error executing query
            echo "Error: Unable to delete the booking.";
        }
    } else {
        echo "Error: Could not prepare the delete statement.";
    }

    // Close the prepared statement and the database connection
    $stmt->close();
} else {
    // If no ID is provided, redirect back to the admin panel
    header("Location: admin.php");
    exit;
}

$conn->close();
?>
