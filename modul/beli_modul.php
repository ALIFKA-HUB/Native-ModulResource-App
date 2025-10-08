<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include '../config/database.php';

// pastikan user login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
  header("Location: ../auth/login.php");
  exit;
}

$siswa_id = $_SESSION['user_id'];

// pastikan ada modul ID
if (!isset($_GET['id'])) {
  echo "<p>Modul tidak ditemukan.</p>";
  exit;
}

$modul_id = intval($_GET['id']);

// ambil data modul
$query = "SELECT * FROM modul_ajar WHERE id = '$modul_id'";
$result = mysqli_query($conn, $query);
$modul = mysqli_fetch_assoc($result);

if (!$modul) {
  echo "<p>Modul tidak ditemukan.</p>";
  exit;
}

// cek apakah sudah pernah dibeli
$q_cek = "SELECT * FROM modul_akses WHERE siswa_id='$siswa_id' AND modul_id='$modul_id'";
$r_cek = mysqli_query($conn, $q_cek);

if (mysqli_num_rows($r_cek) > 0) {
  header("Location: detail_modul.php?id=$modul_id");
  exit;
}

// simulasi pembelian
if (isset($_POST['konfirmasi'])) {
  // 1️⃣ Tambahkan ke tabel modul_akses (biar siswa punya akses)
  $insert_akses = "INSERT INTO modul_akses (siswa_id, modul_id) VALUES ('$siswa_id', '$modul_id')";
  mysqli_query($conn, $insert_akses);

  // 2️⃣ Tambahkan juga ke tabel transaksi (biar guru bisa lihat)
  $insert_transaksi = "INSERT INTO transaksi (siswa_id, modul_id) VALUES ('$siswa_id', '$modul_id')";
  mysqli_query($conn, $insert_transaksi);

  // 3️⃣ Redirect ke halaman detail modul
  header("Location: detail_modul.php?id=$modul_id");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Beli Modul - <?php echo htmlspecialchars($modul['judul']); ?></title>
  <link rel="stylesheet" href="css/beli_modul.css">
</head>

<body>
  <div class="buy-container">
    <h1>Konfirmasi Pembelian</h1>
    <p>Apakah kamu yakin ingin membeli modul:</p>
    <h2>📘 <?php echo htmlspecialchars($modul['judul']); ?></h2>
    <p class="price">Harga: Rp <?php echo number_format($modul['harga'], 0, ',', '.'); ?></p>

    <form method="post">
      <button type="submit" name="konfirmasi" class="btn">✅ Ya, Beli Sekarang</button>
    </form>
    <a href="daftar_modul.php" class="cancel">❌ Batal</a>
  </div>
</body>

</html>