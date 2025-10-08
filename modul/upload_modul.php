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
$success = "";
$error = "";

// proses upload modul
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $judul = mysqli_real_escape_string($conn, $_POST['judul']);
  $mapel_id = $_POST['mapel_id'];
  $tipe = $_POST['tipe'];
  $harga = ($tipe === 'gratis') ? 0 : $_POST['harga'];
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

  // validasi file
  if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_name = basename($_FILES['file']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if ($file_ext !== 'pdf') {
      $error = "File harus berformat PDF!";
    } else {
      $target_dir = "../uploads/";
      if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

      $new_filename = time() . "_" . $file_name;
      $target_path = $target_dir . $new_filename;
      $file_url = "uploads/" . $new_filename;

      if (move_uploaded_file($file_tmp, $target_path)) {
        $query = "
          INSERT INTO modul_ajar (judul, mapel_id, guru_id, tipe, harga, deskripsi, file_url)
          VALUES ('$judul', '$mapel_id', '$guru_id', '$tipe', '$harga', '$deskripsi', '$file_url')
        ";
        if (mysqli_query($conn, $query)) {
          $success = "Modul berhasil diunggah!";
        } else {
          $error = "Gagal menyimpan data ke database.";
        }
      } else {
        $error = "Gagal mengunggah file.";
      }
    }
  } else {
    $error = "Silakan pilih file untuk diunggah.";
  }
}

include '../template/navigation-private.php';
include '../template/sidebar.php';
?>

<link rel="stylesheet" href="css/upload_modul.css">
<div class="main-content">
  <div class="upload-container">
    <h2>📤 Upload Modul Baru</h2>
    <p>Lengkapi form di bawah ini untuk menambahkan modul baru ke sistem.</p>

    <?php if ($success): ?>
      <div class="alert success"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
      <div class="alert error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="upload-form">
      <label>Judul Modul</label>
      <input type="text" name="judul" required>

      <label>Mata Pelajaran</label>
      <select name="mapel_id" required>
        <option value="">-- Pilih Mata Pelajaran --</option>
        <?php
        $mapel = mysqli_query($conn, "SELECT * FROM mata_pelajaran");
        while ($m = mysqli_fetch_assoc($mapel)) {
          echo "<option value='{$m['id']}'>{$m['nama']}</option>";
        }
        ?>
      </select>

      <label>Tipe Modul</label>
      <select name="tipe" id="tipe" required onchange="toggleHarga()">
        <option value="gratis">Gratis</option>
        <option value="berbayar">Berbayar</option>
      </select>

      <div id="harga-field" style="display:none;">
        <label>Harga (Rp)</label>
        <input type="number" name="harga" min="1000" placeholder="contoh: 5000">
      </div>

      <label>Deskripsi Modul</label>
      <textarea name="deskripsi" rows="4" required placeholder="Tulis deskripsi singkat modul..."></textarea>

      <label>Upload File (PDF)</label>
      <input type="file" name="file" accept=".pdf" required>

      <button type="submit" class="btn-upload">💾 Simpan Modul</button>
    </form>

    <div class="back-link">
      <a href="kelola_modul.php">← Kembali ke Modul Saya</a>
    </div>
  </div>
</div>

<!-- Script untuk tampil/sembunyi harga -->
<script>
  function toggleHarga() {
    const tipe = document.getElementById('tipe').value;
    const hargaField = document.getElementById('harga-field');
    hargaField.style.display = (tipe === 'berbayar') ? 'block' : 'none';
  }
</script>