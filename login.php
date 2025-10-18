<?php
session_start();
include 'koneksi.php';

$email = $_POST['email'];
$password = md5($_POST['password']);

$query = "SELECT * FROM dosen WHERE email='$email' AND password='$password'";
$result = mysqli_query($koneksi, $query);

$cek = mysqli_num_rows($result);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($result);
    $_SESSION['nip'] = $data['nip'];
    $_SESSION['nama_dosen'] = $data['nama_dosen'];
    header("Location: dashboard.php");
} else {
    header("Location: index.php?pesan=gagal");
}
?>