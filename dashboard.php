<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: auth/login.php");
  exit;
}

$role = $_SESSION['role'];
?>
<?php
include 'template/header.php';
?>

<!DOCTYPE html>
<html>

<head>
  <title>Dashboard - ModulResource</title>
  <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>
  <div id="dashboard-container">
    <h1 class="dashboard-title">
      Halo, <?php echo $_SESSION['user_nama']; ?> (<?php echo $role; ?>)
    </h1>

    <div class="dashboard-menu">
      <?php if ($role == 'admin'): ?>
        <a href="users/index.php">Kelola User</a>
        <a href="mapel/index.php">Kelola Mapel</a>
        <a href="laporan/">Laporan</a>
      <?php elseif ($role == 'guru'): ?>
        <a href="modul/index.php">Kelola Modul Ajar</a>
      <?php elseif ($role == 'siswa'): ?>
        <a href="modul/index.php">Lihat & Download Modul</a>
        <a href="transaksi/index.php">Riwayat Transaksi</a>
      <?php endif; ?>
    </div>

    <a href="auth/logout.php" class="logout-btn">Logout</a>
  </div>
</body>

</html>

<?php
include 'template/footer.php';
?>