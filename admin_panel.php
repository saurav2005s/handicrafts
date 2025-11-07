<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "db_name");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orders = $conn->query("SELECT * FROM orders");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f1f5f9;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    .logout-container {
      margin-top: auto;
      text-align: center;
      padding: 20px 0;
    }

    .logout-btn {
      display: inline-block;
      color: #fff;
      background-color: #dc3545;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 30px;
      background: #fff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 12px 16px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #007bff;
      color: white;
      text-transform: uppercase;
      font-size: 14px;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    select, button {
      padding: 6px 10px;
      border-radius: 4px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    button {
      background-color: #28a745;
      color: white;
      border: none;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #218838;
    }

    .inline {
      display: flex;
      gap: 5px;
      align-items: center;
    }

    form.inline {
      display: inline-flex;
      align-items: center;
    }

    .delete-btn {
      background-color: #dc3545;
    }

    .delete-btn:hover {
      background-color: #c82333;
    }
  </style>
</head>
<body>

  <h2>📋 Admin Order Management</h2>

  <table>
    <tr>
      <th>Order ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Product</th>
      <th>Address</th>
      <th>Payment</th>
      <th>Delivery Status</th>
      <th>Action</th>
    </tr>
    <?php while ($row = $orders->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['email'] ?></td>
      <td><?= $row['order'] ?></td>
      <td><?= $row['address'] ?></td>
      <td><?= ucfirst($row['payment_method']) ?></td>
      <td>
        <form class="inline" method="post" action="update_status.php">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <select name="status">
            <option <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option <?= $row['status'] === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
            <option <?= $row['status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
          </select>
          <button type="submit">Update</button>
        </form>
      </td>
      <td>
        <form class="inline" method="post" action="delete_order.php">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <button type="submit" class="delete-btn" onclick="return confirm('Delete this order?')">Delete</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>

  <div class="logout-container">
    <a href="home.html" class="logout-btn">Logout</a>
  </div>

</body>
</html>
