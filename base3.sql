-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 06 Août 2015 à 17:18
-- Version du serveur :  5.6.20
-- Version de PHP :  5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `base3`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
`id_categorie` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `id_parent` int(11) NOT NULL,
  `niveau` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom`, `description`, `id_parent`, `niveau`) VALUES
(1, 'catégorie1', '', 0, 1),
(2, 'catégorie2', '', 0, 1),
(3, 'catégorie3', '', 0, 1),
(4, 'catégorie4', '', 0, 1),
(5, 'sous catégorie 1', '', 1, 2),
(6, 'sous catégorie2', '', 1, 2),
(7, 'sous catégorie3', '', 1, 2),
(8, 'sous catégorie4', '', 1, 2),
(9, 'sous catégorie 1', '', 2, 2),
(10, 'sous catégorie2', '', 2, 2),
(11, 'sous catégorie 1', '', 3, 2),
(12, 'sous sous catégorie 1', '', 11, 3),
(13, 'sous catégorie 4', '', 4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
`id_produit` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `prix` float(10,2) NOT NULL,
  `prixht` float(10,2) NOT NULL,
  `reference` varchar(45) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `nom`, `id_categorie`, `prix`, `prixht`, `reference`, `description`) VALUES
(1, 'vxcvxc', 6, 10.20, 8.20, 'ref_9487', 'cdsdsfsdf'),
(2, 'mon produit 1', 5, 100.30, 80.64, 'ref_7197', 'description 1'),
(3, 'bfdgfdg', 11, 10.63, 8.55, 'ref_5223', 'gfdgdfgdf'),
(4, 'mon produit1', 10, 100.25, 80.60, 'ref_7229', 'fdfsdfdsf'),
(5, 'mon produit4', 2, 100.20, 80.56, 'ref_1518', 'dqsdqsdsqd'),
(6, 'dsfsdfsdf', 5, 100.87, 81.10, 'ref_9384', 'qsfdfsdfds');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id_user` int(11) NOT NULL,
  `user_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `user_email` varchar(45) COLLATE utf8_bin NOT NULL,
  `user_pass` varchar(230) COLLATE utf8_bin NOT NULL,
  `user_firstname` varchar(45) COLLATE utf8_bin NOT NULL,
  `user_lastname` varchar(45) COLLATE utf8_bin NOT NULL,
  `user_adress` varchar(100) COLLATE utf8_bin NOT NULL,
  `user_zipcode` varchar(5) COLLATE utf8_bin NOT NULL,
  `user_pic` varchar(45) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `user_name`, `user_email`, `user_pass`, `user_firstname`, `user_lastname`, `user_adress`, `user_zipcode`, `user_pic`, `last_login`, `date_created`, `date_updated`) VALUES
(1, 'amine142', 'amine142@hotmail.fr', '2b7e637fdcf11a5334d5bb87eab66e90', 'amine', 'el houba', 'rue paris', '75012', '1_avatar.jpg', '2015-08-06 15:15:04', '0000-00-00 00:00:00', '2015-08-05 23:45:43'),
(2, 'amine1425', 'amine1425@hotmail.fr', '79e0ea0a04288628a3bd32237ac451ba', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'amine1487', 'amine1427@hotmail.fr', '374b8a66ef97bc841347dc50e43154bd', '', '', '', '', '', '2015-08-05 13:33:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
 ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
 ADD PRIMARY KEY (`id_produit`), ADD KEY `id_category` (`id_categorie`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
