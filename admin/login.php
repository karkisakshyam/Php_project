<?php
session_start(); include '../db.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
  $e=$_POST['email']; $pw=$_POST['password'];
  $r=$conn->query("SELECT * FROM users WHERE email='$e' AND role='admin'");
  $u=$r->fetch_assoc() ?? null;
  if($u && password_verify($pw,$u['password'])){
    $_SESSION['admin']=$u['id'];
    header("Location: dashboard.php"); exit;
  } else $error="Invalid email/password";
}
?>
<!doctype html><html><head><title>Admin Login</title>
<link rel="stylesheet" href="../css/style.css"></head><body>
<form><h2>Admin Login</h2>
<?php if(!empty($error)) echo "<p class='error'>$error</p>"; ?>
<input name="email" type="email" placeholder="Email" required>
<input name="password" type="password" placeholder="Password" required>
<button>Login</button>
<p>No account? <a href="register.php">Register here</a></p>
</form></body></html>