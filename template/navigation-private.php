<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit;
}

$nama_pengguna = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Pengguna';
$role_pengguna = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
?>



<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Dashboard - ModulResource</title>
  <link rel="stylesheet" href="/Native-ModulResource-App/assets/css/navigation-private.css">
</head>

<body>
  <nav class="navbar">
    <div class="navbar-container">

      <!-- kiri -->
      <div class="logo">
        <img src="/Native-ModulResource-App/assets/image/logo.png" alt="Logo ModulResource">
        <span>ModulResource</span>
      </div>

      <!-- tengah -->
      <!-- <ul class="nav-center">
        <li><a href="../dashboard.php">Beranda</a></li>
        <li><a href="../modul/modul.php">Modul</a></li>
        <li><a href="../laporan/laporan.php">Laporan</a></li>
      </ul> -->

      <!-- kanan -->
      <div class="nav-right">
        <div class="user-info">
          <img src="/Native-ModulResource-App/assets/image/student-icon.png" alt="User" class="user-icon">
          <span>Hai, <?php echo htmlspecialchars($nama_pengguna); ?> <?php echo ucfirst($role_pengguna); ?>!</span>
        </div>
        <a href="/Native-ModulResource-App/auth/logout.php" class="btn-logout">Logout</a>
      </div>

    </div>
  </nav>
</body>

</html>