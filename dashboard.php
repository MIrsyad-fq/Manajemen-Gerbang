<?php
session_start();
if (!isset($_SESSION['nip'])) {
    header("Location: index.php");
    exit();
}
include 'koneksi.php';
$nip_dosen = $_SESSION['nip'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Dosen Wali</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container dashboard-container">
        <div class="header">
            <h2>Selamat Datang, <?php echo $_SESSION['nama_dosen']; ?></h2>
            <div>
                <a href="tambah_mahasiswa.php">Tambah Mahasiswa</a>
                <a href="logout.php" style="background-color: #dc3545;">Logout</a>
            </div>
        </div>
        <h3>Daftar Mahasiswa Perwalian</h3>
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Angkatan</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM mahasiswa WHERE nip_dosen_wali='$nip_dosen'";
                $result = mysqli_query($koneksi, $query);
                while ($mhs = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $mhs['nim'] . "</td>";
                    echo "<td>" . $mhs['nama_mahasiswa'] . "</td>";
                    echo "<td>" . $mhs['angkatan'] . "</td>";
                    echo "<td>" . $mhs['email'] . "</td>";
                    echo "<td class='action-links'>";
                    echo "<a href='edit_perwalian.php?nim=" . $mhs['nim'] . "' class='edit'>Edit FRS</a>";
                    // Link hapus bisa ditambahkan di sini jika diperlukan
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>