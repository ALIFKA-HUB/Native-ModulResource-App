<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - ModulResource</title>
  <link rel="stylesheet" href="../assets/css/registers.css">
</head>

<body style="background: linear-gradient(120deg, #2bca92ff, #062870ff); 
             min-height: 100vh; 
             display: flex; 
             justify-content: center; 
             align-items: center; 
             font-family: 'Segoe UI', Arial, sans-serif;">

  <div class="register-wrapper">

    <!-- KIRI -->
    <div class="register-left">
      <div class="left-content">
        <img src="../assets/image/logo.png" alt="Logo ModulResource">
        <h1>Gabung dengan Kami!</h1>
        <p>Buat akun ModulResource untuk mulai berbagi dan mengunduh modul pembelajaran digital.</p>
      </div>
    </div>

    <!-- KANAN -->
    <div class="register-right">
      <h2 class="register-title">Buat Akun Baru</h2>

      <form id="register-form" action="process_register.php" method="POST">
        <div class="form-group">
          <label for="nama">Nama Lengkap :</label><br>
          <input type="text" id="nama" name="nama" class="input-field" required>
        </div>

        <div class="form-group">
          <label for="email">Email :</label><br>
          <input type="email" id="email" name="email" class="input-field" required>
        </div>

        <div class="form-group">
          <label for="password">Password :</label><br>
          <input type="password" id="password" name="password" class="input-field" required>
          <button type="button" class="toggle-password" onclick="togglePassword()">
            <!-- Mata default -->
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>

        <div class="form-group">
          <label for="role">Pilih Peran :</label><br>
          <select id="role" name="role" class="input-field">
            <option value="siswa">Siswa</option>
            <option value="guru">Guru</option>
          </select>
        </div>

        <button type="submit" id="btn-register" class="btn">Daftar</button>
      </form>

      <p class="login-link">Sudah punya akun? <a href="login.php">Login di sini</a></p>

      <div class="back-home">
        <a href="../index.php" class="back-link">← Kembali ke Beranda</a>
      </div>
    </div>

  </div>

  <script>
    // Toggle password visibility
    function togglePassword() {
      const input = document.getElementById("password");
      const icon = document.getElementById("eyeIcon");

      if (input.type === "password") {
        input.type = "text";
        // Ganti ke ikon mata disilang
        icon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.964 9.964 0 012.843-4.419M9.88 9.88a3 3 0 104.24 4.24M15 12a3 3 0 00-3-3m9.121 3c-.458 1.493-1.24 2.877-2.29 4.047M4.707 4.707l14.586 14.586" />`;
      } else {
        input.type = "password";
        // Ganti ke ikon mata biasa
        icon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
      }
    }
  </script>

</body>

</html>