<!DOCTYPE html>
<html>

<head>
  <title>Register - ModulResource</title>
  <link rel="stylesheet" href="../assets/css/register.css">
  <script>
    // fungsi show/hide password
    function togglePassword(id, toggleId) {
      var input = document.getElementById(id);
      var toggle = document.getElementById(toggleId);

      if (input.type === "password") {
        input.type = "text";
        toggle.textContent = "Hide";
      } else {
        input.type = "password";
        toggle.textContent = "Show";
      }
    }

    // cek konfirmasi password
    function validateForm() {
      var pw1 = document.getElementById("password").value;
      var pw2 = document.getElementById("confirm_password").value;
      if (pw1 !== pw2) {
        alert("Password dan konfirmasi password tidak sama!");
        return false;
      }
      return true;
    }
  </script>
</head>

<body>
  <div id="register-container">
    <h2 class="register-title">Buat Akun Baru</h2>
    <form id="register-form" action="process_register.php" method="POST" onsubmit="return validateForm()">

      <div class="form-group">
        <label for="nama">Nama</label><br>
        <input type="text" id="nama" name="nama" class="input-field" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" class="input-field" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label><br>
        <input type="password" id="password" name="password" class="input-field" required>
        <button type="button" id="togglePass" onclick="togglePassword('password','togglePass')">Show</button>
      </div>

      <div class="form-group">
        <label for="confirm_password">Konfirmasi Password</label><br>
        <input type="password" id="confirm_password" name="confirm_password" class="input-field" required>
        <button type="button" id="toggleConfirm" onclick="togglePassword('confirm_password','toggleConfirm')">Show</button>
      </div>

      <div class="form-group">
        <label for="role">Role</label><br>
        <select id="role" name="role" class="input-field">
          <option value="siswa">Siswa</option>
          <option value="guru">Guru</option>
        </select>
      </div>

      <button type="submit" id="btn-register" class="btn">Register</button>
    </form>

    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
  </div>
</body>

</html>