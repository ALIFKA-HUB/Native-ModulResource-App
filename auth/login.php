<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: ../dashboard.php");
  exit;
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Login - ModulResource</title>
  <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>
  <div id="login-container">
    <h2 class="login-title">Login Aplikasi ModulResource</h2>

    <form id="login-form" action="process_login.php" method="POST">
      <div class="form-group">
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email" class="input-field" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label><br>
        <input type="password" id="password" name="password" class="input-field" required>
      </div>

      <button type="submit" id="btn-login" class="btn">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
  </div>
</body>

</html>