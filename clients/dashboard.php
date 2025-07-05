<?php
session_start();
include '../db.php';

if (!isset($_SESSION['client'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['client'];

// Fetch all orders
$stmt = $conn->prepare("SELECT food_item, order_time, estimated_time FROM orders WHERE user_email = ? ORDER BY order_time DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="../css/C.dashboard.css">
</head>
<body>
<nav>
    <img src="../img/logo.png" alt="Logo" height="40">
    <div class="nav-right">
        <a href="dashboard.php">Dashboard</a>
        <a href="order.php">Place Order</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<h2>Welcome to Blue Heaven</h2>

<section>
    <h3>Your Orders</h3>
    <table>
        <tr><th>Food Item</th><th>Order Time</th><th>ETA</th><th>Action</th></tr>
        <?php while ($row = $orders->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['food_item']) ?></td>
                <td><?= $row['order_time'] ?></td>
                <td><?= $row['estimated_time'] ?></td>
                <td><a href="delete_order.php?id=<?= $row['id'] ?>">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</section>
</body>
</html>