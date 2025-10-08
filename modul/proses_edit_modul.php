<?php
include '../config/database.php';
session_start();

if ($_SESSION['role'] !== 'guru') {
  exit('Akses ditolak!');
}

$id = $_POST['id'];
$judul = mysqli_real_escape_string($conn, $_POST['judul']);
$mapel_id = $_POST['mapel_id'];
$tipe = $_POST['tipe'];
$harga = ($tipe === 'gratis') ? 0 : $_POST['harga'];
$deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

$query = "
  UPDATE modul_ajar 
  SET judul='$judul',
      mapel_id='$mapel_id',
      tipe='$tipe',
      harga='$harga',
      deskripsi='$deskripsi'
  WHERE id='$id'
";

if (mysqli_query($conn, $query)) {
  echo "<script>alert('Modul berhasil diperbarui!');window.location='kelola_modul.php';</script>";
} else {
  echo "<script>alert('Gagal memperbarui data.');window.history.back();</script>";
}
?>
