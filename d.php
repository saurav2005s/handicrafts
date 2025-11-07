 <?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
    $username = $_SESSION['username'];
}
?>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <p>This is your dashboard.</p>
    <a href="logout.php">Logout</a>
</body>
</html>  -->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard | E-Commerce Admin</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
    }

    header {
      background-color: #0d6efd;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .container {
      padding: 20px;
    }

    .summary-cards {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background-color: white;
      flex: 1;
      min-width: 200px;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      text-align: center;
    }

    .card h3 {
      margin-bottom: 10px;
      color: #333;
    }

    .card p {
      font-size: 24px;
      font-weight: bold;
      color: #0d6efd;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #f0f0f0;
    }

    th {
      background-color: #f5f5f5;
    }

    .logout {
      margin-top: 20px;
      text-align: center;
    }

    .logout a {
      color: #fff;
      background-color: #dc3545;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
    }

    nav {
      background-color: #e9ecef;
      padding: 10px 20px;
    }

    nav a {
      margin-right: 20px;
      text-decoration: none;
      color: #333;
      font-weight: bold;
    }

    nav a:hover {
      color: #0d6efd;
    }
  </style>
</head>
<body>

<header>
  <h1>Welcome, <?php echo $_SESSION['username']; ?>👋</h1>
  <p>Here’s a snapshot of your e-commerce business</p>
</header>

<nav>
  <a href="#">Dashboard</a>
  <a href="#">Orders</a>
  <a href="#">Products</a>
  <a href="#">Customers</a>
  <a href="#">Reports</a>
</nav>

<div class="container">

  <div class="summary-cards">
    <div class="card">
      <h3>Total Orders</h3>
      <p>245</p>
    </div>
    <div class="card">
      <h3>Total Revenue</h3>
      <p>₹1,25,000</p>
    </div>
    <div class="card">
      <h3>Products</h3>
      <p>82</p>
    </div>
    <div class="card">
      <h3>Customers</h3>
      <p>154</p>
    </div>
  </div>

  <h2>Recent Orders</h2>
  <table>
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Status</th>
        <th>Amount</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>#1001</td>
        <td>John Doe</td>
        <td>Delivered</td>
        <td>₹1,200</td>
        <td>2025-06-10</td>
      </tr>
      <tr>
        <td>#1002</td>
        <td>Jane Smith</td>
        <td>Pending</td>
        <td>₹980</td>
        <td>2025-06-09</td>
      </tr>
      <tr>
        <td>#1003</td>
        <td>Rahul Kumar</td>
        <td>Shipped</td>
        <td>₹2,100</td>
        <td>2025-06-08</td>
      </tr>
    </tbody>
  </table>

  <div class="logout">
    <a href="logout.php">Logout</a>
  </div>

</div>

</body>
</html>
