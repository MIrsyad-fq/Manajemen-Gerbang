<?php session_start(); if(!isset($_SESSION['role']) || $_SESSION['role'] != 'dosen') { header('Location: index.php'); exit(); } require 'config/database.php'; $query = "SELECT m.*, d.nama_dosen FROM mahasiswa m LEFT JOIN dosen d ON m.nip_dosen_wali = d.nip ORDER BY m.nama_mahasiswa ASC"; $result = mysqli_query($koneksi, $query); ?>
<!DOCTYPE html><html lang="id"><head><title>Admin Dashboard</title><link rel="stylesheet" href="assets/style.css"></head>
<body>
    <div class="container">
        <div class="header"><h2>Dashboard Dosen - <?php echo $_SESSION['nama']; ?></h2><a href="logout.php" class="btn btn-danger">Logout</a></div>
        <a href="crud/mahasiswa_buat.php" class="btn btn-primary">➕ Tambah Mahasiswa</a>
        <table><thead><tr><th>NIM</th><th>Nama</th><th>Angkatan</th><th>Dosen Wali</th><th>Aksi</th></tr></thead>
        <tbody><?php while ($mhs = mysqli_fetch_assoc($result)): ?><tr>
            <td><?php echo $mhs['nim']; ?></td>
            <td><?php echo $mhs['nama_mahasiswa']; ?></td><td><?php echo $mhs['angkatan']; ?></td>
            <td><?php echo $mhs['nama_dosen']; ?></td>
            <td><a href="crud/mahasiswa_ubah.php?nim=<?php echo $mhs['nim']; ?>" class="btn btn-warning">Ubah</a> <a href="crud/mahasiswa_hapus.php?nim=<?php echo $mhs['nim']; ?>" class="btn btn-danger">Hapus</a></td>
        </tr><?php endwhile; ?></tbody></table>
    </div>
</body></html>