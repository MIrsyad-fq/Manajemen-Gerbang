<?php
require_once '../config/database.php';

class AksesRead {
    private $connection;
    
    public function __construct() {
        $db = new Database();
        $this->connection = $db->getConnection();
    }
    
    public function getAllAkses() {
        $query = "SELECT a.*, COALESCE(m.nama_mahasiswa, d.nama_dosen) AS nama_pengguna
                  FROM akses a
                  LEFT JOIN mahasiswa m ON a.id_pengguna = m.nim AND a.tipe_pengguna = 'Mahasiswa'
                  LEFT JOIN dosen d ON a.id_pengguna = d.nip AND a.tipe_pengguna = 'Dosen'
                  ORDER BY a.timestamp DESC";
        $result = mysqli_query($this->connection, $query);
        $data = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) $data[] = $row;
        }
        return $data;
    }
    
    public function searchAkses($keyword) {
        $query = "SELECT a.*, COALESCE(m.nama_mahasiswa, d.nama_dosen) AS nama_pengguna
                  FROM akses a
                  LEFT JOIN mahasiswa m ON a.id_pengguna = m.nim AND a.tipe_pengguna = 'Mahasiswa'
                  LEFT JOIN dosen d ON a.id_pengguna = d.nip AND a.tipe_pengguna = 'Dosen'
                  WHERE a.id_pengguna LIKE '%$keyword%'
                  OR m.nama_mahasiswa LIKE '%$keyword%'
                  OR d.nama_dosen LIKE '%$keyword%'
                  OR a.status_akses LIKE '%$keyword%'
                  ORDER BY a.timestamp DESC";
        $result = mysqli_query($this->connection, $query);
        $data = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) $data[] = $row;
        }
        return $data;
    }
}

$aksesRead = new AksesRead();
$keyword = isset($_GET['search']) ? $_GET['search'] : '';
$dataAkses = $keyword ? $aksesRead->searchAkses($keyword) : $aksesRead->getAllAkses();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Log Akses</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h2>📖 Data Log Akses Gerbang</h2>
        <a href="create.php" class="btn btn-add">➕ Tambah Log Baru</a>
        <a href="../index.php" class="btn btn-secondary">🏠 Beranda</a>

        <div class="search-box">
            <form method="GET">
                <input type="text" name="search" placeholder="🔍 Cari berdasarkan ID, Nama, atau Status..." value="<?php echo htmlspecialchars($keyword); ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
                <?php if ($keyword): ?><a href="read.php" class="btn btn-secondary">Reset</a><?php endif; ?>
            </form>
        </div>

        <?php if (empty($dataAkses)): ?>
            <div class="no-data">📝 Belum ada data log akses.</div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>ID Pengguna</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Akses</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataAkses as $akses): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($akses['timestamp'])); ?></td>
                            <td><strong><?php echo htmlspecialchars($akses['id_pengguna']); ?></strong></td>
                            <td><?php echo htmlspecialchars($akses['nama_pengguna'] ?? '<em>Data tidak ditemukan</em>'); ?></td>
                            <td><?php echo htmlspecialchars($akses['tipe_pengguna']); ?></td>
                            <td><?php echo htmlspecialchars($akses['tipe_akses']); ?></td>
                            <td><?php echo htmlspecialchars($akses['status_akses']); ?></td>
                            <td>
                                <a href="update.php?id=<?php echo $akses['id_akses']; ?>" class="btn btn-edit">✏ Edit</a>
                                <a href="delete.php?id=<?php echo $akses['id_akses']; ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus log ini?')">🗑 Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>