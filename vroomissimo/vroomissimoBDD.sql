-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 02 nov. 2022 à 13:14
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
-- Base de données : `vroomissimo`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`admin_id`, `nom`, `email`, `password`, `type_user`) VALUES
(1, 'Chimot Cedric', 'cedom02830@gmail.fr', '81dc9bdb52d04dc20036dbd8313ed055', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `num_annonce` int(100) NOT NULL,
  `idvendeur` int(11) NOT NULL,
  `marque` varchar(255) NOT NULL,
  `modele` varchar(100) NOT NULL,
  `prix` int(100) NOT NULL,
  `km` int(100) NOT NULL,
  `annee_circul` varchar(100) NOT NULL,
  `annee_production` varchar(100) NOT NULL,
  `carburant` varchar(100) NOT NULL,
  `carrosserie` varchar(100) NOT NULL,
  `etat` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `contact_vendeur` varchar(100) NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`num_annonce`, `idvendeur`, `marque`, `modele`, `prix`, `km`, `annee_circul`, `annee_production`, `carburant`, `carrosserie`, `etat`, `description`, `contact_vendeur`, `image`) VALUES
(100, 2, 'Lamborghini', 'Lamborghini Huracàn', 102000, 54125, '06/2019', '2019', 'Essence', 'Coupé', 'Occasion', 'Lamborghini Huracàn, toutes options, parfait état, bleue et orange, pour les amateurs de vitesses', 'P. Parker', 'Lamborghini-Hurcán-STO.jpg'),
(101, 2, 'Peugeot', '308 GTI', 23000, 2686, '12-2021', '2021', 'Diesel', 'Berline', 'Occasion', 'Peugeot 308 GTI, boite manuelle, grise, 5 portes, toutes options', 'P. Parker', 'S7-modele--peugeot-308.jpg'),
(102, 1, 'Audi', 'Audi Q2 TFsi110', 47000, 18000, '08-2021', '2021', 'Diesel', 'Berline', 'Occasion', 'Audi Q2, boite manuelle, Blanche', 'M. Michel', 'Audi Q2 gorseli 12.jpg'),
(103, 1, 'Porsche', 'Porsche 911 S8', 42599, 14575, '12-2021', '2021', 'Essence', 'Coupé', 'Occasion', 'Porsche 911 toutes options, boite manuelle, tout confort', 'M. Michel', 'S8-modele--porsche-911-type-992.jpg'),
(104, 3, 'Ferrari', 'Ferrari F1', 12000000, 150000, '01-2021', '2021', 'Essence', 'F1', 'Occasion', 'Vends F1, bon état, peu servie, 0 confort, 1 personne seulement, boite automatique', 'M. Chimot', '2200120-f1-75th-anniversary-yellow-656x410.jpg'),
(105, 1, 'BMW', 'BMW I8 Coupé', 78000, 18000, '12-2021', '2021', 'Electrique', 'Coupé', 'Occasion', 'BMW I8 coupé, Blanche,  clignotant en option', 'M. Michel', 'bmw-i8-coupe-sport-hybride.jpg'),
(106, 1, 'BMW', 'BMW M4', 56990, 12500, '06-2021', '2021', 'Essence', 'Coupé', 'Occasion', 'BMW M4 bleue, 3 portes, peu servie, contrôle technique ok, toutes options', 'M. Michel', 'BMW-M4.jpg'),
(107, 1, 'BMW', 'BMW X1', 65000, 0, '10-2022', '2022', 'Essence', 'SUV', 'Neuf', 'BMW X1 toutes options, orange, 5 portes, idéal pour les longs trajets en voiture', 'M. Michel', 'bmw-x1.jpg'),
(108, 2, 'Renault', 'Twingo 2', 18599, 12500, '12-2021', '2021', 'Diesel', 'Berline', 'Occasion', 'Renault Twingo toutes options, neuves, boite automatique', 'Parker Peter', 'twingo2.jpeg'),
(109, 2, 'Volkswagen', 'Golf VII GTI 2.0', 25000, 18000, '06-2019', '2019', 'Diesel', 'Berline', 'Occasion', 'Vends Golf VII GTI, toutes options, boite manuelle', 'Parker Peter', 'Golf _VII_GTI.jpg'),
(110, 2, 'Audi', 'Audi A3', 59000, 0, '10-2022', '2022', 'Essence', 'SUV', 'Neuf', 'Audi A3, boite manuelle, Bleue, toutes options', 'Parker Peter', 'Audi_a3.jpg'),
(111, 3, 'Ford', 'Ford Mustang 2019', 185000, 0, '06/2019', '2019', 'Essence', 'Berline', 'Neuf', 'Ford Mustang, Neuve, boite automatique 10 vitesses, essence, 5 places', 'M. Chimot', 'Ford-Mustang-2019.jpg'),
(112, 3, 'Dacia', 'Sandero', 12990, 5978, '09/2021', '2021', 'Diesel', 'SUV', 'Occasion', 'Dacia Sandero, bleue, occasion, bon état, diesel, 5 portes', 'M. Chimot', 'Dacia_sandero.jpg'),
(113, 3, 'Ferrari', 'Ferrari F8 tribute', 232734, 25000, '06/2019', '2019', 'Essence', 'Coupé', 'Occasion', '3.9 Coupé 720ch DCT, puissance 720 ch / 530 kW, boite automatique ', 'M. Chimot', '01-ferrari-f8-tributoredimensionner.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int(100) NOT NULL,
  `num_commande` int(11) DEFAULT NULL,
  `idvendeur` int(11) DEFAULT NULL,
  `client_id` int(100) NOT NULL,
  `nom_vendeur` varchar(50) NOT NULL,
  `nom_client` varchar(100) NOT NULL,
  `note` int(11) NOT NULL,
  `avis` varchar(500) NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `num_commande`, `idvendeur`, `client_id`, `nom_vendeur`, `nom_client`, `note`, `avis`, `image`) VALUES
