<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  file_put_contents("log.txt", "Form submitted\n", FILE_APPEND);

    $full_name = $_POST['full_name'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM register WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "Email already registered. Please use another one.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO register (full_name, mobile_number, email, password) VALUES (?, ?, ?, ?)");

            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("ssss", $full_name, $mobile_number, $email, $hashed_password);

            if ($stmt->execute()) {
                $message = "Registration successful!";
            } else {
                $message = "Insert failed: " . $stmt->error;
            }

            $stmt->close();
        }

        $check->close();
    }
}

$conn->close();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- css -->
    <style>
      body {
  font-family: Arial, sans-serif;
  background: #fbfafb;
  margin: 0;
  padding: 0;
}

.aju {
  width: 100%;
  max-width: 400px;
  margin: 50px auto;
  background: rgb(163, 218, 223);
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(17, 212, 66, 0.1);
}

h2 {
  text-align: center;
  margin-bottom: 40px;

}

.form-group {
  margin-bottom: 15px;
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 5px;
  font-weight: bold;
}

input {
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 6px;
}

button {
  width: 100%;
  padding: 12px;
  background-color: #1cc282;
  color: white;
  border: none;
  font-size: 16px;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 10px;
}

button:hover {
  background-color: #0056b3;
}

#message {
  text-align: center;
  margin-top: 15px;
  color: red;
}
    </style>
</head>

<body>
  
  <!-- form code -->
<div class="aju">
  <form id="registrationForm" method="POST" action="register.php">
      <h2>Register</h2>
      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="full_name" required />
      </div>
      <div class="form-group">
        <label for="Mobile Number">Mobile Number</label>
        <input type="number" id="number" name="mobile_number" required />
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required minlength="6" />
      </div>
      <div class="form-group">
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirm_password" required />
      </div>
      <button type="submit">Register</button>
      <div class="a">
        <p style="justify-content: center;position: relative;">Already have an account?  <a link href="login.html">Login</a></p>
    </div>
<p id="message" style="color: green; text-align: center;"><?php echo $message; ?></p>

    </form>
  </div>
  <!-- js -->

  <script>
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
  //e.preventDefault(); // Prevent form submission

  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirmPassword').value;
  const message = document.getElementById('message');

  if (password !== confirmPassword) {
    message.textContent = "Passwords do not match!";
    return;
  }

  
  message.style.color = "green";
message.textContent = "";

  
  // You can handle the form data here (e.g., send to backend)
  console.log({ name, email, password });
});
  </script>
</body>
</html>