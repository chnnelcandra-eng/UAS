-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Jul 2026 pada 22.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detailpembelian`
--

CREATE TABLE `detailpembelian` (
  `id` int(11) NOT NULL,
  `kodepb` varchar(30) NOT NULL,
  `kode_item` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `harga` decimal(15,2) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detailpembelian`
--

INSERT INTO `detailpembelian` (`id`, `kodepb`, `kode_item`, `nama`, `satuan`, `harga`, `qty`, `subtotal`) VALUES
(1, 'pb20260625060321', 'm01', 'Beras', 'kg', 15000.00, 1.00, 15000.00),
(2, 'pb20260625060413', 'm02', 'Sedapgoreng', 'kardus', 100000.00, 1.00, 100000.00),
(3, 'pb20260625060413', 'm04', 'Gula', 'sak', 750000.00, 1.00, 750000.00),
(4, 'pb20260625060835', 'm06', 'Telur', 'kg', 25000.00, 1.00, 25000.00),
(5, 'pb20260701050318', 'm01', 'Beras', 'kg', 15000.00, 1.00, 15000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detailpenjualan`
--

CREATE TABLE `detailpenjualan` (
  `kodepj` varchar(20) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `hjual` double DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `subtotal` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detailpenjualan`
--

INSERT INTO `detailpenjualan` (`kodepj`, `kode`, `hjual`, `qty`, `subtotal`) VALUES
('pj20260612063113', 'm02', 110000, 1, 110000),
('pj20260612143636', 'm04', 795000, 1, 795000),
('pj20260612151516', 'm08', 279000, 1, 279000),
('pj20260612151823', 'm08', 279000, 1, 279000),
('pj20260623082105', 'm01', 17000, 1, 17000),
('pj20260623082105', 'm02', 110000, 1, 110000),
('pj20260623082105', 'm06', 28000, 1, 28000),
('pj20260623084530', 'm02', 110000, 1, 110000),
('pj20260623084530', 'm03', 3000, 1, 3000),
('pj20260623084530', 'm05', 2500, 1, 2500),
('pj20260623084647', 'm05', 2500, 1, 2500),
('pj20260623084647', 'm06', 28000, 1, 28000),
('pj20260623084647', 'm08', 279000, 1, 279000),
('pj20260623091052', 'm01', 17000, 1, 17000),
('pj20260623091052', 'm04', 795000, 1, 795000),
('pj20260623091052', 'm05', 2500, 1, 2500),
('pj20260623092002', 'm01', 17000, 1, 17000),
('pj20260623092002', 'm03', 3000, 1, 3000),
('pj20260623092002', 'm05', 2500, 1, 2500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `hbeli` double NOT NULL,
  `hjual` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `items`
--

INSERT INTO `items` (`kode`, `nama`, `satuan`, `hbeli`, `hjual`) VALUES
('m01', 'Beras', 'kg', 15000, 17000),
('m02', 'Sedapgoreng', 'kardus', 100000, 110000),
('m03', 'Indomie Kuah', 'bungkus', 2500, 3000),
('m04', 'Gula', 'sak', 750000, 795000),
('m05', 'Sedap Soto', 'bungkus', 2000, 2500),
('m06', 'Telur', 'kg', 25000, 28000),
('m07', 'Hoodie', 'pcs', 120000, 150000),
('m08', 'Pati', 'sak', 279000, 279000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `masterpembelian`
--

CREATE TABLE `masterpembelian` (
  `id` int(11) NOT NULL,
  `kodepb` varchar(30) NOT NULL,
  `tgl` date NOT NULL,
  `nama_perusahaan` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `total` decimal(15,2) DEFAULT 0.00,
  `diskon` decimal(5,2) DEFAULT 0.00,
  `grandtotal` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `masterpembelian`
--

INSERT INTO `masterpembelian` (`id`, `kodepb`, `tgl`, `nama_perusahaan`, `contact_person`, `hp`, `alamat`, `keterangan`, `total`, `diskon`, `grandtotal`) VALUES
(1, 'pb20260625060321', '2026-06-25', 'Toko Cak Agus', 'Cak Agus', '9090999', 'Jombang', 'Ada', 15000.00, 0.00, 15000.00),
(2, 'pb20260625060413', '2026-06-25', 'Toko Cak Agus', 'Cak Agus', '9090999', 'Jombang', 'Ada', 850000.00, 10.00, 765000.00),
(3, 'pb20260625060835', '2026-06-25', 'Toko Cak Agus', 'Cak Agus', '9090999', 'Jombang', 'Ada', 25000.00, 0.00, 25000.00),
(4, 'pb20260701050318', '2026-07-01', 'Toko Cak Agus', 'Cak Agus', '9090999', 'Jombang', 'Ada', 15000.00, 0.00, 15000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `masterpenjualan`
--

CREATE TABLE `masterpenjualan` (
  `kodepj` varchar(20) NOT NULL,
  `tgl` date NOT NULL,
  `customerName` varchar(100) NOT NULL,
  `phoneNum` varchar(15) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `total` double NOT NULL,
  `diskon` double NOT NULL,
  `subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `masterpenjualan`
--

INSERT INTO `masterpenjualan` (`kodepj`, `tgl`, `customerName`, `phoneNum`, `keterangan`, `total`, `diskon`, `subtotal`) VALUES
('pj20260612063113', '2026-06-12', 'candra', '08577674303', 'pelanggan 1', 110000, 0, 110000),
('pj20260612143636', '2026-06-12', 'Candra', '084776', 'pelanggan2', 795000, 15, 675750),
('pj20260612151516', '2026-06-12', 'Noel', '0909', 'pelanggan3', 279000, 10, 251100),
('pj20260612151823', '2026-06-12', 'Noel', '0909', 'pelanggan3', 279000, 10, 251100),
('pj20260623082105', '2026-06-23', 'Candra', '084776', 'ada', 155000, 10, 139500),
('pj20260623084530', '2026-06-23', 'candra', '085776794303', 'pelanggan 2', 115500, 10, 103950),
('pj20260623084647', '2026-06-23', 'candra', '085776794303', 'pelanggan 3', 309500, 10, 278550),
('pj20260623091052', '2026-06-23', 'candra', '085776794303', 'pelanggan 3', 814500, 10, 733050),
('pj20260623092002', '2026-06-23', 'candra', '085776794303', 'ada', 22500, 10, 20250);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama_perusahaan` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nama_perusahaan`, `contact_person`, `hp`, `alamat`, `keterangan`) VALUES
(0, 'Toko Cak Agus', 'Cak Agus', '9090999', 'Jombang', 'Ada');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detailpembelian`
--
ALTER TABLE `detailpembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`kode`);

--
-- Indeks untuk tabel `masterpembelian`
--
ALTER TABLE `masterpembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `masterpenjualan`
--
ALTER TABLE `masterpenjualan`
  ADD PRIMARY KEY (`kodepj`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detailpembelian`
--
ALTER TABLE `detailpembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `masterpembelian`
--
ALTER TABLE `masterpembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
