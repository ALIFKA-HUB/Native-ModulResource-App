<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include '../config/database.php';

// pastikan login sebagai admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../auth/login.php");
  exit;
}

// ambil statistik
$total_guru = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM users WHERE role='guru'"))['jml'];
$total_siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM users WHERE role='siswa'"))['jml'];
$total_modul = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM modul_ajar"))['jml'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM transaksi"))['jml'];
?>

<link rel="stylesheet" href="css/admin-dboard.css">
<div class="main-content">
  <div class="welcome-section">
    <h2>👋 Hai, Admin!</h2>
    <p>Selamat datang di halaman Dashboard Admin ModulResource.</p>
  </div>

  <div class="stats-container">
    <div class="stat-card guru">
      <h3><?php echo $total_guru; ?></h3>
      <p>Total Guru</p>
    </div>

    <div class="stat-card siswa">
      <h3><?php echo $total_siswa; ?></h3>
      <p>Total Siswa</p>
    </div>

    <div class="stat-card modul">
      <h3><?php echo $total_modul; ?></h3>
      <p>Total Modul</p>
    </div>

    <div class="stat-card transaksi">
      <h3><?php echo $total_transaksi; ?></h3>
      <p>Total Transaksi</p>
    </div>
  </div>
</div>