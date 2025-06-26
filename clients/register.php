<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // email cha ki chaina check garni
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // user already cha vanera popup msg dekhauni
        echo "<script>
                alert('User already registered!');
                window.location.href = 'login.php';
              </script>";
        exit; 
    }

    // new user create garni
    $stmt = $conn->prepare("INSERT INTO users(username, email, password, role, address) VALUES (?, ?, ?, 'client', ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $address);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!doctype html>
<html>

<head>
  <title>Client Register</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<form method="POST">
    <h2>Client Register</h2>
    <input name="username" placeholder="Username" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="address" placeholder="Delivery Address" required>
    <input name="password" type="password" placeholder="Password" required>
    <button>Register</button>
    <p>Have account? <a href="login.php">Login here</a></p>
  </form>
</body>

</html>