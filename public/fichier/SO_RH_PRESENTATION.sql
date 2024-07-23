-- Adminer 4.8.1 MySQL 8.0.37 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `attestation_employeur`;
CREATE TABLE `attestation_employeur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fonction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `motif` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `recuperation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fait_le` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `demandeur_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6263E55FED5CA9E6` (`service_id`),
  KEY `IDX_6263E55F95A6EE59` (`demandeur_id`),
  CONSTRAINT `FK_6263E55F95A6EE59` FOREIGN KEY (`demandeur_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_6263E55FED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `attestation_employeur` (`id`, `service_id`, `email`, `telephone`, `fonction`, `motif`, `recuperation`, `fait_le`, `demandeur_id`) VALUES
(1,	1,	'test@gmail.fr',	'0123654789',	'CDA',	'Test docker',	'Me l\'envoyer par email',	'2024-07-23',	916);

DROP TABLE IF EXISTS `bot_categorie`;
CREATE TABLE `bot_categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `bot_categorie` (`id`, `label`) VALUES
(1,	'les congés'),
(2,	'la formation en entreprise'),
(3,	'la paie en entreprise'),
(4,	'la situation de famille'),
(5,	'les avantages sociaux');

DROP TABLE IF EXISTS `bot_question`;
CREATE TABLE `bot_question` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int NOT NULL,
  `question` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reponse` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FD0C6B64BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_FD0C6B64BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `bot_categorie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `bot_question` (`id`, `categorie_id`, `question`, `reponse`) VALUES
(1,	1,	'Quels sont les différents types de congés disponibles',	'Les différents types de congés disponibles sont les congés payés, les congés maladie, les congés maternité/paternité, les congés sans solde, les congés pour événements familiaux, etc.'),
(2,	1,	'Comment faire une demande de congé',	'Pour faire une demande de congé, veuillez suivre ces étapes : [insérer les étapes ici]'),
(3,	2,	'Quels types de formation sont disponibles en entreprise',	'Les types de formation disponibles en entreprise peuvent inclure des formations en présentiel, des formations en ligne, des ateliers, des formations certifiées, etc.'),
(4,	2,	'Comment puis-je m\'inscrire à une formation en entreprise',	'Pour vous inscrire à une formation en entreprise, veuillez suivre ces étapes : [insérer les étapes ici]'),
(5,	3,	'Comment puis-je consulter ma fiche de paie',	'Pour consulter votre fiche de paie, veuillez suivre ces étapes : [insérer les étapes ici]'),
(6,	3,	'Quels sont les différents éléments inclus dans ma fiche de paie',	'Les différents éléments inclus dans votre fiche de paie peuvent inclure le salaire de base, les primes, les retenues pour impôts, les allocations, etc.'),
(7,	4,	'Quelles sont les démarches à suivre pour déclarer un changement de situation familiale',	'Pour déclarer un changement de situation familiale, veuillez suivre ces étapes : [insérer les étapes ici]'),
(8,	4,	'Quels sont les avantages liés à la situation de famille, tels que les congés familiaux ou les allocations familiales',	'Les avantages liés à la situation de famille peuvent inclure des congés familiaux, des allocations familiales, des avantages fiscaux, etc.'),
(9,	5,	'Quels sont les différents avantages sociaux offerts par l\'entreprise, tels que l\'assurance maladie, l\'assurance vie, ou les régimes de retraite',	'Les différents avantages sociaux offerts par l\'entreprise peuvent inclure l\'assurance maladie, l\'assurance vie, les régimes de retraite, les avantages liés à la santé mentale, etc.'),
(10,	5,	'Comment puis-je m\'inscrire aux différents programmes d\'avantages sociaux proposés par l\'entreprise',	'Pour vous inscrire aux différents programmes d\'avantages sociaux proposés par l\'entreprise, veuillez suivre ces étapes : [insérer les étapes ici]');

DROP TABLE IF EXISTS `changement_adresse`;
CREATE TABLE `changement_adresse` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_id` int NOT NULL,
  `commune_id` int NOT NULL,
  `fait_a_id` int NOT NULL,
  `fonction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` int NOT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fait_le` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `demandeur_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1A21084FED5CA9E6` (`service_id`),
  KEY `IDX_1A21084F131A4F72` (`commune_id`),
  KEY `IDX_1A21084FFB75DE1A` (`fait_a_id`),
  KEY `IDX_1A21084F95A6EE59` (`demandeur_id`),
  CONSTRAINT `FK_1A21084F131A4F72` FOREIGN KEY (`commune_id`) REFERENCES `commune` (`id`),
  CONSTRAINT `FK_1A21084F95A6EE59` FOREIGN KEY (`demandeur_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_1A21084FED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  CONSTRAINT `FK_1A21084FFB75DE1A` FOREIGN KEY (`fait_a_id`) REFERENCES `commune` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `changement_compte`;
