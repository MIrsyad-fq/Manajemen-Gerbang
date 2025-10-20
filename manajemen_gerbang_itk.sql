-- Membuat database baru
CREATE DATABASE IF NOT EXISTS manajemen_gerbang_itk;
USE manajemen_gerbang_itk;

-- Tabel 1: prodi
CREATE TABLE prodi (
    no_prodi VARCHAR(10) PRIMARY KEY,
    nama_prodi VARCHAR(100) NOT NULL
);

-- Tabel 2: dosen
CREATE TABLE dosen (
    nip VARCHAR(25) PRIMARY KEY,
    nama_dosen VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    no_prodi VARCHAR(10),
    FOREIGN KEY (no_prodi) REFERENCES prodi(no_prodi)
);

-- Tabel 3: mahasiswa
CREATE TABLE mahasiswa (
    nim VARCHAR(15) PRIMARY KEY,
    nama_mahasiswa VARCHAR(100) NOT NULL,
    angkatan INT,
    no_prodi VARCHAR(10),
    FOREIGN KEY (no_prodi) REFERENCES prodi(no_prodi)
);

-- Tabel 4: akses (Tabel utama untuk CRUD)
CREATE TABLE akses (
    id_akses INT AUTO_INCREMENT PRIMARY KEY,
    id_pengguna VARCHAR(25) NOT NULL,
    tipe_pengguna ENUM('Mahasiswa', 'Dosen') NOT NULL,
    `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tipe_akses ENUM('Masuk', 'Keluar') NOT NULL,
    status_akses ENUM('Berhasil', 'Gagal') NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Memasukkan data contoh
INSERT INTO prodi (no_prodi, nama_prodi) VALUES
('10', 'Sistem Informasi'),
('11', 'Informatika');

INSERT INTO dosen (nip, nama_dosen, email, no_prodi) VALUES
('198503152008122002', 'Ani Wijaya', 'ani.w@itk.ac.id', '10'),
('198805202012031003', 'Charlie D.', 'charlie.d@itk.ac.id', '11');

INSERT INTO mahasiswa (nim, nama_mahasiswa, angkatan, no_prodi) VALUES
('10241004', 'Adelia Isra Ekaputri', 2024, '10'),
('11241001', 'Kevin Sanjaya', 2024, '11');

INSERT INTO akses (id_pengguna, tipe_pengguna, tipe_akses, status_akses, keterangan) VALUES
('10241004', 'Mahasiswa', 'Masuk', 'Berhasil', 'Akses pagi'),
('198503152008122002', 'Dosen', 'Masuk', 'Berhasil', ''),
('11241001', 'Mahasiswa', 'Keluar', 'Gagal', 'Kartu tidak terbaca');