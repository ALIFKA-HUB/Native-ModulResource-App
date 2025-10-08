<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include '../config/database.php';

// pastikan user login dan rolenya guru
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guru') {
  header("Location: ../auth/login.php");
  exit;
}

$guru_id = $_SESSION['user_id'];
$nama_guru = $_SESSION['nama'] ?? 'Guru';

// === ambil data statistik ===
$q_modul = "SELECT COUNT(*) AS total_modul FROM modul_ajar WHERE guru_id = '$guru_id'";
$r_modul = mysqli_query($conn, $q_modul);
$total_modul = mysqli_fetch_assoc($r_modul)['total_modul'] ?? 0;

$q_download = "
  SELECT COUNT(ld.id) AS total_download
  FROM log_download ld
  JOIN modul_ajar m ON ld.modul_id = m.id
  WHERE m.guru_id = '$guru_id'
";
$r_download = mysqli_query($conn, $q_download);
$total_download = mysqli_fetch_assoc($r_download)['total_download'] ?? 0;

// === ambil 5 modul terbaru ===
$q_modul_terbaru = "
  SELECT m.id, m.judul, mp.nama AS mapel, m.harga,
  (SELECT COUNT(*) FROM log_download WHERE modul_id = m.id) AS jumlah_download
  FROM modul_ajar m
  JOIN mata_pelajaran mp ON m.mapel_id = mp.id
  WHERE m.guru_id = '$guru_id'
  ORDER BY m.id DESC
";
$r_modul_terbaru = mysqli_query($conn, $q_modul_terbaru);
?>

<div class="main-content">
  <div class="welcome-section">
    <h2>Hai, <?php echo htmlspecialchars($nama_guru); ?>!</h2>
    <p>Selamat datang di Dashboard Guru.</p>
  </div>

  <div class="stats-container">
    <div class="stat-card">
      <h4>📘 Modul Diunggah</h4>
      <h2><?php echo $total_modul; ?></h2>
    </div>
    <div class="stat-card">
      <h4>📥 Total Unduhan</h4>
      <h2><?php echo $total_download; ?></h2>
    </div>
  </div>

  <div class="modul-terbaru">
    <h3>🧾 Modul Terbaru</h3>
    <table>
      <thead>
        <tr>
          <th>Judul Modul</th>
          <th>Mata Pelajaran</th>
          <th>Harga</th>
          <th>Jumlah Unduhan</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($r_modul_terbaru) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($r_modul_terbaru)): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['judul']); ?></td>
              <td><?php echo htmlspecialchars($row['mapel']); ?></td>
              <td><?php echo $row['harga'] == 0 ? 'Gratis' : 'Rp ' . number_format($row['harga'], 0, ',', '.'); ?></td>
              <td><?php echo $row['jumlah_download']; ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="4">Belum ada modul diunggah.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<style>
  .main-content {
    flex: 1;
    padding: 1px 20px 0px 5px;
    background-color: #f8f9fc;
    min-height: calc(100vh - 80px);
  }

  /* sambutan */
  .welcome-section h2 {
    color: #1F2A5A;
    font-size: 26px;
    margin-bottom: 6px;
  }

  .welcome-section p {
    color: #444;
    font-size: 15px;
    margin-bottom: 30px;
  }

  /* statistik */
  .stats-container {
    display: flex;
    gap: 25px;
    margin-bottom: 40px;
    flex-wrap: wrap;
  }

  .stat-card {
    flex: 1;
    min-width: 240px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    padding: 25px;
    text-align: center;
    border-top: 6px solid #2E9B4F;
  }

  .stat-card h4 {
    color: #1F2A5A;
    font-size: 16px;
    margin-bottom: 8px;
  }

  .stat-card h2 {
    font-size: 36px;
    color: #2E9B4F;
    margin: 0;
  }

  /* tabel modul terbaru */
  .modul-terbaru h3 {
    color: #1F2A5A;
    font-size: 20px;
    margin-bottom: 20px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
  }

  thead {
    background-color: #2E9B4F;
    color: #fff;
  }

  th,
  td {
    padding: 14px 12px;
    text-align: left;
    font-size: 15px;
  }

  tr:nth-child(even) {
    background-color: #f5f5f5;
  }

  tr:hover {
    background-color: #eef7ef;
  }
</style>