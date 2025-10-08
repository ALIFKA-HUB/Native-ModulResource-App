<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include '../config/database.php';

// pastikan admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../auth/login.php");
  exit;
}

$query = "
SELECT t.id, u.nama AS siswa, m.judul AS modul, g.nama AS guru, t.tanggal
FROM transaksi t
JOIN users u ON t.siswa_id = u.id
JOIN modul_ajar m ON t.modul_id = m.id
JOIN users g ON m.guru_id = g.id
ORDER BY t.tanggal DESC
";
$result = mysqli_query($conn, $query);

include '../template/navigation-private.php';
?>

<?php include '../template/sidebar.php'; ?>
<link rel="stylesheet" href="css/laporan.css">
<div class="main-content">
  <h2>📊 Laporan Transaksi</h2>
  <p>Berikut daftar transaksi pembelian modul oleh siswa.</p>

  <table class="data-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Siswa</th>
        <th>Modul</th>
        <th>Guru</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= $row['id']; ?></td>
            <td><?= htmlspecialchars($row['siswa']); ?></td>
            <td><?= htmlspecialchars($row['modul']); ?></td>
            <td><?= htmlspecialchars($row['guru']); ?></td>
            <td><?= date('d M Y, H:i', strtotime($row['tanggal'])); ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" style="text-align:center;">Belum ada transaksi.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<style>
  .main-content {
    margin-top: 100px;
    margin-left: 260px;
    margin-right: 30px;
    background: #f8f9fc;
    min-height: calc(100vh - 80px);
  }

  table.data-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
  }

  th {
    background: #1F2A5A;
    color: #fff;
    padding: 12px;
  }

  td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
  }

  tr:hover {
    background: #f4f7f9;
  }
</style>