<?php
include '../db.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
  $u=$_POST['username']; $e=$_POST['email'];
  $p=password_hash($_POST['password'],PASSWORD_DEFAULT);
  $stmt=$conn->prepare("INSERT INTO users(username,email,password,role) VALUES(?,?,?,'admin')");
  $stmt->bind_param("sss",$u,$e,$p); $stmt->execute();
  header("Location: login.php"); exit;
}
?>
<!doctype html>
<html><head><title>Admin Register</title>
<link rel="stylesheet" href="../css/style.css"></head><body>
<form><h2>Admin Register</h2>
<input name="username" placeholder="Username" required>
<input name="email" type="email" placeholder="Email" required>
<input name="password" type="password" placeholder="Password" required>
<button type="submit">Register</button>
<p>Have account? <a href="login.php">Login here</a></p>
</form></body></html>