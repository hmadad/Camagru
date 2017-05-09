-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 09 Mai 2017 à 14:03
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.0

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
  `user_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `like_count` int(11) NOT NULL DEFAULT '0',
  `dislike_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `path`, `created_at`, `like_count`, `dislike_count`) VALUES
(45, 8, 'public/montages/8/AbmjNJhrov.jpg', '2017-05-09 15:46:19', 0, 0),
(44, 8, 'public/montages/8/j3wW9cZmp6.jpg', '2017-05-09 15:17:50', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `user_id`, `post_id`, `message`, `created_at`) VALUES
(1, 8, 44, 'Salut a tous !', '2017-05-09 15:40:51'),
(2, 8, 45, 'coucouuuu', '2017-05-09 15:46:41'),
(3, 8, 45, 'Bonjouuuur', '2017-05-09 15:47:09'),
(4, 8, 45, 'Nice', '2017-05-09 15:49:03');

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
-- Contenu de la table `votes`
--

INSERT INTO `votes` (`id`, `ref_id`, `ref`, `user_id`, `vote`, `created_at`) VALUES
(1, 5, 'articles', 8, 1, '2017-05-09 09:30:58'),
(2, 10, 'articles', 8, 1, '2017-05-09 10:02:32'),
(3, 9, 'articles', 8, -1, '2017-05-09 10:02:33'),
(4, 44, 'articles', 8, -1, '2017-05-09 13:17:57');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
