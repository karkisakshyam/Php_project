<?php
session_start();
include '../db.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = 'user';
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $location = $_POST['location'];

    // Check if email exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $error = "Already registered. Redirecting to login...";
        header("refresh:2;url=login.php");
    } else {
        $stmt = $conn->prepare("INSERT INTO users (role, email, password, location) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $role, $email, $password, $location);

        if ($stmt->execute()) {
            $_SESSION['client'] = $email;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Something went wrong. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Register</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
<form method="POST" class="form-container">
    <h2>Client Register</h2>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="location" placeholder="Location" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</form>
</body>
</html>