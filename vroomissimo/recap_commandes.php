<?php

//connexion à la base de données
include 'admin/admins/config.php';

//ouverture de la session
session_start();

$client_id = $_SESSION['client_id'];
$vendeur_id = $_SESSION['vendeur_id'];

//si la personne n'est pas connectée, on la renvoie vers la page login
if (!isset($client_id)) {
    header('location:login.php');
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
    <link rel="stylesheet" href="css/style.css">
    <title>Commandes</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="recap_commandes">
        <h3>Toutes vos commandes</h3>
        <p> <a href="home.php">Accueil</a> / Vos commandes </p>
    </div>

    <section class="commandes">

        <h1 class="titre">Commandes effectuées</h1>

        <div class="box-container">
            <?php
                //connexion à la table 'commande' dans la BDD
                $select_commandes = mysqli_query($con, "SELECT * FROM `commandes`
                    WHERE client_id = '$client_id'")
                    or exit("Echec de la requête");
                // Retourne le nombre de lignes dans le jeu de résultats
                if(mysqli_num_rows($select_commandes) > 0){
                    // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                    while($fetch_commande = mysqli_fetch_assoc($select_commandes)){
            ?>
        
            <!-- création de la div correspondante lorque la commande est réglée -->
            <div class="box">
                <h3>Commande N° <?php echo $fetch_commande['id']; ?> </h3>
                <p class="date">Date commande : 
                    <span><?php echo $fetch_commande['date_commande']?></span> 
                </p>
                <h3>Information de livraison :</h3>
                <p class="info">Nom : <span><?php echo $fetch_commande['nom']?> </span> </p>
                <p class="info">Telephone : <span><?php echo $fetch_commande['telephone']?> </span> </p>
                <p class="info">Adresse : <span><?php echo $fetch_commande['adresse']?> </span> </p>
                <p class="info">CP : <span><?php echo $fetch_commande['cp']?> </span> </p>
                <p class="info">Ville : <span><?php echo $fetch_commande['ville']?> </span> </p>
                <p class="info">Pays : <span><?php echo $fetch_commande['pays']?> </span> </p>
                <h3>Information de la commande :</h3>
                <p class="articles">Articles : 
                    <span><?php echo $fetch_commande['total_articles']?> </span> 
                </p>
                <p class="info">Prix total : 
                    <span class="prix"><?php echo $fetch_commande['prix_total']?> € </span> 
                </p>
                <p class="paiement">Paiement : <span><?php echo $fetch_commande['paiement']?> </span> </p>
                <a href="renseignement.php" class="btn"><i class="fa-solid fa-address-book"></i> Contacter le vendeur</a>
                <a href="avis.php" class="option-btn"><i class="fa-solid fa-graduation-cap"></i> Noter le vendeur</a>
            </div>
            <?php
                        }
                    }else{
                        //s'il n'y a aucune commande on affiche ce message
                        echo '<p class="vide">Aucune commandes en cours</p>';
                }
            ?>
        </div>

    </section>


    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>