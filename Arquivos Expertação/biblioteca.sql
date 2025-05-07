-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2025 at 12:52 PM
-- Server version: 8.0.41-0ubuntu0.24.04.1
-- PHP Version: 8.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biblioteca`
--
CREATE DATABASE IF NOT EXISTS `cdsconsu_biblioteca` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `cdsconsu_biblioteca`;

-- --------------------------------------------------------

--
-- Table structure for table `livros`
--

DROP TABLE IF EXISTS `livros`;
CREATE TABLE `livros` (
  `id_livro` int NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `estilo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `livros`
--

INSERT IGNORE INTO `livros` (`id_livro`, `nome`, `autor`, `peso`, `estilo`) VALUES
(8, 'O Diário de um Mago', 'Paulo Coelho', 2.00, 'ocultismo');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `data_nascimento` date NOT NULL DEFAULT '2000-01-01',
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `senha` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuarios`
--

INSERT IGNORE INTO `usuarios` (`id`, `nome`, `email`, `telefone`, `data_nascimento`, `data_cadastro`, `senha`, `nickname`) VALUES
(1, 'Administrador do Sistema', 'sysadmin@example.com', NULL, '2000-01-01', '2025-04-29 13:49:31', '$2y$12$78iMnZsPjuFuRwG5.3UFAOVq/WTE4F.IIx5oC1NSRgzkHM50ntMl2', 'sysadmin'),
(2, 'Root User', 'root@example.com', NULL, '2000-01-01', '2025-04-29 13:49:31', '$2y$12$78iMnZsPjuFuRwG5.3UFAOVq/WTE4F.IIx5oC1NSRgzkHM50ntMl2', 'root'),
(3, 'CEZAR DIAS DA SILVA', 'cezardsilva@gmail.com', '2199999999', '1967-01-19', '2025-04-29 14:11:32', '$2y$12$j5r9lGjMoaeoFJHARgdgluuOeKHiOYPylEOHxD/43tk7V6MFkP47K', 'cezar'),
(4, 'Felipe Ferraz Silva', 'felipe.fe.sil@gmail.com', '21990004131', '2003-05-01', '2025-04-29 19:07:56', '$2y$12$yUhvvdtW3PjL97Cz8PjFIe.pmMT.NYvhvyS4y9sIVG6fRHab66YuO', 'felipe'),
(5, 'Morpheus Yukana', 'morpheus666@gmail.com', '2197625006', '1967-01-19', '2025-04-29 21:38:08', '$2y$12$tWUFJ4rEAdhkRgLLTUcsDeOXB3xKri1Z.dJ1ne/TovzizlVtJRlIO', 'morpheus');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id_livro`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `livros`
--
ALTER TABLE `livros`
  MODIFY `id_livro` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
