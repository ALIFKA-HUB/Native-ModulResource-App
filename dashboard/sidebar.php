<?php
$role = $_SESSION['role'];
?>

<aside class="sidebar">
  <div class="sidebar-header">
    <h3>ModulResource</h3>
  </div>

  <ul class="sidebar-menu">
    <li><a href="dashboard.php">Dashboard</a></li>

    <?php if ($role == 'admin'): ?>
      <li><a href="#">Kelola User</a></li>
      <li><a href="#">Kelola Mapel</a></li>
      <li><a href="#">Laporan</a></li>

    <?php elseif ($role == 'guru'): ?>
      <li><a href="#">Modul Saya</a></li>
      <li><a href="#">Upload Modul</a></li>
      <li><a href="#">Transaksi</a></li>

    <?php elseif ($role == 'siswa'): ?>
      <li><a href="#">Daftar Modul</a></li>
      <li><a href="#">Riwayat Download</a></li>
    <?php endif; ?>

    <li><a href="../auth/logout.php" class="logout">Logout</a></li>
  </ul>
</aside>
