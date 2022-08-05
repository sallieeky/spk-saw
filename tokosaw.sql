-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Jul 2022 pada 09.24
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokosaw`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `idcart` int(11) NOT NULL,
  `orderid` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `tglorder` timestamp NOT NULL DEFAULT current_timestamp(),
  `alamat_pengantaran` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `ongkir` int(11) NOT NULL,
  `jenis_pengiriman` varchar(254) DEFAULT NULL,
  `resi` varchar(100) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Cart'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`idcart`, `orderid`, `userid`, `tglorder`, `alamat_pengantaran`, `catatan`, `ongkir`, `jenis_pengiriman`, `resi`, `status`) VALUES
(4, 'OR-2022-0000001', 2, '2022-07-23 04:42:25', 'Jl.1', '', 15000, 'jnt', '12', 'Selesai'),
(5, 'OR-2022-0000002', 4, '2022-07-23 04:43:16', 'jl.2', '', 15000, 'jnt', '12345', 'Selesai'),
(6, 'OR-2022-0000003', 5, '2022-07-23 04:43:57', 'jl.3', '', 15000, 'jnt', '123', 'Selesai'),
(7, 'OR-2022-0000004', 2, '2022-07-23 04:48:48', 'jl.1', '', 15000, 'gojek', '12', 'Selesai'),
(8, 'OR-2022-0000005', 4, '2022-07-23 04:50:32', 'jl.2', '', 15000, 'gojek', '123', 'Selesai'),
(9, 'OR-2022-0000006', 5, '2022-07-23 04:51:57', 'jl.3', '', 15000, 'gojek', '123', 'Selesai'),
(10, 'OR-2022-0000007', 2, '2022-07-23 04:55:00', 'jl.1', '', 15000, 'jne', '3', 'Selesai'),
(11, 'OR-2022-0000008', 4, '2022-07-23 04:55:56', 'jl.2', '', 15000, 'jne', '2', 'Selesai'),
(12, 'OR-2022-0000009', 5, '2022-07-23 04:56:46', 'jl.3', '', 15000, 'jne', '1', 'Selesai'),
(13, 'OR-2022-0000010', 2, '2022-07-23 04:58:42', 'jl.1', '', 15000, 'gojek', '3', 'Selesai'),
(14, 'OR-2022-0000011', 4, '2022-07-23 04:59:43', 'jl.2', '', 15000, 'gojek', '2', 'Selesai'),
(15, 'OR-2022-0000012', 5, '2022-07-23 05:00:50', 'jl.3', '', 15000, 'gojek', '1', 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `config`
--

CREATE TABLE `config` (
  `id_config` int(11) NOT NULL,
  `nama` varchar(254) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `nohp` varchar(20) NOT NULL,
  `tagline` varchar(254) NOT NULL,
  `ongkir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `config`
--

