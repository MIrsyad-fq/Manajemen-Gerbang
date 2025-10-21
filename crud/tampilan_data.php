<?php session_start(); if(!isset($_SESSION['role']) || $_SESSION['role'] != 'dosen') { header('Location: ../index.php'); exit(); } require '../config/database.php'; $nim = $_GET['nim']; $mhs_query = mysqli_query($koneksi, "SELECT m.*, d.nama_dosen FROM mahasiswa m LEFT JOIN dosen d ON m.nip_dosen_wali = d.nip WHERE nim='$nim'"); $mhs = mysqli_fetch_assoc($mhs_query); $frs_query = mysqli_query($koneksi, "SELECT * FROM frs WHERE nim='$nim'"); ?>
<!DOCTYPE html><html lang="id"><head><title>Detail Mahasiswa</title><link rel="stylesheet" href="../assets/style.css"></head>
<body><div class="container"><h2>Detail Mahasiswa: <?php echo $mhs['nama_mahasiswa']; ?></h2>
<p><strong>NIM:</strong> <?php echo $mhs['nim']; ?><br><strong>Angkatan:</strong> <?php echo $mhs['angkatan']; ?><br><strong>Email:</strong> <?php echo $mhs['email']; ?><br><strong>Dosen Wali:</strong> <?php echo $mhs['nama_dosen']; ?></p>
<h3 style="margin-top:30px;">Data FRS</h3>
<table><thead><tr><th>Kode MK</th><th>Nama MK</th><th>SKS</th><th>Status</th></tr></thead>
<tbody><?php while ($frs = mysqli_fetch_assoc($frs_query)): ?><tr>
<td><?php echo $frs['kode_matkul']; ?></td><td><?php echo $frs['nama_matkul']; ?></td><td><?php echo $frs['sks']; ?></td>
<td><span class="status status-<?php echo strtolower($frs['status_frs']); ?>"><?php echo $frs['status_frs']; ?></span></td>
</tr><?php endwhile; ?></tbody></table>
<a href="../admin_dashboard.php" class="btn btn-secondary" style="margin-top:20px;">Kembali</a>
</div></body></html>