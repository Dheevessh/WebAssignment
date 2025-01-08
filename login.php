<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password are "admin"
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['user'] = $username;
        $_SESSION['user_id'] = 1;  // Setting a dummy user_id for the admin
        header("Location: admin.php"); // Redirect to admin panel
        exit;
    }

    // Check database for other users
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $username;
        $_SESSION['user_id'] = $user['id'];  // Assuming 'id' is the column storing the user ID
        header("Location: movies.php"); // Redirect to user dashboard
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
