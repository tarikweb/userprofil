-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 06 Août 2015 à 16:03
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
(1, 'amine142', 'amine142@hotmail.fr', '2b7e637fdcf11a5334d5bb87eab66e90', 'amine', 'el houba', 'rue paris', '75012', '1_avatar.jpg', '2015-08-06 13:27:55', '0000-00-00 00:00:00', '2015-08-05 23:45:43'),
(2, 'amine1425', 'amine1425@hotmail.fr', '79e0ea0a04288628a3bd32237ac451ba', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'amine1487', 'amine1427@hotmail.fr', '374b8a66ef97bc841347dc50e43154bd', '', '', '', '', '', '2015-08-05 13:33:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
