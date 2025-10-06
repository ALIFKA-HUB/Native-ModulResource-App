<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - ModulResource</title>
  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Arial, sans-serif;
    }

    body {
      background-color: #f4f6fa;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    /* ====== WRAPPER ====== */
    .register-wrapper {
      display: flex;
      width: 950px;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    /* ====== LEFT SIDE ====== */
    .register-left {
      flex: 1;
      background: linear-gradient(135deg, #3A5BA0 0%, #4DBB82 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
      padding: 40px;
    }

    .left-content img {
      width: 90px;
      margin-bottom: 25px;
    }

    .left-content h1 {
      font-size: 30px;
      font-weight: 700;
      margin-bottom: 15px;
    }

    .left-content p {
      font-size: 15px;
      line-height: 1.6;
      color: #E8EEF7;
    }

    /* ====== RIGHT SIDE ====== */
    .register-right {
      flex: 1;
      padding: 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .register-title {
      color: #1F2A5A;
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 30px;
    }

    /* ====== FORM ====== */
    .form-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-field {
      width: 100%;
      padding: 12px 45px 12px 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
      transition: 0.3s;
      margin-top: 10px;
    }

    .input-field:focus {
      border-color: #2E9B4F;
      outline: none;
      box-shadow: 0 0 5px rgba(46, 155, 79, 0.3);
    }

    /* ====== EYE ICON (fix center alignment) ====== */
    .toggle-password {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-35%);
      /* ubah dari -50% biar agak turun */
      background: none;
      border: none;
      cursor: pointer;
      color: #555;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
      height: 100%;
    }

    .toggle-password svg {
      width: 22px;
      height: 22px;
      pointer-events: none;
    }


    .toggle-password:hover svg path {
      stroke: #2E9B4F;
    }

    /* ====== BUTTON ====== */
    .btn {
      width: 100%;
      background-color: #2E9B4F;
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn:hover {
      background-color: #22863a;
      transform: scale(1.03);
    }

    /* ====== LINKS ====== */
    .login-link {
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
    }

    .login-link a {
      color: #1F2A5A;
      text-decoration: none;
      font-weight: 600;
    }

    .login-link a:hover {
      color: #2E9B4F;
    }

    .back-home {
      text-align: right;
      margin-top: 30px;
    }

    .back-link {
      text-decoration: none;
      color: #1F2A5A;
      font-weight: 600;
      font-size: 14px;
      transition: 0.3s;
    }

    .back-link:hover {
      color: #2E9B4F;
    }

    /* ====== RESPONSIVE ====== */
    @media (max-width: 850px) {
      .register-wrapper {
        flex-direction: column;
        width: 90%;
      }

      .register-left,
      .register-right {
        width: 100%;
        padding: 40px 30px;
      }

      .left-content h1 {
        font-size: 26px;
      }
    }
  </style>
</head>

<body>

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