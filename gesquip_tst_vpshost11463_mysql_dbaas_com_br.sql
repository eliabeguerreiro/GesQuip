-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: gesquip_tst.vpshost11463.mysql.dbaas.com.br
-- Generation Time: 22-Mar-2025 às 12:46
-- Versão do servidor: 5.7.32-35-log
-- PHP Version: 5.6.40-0+deb8u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gesquip`
--
CREATE DATABASE IF NOT EXISTS `gesquip` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `gesquip`;



-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `nm_empresa` varchar(45) NOT NULL,
  `nr_cnpj` varchar(45) NOT NULL,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `familia`
--

CREATE TABLE `familia` (
  `id_familia` int(11) NOT NULL,
  `id_classe` int(11) NOT NULL,
  `ds_familia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `familia`
--

INSERT INTO `familia` (`id_familia`, `id_classe`, `ds_familia`) VALUES
(3, 1, 'ALAVANCA'),
(4, 1, 'CAVADOR ARTICULADO'),
(5, 1, 'CHIBANCA'),
(6, 1, 'CISCADOR'),
(8, 1, 'ENXADA'),
(9, 1, 'MARRETA'),
(14, 1, 'PÁ'),
(17, 1, 'PARAFUSADEIRA'),
(18, 1, 'PÉ DE CABRA'),
(19, 1, 'VASSOURA'),
(20, 1, 'SERRA'),
(21, 1, 'CHAVE'),
(32, 1, 'FERRO DE COVA'),
(33, 2, 'ESMERILHADEIRA'),
(35, 2, 'EXTENÇÃO'),
(37, 1, 'MALETA DE FERRAMENTAS'),
(38, 1, 'MACHADINHA'),
(39, 2, 'FURADEIRA'),
(40, 2, 'LIXADEIRA'),
(41, 2, 'LAVA JATO'),
(42, 2, 'FURADEIRA BOSCH'),
(43, 3, 'ESCADA'),
(44, 2, 'ASPIRADOR'),
(45, 3, 'CARRO DE 2 PNEUS'),
(46, 3, 'CARRO DE MÃO'),
(48, 1, 'PONTEIRO'),
(49, 2, 'POLITRIZ ANGULAR'),
(50, 2, 'POLICORTE'),
(51, 3, 'RISCADEIRA'),
(53, 7, 'SOPRADOR'),
(54, 2, 'REFLETOR'),
(55, 4, 'NIVEL A LASER'),
(56, 2, 'MESA VIBRATÓRIA'),
(57, 3, 'MARTELETE'),
(58, 2, 'MISTURADOR'),
(59, 3, 'PISTOLA'),
(62, 3, 'COMPACTADOR DE PERCUSSAO'),
(63, 5, 'EXAUSTOR ESPACO CONFINADO'),
(64, 2, 'SERRA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id_fornecedor` int(11) NOT NULL,
  `nm_fantasia` varchar(100) NOT NULL,
  `rz_social` varchar(100) NOT NULL,
  `cd_cnpj` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE `item` (
  `id_item` int(11) NOT NULL,
  `id_familia` int(10) UNSIGNED DEFAULT NULL,
  `ds_item` varchar(200) NOT NULL,
  `nr_disponibilidade` int(11) NOT NULL DEFAULT '1',
  `dt_cad` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `natureza` varchar(45) NOT NULL DEFAULT 'local',
  `nv_permissao` int(11) NOT NULL,
  `cod_patrimonio` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`id_item`, `id_familia`, `ds_item`, `nr_disponibilidade`, `dt_cad`, `natureza`, `nv_permissao`, `cod_patrimonio`) VALUES
(4, 3, 'teste', 2, '2025-01-08 13:45:57', 'proprio', 2, 'd0ded8'),
(5, 4, 'teste', 1, '2025-01-08 13:46:05', 'proprio', 1, '834969'),
(6, 8, 'tramontina laranjeida', 999999999, '2025-01-08 14:13:58', 'locado', 1, 'c54332'),
(7, 18, 'pretor tramontina', 2, '2025-01-08 14:15:20', 'proprio', 1, '3c8282'),
(8, 9, '1kg ', 1, '2025-01-08 14:16:12', 'locado', 2, 'cce829'),
(9, 5, 'chibanca 1', 1, '2025-01-09 09:22:24', 'proprio', 1, 'e5577d'),
(11, 3, 'alavanca 01', 0, '2025-01-09 09:22:38', 'proprio', 1, 'c7bb86'),
(12, 3, 'alavanca 02', 0, '2025-01-09 09:23:14', 'proprio', 1, '0d803d'),
(13, 4, 'cavador preto', 0, '2025-01-09 11:06:46', 'proprio', 3, '8bd028'),
(14, 6, 'teste', 5, '2025-02-27 14:45:18', 'propio', 2, '42af56'),
(15, 18, 'xpto', 0, '2025-02-27 14:53:11', 'propio', 1, '1c8d3d'),
(17, 3, 'xpto00', 2, '2025-03-14 15:31:50', 'locado', 2, '2a7659');

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_movimentacao`
--

CREATE TABLE `item_movimentacao` (
  `id_item_movimentacao` int(11) NOT NULL,
  `id_movimentacao` int(10) UNSIGNED DEFAULT NULL,
  `id_item` int(10) UNSIGNED DEFAULT NULL,
  `dt_devolucao` datetime DEFAULT NULL,
  `id_autor` int(11) NOT NULL,
  `tipo` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `item_movimentacao`
--

INSERT INTO `item_movimentacao` (`id_item_movimentacao`, `id_movimentacao`, `id_item`, `dt_devolucao`, `id_autor`, `tipo`) VALUES
(1, 1, 15, '2025-03-14 15:09:42', 1, 1),
(2, 1, 14, '2025-03-14 15:10:40', 1, 1),
(3, 1, 13, '2025-03-14 15:10:41', 1, 1),
(4, 1, 12, '2025-03-14 15:10:43', 1, 1),
(5, 1, 11, '2025-03-14 15:10:44', 1, 1),
(6, 1, 9, '2025-03-14 15:10:44', 1, 1),
(7, 1, 8, '2025-03-14 15:10:45', 1, 1),
(8, 1, 7, '2025-03-14 15:10:46', 1, 1),
(9, 1, 6, '2025-03-14 15:10:47', 1, 1),
(10, 1, 5, '2025-03-14 15:10:47', 1, 1),
(11, 1, 4, '2025-03-14 15:10:49', 1, 1),
(12, 2, 17, '2025-03-14 15:38:01', 1, 1),
(13, 2, 15, '2025-03-14 15:38:13', 1, 1),
(14, 2, 14, '2025-03-14 15:38:27', 1, 1),
(15, 3, 17, '2025-03-14 15:42:47', 1, 1),
(16, 3, 15, NULL, 1, 1),
(17, 4, 17, NULL, 1, 1),
(18, 4, 14, '2025-03-14 15:47:54', 1, 1),
(19, 4, 12, NULL, 1, 1),
(20, 6, 13, NULL, 1, 1),
(21, 6, 11, NULL, 1, 1),
(22, 6, 9, '2025-03-17 20:33:27', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `manutencao`
--

CREATE TABLE `manutencao` (
  `id_manutencao` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_item_movimentacao` int(11) NOT NULL,
  `obs_in` varchar(300) NOT NULL,
  `obs_out` varchar(300) DEFAULT NULL,
  `id_autor` int(11) NOT NULL,
  `dt_inicio_manutencao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_fim_manutencao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `manutencao`
--

INSERT INTO `manutencao` (`id_manutencao`, `id_item`, `id_item_movimentacao`, `obs_in`, `obs_out`, `id_autor`, `dt_inicio_manutencao`, `dt_fim_manutencao`) VALUES
(1, 6, 9, 'teste em casa', 'test', 1, '2025-03-17 18:47:38', '2025-03-17 22:23:03'),
(2, 4, 11, 'teste', NULL, 1, '2025-03-17 19:24:08', NULL),
(3, 7, 8, 'teste', NULL, 1, '2025-03-17 19:24:18', NULL),
(4, 17, 17, 'teste', NULL, 1, '2025-03-17 19:26:41', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `id_movimentacao` int(11) NOT NULL,
  `id_itens` varchar(11) DEFAULT NULL,
  `id_empresa` varchar(11) NOT NULL DEFAULT '1',
  `id_responsavel` int(11) NOT NULL,
  `id_autor` varchar(11) NOT NULL,
  `dt_movimentacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_finalizacao` datetime DEFAULT NULL,
  `ds_movimentacao` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `movimentacao`
--

INSERT INTO `movimentacao` (`id_movimentacao`, `id_itens`, `id_empresa`, `id_responsavel`, `id_autor`, `dt_movimentacao`, `dt_finalizacao`, `ds_movimentacao`) VALUES
(1, NULL, '1', 3, '1', '2025-03-14 15:08:20', '2025-03-14 15:10:49', 'Retirada de equipamentos'),
(2, NULL, '1', 7, '1', '2025-03-14 15:36:52', '2025-03-14 15:38:27', 'Retirada de equipamentos'),
(3, NULL, '1', 7, '1', '2025-03-14 15:39:49', NULL, 'Retirada de equipamentos'),
(4, NULL, '1', 1, '1', '2025-03-14 15:45:06', NULL, 'Retirada de equipamentos'),
(5, NULL, '1', 3, '1', '2025-03-14 17:42:48', '2025-03-17 15:42:51', 'teste'),
(6, NULL, '1', 9, '1', '2025-03-17 20:30:14', NULL, 'Retirada de equipamentos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `login` varchar(60) NOT NULL,
  `senha` varchar(300) NOT NULL,
  `nm_usuario` varchar(45) NOT NULL,
  `nr_contato` varchar(45) NOT NULL,
  `id_empresa` varchar(45) NOT NULL,
  `tp_usuario` varchar(45) NOT NULL DEFAULT 'user',
  `nv_permissao` int(11) NOT NULL DEFAULT '0',
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `login`, `senha`, `nm_usuario`, `nr_contato`, `id_empresa`, `tp_usuario`, `nv_permissao`, `dt_cadastro`) VALUES
(1, 'hants', '$2y$10$NS706aAYeNqG6.bB1TBVh.RSbM5PHFj.Gfl5qj.GMidNeWU7qNHrO', 'eliabe paz', '81988668870', '1', 'admin', 3, '2024-12-05 00:00:00'),
(3, 'joao', '$2y$10$NS706aAYeNqG6.bB1TBVh.RSbM5PHFj.Gfl5qj.GMidNeWU7qNHrO', 'joao teste', '81988668870', '1', 'user', 0, '2024-12-18 21:27:49'),
(4, 'teste@teste', '$2y$10$r5Douh1fv7gK2PN5hXKCNO.y0To6rR1JfV8J.cxBkz1LW/itrXk8a', 'testeer', 'teste', '1', 'user', 1, '2025-01-15 14:53:16'),
(5, 'teste2', '$2y$10$Ud5CHMlHSEw5aDNU/HZbcebsI2IJhARQN8LWP6ZsD0WHy3M2BNSrC', 'teste2', 'teste2', '1', 'user', 1, '2025-01-15 15:09:31'),
(7, '', '$2y$10$hEnw3USZeGS9C0AgZTPqLuwDLkhqHEcoCVwu.1zY4qHxpac9/bBRu', 'Marco Aurélio', '123123', '1', 'user', 3, '2025-03-14 15:36:35'),
(8, '', '$2y$10$6eOfvp0Yjk9z7wKbKaUfl.Z608W5BpSYxuo5gxAJUA.ewH9MLz3aC', 'teste', '81900000000', '1', 'user', 3, '2025-03-14 17:30:54'),
(9, '', '$2y$10$TMu86nzEfoj8v1RkS9zH3u7HqGeApt4W/3XeIhtlz7z35iN4E9OZO', 'Marcelo Carlos', '819988909999', '1', 'user', 3, '2025-03-15 09:15:20');


--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indexes for table `familia`
--
ALTER TABLE `familia`
  ADD PRIMARY KEY (`id_familia`);

--
-- Indexes for table `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id_fornecedor`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `item_movimentacao`
--
ALTER TABLE `item_movimentacao`
  ADD PRIMARY KEY (`id_item_movimentacao`),
  ADD KEY `id_item_idx` (`id_item`);

--
-- Indexes for table `manutencao`
--
ALTER TABLE `manutencao`
  ADD PRIMARY KEY (`id_manutencao`);

--
-- Indexes for table `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`id_movimentacao`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);


--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `familia`
--
ALTER TABLE `familia`
  MODIFY `id_familia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `item_movimentacao`
--
ALTER TABLE `item_movimentacao`
  MODIFY `id_item_movimentacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `manutencao`
--
ALTER TABLE `manutencao`
  MODIFY `id_manutencao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
