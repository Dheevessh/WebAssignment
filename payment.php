<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Payment Method</h1>
    </header>
    <main>
        <form action="booking_handler.php" method="POST">
            <label>
                <input type="radio" name="payment_method" value="Credit Card" required> Credit Card
            </label>
            <label>
                <input type="radio" name="payment_method" value="PayPal" required> PayPal
            </label>
            <label>
                <input type="radio" name="payment_method" value="Cash" required> Cash
            </label>
            <button type="submit" class="btn">Complete Booking</button>
        </form>
    </main>
</body>
</html>
