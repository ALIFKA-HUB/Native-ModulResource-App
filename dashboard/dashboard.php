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
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>ModulResource</title>
  <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>

  <!-- Sidebar di atas semua elemen -->
  <?php include '../template/sidebar.php'; ?>

  <div class="dashboard-container">
    <main class="main-content">
      <?php
      if ($role === 'admin') {
        include 'admin-dashboard.php';
      } elseif ($role === 'guru') {
        include 'guru-dashboard.php';
      } else {
        include 'siswa-dashboard.php';
      }
      ?>
    </main>
  </div>

</body>
<script>
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 10) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
</script>

</html>