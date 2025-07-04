<?php
session_start();
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $_SESSION['client'] = $email;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid user login.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<form method="POST">
    <h2>Client Login</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</form>
</body>
</html>