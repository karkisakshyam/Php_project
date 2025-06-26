<?php
$host='localhost'; $user='root'; $pw=''; $db='project_heaven';
$conn = new mysqli($host,$user,$pw,$db);
if($conn->connect_error) die("DB Connection failed: ".$conn->connect_error);
?>