INSERT INTO `config` (`id_config`, `nama`, `alamat`, `email`, `nohp`, `tagline`, `ongkir`) VALUES
(1, 'Warung Uthie', 'Jl. Tiga RT 32 No. 114 Kel. Gunung Samarinda Lama, Balikpapan Utara', 'warunguthie@gmail.com', '081253755312', 'Harga Miring Kualiatas Bersaing', 15000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detailorder`
--

CREATE TABLE `detailorder` (
  `detailid` int(11) NOT NULL,
  `orderid` varchar(100) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detailorder`
--

INSERT INTO `detailorder` (`detailid`, `orderid`, `idproduk`, `qty`) VALUES
(5, 'OR-2022-0000001', 1, 1),
(6, 'OR-2022-0000002', 1, 1),
(7, 'OR-2022-0000003', 1, 1),
(8, 'OR-2022-0000004', 2, 2),
(9, 'OR-2022-0000005', 2, 1),
(10, 'OR-2022-0000006', 2, 1),
(11, 'OR-2022-0000007', 4, 3),
(12, 'OR-2022-0000008', 4, 1),
(13, 'OR-2022-0000009', 4, 1),
(14, 'OR-2022-0000010', 5, 2),
(15, 'OR-2022-0000011', 5, 1),
(16, 'OR-2022-0000012', 5, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `gambar`
--

CREATE TABLE `gambar` (
  `idgambar` int(11) NOT NULL,
  `produk` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `gambar`
--

INSERT INTO `gambar` (`idgambar`, `produk`, `gambar`) VALUES
(1, 1, '16Tt4pPV6QwSA.jpeg'),
(2, 1, '16QTfOjLeZmLM.jpg'),
(3, 2, '9afef887d65d19fb5cb66acf88258587.jpg'),
(4, 2, 'c29bbe3fff9f984168b37dfeda277a34.jpg'),
(5, 3, 'aeddcccbc2c93bea96deace4b579a97a.png'),
(6, 3, 'eb1d9dcd47dc23d35ac20b3623b9d349.jpg'),
(8, 4, '3f0e70cdd0312cc0763b51adf1160011.jpg'),
(9, 4, 'e9a3e66a4bc423e1fb47d0d92f962d0a.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int(11) NOT NULL,
  `namakategori` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`) VALUES
(1, 'Kripik'),
(2, 'Kue Kering');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konfirmasi`
--

CREATE TABLE `konfirmasi` (
  `idkonfirmasi` int(11) NOT NULL,
  `orderid` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `payment` varchar(10) NOT NULL,
  `namarekening` varchar(25) NOT NULL,
  `tglbayar` date NOT NULL,
  `bukti` varchar(100) NOT NULL,
  `tglsubmit` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `konfirmasi`
--

INSERT INTO `konfirmasi` (`idkonfirmasi`, `orderid`, `userid`, `payment`, `namarekening`, `tglbayar`, `bukti`, `tglsubmit`) VALUES
(4, 'OR-2022-0000001', 2, 'Bank BRI', 'Andy', '2022-07-23', '1f93fda7-ee7b-4f6f-a798-1ad7c5a2b985.jfif', '2022-07-23 04:42:54'),
(5, 'OR-2022-0000002', 4, 'Bank BSI', 'kurnia', '2022-07-23', '0_3e8f94a4-c699-457c-b1bf-5163605f4cca_540_666.jpg', '2022-07-23 04:43:42'),
(6, 'OR-2022-0000003', 5, 'Dana', 'setiawan', '2022-07-23', '1b11d52e-1a83-4344-a259-5ef416a89557.jfif', '2022-07-23 04:44:23'),
(7, 'OR-2022-0000004', 2, 'Bank BRI', 'andy', '2022-07-23', '0_3e8f94a4-c699-457c-b1bf-5163605f4cca_540_666.jpg', '2022-07-23 04:49:20'),
(8, 'OR-2022-0000005', 4, 'Bank BSI', 'Kurnia', '2022-07-23', '0_3e8f94a4-c699-457c-b1bf-5163605f4cca_540_666.jpg', '2022-07-23 04:50:58'),
(9, 'OR-2022-0000006', 5, 'Dana', 'Setiawan', '2022-07-23', '4b871b3c-f1bb-4685-af47-0096b13af970.jfif', '2022-07-23 04:52:27'),
(10, 'OR-2022-0000007', 2, 'Bank BRI', 'Andy', '2022-07-23', '1772e3ba-aea8-426c-9408-fbc5676471b9 (1).jfif', '2022-07-23 04:55:36'),
(11, 'OR-2022-0000008', 4, 'Bank BSI', 'Kurnia ', '2022-07-23', '916f0d3e-8a5f-4528-b4c6-f71c7dc09136.jfif', '2022-07-23 04:56:27'),
(12, 'OR-2022-0000009', 5, 'Dana', 'Setiawan', '2022-07-23', '611d1ad2-e62e-40e3-8a72-1c08c69d7f12.jfif', '2022-07-23 04:57:11'),
(13, 'OR-2022-0000010', 2, 'Bank BRI', 'Andy', '2022-07-23', '611d1ad2-e62e-40e3-8a72-1c08c69d7f12.jfif', '2022-07-23 04:59:08'),
(14, 'OR-2022-0000011', 4, 'Bank BSI', 'Kurnia', '2022-07-23', '1b11d52e-1a83-4344-a259-5ef416a89557.jfif', '2022-07-23 05:00:09'),
(15, 'OR-2022-0000012', 5, 'Dana', 'Setiawan', '2022-07-23', '4b871b3c-f1bb-4685-af47-0096b13af970 (1).jfif', '2022-07-23 05:01:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `kriteria_id` int(11) NOT NULL,
  `kriteria` varchar(100) NOT NULL,
  `bobot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`kriteria_id`, `kriteria`, `bobot`) VALUES
(1, 'penjualan', 20),
(2, 'rasa', 50),
(3, 'harga', 30);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `userid` int(11) NOT NULL,
  `namalengkap` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `tgljoin` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(7) NOT NULL DEFAULT 'Member',
  `lastlogin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`userid`, `namalengkap`, `email`, `password`, `notelp`, `alamat`, `tgljoin`, `role`, `lastlogin`) VALUES
(1, 'Administrator', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', '01234567890', 'Indonesia', '2020-03-16 11:31:17', 'Admin', NULL),
(2, 'Andy', 'user@gmail.com', '202cb962ac59075b964b07152d234b70', '01234567890', 'Indonesia', '2020-03-16 11:30:40', 'Member', NULL),
(4, 'Kurnia', 'user1@gmail.com', '202cb962ac59075b964b07152d234b70', '0929183188138', 'Indonesia', '2022-07-23 04:41:38', 'Member', NULL),
(5, 'Setiawan', 'user2@gmail.com', '202cb962ac59075b964b07152d234b70', '9302143084082', 'Indonesia', '2022-07-23 04:42:00', 'Member', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `no` int(11) NOT NULL,
  `metode` varchar(25) NOT NULL,
  `norek` varchar(25) NOT NULL,
  `an` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`no`, `metode`, `norek`, `an`) VALUES
(1, 'Bank BRI', '765601006978538', 'Yudi Setyawan'),
(2, 'Bank BSI', '7172985477', 'Yudi Setyawan'),
(5, 'Dana', '082382000703', 'Yudi Setyawan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `penilaian_id` int(11) NOT NULL,
  `penilaian_produk` int(11) NOT NULL,
  `penilaian_trs` varchar(30) NOT NULL,
  `penilaian_harga` varchar(30) NOT NULL,
  `penilaian_rasa` varchar(30) NOT NULL,
  `penilaian` double NOT NULL,
  `penilaian_waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`penilaian_id`, `penilaian_produk`, `penilaian_trs`, `penilaian_harga`, `penilaian_rasa`, `penilaian`, `penilaian_waktu`) VALUES
(1, 1, '0.60-0.12', '0.60-0.18', '0.80-0.40', 0.7, '2022-07-24 14:23:25'),
(2, 2, '0.80-0.16', '0.27-0.08', '0.73-0.37', 0.61, '2022-07-24 14:23:25'),
(3, 4, '1.00-0.20', '0.80-0.24', '0.87-0.43', 0.87, '2022-07-24 14:23:25'),
(4, 5, '0.80-0.16', '1.00-0.30', '1.00-0.50', 0.96, '2022-07-24 14:23:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `idkategori` int(11) NOT NULL,
  `namaproduk` varchar(254) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `n_rasa` int(11) NOT NULL,
  `n_porsi` int(11) NOT NULL,
  `n_harga` int(11) NOT NULL,
  `tgldibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`idproduk`, `idkategori`, `namaproduk`, `gambar`, `deskripsi`, `harga`, `stok`, `n_rasa`, `n_porsi`, `n_harga`, `tgldibuat`) VALUES
(1, 2, 'Donat', '40b48e9c88d82ff4fb222d08cc82648f.jfif', 'Donat yang memiliki rasa yang bercampur dengan gurihnya kentang', 20000, 72, 90, 70, 80, '2022-06-16 16:21:13'),
(2, 2, 'Nastar ', 'b253e0c7fa836c6e1ec2487d04f5a1d9.jpg', 'Nastar yang didalamnya berisi nanas pilihan yang berasa manis dimulut', 45000, 45, 70, 95, 78, '2022-06-16 16:26:46'),
(4, 1, 'Kripik Singkong ', 'ae9800d5de9c9ec0322284e6f51c138e.jpeg', 'Kripik singkong renyah dan sehat.\r\nHarga yang tertera dalam satuan Kg', 15000, 85, 90, 86, 98, '2022-06-16 16:32:57'),
(5, 1, 'Cimi-Cimi', '506d156d6718e372f6f8ae6e51c2a5b3.jpg', 'Gurih', 12000, 46, 90, 50, 90, '2022-07-23 04:37:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(11) NOT NULL,
  `rating_detailorder` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `rating_waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rating`
--

INSERT INTO `rating` (`rating_id`, `rating_detailorder`, `rating`, `rating_waktu`) VALUES
(4, 5, 4, '2022-07-23 11:45:28'),
(5, 6, 4, '2022-07-23 11:45:49'),
(6, 7, 4, '2022-07-23 11:46:16'),
(7, 8, 5, '2022-07-23 11:50:04'),
(8, 9, 3, '2022-07-23 11:51:39'),
(9, 10, 3, '2022-07-23 11:53:08'),
(10, 11, 5, '2022-07-23 11:58:10'),
(11, 12, 4, '2022-07-23 11:59:32'),
(12, 13, 4, '2022-07-23 12:00:35'),
(13, 14, 5, '2022-07-23 12:02:56'),
(14, 15, 5, '2022-07-23 12:03:13'),
(15, 16, 5, '2022-07-23 12:03:31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`idcart`),
  ADD UNIQUE KEY `orderid` (`orderid`),
  ADD KEY `orderid_2` (`orderid`);

--
-- Indeks untuk tabel `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id_config`);

--
-- Indeks untuk tabel `detailorder`
--
ALTER TABLE `detailorder`
  ADD PRIMARY KEY (`detailid`),
  ADD KEY `orderid` (`orderid`),
  ADD KEY `idproduk` (`idproduk`);

--
-- Indeks untuk tabel `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`idgambar`),
  ADD KEY `produk` (`produk`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indeks untuk tabel `konfirmasi`
--
ALTER TABLE `konfirmasi`
  ADD PRIMARY KEY (`idkonfirmasi`),
  ADD KEY `userid` (`userid`),
  ADD KEY `orderid` (`orderid`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`kriteria_id`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`userid`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`penilaian_id`),
  ADD KEY `penilaian_produk` (`penilaian_produk`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`),
  ADD KEY `idkategori` (`idkategori`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `rating_detailorder` (`rating_detailorder`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `idcart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `config`
--
ALTER TABLE `config`
  MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `detailorder`
--
ALTER TABLE `detailorder`
  MODIFY `detailid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `gambar`
--
ALTER TABLE `gambar`
  MODIFY `idgambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `konfirmasi`
--
ALTER TABLE `konfirmasi`
  MODIFY `idkonfirmasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `kriteria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `penilaian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detailorder`
--
ALTER TABLE `detailorder`
  ADD CONSTRAINT `idproduk` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`idproduk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderid` FOREIGN KEY (`orderid`) REFERENCES `cart` (`orderid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `konfirmasi`
--
ALTER TABLE `konfirmasi`
  ADD CONSTRAINT `konfirmasi_ibfk_1` FOREIGN KEY (`orderid`) REFERENCES `cart` (`orderid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userid` FOREIGN KEY (`userid`) REFERENCES `login` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`penilaian_produk`) REFERENCES `produk` (`idproduk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `idkategori` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`rating_detailorder`) REFERENCES `detailorder` (`detailid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
