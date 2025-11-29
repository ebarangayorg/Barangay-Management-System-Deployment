<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resident Login</title>
  <link rel="stylesheet" href="css/login.css">
  <link rel="icon" type="image/png" href="assets/img/BMS.png">
</head>
<body>
<div class="login-container">
  <div class="left">
    <img src="assets/img/BMS.png" alt="Barangay Logo">
  </div>
  <div class="right">
    <h2><b>Residency</b> Access</h2>
    <form action="backend/login_process.php" method="POST">
      <input type="email" name="email" placeholder="Your Email" required>
      <input type="password" name="password" placeholder="Your Password" required>


      <label><input type="checkbox" name="remember"> Remember me</label>
      <a href="admin_login.php" class="alt-login">Admistrator Login</a>

      <button type="submit">Login</button>
    </form>
    <a href="register.php">Don't have an account? Register here</a>
    <a href="index.php">Back to Homepage</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
