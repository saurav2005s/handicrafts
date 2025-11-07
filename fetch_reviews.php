<?php
$conn = new mysqli("localhost", "root", "", "handicraft_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = $_GET['product_id'];

$sql = "SELECT name, rating, message, created_at FROM reviews WHERE product_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $product_id);
$stmt->execute();
$result = $stmt->get_result();

$reviews = array();
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

echo json_encode($reviews);

$stmt->close();
$conn->close();
?>
