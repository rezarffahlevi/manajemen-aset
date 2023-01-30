-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 31, 2023 at 12:06 AM
-- Server version: 10.5.18-MariaDB-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `idco0927_mulmed`
--

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `id` int(11) NOT NULL,
  `number` varchar(50) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `penyimpanan_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `spr_id` int(11) DEFAULT NULL,
  `status` varchar(70) DEFAULT NULL,
  `material` varchar(200) DEFAULT NULL,
  `vendor` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id`, `number`, `brand`, `penyimpanan_id`, `jumlah`, `spr_id`, `status`, `material`, `vendor`) VALUES
(1, '1233221', 'Nokia', 2, 12, NULL, NULL, 'nama ku', 'Icon');

-- --------------------------------------------------------

--
-- Table structure for table `penyimpanan`
--

CREATE TABLE `penyimpanan` (
  `id` int(11) NOT NULL,
  `lokasi` varchar(200) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyimpanan`
--

INSERT INTO `penyimpanan` (`id`, `lokasi`, `keterangan`) VALUES
(2, 'Laci', 'rak 1'),
(3, 'Bawah meja', 'Samping sepatu');

-- --------------------------------------------------------

--
-- Table structure for table `rekanan`
--

CREATE TABLE `rekanan` (
  `id` int(11) NOT NULL,
  `nama_perusahaan` varchar(200) DEFAULT NULL,
  `pic` varchar(150) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekanan`
--

INSERT INTO `rekanan` (`id`, `nama_perusahaan`, `pic`, `email`, `telp`) VALUES
(2, 'Rekan Saya', 'Saya sendiri', 'rekan@yopmail.com', '08123213213');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id` int(11) NOT NULL,
  `material_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `lokasi_tujuan` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `penyimpanan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rma`
--

CREATE TABLE `rma` (
  `id` int(11) NOT NULL,
  `lokasi_barang` varchar(200) NOT NULL,
  `material_id` int(11) DEFAULT NULL,
  `penyimpanan_id` int(11) DEFAULT NULL,
  `jumlah` int(11) UNSIGNED DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spr`
--

CREATE TABLE `spr` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `no_spr` varchar(150) DEFAULT NULL,
  `rab` double(10,0) DEFAULT NULL,
  `realisasi` double(10,0) DEFAULT NULL,
  `jenis_anggaran` varchar(150) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `rekanan_id` int(11) DEFAULT NULL,
  `nomor_io` varchar(150) DEFAULT NULL,
  `status` varchar(70) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(70) NOT NULL,
  `password` varchar(150) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `level`) VALUES
(1, 'admin', '6116afedcb0bc31083935c1c262ff4c9', 'Admin Icon+', 'Admin'),
(3, 'staff', '6116afedcb0bc31083935c1c262ff4c9', 'Staff  P', 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penyimpanan`
--
ALTER TABLE `penyimpanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rekanan`
--
ALTER TABLE `rekanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rma`
--
ALTER TABLE `rma`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spr`
--
ALTER TABLE `spr`
  ADD UNIQUE KEY `unique_id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penyimpanan`
--
ALTER TABLE `penyimpanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rekanan`
--
ALTER TABLE `rekanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spr`
--
ALTER TABLE `spr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
