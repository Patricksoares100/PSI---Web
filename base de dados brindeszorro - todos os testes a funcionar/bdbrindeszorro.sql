-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 09-Jan-2024 às 15:38
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdbrindeszorro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `artigos`
--

DROP TABLE IF EXISTS `artigos`;
CREATE TABLE IF NOT EXISTS `artigos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `preco` double NOT NULL,
  `stock_atual` int NOT NULL,
  `iva_id` int NOT NULL,
  `fornecedor_id` int NOT NULL,
  `categoria_id` int NOT NULL,
  `perfil_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-artigos-iva_id` (`iva_id`),
  KEY `fk-artigos-fornecedores_id` (`fornecedor_id`),
  KEY `fk-artigos-perfil_id` (`perfil_id`),
  KEY `fk-artigos-categoria_id` (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `artigos`
--

INSERT INTO `artigos` (`id`, `nome`, `descricao`, `referencia`, `preco`, `stock_atual`, `iva_id`, `fornecedor_id`, `categoria_id`, `perfil_id`) VALUES
(1, 'Caneta Aluminio', 'Caneta Preta Potente', 'CAN001', 2.5, 13, 1, 1, 1, 1),
(2, 'Relogio Desportivo', 'Relogio Preto Desportivo à prova de água', 'REL001', 89, 33, 1, 1, 3, 1),
(3, 'Porta Chaves Metálico', 'Porta Chaves Metálico personalizável ao seu gosto!', 'PCM001', 0.99, 80, 1, 1, 2, 1),
(4, 'Elásticos', 'Elásticos pequenos', 'EPQ001', 0.5, 333, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Admin', '1', 1703853460),
('Cliente', '3', 1703853730),
('Funcionario', '2', 1703853584);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Admin', 1, 'Role de Administrador', NULL, NULL, 1703853460, 1703853460),
('Cliente', 1, 'Role de Cliente', NULL, NULL, 1703853460, 1703853460),
('deleteArtigo', 2, 'Eliminar Artigo', NULL, NULL, 1703853460, 1703853460),
('deleteAvaliacao', 2, 'Eliminar Avaliacao', NULL, NULL, 1703853460, 1703853460),
('deleteCategoria', 2, 'Eliminar Categorias', NULL, NULL, 1703853460, 1703853460),
('deleteFatura', 2, 'Eliminar Fatura', NULL, NULL, 1703853460, 1703853460),
('deleteFornecedor', 2, 'Eliminar Fornecedor', NULL, NULL, 1703853460, 1703853460),
('deleteIva', 2, 'Eliminar Iva', NULL, NULL, 1703853460, 1703853460),
('deleteProprioCliente', 2, 'Delete Proprio Cliente', 'isDeleteProprioCliente', NULL, 1703853460, 1703853460),
('editEmpresa', 2, 'Permissão para editar os dados da empresa', NULL, NULL, 1703853460, 1703853460),
('editRoles', 2, 'Permissão para editar os roles', NULL, NULL, 1703853460, 1703853460),
('Funcionario', 1, 'Role de Funcionario', NULL, NULL, 1703853460, 1703853460),
('gerirProdutos', 2, 'Permissão para gerir produtos', NULL, NULL, 1703853460, 1703853460),
('permissionBackoffice', 2, 'Permissão para entrar no backoffice', NULL, NULL, 1703853460, 1703853460),
('permissionFrontoffice', 2, 'Permissão para entrar no front office', NULL, NULL, 1703853460, 1703853460),
('updateAvaliacao', 2, 'Editar Avaliacao', NULL, NULL, 1703853460, 1703853460),
('updateDadosPessoais', 2, 'Atualizar dados pessoais', 'isAuthorDadosPessoais', NULL, 1703853460, 1703853460),
('updatePassword', 2, 'Alterar Password', 'isAuthorPassword', NULL, 1703853460, 1703853460),
('updateProprioCliente', 2, 'Update Proprio Cliente', 'isUpdateProprioCliente', NULL, 1703853460, 1703853460),
('verClientesFront', 2, 'Permissão para ver os seus Favoritos/Carrinho/Faturas como cliente', 'isClientPermission', NULL, 1703853460, 1703853460);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('Admin', 'deleteAvaliacao'),
('Admin', 'deleteCategoria'),
('Admin', 'deleteFatura'),
('Admin', 'deleteFornecedor'),
('Admin', 'deleteIva'),
('Cliente', 'deleteProprioCliente'),
('Admin', 'editEmpresa'),
('Admin', 'editRoles'),
('Admin', 'Funcionario'),
('Funcionario', 'gerirProdutos'),
('Funcionario', 'permissionBackoffice'),
('Cliente', 'permissionFrontoffice'),
('Cliente', 'updateDadosPessoais'),
('Funcionario', 'updateDadosPessoais'),
('Cliente', 'updatePassword'),
('Funcionario', 'updatePassword'),
('Cliente', 'updateProprioCliente'),
('Cliente', 'verClientesFront');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthorDadosPessoais', 0x4f3a33383a22636f6e736f6c655c6d6f64656c735c417574686f724461646f73506573736f61697352756c65223a333a7b733a343a226e616d65223b733a32313a226973417574686f724461646f73506573736f616973223b733a393a22637265617465644174223b693a313730333835333436303b733a393a22757064617465644174223b693a313730333835333436303b7d, 1703853460, 1703853460),
('isAuthorPassword', 0x4f3a33343a22636f6e736f6c655c6d6f64656c735c416c746572617250617373776f726452756c65223a333a7b733a343a226e616d65223b733a31363a226973417574686f7250617373776f7264223b733a393a22637265617465644174223b693a313730333835333436303b733a393a22757064617465644174223b693a313730333835333436303b7d, 1703853460, 1703853460),
('isClientPermission', 0x4f3a34333a22636f6e736f6c655c6d6f64656c735c5065726d6973736f657350726f7072696f436c69656e746552756c65223a333a7b733a343a226e616d65223b733a31383a226973436c69656e745065726d697373696f6e223b733a393a22637265617465644174223b693a313730333835333436303b733a393a22757064617465644174223b693a313730333835333436303b7d, 1703853460, 1703853460),
('isDeleteProprioCliente', 0x4f3a33393a22636f6e736f6c655c6d6f64656c735c44656c65746552756c6550726f7072696f436c69656e7465223a333a7b733a343a226e616d65223b733a32323a22697344656c65746550726f7072696f436c69656e7465223b733a393a22637265617465644174223b693a313730333835333436303b733a393a22757064617465644174223b693a313730333835333436303b7d, 1703853460, 1703853460),
('isUpdateProprioCliente', 0x4f3a33393a22636f6e736f6c655c6d6f64656c735c55706461746552756c6550726f7072696f436c69656e7465223a333a7b733a343a226e616d65223b733a32323a22697355706461746550726f7072696f436c69656e7465223b733a393a22637265617465644174223b693a313730333835333436303b733a393a22757064617465644174223b693a313730333835333436303b7d, 1703853460, 1703853460);

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacaos`
--

