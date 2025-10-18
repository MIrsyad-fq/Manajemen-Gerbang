<?php
session_start();
if (!isset($_SESSION['nip'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Data Mahasiswa</h2>
        <form action="proses_tambah.php" method="post">
            <input type="hidden" name="nip_dosen_wali" value="<?php echo $_SESSION['nip']; ?>">
            <div class="input-group">
                <label>NIM</label>
                <input type="text" name="nim" required>
            </div>
            <div class="input-group">
                <label>Nama Mahasiswa</label>
                <input type="text" name="nama_mahasiswa" required>
            </div>
            <div class="input-group">
                <label>Angkatan</label>
                <input type="number" name="angkatan" required>
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <button type="submit" class="btn">Simpan</button>
        </form>
    </div>
</body>
</html>