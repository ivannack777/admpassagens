-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.30-0ubuntu0.20.04.2 - (Ubuntu)
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para passagens
CREATE DATABASE IF NOT EXISTS `passagens` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `passagens`;

-- Copiando estrutura para tabela passagens.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) COLLATE latin1_general_ci NOT NULL DEFAULT (sha2(now(),256)),
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `cpf` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `celular` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `excluido` enum('S','N') COLLATE latin1_general_ci DEFAULT 'N',
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela passagens.clientes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `key`, `nome`, `cpf`, `celular`, `email`, `excluido`, `excluido_data`, `excluido_por`, `data_insert`, `data_update`) VALUES
	(1, '87817a3b2564c88715d37d8257da75b193453261a6d28c19073075bcc4611cd8', 'Ivan', '01803177926', '44999262946', 'ivan100br@yahoo.com.br', 'N', '2022-09-21 22:14:46', 1, '2022-09-14 21:23:41', '2022-09-21 22:48:01');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Copiando estrutura para tabela passagens.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL DEFAULT (sha2(now(),256)),
  `usuarios_id` int NOT NULL,
  `enderecos_id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cnpj` varchar(15) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `logradouro` varchar(100) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `excluido` enum('S','N') DEFAULT 'N',
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`key`),
  KEY `fk_empresas_enderecos` (`enderecos_id`),
  KEY `fk_empresas_usuarios` (`usuarios_id`) USING BTREE,
  CONSTRAINT `fk_empresas_enderecos` FOREIGN KEY (`enderecos_id`) REFERENCES `enderecos` (`id`),
  CONSTRAINT `fk_empresas_usuarios` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela passagens.empresas: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` (`id`, `key`, `usuarios_id`, `enderecos_id`, `nome`, `cnpj`, `cep`, `logradouro`, `numero`, `bairro`, `uf`, `cidade`, `excluido`, `excluido_data`, `excluido_por`, `data_insert`, `data_update`) VALUES
	(1, '5884221fe2db2a54972b7d483988a212c88eaa6acc38b5a0d1dfdcb619e09f2b', 1, 1, 'Emrpesa Trans 111', '02345789000122', '87033190', 'Rua da Volta', '123A', 'Bairro do meio', 'PR', 'Maringá', 'N', NULL, NULL, '2022-08-29 19:40:27', '2022-09-19 21:51:22'),
	(2, '535697b1455cd0a42273b5fa535be7b248327d088fe0fe48eb00a03e2eed77ad', 1, 1, 'Trans 2', '', '', '', '', '', '', '', 'S', '2022-09-17 10:49:24', 1, '2022-08-29 19:41:26', '2022-09-17 10:49:24'),
	(3, '549cd73f27f6501935a713a44dcdd454c034899c32cae338535cd94f1c9f968f', 1, 1, 'Trans 3', '02345789000122', '87033190', 'Rua da Volta', '123A', 'Bairro do meio', 'PR', 'Maringá', 'N', NULL, NULL, '2022-08-29 19:41:32', '2022-09-19 21:51:27'),
	(4, '0b9202e8f57898f61582d723a577ec0e07c5fabfc6b1929ba875e12c093cad43', 1, 1, 'Trans 4', '', '', '', '', '', '', '', 'S', '2022-09-21 22:13:48', 1, '2022-08-29 19:42:06', '2022-09-21 22:13:48');
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;

-- Copiando estrutura para tabela passagens.enderecos
CREATE TABLE IF NOT EXISTS `enderecos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL DEFAULT (sha2(now(),256)),
  `cep` varchar(10) NOT NULL,
  `logradouro` varchar(150) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `localizacao` varchar(45) DEFAULT NULL,
  `excluido` enum('S','N') DEFAULT 'N',
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela passagens.enderecos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `enderecos` DISABLE KEYS */;
INSERT INTO `enderecos` (`id`, `key`, `cep`, `logradouro`, `numero`, `complemento`, `cidade`, `uf`, `pais`, `localizacao`, `excluido`, `excluido_data`, `excluido_por`, `data_insert`, `data_update`) VALUES
	(1, 'ccd1ca6dd73c2ce89c38273c0ea97831716009f6851d2305d5be111ba261925b', '87033190', 'Rua araxá', '987', 'casa', 'Maringa', 'PR', 'Br', NULL, 'N', NULL, NULL, '2022-08-29 19:33:57', NULL);
