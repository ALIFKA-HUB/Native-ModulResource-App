<footer class="footer">
  <div class="footer-container">

    <div class="footer-column">
      <h4>Tentang</h4>
      <ul>
        <li><a href="#">Tentang ModulResource</a></li>
        <li><a href="#">Fitur Utama</a></li>
        <li><a href="#">Tim Pengembang</a></li>
        <li><a href="#">Hubungi Kami</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <h4>Dukungan</h4>
      <ul>
        <li><a href="#">Pusat Bantuan</a></li>
        <li><a href="#">Kebijakan Privasi</a></li>
        <li><a href="#">Syarat & Ketentuan</a></li>
        <li><a href="#">FAQ</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <h4>Sosial</h4>
      <ul>
        <li><a href="#"><img src="assets/image/instagram.png" alt=""> Instagram</a></li>
        <li><a href="#"><img src="assets/image/facebook.png" alt=""> Facebook</a></li>
        <li><a href="#"><img src="assets/image/linkedin.png" alt=""> LinkedIn</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <h4>Dapatkan Aplikasi</h4>
      <a href="#"><img src="assets/image/appstore.png" alt="App Store" class="app-btn"></a>
      <a href="#"><img src="assets/image/googleplay.png" alt="Google Play" class="app-btn"></a>
    </div>

  </div>

  <div class="footer-bottom">
    <p>&copy; <?= date("Y"); ?> ModulResource. Semua hak cipta dilindungi.</p>
  </div>
</footer>

<!-- Tempatkan semua JS di sini, sebelum penutup body -->
<script>
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 10) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
</script>

</body>

</html>