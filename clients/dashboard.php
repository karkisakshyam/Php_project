<?php
session_start();
include '../db.php';
if (!isset($_SESSION['client'])) {
    header("Location: login.php");
    exit;
}
$uid = $_SESSION['client'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['food_item'])) {
    $food = $_POST['food_item'];
    $stmt = $conn->prepare("INSERT INTO orders (user_id, food_item) VALUES (?, ?)");
    $stmt->bind_param("is", $uid, $food);
    if ($stmt->execute()) {
        header("Location: thankyou.php");
        exit;
    } else {
        $error = "Failed to place order. Try again.";
    }
}

// Fetch past orders
$orders_res = $conn->query("SELECT food_item, order_time FROM orders WHERE user_id = $uid ORDER BY order_time DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="../css/C.dashboard.css" />
</head>

<body>
   <nav>
  <div class="nav-logo">
    <img src="../img/logo.png" alt="Logo" />
  </div>
  <div class="nav-links">
    <a href="dashboard.php">Home</a>
    <a href="#orders">My Orders</a>
    <a href="#">Details</a>
    <a href="../logout.php">Logout</a>
  </div>
</nav>

    <h2>Welcome to Blue Dinner</h2>

    <section class="menu">
        <div class="food-item"><img src="../img/Salami-pizza-hero.jpg" alt="Pizza" />
            <p>Pizza</p>
        </div>
        <div class="food-item"><img src="../img/images.jpeg" alt="Burger" />
            <p>Burger</p>
        </div>
        <div class="food-item"><img src="../img/pasta.jpeg" alt="Pasta" />
            <p>Pasta</p>
        </div>
        <div class="food-item"><img src="../img/momo.jpeg" alt="Momo" />
            <p>Momo</p>
        </div>
    </section>

    <section id="select-food">
        <form method="POST">
            <select name="food_item" required>
                <option value="" disabled selected>Select a food item</option>
                <option value="Pizza">Pizza</option>
                <option value="Burger">Burger</option>
                <option value="Pasta">Pasta</option>
                <option value="Momo">Momo</option>
            </select>
            <button type="submit">Place Order</button>
        </form>
        <?php if (!empty($error))
            echo "<p style='color:red;'>$error</p>"; ?>
    </section>

<section id="orders">
  <h3>Your Orders</h3>
  <ul>
    <?php
    $orders_res = $conn->query("SELECT id, food_item, order_time FROM orders WHERE user_id = $uid ORDER BY order_time DESC");
    while ($order = $orders_res->fetch_assoc()):
    ?>
      <li>
        <strong><?= htmlspecialchars($order['food_item']) ?></strong><br>
        Ordered at: <?= $order['order_time'] ?><br>
        <span class="eta">Estimated delivery: 30–45 minutes</span>
        <form method="POST" action="delete_order.php" style="display:inline;">
          <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
          <button type="submit" class="delete-btn">Delete</button>
        </form>
      </li>
    <?php endwhile; ?>
  </ul>
  </section>
</body>

</html>