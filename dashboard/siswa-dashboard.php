<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include '../config/database.php';

// pastikan user login dan rolenya siswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
  header("Location: ../auth/login.php");
  exit;
}

$siswa_id = $_SESSION['user_id'];
$nama_siswa = $_SESSION['nama'] ?? 'Siswa';

// ===== Query Statistik =====
$query_total_modul = "SELECT COUNT(*) AS total_modul FROM modul_ajar";
$result_modul = mysqli_query($conn, $query_total_modul);
$data_modul = mysqli_fetch_assoc($result_modul);
$total_modul = $data_modul['total_modul'] ?? 0;

$query_download = "SELECT COUNT(*) AS total_download FROM log_download WHERE siswa_id = '$siswa_id'";
$result_download = mysqli_query($conn, $query_download);
$data_download = mysqli_fetch_assoc($result_download);
$total_download = $data_download['total_download'] ?? 0;

// ===== Query Rekomendasi Modul (dengan kolom deskripsi) =====
$query_rekomendasi = "
  SELECT 
    m.id, 
    m.judul, 
    m.deskripsi,
    m.file_url,
    mp.nama AS mapel,
    u.nama AS guru,
    COUNT(ld.id) AS total_download
  FROM modul_ajar m
  LEFT JOIN log_download ld ON m.id = ld.modul_id
  LEFT JOIN mata_pelajaran mp ON m.mapel_id = mp.id
  LEFT JOIN users u ON m.guru_id = u.id
  GROUP BY m.id
  ORDER BY total_download DESC
  LIMIT 3
";
$result_rekomendasi = mysqli_query($conn, $query_rekomendasi);
?>

<div class="main-content">
  <div class="welcome-section">
    <h2>Hai, <?php echo htmlspecialchars($nama_siswa); ?>! 👋</h2>
    <p>Selamat datang kembali di <strong>ModulResource</strong>.
      Yuk lanjut belajar dan jelajahi modul-modul menarik yang disediakan guru kamu!</p>
  </div>

  <div class="stats-container">
    <div class="stat-card modul">
      <h3><?php echo $total_modul; ?></h3>
      <p>Modul Tersedia</p>
    </div>
    <div class="stat-card download">
      <h3><?php echo $total_download; ?></h3>
      <p>Modul Telah Diunduh</p>
    </div>
  </div>

  <div class="feature-section">
    <h3>✨ Apa yang bisa kamu lakukan?</h3>
    <div class="feature-grid">
      <div class="feature-card">
        <div class="icon">📘</div>
        <h4>Lihat & Unduh Modul</h4>
        <p>Akses semua modul pembelajaran yang dibagikan oleh guru dengan mudah.</p>
        <a href="../modul/daftar_modul.php" class="btn-small">Buka</a>
      </div>

      <div class="feature-card">
        <div class="icon">📥</div>
        <h4>Riwayat Unduhan</h4>
        <p>Lihat kembali semua modul yang pernah kamu unduh dari sistem.</p>
        <a href="../transaksi/riwayat_download.php" class="btn-small">Lihat</a>
      </div>

      <div class="feature-card">
        <div class="icon">💬</div>
        <h4>Kirim Umpan Balik</h4>
        <p>Berikan komentar atau saran untuk modul yang kamu pelajari agar guru bisa memperbaikinya.</p>
        <a href="../feedback/form_feedback.php" class="btn-small">Kirim</a>
      </div>

      <div class="feature-card">
        <div class="icon">🎯</div>
        <h4>Rekomendasi Modul</h4>
        <p>Temukan modul populer pilihan guru minggu ini yang paling banyak diunduh.</p>
        <a href="#rekomendasi" class="btn-small">Lihat Rekomendasi</a>
      </div>
    </div>
  </div>

  <!-- Bagian Rekomendasi Modul -->
  <div id="rekomendasi" class="rekomendasi-section">
    <h3>🎯 Rekomendasi Modul Populer</h3>
    <div class="rekomendasi-grid">
      <?php if (mysqli_num_rows($result_rekomendasi) > 0): ?>
        <?php while ($modul = mysqli_fetch_assoc($result_rekomendasi)): ?>
          <div class="modul-card">
            <h4><?php echo htmlspecialchars($modul['judul']); ?></h4>
            <p class="mapel"><strong>Mata Pelajaran:</strong> <?php echo htmlspecialchars($modul['mapel']); ?></p>
            <p class="guru"><strong>Guru:</strong> <?php echo htmlspecialchars($modul['guru']); ?></p>
            <p class="deskripsi"><?php echo nl2br(htmlspecialchars(substr($modul['deskripsi'], 0, 100))) . '...'; ?></p>
            <span class="downloads">📥 <?php echo $modul['total_download']; ?> kali diunduh</span>
            <a href="../modul/detail_modul.php?id=<?php echo $modul['id']; ?>" class="btn-small">Lihat Modul</a>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Tidak ada modul populer untuk saat ini.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<style>
  .main-content {
    flex: 1;
    padding: 1px 20px 0px 0px;
    background-color: #f8f9fc;
    min-height: calc(100vh - 80px);
  }

  .welcome-section {
    margin-bottom: 40px;
  }

  .welcome-section h2 {
    color: #1F2A5A;
    font-size: 30px;
    margin-bottom: 10px;
  }

  .welcome-section p {
    color: #444;
    font-size: 16px;
    line-height: 1.6;
  }

  .stats-container {
    display: flex;
    gap: 30px;
    margin-bottom: 40px;
    flex-wrap: wrap;
  }

  .stat-card {
    flex: 1;
    min-width: 220px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    padding: 25px;
    text-align: center;
    transition: 0.3s;
  }

  .stat-card:hover {
    transform: translateY(-5px);
  }

  .stat-card h3 {
    font-size: 40px;
    color: #2E9B4F;
  }

  .stat-card p {
    color: #1F2A5A;
    font-weight: 600;
  }

  .feature-section h3 {
    color: #1F2A5A;
    font-size: 22px;
    margin-bottom: 25px;
  }

  .feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
  }

  .feature-card {
    background: #fff;
    border-radius: 10px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    transition: 0.3s;
  }

  .feature-card:hover {
    transform: translateY(-6px);
  }

  .feature-card .icon {
    font-size: 36px;
    margin-bottom: 15px;
  }

  .btn-small {
    display: inline-block;
    background-color: #2E9B4F;
    color: #fff;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
  }

  .btn-small:hover {
    background-color: #22863a;
    transform: scale(1.05);
  }

  .rekomendasi-section {
    margin-top: 50px;
  }

  .rekomendasi-section h3 {
    color: #1F2A5A;
    font-size: 22px;
    margin-bottom: 25px;
  }

  .rekomendasi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
  }

  .modul-card {
    background: #fff;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    transition: 0.3s;
  }

  .modul-card:hover {
    transform: translateY(-5px);
  }

  .modul-card h4 {
    color: #1F2A5A;
    margin-bottom: 10px;
  }

  .modul-card .deskripsi {
    color: #555;
    font-size: 14px;
    margin: 10px 0;
    min-height: 60px;
  }

  .modul-card .downloads {
    color: #2E9B4F;
    font-size: 13px;
    margin-bottom: 10px;
    display: block;
  }
</style>