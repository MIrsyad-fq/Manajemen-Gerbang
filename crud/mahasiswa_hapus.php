<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'dosen') { header('Location: ../index.php'); exit(); }
require '../config/database.php';
$nim = $_GET['nim'];

if (isset($_POST['confirm_delete'])) {
    mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE nim='$nim'");
    header("Location: ../admin_dashboard.php");
    exit();
}

$mhs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama_mahasiswa FROM mahasiswa WHERE nim='$nim'"));
?>
<!DOCTYPE html><html lang="id"><head><title>Hapus Data</title><link rel="stylesheet" href="../assets/style.css"></head>
<body><div class="container"><div style="max-width:600px; padding:30px; border:1px solid #ddd; border-left:5px solid #dc3545;">
    <h2>Konfirmasi Hapus</h2>
    <p>Anda yakin ingin menghapus data mahasiswa <strong><?php echo $mhs['nama_mahasiswa']; ?></strong>? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data FRS terkait.</p>
    <form action="mahasiswa_hapus.php?nim=<?php echo $nim; ?>" method="POST">
        <button type="submit" name="confirm_delete" class="btn btn-danger">Ya, Hapus</button>
        <a href="../admin_dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
</div></div></body></html>