(1, 4, 1, 1, 'Garage Michel', 'Stark Tony', 5, 'Excellente affaire, bon vendeur. Merci pour tout et à bientôt ;)', '2019-03-27.jpg'),
(3, 7, 2, 3, 'Garage Parker', 'Wayne Bruce', 5, 'Excellent vendeur, au top. Livraison rapide et nickel, merci ;)', 'pic-3.png'),
(4, 1, 1, 1, 'Garage Michel', 'Stark Tony', 4, 'Livraison un peu lente mais bon contact. Merci pour tout ;)', '2019-03-27.jpg'),
(6, 2, 1, 1, 'Garage Michel', 'Stark Tony', 4, 'Bonne vente, communication moyenne. Je repasserai pour une nouvelle commande ;)', '2019-03-27.jpg'),
(7, 8, 3, 3, 'Chimot Automobiles', 'Wayne Bruce', 5, 'Au top, super voiture, livraison rapide, merci pour tout à bientôt ;)', 'pic-3.png'),
(8, 9, 2, 3, 'Garage Parker', 'Wayne Bruce', 4, 'Pas la voiture de mes rêves malheureusement, état moyen, dommage.', 'pic-3.png');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `idclient` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `cp` varchar(100) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `pays` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type_user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`idclient`, `nom`, `adresse`, `cp`, `ville`, `pays`, `email`, `password`, `type_user`) VALUES
(1, 'Stark Tony', 'rue des Héros', '950633', 'Rome', 'Italie', 'ironman@hotmail.fr', '81dc9bdb52d04dc20036dbd8313ed055', 'client'),
(2, 'Rogers Steve', 'rue de la Paix', '75075', 'Berlin', 'Allemagne', 'captain@yahoo.fr', '81dc9bdb52d04dc20036dbd8313ed055', 'client'),
(3, 'Wayne Bruce', '10 rue des Espions', '75000', 'Paris', 'France', 'batman@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'client');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(100) NOT NULL,
  `date_commande` varchar(50) NOT NULL,
  `client_id` int(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `telephone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `paiement` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `cp` varchar(100) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `pays` varchar(100) NOT NULL,
  `total_articles` varchar(1000) NOT NULL,
  `prix_total` int(100) NOT NULL,
  `statut_paiement` varchar(20) NOT NULL DEFAULT 'en attente',
  `vendeur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `date_commande`, `client_id`, `nom`, `telephone`, `email`, `paiement`, `adresse`, `cp`, `ville`, `pays`, `total_articles`, `prix_total`, `statut_paiement`, `vendeur_id`) VALUES
(1, '27-Oct-2022', 1, 'Stark Tony', '1234376679', 'ironman@hotmail.fr', 'Paiement à la livraison', 'rue des Héros', '950633', 'Rome', 'Italie', 'Lamborghini, Lamborghini Huracàn', 102000, 'completee', 2),
(2, '27-Oct-2022', 1, 'Stark Tony', '012564803', 'ironman@hotmail.fr', 'Virement bancaire', 'rue des Héros', '950633', 'Rome', 'Italie', 'Porsche, Porsche 911 S8', 42599, 'completee', 1),
(3, '27-Oct-2022', 1, 'Stark Tony', '1234376679', 'ironman@hotmail.fr', 'Paiement à la livraison', 'rue des Héros', '950633', 'Rome', 'Italie', 'Peugeot, 308 GTI', 23000, 'en attente', 2),
(4, '28-Oct-2022', 1, 'Stark Tony', '1234376679', 'ironman@hotmail.fr', 'Virement bancaire', 'rue des Héros', '950633', 'Rome', 'Italie', 'BMW, BMW M4', 56990, 'completee', 1),
(5, '28-Oct-2022', 1, 'Stark Tony', '1234376679', 'ironman@hotmail.fr', 'Paiement à la livraison', 'rue des Héros', '950633', 'Rome', 'Italie', 'BMW, BMW I8 Coupé', 78000, 'en attente', 1),
(6, '30-Oct-2022', 2, 'Rogers Steve', '1146890071', 'captain@yahoo.com', 'Paiement à la livraison', 'rue de la Paix', '75075', 'Berlin', 'Allemagne', 'Renault, Twingo 2', 18599, 'en attente', 1),
(7, '30-Oct-2022', 3, 'Wayne Bruce', '1146890071', 'batman@gmail.com', 'Carte bancaire', '10 rue des Espions', '75000', 'Paris', 'France', 'Lamborghini, Lamborghini Huracàn', 102000, 'completee', 2),
(8, '30-Oct-2022', 3, 'Wayne Bruce', '1146890071', 'batman@gmail.com', 'Carte bancaire', '10 rue des Espions', '75000', 'Paris', 'France', 'Ford, Ford Mustang 2019', 185000, 'completee', 3),
(9, '01-Nov-2022', 3, 'Wayne Bruce', '1146890071', 'batman@gmail.com', 'Carte bancaire', '10 rue des Espions', '75000', 'Paris', 'France', 'Peugeot, 308 GTI', 23000, 'completee', 3);

-- --------------------------------------------------------

--
-- Structure de la table `contact_commandes`
--

CREATE TABLE `contact_commandes` (
  `id` int(100) NOT NULL,
  `num_commande` int(11) DEFAULT NULL,
  `idvendeur` int(11) DEFAULT NULL,
  `contact` varchar(100) NOT NULL,
  `client_id` int(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contact_commandes`
--

INSERT INTO `contact_commandes` (`id`, `num_commande`, `idvendeur`, `contact`, `client_id`, `nom`, `email`, `telephone`, `message`) VALUES
(1, 2, 1, 'M. Michel', 1, 'Stark Tony', 'ironman@hotmail.fr', '1234376679', "Bonjour, je viens d\'envoyer le paiement. J\'aimerai savoir si vous l\'avez reçu et quand je serai livré ?\n\nMerci.");

-- --------------------------------------------------------

--
-- Structure de la table `inscrits`
--

CREATE TABLE `inscrits` (
  `idinscrit` int(50) NOT NULL,
  `idadmin` int(50) DEFAULT NULL,
  `idvendeur` int(50) DEFAULT NULL,
  `idclient` int(50) DEFAULT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `inscrits`
--

INSERT INTO `inscrits` (`idinscrit`, `idadmin`, `idvendeur`, `idclient`, `nom`, `email`, `role`) VALUES
(1, 1, NULL, NULL, 'Chimot Cedric', 'cedom02830@gmail.fr', 'admin'),
(2, NULL, 1, NULL, 'Garage Michel', 'gmichel@yahoo.com', 'vendeur'),
(3, NULL, 2, NULL, 'Garage Parker', 'spidey@yahoo.fr', 'vendeur'),
(4, NULL, NULL, 1, 'Stark Tony', 'ironman@hotmail.com', 'client');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `num_annonce` int(11) NOT NULL,
  `idvendeur` int(11) DEFAULT NULL,
  `contact` varchar(100) NOT NULL,
  `client_id` int(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `num_annonce` int(100) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `marque` varchar(100) NOT NULL,
  `modele` varchar(100) NOT NULL,
  `prix` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `vendeur`
--

CREATE TABLE `vendeur` (
  `idvendeur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `cp` varchar(100) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `pays` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type_user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `vendeur`
--

INSERT INTO `vendeur` (`idvendeur`, `nom`, `adresse`, `cp`, `ville`, `pays`, `email`, `password`, `type_user`) VALUES
(1, 'Garage Michel', '10 rue des Espions', '75075', 'Paris', 'France', 'gmichel@hotmail.fr', '81dc9bdb52d04dc20036dbd8313ed055', 'vendeur'),
(2, 'Garage Parker', 'rue des Héros', '75010', 'Berlin', 'Allemagne', 'spidey@yahoo.fr', '81dc9bdb52d04dc20036dbd8313ed055', 'vendeur'),
(3, 'Chimot Automobiles', '10 rue de la BD', '75000', 'Paris', 'France', 'c_autodu75@yahoo.fr', '81dc9bdb52d04dc20036dbd8313ed055', 'vendeur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`num_annonce`),
  ADD KEY `idvendeur` (`idvendeur`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num_commande` (`num_commande`),
  ADD KEY `idvendeur` (`idvendeur`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idclient`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `vendeur_id` (`vendeur_id`);

--
-- Index pour la table `contact_commandes`
--
ALTER TABLE `contact_commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num_commande` (`num_commande`),
  ADD KEY `idvendeur` (`idvendeur`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `inscrits`
--
ALTER TABLE `inscrits`
  ADD PRIMARY KEY (`idinscrit`),
  ADD KEY `idadmin` (`idadmin`),
  ADD KEY `idvendeur` (`idvendeur`),
  ADD KEY `idclient` (`idclient`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num_annonce` (`num_annonce`),
  ADD KEY `idvendeur` (`idvendeur`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `num_annonce` (`num_annonce`);

--
-- Index pour la table `vendeur`
--
ALTER TABLE `vendeur`
  ADD PRIMARY KEY (`idvendeur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `idclient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `contact_commandes`
--
ALTER TABLE `contact_commandes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `inscrits`
--
ALTER TABLE `inscrits`
  MODIFY `idinscrit` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `vendeur`
--
ALTER TABLE `vendeur`
  MODIFY `idvendeur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`idvendeur`) REFERENCES `vendeur` (`idvendeur`);

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`num_commande`) REFERENCES `commandes` (`id`),
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`idvendeur`) REFERENCES `vendeur` (`idvendeur`),
  ADD CONSTRAINT `avis_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `client` (`idclient`);

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`idclient`),
  ADD CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`vendeur_id`) REFERENCES `vendeur` (`idvendeur`);

--
-- Contraintes pour la table `contact_commandes`
--
ALTER TABLE `contact_commandes`
  ADD CONSTRAINT `contact_commandes_ibfk_1` FOREIGN KEY (`num_commande`) REFERENCES `commandes` (`id`),
  ADD CONSTRAINT `contact_commandes_ibfk_2` FOREIGN KEY (`idvendeur`) REFERENCES `vendeur` (`idvendeur`),
  ADD CONSTRAINT `contact_commandes_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `client` (`idclient`);

--
-- Contraintes pour la table `inscrits`
--
ALTER TABLE `inscrits`
  ADD CONSTRAINT `inscrits_ibfk_1` FOREIGN KEY (`idadmin`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `inscrits_ibfk_2` FOREIGN KEY (`idvendeur`) REFERENCES `vendeur` (`idvendeur`),
  ADD CONSTRAINT `inscrits_ibfk_3` FOREIGN KEY (`idclient`) REFERENCES `client` (`idclient`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`num_annonce`) REFERENCES `annonce` (`num_annonce`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`idvendeur`) REFERENCES `vendeur` (`idvendeur`),
  ADD CONSTRAINT `message_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `client` (`idclient`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`idclient`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`num_annonce`) REFERENCES `annonce` (`num_annonce`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Liste des données pour la base SQL sur PHPmyadmin

-- CREATE TABLE `annonce` (
--   `num_annonce` int(100) NOT NULL,
--   `idvendeur` int(11) NOT NULL,
--   `marque` varchar(255) NOT NULL,
--   `modele` varchar(100) NOT NULL,
--   `prix` int(100) NOT NULL,
--   `km` int(100) NOT NULL,
--   `annee_circul` varchar(100) NOT NULL,
--   `annee_production` varchar(100) NOT NULL,
--   `carburant` varchar(100) NOT NULL,
--   `carrosserie` varchar(100) NOT NULL,
--   `etat` varchar(100) NOT NULL,
--   `description` longtext NOT NULL,
--   `contact_vendeur` varchar(100) NOT NULL,
--   `image` varchar(1000) NOT NULL,
--    PRIMARY KEY (`num_annonce`),
--    FOREIGN KEY (`idvendeur`) REFERENCES `vendeur` (`idvendeur`)
-- );

-- CREATE TABLE `commandes` (
--   `id` int(100) AUTO_INCREMENT NOT NULL,
--   `client_id` int(100) NOT NULL,
--   `nom` varchar(100) NOT NULL,
--   `telephone` varchar(100) NOT NULL,
--   `email` varchar(100) NOT NULL,
--   `paiement` varchar(100) NOT NULL,
--   `adresse` varchar(100) NOT NULL,
--   `cp` varchar(100) NOT NULL,
--   `ville` varchar(100) NOT NULL,
--   `pays` varchar(100) NOT NULL,
--   `total_articles` varchar(1000) NOT NULL,
--   `prix_total` int(100) NOT NULL,
--   `date_commande` varchar(50) NOT NULL,
--   `statut_paiement` varchar(20) NOT NULL DEFAULT 'en attente',
--   `vendeur_id` int(11) NOT NULL,
--    PRIMARY KEY (`id`),
--    FOREIGN KEY (`client_id`) REFERENCES `client` (`idclient`),
--    FOREIGN KEY (`vendeur_id`) REFERENCES `vendeur` (`idvendeur`)
-- );

-- CREATE TABLE `message` (
--   `id` int(100) NOT NULL AUTO_INCREMENT,
--   `num_annonce` int(11) DEFAULT NULL,
--   `idvendeur` int(11) DEFAULT NULL,
--   `contact` varchar(100) NOT NULL,
--   `client_id` int(100) NOT NULL,
--   `nom` varchar(100) NOT NULL,
--   `email` varchar(100) NOT NULL,
--   `telephone` varchar(12) NOT NULL,
--   `message` varchar(500) NOT NULL,
--   PRIMARY KEY (`id`),
--   FOREIGN KEY (`num_annonce`) REFERENCES `annonce` (`num_annonce`),
--   FOREIGN KEY (`idvendeur`) REFERENCES `vendeur` (`idvendeur`),
--   FOREIGN KEY (`client_id`) REFERENCES `client` (`idclient`)
-- );

-- CREATE TABLE `panier` (
--   `id` int(11) NOT NULL AUTO_INCREMENT,
--   `client_id` int(11) NOT NULL,
--   `num_annonce` int(100) DEFAULT NULL,
--   `marque` varchar(100) NOT NULL,
--   `modele` varchar(100) NOT NULL,
--   `prix` varchar(100) NOT NULL,
--   `image` varchar(100) NOT NULL,
--   PRIMARY KEY (`id`),
--   FOREIGN KEY (`client_id`) REFERENCES `client` (`idclient`),
--   FOREIGN KEY (`num_annonce`) REFERENCES `annonce` (`num_annonce`)
-- );

-- CREATE TABLE `client` (
--   `idclient` int(11) NOT NULL AUTO_INCREMENT,
--   `nom` varchar(100) NOT NULL,
--   `adresse` varchar(100) NOT NULL,
--   `cp` varchar(100) NOT NULL,
--   `ville` varchar(100) NOT NULL,
--   `pays` varchar(100) NOT NULL,
--   `email` varchar(100) NOT NULL,
--   `password` varchar(100) NOT NULL,
--   `type_user` varchar(100) NOT NULL,
--   PRIMARY KEY (`idclient`)
-- );

-- CREATE TABLE `vendeur` (
--   `idvendeur` int(11) NOT NULL AUTO_INCREMENT,
--   `nom` varchar(100) NOT NULL,
--   `adresse` varchar(100) NOT NULL,
--   `cp` varchar(100) NOT NULL,
--   `ville` varchar(100) NOT NULL,
--   `pays` varchar(100) NOT NULL,
--   `email` varchar(100) NOT NULL,
--   `password` varchar(100) NOT NULL,
--   `type_user` varchar(100) NOT NULL,
--   PRIMARY KEY (`idvendeur`)
-- );

-- CREATE TABLE `admin` (
--   `admin_id` int(11) NOT NULL AUTO_INCREMENT,
--   `nom` varchar(50) NOT NULL,
--   `email` varchar(50) NOT NULL,
--   `password` varchar(50) NOT NULL,
--   `type_user` varchar(50) NOT NULL,
--   PRIMARY KEY (`admin_id`)
-- );

-- CREATE TABLE `inscrits` (
--   `idinscrit` int(50) NOT NULL AUTO_INCREMENT,
--   `idadmin` int(50) DEFAULT NULL,
--   `idvendeur` int(50) DEFAULT NULL,
--   `idclient` int(50) DEFAULT NULL,
--   `nom` varchar(50) NOT NULL,
--   `email` varchar(50) NOT NULL,
--   `role` varchar(50) NOT NULL,
--   PRIMARY KEY (`idinscrit`),
--   FOREIGN KEY (`idadmin`) REFERENCES `admin` (`admin_id`),
--   FOREIGN KEY (`idvendeur`) REFERENCES `vendeur` (`idvendeur`),
--   FOREIGN KEY (`idclient`) REFERENCES `client` (`idclient`)
-- );

-- CREATE TABLE `contact_commandes` (
--   `id` int(100) NOT NULL AUTO_INCREMENT,
--   `num_commande` int(11) DEFAULT NULL,
--   `idvendeur` int(11) DEFAULT NULL,
--   `contact` varchar(100) NOT NULL,
--   `client_id` int(100) NOT NULL,
--   `nom` varchar(100) NOT NULL,
--   `email` varchar(100) NOT NULL,
--   `telephone` varchar(12) NOT NULL,
--   `message` varchar(500) NOT NULL,
--   PRIMARY KEY (`id`),
--   FOREIGN KEY (`num_commande`) REFERENCES `commandes` (`id`),
--   FOREIGN KEY (`idvendeur`) REFERENCES `vendeur` (`idvendeur`),
--   FOREIGN KEY (`client_id`) REFERENCES `client` (`idclient`)
-- );

-- CREATE TABLE `avis` (
--   `id` int(100) NOT NULL AUTO_INCREMENT,
--   `num_commande` int(11) DEFAULT NULL,
--   `idvendeur` int(11) DEFAULT NULL,
--   `client_id` int(100) NOT NULL,
--   `nom_vendeur` varchar(50) NOT NULL,
--   `nom_client` varchar(100) NOT NULL,
--   `note` int(11) NOT NULL,
--   `avis` varchar(500) NOT NULL,
--   `image` varchar(1000) NOT NULL,
--   PRIMARY KEY (`id`),
--   FOREIGN KEY (`num_commande`) REFERENCES `commandes` (`id`),
--   FOREIGN KEY (`idvendeur`) REFERENCES `vendeur` (`idvendeur`),
--   FOREIGN KEY (`client_id`) REFERENCES `client` (`idclient`)
-- );