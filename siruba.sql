-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jun 2025 pada 04.37
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
-- Database: `siruba`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `administrator`
--

CREATE TABLE `administrator` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT 'default-admin.png',
  `level` enum('superadmin','admin') DEFAULT 'admin',
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `administrator`
--

INSERT INTO `administrator` (`id_admin`, `nama_admin`, `email`, `username`, `password`, `foto_profil`, `level`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin Ganteng', 'admin@gmail.com', 'admin', '$2y$12$ySZu6KY8Cujt9FPdipvgmOmLfswss4rsM4Omf/LMinh/xI2qWpcxK', 'default-avatar.png', 'admin', 'aktif', '2025-06-26 00:03:08', '2025-06-26 00:03:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `npm` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT 'default.png',
  `status` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nama_lengkap`, `slug`, `npm`, `email`, `password`, `nomor_telepon`, `alamat`, `foto_profil`, `status`, `created_at`, `updated_at`) VALUES
(10, 'Budi Hartono', 'budi-hartono', '210101005', 'budi@example.com', '$2y$12$GVeyyJpdfETXV06fP8.Qaum0lJ9uYjK7ouHC/oEM8wkB1Ug8CYKwW', '081234567894', 'Jl. Anggrek No. 21, Gunungkidul', '1750877940_50fbf9f79956d72a3857.png', 'Aktif', '2025-06-24 11:21:06', '2025-06-25 18:59:00'),
(26, 'Budiman', 'budiman', '2213025000', 'bebas@gmail.com', '$2y$12$sxD6Xt6gac9wH.zKE0gIa.S7qwsTwtLRLa3.9kN.JQVapxJoxCLZ2', '088747378869', 'Kampung Baru Kec. Rajabasa Kota Bandar Lampung\r\nBlok G Batumarta II', '1750870685_8cc7c038d2cb25d28efc.jpg', 'Aktif', '2025-06-25 16:57:48', '2025-06-25 16:58:05'),
(27, 'Andricha Dea Mitra', 'andricha-dea-mitra', '2213025061', 'andrichadhea@gmail.com', '$2y$12$OwqzOACHywcn544FYXr1wOIOO/hxZjfoHCm8kMWACekAPv6taM33i', '088747378869', 'Kampung Baru Kec. Rajabasa Kota Bandar Lampung\r\nBlok G Batumarta II', '1750872700_f94bb1d220849970c6b4.jpg', 'Aktif', '2025-06-25 17:31:18', '2025-06-25 17:31:40'),
(28, 'Jeremia Adi Pratama', 'jeremia-adi-pratama', '2213025039', 'jeje@gmail.com', '$2y$12$xEwJq6rg75kn3Wgmfy8nQeuMf9XP9pl/qDJUOQURGr0GZx60WXnM.', '088747378869', 'Kampung Baru Kec. Rajabasa Kota Bandar Lampung\r\nBlok G Batumarta II', 'default-avatar.png', 'Aktif', '2025-06-27 02:34:46', '2025-06-27 02:34:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `penulis` varchar(150) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar_sampul` varchar(255) DEFAULT 'default.jpg',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul_buku`, `slug`, `penulis`, `kategori`, `deskripsi`, `gambar_sampul`, `created_at`, `updated_at`) VALUES
(1, 'Laskar Pelangi', 'laskar-pelangi', 'Andrea Hirata', 'Novel', 'Novel yang menceritakan kisah kehidupan 10 anak dari keluarga miskin yang bersekolah di sebuah sekolah Muhammadiyah di Belitung.', 'laskar_pelangi.jpg', '2025-06-21 22:42:27', '2025-06-23 15:58:40'),
(2, 'Bumi Manusia', 'bumi-manusia', 'Pramoedya Ananta Toer', 'Roman Sejarah', 'Buku pertama dari Tetralogi Buru yang menceritakan kisah Minke, seorang priyayi Jawa pada masa Hindia Belanda.', 'bumi_manusia.jpg', '2025-06-21 22:42:27', '2025-06-21 22:42:27'),
(13, 'A Tale of Two Cities', 'a-tale-of-two-cities', 'Charles Dickens', 'Fiksi Sejarah', 'Latar Revolusi Prancis, mengisahkan pengorbanan dan cinta lintas kelas sosial.', '1750950813_8dfeec2b7708b723e608.jpg', '2025-06-26 21:11:49', '2025-06-26 15:13:33'),
(14, 'The Little Prince', 'the-little-prince', 'Antoine de Saint-Exupéry', 'Fiksi Anak', 'Petualangan pangeran kecil dari asteroid B‑612, penuh filosofi kehidupan.', '1750950772_a89981a2b0a7e8ec7b62.jpg', '2025-06-26 21:11:49', '2025-06-26 15:12:52'),
(15, 'The Alchemist', 'the-alchemist', 'Paulo Coelho', 'Fiksi Spiritual', 'Perjalanan Santiago mengikuti mimpinya dan belajar arti pribadi legenda.', '1750950736_4225eda4b6bb9204416b.jpeg', '2025-06-26 21:11:49', '2025-06-26 15:12:16'),
(16, 'Harry Potter and the Philosopher\'s Stone', 'harry-potter-and-the-philosophers-stone', 'J.K. Rowling', 'Fantasi', 'Awal kisah petualangan penyihir muda di Hogwarts.', '1750950707_89c8215f52221dac1341.png', '2025-06-26 21:11:49', '2025-06-26 15:11:47'),
(17, 'And Then There Were None', 'and-then-there-were-none', 'Agatha Christie', 'Misteri', 'Sepuluh orang diundang ke pulau terpencil dan dibunuh satu per satu.', '1750950676_f0de53be5140ff0703dd.jpg', '2025-06-26 21:11:49', '2025-06-26 15:11:16'),
(18, 'Dream of the Red Chamber', 'dream-of-the-red-chamber', 'Cao Xueqin', 'Saga Keluarga', 'Novel klasik Cina tentang cinta dan kehancuran keluarga bangsawan.', '1750950650_b0e49bce3338ab72d003.jpg', '2025-06-26 21:11:49', '2025-06-26 15:10:50'),
(19, 'The Hobbit', 'the-hobbit', 'J.R.R. Tolkien', 'Fantasi', 'Perjalanan Bilbo Baggins bersama kurcaci dan bertemu Smaug.', '1750950623_23b1f8290eb162b8bc26.jpg', '2025-06-26 21:11:49', '2025-06-26 15:10:23'),
(20, 'Alice\'s Adventures in Wonderland', 'alices-adventures-in-wonderland', 'Lewis Carroll', 'Fantasi Anak', 'Petualangan sureal Alice di dunia penuh keanehan bawah tanah.', '1750948691_a585e57bc08c328261c6.jpg', '2025-06-26 21:11:49', '2025-06-26 14:38:11'),
(21, 'Don Quixote', 'don-quixote', 'Miguel de Cervantes', 'Fiksi Klasik', 'Kesatria ngaco yang percaya dunia butuh petualangannya.', '1750950596_7da0e5e48c9289681e68.jpg', '2025-06-26 21:11:49', '2025-06-26 15:09:56'),
(22, 'Pride and Prejudice', 'pride-and-prejudice', 'Jane Austen', 'Romantis Klasik', 'Elisabeth Bennet dan Mr. Darcy dalam kisah cinta lintas kelas.', '1750950576_a5422204b5df07c2d9ca.jpg', '2025-06-26 21:11:49', '2025-06-26 15:09:36'),
(23, 'Moby-Dick', 'moby-dick', 'Herman Melville', 'Petualangan', 'Perburuan paus putih oleh Kapten Ahab yang dendam.', '1750950555_868f6bbb4e8e220eaf0e.jpg', '2025-06-26 21:11:49', '2025-06-26 15:09:15'),
(24, 'The Brothers Karamazov', 'the-brothers-karamazov', 'Fyodor Dostoevsky', 'Filsafat', 'Konflik keluarga, moral, dan iman dalam keluarga Karamazov.', '1750950529_82dd18669b7ddfb1021a.jpg', '2025-06-26 21:11:49', '2025-06-26 15:08:49'),
(25, 'Lolita', 'lolita', 'Vladimir Nabokov', 'Kontroversial', 'Obsesi terlarang seorang pria terhadap anak perempuan, dikemas dengan prosa tajam.', '1750950507_c7131abc38e0693d248d.jpg', '2025-06-26 21:11:49', '2025-06-26 15:08:27'),
(26, 'Crime and Punishment', 'crime-and-punishment', 'Fyodor Dostoevsky', 'Psikologis', 'Rasa bersalah dan moralitas setelah pembunuhan Alm. Žerkov.', '1750950488_bfbe4d8a517c6718371f.jpg', '2025-06-26 21:11:49', '2025-06-26 15:08:08'),
(27, 'Ulysses', 'ulysses', 'James Joyce', 'Modernisme', 'Satu hari dalam hidup Leopold Bloom di Dublin penuh alusi dan arketipe.', '1750950467_b5bae316ffe16ca2be65.jpg', '2025-06-26 21:11:49', '2025-06-26 15:07:47'),
(28, 'The Great Gatsby', 'the-great-gatsby', 'F. Scott Fitzgerald', 'Modernisme', 'Kisah cinta dan ambisi era Jazz Age Amerika.', '1750950449_c5fef2b322cfaec9283a.jpg', '2025-06-26 21:11:49', '2025-06-26 15:07:29'),
(29, 'One Hundred Years of Solitude', 'one-hundred-years-of-solitude', 'Gabriel García Márquez', 'Magical Realism', 'Sejarah tujuh generasi keluarga Buendía di Macondo.', '1750950427_f4ca69d0667510a46405.jpg', '2025-06-26 21:11:49', '2025-06-26 15:07:07'),
(30, 'War and Peace', 'war-and-peace', 'Leo Tolstoy', 'Sejarah Fiksi', 'Revolusi Napoleon dan dampaknya pada keluarga bangsawan Rusia.', '1750950391_5c598ba5bc281530b54f.jpg', '2025-06-26 21:11:49', '2025-06-26 15:06:31'),
(31, 'To Kill a Mockingbird', 'to-kill-a-mockingbird', 'Harper Lee', 'Bildungsroman', 'Melawan rasisme melalui sudut pandang Scout Finch di Alabama.', '1750950370_dca07e2220a628627e0f.jpg', '2025-06-26 21:11:49', '2025-06-26 15:06:10'),
(32, 'The Catcher in the Rye', 'the-catcher-in-the-rye', 'J.D. Salinger', 'Coming‑of‑Age', 'Perjalanan pemberontakan remaja Holden Caulfield di New York.', '1750950346_5313ce77105c913a1f3b.jpg', '2025-06-26 21:11:49', '2025-06-26 15:05:46'),
(33, 'The Old Man and the Sea', 'the-old-man-and-the-sea', 'Ernest Hemingway', 'Fiksi', 'Pertarungan epik nelayan tua Santiago dengan ikan marlin.', '1750950322_cdf601baea9338ba6a72.jpg', '2025-06-26 21:11:49', '2025-06-26 15:05:22'),
(34, 'Brave New World', 'brave-new-world', 'Aldous Huxley', 'Dystopian', 'Masa depan teknologi pengendalian sosial dan rekayasa manusia.', '1750950251_ca3ec67afcb8a00e0306.jpeg', '2025-06-26 21:11:49', '2025-06-26 15:04:11'),
(35, 'The Odyssey', 'the-odyssey', 'Homer', 'Epik Klasik', 'Perjalanan panjang Odysseus kembali ke Ithaca setelah Troya.', '1750950225_f091c94d9ccea23e1909.jpeg', '2025-06-26 21:11:49', '2025-06-26 15:03:45'),
(36, 'Don Quixote', 'don-quixote-1', 'Miguel de Cervantes', 'Fiksi Klasik', '(Duplikat saja; jika butuh lain bisa diganti.)', '1750950198_e1f6221aa5fdc076f114.jpg', '2025-06-26 21:11:49', '2025-06-26 15:03:18'),
(37, 'The Picture of Dorian Gray', 'the-picture-of-dorian-gray', 'Oscar Wilde', 'Fantasi Gothic', 'Pemuda yang abadi muda sementara potret menua.', '1750950154_7c5506f8195ec3390538.jpeg', '2025-06-26 21:11:49', '2025-06-26 15:02:34'),
(38, 'Anna Karenina', 'anna-karenina', 'Leo Tolstoy', 'Romantis', 'Tragedi cinta di masyarakat Rusia abad ke-19.', '1750950118_78901be0213dc40a6e7a.jpg', '2025-06-26 21:11:49', '2025-06-26 15:01:58'),
(39, 'Dracula', 'dracula', 'Bram Stoker', 'Horror', 'Komunikasi jurnal dan perburuan vampir legendaris.', '1750950096_9c54fbb7323de9298163.jpg', '2025-06-26 21:11:49', '2025-06-26 15:01:36'),
(40, 'Frankenstein', 'frankenstein', 'Mary Shelley', 'Horror', 'Ilmuwan yang menciptakan makhluk hidup, lalu menyesal.', '1750950075_76eb9a8491399eb223fb.jpg', '2025-06-26 21:11:49', '2025-06-26 15:01:15'),
(41, 'Sense and Sensibility', 'sense-and-sensibility', 'Jane Austen', 'Romantis', 'Dua saudari Dashwood dan suka-duka percintaan era Regency.', '1750950043_114ec86b9ad51129d9f8.jpeg', '2025-06-26 21:11:49', '2025-06-26 15:00:43'),
(42, 'Great Expectations', 'great-expectations', 'Charles Dickens', 'Bildungsroman', 'Perjalanan Pip dari miskin ke sosialita dan kembali.', '1750950022_3d8dc28367289add202d.jpg', '2025-06-26 21:11:49', '2025-06-26 15:00:22'),
(43, 'The Stranger', 'the-stranger', 'Albert Camus', 'Eksistensialisme', 'Kematian, alienasi, dan absurditas melalui Meursault.', '1750950971_8a21194cf0b098eb40c6.png', '2025-06-26 21:11:49', '2025-06-26 15:16:11'),
(44, 'Heart of Darkness', 'heart-of-darkness', 'Joseph Conrad', 'Petualangan', 'Kegelapan kolonialisme dalam perjalanan di sungai Kongo.', '1750949939_39c7b90ecca0caa99169.jpg', '2025-06-26 21:11:49', '2025-06-26 14:58:59'),
(45, 'The Divine Comedy', 'the-divine-comedy', 'Dante Alighieri', 'Epik', 'Safar imajiner melalui Neraka, Purgatorium, dan Surga.', '1750949911_bb3915209480c9f46369.jpg', '2025-06-26 21:11:49', '2025-06-26 14:58:31'),
(46, 'Pale Fire', 'pale-fire', 'Vladimir Nabokov', 'Postmodern', 'Puisi fiktif dan komentar aneh membentuk teka-teki psikologis.', '1750949879_408695920c3c908d496d.jpg', '2025-06-26 21:11:49', '2025-06-26 14:57:59'),
(47, 'Catch-22', 'catch-22', 'Joseph Heller', 'Satire', 'Absurd birokrasi militer Perang Dunia II.—istilah \"Catch-22\"!', '1750949832_d462c6c7bdf0ecba9b0c.jpg', '2025-06-26 21:11:49', '2025-06-26 14:57:12'),
(48, 'Invisible Man', 'invisible-man', 'Ralph Ellison', 'Fiksi Eksperimental', 'Eksperimen sosial ras dan identitas Afrika‑Amerika.', '1750949757_0dc167e52a8e21d7783b.jpeg', '2025-06-26 21:11:49', '2025-06-26 14:55:57'),
(49, 'Slaughterhouse-Five', 'slaughterhouse-five', 'Kurt Vonnegut', 'Sci‑Fi Satire', 'Perang, waktu non-linear, dan pengalaman Dresden.', '1750949737_7b7ebcbba5218eb774cf.jpg', '2025-06-26 21:11:49', '2025-06-26 14:55:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_pengembalian` date DEFAULT NULL,
  `status` enum('Sedang Dipinjam','Telah Dikembalikan','Terlambat') NOT NULL DEFAULT 'Sedang Dipinjam',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_anggota`, `id_buku`, `tanggal_pinjam`, `tanggal_pengembalian`, `status`, `created_at`, `updated_at`) VALUES
(9, 10, 1, '2025-06-19', '2025-06-28', 'Telah Dikembalikan', '2025-06-24 18:03:46', '2025-06-24 11:26:51'),
(34, 27, 1, '2025-06-25', '2025-06-26', 'Telah Dikembalikan', '2025-06-25 17:55:51', '2025-06-25 18:13:34'),
(35, 26, 1, '2025-06-25', '2025-06-28', 'Telah Dikembalikan', '2025-06-25 17:56:52', '2025-06-25 18:00:24'),
(36, 27, 1, '2025-06-25', '2025-06-28', 'Telah Dikembalikan', '2025-06-25 18:13:45', '2025-06-25 18:45:52'),
(38, 27, 2, '2025-06-26', '2025-06-27', 'Telah Dikembalikan', '2025-06-26 02:09:58', '2025-06-26 02:13:30'),
(39, 27, 2, '2025-06-26', '2025-06-25', 'Telah Dikembalikan', '2025-06-26 02:13:50', '2025-06-26 02:25:02'),
(40, 27, 1, '2025-06-26', '2025-06-25', 'Telah Dikembalikan', '2025-06-26 02:17:12', '2025-06-26 02:21:22'),
(44, 27, 19, '2025-06-26', '2025-06-26', 'Telah Dikembalikan', '2025-06-26 15:55:07', '2025-06-26 15:55:52'),
(45, 27, 14, '2025-06-26', '2025-06-24', 'Telah Dikembalikan', '2025-06-26 15:57:16', '2025-06-26 16:02:05'),
(46, 27, 14, '2025-06-26', '2025-06-28', 'Telah Dikembalikan', '2025-06-26 16:06:34', '2025-06-26 16:06:41'),
(47, 28, 13, '2025-06-27', '2025-06-28', 'Telah Dikembalikan', '2025-06-27 02:35:30', '2025-06-27 02:36:02'),
(48, 28, 19, '2025-06-27', '2025-06-30', 'Sedang Dipinjam', '2025-06-27 02:35:38', '2025-06-27 02:35:38'),
(49, 28, 21, '2025-06-27', '2025-06-25', 'Terlambat', '2025-06-27 02:35:48', '2025-06-27 02:35:48');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `npm` (`npm`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `peminjaman_ibfk_1` (`id_anggota`),
  ADD KEY `peminjaman_ibfk_2` (`id_buku`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
