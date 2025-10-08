<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include '../config/database.php';

// pastikan user login dan role-nya siswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
  header("Location: ../auth/login.php");
  exit;
}

$siswa_id = $_SESSION['user_id'];

// ambil data filter dari form
$keyword = $_GET['keyword'] ?? '';
$mapel_id = $_GET['mapel_id'] ?? '';
$guru_id = $_GET['guru_id'] ?? '';

// query dasar
$query = "
  SELECT m.*, mp.nama AS mapel, u.nama AS guru
  FROM modul_ajar m
  LEFT JOIN mata_pelajaran mp ON m.mapel_id = mp.id
  LEFT JOIN users u ON m.guru_id = u.id
  WHERE 1
";

// tambahkan filter jika ada
if (!empty($keyword)) {
  $query .= " AND m.judul LIKE '%$keyword%'";
}
if (!empty($mapel_id)) {
  $query .= " AND m.mapel_id = '$mapel_id'";
}
if (!empty($guru_id)) {
  $query .= " AND m.guru_id = '$guru_id'";
}

$query .= " ORDER BY m.id DESC";
$result = mysqli_query($conn, $query);

// ambil data mapel untuk dropdown filter
$mapel_result = mysqli_query($conn, "SELECT * FROM mata_pelajaran ORDER BY nama ASC");

// ambil data guru untuk dropdown filter
$guru_result = mysqli_query($conn, "SELECT id, nama FROM users WHERE role = 'guru' ORDER BY nama ASC");


include '../template/navigation-private.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Daftar Modul - ModulResource</title>
  <link rel="stylesheet" href="css/daftar_modul.css">
</head>

<body>
  <?php include '../template/sidebar.php'; ?>
  <h1>📚 Daftar Modul Tersedia</h1>

  <div class="filter-bar">
    <form method="GET">
      <input type="text" name="keyword" placeholder="Cari judul modul..." value="<?php echo htmlspecialchars($keyword); ?>">

      <select name="mapel_id">
        <option value="">Semua Mapel</option>
        <?php while ($m = mysqli_fetch_assoc($mapel_result)): ?>
          <option value="<?php echo $m['id']; ?>" <?php if ($mapel_id == $m['id']) echo 'selected'; ?>>
            <?php echo htmlspecialchars($m['nama']); ?>
          </option>
        <?php endwhile; ?>
      </select>

      <select name="guru_id">
        <option value="">Semua Guru</option>
        <?php while ($g = mysqli_fetch_assoc($guru_result)): ?>
          <option value="<?php echo $g['id']; ?>" <?php if ($guru_id == $g['id']) echo 'selected'; ?>>
            <?php echo htmlspecialchars($g['nama']); ?>
          </option>
        <?php endwhile; ?>
      </select>

      <button type="submit" class="btn-filter">🔍 Filter</button>
    </form>
  </div>

  <div class="modul-grid">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($modul = mysqli_fetch_assoc($result)): ?>
        <div class="modul-card">
          <div>
            <h3><?php echo htmlspecialchars($modul['judul']); ?></h3>
            <p class="mapel">📘 <?php echo htmlspecialchars($modul['mapel']); ?></p>
            <p>👩‍🏫 Guru: <?php echo htmlspecialchars($modul['guru']); ?></p>

            <?php if (!empty($modul['deskripsi'])): ?>
              <p>📄 <?php echo substr($modul['deskripsi'], 0, 100); ?>...</p>
            <?php endif; ?>

            <p class="harga">
              💰
              <?php if ($modul['tipe'] == 'gratis'): ?>
                <span class="gratis">Gratis</span>
              <?php else: ?>
                Rp <?php echo number_format($modul['harga'], 0, ',', '.'); ?>
              <?php endif; ?>
            </p>
          </div>

          <?php if ($modul['tipe'] == 'gratis'): ?>
            <a href="detail_modul.php?id=<?php echo $modul['id']; ?>" class="btn-detail">Lihat Detail</a>
          <?php else: ?>
            <a href="beli_modul.php?id=<?php echo $modul['id']; ?>" class="btn-beli">💳 Beli Modul</a>
          <?php endif; ?>

        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="no-data">Tidak ada modul yang ditemukan.</p>
    <?php endif; ?>
  </div>

</body>

</html>