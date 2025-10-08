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

// tambah mapel
if (isset($_POST['tambah'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  mysqli_query($conn, "INSERT INTO mata_pelajaran (nama) VALUES ('$nama')");
  header("Location: kelola_mapel.php");
  exit;
}

// hapus mapel
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  mysqli_query($conn, "DELETE FROM mata_pelajaran WHERE id='$id'");
  header("Location: kelola_mapel.php");
  exit;
}

// ambil data mapel
$result = mysqli_query($conn, "SELECT * FROM mata_pelajaran ORDER BY id DESC");

include '../template/navigation-private.php';
include '../template/sidebar.php';
?>
<link rel="stylesheet" href="css/kelola_mapel.css">
<div class="main-content">
  <div class="header-section">
    <h2>📚 Kelola Mata Pelajaran</h2>
  </div>

  <form method="post" class="form-inline">
    <input type="text" name="nama" placeholder="Nama Mata Pelajaran..." required>
    <button type="submit" name="tambah">Tambah</button>
  </form>

  <table class="data-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nama Mata Pelajaran</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($mapel = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= $mapel['id']; ?></td>
          <td><?= htmlspecialchars($mapel['nama']); ?></td>
          <td>
            <a href="kelola_mapel.php?hapus=<?= $mapel['id']; ?>" class="btn-delete" onclick="return confirm('Hapus mata pelajaran ini?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>