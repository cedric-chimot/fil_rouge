<?php

//on se connecte à la BDD
include '../components/connect.php';

//lancement de la session
session_start();

// si l'admin est connecté le dashboard s'affiche
$admin_id = $_SESSION['admin_id'];

// s'il n'est pas connecté il est renvoyé sur le formulaire de login
if(isset($admin_id)){
    header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <!-- début section admin -->

    <section class="dashboard">

        <h1 class="heading">Tableau de bord</h1>

        <div class="box-container">
            <div class="box">
                <?php
                    $total_admin = mysqli_query($con, "SELECT * FROM `admin`
                        WHERE `type_user` = 'admin'");
                    $admin = mysqli_num_rows($total_admin);
                ?>
                    <h3>Bienvenue !</h3>
                    <p><span><?php echo $_SESSION['admin_nom']; ?></span> </p>
                    <a href="update_profile.php" class="btn">Modifier</a>
            </div>

            <div class="box">
                <?php
                    $total_produits = mysqli_query($con, "SELECT * FROM `produits`")
                        or exit('Echec de la requête !');
                    $nb_produits = mysqli_num_rows($total_produits);
                ?>
                    <h3>Les produits</h3>
                    <p><span><?php echo $nb_produits; ?></span> </p>
                    <a href="products.php" class="btn">Produits</a>
            </div>

            <div class="box">
                <?php
                    $total_commandes = mysqli_query($con, "SELECT * FROM `commandes`" )
                        or exit('Echec de la requête !');
                    $nb_commandes = mysqli_num_rows($total_commandes);
                ?>
                    <h3>Les commandes</h3>
                    <p><span><?php echo $nb_commandes; ?></span> </p>
                    <a href="recap_commandes.php" class="btn">Commandes</a>
            </div>

            <div class="box">
                <?php
                    $total_commandes = mysqli_query($con, "SELECT * FROM `commandes`
                        WHERE statut_commande = 'en attente'" )
                        or exit('Echec de la requête !');
                    $nb_commandes = mysqli_num_rows($total_commandes);
                ?>
                    <h3>Commandes dues</h3>
                    <p><span><?php echo $nb_commandes; ?></span> </p>
                    <a href="commandes_dues.php" class="btn">Dues</a>
            </div>

            <div class="box">
                <?php
                    $total_commandes = mysqli_query($con, "SELECT * FROM `commandes`
                        WHERE statut_commande = 'annulee'" )
                        or exit('Echec de la requête !');
                    $nb_commandes = mysqli_num_rows($total_commandes);
                ?>
                    <h3>Commandes annulées</h3>
                    <p><span><?php echo $nb_commandes; ?></span> </p>
                    <a href="commandes_annulees.php" class="btn">Annulées</a>
            </div>

            <div class="box">
                <?php
                    $total_commandes = mysqli_query($con, "SELECT * FROM `commandes`
                        WHERE statut_commande = 'expediees'" )
                        or exit('Echec de la requête !');
                    $nb_commandes = mysqli_num_rows($total_commandes);
                ?>
                    <h3>Commandes expédiées</h3>
                    <p><span><?php echo $nb_commandes; ?></span> </p>
                    <a href="commandes_expediees.php" class="btn">Expédiées</a>
            </div>

            <div class="box">
                <?php
                    $total_clients = mysqli_query($con, "SELECT * FROM `client`" )
                        or exit('Echec de la requête !');
                    $nb_clients = mysqli_num_rows($total_clients);
                ?>
                    <h3>Les clients</h3>
                    <p><span><?php echo $nb_clients; ?></span> </p>
                    <a href="admin_client.php" class="btn">Clients</a>
            </div>

        </div>

    </section>

    <!-- début section admin -->


<script src="assets/js/admin_script.js"></script>

</body>

</html>