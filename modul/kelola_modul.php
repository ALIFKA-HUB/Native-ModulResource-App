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

// ambil semua modul milik guru ini
$query = "
  SELECT 
    m.id, 
    m.judul, 
    m.tipe, 
    m.harga,
    m.deskripsi,
    mp.nama AS mapel,
    (SELECT COUNT(*) FROM log_download WHERE modul_id = m.id) AS total_download
  FROM modul_ajar m
  JOIN mata_pelajaran mp ON m.mapel_id = mp.id
  WHERE m.guru_id = '$guru_id'
  ORDER BY m.id DESC
";
$result = mysqli_query($conn, $query);

// proses hapus modul
if (isset($_GET['act']) && $_GET['act'] == 'hapus') {
  mysqli_query($conn, "DELETE FROM modul_ajar WHERE id='" . $_GET['id'] . "'") or die("Gagal Hapus");
  header('Location: kelola_modul.php'); exit;
}

include '../template/navigation-private.php';
?>
<link rel="stylesheet" href="css/kelola_modul.css">
<?php include '../template/sidebar.php'; ?>
<div class="main-content">
  <div class="header-section">
    <h2>📚 Modul Saya</h2>
    <a href="upload_modul.php" class="btn-primary">+ Upload Modul Baru</a>
  </div>

  <p>Kelola semua modul yang telah Anda unggah.</p>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Judul Modul</th>
          <th>Mata Pelajaran</th>
          <th>Tipe</th>
          <th>Harga</th>
          <th>Unduhan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['judul']); ?></td>
              <td><?php echo htmlspecialchars($row['mapel']); ?></td>
              <td><?php echo ucfirst($row['tipe']); ?></td>
              <td>
                <?php echo ($row['tipe'] === 'gratis')
                  ? 'Gratis'
                  : 'Rp ' . number_format($row['harga'], 0, ',', '.'); ?>
              </td>
              <td><?php echo $row['total_download']; ?></td>
              <td class="actions">
                <a href="detail_modul.php?id=<?php echo $row['id']; ?>" class="btn-view">Lihat</a>
                <a href="#"
                  class="btn-edit"
                  data-id="<?php echo $row['id']; ?>"
                  data-judul="<?php echo htmlspecialchars($row['judul']); ?>"
                  data-mapel="<?php echo htmlspecialchars($row['mapel']); ?>"
                  data-tipe="<?php echo htmlspecialchars($row['tipe']); ?>"
                  data-harga="<?php echo htmlspecialchars($row['harga']); ?>"
                  data-deskripsi="<?php echo htmlspecialchars($row['deskripsi']); ?>">
                  Edit
                </a>
                <a href="kelola_modul.php?act=hapus&id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus modul ini?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align:center;">Belum ada modul yang diunggah.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ===================== MODAL EDIT ===================== -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3>✏️ Edit Modul</h3>
    <form id="editForm" method="POST" action="proses_edit_modul.php">
      <input type="hidden" name="id" id="edit_id">

      <label>Judul Modul</label>
      <input type="text" name="judul" id="edit_judul" required>

      <label>Mata Pelajaran</label>
      <select name="mapel_id" id="edit_mapel" required>
        <?php
        $mapel = mysqli_query($conn, "SELECT * FROM mata_pelajaran");
        while ($m = mysqli_fetch_assoc($mapel)) {
          echo "<option value='{$m['id']}'>{$m['nama']}</option>";
        }
        ?>
      </select>

      <label>Tipe</label>
      <select name="tipe" id="edit_tipe" required>
        <option value="gratis">Gratis</option>
        <option value="berbayar">Berbayar</option>
      </select>

      <label>Harga (Rp)</label>
      <input type="number" name="harga" id="edit_harga" min="0" value="0">

      <label>Deskripsi</label>
      <textarea name="deskripsi" id="edit_deskripsi" rows="4" required></textarea>

      <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
    </form>
  </div>
</div>

<!-- ===================== CSS MODAL ===================== -->
<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
  }

  .modal-content {
    background: #fff;
    margin: 8% auto;
    padding: 25px 30px;
    border-radius: 10px;
    width: 450px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    position: relative;
  }

  .modal-content h3 {
    margin-bottom: 15px;
    color: #1F2A5A;
  }

  .close {
    position: absolute;
    top: 12px;
    right: 16px;
    font-size: 20px;
    cursor: pointer;
    color: #333;
  }

  label {
    display: block;
    margin-top: 10px;
    font-weight: 600;
    color: #1F2A5A;
  }

  input,
  select,
  textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-top: 5px;
  }

  .btn-save {
    background-color: #2E9B4F;
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 6px;
    margin-top: 15px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
  }

  .btn-save:hover {
    background-color: #22863a;
  }
</style>

<!-- ===================== JAVASCRIPT ===================== -->
<script>
  const modal = document.getElementById("editModal");
  const closeBtn = document.querySelector(".close");
  const form = document.getElementById("editForm");

  document.querySelectorAll(".btn-edit").forEach(btn => {
    btn.addEventListener("click", function(e) {
      e.preventDefault();
      modal.style.display = "block";
      document.getElementById("edit_id").value = this.dataset.id;
      document.getElementById("edit_judul").value = this.dataset.judul;
      document.getElementById("edit_deskripsi").value = this.dataset.deskripsi;
      document.getElementById("edit_tipe").value = this.dataset.tipe.toLowerCase();
      document.getElementById("edit_harga").value = this.dataset.harga;

      const mapelSelect = document.getElementById("edit_mapel");
      for (let opt of mapelSelect.options) {
        if (opt.text === this.dataset.mapel) opt.selected = true;
      }
    });
  });

  closeBtn.onclick = () => modal.style.display = "none";
  window.onclick = e => {
    if (e.target == modal) modal.style.display = "none";
  };
</script>