DROP TABLE IF EXISTS `avaliacaos`;
CREATE TABLE IF NOT EXISTS `avaliacaos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comentario` varchar(255) NOT NULL,
  `classificacao` enum('1','2','3','4','5') DEFAULT NULL,
  `artigo_id` int NOT NULL,
  `perfil_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-avaliacaos-artigos_id` (`artigo_id`),
  KEY `fk-avaliacaos-perfil_id` (`perfil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `avaliacaos`
--

INSERT INTO `avaliacaos` (`id`, `comentario`, `classificacao`, `artigo_id`, `perfil_id`) VALUES
(1, 'ja vi melhores', '3', 1, 3),
(7, 'Top', '4', 1, 3),
(8, 'Top', '4', 1, 3),
(9, 'Top', '4', 1, 3),
(10, 'Top', '4', 1, 3),
(11, 'Top', '4', 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Canetas'),
(2, 'Acessórios'),
(3, 'Relógios');

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` int NOT NULL,
  `nif` int NOT NULL,
  `morada` varchar(255) NOT NULL,
  `codigo_postal` varchar(255) NOT NULL,
  `localidade` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`id`, `nome`, `email`, `telefone`, `nif`, `morada`, `codigo_postal`, `localidade`) VALUES
(1, 'BrindesZorro', 'brindes@zorro.com', 123456789, 987654321, 'Alto do Lena', '2400-000', 'Leiria');

-- --------------------------------------------------------

--
-- Estrutura da tabela `faturas`
--

DROP TABLE IF EXISTS `faturas`;
CREATE TABLE IF NOT EXISTS `faturas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `valor_fatura` double NOT NULL,
  `estado` enum('Emitida','Paga') DEFAULT NULL,
  `perfil_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-faturas-perfil_id` (`perfil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `faturas`
