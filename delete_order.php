<?php
$conn = new mysqli("localhost", "root", "", "db_name");
if ($conn->connect_error) die("Connection failed");

$id = $_POST['id'];
$conn->query("DELETE FROM orders WHERE id=$id");
$conn->close();

header("Location: admin_panel.php");
exit();
