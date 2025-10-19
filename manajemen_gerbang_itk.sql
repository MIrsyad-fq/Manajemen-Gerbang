
USE manajemen_gerbang_itk;

CREATE TABLE dosen (
    nip VARCHAR(25) PRIMARY KEY,
    nama_dosen VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255) NOT NULL -- Untuk login
);

CREATE TABLE mahasiswa (
    nim VARCHAR(15) PRIMARY KEY,
    nama_mahasiswa VARCHAR(100) NOT NULL,
    angkatan INT,
    email VARCHAR(100) UNIQUE,
    nip_dosen_wali VARCHAR(25),
    FOREIGN KEY (nip_dosen_wali) REFERENCES dosen(nip)
);

CREATE TABLE frs (
    id_frs INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(15),
    kode_matkul VARCHAR(10),
    nama_matkul VARCHAR(100),
    sks INT,
    semester INT,
    status_persetujuan VARCHAR(20) DEFAULT 'Menunggu',
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim)
);

INSERT INTO dosen (nip, nama_dosen, email, password) VALUES
('198503152008122002', 'Ani Wijaya', 'ani.w@itk.ac.id', MD5('password123'));