CREATE TABLE `changement_compte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_id` int NOT NULL,
  `fait_a_id` int NOT NULL,
  `fonction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fait_le` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `demandeur_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_67ACD789ED5CA9E6` (`service_id`),
  KEY `IDX_67ACD789FB75DE1A` (`fait_a_id`),
  KEY `IDX_67ACD78995A6EE59` (`demandeur_id`),
  CONSTRAINT `FK_67ACD78995A6EE59` FOREIGN KEY (`demandeur_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_67ACD789ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  CONSTRAINT `FK_67ACD789FB75DE1A` FOREIGN KEY (`fait_a_id`) REFERENCES `commune` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `commune`;
CREATE TABLE `commune` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code_postal` int NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `commune` (`id`, `code_postal`, `label`) VALUES
(1,	97402,	'Bras-Panon'),
(2,	97424,	'Cilaos'),
(3,	97403,	'Entre-Deux'),
(4,	97406,	'La Plaine-des-Palmistes'),
(5,	97408,	'La Possession'),
(6,	97407,	'Le Port'),
(7,	97401,	'Les Avirons'),
(8,	97423,	'Les Trois-Bassins'),
(9,	97422,	'Le Tampon'),
(10,	97404,	'L\'Étang-Salé'),
(11,	97405,	'Petite-Île'),
(12,	97409,	'Saint-André'),
(13,	97410,	'Saint-Benoît'),
(14,	97411,	'Saint-Denis'),
(15,	97418,	'Sainte-Marie'),
(16,	97419,	'Sainte-Rose'),
(17,	97420,	'Sainte-Suzanne'),
(18,	97412,	'Saint-Joseph'),
(19,	97413,	'Saint-Leu'),
(20,	97414,	'Saint-Louis'),
(21,	97415,	'Saint-Paul'),
(22,	97417,	'Saint-Philippe'),
(23,	97416,	'Saint-Pierre'),
(24,	97421,	'Salazie');

DROP TABLE IF EXISTS `demande_accompte`;
CREATE TABLE `demande_accompte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_id` int NOT NULL,
  `fait_a_id` int NOT NULL,
  `fonction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `accompte_chiffre` int NOT NULL,
  `accompte_lettre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `motif` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fait_le` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `demandeur_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FB509335ED5CA9E6` (`service_id`),
  KEY `IDX_FB509335FB75DE1A` (`fait_a_id`),
  KEY `IDX_FB50933595A6EE59` (`demandeur_id`),
  CONSTRAINT `FK_FB50933595A6EE59` FOREIGN KEY (`demandeur_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_FB509335ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  CONSTRAINT `FK_FB509335FB75DE1A` FOREIGN KEY (`fait_a_id`) REFERENCES `commune` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `demande_bulletin_salaire`;
CREATE TABLE `demande_bulletin_salaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_id` int NOT NULL,
  `fait_a_id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fonction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_du` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `date_au` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `motif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `recuperation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fait_le` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `demandeur_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2D3AB2E1ED5CA9E6` (`service_id`),
  KEY `IDX_2D3AB2E1FB75DE1A` (`fait_a_id`),
  KEY `IDX_2D3AB2E195A6EE59` (`demandeur_id`),
  CONSTRAINT `FK_2D3AB2E195A6EE59` FOREIGN KEY (`demandeur_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_2D3AB2E1ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  CONSTRAINT `FK_2D3AB2E1FB75DE1A` FOREIGN KEY (`fait_a_id`) REFERENCES `commune` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `question_pour`;
CREATE TABLE `question_pour` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `question_pour` (`id`, `label`) VALUES
(1,	'Formation'),
(2,	'Paie'),
(3,	'Dossier administratif'),
(4,	'Santé et conditions de travail'),
(5,	'Autre');

DROP TABLE IF EXISTS `question_rh`;
CREATE TABLE `question_rh` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_pour_id` int NOT NULL,
  `service_id` int NOT NULL,
  `telephone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fait_le` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `demandeur_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BEA7710EEF7E7C4D` (`question_pour_id`),
  KEY `IDX_BEA7710EED5CA9E6` (`service_id`),
  KEY `IDX_BEA7710E95A6EE59` (`demandeur_id`),
  CONSTRAINT `FK_BEA7710E95A6EE59` FOREIGN KEY (`demandeur_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_BEA7710EED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  CONSTRAINT `FK_BEA7710EEF7E7C4D` FOREIGN KEY (`question_pour_id`) REFERENCES `question_pour` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `rdv_avec`;
CREATE TABLE `rdv_avec` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rdv_avec` (`id`, `label`) VALUES
(1,	'DRH'),
(2,	'Service paie'),
(3,	'Service Formation'),
(4,	'Service Administratif'),
(5,	'Service Santé et Conditions de Travail');

DROP TABLE IF EXISTS `rendez_vous_rh`;
CREATE TABLE `rendez_vous_rh` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rdv_avec_id` int NOT NULL,
  `service_id` int NOT NULL,
  `telephone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fait_le` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `demandeur_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_316FF91BB81B09E` (`rdv_avec_id`),
  KEY `IDX_316FF91BED5CA9E6` (`service_id`),
  KEY `IDX_316FF91B95A6EE59` (`demandeur_id`),
  CONSTRAINT `FK_316FF91B95A6EE59` FOREIGN KEY (`demandeur_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_316FF91BB81B09E` FOREIGN KEY (`rdv_avec_id`) REFERENCES `rdv_avec` (`id`),
  CONSTRAINT `FK_316FF91BED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rendez_vous_rh` (`id`, `rdv_avec_id`, `service_id`, `telephone`, `email`, `message`, `fait_le`, `demandeur_id`) VALUES
(133,	1,	1,	'0125369854',	'deve@htoamil.fr',	'tre',	'2024-07-23',	916),
(134,	1,	1,	'0125369854',	'deve@htoamil.fr',	'tre',	'2024-07-23',	916),
(135,	1,	1,	'0125369854',	'deve@htoamil.fr',	'yuu',	'2024-07-23',	916),
(136,	1,	1,	'0125369854',	'deve@htoamil.fr',	'trest',	'2024-07-23',	916),
(137,	1,	1,	'0123654789',	'utilisateur1@gmail.com',	'test utilisateur 1',	'2024-07-23',	917);

DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email_secretariat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_responsable` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_secretariat_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service` (`id`, `email_secretariat`, `label`, `email_responsable`, `email_secretariat_2`) VALUES
(1,	'testdeveloppment@gmail.com',	'Cityker',	'testdeveloppment@gmail.com',	'testdeveloppment2@gmail.com'),
(2,	'testdeveloppment@outlook.fr',	'Direction Administrative et Financière',	'testdeveloppment@outlook.fr',	NULL),
(3,	'testdeveloppment@outlook.fr',	'Direction Commercial',	'testdeveloppment@outlook.fr',	NULL),
(4,	'testdeveloppment@outlook.fr',	'Direction des Transports',	'testdeveloppment@outlook.fr',	NULL),
(5,	'testdeveloppment@outlook.fr',	'Direction Développement',	'testdeveloppment@outlook.fr',	NULL),
(6,	'testdeveloppment@outlook.fr',	'Direction Générale',	'testdeveloppment@outlook.fr',	NULL),
(7,	'testdeveloppment@outlook.fr',	'Direction Ressources Humaines',	'testdeveloppment@outlook.fr',	NULL),
(8,	'testdeveloppment@outlook.fr',	'Direction Stationnement',	'testdeveloppment@outlook.fr',	NULL),
(9,	'testdeveloppment@outlook.fr',	'Direction Technique',	'testdeveloppment@outlook.fr',	NULL),
(10,	'testdeveloppment@outlook.fr',	'Service Administratif Exploitation Transports',	'testdeveloppment@outlook.fr',	NULL),
(11,	'testdeveloppment@outlook.fr',	'Service Contrôle',	'testdeveloppment@outlook.fr',	NULL),
(12,	'testdeveloppment@outlook.fr',	'Service Marketing',	'testdeveloppment@outlook.fr',	NULL),
(13,	'testdeveloppment@outlook.fr',	'Service Propreté Logistique et Maintenance',	'testdeveloppment@outlook.fr',	NULL),
(14,	'testdeveloppment@outlook.fr',	'Service Communication',	'testdeveloppment@outlook.fr',	NULL);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(916,	'admin',	'[\"ROLE_ADMIN\", \"ROLE_ACTIF\", \"ROLE_USER\"]',	'$2y$13$Ctu708ksOXq8fZBjZPMbuuAnj/oAc.U332x7vuGjpTcZPTqZ/rjBS'),
(917,	'utilisateur1',	'[\"ROLE_ACTIF\"]',	'$2y$13$tcZEPxLTfG5FdSU0wucphug9GgFd.inccMbEX2I0lsrDTOmW.TtOq'),
(918,	'utilisateur2',	'[]',	'$2y$13$zRzv/9cWHXZQicH7TOUcXeUhN5BWsh/MOUzhAjG7XE7rEVqKWMmMq');

-- 2024-07-23 05:14:33
