<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
  header("Location: ../dashboard.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - ModulResource</title>
  <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body style="background: linear-gradient(120deg, #2bca92ff, #062870ff); 
             min-height: 100vh; 
             display: flex; 
             justify-content: center; 
             align-items: center; 
             font-family: 'Segoe UI', Arial, sans-serif;">
  <div class="login-wrapper">

    <!-- Bagian kiri -->
    <div class="login-left">
      <div class="left-content">
        <img src="../assets/image/logo.png" alt="Logo ModulResource">
        <h1>Selamat Datang!</h1>
        <p>Masuk ke akun ModulResource kamu dan mulai perjalanan belajarmu sekarang.</p>
      </div>
    </div>

    <!-- Bagian kanan -->
    <div class="login-right">
      <h2 class="login-title">Login Aplikasi ModulResource</h2>
      <form id="login-form" action="process_login.php" method="POST">
        <div class="form-group">
          <label for="email">Email :</label><br>
          <input type="text" id="email" name="email" class="input-field" required>
        </div>
        <div class="form-group password-group">
          <label for="password">Password :</label><br>
          <div class="password-container">
            <input type="password" id="password" name="password" class="input-field" required>
            <button type="button" class="toggle-password" onclick="togglePassword()">
              <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
        </div>

        <button type="submit" id="btn-login" class="btn">Login</button>
      </form>

      <p class="register-link">Belum punya akun? <a href="register.php">Daftar di sini</a></p>

      <!-- Tombol kembali ke beranda di kanan bawah -->
      <div class="back-home">
        <a href="../index.php" class="back-link">← Kembali ke Beranda</a>
      </div>
    </div>

  </div>
</body>
<script>
  function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (input.type === "password") {
      input.type = "text";
      icon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.964 9.964 0 012.843-4.419M9.88 9.88a3 3 0 104.24 4.24M15 12a3 3 0 00-3-3m9.121 3c-.458 1.493-1.24 2.877-2.29 4.047M4.707 4.707l14.586 14.586" />`;
    } else {
      input.type = "password";
      icon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
    }
  }
</script>


</html>