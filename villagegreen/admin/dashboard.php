<?php

//on se connecte à la BDD
include '../components/connect.php';

//lancement de la session
session_start();

// si l'admin est connecté le dashboard s'affiche
$admin_id = $_SESSION['admin_id'];

// s'il n'est pas connecté il est renvoyé sur le formulaire de login
if (!isset($admin_id)) {
    header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <!-- début section admin -->

    <section class="dashboard">

        <h1 class="heading">Tableau de bord</h1>

        <!-- affichage du nom de l'admin connecté -->
        <div class="box-container">
            <div class="box">
                <h3>Bienvenue !</h3>
                <p><?= $fetch_profile['nom']; ?></p>
                <a href="update_profile.php" class="option-btn">Modifier</a>
            </div>

            <!-- lien vers les utilisateurs inscrits sur le site -->
            <div class="box">
                <?php
                $select_users = $conn->prepare("SELECT * FROM `users`");
                $select_users->execute();
                //on retourne le nombre de lignes dans la table 'users' pour afficher les clients inscrits
                $number_of_users = $select_users->rowCount()
                ?>
                <!-- on affiche le nombre d'inscrits -->
                <h3><?= $number_of_users; ?></h3>
                <p>Les clients</p>
                <a href="users_accounts.php" class="option-btn">Clients</a>
            </div>

            <!-- lien vers les produits vendus sur le site -->
            <div class="box">
                <?php
                $select_products = $conn->prepare("SELECT * FROM `products`");
                $select_products->execute();
                $number_products = $select_products->rowCount()
                ?>
                <!-- on affiche le nombre de produits -->
                <h3><?= $number_products; ?></h3>
                <p>Les produits</p>
                <a href="products.php" class="option-btn">Produits</a>
            </div>

            <!-- lien vers toutes les commandes effectuées sur le site -->
            <div class="box">
                <?php
                $total_commandes = 0;
                $select_commandes = $conn->prepare("SELECT * FROM `orders`");
                $select_commandes->execute();
                while ($fetch_commandes = $select_commandes->fetch(PDO::FETCH_ASSOC)) {
                    $total_commandes += $fetch_commandes['prixTTC'];
                }
                ?>
                <!-- on affiche le nombre total de commandes effectuées -->
                <h3><?= $total_commandes; ?><span> €</span></h3>
                <p>Les commandes</p>
                <a href="placed_orders.php" class="option-btn">Commandes</a>
            </div>

            <!-- lien vers toutes les commandes en attente de paiement -->
            <div class="box">
                <?php
                $total_dues = 0;
                $select_dues = $conn->prepare("SELECT * FROM `orders`
                        WHERE statut_commande = ?");
                $select_dues->execute((['en attente']));
                while ($fetch_dues = $select_dues->fetch(PDO::FETCH_ASSOC)) {
                    $total_dues += $fetch_dues['prixTTC'];
                }
                ?>
                <!-- on affiche montant total des commandes à payer -->
                <h3><?= $total_dues; ?><span> €</span></h3>
                <p>Commandes dues</p>
                <a href="commandes_dues.php" class="option-btn">Dues</a>
            </div>

            <!-- lien vers toutes les commandes expédiées -->
            <div class="box">
                <?php
                $select_expediees = $conn->prepare("SELECT * FROM `orders`
                        WHERE statut_commande = ?");
                $select_expediees->execute((['expediees']));
                $number_expediees = $select_expediees->rowCount();
                ?>
                <!-- on affiche le nombre total de commandes expédiées -->
                <h3><?= $number_expediees; ?></h3>
                <p>Commandes expédiées</p>
                <a href="commandes_expediees.php" class="option-btn">Expédiées</a>
            </div>

            <!-- lien vers toutes les commandes annulées -->
            <div class="box">
                <?php
                $select_annulees = $conn->prepare("SELECT * FROM `orders`
                        WHERE statut_commande = ?");
                $select_annulees->execute((['annulees']));
                $number_annulees = $select_annulees->rowCount();
                ?>
                <!-- on affiche le nombre total de commandes annulées -->
                <h3><?= $number_annulees; ?></h3>
                <p>Commandes annulées</p>
                <a href="commandes_annulees.php" class="option-btn">Annulées</a>
            </div>
        </div>

    </section>

    <!-- fin section admin -->

    <script src="assets/js/admin_script.js"></script>

</body>

</html>