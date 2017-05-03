-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 03 Mai 2017 à 15:58
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `camagru`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `like_count` int(11) NOT NULL DEFAULT '0',
  `dislike_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `path`, `created_at`, `like_count`, `dislike_count`) VALUES
(1, 'http://naruto.japflap.com/images/banner.jpg', '2017-05-03 00:00:00', 0, 0),
(2, 'http://coloriage.info/images/ccovers/1461700982manga-naruto-sasuke-277.jpg', '2017-05-03 11:00:00', 0, 0),
(3, 'https://i.ytimg.com/vi/OXmAXO4-6zs/maxresdefault.jpg', '2017-05-03 18:36:00', 0, 0),
(4, 'http://laguerche.com/image/coloriage-naruto-10.jpg', '2017-05-03 11:47:26', 0, 0),
(5, 'https://www.buzz2000.com/coloriage/naruto/coloriage-naruto-11188.jpg', '2017-05-24 20:33:00', 0, 0),
(6, 'http://www.allodessin.com/tuts/138/dessin-de-naruto-termine.gif', '2017-05-16 11:31:00', 0, 0),
(7, 'http://www.allodessin.com/tuts/153/dessin-de-kakashi-de-naruto-termine.gif', '2017-05-01 07:14:49', 0, 0),
(8, 'https://s-media-cache-ak0.pinimg.com/736x/17/d1/45/17d145f9e5ad27417c269e35b51dc9eb.jpg', '2017-05-02 11:47:26', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`) VALUES
(5, 'Admin', 'admin@camagru.fr', '$2y$10$/v1t2IChUuOjC1wRUFf3p.iOSdEj8pHd0cCGfA7d3leV94m4aVxmm', NULL, '2017-05-01 18:48:56', NULL, NULL),
(6, 'Hamzouz', 'lol@hotmail.fr', '$2y$10$/v1t2IChUuOjC1wRUFf3p.iOSdEj8pHd0cCGfA7d3leV94m4aVxmm', 'UjmPeH6O7X0EqE2lGHxbxHfZWfuVghVKVvwYvN61M4qWBxmp0x0LUJKEHT4V', NULL, NULL, NULL),
(7, 'Adminn', 'admin@cammagru.fr', '$2y$10$/v1t2IChUuOjC1wRUFf3p.iOSdEj8pHd0cCGfA7d3leV94m4aVxmm', 'b2XndWX1v6sfbxQJl1nxrMBk3fQPNI5UYgIxBIYxdq2CQwfAT4CaFmXT8AII', NULL, NULL, NULL),
(8, 'a', 'a@a.fr', '$2y$10$/v1t2IChUuOjC1wRUFf3p.iOSdEj8pHd0cCGfA7d3leV94m4aVxmm', NULL, '2017-05-02 08:05:02', 'oYJYQfVpHeW8C6J1xsbbA2XEF3VdAHJQvzGzKkWQryPwKLKarpfUrUE7iY1L', '2017-05-02 10:06:44');

-- --------------------------------------------------------

--
-- Structure de la table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `ref` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vote` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
