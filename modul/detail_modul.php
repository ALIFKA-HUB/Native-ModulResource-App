<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include '../config/database.php';

// pastikan user login
if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? 'guest';

// pastikan ada parameter ID
if (!isset($_GET['id'])) {
  echo "<p>Modul tidak ditemukan.</p>";
  exit;
}

$modul_id = intval($_GET['id']);

// ambil data modul dari database
$query = "
  SELECT m.*, u.nama AS guru, mp.nama AS mapel
  FROM modul_ajar m
  LEFT JOIN users u ON m.guru_id = u.id
  LEFT JOIN mata_pelajaran mp ON m.mapel_id = mp.id
  WHERE m.id = '$modul_id'
";
$result = mysqli_query($conn, $query);
$modul = mysqli_fetch_assoc($result);

if (!$modul) {
  echo "<p>Modul tidak ditemukan atau telah dihapus.</p>";
  exit;
}

// hitung jumlah download modul ini
$q_downloads = "SELECT COUNT(*) AS total_download FROM log_download WHERE modul_id = '$modul_id'";
$r_downloads = mysqli_query($conn, $q_downloads);
$d_downloads = mysqli_fetch_assoc($r_downloads);
$total_download = $d_downloads['total_download'] ?? 0;

// proses jika tombol download ditekan (khusus siswa)
if (isset($_GET['download']) && $role === 'siswa') {
  $file_path = "../" . $modul['file_url'];
  if (file_exists($file_path)) {

    // 🔒 Cegah duplikat log (dalam satu hari)
    $cek_log = mysqli_query($conn, "
      SELECT id FROM log_download
      WHERE siswa_id = '$user_id' AND modul_id = '$modul_id'
      AND DATE(tanggal_download) = CURDATE()
    ");

    if (mysqli_num_rows($cek_log) == 0) {
      $insert_log = "
        INSERT INTO log_download (siswa_id, modul_id, tanggal_download)
        VALUES ('$user_id', '$modul_id', NOW())
      ";
      mysqli_query($conn, $insert_log);
    }

    // kirim file ke browser
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
    exit;
  } else {
    echo "<script>alert('File tidak ditemukan.');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Detail Modul - <?php echo htmlspecialchars($modul['judul']); ?></title>
  <link rel="stylesheet" href="css/detail_modul.css">
</head>

<body>
  <div class="detail-container">
    <div class="detail-header">
      <h1><?php echo htmlspecialchars($modul['judul']); ?></h1>
      <p class="mapel">📘 <?php echo htmlspecialchars($modul['mapel']); ?></p>
      <p class="guru">👩‍🏫 Oleh: <?php echo htmlspecialchars($modul['guru']); ?></p>
    </div>

    <div class="detail-body">
      <p class="deskripsi"><?php echo nl2br(htmlspecialchars($modul['deskripsi'])); ?></p>

      <div class="info-box">
        <p><strong>Jumlah Unduhan:</strong> <?php echo $total_download; ?></p>
        <p><strong>File:</strong> <?php echo basename($modul['file_url']); ?></p>
      </div>

      <?php if ($role === 'siswa'): ?>
        <?php
        $boleh_akses = false;

        // cek hak akses siswa
        if ($modul['tipe'] === 'gratis') {
          $boleh_akses = true;
        } else {
          $cek_akses = mysqli_query($conn, "
            SELECT * FROM modul_akses
            WHERE siswa_id='$user_id' AND modul_id='$modul_id'
          ");
          if (mysqli_num_rows($cek_akses) > 0) {
            $boleh_akses = true;
          }
        }

        // tampilkan tombol download / pesan
        if ($boleh_akses) {
          echo '<a href="detail_modul.php?id=' . $modul_id . '&download=true" class="btn-download">📥 Unduh Modul</a>';
        } else {
          echo '<p class="note">🔒 Modul ini berbayar. Silakan <a href="beli_modul.php?id=' . $modul_id . '">beli terlebih dahulu</a>.</p>';
        }
        ?>
      <?php else: ?>
        <p class="note">ℹ️ Hanya siswa yang dapat mengunduh modul.</p>
      <?php endif; ?>
    </div>

    <div class="back-link">
      <?php if ($role === 'guru'): ?>
        <a href="../modul/kelola_modul.php">← Kembali ke Modul Saya</a>
      <?php else: ?>
        <a href="../modul/daftar_modul.php">← Kembali ke Daftar Modul</a>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>