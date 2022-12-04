-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 04 déc. 2022 à 17:57
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `v_green`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `nom`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(2, 'Ced02830', '814f187e87b68f296deed3128d5d32ed0ac7b057');

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `prix` int(10) NOT NULL,
  `quantite` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `inscrire`
--

CREATE TABLE `inscrire` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `inscrire`
--

INSERT INTO `inscrire` (`id`, `admin_id`, `user_id`, `role`) VALUES
(1, 1, NULL, 'Admin'),
(2, NULL, 1, 'User'),
(3, NULL, 2, 'User'),
(4, 2, NULL, 'Admin'),
(5, NULL, 3, 'User'),
(6, NULL, 4, 'User'),
(7, NULL, 5, 'User'),
(8, NULL, 6, 'User');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `nom`, `prenom`, `email`, `telephone`, `message`) VALUES
(1, 1, 'Chimot', 'Cedric', 'cedric@gmail.fr', '1146890071', 'Coucou me voilou ;)');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` varchar(50) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `total_produits` varchar(1000) NOT NULL,
  `prixTTC` int(100) NOT NULL,
  `date_commande` date NOT NULL DEFAULT current_timestamp(),
  `statut_commande` varchar(20) NOT NULL DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `nom`, `prenom`, `telephone`, `adresse`, `cp`, `ville`, `total_produits`, `prixTTC`, `date_commande`, `statut_commande`) VALUES
(1, 2, 'Stark', 'Tony', '1146890071', '10 rue des Espions', '75075', 'Paris', 'Kawai ES-8 B (1256 x 1) - Guitare (85 x 1) - Startone SAS-75 Alto (620 x 1) - ', 1961, '2022-12-02', 'retard'),
(2, 3, 'Rogers', 'Steve', '727897220', 'rue de la Paix', '75075', 'Paris', 'Trompette (299 x 1) - Sono (599 x 1) - Harley Benton D-120CE BK (79 x 1) - ', 977, '2022-12-04', 'annulee'),
(3, 3, 'Rogers', 'Steve', '727897220', 'rue de la Paix', '75075', 'Paris', 'Trompette (299 x 1) - Batterie (849 x 1) - Kawai ES-8 B (1256 x 1) - ', 2404, '2022-12-04', 'terminee'),
(4, 1, 'Chimot', 'Cédric', '1146890071', 'rue des Héros', '75075', 'Paris', 'Guitare (85 x 1) - Micro (259 x 1) - Case (310 x 1) - ', 654, '2022-12-04', 'terminee'),
(5, 1, 'Chimot', 'Cédric', '1146890071', 'rue des Héros', '75075', 'Paris', 'Piano (2259 x 1) - Trompette (299 x 1) - ', 2558, '2022-12-04', 'terminee'),
(6, 4, 'Lucky', 'Luke', '012564803', 'rue de la BD', '85075', 'Paris', 'Guitare (79 x 1) - Harley Benton D-120CE BK (79 x 1) - ', 158, '2022-12-04', 'annulee'),
(7, 5, 'Blake', 'Francis', '727897220', '10 rue de la BD', '950633', 'Bruxelles', 'Piano (2259 x 1) - Startone SAS-75 Alto (620 x 1) - ', 2879, '2022-12-04', 'terminee'),
(8, 2, 'Stark', 'Tony', '1234376679', '10 rue des Espions', '75075', 'Paris', 'Harley Benton D-120CE BK (75 x 1) - Cables (159 x 1) - Batterie (849 x 1) - ', 1083, '2022-12-04', 'en attente'),
(9, 6, 'Wayne Bruce', 'Bruce', '012564803', 'rue des Héros', '75075', 'Paris', 'Batterie (849 x 1) - Guitare (79 x 1) - Sono (599 x 1) - Startone SAS-75 Alto (620 x 1) - ', 2147, '2022-12-04', 'terminee'),
(10, 6, 'Wayne', 'Bruce', '012564803', 'rue des Héros', '75075', 'Paris', 'Harley Benton D-120CE BK (79 x 1) - Kawai ES-8 B (1256 x 1) - Micro (259 x 1) - ', 1594, '2022-12-04', 'annulee');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `prix` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `categorie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `libelle`, `details`, `prix`, `image`, `categorie`) VALUES
(1, 'Guitare', 'Guitare', 79, 'guitare.png', 'Guitare'),
(2, 'Batterie', 'Batterie', 849, 'batterie.png', 'Batterie'),
(3, 'Micro', 'Micro', 259, 'micro.png', 'Micro'),
(4, 'Piano', 'Piano', 2259, 'piano.png', 'Piano'),
(5, 'Cables', 'Cables', 159, 'cable.png', 'Accessoires'),
(6, 'Trompette', 'Trompette', 299, 'saxo.png', 'Instrument à vent'),
(7, 'Sono', 'Sono', 599, 'sono.png', 'Sono'),
(8, 'Case', 'Case', 310, 'cases.png', 'Case'),
(9, 'Startone SAS-75 Alto', 'Saxo', 620, 'top_ventes_saxo.png', 'Instrument à vent'),
(10, 'Harley Benton D-120CE BK', 'Guitare', 79, 'top_ventes_guitare.png', 'Guitare'),
(11, 'Kawai ES-8 B', 'Piano', 1256, 'top_ventes_piano.png', 'Piano');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`) VALUES
(1, 'Ced02830', 'cedric@gmail.fr', '33e27aabe23a13f3388754a4d7f3ee764d64a711'),
(2, 'Ironman', 'stark@gmail.fr', '18db1570a60d78c70c1aab7b825375fa3a74194d'),
(3, 'Captain02', 'captain02@gmail.fr', 'f1c2f92cae64aef47cbc861ad1bd200fb9d3a361'),
(4, 'LuckyL.', 'luckyluke@gmail.fr', 'f799bf2c2861d2a0742310952b9677ab12ee1d22'),
(5, 'BlakeF.', 'blake.f@gmail.fr', 'f9ef14c8e41a1000549a6418430baa31d4fd3607'),
(6, 'Batman', 'batman@gmail.fr', '9441924c8e7dfbce2372908ede07dce3f5642d91');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `panier_ibfk_2` (`pid`),
  ADD KEY `panier_ibfk_1` (`user_id`);

--
-- Index pour la table `inscrire`
--
ALTER TABLE `inscrire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inscrire_ibfk_1` (`admin_id`),
  ADD KEY `inscrire_ibfk_2` (`user_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `inscrire`
--
ALTER TABLE `inscrire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `products` (`id`);

--
-- Contraintes pour la table `inscrire`
--
ALTER TABLE `inscrire`
  ADD CONSTRAINT `inscrire_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `inscrire_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
