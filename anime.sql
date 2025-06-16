-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 16 juin 2025 à 09:13
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `anime`
--

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorId` int NOT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `authorId` (`authorId`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `authorId`, `createdAt`) VALUES
(117, 'Critique : Chainsaw Man', 'Chainsaw Man est un anime qui détonne avec son style sanglant et son humour noir. L’animation est incroyable et les personnages sont mémorables, notamment Denji et Power.', 7, '2025-04-15 14:30:00'),
(118, 'Top 5 des animés de l’hiver 2025', '1. Vinland Saga Saison 2\n2. Solo Leveling\n3. Blue Lock\n4. Frieren\n5. Bungo Stray Dogs\nUne saison très compétitive avec un retour impressionnant de plusieurs grosses licences.', 2, '2025-02-20 10:15:00'),
(119, 'Recommandation : Mob Psycho 100', 'Mob Psycho 100 est une perle de l’animation. L’animation est unique, l’histoire très humaine. À voir absolument si vous aimez les animés qui ont du cœur.', 3, '2025-03-01 09:00:00'),
(120, 'Critique : Jujutsu Kaisen Saison 2', 'Encore plus intense que la première saison. L’arc de Shibuya est une claque visuelle et émotionnelle. MAPPA ne déçoit pas.', 4, '2025-03-28 17:45:00'),
(121, 'Les animés incontournables pour débuter', 'Voici une sélection parfaite pour débuter : Death Note, Fullmetal Alchemist: Brotherhood, Demon Slayer, Your Name, et My Hero Academia. Tous très accessibles et impressionnants.', 5, '2025-01-10 12:00:00'),
(122, 'Pourquoi regarder Steins;Gate ?', 'Un thriller temporel fascinant, intelligent et émouvant. À ne pas manquer si vous aimez la science-fiction et les paradoxes temporels.', 6, '2025-04-02 19:25:00'),
(123, 'Top 3 des films du studio Ghibli à voir absolument', '1. Le Voyage de Chihiro\n2. Princesse Mononoké\n3. Mon Voisin Totoro\nDes chefs-d’œuvre intemporels, aussi beaux que profonds.', 7, '2025-02-14 08:45:00'),
(124, 'Analyse : le message caché de Neon Genesis Evangelion', 'Evangelion explore la psychologie humaine, le deuil et l’identité de façon unique. Une œuvre complexe qui mérite d’être revue plusieurs fois.', 8, '2025-03-22 21:10:00'),
(125, 'Annonce : la suite de Demon Slayer en production', 'Le prochain arc de Demon Slayer est officiellement en production. Prévu pour fin 2025 avec une qualité d’animation toujours assurée par ufotable.', 9, '2025-04-30 11:05:00'),
(126, 'Débat : Naruto ou One Piece ?', 'Depuis 20 ans, les fans se divisent. Naruto séduit par son émotion et ses combats épiques, tandis que One Piece brille par son univers vaste et sa narration longue mais maîtrisée.', 10, '2025-04-05 16:40:00'),
(127, 'À découvrir : Made in Abyss', 'Attention : anime aussi magnifique que dérangeant. Made in Abyss vous surprendra par la profondeur de son univers et la brutalité inattendue de son récit.', 8, '2025-03-11 13:20:00'),
(128, 'Critique : Attack on Titan - Final Season Part 3', 'Une conclusion haletante, fidèle à l’œuvre originale. La mise en scène de MAPPA est à couper le souffle. Un chef-d’œuvre moderne de la dark fantasy.', 12, '2025-04-27 20:10:00'),
(129, 'Vous avez aimé Death Note ? Essayez Code Geass', 'Code Geass combine stratégie, dilemmes moraux et rebondissements. Si vous avez aimé Light Yagami, vous adorerez Lelouch.', 13, '2025-02-26 18:55:00'),
(130, 'Animés d’horreur à ne pas regarder seul la nuit', 'Parmi les plus flippants : Another, Shiki, Yamishibai, et Higurashi. Âmes sensibles s’abstenir.', 14, '2025-01-31 23:15:00'),
(131, 'Top 7 des openings les plus iconiques', '1. Guren no Yumiya (Attack on Titan)\n2. Unravel (Tokyo Ghoul)\n3. A Cruel Angel’s Thesis (Evangelion)\n4. Again (FMA Brotherhood)\n5. Colors (Code Geass)\n6. Kaikai Kitan (JJK)\n7. Crossing Field (SAO)', 15, '2025-03-18 09:35:00'),
(132, 'Bleach : Thousand-Year Blood War – Partie 3 annoncée', 'La suite très attendue de Bleach TYBW est prévue pour automne 2025. Le studio Pierrot promet une animation toujours plus soignée.', 9, '2025-04-29 10:10:00'),
(133, 'Critique : Frieren – Au-delà du voyage', 'Poétique et contemplatif, Frieren aborde le deuil et le temps d’une manière rare en animation. Chaque épisode est une leçon de calme et de beauté.', 16, '2025-02-22 12:40:00');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userName` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `userName`, `email`, `password`, `is_admin`) VALUES
(1, 'ADMIN', 'admin.admin@gmail.admin', '$2y$10$wrVJgIE.0e8SH6mIiYWxsuxgKtfyKgkQZzUxeBM9ypRpLDAKDg.YG', 1),
(2, 'alice123', 'alice@example.com', '$2y$10$U2ZzzgTGiT2UMix0D3cEmeGPx0Jx1BF0LR6s.7Y3j/7dzVZbe3GR2', 0),
(3, 'bob_dev', 'bob@example.com', '$2y$10$M8aFJAH1UoB3pUQ7Ax3l8uYHk.DT8PBQ0MTNc4Zd0jToOStRMqC5G', 0),
(4, 'charlie92', 'charlie92@example.com', '$2y$10$fsS1FrEXh.VPb5Nli5EFeO43LytsLo/0nDKP2V4bJbcFe3cG8FoE6', 0),
(5, 'diana_b', 'diana.b@example.com', '$2y$10$C6w4QJ5Kt4eF1qYcN9sxleUg.6uFD3TbD8K0/M94HZv23knHkPf1e', 0),
(6, 'ethan_007', 'ethan007@example.com', '$2y$10$qEzvUoC1Vqz1o4MQyA.fru14BTCDKVRzJxANqKhcsZjLoRCj1qJSe', 0),
(7, 'frankie_g', 'frankie.g@example.com', '$2y$10$0XBzHDpYZKNoKklR8J8l9OB6/IctXxsyELeUIfAjXTRRBJ13mMXUO', 0),
(8, 'grace_hopper', 'grace.h@example.com', '$2y$10$3T7Fgz9A0EyVbZt4gk4RxOL/CqUce1SSbU1bm8xhY5PUcXz2RLtkO', 0),
(9, 'hugo_theboss', 'hugo@example.com', '$2y$10$W5/PG4HeCNzYKnqZdQXL2.NTrFBB0jGnhnhD2UvO6PmyW62zW2qJ6', 0),
(10, 'iris99', 'iris99@example.com', '$2y$10$ndogK46zvEl5oKkE/GoP8Ou84byy6V8G3fpvQmMGFVFL/nVY6V1cy', 0),
(12, 'Aymeric', 'aymeric@example.com', 'password1', 0),
(13, 'Claire', 'claire@example.com', 'password2', 0),
(14, 'Léo', 'leo@example.com', 'password3', 0),
(15, 'Justine', 'justine@example.com', 'password4', 0),
(16, 'Kévin', 'kevin@example.com', 'password5', 0),
(18, 'Thomas', 'thomas@example.com', 'password7', 0),
(19, 'Mélanie', 'melanie@example.com', 'password8', 0),
(20, 'Admin', 'admin@example.com', 'adminpass', 0),
(21, 'Lucas', 'lucas@example.com', 'password10', 0),
(22, 'Maya', 'maya@example.com', 'password11', 0),
(23, 'Adrien', 'adrien@example.com', 'password12', 0),
(24, 'Sophie', 'sophie@example.com', 'password13', 0),
(25, 'Jules', 'jules@example.com', 'password14', 0),
(26, 'Emma', 'emma@example.com', 'password15', 0),
(27, 'Camille', 'camille@example.com', 'password16', 0),
(28, 'Yanis', 'yanis@example.com', 'password17', 0),
(54, 'Romain', '1234@mail.com', '$2y$10$Thz2lQCp7sq.fcUCBYTNMuNVFNKYKwXhvxUwRpRXxD9Z/UEtWXdTa', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
