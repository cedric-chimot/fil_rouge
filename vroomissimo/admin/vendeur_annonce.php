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

//paramétrage de la fonction 'ajout'
if (isset($_POST['ajout_annonce'])) {

    //création des variables connectées aux différents input du formulaire d'ajout par le '$_POST['nomInput']"
    //'$con' : lien vers la BDD
    //'mysqli_real_escape_string' : Protège les caractères spéciaux d'une chaîne pour l'utiliser dans une requête SQL,
    //en prenant en compte le jeu de caractères courant de la connexion
    $num_annonce = mysqli_real_escape_string($con, $_POST['num_annonce']);
    $marque = mysqli_real_escape_string($con, $_POST['marque']);
    $modele = mysqli_real_escape_string($con, $_POST['modele']);
    $prix = $_POST['prix'];
    $km = mysqli_real_escape_string($con, $_POST['km']);
    $circulation = mysqli_real_escape_string($con, $_POST['annee_circul']);
    $production = mysqli_real_escape_string($con, $_POST['annee_production']);
    $carburant = mysqli_real_escape_string($con, $_POST['carburant']);
    $carrosserie = mysqli_real_escape_string($con, $_POST['carrosserie']);
    $etat = mysqli_real_escape_string($con, $_POST['etat']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];                                     //"tmp_name" = temporary name
    $image_folder = 'image/' . $image;

    //on va chercher dans la BDD la table 'annonce' par rapport au numéro de l'annonce
    $select_num_annonce = mysqli_query($con, "SELECT num_annonce FROM `annonce` WHERE num_annonce = '$num_annonce'")
    //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');

    //Création d'une variable pour vérifier si le numéro d'annonce existe déjà dans la BDD
    if (mysqli_num_rows($select_num_annonce) > 0) {
        //si oui, envoie d'un message d'erreur
        $message[] = 'Cette annonce existe déjà !';
    } else {
        //sinon, connexion à la BDD et insertion des données de l'annonce à l'aide d'une requête
        $ajout_annonce = mysqli_query($con, "INSERT INTO `annonce`
        (num_annonce, idvendeur, marque, modele, prix, Km, annee_circul, annee_production, carburant, carrosserie, etat, description, contact_vendeur, image)
        VALUES('$num_annonce', '$vendeur_id',  '$marque', '$modele', '$prix', '$km', '$circulation', '$production', '$carburant',
                '$carrosserie', '$etat', '$description', '$contact', '$image')")
            or exit('Echec de la requête');

        //vérification de la taile de l'image au moment de l'insertion et envoie d'un message d'erreur si elle est trop grande
        if ($ajout_annonce) {
            if ($image_size > 2000000) {
                $message[] = "La taille de l'image est trop grande !";
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Annonce ajoutée avec succès !';
            }
        } else {
            $message[] = "Votre annonce n'a pas pu être ajoutée";
        }
    }
}

//paramétrage de la fonction 'delete'
if (isset($_GET['delete'])) {
    //association du bouton 'delete' avec le numéro de l'annonce
    $delete_num_annonce = $_GET['delete'];
    $delete_image_query = mysqli_query($con, "SELECT image FROM `annonce` WHERE num_annonce = '$num_annonce'")
        or exit('Echec de la requête');
    //association pour la suppression de l'image
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    mysqli_query($con, "DELETE FROM `annonce` WHERE num_annonce = '$delete_num_annonce'")
        or exit('Echec de la requête');
    //renvoie vers la page d'administration des annonces
    header('location:vendeur_annonce.php');
}

//paramétrage de la fonction 'update'
if (isset($_POST['update_annonce'])) {

    //déclaration des variables et lien vers les inputs avec '$_POST['nomInput']
    //'htmlspecialchars' pour convertir les caractères spéciaux en entité HTML
    $update_num_annonce = htmlspecialchars($_POST['update_num_annonce']);
    $update_modele = htmlspecialchars($_POST['update_modele']);
    $update_prix = $_POST['update_prix'];
    $update_km = $_POST['update_km'];
    $update_carburant = htmlspecialchars($_POST['update_carburant']);
    $update_etat = htmlspecialchars($_POST['update_etat']);
    $update_description = htmlspecialchars($_POST['update_description']);

    //requête de MAJ de la table annonce en liant les colonnes avec les variables
    mysqli_query($con, "UPDATE `annonce` SET modele = '$update_modele', prix = '$update_prix', km = '$update_km',
        carburant = '$update_carburant', etat = '$update_etat', description = '$update_description'
        WHERE num_annonce = '$update_num_annonce'")
        or exit('Echec de la requête');

    //MAJ de l'image
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'image/' . $update_image;
    $update_ancien_image = $_POST['update_ancien_image'];

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = "La taille de l'image est trop grande !";
        } else {
            mysqli_query($con, "UPDATE `annonce` SET image = '$update_image'
                WHERE num_annonce = '$update_num_annonce'")
                or exit('Echec de la requête');
            move_uploaded_file($update_image_tmp_name, $update_folder);
        }
    }

    //renvoie vers la page d'administration des annonces
    header('location:vendeur_annonce.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admins/css/admin.css">
    <title>Annonces</title>
</head>

<body>

    <?php include 'vendeur_header.php'; ?>

    <!-- Début du CRUD annonce -->

    <section class="ajout-annonce">

        <h1 class="titre">Annonces</h1>

        <form method="post" action="" enctype="multipart/form-data">
            <h3>Ajouter une annonce</h3>
            <input type="text" name="num_annonce" class="box" placeholder="numéro de l'annonce" required>
            <input type="text" name="vendeur" class="box" placeholder="vendeur" required>
            <input type="text" name="marque" class="box" placeholder="entrer la marque du véhicule" required>
            <input type="text" name="modele" class="box" placeholder="entrer le modèle du véhicule" required>
            <input type="number" name="prix" class="box" placeholder="prix du produit" required>
            <input type="text" name="km" class="box" placeholder="kilométrage" required>
            <input type="text" name="annee_circul" class="box" placeholder="mise en circulation" required>
            <input type="text" name="annee_production" class="box" placeholder="année de production" required>
            <input type="text" name="carburant" class="box" placeholder="carburant" required>
            <input type="text" name="carrosserie" class="box" placeholder="carrosserie" required>
            <input type="text" name="etat" class="box" placeholder="etat" required>
            <input type="text" name="description" class="box" placeholder="description" required>
            <input type="text" name="contact" class="box" placeholder="contact" required>
            <h2>Ajouter des photos</h2>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
            <input type="submit" value="Ajouter une annonce" name="ajout_annonce" class="btn">
        </form>

    </section>

    <!-- Fin du CRUD annonce -->

    <!-- Afficher les annonces -->

    <section class="afficher_annonces">

        <div class="box-container">

            <?php

            //requête pour afficher la totalité des données de la table annonce
            $select_annonces = mysqli_query($con, "SELECT * FROM `annonce`
                WHERE idvendeur = '$vendeur_id'")
                or exit('Echec de la requête');
            // Retourne le nombre de lignes dans le jeu de résultats
            if (mysqli_num_rows($select_annonces) > 0) {
                // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                while ($fetch_annonces = mysqli_fetch_assoc($select_annonces)) {
            ?>
            <!-- S'il existe une annonce, on affiche les informations correspondantes -->
                   <div class="box">
                        <img src="image/<?php echo $fetch_annonces['image']; ?>" alt="">
                        <div class="marque"><?php echo "Numéro de l'annonce : " . $fetch_annonces['num_annonce']; ?></div>
                        <div class="marque"><?php echo "Marque : " . $fetch_annonces['marque']; ?></div>
                        <div class="modele"><?php echo "Modèle : " . $fetch_annonces['modele']; ?></div>
                        <div class="prix"><?php echo "Prix : " . $fetch_annonces['prix'] . " €"; ?></div>
                        <div class="km"><?php echo "Kilométrage : " . $fetch_annonces['km'] . " km"; ?></div>
                        <div class="carburant"><?php echo "Carburant : " .  $fetch_annonces['carburant']; ?></div>
                        <div class="etat"><?php echo "Etat : " . $fetch_annonces['etat']; ?></div>
                        <div class="description"><?php echo "Description : " . $fetch_annonces['description']; ?></div>
                        <a href="vendeur_annonce.php?update_annonce=<?php echo $fetch_annonces['num_annonce']; ?>" class="btn">Modifier l'annonce</a>
                        <a href="vendeur_annonce.php?delete=<?php echo $fetch_annonces['num_annonce']; ?>"
                            class="delete-btn" onclick="return confirm('Voulez-vous supprimer cette annonce ?');">Supprimer l'annonce</a>
                    </div>
            <?php
                }
            } else {
                //Sinon la phrase suivante s'affiche
                echo '<p class="vide">Aucune annonce ajoutée</p>';
            }

            ?>

        </div>

    </section>

    <!-- Afficher les annonces Fin -->

    <!-- Modifier les annonces -->

    <section class="edit-annonce-form">
        
        <div class="form">
            <?php
            if (isset($_GET['update_annonce'])) {
                //on va chercher le bouton modifier
                $update_num_annonce = $_GET['update_annonce'];

                //on fait une requête en se connectant à la table 'annonce' et en le liant au numéro de l'annonce
                $update_query = mysqli_query($con, "SELECT * FROM `annonce` WHERE num_annonce = '$update_num_annonce'")
                    or exit('Echec de la requête');
                if (mysqli_num_rows($update_query) > 0) {
                    while ($fetch_update = mysqli_fetch_assoc($update_query)) {
            ?>
                <!-- le formulaire de modification apparait à l'écran -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="update_num_annonce" value="<?php echo $fetch_update['num_annonce']; ?>">
                            <input type="hidden" name="update_ancien_image" value="<?php echo $fetch_update['image']; ?>">
                            <img src="image/<?php echo $fetch_update['image']; ?>" alt="">
                            <input type="text" name="update_modele" value="<?php echo $fetch_update['modele']; ?>" class="box" placeholder="modele" required>
                            <input type="text" name="update_prix" value="<?php echo $fetch_update['prix']; ?>" class="box" placeholder="prix" required>
                            <input type="text" name="update_km" value="<?php echo $fetch_update['km']; ?>" class="box" placeholder="kilometrage" required>
                            <input type="text" name="update_carburant" value="<?php echo $fetch_update['carburant']; ?>" class="box" placeholder="carburant" required>
                            <input type="text" name="update_etat" value="<?php echo $fetch_update['etat']; ?>" class="box" placeholder="etat" required>
                            <input type="text" name="update_description" value="<?php echo $fetch_update['description']; ?>" class="box" placeholder="description" required>
                            <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                            <input type="submit" value="Modifier" name="update_annonce" class="btn" onclick="return confirm('Annonce modifiée avec succès !')">
                            <input type="reset" value="Annuler" id="stop-update" class="delete-btn">
                        </form>

            <?php
                    }
                }
            } else {
                //sinon tant que l'on n'appuie pas sur le bouton 'update', le formulaire reste invisible
                echo '<script>document.querySelector(".edit-annonce-form").style.display = "none";</script>';
            }
            ?>

        </div>

    </section>

    <!-- Modifier les annonces Fin -->

    <script src="admins/js/admin_script.js"></script>

</body>

</html>