<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../config/database.php';

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

    header("Location: ../dashboard/dashboard.php");
    exit;
} else {
    echo "<script>alert('Email atau password salah!'); window.location.href='login.php';</script>";
    exit;
}
