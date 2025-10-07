<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit;
}

$nama = $_SESSION['nama'] ?? 'Pengguna';
$role = $_SESSION['role'] ?? 'siswa';

include '../template/navigation-private.php';
include '../template/header.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - ModulResource</title>
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="stylesheet" href="css/sidebar.css">
</head>
<body>
<div class="dashboard-container">
  <?php include 'sidebar.php'; ?>

  <main class="main-content">
    <h2>Hai, <?php echo htmlspecialchars($nama); ?>!</h2>

    <?php if ($role == 'admin'): ?>
      <p>Selamat datang di dashboard Admin.</p>
    <?php elseif ($role == 'guru'): ?>
      <p>Selamat datang di dashboard Guru.</p>
    <?php else: ?>
      <p>Selamat datang di dashboard Siswa.</p>
    <?php endif; ?>
  </main>
</div>
</body>
</html>
