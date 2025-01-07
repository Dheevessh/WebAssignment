<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack Menu</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Select Your Snacks</h1>
    </header>
    <main>
        <form action="payment.php" method="POST">
            <label>
                <input type="checkbox" name="snacks[]" value="Popcorn"> Popcorn
            </label>
            <label>
                <input type="checkbox" name="snacks[]" value="Soda"> Soda
            </label>
            <label>
                <input type="checkbox" name="snacks[]" value="Nachos"> Nachos
            </label>
            <label>
                <input type="checkbox" name="snacks[]" value="Candy"> Candy
