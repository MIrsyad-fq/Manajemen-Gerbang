<?php
session_start();
if (!isset($_SESSION['nip'])) {
    header("Location: index.php"); exit();
}
include 'koneksi.php';
$nim = $_GET['nim'];
$mhs_query = mysqli_query($koneksi, "SELECT nama_mahasiswa FROM mahasiswa WHERE nim='$nim'");
$mhs = mysqli_fetch_assoc($mhs_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit FRS Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container dashboard-container">
        <h3>Edit Perwalian FRS untuk <?php echo $mhs['nama_mahasiswa']; ?> (<?php echo $nim; ?>)</h3>
        <h4>Tambah Mata Kuliah</h4>
        <form action="proses_edit.php" method="POST">
             <input type="hidden" name="nim" value="<?php echo $nim; ?>">
             <input type="hidden" name="aksi" value="tambah_matkul">
             <div class="input-group"><label>Kode Matkul</label><input type="text" name="kode_matkul"></div>
             <div class="input-group"><label>Nama Matkul</label><input type="text" name="nama_matkul"></div>
             <div class="input-group"><label>SKS</label><input type="number" name="sks"></div>
             <div class="input-group"><label>Semester</label><input type="number" name="semester"></div>
             <button type="submit" class="btn" style="background-color:#28a745;">Tambah Matkul</button>
        </form>
        
        <hr style="margin: 30px 0;">
        
        <h4>Daftar Mata Kuliah di FRS</h4>
        <table>
            <thead><tr><th>Kode</th><th>Mata Kuliah</th><th>SKS</th><th>Semester</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php
            $frs_query = mysqli_query($koneksi, "SELECT * FROM frs WHERE nim='$nim'");
            while ($frs = mysqli_fetch_assoc($frs_query)) {
                echo "<tr>";
                echo "<td>" . $frs['kode_matkul'] . "</td>";
                echo "<td>" . $frs['nama_matkul'] . "</td>";
                echo "<td>" . $frs['sks'] . "</td>";
                echo "<td>" . $frs['semester'] . "</td>";
                echo "<td>";
                echo "<form action='proses_edit.php' method='POST' style='display:inline;'>";
                echo "<input type='hidden' name='id_frs' value='".$frs['id_frs']."'>";
                echo "<input type='hidden' name='nim' value='".$nim."'>";
                echo "<input type='hidden' name='aksi' value='update_status'>";
                echo "<select name='status_persetujuan' onchange='this.form.submit()'>";
                echo "<option value='Menunggu'" . ($frs['status_persetujuan'] == 'Menunggu' ? ' selected' : '') . ">Menunggu</option>";
                echo "<option value='Disetujui'" . ($frs['status_persetujuan'] == 'Disetujui' ? ' selected' : '') . ">Disetujui</option>";
                echo "<option value='Ditolak'" . ($frs['status_persetujuan'] == 'Ditolak' ? ' selected' : '') . ">Ditolak</option>";
                echo "</select>";
                echo "</form>";
                echo "</td>";
                echo "<td class='action-links'><a href='hapus_perwalian.php?id=".$frs['id_frs']."&nim=".$nim."' class='delete' onclick='return confirm(\"Yakin hapus matkul ini?\")'>Hapus</a></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <a href="dashboard.php" style="display:block; margin-top:20px;">Kembali ke Dashboard</a>
    </div>
</body>
</html>