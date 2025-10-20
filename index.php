<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Gerbang ITK</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>🚪 Sistem Manajemen Gerbang ITK</h1>
        <p class="subtitle">Aplikasi CRUD untuk Mengelola Log Akses</p>
        
        <div class="info-box">
            <h3>📚 Tentang Aplikasi</h3>
            <p>Aplikasi ini adalah implementasi operasi CRUD (Create, Read, Update, Delete) untuk mengelola data log akses gerbang oleh mahasiswa dan dosen di lingkungan Institut Teknologi Kalimantan.</p>
        </div>
        
        <div class="menu-grid">
            <a href="crud/create.php" class="menu-item create">
                <h3>➕ CREATE</h3>
                <p>Tambah data log akses baru</p>
            </a>
            
            <a href="crud/read.php" class="menu-item read">
                <h3>📖 READ</h3>
                <p>Lihat & cari data log akses</p>
            </a>
            
            <a href="crud/read.php" class="menu-item update">
                <h3>✏ UPDATE</h3>
                <p>Edit data log akses</p>
            </a>
            
            <a href="crud/read.php" class="menu-item delete">
                <h3>🗑 DELETE</h3>
                <p>Hapus data log akses</p>
            </a>
        </div>
                
        <div class="footer">
            <p><strong>Database:</strong> manajemen_gerbang_itk | <strong>Tabel Utama:</strong> akses</p>
            <p>Pastikan database sudah dibuat menggunakan file <code>database.sql</code></p>
        </div>
    </div>
</body>
</html>