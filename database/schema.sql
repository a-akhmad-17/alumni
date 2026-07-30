-- Database Schema for Web Alumni IKA SMAN Kajuara / SMAN 8 Bone
-- Standards: sys_, mst_, trn_, log_ table prefixes & Soft Deletes

CREATE TABLE IF NOT EXISTS sys_users (
    id VARCHAR(36) PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    full_name VARCHAR(100) NOT NULL,
    role VARCHAR(20) DEFAULT 'admin',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS sys_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TEXT
);

CREATE TABLE IF NOT EXISTS mst_kategori_berita (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_kategori VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS mst_bidang (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_bidang VARCHAR(150) NOT NULL,
    urutan INT DEFAULT 0,
    deskripsi TEXT
);

CREATE TABLE IF NOT EXISTS mst_pengurus (
    id VARCHAR(36) PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    id_bidang INT DEFAULT 0,
    periode VARCHAR(20) DEFAULT '2026-2031',
    foto VARCHAR(255),
    sosmed_instagram VARCHAR(150),
    sosmed_linkedin VARCHAR(150),
    deskripsi_tugas TEXT,
    urutan INT DEFAULT 0,
    is_inti TINYINT(1) DEFAULT 0,
    deleted_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS mst_alumni (
    id VARCHAR(36) PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    jenis_kelamin VARCHAR(20) DEFAULT 'Laki-laki',
    angkatan INT NOT NULL,
    profesi VARCHAR(150),
    kategori_profesi VARCHAR(100),
    domisili VARCHAR(150),
    no_hp VARCHAR(30),
    email VARCHAR(100),
    is_berprestasi TINYINT(1) DEFAULT 0,
    deskripsi_prestasi TEXT,
    foto VARCHAR(255),
    status VARCHAR(20) DEFAULT 'approved',
    no_kta VARCHAR(50) NULL,
    deleted_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS trn_berita (
    id VARCHAR(36) PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    ringkasan TEXT,
    isi TEXT,
    gambar VARCHAR(255),
    penulis VARCHAR(100) DEFAULT 'Admin IKA',
    kategori VARCHAR(50) DEFAULT 'Berita',
    status VARCHAR(20) DEFAULT 'published',
    deleted_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS trn_galeri (
    id VARCHAR(36) PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    gambar VARCHAR(255) NOT NULL,
    kategori VARCHAR(50) DEFAULT 'Kegiatan',
    deleted_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS trn_beasiswa (
    id VARCHAR(36) PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    informasi TEXT NOT NULL,
    link_eksternal VARCHAR(500) NOT NULL,
    gambar VARCHAR(255),
    status VARCHAR(20) DEFAULT 'published',
    deleted_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS trn_infografis (
    id VARCHAR(36) PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    gambar VARCHAR(255) NOT NULL,
    link_tautan VARCHAR(500),
    is_popup TINYINT(1) DEFAULT 0,
    urutan INT DEFAULT 0,
    status VARCHAR(20) DEFAULT 'published',
    deleted_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS log_activity (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id VARCHAR(36),
    activity TEXT NOT NULL,
    ip_address VARCHAR(45),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
