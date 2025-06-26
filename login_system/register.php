<?php
session_start();
include 'config.php';


if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];  


    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param('s', $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "Email already taken!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $pass, $role);
        $stmt->execute();
        echo "Registration successful!";
    }
}
?>

<link rel="stylesheet" href="style.css">





<form method="post" action="">
  <div class="avatar-container">
    <img src="avatar.png" class="avatar" alt="Avatar">
  </div>
  <form method="post" action="register.php">

  <h2>Register</h2>
  <input type="text" name="username" placeholder="Username" required><br>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <select name="role" required>
  <option value="" disabled selected>Select role</option>
  <option value="user">User</option>
  <option value="admin">Admin</option>
</select>
  <button type="submit" name="register">Register</button>
  <p>Already have an account? <a href="login.php">Login</a></p>


</form>
