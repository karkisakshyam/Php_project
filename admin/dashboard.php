<?php
session_start(); include '../db.php';
if(!isset($_SESSION['admin'])) header("Location: login.php");
$result = $conn->query("
SELECT u.username,u.address,o.food_item,o.order_time
FROM orders o JOIN users u ON o.user_id=u.id
ORDER BY o.order_time DESC
");
?>
<!doctype html><html><head><title>Admin Dashboard</title>
<link rel="stylesheet" href="../css/style.css"></head><body>
<nav><a href="dashboard.php">Dashboard</a><a href="../admin/login.php?logout=1">Logout</a></nav>
<h2>Admin Dashboard</h2>
<table><thead><tr>
<th>Customer</th><th>Address</th><th>Food</th><th>Ordered At</th></tr></thead><tbody>
<?php while($r=$result->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($r['username']) ?></td>
<td><?= htmlspecialchars($r['address']) ?></td>
<td><?= htmlspecialchars($r['food_item']) ?></td>
<td><?= $r['order_time'] ?></td>
</tr>
<?php endwhile; ?>
</tbody></table></body></html>