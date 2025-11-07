<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Step 1: Database connection
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "db_name";

// Step 2: Create connection
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Step 3: Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL
$product_id = $_GET['product_id'] ?? '';

// Step 4: Handle form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $order   = trim($_POST['order'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $payment = trim($_POST['payment'] ?? '');

    // Step 5: Validate
    if (empty($name) || empty($email) || empty($phone) || empty($order) || empty($address) || empty($payment)) {
        die("All fields are required.");
    }

    // Step 6: Insert into database
    $stmt = $conn->prepare("INSERT INTO orders (name, email, phone, `order`, address, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $phone, $order, $address, $payment);

    if ($stmt->execute()) {
        header("Location: order_confirm.html");
        exit();
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!-- HTML ORDER FORM -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Quick Order</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background: #f4f4f4;
      background-image: url(image/bg1.png);
    }
    .form-container {
      max-width: 400px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 6px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }
    label {
      display: block;
      margin: 12px 0 5px;
      font-weight: bold;
    }
    input, select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    button {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background: #28a745;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 1rem;
      cursor: pointer;
    }
    button:hover {
      background: #218838;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Place Your Order</h2>
    <form method="POST" action="">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" placeholder="Your Name" required />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="you@example.com" required />

      <label for="phone">Phone</label>
      <input type="tel" id="phone" name="phone" placeholder="+91 9876543210" required />

      <label for="order">Product ID</label>
      <input type="text" id="order" name="order" value="<?php echo htmlspecialchars($product_id); ?>" readonly required />

      <label for="address">Shipping Address</label>
      <input type="text" id="address" name="address" placeholder="Street, City" required />

      <label for="payment">Payment Method</label>
      <select id="payment" name="payment" required>
        <option value="">Choose Payment</option>
        <option value="cod">Cash on Delivery</option>
      </select>

      <button type="submit">Order Now</button>
    </form>
  </div>
</body>
</html>
