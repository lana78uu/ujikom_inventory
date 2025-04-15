-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Apr 2025 pada 06.39
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `PenjualanID` int(11) NOT NULL,
  `TokoID` int(11) DEFAULT NULL,
  `NamaProduk` varchar(25) NOT NULL,
  `Harga` decimal(10,2) NOT NULL,
  `Stok` int(11) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL,
  `TanggalPenjualan` date NOT NULL,
  `ProdukID` int(11) NOT NULL,
  `NamaToko` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`PenjualanID`, `TokoID`, `NamaProduk`, `Harga`, `Stok`, `Subtotal`, `TanggalPenjualan`, `ProdukID`, `NamaToko`) VALUES
(82, 1, 'CANON PowerShot G7 X Mark', 8000000.00, 5, 40000000.00, '2025-04-13', 26, 'Canon Indonesia'),
(83, 1, 'EOS 3000D Kit ', 8000000.00, 4, 32000000.00, '2025-04-16', 29, 'Canon Indonesia'),
(84, 1, 'CANON PowerShot G7 X Mark', 8000000.00, 5, 40000000.00, '2025-04-17', 26, 'Canon Indonesia'),
(85, 2, 'NIKON D850', 7000000.00, 5, 35000000.00, '2025-04-18', 27, 'Nikon Indonesia'),
(86, 1, 'PowerShot V10', 10000000.00, 5, 50000000.00, '2025-04-18', 30, 'Canon Indonesia'),
(87, 1, 'CANON PowerShot G7 X Mark', 8000000.00, 5, 40000000.00, '2025-04-19', 26, 'Canon Indonesia'),
(88, 2, 'NIKON aja', 2000000.00, 3, 6000000.00, '2025-04-15', 32, 'Nikon Indonesia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `ProdukID` int(11) NOT NULL,
  `NamaProduk` varchar(25) DEFAULT NULL,
  `Harga` decimal(10,2) DEFAULT NULL,
  `Stok` int(11) DEFAULT NULL,
  `TanggalMasuk` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`ProdukID`, `NamaProduk`, `Harga`, `Stok`, `TanggalMasuk`, `user_id`) VALUES
(26, 'CANON PowerShot G7 X Mark', 8000000.00, 25, '2025-04-13', NULL),
(27, 'NIKON D850', 7000000.00, 35, '2025-04-13', NULL),
(29, 'EOS 3000D Kit ', 8000000.00, 5, '2025-04-15', NULL),
(30, 'PowerShot V10', 10000000.00, 4, '2025-04-16', NULL),
(31, 'Canon EOS 6D Mark II', 10700000.00, 8, '2025-04-17', NULL),
(32, 'NIKON aja', 2000000.00, 2, '2025-04-15', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `toko`
--

CREATE TABLE `toko` (
  `TokoID` int(11) NOT NULL,
  `NamaToko` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `toko`
--

INSERT INTO `toko` (`TokoID`, `NamaToko`) VALUES
(1, 'Canon Indonesia'),
(2, 'Nikon Indonesia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `alamat`) VALUES
(1, 'admin', '123', 'Kota Cimahi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`PenjualanID`),
  ADD KEY `TokoID` (`TokoID`),
  ADD KEY `ProdukID` (`ProdukID`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`ProdukID`),
  ADD KEY `fk_produk_user` (`user_id`);

--
-- Indeks untuk tabel `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`TokoID`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `PenjualanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `ProdukID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `toko`
--
ALTER TABLE `toko`
  MODIFY `TokoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1235;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`TokoID`) REFERENCES `toko` (`TokoID`),
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`ProdukID`) REFERENCES `produk` (`ProdukID`);

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `fk_produk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
