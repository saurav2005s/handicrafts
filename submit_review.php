<?php
// Connect to DB
$conn = new mysqli("localhost", "root", "", "handicraft_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$product_id = $_POST['product_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$rating = $_POST['rating'];
$message = $_POST['message'];

$sql = "INSERT INTO reviews (product_id, name, email, rating, message)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssis", $product_id, $name, $email, $rating, $message);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
