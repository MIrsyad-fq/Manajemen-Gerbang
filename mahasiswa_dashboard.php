<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'mahasiswa') { header('Location: index.php'); exit(); }
require 'config/database.php';
$nim = $_SESSION['user_id'];

// Proses tambah FRS
if (isset($_POST['tambah_frs'])) {
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode_matkul']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_matkul']);
    $sks = mysqli_real_escape_string($koneksi, $_POST['sks']);
    mysqli_query($koneksi, "INSERT INTO frs (nim, kode_matkul, nama_matkul, sks) VALUES ('$nim', '$kode', '$nama', '$sks')");
    header('Location: mahasiswa_dashboard.php'); exit();
}

// Proses hapus FRS
if (isset($_GET['hapus_frs'])) {
    $id_frs = $_GET['hapus_frs'];
    // Security check: pastikan FRS milik mahasiswa yang login
    $cek_query = mysqli_query($koneksi, "SELECT nim FROM frs WHERE id_frs='$id_frs'");
    $frs_data = mysqli_fetch_assoc($cek_query);
    if ($frs_data && $frs_data['nim'] == $nim) {
        mysqli_query($koneksi, "DELETE FROM frs WHERE id_frs='$id_frs'");
    }
    header('Location: mahasiswa_dashboard.php'); exit();
}

$query = "SELECT * FROM frs WHERE nim='$nim'";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html><html lang="id"><head><title>Mahasiswa Dashboard</title><link rel="stylesheet" href="assets/style.css"></head>
<body>
    <div class="container">
        <div class="header"><h2>Dashboard Mahasiswa - <?php echo $_SESSION['nama']; ?></h2><a href="logout.php" class="btn btn-danger">Logout</a></div>
        <div style="display:flex; gap: 30px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <h3>Ajukan FRS Baru</h3>
                <form action="mahasiswa_dashboard.php" method="POST"><input type="hidden" name="tambah_frs" value="1">
                    <div class="form-group"><label>Kode Matakuliah</label><input type="text" name="kode_matkul" required></div>
                    <div class="form-group"><label>Nama Matakuliah</label><input type="text" name="nama_matkul" required></div>
                    <div class="form-group"><label>SKS</label><input type="number" name="sks" required></div>
                    <button type="submit" class="btn btn-success">Ajukan</button>
                </form>
            </div>
            <div style="flex: 2; min-width: 500px;">
                <h3>Status FRS Anda</h3>
                <table><thead><tr><th>Kode MK</th><th>Nama MK</th><th>SKS</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while ($frs = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $frs['kode_matkul']; ?></td>
                            <td><?php echo $frs['nama_matkul']; ?></td>
                            <td><?php echo $frs['sks']; ?></td>
                            <td><span class="status status-<?php echo strtolower($frs['status_frs']); ?>"><?php echo $frs['status_frs']; ?></span></td>
                            <td><a href="mahasiswa_dashboard.php?hapus_frs=<?php echo $frs['id_frs']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pengajuan FRS ini?')">Hapus</a></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center;">Anda belum memiliki data FRS.</td></tr>
                    <?php endif; ?>
                </tbody></table>
            </div>
        </div>
    </div>
</body></html>