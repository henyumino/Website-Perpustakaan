-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2018 at 12:45 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `bendahara`
--

CREATE TABLE `bendahara` (
  `ID_Bendahara` varchar(50) NOT NULL,
  `Folder_Bendahara` varchar(60) NOT NULL,
  `Foto_Bendahara` varchar(50) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Tanggal_Lahir` varchar(5) NOT NULL,
  `Bulan_Lahir` varchar(10) NOT NULL,
  `Tahun_Lahir` varchar(4) NOT NULL,
  `Jenis_Kelamin` varchar(10) NOT NULL,
  `Alamat` varchar(50) NOT NULL,
  `Ponsel` varchar(15) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Katasandi` varchar(70) NOT NULL,
  `Kode_Konfigurasi_Akun` varchar(50) NOT NULL,
  `Kode_Atur_Ulang_Katasandi` varchar(50) NOT NULL,
  `Akses_Atur_Ulang_Katasandi` varchar(10) NOT NULL,
  `Status_Akun` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `ID_Buku` varchar(50) NOT NULL,
  `Folder_Buku` varchar(50) NOT NULL,
  `Foto_Buku` varchar(50) NOT NULL,
  `Judul_Buku` varchar(100) NOT NULL,
  `Deskripsi_Buku` text NOT NULL,
  `Nama_Pengarang` varchar(50) NOT NULL,
  `Penerbit_Buku` varchar(50) NOT NULL,
  `Tanggal_Terbit` varchar(5) NOT NULL,
  `Bulan_Terbit` varchar(10) NOT NULL,
  `Tahun_Terbit` varchar(4) NOT NULL,
  `Tempat_Terbit` varchar(15) NOT NULL,
  `Kategori_Buku` varchar(15) NOT NULL,
  `Jumlah_Buku` int(11) NOT NULL,
  `Total_Rating` bigint(20) NOT NULL,
  `Ditambahkan` date NOT NULL,
  `ID_Sekretaris` varchar(50) NOT NULL,
  `Nama_Sekretaris` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_buku`
--

CREATE TABLE `kategori_buku` (
  `ID_Kategori_Buku` varchar(50) NOT NULL,
  `Nama` varchar(60) NOT NULL,
  `Ditambahkan` date NOT NULL,
  `ID_Sekretaris` varchar(50) NOT NULL,
  `Nama_Sekretaris` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pemilik`
--

CREATE TABLE `pemilik` (
  `ID_Pemilik` varchar(50) NOT NULL,
  `Folder_Pemilik` varchar(60) NOT NULL,
  `Foto_Pemilik` varchar(50) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Tanggal_Lahir` varchar(5) NOT NULL,
  `Bulan_Lahir` varchar(10) NOT NULL,
  `Tahun_Lahir` varchar(4) NOT NULL,
  `Jenis_Kelamin` varchar(10) NOT NULL,
  `Alamat` varchar(50) NOT NULL,
  `Ponsel` varchar(15) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Katasandi` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemilik`
--

INSERT INTO `pemilik` (`ID_Pemilik`, `Folder_Pemilik`, `Foto_Pemilik`, `Nama`, `Tanggal_Lahir`, `Bulan_Lahir`, `Tahun_Lahir`, `Jenis_Kelamin`, `Alamat`, `Ponsel`, `Email`, `Katasandi`) VALUES
('0210358530764624917791483859486296025317', 'egfd3h84099094af58h15gab776283276adecg3f', '6gb12a88h51e7016b21g7371h.png', 'Ryan Hazizi', '7', 'November', '2000', 'Pria', 'Jalan Sandat VII N0 17', '089605090407', 'admin@perpusnusantara.com', '$2y$10$10mzD7fS9PKc7Tz3j/W.oOvbwWbAsi9iZz8.FJ75B1w3dJrtp2qHO');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `ID_Pengguna` varchar(50) NOT NULL,
  `Folder_Pengguna` varchar(60) NOT NULL,
  `Foto_Pengguna` varchar(50) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Tanggal_Lahir` varchar(5) NOT NULL,
  `Bulan_Lahir` varchar(10) NOT NULL,
  `Tahun_Lahir` varchar(4) NOT NULL,
  `Jenis_Kelamin` varchar(10) NOT NULL,
  `Alamat` varchar(50) NOT NULL,
  `Ponsel` varchar(15) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Katasandi` varchar(70) NOT NULL,
  `Kode_Verifikasi_Email` varchar(50) NOT NULL,
  `Kode_Atur_Ulang_Katasandi` varchar(50) NOT NULL,
  `Akses_Atur_Ulang_Katasandi` varchar(20) NOT NULL,
  `Status_Akun` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sekretaris`
--

CREATE TABLE `sekretaris` (
  `ID_Sekretaris` varchar(50) NOT NULL,
  `Folder_Sekretaris` varchar(60) NOT NULL,
  `Foto_Sekretaris` varchar(50) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Tanggal_Lahir` varchar(5) NOT NULL,
  `Bulan_Lahir` varchar(10) NOT NULL,
  `Tahun_Lahir` varchar(4) NOT NULL,
  `Jenis_Kelamin` varchar(10) NOT NULL,
  `Alamat` varchar(50) NOT NULL,
  `Ponsel` varchar(15) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Katasandi` varchar(70) NOT NULL,
  `Kode_Konfigurasi_Akun` varchar(50) NOT NULL,
  `Kode_Atur_Ulang_Katasandi` varchar(50) NOT NULL,
  `Akses_Atur_Ulang_Katasandi` varchar(20) NOT NULL,
  `Status_Akun` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `statistik_buku`
--

CREATE TABLE `statistik_buku` (
  `ID_Peminjaman` varchar(15) NOT NULL,
  `ID_Buku` varchar(50) NOT NULL,
  `Judul_Buku` varchar(100) NOT NULL,
  `Tanggal_Dipinjam` datetime NOT NULL,
  `Tanggal_Dikembalikan` datetime NOT NULL,
  `Keterangan` varchar(50) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `ID_Pengguna` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `statistik_keuangan`
--

CREATE TABLE `statistik_keuangan` (
  `ID_Laporan` varchar(100) NOT NULL,
  `Waktu` datetime NOT NULL,
  `Dana_Masuk` bigint(11) NOT NULL,
  `Dana_Keluar` bigint(11) NOT NULL,
  `Keterangan` text NOT NULL,
  `ID_Bendahara` varchar(50) NOT NULL,
  `Nama_Bendahara` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ulasan_buku`
--

CREATE TABLE `ulasan_buku` (
  `ID_Ulasan` varchar(50) NOT NULL,
  `ID_Buku` varchar(50) NOT NULL,
  `ID_Pengguna` varchar(50) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Isi_Ulasan` text NOT NULL,
  `Jumlah_Rating` int(11) NOT NULL,
  `Tanggal_Diulas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bendahara`
--
ALTER TABLE `bendahara`
  ADD PRIMARY KEY (`ID_Bendahara`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`ID_Buku`);

--
-- Indexes for table `kategori_buku`
--
ALTER TABLE `kategori_buku`
  ADD PRIMARY KEY (`ID_Kategori_Buku`);

--
-- Indexes for table `pemilik`
--
ALTER TABLE `pemilik`
  ADD PRIMARY KEY (`ID_Pemilik`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`ID_Pengguna`);

--
-- Indexes for table `sekretaris`
--
ALTER TABLE `sekretaris`
  ADD PRIMARY KEY (`ID_Sekretaris`);

--
-- Indexes for table `statistik_buku`
--
ALTER TABLE `statistik_buku`
  ADD PRIMARY KEY (`ID_Peminjaman`);

--
-- Indexes for table `statistik_keuangan`
--
ALTER TABLE `statistik_keuangan`
  ADD PRIMARY KEY (`ID_Laporan`);

--
-- Indexes for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  ADD PRIMARY KEY (`ID_Ulasan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
