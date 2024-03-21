-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 16, 2024 at 08:12 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cash_in_out`
--

CREATE TABLE `cash_in_out` (
  `id` int NOT NULL,
  `kode_rekening` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `masuk` decimal(10,0) NOT NULL,
  `keluar` decimal(10,0) NOT NULL,
  `id_hutang_dibayar` int DEFAULT NULL,
  `id_piutang_dibayar` int DEFAULT NULL,
  `id_penjualan` varchar(50) DEFAULT NULL,
  `keterangan` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash_in_out`
--

INSERT INTO `cash_in_out` (`id`, `kode_rekening`, `tanggal`, `masuk`, `keluar`, `id_hutang_dibayar`, `id_piutang_dibayar`, `id_penjualan`, `keterangan`) VALUES
(76, '10001', '2024-03-15', '48835', '0', NULL, NULL, '150324000002', ''),
(77, '10001', '2024-03-15', '195340', '0', NULL, NULL, '150324000003', ''),
(78, '10001', '2024-03-15', '270840', '0', NULL, NULL, '150324000004', ''),
(79, '10001', '2024-03-15', '976700', '0', NULL, NULL, '150324000005', ''),
(80, '20008', '2024-03-15', '0', '1400000', NULL, NULL, NULL, 'oket'),
(81, '10001', '2024-03-15', '622932', '0', NULL, NULL, '150324000006', ''),
(82, '10001', '2024-03-15', '75919', '0', NULL, NULL, '150324000007', ''),
(83, '10001', '2024-03-16', '27084', '0', NULL, NULL, '160324000008', ''),
(84, '10001', '2024-03-16', '244175', '0', NULL, NULL, '160324000009', ''),
(85, '10001', '2024-03-16', '27084', '0', NULL, NULL, '160324000010', ''),
(86, '10001', '2024-03-16', '54168', '0', NULL, NULL, '160324000011', ''),
(87, '10001', '2024-03-16', '27084', '0', NULL, NULL, '160324000012', ''),
(88, '10001', '2024-03-16', '27084', '0', NULL, NULL, '160324000013', ''),
(89, '20008', '2024-03-16', '0', '50000', NULL, NULL, NULL, 'okey'),
(90, '10001', '2024-03-16', '27084', '0', NULL, NULL, '160324000014', '');

-- --------------------------------------------------------

--
-- Table structure for table `hutang_dibayar_history`
--

