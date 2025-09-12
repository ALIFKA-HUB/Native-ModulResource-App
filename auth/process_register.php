<?php
include '../config/database.php';

$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (nama, email, password, role) 
        VALUES ('$nama', '$email', '$hashedPassword', '$role')";

if (mysqli_query($conn, $sql)) {
  echo "Registrasi berhasil! <a href='login.php'>Login di sini</a>";
} else {
  echo "Gagal registrasi: " . mysqli_error($conn);
}
