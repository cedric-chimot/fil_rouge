<?php

//connexion à la BDD
include 'components/connect.php';

//début de la session
session_start();

//si l'ulisateur est connecté on renvoie ses identifiants sinon ça reste vide
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Commandes</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- on inclut le header du site -->
    <?php include 'components/user_header.php'; ?>

    <section class="about">

        <h3 class="heading">A propos</h3>

        <div class="flex">

            <div class="image">
                <img src="assets/images/BODY/pub_guitare.png""alt="">
            </div>

            <div class="content">
                <h3>Pourquoi nous faire confiance ?</h3>
                <p>Spécialisé dans la vente de matériel de musique toutes marques depuis plus de 5 ans,
                    nous sommes devenus une référence pour les amateurs comme les passionnés.
                </p>
                <p>Vous voulez du matériel de qualité, venez chez Villagegreen, nos clients apprécient nos services,
                    nos boutiques sont gérées par des spécialistes exigeants, toujours à l'écoute de leur public.
                </p>
                <a href="contact.php" class="option-btn">Contactez-nous</a>
            </div>

        </div>

        <section class="reviews">
        <!-- box recommandations clients -->
            <h3 class="heading">Derniers commentaires clients</h3>

            <div class="box-container">

                <?php
                //requête pour afficher les données de la table 'reviews' par rapport à la note et limité à 6 sur la page
                $select_reviews = $conn->prepare('SELECT * FROM reviews ORDER BY id DESC LIMIT 6');
                $select_reviews->execute();
                // Retourne le nombre de lignes affectées par le dernier appel à la fonction
                if ($select_reviews->rowCount() > 0) {
                    // Récupère la ligne suivante d'un ensemble de résultats PDO
                    while ($fetch_reviews = $select_reviews->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <!-- S'il existe un avis, on affiche les informations correspondantes -->
                        <div class="box">
                            <img src="assets/images/avatar/<?php echo $fetch_reviews['image']; ?>" alt=""><br><br>
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

    </section>

    <!-- on inclut le footer du site -->
    <?php include 'components/footer.php'; ?>

    <script src="assets/js/script.js"></script>

</body>

</html>