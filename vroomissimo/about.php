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
    <title>A propos</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>A propos</h3>
        <p> <a href="home.php">Accueil</a> / A propos </p>
    </div>

    <section class="a_propos">

        <div class="flex">

            <div class="image">
                <img src="image/S0-modele--audi-q2.jpg"alt="">
            </div>

            <div class="content">
                <h3>Pourquoi nous faire confiance ?</h3>
                <p>Vroomissimo est une communauté créée par des passionnés pour des passionnés.
                    Vous aimez les belles voitures, vous êtes au bon endroit !
                </p>
                <p>Vendeur professionnels, nous sommes là pour vous conseiller et vous aider à faire
                    le meilleur choix possible. N'hésitez pas à faire appel à nos services.</p>
                <a href="contact.php" class="btn">Contactez-nous</a>
            </div>

        </div>

    </section>

    <section class="reviews">

    <!-- box recommandations clients -->
        <h1 class="titre">Nos clients nous recommandent</h1>

        <div class="box-container">

            <?php

            //requête pour afficher les données de la table avis par rapport à la note et limité à 6 sur la page
            $select_avis = mysqli_query($con, "SELECT * FROM `avis`
                WHERE note = 5 ORDER BY id DESC LIMIT 6")
                or exit('Echec de la requête');
            // Retourne le nombre de lignes dans le jeu de résultats
            if (mysqli_num_rows($select_avis) > 0) {
                // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                while ($fetch_avis = mysqli_fetch_assoc($select_avis)) {
            ?>
                    <!-- S'il existe un avis, on affiche les informations correspondantes -->
                    <div class="box">
                        <img src="image/<?php echo $fetch_avis['image']; ?>" alt=""><br><br>
                        <span class="row">Client : </span>
                        <div class="vendeur"><?php echo $fetch_avis['nom_client']; ?></div>
                        <span class="row">Note : </span>
                        <div class="note">
                            <?php
                                if ($fetch_avis['note'] == 5){
                                    echo '<i class="las la-star" style="color: goldenrod;"></i>
                                        <i class="las la-star" style="color: goldenrod;"></i>
                                        <i class="las la-star" style="color: goldenrod;"></i>
                                        <i class="las la-star" style="color: goldenrod;"></i>
                                        <i class="las la-star" style="color: goldenrod;"></i>';
                                    }
                            ?>                                    
                        </div>
                        <span class="row">Commentaire : </span>
                        <div class="avis"><?php echo $fetch_avis['avis']; ?></div>
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

</body>

</html>