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

//fonction d'ajout au panier sur les annonces de la page de recherche
if (isset($_POST['ajout_panier'])){

    //déclaration des variables
    $num_annonce = $_POST['num_annonce'];
    $annonce_marque = $_POST['annonce_marque'];
    $annonce_modele = $_POST['annonce_modele'];
    $annonce_prix = $_POST['annonce_prix'];
    $annonce_image = $_POST['annonce_image'];

    //connexion à la table 'panier' et lien sur le modèle et l'ID du client
    $check_panier_nombre = mysqli_query($con, "SELECT * FROM `panier`
        WHERE modele = '$annonce_modele' AND client_id = '$client_id'")
        //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');

    //si l'article est déjà dans le panier ça revoie un message d'erreur
    if(mysqli_num_rows($check_panier_nombre) > 0){
        $message[] = 'Article déjà ajouté au panier !';
    }else{
        //sinon, on insère les données dans la table 'panier'
        mysqli_query($con, "INSERT INTO `panier`(client_id, num_annonce, marque, modele, prix, image)
            VALUES ('$client_id', $num_annonce, '$annonce_marque', '$annonce_modele', '$annonce_prix', '$annonce_image')")
            or exit('Echec de la requête');
        //le message de confirmation s'inscrit
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
    <title>Recherche</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading_recherche">
        <h3>Rechercher</h3>
        <p> <a href="home.php">Accueil</a> / Recherche </p>
    </div>

    <!-- formulaire de recherche -->
    <section class="search-form">
        <h3 class="titre">Vous cherchez un véhicule ?</h3>
        <form method="post" action="" class="search">
            <input type="text" name="recherche" placeholder="rechercher un vehicule..."
                class="box" autocomplete="off">
            <input type="submit" name="valider" value="Rechercher" class="btn">
        </form>

    </section>

    <section class="search_annonce">

        <div class="box-container">

            <?php
            //lien avec le bouton de validation
            if (isset($_POST['valider'])) {
                //variable de recherche
                $search_item = $_POST['recherche'];
                // connexion à la table 'annonce' et association de la recherche sur les colonnes de la table
                //ensuite, association de la recherche en faisant correspondre les données de la table et la saisie dans la barre de recherche
                $select_annonces = mysqli_query($con, "SELECT * FROM `annonce`
                    WHERE marque LIKE('%$search_item%') OR modele LIKE('%$search_item%')
                    OR prix LIKE ('%$search_item%') OR km LIKE ('%$search_item%') OR
                    carburant LIKE('%$search_item%') OR etat LIKE('%$search_item%')")
                    or exit('Echec de la requête');
                //si des éléments de recherche correspondent, le formulaire d'annonce s'affiche
                if (mysqli_num_rows($select_annonces) > 0) {
                    while ($fetch_annonces = mysqli_fetch_assoc($select_annonces)) {
            ?>
                    <form method="post" class="box" action="">
                        <img src="image/<?php echo $fetch_annonces['image']; ?>">
                        <div class="marque"><span>Marque : </span><?php echo $fetch_annonces['marque']; ?></div>
                        <div class="modele"><span>Modèle : </span><?php echo $fetch_annonces['modele']; ?></div>
                        <div class="prix"><span>Prix : </span><?php echo $fetch_annonces['prix'] . " €"; ?></div>
                        <div class="km"><span>Kilométrage : </span><?php echo $fetch_annonces['km'] . " km"; ?></div>
                        <div class="carburant"><span>Carburant : </span><?php echo $fetch_annonces['carburant']; ?></div>
                        <div class="etat"><span>Etat : </span><?php echo $fetch_annonces['etat']; ?></div>
                        <div class="description"><span>Description : </span><?php echo $fetch_annonces['description']; ?></div>
                        <input type="hidden" name="num_annonce" value="<?php echo $fetch_annonces['num_annonce']; ?>" />
                        <input type="hidden" name="annonce_marque" value="<?php echo $fetch_annonces['marque']; ?>" />
                        <input type="hidden" name="annonce_modele" value="<?php echo $fetch_annonces['modele']; ?>" />
                        <input type="hidden" name="annonce_prix" value="<?php echo $fetch_annonces['prix']; ?>" />
                        <input type="hidden" name="annonce_image" value="<?php echo $fetch_annonces['image']; ?>" />
                        <button type="submit" class="btn" name="ajout_panier"><i class="fa-solid fa-cart-plus"></i> Ajouter</button>
                    </form>
            <?php
                    }
                }else{
                    //sinon on renvoie ce message
                    echo '<p class="vide">Aucune annonces trouvées</p>';
                }
            }
            ?>

        </div>

    </section>


    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>