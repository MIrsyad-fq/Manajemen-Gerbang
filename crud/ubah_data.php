<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'dosen') { header('Location: ../index.php'); exit(); }
require '../config/database.php';
$nim = $_GET['nim'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_mahasiswa']);
    $angkatan = mysqli_real_escape_string($koneksi, $_POST['angkatan']);
    $nip_dosen = mysqli_real_escape_string($koneksi, $_POST['nip_dosen_wali']);
    mysqli_query($koneksi, "UPDATE mahasiswa SET nama_mahasiswa='$nama', angkatan='$angkatan', nip_dosen_wali='$nip_dosen' WHERE nim='$nim'");
    
    if (isset($_POST['frs_status'])) {
        foreach ($_POST['frs_status'] as $id_frs => $status) {
            $status = mysqli_real_escape_string($koneksi, $status);
            mysqli_query($koneksi, "UPDATE frs SET status_frs='$status' WHERE id_frs='$id_frs'");
        }
    }
    header("Location: ../admin_dashboard.php");
    exit();
}

$mhs_query = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nim='$nim'");
$mhs = mysqli_fetch_assoc($mhs_query);
$dosen_query = mysqli_query($koneksi, "SELECT * FROM dosen");
$frs_query = mysqli_query($koneksi, "SELECT * FROM frs WHERE nim='$nim'");
?>
<!DOCTYPE html><html lang="id"><head><title>Ubah Data</title><link rel="stylesheet" href="../assets/style.css"></head>
<body><div class="container"><h2>Ubah Data Mahasiswa & FRS</h2>
<form action="ubah_data.php?nim=<?php echo $nim; ?>" method="POST">
    <h4>Data Mahasiswa</h4>
    <div class="form-group"><label>Nama</label><input type="text" name="nama_mahasiswa" value="<?php echo $mhs['nama_mahasiswa']; ?>"></div>
    <div class="form-group"><label>Angkatan</label><input type="number" name="angkatan" value="<?php echo $mhs['angkatan']; ?>"></div>
    <div class="form-group"><label>Dosen Wali</label><select name="nip_dosen_wali">
        <?php while ($dosen = mysqli_fetch_assoc($dosen_query)): ?>
        <option value="<?php echo $dosen['nip']; ?>" <?php if($mhs['nip_dosen_wali'] == $dosen['nip']) echo 'selected'; ?>><?php echo $dosen['nama_dosen']; ?></option>
        <?php endwhile; ?>
    </select></div>
    
    <h4 style="margin-top:30px;">Persetujuan FRS</h4>
    <table><thead><tr><th>Nama MK</th><th>Status</th></tr></thead>
    <tbody><?php while ($frs = mysqli_fetch_assoc($frs_query)): ?><tr>
        <td><?php echo $frs['nama_matkul']; ?></td>
        <td><select name="frs_status[<?php echo $frs['id_frs']; ?>]">
            <option value="Menunggu" <?php if($frs['status_frs'] == 'Menunggu') echo 'selected'; ?>>Menunggu</option>
            <option value="Disetujui" <?php if($frs['status_frs'] == 'Disetujui') echo 'selected'; ?>>Disetujui</option>
            <option value="Ditolak" <?php if($frs['status_frs'] == 'Ditolak') echo 'selected'; ?>>Ditolak</option>
        </select></td>
    </tr><?php endwhile; ?></tbody></table>
    <div style="margin-top:20px;"><button type="submit" class="btn btn-success">Update Data</button> <a href="../admin_dashboard.php" class="btn btn-secondary">Batal</a></div>
</form></div></body></html>