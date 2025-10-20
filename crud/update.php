<?php
require_once '../config/database.php';

class AksesUpdate {
    private $connection;
    
    public function __construct() {
        $db = new Database();
        $this->connection = $db->getConnection();
    }
    
    public function getAksesById($id) {
        $query = "SELECT * FROM akses WHERE id_akses = $id";
        $result = mysqli_query($this->connection, $query);
        return ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;
    }
    
    public function updateAkses($id, $data) {
        if (empty($data['id_pengguna']) || empty($data['tipe_pengguna']) || empty($data['tipe_akses']) || empty($data['status_akses'])) {
            return ['success' => false, 'message' => 'Semua field wajib diisi!'];
        }
        $query = "UPDATE akses SET 
                    id_pengguna = '{$data['id_pengguna']}',
                    tipe_pengguna = '{$data['tipe_pengguna']}',
                    tipe_akses = '{$data['tipe_akses']}',
                    status_akses = '{$data['status_akses']}',
                    keterangan = '{$data['keterangan']}'
                  WHERE id_akses = $id";
        
        if (mysqli_query($this->connection, $query)) {
            return ['success' => true, 'message' => 'Log akses berhasil diupdate!'];
        } else {
            return ['success' => false, 'message' => 'Error: ' . mysqli_error($this->connection)];
        }
    }
}

$aksesUpdate = new AksesUpdate();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) exit('ID tidak valid!');

if ($_POST) {
    $result = $aksesUpdate->updateAkses($id, $_POST);
    if ($result['success']) {
        echo "<script>alert('✅ {$result['message']}'); window.location='read.php';</script>";
    } else {
        $error_message = $result['message'];
    }
}

$akses = $aksesUpdate->getAksesById($id);
if (!$akses) exit('Data tidak ditemukan!');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Log Akses</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h2>✏ Edit Log Akses</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-error">❌ <?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST">
             <div class="form-group">
                <label>Tipe Pengguna:</label>
                <select name="tipe_pengguna" required>
                    <option value="Mahasiswa" <?php echo ($akses['tipe_pengguna'] == 'Mahasiswa') ? 'selected' : ''; ?>>Mahasiswa</option>
                    <option value="Dosen" <?php echo ($akses['tipe_pengguna'] == 'Dosen') ? 'selected' : ''; ?>>Dosen</option>
                </select>
            </div>
             <div class="form-group">
                <label>ID Pengguna (NIM/NIP):</label>
                <input type="text" name="id_pengguna" value="<?php echo htmlspecialchars($akses['id_pengguna']); ?>" required>
            </div>
             <div class="form-group">
                <label>Tipe Akses:</label>
                <select name="tipe_akses" required>
                    <option value="Masuk" <?php echo ($akses['tipe_akses'] == 'Masuk') ? 'selected' : ''; ?>>Masuk</option>
                    <option value="Keluar" <?php echo ($akses['tipe_akses'] == 'Keluar') ? 'selected' : ''; ?>>Keluar</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status Akses:</label>
                <select name="status_akses" required>
                    <option value="Berhasil" <?php echo ($akses['status_akses'] == 'Berhasil') ? 'selected' : ''; ?>>Berhasil</option>
                    <option value="Gagal" <?php echo ($akses['status_akses'] == 'Gagal') ? 'selected' : ''; ?>>Gagal</option>
                </select>
            </div>
            <div class="form-group">
                <label>Keterangan:</label>
                <textarea name="keterangan" rows="3"><?php echo htmlspecialchars($akses['keterangan']); ?></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-update">💾 Update Data</button>
                <a href="read.php" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</body>
</html>