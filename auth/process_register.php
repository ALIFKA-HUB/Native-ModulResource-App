<?php
include '../config/database.php';

// Ambil data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Cegah SQL Injection (aman)
$nama = mysqli_real_escape_string($conn, $nama);
$email = mysqli_real_escape_string($conn, $email);
$role = mysqli_real_escape_string($conn, $role);

// Hash password sebelum disimpan
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Query simpan user
$sql = "INSERT INTO users (nama, email, password, role) 
        VALUES ('$nama', '$email', '$hashedPassword', '$role')";

if (mysqli_query($conn, $sql)) {
  // Redirect ke halaman utama (landing page)
  header("Location: ../index.php?status=registered");
  exit();
} else {
  echo "Gagal registrasi: " . mysqli_error($conn);
}

mysqli_close($conn);
