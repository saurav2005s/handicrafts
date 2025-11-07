<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}
$email = $_SESSION['email'];
$conn = new mysqli("localhost", "root", "", "db_name");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, `order`, payment_method, address, delivery_status, payment_status, order_date
        FROM orders WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #eef2f5;
        }
        .dashboard {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        h2 {
            margin-top: 0;
            font-size: 24px;
        }
        .logout {
            float: right;
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background: #2ecc71;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        tr:hover {
            background: #eef9f1;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            color: white;
        }
        .paid { background: #3498db; }
        .pending { background: #e67e22; }
        .delivered { background: #2ecc71; }
        .shipped { background: #9b59b6; }
        .pending-delivery { background: #e74c3c; }
    </style>
</head>
<body>
  <!-- navbar -->
  <div style="position: sticky;">
    <link rel="stylesheet" href="site.css">
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light ww" style="background-color: aqua;">
        <div class="container-fluid">
          <img  class="navimg" src="./Untitled design2.jpg" alt="">
          <h1 style=" margin-right: 2.5cm; margin-left: 0.5cm;font-family: cursive;margin-top: 20px;">CRAFTY CREATIONS</h1>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <div class="nav">
              <a class="nav-link active" aria-current="page" href="home.html">Home</a>
              <a class="nav-link active" href="about us.html">About Us</a>
              <a class="nav-link active" href="collection.html">Collection</a>  
              <a class="nav-link active" href="review.php">Review</a>
              <a class="nav-link active" href="contact us.html">Contact Us</a>
              <a class="nav-link active" href="register.php">Account</a>
            </div>
            </div>
          </div>
        </div>
      </nav>
      </header>
      </div>
    <div class="dashboard">
        <a href="home.html" class="logout">Logout</a>
        <h2>Welcome, <?php echo htmlspecialchars($email); ?></h2>
        <h3>Your Orders</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Product</th>
                <th>Address</th>
                <th>Payment</th>
                <th>Delivery</th>
                <th>Date</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $paymentClass = ($row['payment_status'] == 'Paid') ? 'paid' : 'pending';
                    $deliveryClass = match ($row['delivery_status']) {
                        'Delivered' => 'delivered',
                        'Shipped' => 'shipped',
                        default => 'pending-delivery'
                    };
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['order']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td><span class='badge $paymentClass'>" . htmlspecialchars($row['payment_status']) . "</span></td>";
                    echo "<td><span class='badge $deliveryClass'>" . htmlspecialchars($row['delivery_status']) . "</span></td>";
                    echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No orders found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