/*!40000 ALTER TABLE `enderecos` ENABLE KEYS */;

-- Copiando estrutura para tabela passagens.localidades_log
CREATE TABLE IF NOT EXISTS `localidades_log` (
  `localidades_id` int NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `direcao` enum('1','2') COLLATE latin1_general_ci DEFAULT NULL COMMENT '1: origem; 2: destino'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela passagens.localidades_log: ~21 rows (aproximadamente)
/*!40000 ALTER TABLE `localidades_log` DISABLE KEYS */;
INSERT INTO `localidades_log` (`localidades_id`, `data`, `direcao`) VALUES
	(7809, '2022-09-14 23:50:40', '1'),
	(7810, '2022-09-14 23:50:40', '2'),
	(7809, '2022-09-14 23:50:42', '1'),
	(7810, '2022-09-14 23:50:42', '2'),
	(7809, '2022-09-14 23:50:44', '1'),
	(7810, '2022-09-14 23:50:44', '2'),
	(7809, '2022-09-14 23:56:02', '1'),
	(7809, '2022-09-14 23:56:53', '1'),
	(7810, '2022-09-14 23:56:53', '2'),
	(7809, '2022-09-14 23:57:27', '1'),
	(7810, '2022-09-14 23:57:27', '2'),
	(7809, '2022-09-14 23:58:22', '1'),
	(7810, '2022-09-14 23:58:22', '2'),
	(7809, '2022-09-15 00:01:28', '1'),
	(7810, '2022-09-15 00:01:28', '2'),
	(7809, '2022-09-15 00:01:43', '1'),
	(7810, '2022-09-15 00:01:43', '2'),
	(7809, '2022-09-15 00:02:15', '1'),
	(7810, '2022-09-15 00:02:15', '2'),
	(7809, '2022-09-15 00:02:25', '1'),
	(7810, '2022-09-15 00:02:25', '2'),
	(7809, '2022-09-15 00:03:07', '1'),
	(7809, '2022-09-15 00:04:29', '1'),
	(7810, '2022-09-15 00:04:29', '2');
/*!40000 ALTER TABLE `localidades_log` ENABLE KEYS */;

-- Copiando estrutura para tabela passagens.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) COLLATE latin1_general_ci NOT NULL DEFAULT (sha2(now(),256)),
  `codigo` bigint DEFAULT NULL,
  `clientes_id` int NOT NULL,
  `viagens_id` int NOT NULL,
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `cpf` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `status` enum('R','P','C') CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT 'R: Reservado; P: Pago; C: Cancelado',
  `excluido` enum('S','N') COLLATE latin1_general_ci DEFAULT 'N',
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`key`),
  KEY `fk_pedidos_clientes1_idx` (`clientes_id`),
  KEY `fk_pedidos_viagens` (`viagens_id`),
  CONSTRAINT `fk_pedidos_viagens` FOREIGN KEY (`viagens_id`) REFERENCES `viagens` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela passagens.pedidos: ~22 rows (aproximadamente)
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` (`id`, `key`, `codigo`, `clientes_id`, `viagens_id`, `nome`, `cpf`, `valor`, `status`, `excluido`, `excluido_data`, `excluido_por`, `data_insert`, `data_update`) VALUES
	(7, 'ba938f1b4d61be1637ed9aefb9bf995ad4e920b7ea48e978c4d6645bafcc9454', 2209140000100001, 1, 1, '', NULL, 16.57, 'R', 'N', NULL, NULL, '2022-09-14 23:44:13', '2022-09-20 07:38:42'),
	(8, 'ad252d79de0874169f48a8873e5aa06929790bd9a572502ab02087f587c6ba17', 2209140000100008, 1, 1, '', NULL, 16.57, 'P', 'N', NULL, NULL, '2022-09-14 23:45:17', '2022-09-20 07:38:45'),
	(9, '6396cf12717bf403cc28bc5077d4ac153a7b17792e62d52ed6aa67df319fe2bb', 2209140000100009, 1, 1, '', '01803177926', 16.57, 'R', 'N', NULL, NULL, '2022-09-14 23:45:58', '2022-09-20 07:45:59'),
	(10, '474b603629ccab37f24b6cb5a51333a4ec69106193cb8f14edd8974a60779864', 2209140000100010, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:46:45', NULL),
	(11, 'dbad477dc10729a8f0850aa66ef7a6a6cac52baee059fc396c513c68a34a744e', 2209140000100011, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:47:39', NULL),
	(12, '44e5655b202fabf32be69e52780832eefd3ed1e7f6d12274e75eef9759e48d34', 2209140000100012, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:47:59', NULL),
	(13, '74db1ecd58f7cf2d45a1d63b5d092ab7b6ec25d25b17a3d1b3a0206586ed22a2', 2209140000100013, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:48:40', NULL),
	(14, 'ca5eae0db5e8ee4079280b643dacd4516cee41038d8c8030942c7d57c7ac44c6', 2209140000100014, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:49:42', NULL),
	(15, '1a5b4362a8b5624ae83b38766221a2ca76e58258ad1d7f0b8982dbb36e044108', 2209140000100015, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:50:23', NULL),
	(16, 'a2b67ad12d3a545bcc6e8e46f9613e69a79f2e2228aaa265cbbc1531643bc8c1', 2209140000100016, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:50:40', NULL),
	(17, '4bcb771e7d884dd625db4dc7997fa93272c4a459851e6f108d938acb2aa7bb07', 2209140000100017, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:50:42', NULL),
	(18, '49aa9250b02e4caa4cae6de28bab95a153f7533a05537987c3e00f1efb88fede', 2209140000100018, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:50:44', NULL),
	(19, 'ce0786e2d9f1b5d645c17df4732d1df85e08810b9542482bc0d488d13141db6a', 2209140000100019, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:56:02', NULL),
	(20, 'f68e155c727f27328d08242b9d7c63521dcbc8c662d904e3dbc87f3bf12ef698', 2209140000100020, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:56:53', NULL),
	(21, 'a54e393963a563f6a88c60ab0591aa76ebe6d9ba5046c9f08c1cc83a10cc40d8', 2209140000100021, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:57:27', NULL),
	(22, '610bc737a295448125f3c948c1f445ed9c200f2500ddc0629ca5ba875bc59d3e', 2209140000100022, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-14 23:58:22', NULL),
	(23, 'f9d8f9759c7095c2c1e2bd8f8eab1d439dac93f7f6d67ec776a03a67aa8e2204', 2209150000100023, 1, 1, '', NULL, 16.57, NULL, 'S', '2022-09-21 22:17:18', 1, '2022-09-15 00:01:28', '2022-09-21 22:17:18'),
	(24, '1ade8f8140acaa8387fd0234409378c78e9635aa67630233959ba08f1d2c5b2c', 2209150000100024, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-15 00:01:43', NULL),
	(25, '509dbb8308ad136bf365eef9cb9a177fd63d894684e343a61e6756d934be83f4', 2209150000100025, 1, 1, '', NULL, 16.57, NULL, 'S', '2022-09-21 22:16:53', 1, '2022-09-15 00:02:15', '2022-09-21 22:16:53'),
	(26, '9d25b1daa88c4cfc130fd39da24d03aac72ab777fbbe65e49abe5cf68691c1e9', 2209150000100026, 1, 1, '', NULL, 16.57, NULL, 'N', NULL, NULL, '2022-09-15 00:02:25', NULL),
	(27, '7c8e11890c249f6f5cf32719408fde3cbf8d268d3d3b427d38b3bea0a154ba3f', 2209150000100027, 1, 1, '', NULL, 16.57, NULL, 'S', '2022-09-21 22:29:49', 1, '2022-09-15 00:03:07', '2022-09-21 22:29:49'),
	(28, '119cf8e542a4edd750f04c56088fd6df4e1efac684deeacbccf47b41e3f7ffdf', 2209150000100028, 1, 1, '', NULL, 16.57, NULL, 'S', '2022-09-21 22:16:11', 1, '2022-09-15 00:04:29', '2022-09-21 22:16:11');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;

-- Copiando estrutura para tabela passagens.pessoas
CREATE TABLE IF NOT EXISTS `pessoas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) COLLATE latin1_general_ci NOT NULL DEFAULT (sha2(now(),256)),
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `cpf_cnpj` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `documento` varchar(20) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Documento com foto',
  `excluido` enum('S','N') COLLATE latin1_general_ci DEFAULT 'N',
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela passagens.pessoas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoas` DISABLE KEYS */;
/*!40000 ALTER TABLE `pessoas` ENABLE KEYS */;

-- Copiando estrutura para tabela passagens.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(50) DEFAULT NULL,
  `pessoas_id` int DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `senha` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Criptografada com mysql => sha2(''str'',256) ou php => hash(''sha256'', ''str'');',
  `token` varchar(64) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `nivel` int DEFAULT NULL COMMENT '1: Básico; 3: Médio; 5: Super',
  `excluido` enum('S','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'N',
  `excluido_por` int DEFAULT NULL,
  `excluido_data` datetime DEFAULT NULL,
  `dataInsert` datetime DEFAULT CURRENT_TIMESTAMP,
  `dataUpdate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pessoas` (`pessoas_id`),
  CONSTRAINT `fk_pessoas` FOREIGN KEY (`pessoas_id`) REFERENCES `pessoas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela passagens.usuarios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `key`, `pessoas_id`, `usuario`, `senha`, `token`, `email`, `celular`, `nivel`, `excluido`, `excluido_por`, `excluido_data`, `dataInsert`, `dataUpdate`) VALUES
	(1, NULL, NULL, 'ivan', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '1234', 'ivan100br@yahoo.com.br', '44999262946', 3, 'N', NULL, NULL, NULL, '2022-09-17 15:19:42');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Copiando estrutura para tabela passagens.usuarios_log
