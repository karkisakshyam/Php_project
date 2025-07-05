<?php
session_start();
include '../db.php';

if (!isset($_SESSION['client'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['client'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $food = $_POST['food_item'];
    $eta = "30-45 minutes";

    $stmt = $conn->prepare("INSERT INTO orders (user_email, food_item, estimated_time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $food, $eta);
    $stmt->execute();

    header("Location: thankyou.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Place Order</title>
    <link rel="stylesheet" href="../css/C.dashboard.css">
</head>
<body>
<form method="POST" class="form-container">
    <h2>Select Food Item</h2>
    <select name="food_item" required>
        <option value="">-- Select --</option>
        <option value="Pizza">Pizza</option>
        <option value="Burger">Burger</option>
        <option value="Mo:Mo">Mo:Mo</option>
        <option value="Fried Rice">Fried Rice</option>
    </select>
    <button type="submit">Confirm Order</button>
</form>
</body>
</html>