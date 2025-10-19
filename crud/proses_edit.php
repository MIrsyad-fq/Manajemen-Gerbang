<?php
include 'koneksi.php';
$nim = $_POST['nim'];
$aksi = $_POST['aksi'];

if ($aksi == 'update_status') {
    $id_frs = $_POST['id_frs'];
    $status = $_POST['status_persetujuan'];
    mysqli_query($koneksi, "UPDATE frs SET status_persetujuan='$status' WHERE id_frs='$id_frs'");

} elseif ($aksi == 'tambah_matkul') {
    $kode_matkul = $_POST['kode_matkul'];
    $nama_matkul = $_POST['nama_matkul'];
    $sks = $_POST['sks'];
    $semester = $_POST['semester'];
    mysqli_query($koneksi, "INSERT INTO frs (nim, kode_matkul, nama_matkul, sks, semester) VALUES ('$nim', '$kode_matkul', '$nama_matkul', '$sks', '$semester')");
}

header("Location: edit_perwalian.php?nim=" . $nim);
?>