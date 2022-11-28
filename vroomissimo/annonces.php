<?php

//connexion à la base de données
include 'admin/admins/config.php';

//ouverture de la session
session_start();

$client_id = $_SESSION['client_id'];

//si la personne n'est pas connectée, on la renvoie vers la page login
if (!isset($client_id)) {
    header('location:login.php');
};

//Fonction d'ajout au panier
if (isset($_POST['ajout_panier'])){

    //déclaration des variables
    $num_annonce = $_POST['num_annonce'];
    $annonce_marque = $_POST['annonce_marque'];
    $annonce_modele = $_POST['annonce_modele'];
    $annonce_prix = $_POST['annonce_prix'];
    $annonce_image = $_POST['annonce_image'];

    //Création d'une variable pour vérifier le panier
    $check_panier = mysqli_query($con, "SELECT * FROM `panier`
        WHERE modele = '$annonce_modele' AND client_id = '$client_id'")
        //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');

    //on vérifie grace à l'id du client et le modèle du véhicule si l'article est déjà dans le panier
    if(mysqli_num_rows($check_panier) > 0){
        $message[] = 'Article déjà ajouté au panier !';
    }else{
        //Si l'article n'y est pas déjà on créé sa fiche produit dans le panier
        mysqli_query($con, "INSERT INTO `panier`(client_id, num_annonce, marque, modele, prix, image)
        VALUES ('$client_id', $num_annonce, '$annonce_marque', '$annonce_modele', '$annonce_prix', '$annonce_image')")
        or exit('Echec de la requête');
        $message[] = 'Article ajouté avec succès !';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Annonces</title>
</head>

<body>

    <!-- Inclure le header commun aux pages du site -->
    <?php include 'header.php'; ?>


    <div class="heading_annonces">
        <h3>Les annonces publiées</h3>
        <p> <a href="home.php">Accueil</a> / Annonces </p>
    </div>

    <!-- Formulaire d'affichage des annonces -->
    <section class="annonce_publiées">

        <h1 class="titre">Toutes les annonces</h1>

        <div class="box-container">

            <?php
                // On se connecte à la table 'annonce' de la base de données
                $select_annonces = mysqli_query($con, "SELECT * FROM `annonce`")
                    or exit('Echec de la requête');
                // Retourne le nombre de lignes dans le jeu de résultats
                if(mysqli_num_rows($select_annonces) > 0) {
                    // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                    while($fetch_annonces = mysqli_fetch_assoc($select_annonces)){
            ?>
                    <!-- S'il existe une annonce, on affiche le formulaire correspondant -->
                        <form method="post" class="box" action="">
                            <img src="image/<?php echo $fetch_annonces['image']; ?>">
                            <div class="marque"><span>Numéro de l'annonce : </span><?php echo $fetch_annonces['num_annonce']; ?></div>
                            <div class="marque"><span>Marque : </span><?php echo $fetch_annonces['marque']; ?></div>
                            <div class="modele"><span>Modèle : </span><?php echo $fetch_annonces['modele']; ?></div>
                            <div class="prix"><span>Prix : </span><?php echo $fetch_annonces['prix'] . " €"; ?></div>
                            <div class="km"><span>Kilométrage : </span><?php echo $fetch_annonces['km'] . " km"; ?></div>
                            <div class="carburant"><span>Carburant : </span><?php echo $fetch_annonces['carburant']; ?></div>
                            <div class="etat"><span>Etat : </span><?php echo $fetch_annonces['etat']; ?></div>
                            <div class="description"><span>Description : </span><?php echo $fetch_annonces['description']; ?></div>
                            <div class="contact"><span>Contact : </span><?php echo $fetch_annonces['contact_vendeur']; ?></div>
                            <input type="hidden" name="num_annonce" value="<?php echo $fetch_annonces['num_annonce']; ?>" />
                            <input type="hidden" name="annonce_marque" value="<?php echo $fetch_annonces['marque']; ?>" />
                            <input type="hidden" name="annonce_modele" value="<?php echo $fetch_annonces['modele']; ?>" />
                            <input type="hidden" name="annonce_prix" value="<?php echo $fetch_annonces['prix']; ?>" />
                            <input type="hidden" name="annonce_image" value="<?php echo $fetch_annonces['image']; ?>" />
                            <button type="submit" class="btn" name="ajout_panier"><i class="fa-solid fa-cart-plus"></i> Ajouter</button>
                            <a href="contact.php" class="option-btn"><i class="fa-solid fa-address-book"></i> Poser une question</a>
                        </form>
            <?php
                }
                }else{
                    //Sinon la phrase suivante s'affiche
                    echo '<p class="vide">Aucune annonces ajoutées</p>';
                }
            ?>
        </div>

    </section>


    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>