<?php
$host = "localhost";
$user = "root";     // default XAMPP
$pass = "";         // default kosong
$db   = "modulresource_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
