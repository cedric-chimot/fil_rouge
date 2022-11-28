<?php

//connexion à la base de données
include 'admins/config.php';

//ouverture de la session
session_start();

$vendeur_id = $_SESSION['vendeur_id'];

//si la personne connectée n'est pas un admin, on la renvoie vers la page login
if (!isset($vendeur_id)) {
    header('location:login_vendeur.php');
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admins/css/admin.css">
    <title>Tableau de bord</title>
</head>

<body>

    <?php include 'vendeur_header.php'; ?>

    <!-- admin tableau de bord début -->

    <section class="dashboard">

        <h1 class="titre">Tableau de bord</h1>

        <div class="box-container">

            <div class="box">
                <?php
                //affichage des commandes en attente
                $total_dus = 0;
                //connexion à la table dans la BDD en selectionnant la colonne 'statut_paiement',
                //avec le statut de paiement 'en attente'
                $select_dus = mysqli_query($con, "SELECT prix_total FROM `commandes`
                    WHERE statut_paiement = 'en attente' AND vendeur_id = '$vendeur_id'")
                    //'or exit' Affiche un message d'erreur et termine le script courant
                    or exit('Echec de la requête');
                    if(mysqli_num_rows($select_dus) > 0){
                        while($fetch_dus = mysqli_fetch_assoc($select_dus)){
                            $prix_total = $fetch_dus['prix_total'];
                            $total_dus += $prix_total;
                        };
                    };
                ?>
                <!-- On renvoie le montant des commandes avec paiement en attente -->
                <h3><?php echo $total_dus; ?> €</h3>
                <p>Paiement non reçu</p>
                <a href="vendeur_dues.php" class="btn">Commandes dues</a>
            </div>

            <div class="box">
                <?php
                //même chose que précédemment en allant chercher cette fois les commandes complétées
                $total_completee = 0;
                $select_completee = mysqli_query($con, "SELECT prix_total FROM `commandes`
                    WHERE statut_paiement = 'completee' AND vendeur_id = '$vendeur_id'")
                    or exit('Echec de la requête');
                if(mysqli_num_rows($select_completee) > 0){
                    while($fetch_completee = mysqli_fetch_assoc($select_completee)){
                        $prix_total = $fetch_completee['prix_total'];
                        $total_completee += $prix_total;
                    };
                };
                ?>
                <h3><?php echo $total_completee; ?> €</h3>
                <p>Commandes payées</p>
                <a href="vendeur_reglee.php" class="btn">Commandes payées</a>
            </div>

            <div class="box">
                <?php
                //même chose que précédemment en allant chercher la totalité des commandes
                $select_commandes = mysqli_query($con, "SELECT * FROM `commandes`
                    WHERE vendeur_id = '$vendeur_id'")
                    or exit('Echec de la requête');
                $nb_commandes = mysqli_num_rows($select_commandes);
                ?>
                <h3><?php echo $nb_commandes; ?></h3>
                <p>Commandes passées</p>
                <a href="vendeur_commandes.php" class="btn">Total commandes</a>
            </div>

            <div class="box">
                <?php
                //afficher le nombre total d'annonces publiées
                    $select_annonces = mysqli_query($con, "SELECT * FROM `annonce`
                        WHERE idvendeur = '$vendeur_id'")
                        or exit('Echec de la requête');
                    $nb_annonces = mysqli_num_rows($select_annonces);
                ?>
                <h3><?php echo $nb_annonces; ?></h3>
                <p>Nombre d'annonces</p>
                <a href="vendeur_annonce.php" class="btn">Voir les annonces</a>
            </div>

            <div class="box">
                <?php
                //afficher le nombre de clients
                    $select_clients = mysqli_query($con, "SELECT * FROM `client`
                        WHERE type_user = 'client'")
                        or exit('Echec de la requête');
                    $nb_clients = mysqli_num_rows($select_clients);
                ?>
                <h3><?php echo $nb_clients; ?></h3>
                <p>Nombre de clients</p>
                <a href="vendeur_client.php" class="btn">Voir les clients</a>
            </div>

            <div class="box">
                <?php
                //afficher tous les messages
                    $select_messages = mysqli_query($con, "SELECT * FROM `message`
                        WHERE idvendeur = '$vendeur_id'")
                        or exit('Echec de la requête');
                    $nb_messages = mysqli_num_rows($select_messages);
                ?>
                <h3><?php echo $nb_messages; ?></h3>
                <p>Nombre de messages</p>
                <a href="vendeur_contact.php" class="btn">Messages reçus</a>
            </div>

            <div class="box">
                <?php
                //afficher tous les messages
                    $select_messages = mysqli_query($con, "SELECT * FROM `contact_commandes`
                        WHERE idvendeur = '$vendeur_id'")
                        or exit('Echec de la requête');
                    $nb_messages = mysqli_num_rows($select_messages);
                ?>
                <h3><?php echo $nb_messages; ?></h3>
                <p>Demandes clients</p>
                <a href="contact_commandes.php" class="btn">Demandes reçues</a>
            </div>

            <div class="box">
                <?php
                //afficher tous les messages
                    $select_avis = mysqli_query($con, "SELECT * FROM `avis`
                        WHERE idvendeur = '$vendeur_id'")
                        or exit('Echec de la requête');
                    $nb_avis = mysqli_num_rows($select_avis);
                ?>
                <h3><?php echo $nb_avis; ?></h3>
                <p>Notes des clients</p>
                <a href="avis_client.php" class="btn">Avis clients</a>
            </div>

        </div>

    </section>

    <!-- admin tableau de bord fin -->

    <script src="admins/js/admin_script.js"></script>

</body>

</html>