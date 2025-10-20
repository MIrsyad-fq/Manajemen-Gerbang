<?php
require_once '../config/database.php';

class AksesDelete {
    private $connection;
    
    public function __construct() {
        $db = new Database();
        $this->connection = $db->getConnection();
    }
    
    public function getAksesById($id) {
        $query = "SELECT a.*, COALESCE(m.nama_mahasiswa, d.nama_dosen) AS nama_pengguna
                  FROM akses a
                  LEFT JOIN mahasiswa m ON a.id_pengguna = m.nim AND a.tipe_pengguna = 'Mahasiswa'
                  LEFT JOIN dosen d ON a.id_pengguna = d.nip AND a.tipe_pengguna = 'Dosen'
                  WHERE a.id_akses = $id";
        $result = mysqli_query($this->connection, $query);
        return ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;
    }
    
    public function deleteAkses($id) {
        $query = "DELETE FROM akses WHERE id_akses = $id";
        if (mysqli_query($this->connection, $query)) {
            return ['success' => true, 'message' => "Log akses berhasil dihapus!"];
        } else {
            return ['success' => false, 'message' => 'Error: ' . mysqli_error($this->connection)];
        }
    }
}

$aksesDelete = new AksesDelete();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) exit('ID tidak valid!');

$akses = $aksesDelete->getAksesById($id);
if (!$akses) exit('Data tidak ditemukan!');

if (isset($_POST['confirm_delete'])) {
    $result = $aksesDelete->deleteAkses($id);
    if ($result['success']) {
        echo "<script>alert('✅ {$result['message']}'); window.location='read.php';</script>";
    } else {
        $error_message = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Hapus Log Akses</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="confirm-box">
        <h2>🗑 Konfirmasi Penghapusan Data</h2>
        <div class="warning">
            <strong>⚠ PERINGATAN!</strong> Anda akan menghapus data ini secara permanen. Tindakan ini tidak dapat dibatalkan!
        </div>
        <div class="student-info">
            <h3>👤 Data yang akan dihapus:</h3>
            <div class="info-row"><span class="info-label">ID Log:</span><strong><?php echo htmlspecialchars($akses['id_akses']); ?></strong></div>
            <div class="info-row"><span class="info-label">Waktu:</span><?php echo date('d/m/Y H:i', strtotime($akses['timestamp'])); ?></div>
            <div class="info-row"><span class="info-label">ID Pengguna:</span><strong><?php echo htmlspecialchars($akses['id_pengguna']); ?></strong></div>
            <div class="info-row"><span class="info-label">Nama:</span><?php echo htmlspecialchars($akses['nama_pengguna'] ?? 'N/A'); ?></div>
            <div class="info-row"><span class="info-label">Akses:</span><?php echo htmlspecialchars($akses['tipe_akses']); ?></div>
            <div class="info-row"><span class="info-label">Status:</span><?php echo htmlspecialchars($akses['status_akses']); ?></div>
        </div>
        <form method="POST" style="text-align: center;">
            <button type="submit" name="confirm_delete" class="btn btn-delete">🗑 Ya, Hapus Data</button>
            <a href="read.php" class="btn btn-cancel">❌ Batal</a>
        </form>
    </div>
</body>
</html>