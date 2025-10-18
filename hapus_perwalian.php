<?php
include 'koneksi.php';
$id_frs = $_GET['id'];
$nim = $_GET['nim'];

mysqli_query($koneksi, "DELETE FROM frs WHERE id_frs='$id_frs'");

header("Location: edit_perwalian.php?nim=" . $nim);
?>