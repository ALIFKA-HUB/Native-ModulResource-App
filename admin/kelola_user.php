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

// === HANDLE TAMBAH USER ===
if (isset($_POST['tambah_user'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = mysqli_real_escape_string($conn, $_POST['role']);

  mysqli_query($conn, "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')");
  header("Location: kelola_user.php?added=1");
  exit;
}

// === HANDLE UPDATE DATA USER ===
if (isset($_POST['update_user'])) {
  $id = intval($_POST['id']);
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $role = mysqli_real_escape_string($conn, $_POST['role']);

  mysqli_query($conn, "UPDATE users SET nama='$nama', email='$email', role='$role' WHERE id='$id'");
  header("Location: kelola_user.php?success=1");
  exit;
}

// === HANDLE HAPUS USER ===
if (isset($_GET['hapus'])) {
  $hapus_id = intval($_GET['hapus']);
  mysqli_query($conn, "DELETE FROM users WHERE id = '$hapus_id'");
  header("Location: kelola_user.php");
  exit;
}

// === AMBIL SEMUA USER ===
$result = mysqli_query($conn, "SELECT * FROM users ORDER BY role, nama ASC");

include '../template/navigation-private.php';
include '../template/sidebar.php';
?>

<link rel="stylesheet" href="css/kelola_user.css">

<div class="main-content">
  <div class="header-section">
    <h2>👥 Kelola User</h2>
    <button class="btn-primary" onclick="openAddModal()">+ Tambah User</button>
  </div>

  <p>Daftar semua pengguna sistem (Admin, Guru, dan Siswa).</p>

  <table class="data-table">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td><?= htmlspecialchars($row['email']); ?></td>
            <td><span class="role <?= $row['role']; ?>"><?= ucfirst($row['role']); ?></span></td>
            <td>
              <button
                class="btn-edit"
                onclick="openEditModal(<?= $row['id']; ?>, '<?= htmlspecialchars($row['nama']); ?>', '<?= htmlspecialchars($row['email']); ?>', '<?= $row['role']; ?>')">
                Edit
              </button>
              <a href="kelola_user.php?hapus=<?= $row['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" style="text-align:center;">Belum ada user terdaftar.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- 🔹 MODAL TAMBAH USER -->
<div id="addModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeAddModal()">&times;</span>
    <h3>➕ Tambah User Baru</h3>
    <form method="POST">
      <label>Nama Lengkap</label>
      <input type="text" name="nama" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Password</label>
      <input type="password" name="password" required>

      <label>Role</label>
      <select name="role" required>
        <option value="admin">Admin</option>
        <option value="guru">Guru</option>
        <option value="siswa">Siswa</option>
      </select>

      <button type="submit" name="tambah_user" class="btn-save">Tambah User</button>
    </form>
  </div>
</div>

<!-- 🔹 MODAL EDIT USER -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeEditModal()">&times;</span>
    <h3>✏️ Edit Data User</h3>
    <form method="POST">
      <input type="hidden" name="id" id="edit_id">

      <label>Nama Lengkap</label>
      <input type="text" name="nama" id="edit_nama" required>

      <label>Email</label>
      <input type="email" name="email" id="edit_email" required>

      <label>Role</label>
      <select name="role" id="edit_role" required>
        <option value="admin">Admin</option>
        <option value="guru">Guru</option>
        <option value="siswa">Siswa</option>
      </select>

      <button type="submit" name="update_user" class="btn-save">Simpan Perubahan</button>
    </form>
  </div>
</div>

<style>
  .main-content {
    margin-top: 100px;
    margin-left: 260px;
    margin-right: 30px;
    background: #f8f9fc;
    min-height: calc(100vh - 80px);
  }

  .header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
  }

  .btn-primary {
    background: #2E9B4F;
    color: #fff;
    padding: 10px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 600;
  }

  table.data-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  }

  th {
    background: #1F2A5A;
    color: #fff;
    text-align: left;
    padding: 12px;
  }

  td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
  }

  tr:hover {
    background: #f4f7f9;
  }

  .btn-edit {
    background: #FFD43B;
    color: #000;
    padding: 6px 10px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
  }

  .btn-delete {
    background: #E63946;
    color: #fff;
    padding: 6px 10px;
    border-radius: 5px;
    text-decoration: none;
    margin-left: 5px;
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
  }

  .modal-content {
    background-color: #fff;
    margin: 8% auto;
    padding: 30px;
    border-radius: 10px;
    width: 400px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    position: relative;
    animation: fadeIn 0.3s ease-in-out;
  }

  label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #333;
  }

  input,
  select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
  }

  .btn-save {
    background: #2E9B4F;
    color: #fff;
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    width: 100%;
  }

  .close {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 24px;
    color: #888;
    cursor: pointer;
  }

  .close:hover {
    color: #000;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: scale(0.9);
    }

    to {
      opacity: 1;
      transform: scale(1);
    }
  }
</style>

<script>
  // === TAMBAH USER ===
  function openAddModal() {
    document.getElementById("addModal").style.display = "block";
  }

  function closeAddModal() {
    document.getElementById("addModal").style.display = "none";
  }

  // === EDIT USER ===
  function openEditModal(id, nama, email, role) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nama").value = nama;
    document.getElementById("edit_email").value = email;
    document.getElementById("edit_role").value = role;
    document.getElementById("editModal").style.display = "block";
  }

  function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
  }

  // Tutup modal jika klik di luar area
  window.onclick = function(event) {
    let addModal = document.getElementById("addModal");
    let editModal = document.getElementById("editModal");
    if (event.target == addModal) addModal.style.display = "none";
    if (event.target == editModal) editModal.style.display = "none";
  }
</script>