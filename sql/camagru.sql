-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 02 Mai 2017 à 13:21
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `camagru`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`) VALUES
(5, 'Admin', 'admin@camagru.fr', '$2y$10$/v1t2IChUuOjC1wRUFf3p.iOSdEj8pHd0cCGfA7d3leV94m4aVxmm', NULL, '2017-05-01 18:48:56', NULL, NULL),
(6, 'Hamzouz', 'lol@hotmail.fr', '$2y$10$/v1t2IChUuOjC1wRUFf3p.iOSdEj8pHd0cCGfA7d3leV94m4aVxmm', 'UjmPeH6O7X0EqE2lGHxbxHfZWfuVghVKVvwYvN61M4qWBxmp0x0LUJKEHT4V', NULL, NULL, NULL),
(7, 'Adminn', 'admin@cammagru.fr', '$2y$10$/v1t2IChUuOjC1wRUFf3p.iOSdEj8pHd0cCGfA7d3leV94m4aVxmm', 'b2XndWX1v6sfbxQJl1nxrMBk3fQPNI5UYgIxBIYxdq2CQwfAT4CaFmXT8AII', NULL, NULL, NULL),
(8, 'a', 'a@a.fr', '$2y$10$/v1t2IChUuOjC1wRUFf3p.iOSdEj8pHd0cCGfA7d3leV94m4aVxmm', NULL, '2017-05-02 08:05:02', 'oYJYQfVpHeW8C6J1xsbbA2XEF3VdAHJQvzGzKkWQryPwKLKarpfUrUE7iY1L', '2017-05-02 10:06:44');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
