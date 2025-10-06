<?php
// Mulai sesi (biar bisa deteksi login nanti)
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Optional: base URL biar path file CSS/JS rapi
$base_url = "http://localhost/NATIVE-MODULRESOURCE-APP/";
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ModulResource</title>

  <!-- CSS utama -->
  <link rel="stylesheet" href="<?= $base_url ?>assets/css/navbar.css">
  <link rel="stylesheet" href="<?= $base_url ?>assets/css/footer.css">
  <link rel="stylesheet" href="<?= $base_url ?>assets/css/index.css">

  <?php
  // Tambah CSS khusus per halaman
  if (isset($page_css)) {
    echo '<link rel="stylesheet" href="' . $base_url . 'assets/css/' . $page_css . '">';
  }
  ?>
</head>