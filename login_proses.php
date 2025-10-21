<?php
session_start();
require 'config/database.php';

$email = mysqli_real_escape_string($koneksi, $_POST['email']);
$password = MD5($_POST['password']);

// 1. Coba login sebagai Dosen (Admin) terlebih dahulu
$query_dosen = "SELECT * FROM dosen WHERE email='$email' AND password='$password'";
$result_dosen = mysqli_query($koneksi, $query_dosen);

if (mysqli_num_rows($result_dosen) > 0) {
    // Jika berhasil, set session sebagai dosen dan arahkan ke dashboard admin
    $user = mysqli_fetch_assoc($result_dosen);
    $_SESSION['user_id'] = $user['nip'];
    $_SESSION['nama'] = $user['nama_dosen'];
    $_SESSION['role'] = 'dosen';
    header("Location: admin_dashboard.php");
    exit();
}

// 2. Jika gagal sebagai dosen, coba login sebagai Mahasiswa
$query_mahasiswa = "SELECT * FROM mahasiswa WHERE email='$email' AND password='$password'";
$result_mahasiswa = mysqli_query($koneksi, $query_mahasiswa);

if (mysqli_num_rows($result_mahasiswa) > 0) {
    // Jika berhasil, set session sebagai mahasiswa dan arahkan ke dashboard mahasiswa
    $user = mysqli_fetch_assoc($result_mahasiswa);
    $_SESSION['user_id'] = $user['nim'];
    $_SESSION['nama'] = $user['nama_mahasiswa'];
    $_SESSION['role'] = 'mahasiswa';
    header("Location: mahasiswa_dashboard.php");
    exit();
}

// 3. Jika keduanya gagal, kembali ke halaman login dengan pesan error
header("Location: index.php?error=1");
exit();

?>