-- Seed Data for Web Alumni IKA SMAN Kajuara / SMAN 8 Bone
USE db_alumni;

-- Reset and Update Bidang Organisasi (8 Bidang + Pengurus Inti + Koordinator Angkatan)
TRUNCATE TABLE mst_bidang;
INSERT INTO mst_bidang (id, nama_bidang, urutan, deskripsi) VALUES
(1, 'Pengurus Inti', 1, 'Ketua Umum, Ketua Harian, Sekretaris Umum, Wakil Sekretaris, Bendahara Umum, Wakil Bendahara'),
(2, 'Bidang Humas & Hubungan Alumni', 2, 'Pengembangan jaringan alumni lintas daerah dan komunikasi publik'),
(3, 'Bidang Sosial & Pengabdian Masyarakat', 3, 'Kegiatan bakti sosial, tanggap bencana, dan kepedulian alumni'),
(4, 'Bidang Usaha, Ekonomi Kreatif & Kemitraan', 4, 'Pengembangan UMKM alumni dan kemitraan bisnis strategeis'),
(5, 'Bidang Pemuda, Olahraga & Seni Budaya', 5, 'Kegiatan olahraga, kebudayaan, dan pengembangan minat bakat alumni'),
(6, 'Bidang Pengembangan SDM & Beasiswa', 6, 'Beasiswa alumni, pelatihan karir, dan pembinaan almamater'),
(7, 'Bidang Hukum, Advokasi & HAM', 7, 'Pendampingan hukum dan konsultasi legal bagi alumni'),
(8, 'Bidang Riset, Teknologi & Informasi', 8, 'Pengelolaan portal digital, inovasi riset, dan database alumni'),
(9, 'Koordinator Angkatan', 9, 'Perwakilan koordinator penanggung jawab alumni per angkatan kelulusan');

-- Seed Data Pengurus Inti Lengkap
TRUNCATE TABLE mst_pengurus;
INSERT INTO mst_pengurus (id, nama, jabatan, id_bidang, periode, is_inti, urutan, sosmed_instagram, sosmed_linkedin, deskripsi_tugas) VALUES
('peng-001', 'Dr. H. Andi Syamsul, M.Si.', 'Ketua Umum', 1, '2026-2031', 1, 1, 'andisyamsul_official', 'dr-andi-syamsul', 'Memimpin dan mengkoordinasikan seluruh arah kebijakan serta program kerja IKA SMAN Kajuara / SMAN 8 Bone.'),
('peng-002', 'Kapt. Inf. Muhammad Aris, S.T.', 'Ketua Harian', 1, '2026-2031', 1, 2, 'm_aris_tni', 'muhammad-aris-st', 'Mengkoordinasikan operasional harian kepengurusan dan supervisi program kerja bidang-bidang.'),
('peng-003', 'Dr. Hj. Nurhidayah, S.E., M.M.', 'Sekretaris Umum', 1, '2026-2031', 1, 3, 'nurhidayah_sekjen', 'nurhidayah-mm', 'Mengelola administrasi kepengurusan, persuratan, dan dokumentasi resmi organisasi.'),
('peng-004', 'Andi Dian Pratiwi, S.H., M.Kn.', 'Wakil Sekretaris', 1, '2026-2031', 1, 4, 'dian.notaris', 'dian-pratiwi', 'Membantu Sekretaris Umum dalam kelancaran administrasi dan kesekretariatan.'),
('peng-005', 'Andi Rahmat Hidayat, S.Kom., M.T.', 'Bendahara Umum', 1, '2026-2031', 1, 5, 'rahmathidayat_ak', 'rahmat-hidayat-mt', 'Mengelola keuangan, perbendaharaan, dan laporan transparansi anggaran organisasi.'),
('peng-006', 'Siti Nurhaliza, S.Ak.', 'Wakil Bendahara', 1, '2026-2031', 1, 6, 'siti.nurhaliza', 'siti-nurhaliza', 'Membantu Bendahara Umum dalam pencatatan transaksi dan pembukuan keuangan.'),

-- Seed Data Pengurus Bidang
('peng-007', 'AKBP H. Firman Said, S.I.K.', 'Ketua Bidang Humas', 2, '2026-2031', 0, 7, 'firman_polri', 'firman-said-sik', 'Mempererat komunikasi antar alumni lintas angkatan di seluruh Indonesia.'),
('peng-008', 'Dr. Faisal Rahman, Sp.PD', 'Ketua Bidang Sosial', 3, '2026-2031', 0, 8, 'faisal_med', 'faisal-rahman', 'Mengkoordinasikan bakti sosial kesehatan dan aksi tanggap bencana.'),
('peng-009', 'H. Andi Gunawan, S.E.', 'Ketua Bidang Ekonomi Kreatif', 4, '2026-2031', 0, 9, 'gunawan_biz', 'andi-gunawan', 'Fasilitasi jejaring bisnis dan pemberdayaan UMKM alumni.'),
('peng-010', 'Bripka Andi Baso Irawan', 'Ketua Bidang Olahraga & Seni', 5, '2026-2031', 0, 10, 'baso_irawan', 'baso-irawan', 'Penyelenggaraan turnamen olahraga dan pentas seni alumni.'),
('peng-011', 'Dra. St. Maryam, M.Pd.', 'Ketua Bidang SDM & Beasiswa', 6, '2026-2031', 0, 11, 'maryam_mpd', 'st-maryam-mpd', 'Pengelolaan beasiswa alumni peduli dan pembinaan almamater.'),
('peng-012', 'A. Akhmad Sultan, S.T.', 'Ketua Bidang Teknologi & Riset', 8, '2026-2031', 0, 12, 'sultan_dev', 'akhmad-sultan', 'Pengembangan portal digital alumni dan sistem database otomatis.'),

-- Seed Data Koordinator Angkatan
('peng-013', 'Nurdin Syam, S.Pd., M.Ed.', 'Koordinator Angkatan 2000', 9, '2026-2031', 0, 13, 'nurdin_2000', 'nurdin-syam', 'Penanggung jawab komunikasi alumni lulusan tahun 2000.'),
('peng-014', 'Mayor Czi Ir. Hendra Wijaya', 'Koordinator Angkatan 2008', 9, '2026-2031', 0, 14, 'hendra_2008', 'hendra-wijaya', 'Penanggung jawab komunikasi alumni lulusan tahun 2008.'),
('peng-015', 'Apt. Rizky Amalia, S.Farm.', 'Koordinator Angkatan 2015', 9, '2026-2031', 0, 15, 'rizky_2015', 'rizky-amalia', 'Penanggung jawab komunikasi alumni lulusan tahun 2015.');