--

INSERT INTO `faturas` (`id`, `data`, `valor_fatura`, `estado`, `perfil_id`) VALUES
(1, '2023-12-29 12:42:48', 3.075, 'Paga', 3),
(5, '2023-12-31 02:03:32', 3.075, 'Paga', 3),
(7, '2023-12-31 02:11:25', 3.075, 'Paga', 3),
(9, '2023-12-31 02:19:48', 3.075, 'Paga', 3),
(11, '2023-12-31 11:38:06', 3.075, 'Paga', 3),
(13, '2024-01-09 14:16:36', 3.075, 'Paga', 3),
(15, '2024-01-09 14:30:46', 3.075, 'Paga', 3),
(18, '2024-01-09 14:35:19', 3.075, 'Paga', 3),
(20, '2024-01-09 14:59:35', 3.075, 'Paga', 3),
(22, '2024-01-09 15:28:13', 3.075, 'Paga', 3),
(24, '2024-01-09 15:35:03', 3.075, 'Paga', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `artigo_id` int NOT NULL,
  `perfil_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-favoritos-artigos_id` (`artigo_id`),
  KEY `fk-favoritos-perfil_id` (`perfil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

DROP TABLE IF EXISTS `fornecedores`;
CREATE TABLE IF NOT EXISTS `fornecedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `telefone` int DEFAULT NULL,
  `nif` int DEFAULT NULL,
  `morada` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id`, `nome`, `telefone`, `nif`, `morada`) VALUES
(1, 'Fornecedor1', 111222333, 333222111, 'Rua do Santo, 1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens`
--

DROP TABLE IF EXISTS `imagens`;
CREATE TABLE IF NOT EXISTS `imagens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `artigo_id` int DEFAULT NULL,
  `categoria_id` int DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `imagens`
--

INSERT INTO `imagens` (`id`, `artigo_id`, `categoria_id`, `image_path`) VALUES
(3, 1, NULL, 'uploads/caneta_20231229124130.png'),
(4, NULL, 1, 'uploads/g_2023.03_28212_2750_20231231021347.jpg'),
(5, NULL, 2, 'uploads/top-view-acessorios-para-viajar-com-roupas-femininas-conceito-blanco_1921-107_20231231021510.jpg'),
(6, NULL, 3, 'uploads/relogios_20231231021522.jpg'),
(7, 2, NULL, 'uploads/relogio_20231231021550.jpg'),
(8, 3, NULL, 'uploads/porta-chaves-hassu-em-aco-chapa-retangular-prateado_20231231021628.jpg'),
(9, 4, NULL, 'uploads/LOSQXL_MI2_0826_STRAPPING_STAPLING_BUNDLING_ELASTIC_BAND_S19_TS_440735_00_20180910_20231231021654.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ivas`
--

DROP TABLE IF EXISTS `ivas`;
CREATE TABLE IF NOT EXISTS `ivas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `em_vigor` enum('Sim','Não') DEFAULT NULL,
  `descricao` varchar(255) NOT NULL,
  `percentagem` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `ivas`
--

INSERT INTO `ivas` (`id`, `em_vigor`, `descricao`, `percentagem`) VALUES
(1, 'Sim', 'todos artigos', 23);

-- --------------------------------------------------------

--
-- Estrutura da tabela `linhas_carrinho`
--

DROP TABLE IF EXISTS `linhas_carrinho`;
CREATE TABLE IF NOT EXISTS `linhas_carrinho` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int NOT NULL,
  `artigo_id` int NOT NULL,
  `perfil_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-linhascarrinho-artigos_id` (`artigo_id`),
  KEY `fk-linhascarrinho-perfil_id` (`perfil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `linhas_faturas`
--

DROP TABLE IF EXISTS `linhas_faturas`;
CREATE TABLE IF NOT EXISTS `linhas_faturas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int NOT NULL,
  `valor` double NOT NULL,
  `valor_iva` double NOT NULL,
  `artigo_id` int NOT NULL,
  `fatura_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-linhasfaturas-artigos_id` (`artigo_id`),
  KEY `fk-linhasfaturas-faturas_id` (`fatura_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `linhas_faturas`
--

INSERT INTO `linhas_faturas` (`id`, `quantidade`, `valor`, `valor_iva`, `artigo_id`, `fatura_id`) VALUES
(1, 1, 2.5, 0.58, 1, 1),
(5, 1, 2.5, 0.58, 1, 5),
(7, 1, 2.5, 0.58, 1, 7),
(9, 1, 2.5, 0.58, 1, 9),
(11, 1, 2.5, 0.58, 1, 11),
(13, 1, 2.5, 0.58, 1, 13),
(15, 1, 2.5, 0.58, 1, 15),
(18, 1, 2.5, 0.58, 1, 18),
(20, 1, 2.5, 0.58, 1, 20),
(22, 1, 2.5, 0.58, 1, 22),
(24, 1, 2.5, 0.58, 1, 24);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1703853457),
('m130524_201442_init', 1703853459),
('m140506_102106_rbac_init', 1703853459),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1703853459),
('m180523_151638_rbac_updates_indexes_without_prefix', 1703853459),
('m190124_110200_add_verification_token_column_to_user_table', 1703853459),
('m200409_110543_rbac_update_mssql_trigger', 1703853459),
('m231030_212423_init_rbac', 1703853460),
('m231031_210433_criar_bd_inicial', 1703853463);

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfis`
--

DROP TABLE IF EXISTS `perfis`;
CREATE TABLE IF NOT EXISTS `perfis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `telefone` int NOT NULL,
  `nif` int NOT NULL,
  `morada` varchar(255) NOT NULL,
  `codigo_postal` varchar(255) NOT NULL,
  `localidade` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `perfis`
