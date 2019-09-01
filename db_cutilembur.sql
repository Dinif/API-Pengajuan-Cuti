-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Sep 2019 pada 17.52
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cutilembur`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_absensi`
--

CREATE TABLE `tb_absensi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` varchar(10) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `photo` text NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_absensi`
--

INSERT INTO `tb_absensi` (`id`, `nama`, `nip`, `keterangan`, `deskripsi`, `photo`, `tanggal`) VALUES
(1, 'Azzura Ferliani', 'TTX-004', 'Sakit', 'pusing', 'http://192.168.4.188/AplikasiPengajuanCutidanLembur/api/uploads/1.jpg', '2019-08-26'),
(2, 'Dini Febriani', 'TTX-003', 'Sakit', 'mual', 'http://192.168.4.188/AplikasiPengajuanCutidanLembur/api/uploads/2.jpg', '2019-08-26'),
(3, 'Dini Febriani', 'TTX-003', 'Sakit', 'Demam', 'http://192.168.4.188/AplikasiPengajuanCutidanLembur/api/uploads/3.jpg', '2019-08-26'),
(4, 'Frisca Amelia', 'TTX-006', 'Izin', 'Bimbingan', '-', '2019-08-26'),
(5, 'Dini Febriani', 'TTX-003', 'Sakit', 'maag', 'http://192.168.4.188/AplikasiPengajuanCutidanLembur/api/uploads/5.jpg', '2019-08-26'),
(6, 'Tegar Ridwansyah', 'TTX-005', 'Sakit', 'Flu batuk', 'http://192.168.4.188/AplikasiPengajuanCutidanLembur/api/uploads/6.jpg', '2019-08-26'),
(7, 'Dini Febriani', 'TTX-003', 'Mangkir', 'Apa ya', '-', '2019-08-30'),
(8, 'Frisca Amelia', 'TTX-006', 'Sakit', 'Pusing', 'http://192.168.43.38/AplikasiPengajuanCutidanLembur/api/uploads/8.png', '2019-08-30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_cuti`
--

