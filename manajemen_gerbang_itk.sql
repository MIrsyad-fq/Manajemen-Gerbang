-- Menggunakan database yang sudah ada
USE manajemen_gerbang_itk;

-- Menghapus tabel lama jika ada untuk menghindari error
DROP TABLE IF EXISTS frs, mahasiswa, dosen;

-- =================================================================
-- STRUKTUR TABEL
-- =================================================================

-- Tabel Dosen (DENGAN KOLOM PASSWORD)
CREATE TABLE dosen (
    nip VARCHAR(25) PRIMARY KEY,
    nama_dosen VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL -- Kolom ini ditambahkan
);

-- Tabel Mahasiswa (DENGAN KOLOM PASSWORD)
CREATE TABLE mahasiswa (
    nim VARCHAR(15) PRIMARY KEY,
    nama_mahasiswa VARCHAR(100) NOT NULL,
    angkatan INT NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- Kolom ini ditambahkan
    nip_dosen_wali VARCHAR(25),
    FOREIGN KEY (nip_dosen_wali) REFERENCES dosen(nip)
);

-- Tabel FRS (Formulir Rencana Studi)
CREATE TABLE frs (
    id_frs INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(15),
    kode_matkul VARCHAR(10) NOT NULL,
    nama_matkul VARCHAR(100) NOT NULL,
    sks INT NOT NULL,
    status_frs ENUM('Menunggu', 'Disetujui', 'Ditolak') DEFAULT 'Menunggu',
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim) ON DELETE CASCADE
);

-- =================================================================
-- DATA DUMMY (DENGAN ISI PASSWORD)
-- Password untuk semua akun: 'password123'
-- =================================================================
INSERT INTO dosen (nip, nama_dosen, email, password) VALUES
('198503152008122002', 'Dr. Ani Wijaya', 'ani.wijaya@itk.ac.id', MD5('password123'));

INSERT INTO mahasiswa (nim, nama_mahasiswa, angkatan, email, password, nip_dosen_wali) VALUES
('10241004', 'Adelia Isra Ekaputri', 2024, 'adelia.isra@itk.ac.id', MD5('password123'), '198503152008122002'),
('10241042', 'Moh. Irsyad Fiqi', 2024, 'irsyad.fiqi@itk.ac.id', MD5('password123'), '198503152008122002');

INSERT INTO frs (nim, kode_matkul, nama_matkul, sks, status_frs) VALUES
('10241004', 'SI-101', 'Algoritma Pemrograman', 3, 'Disetujui'),
('10241004', 'SI-102', 'Basis Data', 3, 'Menunggu'),
('10241042', 'IF-101', 'Kalkulus I', 4, 'Ditolak');