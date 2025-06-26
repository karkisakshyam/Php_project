<?php
session_start();
if (!isset($_SESSION['client'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Thank You</title>
  <link rel="stylesheet" href="../css/thankyou.css" />
</head>
<body>
    <div class="thankyou-container">
  <nav>
    <a href="dashboard.php">Home</a>
    <a href="../logout.php">Logout</a>
  </nav>
  <h2>Thank you for your order!</h2>
  <p>Your delicious food is on the way 🚀</p>
  </div>
</body>
</html>