CREATE TABLE `tb_cuti` (
  `nip` varchar(10) NOT NULL,
  `sisa_cuti` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_cuti`
--

INSERT INTO `tb_cuti` (`nip`, `sisa_cuti`) VALUES
('TTX-002', 8),
('TTX-003', 10),
('TTX-004', 11),
('TTX-005', 11),
('TTX-006', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_divisi`
--

CREATE TABLE `tb_divisi` (
  `id_divisi` varchar(10) NOT NULL,
  `nama_divisi` varchar(50) NOT NULL,
  `penanggung_jawab` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_divisi`
--

INSERT INTO `tb_divisi` (`id_divisi`, `nama_divisi`, `penanggung_jawab`) VALUES
('DVS-001', 'Android Developer', 'Ratno Putro S.'),
('DVS-002', 'Web Developer', 'Ratno Putro S.'),
('DVS-003', 'Keuangan', 'Barton Yan Fari'),
('DVS-004', 'HRD', 'Barton Yan Fari');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_login`
--

CREATE TABLE `tb_login` (
  `nip` varchar(10) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_login`
--

INSERT INTO `tb_login` (`nip`, `user`, `pass`, `level`) VALUES
('TTX-002', 'Thio', 'ttx123', 'HRD'),
('TTX-003', 'Dini Febriani', 'ttx123', 'KARYAWAN'),
('TTX-004', 'Azzura Ferliani', 'ttx123', 'KARYAWAN'),
('TTX-005', 'Tegar Ridwansyah', 'ttx123', 'KARYAWAN'),
('TTX-006', 'Frisca Amelia', 'ttx123', 'KARYAWAN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pegawai`
--

CREATE TABLE `tb_pegawai` (
  `nip` varchar(10) NOT NULL,
  `nama_pegawai` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `divisi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_pegawai`
--

INSERT INTO `tb_pegawai` (`nip`, `nama_pegawai`, `alamat`, `no_telp`, `divisi`) VALUES
('TTX-002', 'Thio', 'Bandung', '083872724801', 'DVS-004'),
('TTX-003', 'Dini Febriani', 'Cibogo', '089656427556', 'DVS-002'),
('TTX-004', 'Azzura Ferliani', 'Contong', '087823667621', 'DVS-001'),
('TTX-005', 'Tegar Ridwansyah', 'Cigugur', '085352486752', 'DVS-001'),
('TTX-006', 'Frisca Amelia', 'Jl Pesantren', '089518996171', 'DVS-002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengajuan`
--

CREATE TABLE `tb_pengajuan` (
  `id_pengajuan` varchar(10) NOT NULL,
  `nip` varchar(10) NOT NULL,
  `keterangan` text NOT NULL,
  `mulai_cuti` date NOT NULL,
  `hari_mulai` varchar(20) NOT NULL,
  `selesai_cuti` date NOT NULL,
  `hari_selesai` varchar(20) NOT NULL,
  `jumlah_cuti` int(11) NOT NULL,
  `tanggal_diajukan` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_pengajuan`
--

INSERT INTO `tb_pengajuan` (`id_pengajuan`, `nip`, `keterangan`, `mulai_cuti`, `hari_mulai`, `selesai_cuti`, `hari_selesai`, `jumlah_cuti`, `tanggal_diajukan`, `status`) VALUES
('PNG-001', 'TTX-003', 'Bimbingan', '2019-08-16', 'Jumat', '2019-08-16', 'Jumat', 1, '2019-08-13', 'Diterima'),
('PNG-002', 'TTX-002', 'Acara keluarga', '2019-08-19', 'Senin', '2019-08-20', 'Selasa', 2, '2019-08-13', 'Ditolak'),
('PNG-003', 'TTX-003', 'Ambil rapot', '2019-08-30', 'Jumat', '2019-08-30', 'Jumat', 1, '2019-08-13', 'Diterima'),
('PNG-004', 'TTX-006', 'Ke sekolah', '2019-08-17', 'Sabtu', '2019-08-17', 'Sabtu', 1, '2019-08-14', 'Diterima'),
('PNG-005', 'TTX-005', 'Bimbingan', '2019-08-16', 'Jumat', '2019-08-16', 'Jumat', 1, '2019-08-14', 'Menunggu'),
('PNG-006', 'TTX-005', 'Acara keluarga', '2019-08-16', 'Jumat', '2019-08-16', 'Jumat', 1, '2019-08-11', 'Diterima'),
('PNG-007', 'TTX-001', 'cuti 1', '2019-01-04', 'Jumat', '2019-01-04', 'Jumat', 1, '2019-01-01', 'Diterima'),
('PNG-008', 'TTX-002', 'cuti 2', '2019-02-04', 'Senin', '2019-02-04', 'Senin', 1, '2019-02-01', 'Ditolak'),
('PNG-009', 'TTX-003', 'cuti 3', '2019-03-05', 'Selasa', '2019-03-05', 'Selasa', 1, '2019-03-01', 'Diterima'),
('PNG-010', 'TTX-004', 'cuti 4', '2019-04-05', 'Jumat', '2019-04-05', 'Jumat', 1, '2019-04-01', 'Ditolak'),
('PNG-011', 'TTX-005', 'cuti 5', '2019-05-08', 'Rabu', '2019-05-08', 'Rabu', 1, '2019-05-01', 'Diterima'),
('PNG-012', 'TTX-006', 'cuti 6', '2019-06-06', 'Kamis', '2019-06-06', 'Kamis', 1, '2019-06-03', 'Ditolak'),
('PNG-013', 'TTX-001', 'cuti 7', '2019-07-12', 'Jumat', '2019-07-12', 'Jumat', 1, '2019-07-05', 'Diterima'),
('PNG-014', 'TTX-002', 'cuti 8', '2019-09-12', 'Kamis', '2019-09-12', 'Kamis', 1, '2019-09-06', 'Ditolak'),
('PNG-015', 'TTX-003', 'cuti 9', '2019-10-07', 'Senin', '2019-10-11', 'Jumat', 5, '2019-10-01', 'Diterima'),
('PNG-016', 'TTX-004', 'cuti 10', '2019-11-06', 'Rabu', '2019-11-07', 'Kamis', 2, '2019-11-01', 'Ditolak'),
('PNG-017', 'TTX-005', 'cuti 11', '2019-12-26', 'Rabu', '2019-12-26', 'Rabu', 1, '2019-12-16', 'Diterima'),
('PNG-018', 'TTX-002', 'Holiday', '2019-08-16', 'Jumat', '2019-08-19', 'Senin', 4, '2019-08-16', 'Diterima'),
('PNG-019', 'TTX-006', 'pergi sama keluarga', '2019-08-29', 'Kamis', '2019-08-31', 'Sabtu', 3, '2019-08-29', 'Menunggu'),
('PNG-020', 'TTX-006', 'jsksuba', '2019-08-31', 'Sabtu', '2019-09-03', 'Selasa', 4, '2019-08-30', 'Menunggu'),
('PNG-021', 'TTX-004', 'pergi', '2019-09-10', 'Selasa', '2019-09-11', 'Rabu', 2, '2019-08-30', 'Menunggu'),
('PNG-022', 'TTX-005', 'pergi', '2019-08-29', 'Kamis', '2019-08-30', 'Jumat', 2, '2019-08-30', 'Menunggu'),
('PNG-023', 'TTX-006', 'pergi', '2019-09-02', 'Senin', '2019-09-03', 'Selasa', 2, '2019-08-30', 'Diterima'),
('PNG-024', 'TTX-002', 'Pergi', '2019-09-02', '', '2019-09-03', '', 2, '2019-08-02', 'Menunggu'),
('PNG-025', 'TTX-002', 'Pergi', '2019-09-02', '', '2019-09-03', '', 2, '2019-08-30', 'Menunggu'),
('PNG-026', 'TTX-003', 'Libur panjang', '2019-09-16', 'Jumat', '2019-09-26', 'Senin', 11, '2019-09-11', 'Menunggu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_registrasi`
--

CREATE TABLE `tb_registrasi` (
  `id` int(11) NOT NULL,
  `id_registrasi` varchar(200) NOT NULL,
  `device` varchar(200) NOT NULL,
  `id_device` varchar(200) NOT NULL,
  `id_client` varchar(200) NOT NULL,
  `nip` varchar(10) NOT NULL,
  `waktu_registrasi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_registrasi`
--

INSERT INTO `tb_registrasi` (`id`, `id_registrasi`, `device`, `id_device`, `id_client`, `nip`, `waktu_registrasi`) VALUES
(1, 'c9DKTswXZ7w:APA91bEPsi4uZgFHhlmxHDZm6C_VQNLJUyTiE4eFtNUwRDM12m1JrSW9z6cyupAeJjVQzsxJ7KezCVOnnUz4dHbXHlfHTvGraB5m1rgMXPYGpQejxOqAnAZRX1qiobQuON9NPq5uVAmz', 'CPH1701', '1e51d0fe2b221383', 'APC', 'TTX-002', '2019-09-01 22:29:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_request_log`
--

CREATE TABLE `tb_request_log` (
  `id` int(11) NOT NULL,
  `message` varchar(200) NOT NULL,
  `response` varchar(200) NOT NULL,
  `id_registrasi` varchar(200) NOT NULL,
  `nip` varchar(10) NOT NULL,
  `id_push` varchar(10) NOT NULL,
  `waktu_request` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_request_log`
--

INSERT INTO `tb_request_log` (`id`, `message`, `response`, `id_registrasi`, `nip`, `id_push`, `waktu_request`) VALUES
(1, 'Aplikasi Pengajuan Cuti : {\"title\":\"New Submission\",\"message\":\"Pengajuan cuti dari Dini Febriani\"}', '{\"multicast_id\":9058876435872387601,\"success\":1,\"failure\":0,\"canonical_ids\":0,\"results\":[{\"message_id\":\"0:1567351966038345%800923a1f9fd7ecd\"}]}', 'c9DKTswXZ7w:APA91bEPsi4uZgFHhlmxHDZm6C_VQNLJUyTiE4eFtNUwRDM12m1JrSW9z6cyupAeJjVQzsxJ7KezCVOnnUz4dHbXHlfHTvGraB5m1rgMXPYGpQejxOqAnAZRX1qiobQuON9NPq5uVAmz', 'TTX-002', 'PID-001', '2019-09-01 22:32:47');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_cuti`
--
ALTER TABLE `tb_cuti`
  ADD PRIMARY KEY (`nip`);

--
-- Indeks untuk tabel `tb_divisi`
--
ALTER TABLE `tb_divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indeks untuk tabel `tb_login`
--
ALTER TABLE `tb_login`
  ADD PRIMARY KEY (`nip`);

--
-- Indeks untuk tabel `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD PRIMARY KEY (`nip`);

--
-- Indeks untuk tabel `tb_pengajuan`
--
ALTER TABLE `tb_pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indeks untuk tabel `tb_registrasi`
--
ALTER TABLE `tb_registrasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_request_log`
--
ALTER TABLE `tb_request_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_absensi`
--
ALTER TABLE `tb_absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_registrasi`
--
ALTER TABLE `tb_registrasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_request_log`
--
ALTER TABLE `tb_request_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
