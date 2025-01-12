<?php
session_start();
include 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $enquiry = $_POST['enquiry'];

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, contact_number, enquiry) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $contact_number, $enquiry);

    if ($stmt->execute()) {
        echo "<script>alert('Thank you for contacting us! We will get back to you soon.'); window.location.href='index.php';</script>";
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
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact1.css">
</head>

<body>
    <header>
        <h1>Contact Us</h1>
    </header>
    <main>
        <form action="contact.php" method="POST" class="contact-form">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" required>

            <label for="enquiry">Your Enquiry:</label>
            <textarea id="enquiry" name="enquiry" rows="5" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2025 CinemaHub. All rights reserved.</p>
    </footer>
</body>

</html>
