<?php session_start(); if(!isset($_SESSION['role']) || $_SESSION['role'] != 'dosen') { header('Location: ../index.php'); exit(); } require '../config/database.php'; $dosen_query = mysqli_query($koneksi, "SELECT * FROM dosen"); if ($_SERVER["REQUEST_METHOD"] == "POST") { $nim = mysqli_real_escape_string($koneksi, $_POST['nim']); $nama = mysqli_real_escape_string($koneksi, $_POST['nama_mahasiswa']); $angkatan = mysqli_real_escape_string($koneksi, $_POST['angkatan']); $email = mysqli_real_escape_string($koneksi, $_POST['email']); $password = MD5($_POST['password']); $nip_dosen = mysqli_real_escape_string($koneksi, $_POST['nip_dosen_wali']); $query = "INSERT INTO mahasiswa (nim, nama_mahasiswa, angkatan, email, password, nip_dosen_wali) VALUES ('$nim', '$nama', '$angkatan', '$email', '$password', '$nip_dosen')"; mysqli_query($koneksi, $query); header("Location: ../admin_dashboard.php"); exit(); } ?>
<!DOCTYPE html><html lang="id"><head><title>Tambah Mahasiswa</title><link rel="stylesheet" href="../assets/style.css"></head>
<body><div class="container"><h2>Tambah Mahasiswa Baru</h2>
<form action="buat_data.php" method="POST">
    <div class="form-group"><label>NIM</label><input type="text" name="nim" required></div>
    <div class="form-group"><label>Nama</label><input type="text" name="nama_mahasiswa" required></div>
    <div class="form-group"><label>Angkatan</label><input type="number" name="angkatan" required></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
    <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
    <div class="form-group"><label>Dosen Wali</label><select name="nip_dosen_wali" required>
        <option value="">-- Pilih Dosen --</option>
        <?php mysqli_data_seek($dosen_query, 0); while ($dosen = mysqli_fetch_assoc($dosen_query)): ?>
        <option value="<?php echo $dosen['nip']; ?>"><?php echo $dosen['nama_dosen']; ?></option>
        <?php endwhile; ?>
    </select></div>
    <button type="submit" class="btn btn-success">Simpan</button> <a href="../admin_dashboard.php" class="btn btn-secondary">Batal</a>
</form></div></body></html>