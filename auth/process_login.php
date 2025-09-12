<?php
session_start();
include '../config/database.php';

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if($user && password_verify($password, $user['password'])) {
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['user_nama'] = $user['nama'];
  $_SESSION['role'] = $user['role'];

  header("Location: ../dashboard.php");
  exit;
} else {
  echo "<p class='error-msg'>Login gagal! <a href='login.php'>Coba lagi</a></p>";
}
