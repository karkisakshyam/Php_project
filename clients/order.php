<?php
session_start();
include '../db.php';
if (!isset($_SESSION['client']))
    header("Location: login.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fi = $_POST['food_item'];
    $uid = $_SESSION['client'];
    $stmt = $conn->prepare("INSERT INTO orders(user_id,food_item) VALUES(?,?)");
    $stmt->bind_param("is", $uid, $fi);
    $stmt->execute();
    header("Location: thankyou.php");
    exit;
}