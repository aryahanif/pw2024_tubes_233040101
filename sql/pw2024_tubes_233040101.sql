-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 10, 2024 at 08:18 PM
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
-- Database: `pw2024_tubes_233040101`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `deskripsi`, `penerbit`, `kategori`, `gambar`) VALUES
(1, 'Osong Kongkong', 'wu9qbiosdbaifbdiosbofywqbebfzkhb', 'wiufbsdbajifbooyasbeiubwqiofbdj', 'Comic', 'fiverr.png'),
(3, 'asasaaawkowakodaod', 'oiwvoinosxnocnqoindoi', '2oeifnocncoin2oisnaondoiqn', 'Novel', 'IMG_20231214_202758.jpg'),
(4, 'spianscokancponqwoinqocinas', 'owqnscipnpsiancoiqwnlknweoivdnoqen', 'oiencpsncl;kas', 'Religion', 'WhatsApp Image 2024-01-06 at 13.57.11_75e47946.jpg'),
(5, 'pi3f1enslkancliqnsiocnaocqljsn', 'w1dpinslk lanidwnqslk adlqs odwq oi', '1iwnlnaocfquenoidnqwoisn', 'Novel', 'IMG_20231214_202758.jpg'),
(9, 'Ahmad', 'Ahmad', 'Ahmad', 'Novel', 'Screenshot 2023-12-06 201815.png');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `role`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_role` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `id_role`) VALUES
(6, 'Coki', 'cocote@gmail.com', '$2y$10$TGZlLbu.TJpplVv3hgRnTOeZtchwNYJlTSsbIetSNn1ziqyxK5SbS', 2),
(9, 'admin', 'admin@gmail.com', '$2y$10$zvaPqYrSZo.h/89hRYP/7.SQniJ8dNp7UoAoKpAxt1fQBC7th2u4S', 1),
(10, 'Ustad', 'ahmad@unpas.ac.id', '$2y$10$kqYl3MZ/tEP7RQl2XXxao.BzoxxvYSVL5tjli4ASt3eH0nR8DKkK6', 2),
(12, 'User', 'user@gmail.com', '$2y$10$6.AIg1GamTeumYDiohmTJ.FzG65oMLm/AxWbZ0QDKKk5bGmJj5c92', 2),
(13, 'Ikan', 'ikan@gmail.com', '$2y$10$aVTQ/hJjTBg850/h1x4nP.SacHdQqKlZMu.4liJrje2JL/yA4XDkK', 2),
(14, 'Hiu', 'hiu@gmail.com', '$2y$10$h2LQhPfT96UIxHTvDHeLNeaHzIO3ieCbjw8767XMFBICF.60sd1jy', 1),
(15, 'Ayam', 'ayam@gmail.com', '$2y$10$Ib7oImWjb2AUiNMklY/CpOg6VCiBkqb5xyRCuSZW6AQez1lvB2GT.', 2),
(16, 'Kangkung', 'kangkung@gmail.com', '$2y$10$lH8EUEmbJ5D9MpJJ72/bu.Bh4fU5B6cVmRYn.TOoFsitPdFIz7Qg6', 2),
(17, 'Bayam', 'bayam@gmail.com', '$2y$10$pCGV3gMrmiaZ7yJ/VeWwx.UawSi/VbLGuEPyXPK0tKLpK9IMz/.aC', 2),
(18, 'Sawi', 'sawi@gmail.com', '$2y$10$qtvJKUS7qgIHVl34Svmquu9qCD7kvWzRD9vSkgkv3xGdY821L16Uu', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
