<?php
$conn = new mysqli("localhost", "root", "", "db_name");
if ($conn->connect_error) die("Connection failed");

$id = $_POST['id'];
$status = $_POST['status'];

$conn->query("UPDATE orders SET status='$status' WHERE id=$id");
$conn->close();

header("Location: admin_panel.php");
exit();
