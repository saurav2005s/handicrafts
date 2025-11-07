<?php
session_start();
$admin_email = 'pts@gmail.com';
$admin_pass = 'pts123';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === $admin_email && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_panel.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <style>
    body {
      background: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      background: linear-gradient(145deg, #ffffff, #f3f3f3);
      padding: 35px 45px;
      border-radius: 15px;
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
      max-width: 400px;
      width: 100%;
      transition: 0.3s ease;
    }

    .login-box:hover {
      box-shadow: 0 18px 30px rgba(0, 0, 0, 0.25);
    }

    .login-box h2 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
      transition: 0.3s;
    }

    .login-box input:focus {
      border-color: #ff6f61;
      outline: none;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      background: #ff6f61;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .login-box button:hover {
      background: #ff3c28;
    }

    .error {
      color: red;
      text-align: center;
      margin-top: 10px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Admin Login</h2>
    <form method="post">
      <input type="email" name="email" placeholder="Admin Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
      <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
  </div>
</body>
</html>
