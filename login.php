<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

var_dump($_SERVER['REQUEST_METHOD'], $_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        die("Email or password missing");
    }

    $mysqli = new mysqli('localhost', 'root', '', 'user_db');
    if ($mysqli->connect_error) die("Connection Error: " . $mysqli->connect_error);

    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE email = ?");
    if (!$stmt) die("Prepare failed: " . $mysqli->error);
    $stmt->bind_param('s', $email);
    if (!$stmt->execute()) die("Execute failed: " . $stmt->error);

    $stmt->store_result();
    if ($stmt->num_rows !== 1) die('User not found');
    $stmt->bind_result($id, $hash);
    $stmt->fetch();

    if (!password_verify($password, $hash)) {
        die('Invalid credentials');
    }

    $_SESSION['loggedin'] = true;
    $_SESSION['id'] = $id;
    $_SESSION['email'] = $email;

    header('Location: dashboard.php');
    exit;
}
