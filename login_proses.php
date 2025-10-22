<?php
session_start();
require 'config/database.php';

$email = mysqli_real_escape_string($koneksi, $_POST['email']);
$password = MD5($_POST['password']);
$role = $_POST['role'];

if ($role == 'dosen') {
    $table = 'dosen'; $id_col = 'nip'; $name_col = 'nama_dosen'; $dashboard = 'admin_dashboard.php';
} else {
    $table = 'mahasiswa'; $id_col = 'nim'; $name_col = 'nama_mahasiswa'; $dashboard = 'mahasiswa_dashboard.php';
}

$query = "SELECT * FROM $table WHERE email='$email' AND password='$password'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $user[$id_col];
    $_SESSION['nama'] = $user[$name_col];
    $_SESSION['role'] = $role;
    header("Location: $dashboard");
} else {
    header("Location: index.php?error=1");
}
?>