CREATE TABLE `hutang_dibayar_history` (
  `id` int NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `id_hutang` int NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` decimal(10,0) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hutang_history`
--

CREATE TABLE `hutang_history` (
  `id` int NOT NULL,
  `judul` varchar(200) NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` decimal(10,0) NOT NULL,
  `nominal_dibayar` decimal(10,0) NOT NULL,
  `nomor_faktur` varchar(100) DEFAULT NULL,
  `id_supplier` int DEFAULT NULL,
  `tanggal_lunas` date NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `sudah_lunas` enum('0','1') NOT NULL DEFAULT '0',
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `keterangan` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hutang_history`
--

INSERT INTO `hutang_history` (`id`, `judul`, `tanggal`, `nominal`, `nominal_dibayar`, `nomor_faktur`, `id_supplier`, `tanggal_lunas`, `tanggal_jatuh_tempo`, `sudah_lunas`, `waktu_update`, `keterangan`) VALUES
(28, 'pembelian ke supplier', '2024-03-15', '5000', '0', 'F1603240001', 3, '0000-00-00', '2024-03-15', '0', '2024-03-15 18:44:12', '-'),
(29, 'pembelian ke supplier', '2024-03-16', '4500', '0', 'F1603240002', 8, '0000-00-00', '2024-03-16', '0', '2024-03-16 06:42:42', '-'),
(30, 'pembelian ke supplier', '2024-03-16', '130000', '0', 'F1603240003', 4, '0000-00-00', '2024-03-16', '0', '2024-03-16 08:11:40', '-');

-- --------------------------------------------------------

--
-- Table structure for table `kartu_stok`
--

CREATE TABLE `kartu_stok` (
  `id` int NOT NULL,
  `nomor_rec_penerimaan` varchar(100) DEFAULT NULL,
  `id_stok_adjustment` int DEFAULT NULL,
  `id_stok_opname` int DEFAULT NULL,
  `id_stok_keluar` int DEFAULT NULL,
  `id_penjualan` varchar(50) DEFAULT NULL,
  `kode_item` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_transaksi` enum('pembelian ke supplier','retur penjualan','stok opname','stok adjustment','retur pembelian','penjualan','retur penjualan') NOT NULL DEFAULT 'retur pembelian',
  `jumlah_masuk` int NOT NULL,
  `jumlah_keluar` int NOT NULL,
  `satuan_kecil` varchar(100) NOT NULL,
  `tgl_expired` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kartu_stok`
--

INSERT INTO `kartu_stok` (`id`, `nomor_rec_penerimaan`, `id_stok_adjustment`, `id_stok_opname`, `id_stok_keluar`, `id_penjualan`, `kode_item`, `tanggal`, `jenis_transaksi`, `jumlah_masuk`, `jumlah_keluar`, `satuan_kecil`, `tgl_expired`) VALUES
(90, NULL, NULL, 1, NULL, NULL, '8999909676352', '2024-03-15', 'stok opname', 10, 0, 'Pcs', '2024-05-23'),
(96, NULL, NULL, 2, NULL, NULL, '8999909676352', '2024-03-15', 'stok opname', 50, 0, 'Pcs', '2026-02-03'),
(102, NULL, NULL, 3, NULL, NULL, '8234909028229', '2024-03-15', 'stok opname', 60, 0, 'Botol', '2029-07-01'),
(117, NULL, NULL, NULL, NULL, '150324000001', '8999909676352', '2024-03-15', 'penjualan', 0, 5, 'Pcs', '2024-05-23'),
(118, NULL, NULL, NULL, NULL, '150324000002', '8999909676352', '2024-03-15', 'penjualan', 0, 1, 'Pcs', '2024-05-23'),
(119, NULL, NULL, NULL, NULL, '150324000003', '8999909676352', '2024-03-15', 'penjualan', 0, 4, 'Pcs', '2024-05-23'),
(120, NULL, NULL, NULL, NULL, '150324000004', '8234909028229', '2024-03-15', 'penjualan', 0, 10, 'Botol', '2029-07-01'),
(125, NULL, NULL, NULL, NULL, '150324000005', '8999909676352', '2024-03-15', 'penjualan', 0, 20, 'Pcs', '2024-05-23'),
(129, NULL, NULL, NULL, NULL, '150324000006', '8234909028229', '2024-03-15', 'penjualan', 0, 23, 'Botol', '2029-07-01'),
(131, NULL, NULL, NULL, NULL, '150324000007', '8234909028229', '2024-03-15', 'penjualan', 0, 1, 'Botol', '2029-07-01'),
(132, NULL, NULL, NULL, NULL, '150324000007', '8999909676352', '2024-03-15', 'penjualan', 0, 1, 'Pcs', '2024-03-20'),
(133, NULL, NULL, NULL, NULL, '160324000008', '8234909028229', '2024-03-16', 'penjualan', 0, 1, 'Botol', '2029-07-01'),
(134, NULL, NULL, NULL, NULL, '160324000009', '8999909676352', '2024-03-16', 'penjualan', 0, 5, 'Pcs', '2024-03-20'),
(135, NULL, NULL, NULL, NULL, '160324000010', '8234909028229', '2024-03-16', 'penjualan', 0, 1, 'Botol', '2029-07-01'),
(136, NULL, NULL, NULL, NULL, '160324000011', '8234909028229', '2024-03-16', 'penjualan', 0, 2, 'Botol', '2029-07-01'),
(138, 'PE1603240001', NULL, NULL, NULL, NULL, '8234909028229', '2024-03-28', 'pembelian ke supplier', 1, 0, 'Botol', '2024-03-20'),
(139, NULL, NULL, NULL, NULL, '160324000012', '8234909028229', '2024-03-16', 'penjualan', 0, 1, 'Botol', '2024-03-20'),
(140, NULL, NULL, NULL, NULL, '160324000013', '8234909028229', '2024-03-16', 'penjualan', 0, 1, 'Botol', '2024-03-20'),
(141, 'PE1603240002', NULL, NULL, NULL, NULL, '8234909028229', '2024-03-16', 'pembelian ke supplier', 1, 0, 'Botol', '2024-03-18'),
(143, NULL, 1, NULL, NULL, NULL, '8234909028229', '2024-03-16', 'stok adjustment', 0, 1, 'Botol', '2024-03-29'),
(144, NULL, NULL, NULL, NULL, '160324000014', '8234909028229', '2024-03-16', 'penjualan', 0, 1, 'Botol', '2024-03-18'),
(145, NULL, NULL, 7, NULL, NULL, '8999909676352', '2024-03-16', 'stok opname', 26, 0, 'Pcs', '2024-03-16'),
(146, 'PE1603240003', NULL, NULL, NULL, NULL, '8999909676352', '2024-03-16', 'pembelian ke supplier', 5, 0, 'Pcs', '2027-03-23');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_user`
--

CREATE TABLE `kategori_user` (
  `id` int NOT NULL,
  `kategori_user` varchar(100) NOT NULL,
  `beranda` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_user`
--

INSERT INTO `kategori_user` (`id`, `kategori_user`, `beranda`) VALUES
(31, 'Manager', 1),
(32, 'Kasir', 25);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_user_modul`
--

CREATE TABLE `kategori_user_modul` (
  `id` int NOT NULL,
  `kategori_user` int NOT NULL,
  `modul` int NOT NULL,
  `akses` enum('read','add','edit','delete') NOT NULL DEFAULT 'read'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_user_modul`
--

INSERT INTO `kategori_user_modul` (`id`, `kategori_user`, `modul`, `akses`) VALUES
(3229, 32, 25, 'read'),
(11956, 31, 1, 'read'),
(11957, 31, 2, 'read'),
(11958, 31, 3, 'read'),
(11959, 31, 4, 'read'),
(11960, 31, 5, 'read'),
(11961, 31, 6, 'read'),
(11962, 31, 7, 'read'),
(11963, 31, 8, 'read'),
(11964, 31, 9, 'read'),
(11965, 31, 10, 'read'),
(11966, 31, 11, 'read'),
(11967, 31, 12, 'read'),
(11968, 31, 13, 'read'),
(11969, 31, 14, 'read'),
(11970, 31, 15, 'read'),
(11971, 31, 16, 'read'),
(11972, 31, 17, 'read'),
(11973, 31, 18, 'read'),
(11974, 31, 19, 'read'),
(11975, 31, 20, 'read'),
(11976, 31, 21, 'read'),
(11977, 31, 22, 'read'),
(11978, 31, 23, 'read'),
(11979, 31, 24, 'read'),
(11980, 31, 25, 'read'),
(11981, 31, 26, 'read'),
(11982, 31, 27, 'read'),
(11983, 31, 28, 'read'),
(11984, 31, 29, 'read'),
(11985, 31, 30, 'read'),
(11986, 31, 31, 'read'),
(11987, 31, 32, 'read'),
(11988, 31, 33, 'read'),
(11989, 31, 34, 'read'),
(11990, 31, 35, 'read'),
(11991, 31, 36, 'read'),
(11992, 31, 37, 'read'),
(11993, 31, 38, 'read'),
(11994, 31, 39, 'read'),
(11995, 31, 40, 'read'),
(11996, 31, 41, 'read'),
(11997, 31, 42, 'read'),
(11998, 31, 43, 'read'),
(11999, 31, 3, 'add'),
(12000, 31, 4, 'add'),
(12001, 31, 5, 'add'),
(12002, 31, 6, 'add'),
(12003, 31, 7, 'add'),
(12004, 31, 8, 'add'),
(12005, 31, 9, 'add'),
(12006, 31, 10, 'add'),
(12007, 31, 12, 'add'),
(12008, 31, 13, 'add'),
(12009, 31, 14, 'add'),
(12010, 31, 15, 'add'),
(12011, 31, 17, 'add'),
(12012, 31, 18, 'add'),
(12013, 31, 19, 'add'),
(12014, 31, 23, 'add'),
(12015, 31, 24, 'add'),
(12016, 31, 27, 'add'),
(12017, 31, 28, 'add'),
(12018, 31, 29, 'add'),
(12019, 31, 38, 'add'),
(12020, 31, 39, 'add'),
(12021, 31, 42, 'add'),
(12022, 31, 3, 'edit'),
(12023, 31, 4, 'edit'),
(12024, 31, 5, 'edit'),
(12025, 31, 6, 'edit'),
(12026, 31, 7, 'edit'),
(12027, 31, 8, 'edit'),
(12028, 31, 9, 'edit'),
(12029, 31, 10, 'edit'),
(12030, 31, 12, 'edit'),
(12031, 31, 13, 'edit'),
(12032, 31, 15, 'edit'),
(12033, 31, 24, 'edit'),
(12034, 31, 27, 'edit'),
(12035, 31, 29, 'edit'),
(12036, 31, 38, 'edit'),
(12037, 31, 39, 'edit'),
(12038, 31, 41, 'edit'),
(12039, 31, 43, 'edit'),
(12040, 31, 3, 'delete'),
(12041, 31, 4, 'delete'),
(12042, 31, 5, 'delete'),
(12043, 31, 6, 'delete'),
(12044, 31, 7, 'delete'),
(12045, 31, 8, 'delete'),
(12046, 31, 9, 'delete'),
(12047, 31, 10, 'delete'),
(12048, 31, 12, 'delete'),
(12049, 31, 13, 'delete'),
(12050, 31, 14, 'delete'),
(12051, 31, 15, 'delete'),
(12052, 31, 17, 'delete'),
(12053, 31, 18, 'delete'),
(12054, 31, 19, 'delete'),
(12055, 31, 23, 'delete'),
(12056, 31, 24, 'delete'),
(12057, 31, 27, 'delete'),
(12058, 31, 28, 'delete'),
(12059, 31, 29, 'delete'),
(12060, 31, 38, 'delete'),
(12061, 31, 39, 'delete');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int NOT NULL,
  `token` varchar(200) NOT NULL,
  `tanggal_jam` datetime NOT NULL,
  `id_admin` int NOT NULL,
  `id_pembeli` int DEFAULT NULL,
  `total_upah_peracik` decimal(10,0) NOT NULL,
  `total_harga_item` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `hold` enum('0','1') NOT NULL DEFAULT '0',
  `keterangan_hold` varchar(200) NOT NULL,
  `waktu_hold` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id`, `token`, `tanggal_jam`, `id_admin`, `id_pembeli`, `total_upah_peracik`, `total_harga_item`, `total`, `hold`, `keterangan_hold`, `waktu_hold`) VALUES
(69, 'a5a857b77a4e28dc0df2c5192c6c90be', '2019-06-30 01:42:32', 1, NULL, '0', '44000', '44000', '0', '', ''),
(71, 'dccbbb8941d22dac340a245b4b7052fd', '2019-06-30 03:38:33', 1, NULL, '0', '84000', '84000', '1', 'ok', '1561883934'),
(72, 'dccbbb8941d22dac340a245b4b7052fd', '2019-07-01 01:33:14', 1, NULL, '0', '27000', '27000', '0', '', ''),
(74, '4ac14df063b1729185d4e0e2a6e4379e', '2019-07-01 01:08:36', 1, NULL, '5000', '182000', '187000', '0', '', ''),
(75, '982c1b7178f668d87e8cf3e21a072cb8', '2019-07-02 05:31:44', 1, NULL, '0', '10500', '10500', '0', '', ''),
(78, 'b1f95b98bf3941e3b3c07338a2cd6402', '2019-07-03 03:31:28', 1, NULL, '0', '0', '0', '0', '', ''),
(79, '8f24b84bb00133ed237217cb89ae9805', '2019-07-03 10:03:52', 1, NULL, '0', '0', '0', '0', '', ''),
(83, '1b5adad87a92915f2f46b460b8ea6e8f', '2020-10-24 10:09:19', 1, NULL, '0', '82000', '82000', '0', '', ''),
(128, '57a8d2f89caae0de59098466cb7d834c', '2024-03-16 02:27:02', 2, NULL, '0', '0', '0', '0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang_detail`
--

CREATE TABLE `keranjang_detail` (
  `id` int NOT NULL,
  `id_keranjang` int NOT NULL,
  `kode_item` varchar(100) NOT NULL,
  `racikan` enum('0','1') NOT NULL DEFAULT '0',
  `upah_peracik` decimal(10,0) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `diskon` decimal(10,0) NOT NULL,
  `kuantiti` float NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_admin`
--

CREATE TABLE `master_admin` (
  `id` int NOT NULL,
  `kategori` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(150) NOT NULL,
  `nama_admin` varchar(200) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL DEFAULT 'laki-laki',
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(30) NOT NULL,
  `handphone` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `aktif` enum('0','1') NOT NULL DEFAULT '1',
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_admin`
--

INSERT INTO `master_admin` (`id`, `kategori`, `username`, `password`, `nama_admin`, `jenis_kelamin`, `alamat`, `telepon`, `handphone`, `email`, `aktif`, `waktu_update`) VALUES
(1, 31, 'manager', '$2y$10$UFUuezcD1OdEIoPQXOpW5eXTzYJwyMdu2/KHgwAnK/X51hquAfxke', 'Eni Surani', 'perempuan', 'Jln pepaya no 12 Bali', '', '082139221343', 'paber@gmail.com', '1', '2024-03-15 17:26:24'),
(2, 32, 'kasir', '$2y$10$jQeiZ3ROi/l/ig5he1aOtuAPMCkDfFfSHltbsLQFBT.m4p.Wc5XCS', 'Andika', 'laki-laki', 'Jalan kelapa muda no 21', '', '082183439921', 'andika@gmail.com', '1', '2024-02-03 03:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `master_bank`
--

CREATE TABLE `master_bank` (
  `singkatan` varchar(30) NOT NULL,
  `nama_bank` varchar(100) NOT NULL,
  `jenis` enum('credit card','debet') NOT NULL DEFAULT 'debet',
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_bank`
--

INSERT INTO `master_bank` (`singkatan`, `nama_bank`, `jenis`, `waktu_update`) VALUES
('Amex', 'Amex', 'credit card', '2019-06-28 11:04:06'),
('BCA', 'Bank Central Asia', 'debet', '2019-06-28 11:02:02'),
('BNI', 'Bank Nasional Indonesia', 'debet', '2019-06-28 11:02:26'),
('BRI', 'Bank Rakyat Indonesia', 'debet', '2019-06-28 11:02:26'),
('Discover', 'Discover', 'credit card', '2019-06-28 19:02:30'),
('Mandiri', 'Bank Mandiri', 'debet', '2019-06-28 11:02:02'),
('Master Card', 'Master Card', 'credit card', '2019-06-28 11:03:30'),
('Visa', 'Visa', 'credit card', '2019-06-28 11:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `master_diskon_kelipatan`
--

CREATE TABLE `master_diskon_kelipatan` (
  `id` int NOT NULL,
  `kode_item` varchar(100) NOT NULL,
  `min_kuantiti` int NOT NULL,
  `diskon` decimal(10,0) NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `waktu_update_diskon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_dokter`
--

CREATE TABLE `master_dokter` (
  `kode_dokter` varchar(15) NOT NULL,
  `nama_dokter` varchar(200) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(30) NOT NULL,
  `handphone` varchar(30) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL DEFAULT 'laki-laki',
  `spesialis` varchar(255) DEFAULT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_dokter`
--

INSERT INTO `master_dokter` (`kode_dokter`, `nama_dokter`, `alamat`, `telepon`, `handphone`, `jenis_kelamin`, `spesialis`, `waktu_update`) VALUES
('KD001', 'Dr. Andi', 'Jl. Pahlawan No. 10', '021-123456', '08123456789', 'laki-laki', 'Bedah Umum', '2024-03-15 01:00:00'),
('KD002', 'Dr. Budi', 'Jl. Diponegoro No. 15', '022-987654', '087654321', 'laki-laki', 'Dokter Gigi', '2024-03-15 02:00:00'),
('KD003', 'Dr. Cinta', 'Jl. Thamrin No. 20', '031-456789', '08987654321', 'perempuan', 'Dokter Anak', '2024-03-15 03:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `master_item`
--

CREATE TABLE `master_item` (
  `kode_item` varchar(100) NOT NULL,
  `jenis` enum('obat','alkes','racikan') NOT NULL DEFAULT 'obat',
  `kategori` varchar(100) NOT NULL,
  `satuan` varchar(100) NOT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `nama_item` varchar(200) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `gambar` varchar(200) NOT NULL DEFAULT 'default.jpg',
  `harga_jual` decimal(10,0) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upah_peracik` decimal(10,0) NOT NULL,
  `aturan_pakai` varchar(100) NOT NULL,
  `stok` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_item`
--

INSERT INTO `master_item` (`kode_item`, `jenis`, `kategori`, `satuan`, `merk`, `nama_item`, `keterangan`, `lokasi`, `gambar`, `harga_jual`, `waktu_update`, `upah_peracik`, `aturan_pakai`, `stok`) VALUES
('8234909028229', 'obat', 'Minyak urut', 'Botol', 'GPU', 'Gpu Minyak Urut Sereh 100 Ml', 'Minyak urut', 'Rak C', '8234909028229.png', '27084', '2024-03-16 08:09:09', '0', '', 0),
('8999909676352', 'obat', 'Kontrasepsi', 'Pcs', 'Sutra', 'Sutra Kondom (isi 24) (per Pcs)', 'Khusus 21+', 'Rak C', '8999909676352.png', '48835', '2024-03-16 08:12:01', '0', '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `master_kategori`
--

CREATE TABLE `master_kategori` (
  `id` varchar(100) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_kategori`
--

INSERT INTO `master_kategori` (`id`, `waktu_update`) VALUES
('Herbal', '2019-06-13 11:37:54'),
('Kecantikan', '2019-06-13 11:40:14'),
('Kontrasepsi', '2019-06-13 11:39:57'),
('Minyak urut', '2024-03-15 15:24:03'),
('Nutrisi', '2019-06-13 11:37:24'),
('Obat', '2019-06-13 11:36:58'),
('Produk Bayi', '2019-06-13 11:38:18'),
('Stetoskop', '2019-06-13 11:39:34'),
('Suplemen', '2019-06-13 11:37:11'),
('Tensimeter', '2019-06-13 11:39:11');

-- --------------------------------------------------------

--
-- Table structure for table `master_merk`
--

CREATE TABLE `master_merk` (
  `id` varchar(100) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_merk`
--

INSERT INTO `master_merk` (`id`, `waktu_update`) VALUES
('Acne', '2019-06-13 12:50:41'),
('Ambeven', '2019-06-13 12:24:48'),
('Bintang Toedjo', '2019-06-13 12:44:08'),
('Cussons', '2019-06-13 11:48:37'),
('GPU', '2024-03-15 15:23:46'),
('Sutra', '2024-03-15 14:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `master_pembeli`
--

CREATE TABLE `master_pembeli` (
  `id` int NOT NULL,
  `nama_pembeli` varchar(200) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL DEFAULT 'laki-laki',
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(30) NOT NULL,
  `handphone` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kode_dokter` varchar(15) DEFAULT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_pembeli`
--

INSERT INTO `master_pembeli` (`id`, `nama_pembeli`, `jenis_kelamin`, `alamat`, `telepon`, `handphone`, `email`, `kode_dokter`, `waktu_update`) VALUES
(1, 'Ani', 'perempuan', 'Jl. Merdeka No. 10', '021-123456', '08123456789', 'ani@example.com', 'KD001', '2024-03-15 01:00:00'),
(2, 'Budi', 'laki-laki', 'Jl. Jendral Sudirman No. 15', '022-987654', '087654321', 'budi@example.com', 'KD002', '2024-03-15 02:00:00'),
(3, 'Citra', 'perempuan', 'Jl. Gajah Mada No. 25', '031-456789', '08987654321', 'citra@example.com', 'KD003', '2024-03-15 03:00:00'),
(4, 'Dodi', 'laki-laki', 'Jl. A. Yani No. 30', '0341-987654', '08123456789', 'dodi@example.com', NULL, '2024-03-15 04:00:00'),
(5, 'Eva', 'perempuan', 'Jl. Raya Bogor No. 40', '021-123456', '087654321', 'eva@example.com', 'KD003', '2024-03-15 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `master_racikan`
--

CREATE TABLE `master_racikan` (
  `id` int NOT NULL,
  `kode_racikan` varchar(100) NOT NULL,
  `kode_obat` varchar(100) NOT NULL,
  `jumlah_obat_dibuat` float NOT NULL,
  `jumlah_obat_dipakai` float NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_satuan`
--

CREATE TABLE `master_satuan` (
  `id` varchar(100) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_satuan`
--

INSERT INTO `master_satuan` (`id`, `waktu_update`) VALUES
('Botol', '2019-03-23 14:18:45'),
('Box', '2019-06-13 12:23:46'),
('Dus', '2019-03-23 14:18:57'),
('Gram', '2019-02-16 05:53:11'),
('Kapsul', '2019-02-16 05:53:07'),
('Papan', '2019-02-16 05:52:49'),
('Pcs', '2024-03-15 14:43:21'),
('Tablet', '2019-02-15 15:50:09'),
('Tube', '2019-06-13 12:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `master_supplier`
--

CREATE TABLE `master_supplier` (
  `id` int NOT NULL,
  `nama_supplier` varchar(200) NOT NULL,
  `kontak_person` varchar(100) NOT NULL,
  `telepon` varchar(30) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_supplier`
--

INSERT INTO `master_supplier` (`id`, `nama_supplier`, `kontak_person`, `telepon`, `alamat`, `waktu_update`) VALUES
(2, 'PT Air Mancur', 'Sulistiyo', '+6288893900202', 'Jl. Udang  Cakung, Kota Jakarta Timur', '2019-06-13 11:43:26'),
(3, 'PT Maju Sejahtera Senantiasa', 'Rian', '+620921939483', 'Jl mawar melati indah bekasi barat', '2019-06-13 11:45:29'),
(4, 'PT Pelangi Jaya Bersinar', 'Joko', '+183948938493', 'Jl kemenangan bersama jakarta barat', '2019-07-02 18:51:19'),
(5, 'PT Visionary Solutions', 'John Doe', '021-123456', 'Jl. Pahlawan No. 10', '2024-03-15 01:00:00'),
(6, 'PT Nexus Dynamics', 'Jane Doe', '022-987654', 'Jl. Diponegoro No. 15', '2024-03-15 02:00:00'),
(7, 'PT Quantum Innovations', 'Michael Smith', '031-456789', 'Jl. Thamrin No. 20', '2024-03-15 03:00:00'),
(8, 'PT Stellar Creations', 'Emily Johnson', '0341-123456', 'Jl. Gatot Subroto No. 25', '2024-03-15 04:00:00'),
(9, 'PT Infinite Solutions', 'David Wilson', '0351-987654', 'Jl. Jenderal Sudirman No. 30', '2024-03-15 05:00:00'),
(10, 'PT Fusion Innovators', 'Sarah Brown', '0361-456789', 'Jl. Ahmad Yani No. 35', '2024-03-15 06:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `id` int NOT NULL,
  `label` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL,
  `nama_function` varchar(100) NOT NULL,
  `aksi_edit` enum('0','1') NOT NULL DEFAULT '1',
  `aksi_hapus` enum('0','1') NOT NULL DEFAULT '1',
  `aksi_tambah` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`id`, `label`, `controller`, `nama_function`, `aksi_edit`, `aksi_hapus`, `aksi_tambah`) VALUES
(1, 'Dashboard', 'dashboard', 'index', '0', '0', '0'),
(2, 'Master Data Beranda', 'master', 'index', '0', '0', '0'),
(3, 'Master Data Dokter', 'master', 'dokter', '1', '1', '1'),
(4, 'Master Data pembeli', 'master', 'pembeli', '1', '1', '1'),
(5, 'Master Data Supplier', 'master', 'supplier', '1', '1', '1'),
(6, 'Master Data Kategori Item', 'master', 'itemkategori', '1', '1', '1'),
(7, 'Master Data Satuan Item', 'master', 'satuan', '1', '1', '1'),
(8, 'Master Data Merk', 'master', 'merk', '1', '1', '1'),
(9, 'Master Data Obat dan Alkes', 'master', 'items', '1', '1', '1'),
(10, 'Master Racikan', 'master', 'racikan', '1', '1', '1'),
(11, 'Pembelian Beranda', 'pembelian', 'index', '0', '0', '0'),
(12, 'Purchase Order', 'pembelian', 'po', '1', '1', '1'),
(13, 'Pembelian ke Supplier', 'pembelian', 'langsung', '1', '1', '1'),
(14, 'Penerimaan Barang', 'pembelian', 'penerimaan', '0', '1', '1'),
(15, 'Retur Pembelian', 'pembelian', 'retur', '1', '1', '1'),
(16, 'Stok Beranda', 'stok', 'index', '0', '0', '0'),
(17, 'Stok Keluar Retur Pembelian', 'stok', 'keluar', '0', '1', '1'),
(18, 'Stok Adjustment', 'stok', 'adjustment', '0', '1', '1'),
(19, 'Stok Opname', 'stok', 'opname', '0', '1', '1'),
(20, 'Cetak Barcode', 'stok', 'barcode', '0', '0', '0'),
(21, 'Kartu Stok', 'stok', 'kartustok', '0', '0', '0'),
(22, 'Penjualan Beranda', 'penjualan', 'index', '0', '0', '0'),
(23, 'Diskon Produk', 'penjualan', 'diskon', '0', '1', '1'),
(24, 'Jenis Pembayaran', 'penjualan', 'jenispembayaran', '1', '1', '1'),
(25, 'Kasir / Point Of Sales', 'penjualan', 'kasir', '0', '0', '0'),
(26, 'Keuangan Beranda', 'keuangan', 'index', '0', '0', '0'),
(27, 'Kode Rekening', 'keuangan', 'koderekening', '1', '1', '1'),
(28, 'Hutang', 'keuangan', 'hutang', '0', '1', '1'),
(29, 'Cash in Cash Out', 'keuangan', 'cashinout', '1', '1', '1'),
(30, 'Laporan Beranda', 'laporan', 'index', '0', '0', '0'),
(31, 'Laporan Purchase Order', 'laporan', 'po', '0', '0', '0'),
(32, 'Laporan Pembelian', 'laporan', 'pembelian', '0', '0', '0'),
(33, 'Laporan Penerimaan Barang', 'laporan', 'penerimaan', '0', '0', '0'),
(34, 'Laporan Stok', 'laporan', 'stok', '0', '0', '0'),
(35, 'Laporan Penjualan', 'laporan', 'penjualan', '0', '0', '0'),
(36, 'Laporan Keuangan', 'laporan', 'keuangan', '0', '0', '0'),
(37, 'User Beranda', 'user', 'index', '0', '0', '0'),
(38, 'Kategori User', 'user', 'kategori', '1', '1', '1'),
(39, 'Data User', 'user', 'user', '1', '1', '1'),
(40, 'Tools Beranda', 'tools', 'index', '0', '0', '0'),
(41, 'Profil Apotek', 'tools', 'profil', '1', '0', '0'),
(42, 'Import Produk', 'tools', 'import_item', '0', '0', '1'),
(43, 'Edit Password', 'password', 'index', '1', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_langsung`
--

CREATE TABLE `pembelian_langsung` (
  `nomor_faktur` varchar(100) NOT NULL,
  `kategori` enum('Pembelian Langsung','Purchase Order') NOT NULL DEFAULT 'Pembelian Langsung',
  `nomor_po` varchar(100) DEFAULT NULL,
  `tgl_pembelian` date NOT NULL,
  `termin` int NOT NULL,
  `pembayaran` enum('cash','hutang','lain-lain') NOT NULL DEFAULT 'cash',
  `supplier` int NOT NULL,
  `total` decimal(20,0) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `waktu_update_pembelian` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian_langsung`
--

INSERT INTO `pembelian_langsung` (`nomor_faktur`, `kategori`, `nomor_po`, `tgl_pembelian`, `termin`, `pembayaran`, `supplier`, `total`, `keterangan`, `waktu_update_pembelian`) VALUES
('F1603240001', 'Purchase Order', 'PO1603240001', '2024-03-15', 0, 'cash', 3, '5000', 'Beli', '2024-03-15 18:44:12'),
('F1603240002', 'Purchase Order', 'PO1603240002', '2024-03-16', 0, 'cash', 8, '4500', 'PO tes', '2024-03-16 06:42:42'),
('F1603240003', 'Purchase Order', 'PO1603240003', '2024-03-16', 0, 'cash', 4, '130000', 'sipp', '2024-03-16 08:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_langsung_detail`
--

CREATE TABLE `pembelian_langsung_detail` (
  `idd` int NOT NULL,
  `nomor_faktur` varchar(100) NOT NULL,
  `kode_item` varchar(100) NOT NULL,
  `sku` varchar(200) NOT NULL,
  `nama_item` varchar(200) NOT NULL,
  `tgl_expired` date NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `satuan_besar` varchar(100) NOT NULL,
  `satuan_kecil` varchar(100) NOT NULL,
  `konversi` int NOT NULL,
  `kuantiti` int NOT NULL,
  `total_harga` decimal(10,0) NOT NULL,
  `diskon` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian_langsung_detail`
--

INSERT INTO `pembelian_langsung_detail` (`idd`, `nomor_faktur`, `kode_item`, `sku`, `nama_item`, `tgl_expired`, `harga`, `satuan_besar`, `satuan_kecil`, `konversi`, `kuantiti`, `total_harga`, `diskon`) VALUES
(39, 'F1603240001', '8234909028229', '8234909028229', 'Gpu Minyak Urut Sereh 100 Ml', '2024-03-20', '5000', '', 'Botol', 1, 1, '5000', 0),
(40, 'F1603240002', '8234909028229', '8234909028229', 'Gpu Minyak Urut Sereh 100 Ml', '2024-03-18', '4500', 'dos', 'Botol', 1, 1, '4500', 0),
(41, 'F1603240003', '8999909676352', '8999909676352', 'Sutra Kondom (isi 24) (per Pcs)', '2027-03-23', '26000', 'dos', 'Pcs', 1, 5, '130000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan_barang`
--

CREATE TABLE `penerimaan_barang` (
  `nomor_rec` varchar(100) NOT NULL,
  `nomor_faktur` varchar(100) NOT NULL,
  `nomor_po` varchar(100) NOT NULL,
  `tanggal_penerimaan` date NOT NULL,
  `penerima` varchar(200) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penerimaan_barang`
--

INSERT INTO `penerimaan_barang` (`nomor_rec`, `nomor_faktur`, `nomor_po`, `tanggal_penerimaan`, `penerima`, `keterangan`, `waktu_update`) VALUES
('PE1603240001', 'F1603240001', 'PO1603240001', '2024-03-28', 'Andi', 'Makasih', '2024-03-15 18:44:51'),
('PE1603240002', 'F1603240002', 'PO1603240002', '2024-03-16', 'Andi Saputra', 'Baik', '2024-03-16 06:43:10'),
('PE1603240003', 'F1603240003', 'PO1603240003', '2024-03-16', 'jarwo', '', '2024-03-16 08:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan_barang_detail`
--

CREATE TABLE `penerimaan_barang_detail` (
  `idd` int NOT NULL,
  `nomor_rec` varchar(100) NOT NULL,
  `kode_item` varchar(100) NOT NULL,
  `sku` varchar(200) NOT NULL,
  `nama_item` varchar(200) NOT NULL,
  `tgl_expired` date NOT NULL,
  `kuantiti` int NOT NULL,
  `satuan_kecil` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penerimaan_barang_detail`
--

INSERT INTO `penerimaan_barang_detail` (`idd`, `nomor_rec`, `kode_item`, `sku`, `nama_item`, `tgl_expired`, `kuantiti`, `satuan_kecil`) VALUES
(35, 'PE1603240001', '8234909028229', '8234909028229', 'Gpu Minyak Urut Sereh 100 Ml', '2024-03-20', 1, 'Botol'),
(36, 'PE1603240002', '8234909028229', '8234909028229', 'Gpu Minyak Urut Sereh 100 Ml', '2024-03-18', 1, 'Botol'),
(37, 'PE1603240003', '8999909676352', '8999909676352', 'Sutra Kondom (isi 24) (per Pcs)', '2027-03-23', 5, 'Pcs');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` varchar(50) NOT NULL,
  `id_pembeli` int DEFAULT NULL,
  `id_admin` int NOT NULL,
  `total_upah_peracik` decimal(10,0) NOT NULL,
  `total_harga_item` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `tanggal` date NOT NULL,
  `tanggal_jam` datetime NOT NULL,
  `retur` enum('0','1') NOT NULL DEFAULT '0',
  `tanggal_retur` datetime NOT NULL,
  `admin_retur` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `id_pembeli`, `id_admin`, `total_upah_peracik`, `total_harga_item`, `total`, `tanggal`, `tanggal_jam`, `retur`, `tanggal_retur`, `admin_retur`) VALUES
('150324000001', NULL, 1, '0', '244175', '244175', '2024-03-15', '2024-03-15 22:57:59', '0', '0000-00-00 00:00:00', NULL),
('150324000002', NULL, 1, '0', '48835', '48835', '2024-03-15', '2024-03-15 23:00:29', '0', '0000-00-00 00:00:00', NULL),
('150324000003', NULL, 1, '0', '195340', '195340', '2024-03-15', '2024-03-15 23:01:26', '0', '0000-00-00 00:00:00', NULL),
('150324000004', NULL, 1, '0', '270840', '270840', '2024-03-15', '2024-03-15 23:20:43', '0', '0000-00-00 00:00:00', NULL),
('150324000005', NULL, 1, '0', '976700', '976700', '2024-03-15', '2024-03-15 23:26:35', '0', '0000-00-00 00:00:00', NULL),
('150324000006', NULL, 1, '0', '622932', '622932', '2024-03-15', '2024-03-15 23:55:42', '0', '0000-00-00 00:00:00', NULL),
('150324000007', NULL, 1, '0', '75919', '75919', '2024-03-15', '2024-03-15 23:59:41', '0', '0000-00-00 00:00:00', NULL),
('160324000008', NULL, 2, '0', '27084', '27084', '2024-03-16', '2024-03-16 00:04:50', '0', '0000-00-00 00:00:00', NULL),
('160324000009', NULL, 1, '0', '244175', '244175', '2024-03-16', '2024-03-16 00:13:19', '0', '0000-00-00 00:00:00', NULL),
('160324000010', NULL, 1, '0', '27084', '27084', '2024-03-16', '2024-03-16 00:30:40', '0', '0000-00-00 00:00:00', NULL),
('160324000011', NULL, 2, '0', '54168', '54168', '2024-03-16', '2024-03-16 01:34:41', '0', '0000-00-00 00:00:00', NULL),
('160324000012', NULL, 1, '0', '27084', '27084', '2024-03-16', '2024-03-16 01:45:33', '0', '0000-00-00 00:00:00', NULL),
('160324000013', NULL, 1, '0', '27084', '27084', '2024-03-16', '2024-03-16 02:06:20', '0', '0000-00-00 00:00:00', NULL),
('160324000014', NULL, 1, '0', '27084', '27084', '2024-03-16', '2024-03-16 15:05:26', '0', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id` int NOT NULL,
  `id_penjualan` varchar(50) NOT NULL,
  `kode_item` varchar(100) NOT NULL,
  `racikan` enum('0','1') NOT NULL DEFAULT '0',
  `upah_peracik` decimal(10,0) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `diskon` decimal(10,0) NOT NULL,
  `kuantiti` float NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id`, `id_penjualan`, `kode_item`, `racikan`, `upah_peracik`, `harga`, `diskon`, `kuantiti`, `total`) VALUES
(89, '150324000001', '8999909676352', '0', '0', '48835', '0', 5, '244175'),
(90, '150324000002', '8999909676352', '0', '0', '48835', '0', 1, '48835'),
(91, '150324000003', '8999909676352', '0', '0', '48835', '0', 4, '195340'),
(92, '150324000004', '8234909028229', '0', '0', '27084', '0', 10, '270840'),
(93, '150324000005', '8999909676352', '0', '0', '48835', '0', 20, '976700'),
(94, '150324000006', '8234909028229', '0', '0', '27084', '0', 23, '622932'),
(95, '150324000007', '8234909028229', '0', '0', '27084', '0', 1, '27084'),
(96, '150324000007', '8999909676352', '0', '0', '48835', '0', 1, '48835'),
(97, '160324000008', '8234909028229', '0', '0', '27084', '0', 1, '27084'),
(98, '160324000009', '8999909676352', '0', '0', '48835', '0', 5, '244175'),
(99, '160324000010', '8234909028229', '0', '0', '27084', '0', 1, '27084'),
(100, '160324000011', '8234909028229', '0', '0', '27084', '0', 2, '54168'),
(101, '160324000012', '8234909028229', '0', '0', '27084', '0', 1, '27084'),
(102, '160324000013', '8234909028229', '0', '0', '27084', '0', 1, '27084'),
(103, '160324000014', '8234909028229', '0', '0', '27084', '0', 1, '27084');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_pembayaran`
--

CREATE TABLE `penjualan_pembayaran` (
  `id` int NOT NULL,
  `id_penjualan` varchar(50) NOT NULL,
  `nominal` decimal(10,0) NOT NULL,
  `cara_bayar` enum('cash','credit card','debet') NOT NULL DEFAULT 'cash',
  `swipe` varchar(100) NOT NULL,
  `card_no` varchar(100) NOT NULL,
  `holder_name` varchar(100) NOT NULL,
  `bank` varchar(30) NOT NULL,
  `month` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `security_code` varchar(100) NOT NULL,
  `catatan` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_pembayaran`
--

INSERT INTO `penjualan_pembayaran` (`id`, `id_penjualan`, `nominal`, `cara_bayar`, `swipe`, `card_no`, `holder_name`, `bank`, `month`, `year`, `security_code`, `catatan`) VALUES
(67, '150324000001', '400000', 'cash', '', '', '', '', '', '', '', ''),
(68, '150324000002', '200000', 'cash', '', '', '', '', '', '', '', ''),
(69, '150324000003', '200000', 'cash', '', '', '', '', '', '', '', ''),
(70, '150324000004', '400000', 'cash', '', '', '', '', '', '', '', ''),
(71, '150324000005', '1000000', 'cash', '', '', '', '', '', '', '', ''),
(72, '150324000006', '1000000', 'cash', '', '', '', '', '', '', '', ''),
(73, '150324000007', '200000', 'cash', '', '', '', '', '', '', '', ''),
(74, '160324000008', '100000', 'cash', '', '', '', '', '', '', '', ''),
(75, '160324000009', '250000', 'cash', '', '', '', '', '', '', '', ''),
(76, '160324000010', '100000', 'cash', '', '', '', '', '', '', '', ''),
(77, '160324000011', '90000', 'cash', '', '', '', '', '', '', '', ''),
(78, '160324000012', '100000', 'cash', '', '', '', '', '', '', '', ''),
(79, '160324000013', '300000', 'cash', '', '', '', '', '', '', '', ''),
(80, '160324000014', '200000', 'cash', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `piutang_dibayar_history`
--

CREATE TABLE `piutang_dibayar_history` (
  `id` int NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `id_piutang` int NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` decimal(10,0) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `piutang_history`
--

CREATE TABLE `piutang_history` (
  `id` int NOT NULL,
  `id_penjualan` varchar(50) NOT NULL,
  `id_pembeli` int DEFAULT NULL,
  `judul` varchar(200) NOT NULL,
  `tanggal` date NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `nominal` decimal(10,0) NOT NULL,
  `nominal_dibayar` decimal(10,0) NOT NULL,
  `sudah_lunas` enum('0','1') NOT NULL DEFAULT '0',
  `tanggal_lunas` date NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `keterangan` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profil_apotek`
--

CREATE TABLE `profil_apotek` (
  `id` varchar(2) NOT NULL,
  `nama_apotek` varchar(300) NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `logo` varchar(300) NOT NULL,
  `footer_struk` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profil_apotek`
--

INSERT INTO `profil_apotek` (`id`, `nama_apotek`, `alamat`, `logo`, `footer_struk`) VALUES
('1', 'APOTEK BAHAGIA SELALU', 'Jalan Kesehatan Selamat Bekasi, Jawa Barat', '1561981979.png', 'Terimakasih telah berbelanja');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `nomor_po` varchar(100) NOT NULL,
  `tgl_po` date NOT NULL,
  `termin` int NOT NULL,
  `pembayaran` enum('cash','hutang','lain-lain') NOT NULL DEFAULT 'cash',
  `supplier` int NOT NULL,
  `total` decimal(20,0) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `waktu_update_po` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`nomor_po`, `tgl_po`, `termin`, `pembayaran`, `supplier`, `total`, `keterangan`, `waktu_update_po`) VALUES
('PO1603240001', '2024-03-15', 0, 'cash', 3, '5000', 'Beli', '2024-03-15 18:43:45'),
('PO1603240002', '2024-03-07', 0, 'cash', 8, '4500', 'PO tes', '2024-03-16 06:42:08'),
('PO1603240003', '2024-03-07', 0, 'cash', 4, '130000', 'sipp', '2024-03-16 08:11:21');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_detail`
--

CREATE TABLE `purchase_order_detail` (
  `idd` int NOT NULL,
  `nomor_po` varchar(100) NOT NULL,
  `kode_item` varchar(100) NOT NULL,
  `sku` varchar(200) NOT NULL,
  `nama_item` varchar(200) NOT NULL,
  `tgl_expired` date NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `satuan_besar` varchar(100) NOT NULL,
  `satuan_kecil` varchar(100) NOT NULL,
  `konversi` int NOT NULL,
  `kuantiti` int NOT NULL,
  `total_harga` decimal(10,0) NOT NULL,
  `diskon` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_order_detail`
--

INSERT INTO `purchase_order_detail` (`idd`, `nomor_po`, `kode_item`, `sku`, `nama_item`, `tgl_expired`, `harga`, `satuan_besar`, `satuan_kecil`, `konversi`, `kuantiti`, `total_harga`, `diskon`) VALUES
(43, 'PO1603240001', '8234909028229', '8234909028229', 'Gpu Minyak Urut Sereh 100 Ml', '2024-03-20', '5000', '', 'Botol', 1, 1, '5000', 0),
(44, 'PO1603240002', '8234909028229', '8234909028229', 'Gpu Minyak Urut Sereh 100 Ml', '2024-03-18', '4500', 'dos', 'Botol', 1, 1, '4500', 0),
(45, 'PO1603240003', '8999909676352', '8999909676352', 'Sutra Kondom (isi 24) (per Pcs)', '2027-03-23', '26000', 'dos', 'Pcs', 1, 5, '130000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rekening_kode`
--

CREATE TABLE `rekening_kode` (
  `kode_rekening` varchar(30) NOT NULL,
  `kategori` enum('pemasukan','pengeluaran') NOT NULL DEFAULT 'pemasukan',
  `nama_rekening` varchar(200) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `editable` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rekening_kode`
--

INSERT INTO `rekening_kode` (`kode_rekening`, `kategori`, `nama_rekening`, `waktu_update`, `editable`) VALUES
('10001', 'pemasukan', 'Penjualan', '2019-05-28 14:03:51', '0'),
('20001', 'pengeluaran', 'Pembelian ke supplier', '2019-05-28 07:03:51', '0'),
('20008', 'pengeluaran', 'Beli token listrik', '2024-03-15 17:25:37', '1');

-- --------------------------------------------------------

--
-- Table structure for table `retur_pembelian`
--

CREATE TABLE `retur_pembelian` (
  `nomor_retur` varchar(100) NOT NULL,
  `nomor_faktur` varchar(100) NOT NULL,
  `nomor_rec_penerimaan` varchar(100) NOT NULL,
  `tanggal_retur` date NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stok_adjustment`
--

CREATE TABLE `stok_adjustment` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `nomor_ref` varchar(100) NOT NULL,
  `stok_sebelum` int NOT NULL,
  `kuantiti_berubah` int NOT NULL,
  `kode_item` varchar(100) NOT NULL,
  `nama_item` varchar(200) NOT NULL,
  `tgl_expired` date NOT NULL,
  `satuan_kecil` varchar(100) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_adjustment`
--

INSERT INTO `stok_adjustment` (`id`, `tanggal`, `nomor_ref`, `stok_sebelum`, `kuantiti_berubah`, `kode_item`, `nama_item`, `tgl_expired`, `satuan_kecil`, `keterangan`, `waktu_update`) VALUES
(1, '2024-03-16', 'SA1603240001', 6, 1, '8234909028229', 'Gpu Minyak Urut Sereh 100 Ml', '2024-03-29', 'Botol', 'okey', '2024-03-16 08:00:50');

-- --------------------------------------------------------

--
-- Table structure for table `stok_opname`
--

CREATE TABLE `stok_opname` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `nomor_ref` varchar(100) NOT NULL,
  `stok_sebelum` int NOT NULL,
  `kuantiti_berubah` int NOT NULL,
  `kode_item` varchar(100) NOT NULL,
  `nama_item` varchar(200) NOT NULL,
  `tgl_expired` date NOT NULL,
  `satuan_kecil` varchar(100) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `verifikasi` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok_opname`
--

INSERT INTO `stok_opname` (`id`, `tanggal`, `nomor_ref`, `stok_sebelum`, `kuantiti_berubah`, `kode_item`, `nama_item`, `tgl_expired`, `satuan_kecil`, `keterangan`, `waktu_update`, `verifikasi`) VALUES
(1, '2024-03-15', 'SO1503240001', 0, 10, '8999909676352', 'Sutra Kondom (isi 24) (per Pcs)', '2024-05-23', 'Pcs', 'Tambah stok tes', '2024-03-15 14:47:12', '1'),
(2, '2024-03-15', 'SO1503240002', 0, 50, '8999909676352', 'Sutra Kondom (isi 24) (per Pcs)', '2026-02-03', 'Pcs', 'Tambah stok tes', '2024-03-15 15:14:06', '1'),
(3, '2024-03-15', 'SO1503240003', 0, 60, '8234909028229', 'Gpu Minyak Urut Sereh 100 Ml', '2029-07-01', 'Botol', 'Tambah stok tes', '2024-03-15 15:30:26', '1'),
(7, '2024-03-16', 'SO1603240004', -26, 26, '8999909676352', 'Sutra Kondom (isi 24) (per Pcs)', '2024-03-16', 'Pcs', 'tes', '2024-03-16 08:10:19', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cash_in_out`
--
ALTER TABLE `cash_in_out`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_rekening` (`kode_rekening`),
  ADD KEY `id_hutang_dibayar` (`id_hutang_dibayar`),
  ADD KEY `id_piutang_dibayar` (`id_piutang_dibayar`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `hutang_dibayar_history`
--
ALTER TABLE `hutang_dibayar_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_hutang` (`id_hutang`);

--
-- Indexes for table `hutang_history`
--
ALTER TABLE `hutang_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomor_faktur` (`nomor_faktur`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indexes for table `kartu_stok`
--
ALTER TABLE `kartu_stok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_item` (`kode_item`),
  ADD KEY `nomor_rec` (`nomor_rec_penerimaan`),
  ADD KEY `id_stok_keluar` (`id_stok_keluar`),
  ADD KEY `id_stok_adjustment` (`id_stok_adjustment`),
  ADD KEY `id_stok_opname` (`id_stok_opname`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `kategori_user`
--
ALTER TABLE `kategori_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategori_user` (`kategori_user`),
  ADD KEY `beranda` (`beranda`);

--
-- Indexes for table `kategori_user_modul`
--
ALTER TABLE `kategori_user_modul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_user` (`kategori_user`),
  ADD KEY `modul` (`modul`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_pembeli` (`id_pembeli`);

--
-- Indexes for table `keranjang_detail`
--
ALTER TABLE `keranjang_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_keranjang` (`id_keranjang`),
  ADD KEY `kode_item` (`kode_item`);

--
-- Indexes for table `master_admin`
--
ALTER TABLE `master_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `kategori` (`kategori`);

--
-- Indexes for table `master_bank`
--
ALTER TABLE `master_bank`
  ADD PRIMARY KEY (`singkatan`);

--
-- Indexes for table `master_diskon_kelipatan`
--
ALTER TABLE `master_diskon_kelipatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_item` (`kode_item`);

--
-- Indexes for table `master_dokter`
--
ALTER TABLE `master_dokter`
  ADD PRIMARY KEY (`kode_dokter`);

--
-- Indexes for table `master_item`
--
ALTER TABLE `master_item`
  ADD PRIMARY KEY (`kode_item`);

--
-- Indexes for table `master_kategori`
--
ALTER TABLE `master_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_merk`
--
ALTER TABLE `master_merk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_pembeli`
--
ALTER TABLE `master_pembeli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_dokter` (`kode_dokter`);

--
-- Indexes for table `master_racikan`
--
ALTER TABLE `master_racikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `master_racikan_ibfk_1` (`kode_racikan`),
  ADD KEY `kode_obat` (`kode_obat`);

--
-- Indexes for table `master_satuan`
--
ALTER TABLE `master_satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_supplier`
--
ALTER TABLE `master_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian_langsung`
--
ALTER TABLE `pembelian_langsung`
  ADD PRIMARY KEY (`nomor_faktur`),
  ADD KEY `supplier` (`supplier`),
  ADD KEY `nomor_po` (`nomor_po`);

--
-- Indexes for table `pembelian_langsung_detail`
--
ALTER TABLE `pembelian_langsung_detail`
  ADD PRIMARY KEY (`idd`),
  ADD KEY `kode_item` (`kode_item`),
  ADD KEY `nomor_po` (`nomor_faktur`);

--
-- Indexes for table `penerimaan_barang`
--
ALTER TABLE `penerimaan_barang`
  ADD PRIMARY KEY (`nomor_rec`),
  ADD KEY `nomor_faktur` (`nomor_faktur`);

--
-- Indexes for table `penerimaan_barang_detail`
--
ALTER TABLE `penerimaan_barang_detail`
  ADD PRIMARY KEY (`idd`),
  ADD KEY `nomor_rec` (`nomor_rec`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pembeli` (`id_pembeli`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `admin_retur` (`admin_retur`);

--
-- Indexes for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_item` (`kode_item`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `penjualan_pembayaran`
--
ALTER TABLE `penjualan_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `piutang_dibayar_history`
--
ALTER TABLE `piutang_dibayar_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_piutang` (`id_piutang`);

--
-- Indexes for table `piutang_history`
--
ALTER TABLE `piutang_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pembeli` (`id_pembeli`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `profil_apotek`
--
ALTER TABLE `profil_apotek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`nomor_po`),
  ADD KEY `supplier` (`supplier`);

--
-- Indexes for table `purchase_order_detail`
--
ALTER TABLE `purchase_order_detail`
  ADD PRIMARY KEY (`idd`),
  ADD KEY `kode_item` (`kode_item`),
  ADD KEY `nomor_po` (`nomor_po`);

--
-- Indexes for table `rekening_kode`
--
ALTER TABLE `rekening_kode`
  ADD PRIMARY KEY (`kode_rekening`);

--
-- Indexes for table `retur_pembelian`
--
ALTER TABLE `retur_pembelian`
  ADD PRIMARY KEY (`nomor_retur`),
  ADD KEY `nomor_faktur` (`nomor_faktur`),
  ADD KEY `nomor_rec_penerimaan` (`nomor_rec_penerimaan`);

--
-- Indexes for table `stok_adjustment`
--
ALTER TABLE `stok_adjustment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_ref` (`nomor_ref`),
  ADD KEY `kode_item` (`kode_item`);

--
-- Indexes for table `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_ref` (`nomor_ref`),
  ADD KEY `kode_item` (`kode_item`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cash_in_out`
--
ALTER TABLE `cash_in_out`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `hutang_dibayar_history`
--
ALTER TABLE `hutang_dibayar_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hutang_history`
--
ALTER TABLE `hutang_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `kartu_stok`
--
ALTER TABLE `kartu_stok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `kategori_user`
--
ALTER TABLE `kategori_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `kategori_user_modul`
--
ALTER TABLE `kategori_user_modul`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12062;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `keranjang_detail`
--
ALTER TABLE `keranjang_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `master_admin`
--
ALTER TABLE `master_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_diskon_kelipatan`
--
ALTER TABLE `master_diskon_kelipatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `master_pembeli`
--
ALTER TABLE `master_pembeli`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `master_racikan`
--
ALTER TABLE `master_racikan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `master_supplier`
--
ALTER TABLE `master_supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `pembelian_langsung_detail`
--
ALTER TABLE `pembelian_langsung_detail`
  MODIFY `idd` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `penerimaan_barang_detail`
--
ALTER TABLE `penerimaan_barang_detail`
  MODIFY `idd` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `penjualan_pembayaran`
--
ALTER TABLE `penjualan_pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `piutang_dibayar_history`
--
ALTER TABLE `piutang_dibayar_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `piutang_history`
--
ALTER TABLE `piutang_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_detail`
--
ALTER TABLE `purchase_order_detail`
  MODIFY `idd` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `stok_adjustment`
--
ALTER TABLE `stok_adjustment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stok_opname`
--
ALTER TABLE `stok_opname`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cash_in_out`
--
ALTER TABLE `cash_in_out`
  ADD CONSTRAINT `cash_in_out_ibfk_1` FOREIGN KEY (`kode_rekening`) REFERENCES `rekening_kode` (`kode_rekening`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cash_in_out_ibfk_2` FOREIGN KEY (`id_hutang_dibayar`) REFERENCES `hutang_dibayar_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cash_in_out_ibfk_3` FOREIGN KEY (`id_piutang_dibayar`) REFERENCES `piutang_dibayar_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cash_in_out_ibfk_4` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hutang_dibayar_history`
--
ALTER TABLE `hutang_dibayar_history`
  ADD CONSTRAINT `hutang_dibayar_history_ibfk_1` FOREIGN KEY (`id_hutang`) REFERENCES `hutang_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hutang_history`
--
ALTER TABLE `hutang_history`
  ADD CONSTRAINT `hutang_history_ibfk_1` FOREIGN KEY (`nomor_faktur`) REFERENCES `pembelian_langsung` (`nomor_faktur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hutang_history_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `master_supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kartu_stok`
--
ALTER TABLE `kartu_stok`
  ADD CONSTRAINT `kartu_stok_ibfk_1` FOREIGN KEY (`kode_item`) REFERENCES `master_item` (`kode_item`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kartu_stok_ibfk_2` FOREIGN KEY (`nomor_rec_penerimaan`) REFERENCES `penerimaan_barang` (`nomor_rec`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kartu_stok_ibfk_3` FOREIGN KEY (`id_stok_keluar`) REFERENCES `stok_keluar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kartu_stok_ibfk_4` FOREIGN KEY (`id_stok_adjustment`) REFERENCES `stok_adjustment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kartu_stok_ibfk_5` FOREIGN KEY (`id_stok_opname`) REFERENCES `stok_opname` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kartu_stok_ibfk_6` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kategori_user`
--
ALTER TABLE `kategori_user`
  ADD CONSTRAINT `kategori_user_ibfk_1` FOREIGN KEY (`beranda`) REFERENCES `modul` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kategori_user_modul`
--
ALTER TABLE `kategori_user_modul`
  ADD CONSTRAINT `kategori_user_modul_ibfk_1` FOREIGN KEY (`kategori_user`) REFERENCES `kategori_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kategori_user_modul_ibfk_2` FOREIGN KEY (`modul`) REFERENCES `modul` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `master_admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`id_pembeli`) REFERENCES `master_pembeli` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keranjang_detail`
--
ALTER TABLE `keranjang_detail`
  ADD CONSTRAINT `keranjang_detail_ibfk_1` FOREIGN KEY (`id_keranjang`) REFERENCES `keranjang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `keranjang_detail_ibfk_2` FOREIGN KEY (`kode_item`) REFERENCES `master_item` (`kode_item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_admin`
--
ALTER TABLE `master_admin`
  ADD CONSTRAINT `master_admin_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori_user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `master_diskon_kelipatan`
--
ALTER TABLE `master_diskon_kelipatan`
  ADD CONSTRAINT `master_diskon_kelipatan_ibfk_1` FOREIGN KEY (`kode_item`) REFERENCES `master_item` (`kode_item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_pembeli`
--
ALTER TABLE `master_pembeli`
  ADD CONSTRAINT `master_pembeli_ibfk_1` FOREIGN KEY (`kode_dokter`) REFERENCES `master_dokter` (`kode_dokter`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_racikan`
--
ALTER TABLE `master_racikan`
  ADD CONSTRAINT `master_racikan_ibfk_1` FOREIGN KEY (`kode_racikan`) REFERENCES `master_item` (`kode_item`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `master_racikan_ibfk_2` FOREIGN KEY (`kode_obat`) REFERENCES `master_item` (`kode_item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian_langsung`
--
ALTER TABLE `pembelian_langsung`
  ADD CONSTRAINT `pembelian_langsung_ibfk_1` FOREIGN KEY (`nomor_po`) REFERENCES `purchase_order` (`nomor_po`);

--
-- Constraints for table `pembelian_langsung_detail`
--
ALTER TABLE `pembelian_langsung_detail`
  ADD CONSTRAINT `pembelian_langsung_detail_ibfk_1` FOREIGN KEY (`nomor_faktur`) REFERENCES `pembelian_langsung` (`nomor_faktur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_langsung_detail_ibfk_2` FOREIGN KEY (`kode_item`) REFERENCES `master_item` (`kode_item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penerimaan_barang`
--
ALTER TABLE `penerimaan_barang`
  ADD CONSTRAINT `penerimaan_barang_ibfk_1` FOREIGN KEY (`nomor_faktur`) REFERENCES `pembelian_langsung` (`nomor_faktur`) ON UPDATE CASCADE;

--
-- Constraints for table `penerimaan_barang_detail`
--
ALTER TABLE `penerimaan_barang_detail`
  ADD CONSTRAINT `penerimaan_barang_detail_ibfk_1` FOREIGN KEY (`nomor_rec`) REFERENCES `penerimaan_barang` (`nomor_rec`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_pembeli`) REFERENCES `master_pembeli` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `master_admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_ibfk_3` FOREIGN KEY (`admin_retur`) REFERENCES `master_admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD CONSTRAINT `penjualan_detail_ibfk_1` FOREIGN KEY (`kode_item`) REFERENCES `master_item` (`kode_item`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_detail_ibfk_2` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualan_pembayaran`
--
ALTER TABLE `penjualan_pembayaran`
  ADD CONSTRAINT `penjualan_pembayaran_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `piutang_dibayar_history`
--
ALTER TABLE `piutang_dibayar_history`
  ADD CONSTRAINT `piutang_dibayar_history_ibfk_1` FOREIGN KEY (`id_piutang`) REFERENCES `piutang_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `piutang_history`
--
ALTER TABLE `piutang_history`
  ADD CONSTRAINT `piutang_history_ibfk_2` FOREIGN KEY (`id_pembeli`) REFERENCES `master_pembeli` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `piutang_history_ibfk_3` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD CONSTRAINT `purchase_order_ibfk_1` FOREIGN KEY (`supplier`) REFERENCES `master_supplier` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `purchase_order_detail`
--
ALTER TABLE `purchase_order_detail`
  ADD CONSTRAINT `purchase_order_detail_ibfk_1` FOREIGN KEY (`nomor_po`) REFERENCES `purchase_order` (`nomor_po`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_order_detail_ibfk_2` FOREIGN KEY (`kode_item`) REFERENCES `master_item` (`kode_item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `retur_pembelian`
--
ALTER TABLE `retur_pembelian`
  ADD CONSTRAINT `retur_pembelian_ibfk_1` FOREIGN KEY (`nomor_faktur`) REFERENCES `pembelian_langsung` (`nomor_faktur`) ON UPDATE CASCADE,
  ADD CONSTRAINT `retur_pembelian_ibfk_2` FOREIGN KEY (`nomor_rec_penerimaan`) REFERENCES `penerimaan_barang` (`nomor_rec`) ON UPDATE CASCADE;

--
-- Constraints for table `stok_adjustment`
--
ALTER TABLE `stok_adjustment`
  ADD CONSTRAINT `stok_adjustment_ibfk_1` FOREIGN KEY (`kode_item`) REFERENCES `master_item` (`kode_item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD CONSTRAINT `stok_opname_ibfk_1` FOREIGN KEY (`kode_item`) REFERENCES `master_item` (`kode_item`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
