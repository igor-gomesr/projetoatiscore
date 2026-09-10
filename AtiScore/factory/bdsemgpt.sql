-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/08/2026 às 19:40
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdatiscore`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `questionarios`
--

CREATE TABLE `questionarios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data_resposta` datetime DEFAULT current_timestamp(),
  `diasinstenso` int(11) NOT NULL CHECK (`diasinstenso` between 0 and 7),
  `minutosinstenso` int(11) NOT NULL CHECK (`minutosinstenso` between 0 and 1440),
  `diasmoderada` int(11) NOT NULL CHECK (`diasmoderada` between 0 and 7),
  `minutosmoderada` int(11) NOT NULL CHECK (`minutosmoderada` between 0 and 1440),
  `diascaminhada` int(11) NOT NULL CHECK (`diascaminhada` between 0 and 7),
  `minutoscaminhada` int(11) NOT NULL CHECK (`minutoscaminhada` between 0 and 1440),
  `minutossentado` int(11) NOT NULL CHECK (`minutossentado` between 0 and 1440),
  `metcaminhada` int(11) DEFAULT 0,
  `metmoderada` int(11) DEFAULT 0,
  `metintenso` int(11) DEFAULT 0,
  `mettotal` int(11) DEFAULT 0,
  `nivel` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `idade` int(11) DEFAULT NULL,
  `peso` decimal(5,1) DEFAULT NULL,
  `altura` decimal(5,1) DEFAULT NULL,
  `sexo` enum('masculino','feminino') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `questionarios`
--
ALTER TABLE `questionarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `questionarios`
--
ALTER TABLE `questionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `questionarios`
--
ALTER TABLE `questionarios`
  ADD CONSTRAINT `questionarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
