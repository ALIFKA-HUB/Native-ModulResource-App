<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include '../config/database.php';

// pastikan user login dan berperan sebagai siswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
  header("Location: ../auth/login.php");
  exit;
}

$siswa_id = $_SESSION['user_id'];

// ambil riwayat download dari database
$query = "
  SELECT 
    m.id AS modul_id,
    m.judul, 
    u.nama AS guru, 
    l.tanggal_download
  FROM log_download l
  JOIN modul_ajar m ON l.modul_id = m.id
  JOIN users u ON m.guru_id = u.id
  WHERE l.siswa_id = '$siswa_id'
  ORDER BY l.tanggal_download DESC
";
$result = mysqli_query($conn, $query);

include '../template/navigation-private.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Riwayat Download - ModulResource</title>
  <link rel="stylesheet" href="css/riwayat_download.css">
</head>

<body>

  <?php include '../template/sidebar.php'; ?>

  <div class="container">
    <h1>📥 Riwayat Download Modul</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Judul Modul</th>
            <th>Guru Pembuat</th>
            <th>Tanggal Download</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['judul']); ?></td>
              <td><?php echo htmlspecialchars($row['guru']); ?></td>
              <td><?php echo date('d M Y, H:i', strtotime($row['tanggal_download'])); ?></td>
              <td>
                <a href="../daftar_modul/detail_modul.php?id=<?php echo $row['modul_id']; ?>" class="btn">Lihat Modul</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="no-data">Belum ada modul yang pernah kamu unduh.</p>
    <?php endif; ?>
    <br>
    <div class="back-link">
      <a href="../dashboard/dashboard.php">← Kembali ke Dashboard</a>
    </div>
  </div>

</body>

</html>