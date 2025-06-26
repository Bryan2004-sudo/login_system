<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user'] = $user;
        if ($user['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: user_page.php");
        }
    } else {
        echo "Invalid login!";
    }
}
?>

<link rel="stylesheet" href="style.css">
<form method="post">
  <h2>Login</h2>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit" name="login">Login</button>
  <p>Don't have an account? <a href="register.php">Register</a></p>
</form>
