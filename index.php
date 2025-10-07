<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_css = "index.css";
include "template/header.php";
include "template/navigation-public.php";
?>
<?php if (isset($_GET['status']) && $_GET['status'] == 'registered'): ?>
  <script>
    alert("Registrasi berhasil! Silakan login untuk melanjutkan.");
  </script>
<?php endif; ?>

<!-- ===== HERO SECTION ===== -->
<section class="hero">
    <div class="hero-content">
        <h1>Temukan dan Kelola Modul Ajar Digital dengan Mudah</h1>
        <p>ModulResource memudahkan guru untuk berbagi dan siswa untuk belajar.
            Unduh, unggah, dan kelola modul ajar hanya dengan beberapa klik.</p>
        <a href="auth/register.php" class="btn-primary">Mulai Sekarang</a>
    </div>
    <div class="hero-image">
        <img src="assets/image/learning-people.png" alt="Ilustrasi ModulResource">
    </div>
</section>

<!-- ===== FITUR UNGGULAN ===== -->
<section class="features">
    <h2>Fitur Unggulan</h2>
    <div class="feature-list">
        <div class="feature-item">
            <img src="assets/image/feature1.png" alt="Upload Modul">
            <h3>Upload Modul</h3>
            <p>Guru dapat mengunggah modul ajar dalam format PDF dengan mudah dan cepat.</p>
        </div>
        <div class="feature-item">
            <img src="assets/image/feature2.png" alt="Download Modul">
            <h3>Download Modul</h3>
            <p>Siswa dapat mengunduh modul gratis atau berbayar untuk mendukung pembelajaran mereka.</p>
        </div>
        <div class="feature-item">
            <img src="assets/image/feature3.png" alt="Laporan & Transaksi">
            <h3>Laporan & Transaksi</h3>
            <p>Admin dapat memantau statistik modul, transaksi, dan aktivitas unduhan dengan mudah.</p>
        </div>
    </div>
</section>

<!-- ===== STATISTIK ===== -->
<section class="stats">
    <div class="stats-content">
        <h2>Statistik Pengguna ModulResource</h2>
        <p>Semakin banyak guru dan siswa mempercayai ModulResource sebagai media belajar digital.</p>
    </div>
    <br> <br>
    <div class="stat-list">
        <div class="stat-item">
            <img src="assets/image/module-icon.png" alt="Modul">
            <h3>1.200+</h3>
            <p>Modul Ajar Digital</p>
        </div>
        <div class="stat-item">
            <img src="assets/image/teacher-icon.png" alt="Guru">
            <h3>500+</h3>
            <p>Guru Pengunggah</p>
        </div>
        <div class="stat-item">
            <img src="assets/image/student-icon.png" alt="Siswa">
            <h3>2.000+</h3>
            <p>Siswa Aktif</p>
        </div>
    </div>
</section>


<!-- ===== WHY US ===== -->
<section class="why-us">
    <h2>Kenapa Memilih ModulResource?</h2>
    <div class="why-list">
        <div class="why-item">
            <img src="assets/image/verified.png" alt="Terpercaya">
            <h3>Terpercaya</h3>
            <p>Dipercaya oleh guru dan siswa dari berbagai sekolah di Indonesia.</p>
        </div>
        <div class="why-item">
            <img src="assets/image/easy1.png" alt="Mudah Digunakan">
            <h3>Mudah Digunakan</h3>
            <p>Tampilan sederhana dan navigasi yang intuitif untuk semua pengguna.</p>
        </div>
        <div class="why-item">
            <img src="assets/image/support.png" alt="Dukungan Penuh">
            <h3>Dukungan Penuh</h3>
            <p>Kami siap membantu kapan pun kamu butuh bantuan teknis.</p>
        </div>
    </div>
</section>

<!-- ===== TESTIMONI ===== -->
<section class="testimoni">
    <h2>Apa Kata Mereka?</h2>
    <br><br>
    <div class="testi-list">
        <div class="testi-item">
            <p>“ModulResource mempermudah saya membagikan materi ke murid-murid tanpa repot.”</p>
            <h4>- Pak Yayat, Guru RPL</h4>
        </div>
        <div class="testi-item">
            <p>“Saya suka karena banyak modul gratis dan bisa langsung dipelajari di mana saja.”</p>
            <h4>- Farris, Siswa SMK</h4>
        </div>
        <div class="testi-item">
            <p>“ModulResource sangat membantu saya dalam belajar. Semua materi ada di sini!”</p>
            <h4>- Putra, Siswa SMK</h4>
        </div>
    </div>
</section>

<!-- ===== CTA (Call To Action) ===== -->
<section class="cta">
    <div class="cta-content">
        <div class="cta-text">
            <h2>Bergabunglah Bersama Komunitas Pembelajaran Digital!</h2>
            <p>
                Jadilah bagian dari revolusi pembelajaran modern.
                ModulResource membantu guru berbagi ilmu dan siswa belajar tanpa batas.
            </p>
            <a href="auth/register.php" class="btn-secondary">Daftar Sekarang</a>
        </div>
        <div class="cta-image">
            <img src="assets/image/study-together.png" alt="Belajar bersama">
        </div>
    </div>
</section>


<?php include "template/footer.php"; ?>