<?php
$role = $_SESSION['role'];
?>
<style>
  .sidebar {
    width: 230px;
    background-color: #1F2A5A;
    color: #fff;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 9999;
    /* lebih tinggi dari navbar */
  }

  .sidebar-header {
    padding: 20px;
    font-size: 20px;
    font-weight: 700;
    background-color: #192249;
    text-align: center;
  }

  .sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .sidebar-menu li {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .sidebar-menu li a {
    display: block;
    padding: 14px 20px;
    color: #fff;
    text-decoration: none;
    transition: 0.3s;
  }

  .sidebar-menu li a:hover {
    background-color: #2E9B4F;
  }

  .sidebar-menu .logout {
    background-color: #c0392b;
  }

  .sidebar-menu .logout:hover {
    background-color: #a93226;
  }
</style>

<link rel="stylesheet" href="css/sidebar.css">
<aside class="sidebar">
  <div class="sidebar-header">
    <h3>ModulResource</h3>
  </div>

  <ul class="sidebar-menu">
    <li><a href="../dashboard/dashboard.php">Dashboard</a></li>

    <?php if ($role == 'admin'): ?>
      <li><a href="../admin/kelola_user.php">Kelola User</a></li>
      <li><a href="../admin/kelola_mapel.php">Kelola Mapel</a></li>
      <li><a href="../admin/laporan.php">Laporan</a></li>

    <?php elseif ($role == 'guru'): ?>
      <li><a href="../modul/kelola_modul.php">Modul Saya</a></li>
      <li><a href="../modul/upload_modul.php">Upload Modul</a></li>
      <li><a href="../transaksi/riwayat_transaksi.php">Transaksi</a></li>

    <?php elseif ($role == 'siswa'): ?>
      <li><a href="../modul/daftar_modul.php">Daftar Modul</a></li>
      <li><a href="../transaksi/riwayat_download.php">Riwayat Download</a></li>
    <?php endif; ?>

    <li><a href="../auth/logout.php" class="logout">Logout</a></li>
  </ul>
</aside>