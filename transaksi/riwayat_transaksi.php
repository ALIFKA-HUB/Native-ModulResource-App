<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include '../config/database.php';

// pastikan user login dan role guru
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
  header("Location: ../auth/login.php");
  exit;
}

$guru_id = $_SESSION['user_id'];
$nama_guru = $_SESSION['nama'] ?? 'Guru';

// ambil data transaksi modul milik guru ini
$query = "
  SELECT 
    t.id,
    m.judul AS nama_modul,
    u.nama AS nama_siswa,
    m.harga,
    t.status
  FROM transaksi t
  JOIN modul_ajar m ON t.modul_id = m.id
  JOIN users u ON t.siswa_id = u.id
  WHERE m.guru_id = '$guru_id'
  ORDER BY t.id DESC
";
$result = mysqli_query($conn, $query);

include '../template/navigation-private.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Transaksi Modul - Guru</title>
  <link rel="stylesheet" href="css/riwayat_transaksi.css">
</head>
<?php include '../template/sidebar.php'; ?>
<body>
  <div class="container">
    <h2>💰 Daftar Transaksi Modul Anda</h2>

    <table>
      <thead>
        <tr>
          <th>Judul Modul</th>
          <th>Siswa</th>
          <th>Harga</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['nama_modul']); ?></td>
              <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
              <td>
                <?php echo $row['harga'] == 0 ? 'Gratis' : 'Rp ' . number_format($row['harga'], 0, ',', '.'); ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="no-data">Belum ada transaksi pembelian modul.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
    <br>
    <div class="back-link">
      <a href="../dashboard/dashboard.php">← Kembali ke Dashboard</a>
    </div>
  </div>
</body>

</html>