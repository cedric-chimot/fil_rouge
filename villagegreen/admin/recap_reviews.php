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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css">
    <title>Reviews</title>
</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <section class="reviews">

        <h1 class="heading">Commentaires clients</h1>

        <div class="box-container">

        <?php
            //requête pour afficher les données de la table 'reviews' par rapport à la note et limité à 6 sur la page
            $select_reviews = $conn->prepare('SELECT * FROM `reviews`');
            $select_reviews->execute();
            // Retourne le nombre de lignes affectées par le dernier appel à la fonction
            if ($select_reviews->rowCount() > 0) {
                // Récupère la ligne suivante d'un ensemble de résultats PDO
                while ($fetch_reviews = $select_reviews->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <!-- S'il existe un avis, on affiche les informations correspondantes -->
                    <div class="box">
                        <img src="../assets/images/avatar/<?php echo $fetch_reviews['image']; ?>" alt=""><br><br>
                        <span class="row">Client : </span>
                        <div class="client"><?php echo $fetch_reviews['client']; ?></div>
                        <span class="row">Note : </span>
                        <div class="note">
                            <?php if ($fetch_reviews['note'] == 0) {
                                    echo '<i class="fa-regular fa-star"> style="color: grey;"></i>
                                        <i class="fa-regular fa-star"> style="color: grey;"></i>
                                        <i class="fa-regular fa-star"> style="color: grey;"></i>
                                        <i class="fa-regular fa-star"> style="color: grey;"></i>
                                        <i class="fa-regular fa-star"> style="color: grey;"></i>';
                                } elseif ($fetch_reviews['note'] == 1) {
                                    echo '<i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-regular fa-star" style="color: grey;"></i>
                                        <i class="fa-regular fa-star" style="color: grey;"></i>
                                        <i class="fa-regular fa-star" style="color: grey;"></i>
                                        <i class="fa-regular fa-star" style="color: grey;"></i>';                                            
                                } elseif ($fetch_reviews['note'] == 2) {
                                    echo '<i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-regular fa-star" style="color: grey;"></i>
                                        <i class="fa-regular fa-star" style="color: grey;"></i>
                                        <i class="fa-regular fa-star" style="color: grey;"></i>';
                                } else if ($fetch_reviews['note'] == 3){
                                    echo '<i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-regular fa-star" style="color: grey;"></i>
                                        <i class="fa-regular fa-star" style="color: grey;"></i>';
                                } else if ($fetch_reviews['note'] == 4){
                                    echo '<i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-regular fa-star" style="color: grey;"></i>';
                                } else if ($fetch_reviews['note'] == 5){
                                    echo '<i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-solid fa-star" style="color: goldenrod;"></i>
                                        <i class="fa-solid fa-star" style="color: goldenrod;"></i>';
                                } ?>                                                                                                       
                        </div>
                        <span class="row">Commentaire : </span>
                        <div class="avis"><?php echo $fetch_reviews['avis']; ?></div>
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


    <script src="assets/js/admin_script.js"></script>

</body>

</html>