CREATE TABLE IF NOT EXISTS `usuarios_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuarios_id` int DEFAULT NULL,
  `uri` varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `direcao` enum('E','S') COLLATE latin1_general_ci DEFAULT NULL COMMENT 'E: Entrada; S: Saída',
  `dataInsert` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela passagens.usuarios_log: ~46 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios_log` DISABLE KEYS */;
INSERT INTO `usuarios_log` (`id`, `usuarios_id`, `uri`, `direcao`, `dataInsert`) VALUES
	(1, NULL, 'https://admpassagens.americabiz/usuarios/login/ent', NULL, '2022-09-17 00:07:57'),
	(2, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', NULL, '2022-09-17 00:09:53'),
	(3, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', NULL, '2022-09-17 00:10:17'),
	(4, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', NULL, '2022-09-17 00:12:10'),
	(5, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', NULL, '2022-09-17 00:15:28'),
	(6, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', NULL, '2022-09-17 00:15:51'),
	(7, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', NULL, '2022-09-17 00:20:47'),
	(8, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:43:35'),
	(9, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:44:55'),
	(10, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:45:14'),
	(11, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:45:56'),
	(12, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:46:54'),
	(13, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:48:09'),
	(14, 1, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-17 00:48:54'),
	(15, NULL, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-17 00:49:07'),
	(16, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:50:44'),
	(17, 1, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-17 00:51:04'),
	(18, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:55:05'),
	(19, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:56:09'),
	(20, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:56:39'),
	(21, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:57:35'),
	(22, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:57:48'),
	(23, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:58:13'),
	(24, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:58:29'),
	(25, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:58:49'),
	(26, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:59:20'),
	(27, 1, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-17 00:59:29'),
	(28, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 00:59:34'),
	(29, 1, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-17 01:00:02'),
	(30, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 01:00:07'),
	(31, 1, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-17 01:02:34'),
	(32, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 01:05:45'),
	(33, 1, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-17 01:06:00'),
	(34, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 01:06:02'),
	(35, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 09:04:56'),
	(36, 1, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-17 09:32:37'),
	(37, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 09:32:38'),
	(38, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 14:22:07'),
	(39, 1, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-17 15:19:46'),
	(40, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 15:19:48'),
	(41, 1, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-17 15:44:39'),
	(42, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 21:11:32'),
	(43, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 21:15:35'),
	(44, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 21:15:59'),
	(45, 1, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-17 21:16:52'),
	(46, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-17 21:16:58'),
	(47, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-18 19:12:14'),
	(48, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-19 06:10:21'),
	(49, 1, 'https://admpassagens.americabiz/usuarios/login/sair', 'S', '2022-09-19 06:10:26'),
	(50, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-19 06:10:51'),
	(51, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-19 20:29:11'),
	(52, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-19 21:29:04'),
	(53, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-20 06:26:18'),
	(54, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-20 07:25:23'),
	(55, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-20 18:22:30'),
	(56, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-21 07:15:18'),
	(57, 1, 'https://admpassagens.americabiz/usuarios/login/entrar', 'E', '2022-09-21 20:41:54');
/*!40000 ALTER TABLE `usuarios_log` ENABLE KEYS */;

-- Copiando estrutura para tabela passagens.veiculos
CREATE TABLE IF NOT EXISTS `veiculos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL DEFAULT (sha2(now(),256)),
  `veiculos_tipo_id` int NOT NULL,
  `empresas_id` int NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(45) DEFAULT NULL,
  `ano` varchar(45) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `excluido` enum('S','N') DEFAULT 'N',
  `placa` varchar(45) DEFAULT NULL,
  `lugares` varchar(45) DEFAULT NULL,
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`key`),
  KEY `fk_veiculos_empresas` (`empresas_id`),
  KEY `fk_veiculos_veiculos_tipo` (`veiculos_tipo_id`),
  CONSTRAINT `fk_veiculos_empresas` FOREIGN KEY (`empresas_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `fk_veiculos_veiculos_tipo` FOREIGN KEY (`veiculos_tipo_id`) REFERENCES `veiculos_tipo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela passagens.veiculos: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `veiculos` DISABLE KEYS */;
INSERT INTO `veiculos` (`id`, `key`, `veiculos_tipo_id`, `empresas_id`, `marca`, `modelo`, `ano`, `codigo`, `excluido`, `placa`, `lugares`, `excluido_data`, `excluido_por`, `data_insert`, `data_update`) VALUES
	(1, '0b086a1e14da3e60a9959815a5587aace1d4fe380657ee99568dd83956be4f73', 1, 2, 'Volvo', 'mo', '2019', '1101', 'N', 'ABC1501', NULL, NULL, NULL, '2022-08-29 20:10:28', '2022-09-21 07:31:58'),
	(2, '8cb98dd961b7849a570b54dd0427982158acc26f5473547bc6416ae8c94b2cf8', 2, 4, 'Volvo', 'mo', '2019', '1102', 'S', 'ABC2502', NULL, '2022-09-17 10:37:33', 1, '2022-08-29 20:11:06', '2022-09-21 07:32:01'),
	(3, '5eb795a671a23e1169b5264fc0fa854fbb316c71c6fdfcf1f9008cd093882158', 1, 3, 'Volvoxxxxxx', 'mo', '2019', '1103', 'S', 'ABC3003', NULL, '2022-09-17 10:32:05', 1, '2022-08-29 20:11:13', '2022-09-21 07:32:06'),
	(4, '9b15ba7df73577826177fc5796ff395e1a65f9d56249c7bc7a3dbf4c87dbc7c5', 1, 4, 'Volvo', 'mo', '2019', '1104', 'S', 'ABC4904', NULL, '2022-09-17 10:38:06', 1, '2022-08-29 20:11:47', '2022-09-21 07:32:10'),
	(5, '73813b726630d79c751a14de01b651732cbbffd149206ea9903486b65a233f70', 2, 3, 'Volvo5', 'mo5', '2005', '1105', 'N', 'ABC-5555', NULL, NULL, NULL, '2022-08-29 20:12:31', '2022-09-21 22:28:13'),
	(6, 'fb7ac4dfb9f03132a04a5600afd7ebde2694e57268708f43a3436a34f403250b', 1, 1, 'Volvo', 'mo', '2019', '1100', 'N', 'ABC1A66', NULL, NULL, NULL, '2022-08-29 20:13:04', '2022-09-21 07:32:26'),
	(7, 'bfd2fa645e0aae8a8c60a980c0ba3e6845ba63b5211a90205cfe157f1f409de7', 1, 1, 'Volvo', 'mo', '2019', '1100', 'S', 'ABC7Y47', NULL, '2022-09-17 10:45:59', 1, '2022-08-29 20:13:08', '2022-09-21 07:32:54'),
	(8, '02b1848a0796aeefa675a4fdcb35fcbf7807871d9593910a877f780416f480d3', 1, 1, 'Volvo', 'mo', '2019', '1100', 'S', 'ABC8808', NULL, '2022-09-17 10:39:08', 1, '2022-08-29 20:13:59', '2022-09-21 07:32:51'),
	(9, 'a772c09fd49dc93734b72f65b0ad4d6ee28cc3a1df4b9b57995399eb34144703', 1, 1, 'Volvo', 'mo', '2019', '1100', 'S', 'ABC9P78', NULL, '2022-09-21 22:18:19', 1, '2022-08-29 20:14:19', '2022-09-21 22:18:19'),
	(10, '51c1c0490fbfc5ecc590c7789c0df8abc2fbaa0b8fccd1b5a5f94652b95a058b', 1, 1, 'Volvo', 'mo', '2019', '1100', 'S', 'ABC1010', NULL, '2022-09-17 10:46:25', 1, '2022-08-29 20:14:30', '2022-09-21 07:33:08');
/*!40000 ALTER TABLE `veiculos` ENABLE KEYS */;

-- Copiando estrutura para tabela passagens.veiculos_tipo
CREATE TABLE IF NOT EXISTS `veiculos_tipo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'sha2(now(),256)',
  `nome` varchar(50) DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `excluido` enum('S','N') DEFAULT NULL,
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela passagens.veiculos_tipo: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `veiculos_tipo` DISABLE KEYS */;
INSERT INTO `veiculos_tipo` (`id`, `key`, `nome`, `descricao`, `excluido`, `excluido_data`, `excluido_por`, `data_insert`, `data_update`) VALUES
	(1, NULL, 'Ônibus', 'Ônibus mesmo', 'S', '2022-09-21 22:18:02', 1, '2022-08-29 21:12:07', '2022-09-21 22:18:02'),
	(2, NULL, 'Konbi', 'Filhote de ônibus ;-)', 'S', '2022-09-21 22:17:29', 1, '2022-08-29 21:12:07', '2022-09-21 22:17:29');
/*!40000 ALTER TABLE `veiculos_tipo` ENABLE KEYS */;

-- Copiando estrutura para tabela passagens.viagens
CREATE TABLE IF NOT EXISTS `viagens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL DEFAULT (sha2(now(),256)),
  `veiculos_id` int DEFAULT NULL,
  `descricao` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `origem_id` int DEFAULT NULL,
  `destino_id` int DEFAULT NULL,
  `data_saida` datetime NOT NULL,
  `data_chegada` datetime NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `detalhes` text,
  `excluido` enum('S','N') DEFAULT 'N',
  `excluido_data` datetime DEFAULT NULL,
  `excluido_por` int DEFAULT NULL,
  `data_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`key`),
  KEY `fk_viagens_veiculos` (`veiculos_id`) USING BTREE,
  CONSTRAINT `fk_viagens_veiculos` FOREIGN KEY (`veiculos_id`) REFERENCES `veiculos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela passagens.viagens: ~16 rows (aproximadamente)
/*!40000 ALTER TABLE `viagens` DISABLE KEYS */;
INSERT INTO `viagens` (`id`, `key`, `veiculos_id`, `descricao`, `origem_id`, `destino_id`, `data_saida`, `data_chegada`, `valor`, `detalhes`, `excluido`, `excluido_data`, `excluido_por`, `data_insert`, `data_update`) VALUES
	(1, 'd60bd8da8a09059a7f3449cab2839e04d183f3071ed90cf237705499b0d453cd', 9, 'dafadsfadf', 7809, 7810, '2022-08-30 08:00:00', '2022-08-30 18:00:00', 95.05, 'Nenhum detalhe', 'N', NULL, NULL, '2022-08-29 20:27:51', '2022-09-21 22:39:14'),
	(2, '4c1afb6f4d9304473363e75d328ec74adcff8b2ca4c517c4bd26dfaa9a86e2e7', 9, '7809', 7809, 7810, '2022-08-12 20:00:00', '2022-09-03 11:00:00', 101.01, 'Sainda em frente ao parque', 'N', NULL, NULL, '2022-08-30 07:41:22', '2022-09-19 22:45:48'),
	(3, 'd6f4b26df527a5a23931f193f91ae015ac15bffcd1616e0f0df49e7679f953e2', 5, '7809', 7809, 7810, '2022-08-25 21:00:00', '2022-09-01 11:00:00', NULL, 'Nenhum detalhe', 'N', NULL, NULL, '2022-08-30 07:41:41', '2022-09-14 23:49:17'),
	(4, 'e350293eb3285f84ccaa25e4425fb89eb3967ca4bd58d700c9e09a271827e4f3', 9, '0', 0, 0, '2022-08-31 20:00:00', '2022-09-01 11:00:00', NULL, 'Chega tarde', 'S', '2022-09-21 22:10:24', 1, '2022-08-30 07:42:33', '2022-09-21 22:10:24'),
	(5, '0ebea8abbc2e1b0f669955aa143488a8907598e34f9d60632105dc64adf1c995', 5, '0', 0, 0, '2022-08-31 20:00:00', '2022-09-01 11:00:00', NULL, 'Nenhum detalhe', 'S', '2022-09-21 22:12:48', 1, '2022-08-30 07:44:09', '2022-09-21 22:12:48'),
	(6, '87761f5c64434254bba38e291a8ab2afbcb4d6d9fa785adc206a01ef27db6f89', 3, '0', 0, 0, '2022-08-31 20:00:00', '2022-09-01 11:00:00', NULL, 'Nenhum detalhe', 'S', '2022-09-21 22:13:16', 1, '2022-08-30 07:46:01', '2022-09-21 22:13:16'),
	(7, 'bef0c94416ddc8a18a970ff04b1690b2ebc0aa9f3b7abbf29c087810c10e64c0', 9, '0', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'Nenhum detalhe', 'S', '2022-09-21 22:13:35', 1, '2022-08-30 07:46:23', '2022-09-21 22:13:35'),
	(8, '2a757d763b8a1e61cd4e028c37058b71e848f9afadd929a8c22963befea868e7', 9, '0', 0, 0, '2022-08-01 20:00:00', '2022-09-21 11:00:00', NULL, 'Nenhum detalhe', 'S', '2022-09-21 22:13:27', 1, '2022-08-30 07:46:29', '2022-09-21 22:13:27'),
	(9, '4f2a68c36fc4f00c9bc4a28e14a18a09b29de2796046443a5d7432900d8d4015', NULL, '0', 0, 0, '2022-08-31 20:00:00', '2022-09-01 11:00:00', NULL, 'Nenhum detalhe', 'S', '2022-09-17 10:47:36', 1, '2022-08-30 07:47:25', '2022-09-17 10:47:36'),
	(10, '0c3d6c073c2a8626204a489e576d66c97294531146a0a736e6864e6bd5d3eff4', NULL, '0', 0, 0, '2022-08-31 20:00:00', '2022-09-01 11:00:00', NULL, 'Nenhum detalhe', 'S', '2022-09-17 10:47:47', 1, '2022-08-30 07:48:33', '2022-09-17 10:47:47'),
	(11, '709e76dffcb3b98140bdb885a833fa011f22160ba9112a28e833e1ac442cd4c5', NULL, '0', 0, 0, '2022-08-31 20:00:00', '2022-09-01 11:00:00', NULL, 'Nenhum detalhe', 'S', '2022-09-17 10:47:49', 1, '2022-08-30 07:49:05', '2022-09-17 10:47:49'),
	(12, 'bfae7e537bd4b27171605a5d989264b76329b6da7c941101d68ff39d8d2812e0', NULL, '0', 0, 0, '2022-08-31 20:00:00', '2022-09-01 11:00:00', NULL, 'Nenhum detalhe', 'S', '2022-09-17 10:47:51', 1, '2022-08-30 07:49:27', '2022-09-17 10:47:51'),
	(13, 'eb2dd93f46504e29e7c12f08d51bbacc604d4ee49d437e97078087ceb3aa81d2', 2, '0', 0, 0, '2022-08-31 20:00:00', '2022-09-01 11:00:00', NULL, 'Nenhum detalhe', 'S', '2022-09-17 10:47:52', 1, '2022-08-30 07:50:16', '2022-09-17 10:47:52'),
	(14, '1f83998ea0bf4fdb4783845a58317bf170222224a8ec7c3a18b3a89f397973d5', 6, 'Primeira viagem de teste', 7764, 7809, '2022-09-24 22:00:00', '2022-09-24 23:00:00', 99.50, 'Sai da rodoviária de Londrina e chega na praça de Maringá', 'N', NULL, NULL, '2022-09-20 20:10:54', NULL),
	(15, '1f83998ea0bf4fdb4783845a58317bf170222224a8ec7c3a18b3a89f397973d5', 6, 'Primeira viagem de teste', 7764, 7809, '2022-09-24 22:00:00', '2022-09-24 23:00:00', 99.50, 'Sai da rodoviária de Londrina e chega na praça de Maringá', 'N', NULL, NULL, '2022-09-20 20:10:54', NULL),
	(16, '996f9a3e0b17331d9887d0a5604b2bc7fd9565c75505b3b754ed8ca61071e89c', 9, 'Segunda viagem de teste', 7809, 7764, '2022-09-20 20:00:00', '2022-09-20 22:00:00', NULL, NULL, 'N', NULL, NULL, '2022-09-20 20:13:15', NULL),
	(17, '996f9a3e0b17331d9887d0a5604b2bc7fd9565c75505b3b754ed8ca61071e89c', 9, 'Segunda viagem de teste', 7809, 7764, '2022-09-20 20:00:00', '2022-09-20 22:00:00', NULL, NULL, 'N', NULL, NULL, '2022-09-20 20:13:15', NULL);
/*!40000 ALTER TABLE `viagens` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