--

INSERT INTO `perfis` (`id`, `nome`, `telefone`, `nif`, `morada`, `codigo_postal`, `localidade`) VALUES
(1, 'Admin', 987654321, 123456789, 'Leiria', '2480-123', 'leiria'),
(2, 'funcionario', 123456789, 999888777, 'Rua 1223, n1', '1234-567', 'Leiria'),
(3, 'cliente', 912345678, 987987987, 'Rua 1223, n1', '1234-567', 'Leiria');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'admin', '', '$2y$13$o/JJp/NOv4p0Q6dyaKobyOi0WNiC2yqeyi.iKHt4/DcdOnOopPLBO', NULL, 'a@a.a', 10, 1703853461, 1703853461, NULL),
(2, 'funcionario', 'F7fZAlWu4tHZJjryzRx7Gc-1TJhf3X3g', '$2y$13$qCHb9XJBmghXyGRzezynZ.InUcH/ImE32NDvBol4w1SUdS6C.LDVO', NULL, 'funcionario@a.com', 10, 1703853583, 1703853583, 'AL-JvGHda2RuLAL0YoQcCmIBVq_CdMM5_1703853583'),
(3, 'cliente', 'Zf771iJV7jYsAfj8ZrxL4jsTYbg8-_gY', '$2y$13$ZlAUgDakFwD7EZ/kQTExV.w7WGD.sXQbAzamT1X7KDRRcCKvha0gO', NULL, 'cliente@a.a', 10, 1703853730, 1704814558, 'nBZ4TZltytNP485zmMIcb-eaJlzIBr07_1703853730');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `artigos`
--
ALTER TABLE `artigos`
  ADD CONSTRAINT `fk-artigos-categoria_id` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-artigos-fornecedores_id` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-artigos-iva_id` FOREIGN KEY (`iva_id`) REFERENCES `ivas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-artigos-perfil_id` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `avaliacaos`
--
ALTER TABLE `avaliacaos`
  ADD CONSTRAINT `fk-avaliacaos-artigos_id` FOREIGN KEY (`artigo_id`) REFERENCES `artigos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-avaliacaos-perfil_id` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `faturas`
--
ALTER TABLE `faturas`
  ADD CONSTRAINT `fk-faturas-perfil_id` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `fk-favoritos-artigos_id` FOREIGN KEY (`artigo_id`) REFERENCES `artigos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-favoritos-perfil_id` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `linhas_carrinho`
--
ALTER TABLE `linhas_carrinho`
  ADD CONSTRAINT `fk-linhascarrinho-artigos_id` FOREIGN KEY (`artigo_id`) REFERENCES `artigos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-linhascarrinho-perfil_id` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `linhas_faturas`
--
ALTER TABLE `linhas_faturas`
  ADD CONSTRAINT `fk-linhasfaturas-artigos_id` FOREIGN KEY (`artigo_id`) REFERENCES `artigos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-linhasfaturas-faturas_id` FOREIGN KEY (`fatura_id`) REFERENCES `faturas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `perfis`
--
ALTER TABLE `perfis`
  ADD CONSTRAINT `fk-perfis-user` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
