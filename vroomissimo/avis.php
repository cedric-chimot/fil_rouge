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

//paramétrage de la fonction 'ajout'
if (isset($_POST['ajout_avis'])) {

    $num_commande = mysqli_real_escape_string($con, $_POST['num_commande']);
    $nom_vendeur = mysqli_real_escape_string($con, $_POST['nom_vendeur']);
    $nom_client = mysqli_real_escape_string($con, $_POST['nom_client']);
    $note = mysqli_real_escape_string($con, $_POST['note']);
    $avis = mysqli_real_escape_string($con, $_POST['avis']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];                                     //"tmp_name" = temporary name
    $image_folder = 'image/' . $image;

    //on va chercher dans la BDD la table 'avis' par rapport au numéro de commande
    $select_avis = mysqli_query($con, "SELECT * FROM `avis`
        WHERE num_commande = '$num_commande'")
        //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');
    
    // si le commentaire a déjà été envoyé on affiche ceci
    if(mysqli_num_rows($select_avis) > 0){
        $message[] = 'Commentaire déjà envoyé !';
    }else{
        //insertion des données du commentaire à l'aide d'une requête
        $ajout_avis = mysqli_query($con, "INSERT INTO `avis`(num_commande, idvendeur, client_id, nom_vendeur,
            nom_client, note, avis, image) VALUES($num_commande, '$vendeur_id', '$client_id',
            '$nom_vendeur', '$nom_client', '$note', '$avis', '$image')")
            or exit('Echec de la requête');  

    //vérification de la taile de l'image au moment de l'insertion et envoie d'un message d'erreur si elle est trop grande
    if ($ajout_avis) {
        if ($image_size > 2000000) {
            $message[] = "La taille de l'image est trop grande !";
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Commentaire ajoutée avec succès !';
        }
        } else {
            $message[] = "Votre commentaire n'a pas pu être ajouté";
        }
    }
}

//paramétrage de la fonction 'delete'
if (isset($_GET['delete'])) {
    //association du bouton 'delete' avec l'ID du message
    $delete_id = $_GET['delete'];
    //requête de suppression avec lien vers la table 'message'
    mysqli_query($con, "DELETE FROM `avis` WHERE id = '$delete_id'")
        //'or die' renvoie une notification d'erreur si la requête ne peut aboutir
        or exit('Echec de la requête');
    //renvoie vers la liste des messages
    header('location:avis.php');
}

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
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Avis client</title>
</head>

<body>

    <!-- Inclure le header commun aux pages du site -->
    <?php include 'header.php'; ?>

    <div class="recap_avis">
        <h3>Tous vos commentaires</h3>
        <p> <a href="home.php">Accueil</a> / Commentaires </p>
    </div>

    <!-- Formulaire d'ajout d'un commentaire -->
    <section class="ajout-review">

        <h1 class="titre">Donner votre avis</h1>

        <form method="post" action="" enctype="multipart/form-data">
            <h3>Votre avatar :</h3>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
            <h3>Votre nom :</h3>
            <input type="text" name="nom_client" class="box" placeholder="votre nom" required>
            <h3>Vendeur :</h3>
            <input type="text" name="nom_vendeur" class="box" placeholder="vendeur" required>
            <h3>Commande N° :</h3>
            <input type="text" name="num_commande" class="box" placeholder="numéro de commande" required>
            <h3>Votre note :</h3>
            <!-- on attribue une valeur aux étoiles -->
            <div class="stars">
                <i class="fa-regular fa-star" data-value="1"></i>
                <i class="fa-regular fa-star" data-value="2"></i>
                <i class="fa-regular fa-star" data-value="3"></i>
                <i class="fa-regular fa-star" data-value="4"></i>
                <i class="fa-regular fa-star" data-value="5"></i>
            </div>
            <!-- input type 'hidden' qui attribue une note de base de '0' -->
            <input type="hidden" name="note" id="note" value="0">
            <h3>Votre commentaire :</h3>
            <textarea name="avis" class="box" placeholder="votre avis" cols="30" rows="10" required></textarea>
            <input type="submit" value="Ajouter un avis" name="ajout_avis" class="btn">
        </form>

    </section>

    <section class="afficher_avis">

        <h3 class="titre">Tous vos commentaires</h3>

        <div class="box-container">

            <?php

            //requête pour afficher les données de la table avis correspondantes au client
            $select_avis = mysqli_query($con, "SELECT * FROM `avis`
                WHERE `client_id` = '$client_id'")
                or exit('Echec de la requête');
            // Retourne le nombre de lignes dans le jeu de résultats
            if (mysqli_num_rows($select_avis) > 0) {
                // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                while ($fetch_avis = mysqli_fetch_assoc($select_avis)) {
            ?>
                    <!-- S'il existe un avis, on affiche les informations correspondantes -->
                    <div class="box">
                        <img src="image/<?php echo $fetch_avis['image']; ?>" alt=""><br><br>
                        <span>Vendeur : </span>
                        <div class="vendeur"><?php echo $fetch_avis['nom_vendeur']; ?></div>
                        <span>Commande N° : </span>
                        <div class="commande"><?php echo $fetch_avis['num_commande']; ?></div>
                        <span>Note : </span>
                        <div class="note">
                            <?php
                            //'Switch case' sur la note moyenne pour attribuer le nombre d'étoile correspondant
                                switch ($_SERVER["REQUEST_METHOD"] == "POST"){
                                    case "0":
                                        if($fetch_avis['note'] == 0){
                                            echo '<i class="lar la-star" style="color: black;"></i>
                                                <i class="lar la-star" style="color: black;"></i>
                                                <i class="lar la-star" style="color: black;"></i>
                                                <i class="lar la-star" style="color: black;"></i>
                                                <i class="lar la-star" style="color: black;"></i>';
                                            }

                                    case "1":
                                        if ($fetch_avis['note'] == 1){
                                            echo '<i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="lar la-star" style="color: black;"></i>
                                                <i class="lar la-star" style="color: black;"></i>
                                                <i class="lar la-star" style="color: black;"></i>
                                                <i class="lar la-star" style="color: black;"></i>';
                                            }

                                    case "2":
                                        if ($fetch_avis['note'] == 2){
                                            echo '<i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="lar la-star" style="color: black;"></i>
                                                <i class="lar la-star" style="color: black;"></i>
                                                <i class="lar la-star" style="color: black;"></i>';
                                            }
                                    
                                    case "3":
                                        if ($fetch_avis['note'] == 3){
                                            echo '<i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="lar la-star" style="color: black;"></i>
                                                <i class="lar la-star" style="color: black;"></i>';
                                            }

                                    case "4":
                                        if ($fetch_avis['note'] == 4){
                                            echo '<i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="lar la-star" style="color: black;"></i>';
                                        }

                                    case "5":
                                        if ($fetch_avis['note'] == 5){
                                            echo '<i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="las la-star" style="color: goldenrod;"></i>
                                                <i class="las la-star" style="color: goldenrod;"></i>';
                                        }
                                }
                            ?>                                    
                        </div>
                        <span>Commentaire : </span>
                        <div class="avis"><?php echo $fetch_avis['avis']; ?></div>
                        <a href="avis.php?delete=<?php echo $fetch_avis['id']; ?>" class="delete-btn"
                            onclick="return confirm('Voulez-vous supprimer ce commentaire ?');">Supprimer
                        </a>
                    </div>
            <?php
                }
            } else {
                //Sinon la phrase suivante s'affiche
                echo '<p class="vide">Aucun avis publié</p>';
            }

            ?>

        </div>

    </section>


    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>
    <script src="js/eval.js"></script>

</body>

</html>