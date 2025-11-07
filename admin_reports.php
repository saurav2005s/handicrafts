<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_name";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Total Orders
$totalOrders = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];

// Payment method count
$codOrders = $conn->query("SELECT COUNT(*) AS cod FROM orders WHERE payment_method='cod'")->fetch_assoc()['cod'];

// Delivery status (if column exists)
$delivered = $conn->query("SELECT COUNT(*) AS delivered FROM orders WHERE delivery_status='delivered'")->fetch_assoc()['delivered'];

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Reports</title>
  <style>
    body {
      background: #eef2f7;
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    .card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      padding: 20px;
      margin: 10px auto;
      max-width: 600px;
    }
    h2 {
      text-align: center;
      color: #333;
    }
    .stat {
      font-size: 1.2em;
      margin: 10px 0;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>📈 Reports Overview</h2>
    <div class="stat">Total Orders: <strong><?= $totalOrders ?></strong></div>
    <div class="stat">Cash on Delivery Orders: <strong><?= $codOrders ?></strong></div>
    <div class="stat">Delivered Orders: <strong><?= $delivered ?></strong></div>
  </div>
</body>
</html>
