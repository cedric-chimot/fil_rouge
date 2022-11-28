<?php

//connexion à la base de données
include 'components/connect.php';

//ouverture de la session
session_start();

$client_id = $_SESSION['client_id'];

//si la personne n'est pas connectée, on la renvoie vers la page login
if (!isset($_SESSION['client_id'])) {
    header('location:user_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Page d'accueil</title>
</head>

<body>

    <!-- Inclure le header commun aux pages du site -->
    <?php include 'user_header.php'; ?>

    <div class="home-bg">

        <section class="home">

            <div class="image">
                <img class="image1" src="assets/images/BODY/pub_guitare.png" alt="">
                <img class="image2" src="assets/images/BODY/banniere_droite_prix.png" alt="">
            </div>

        </section>

        <section class="category">

            <div class="category-line">

                <h1 class="titre">Nos catégories :</h1>
                <div class="category-list">
                    <a href="category.php?category=guitare"><img src="assets/images/BODY/roll_over_guitare.png" alt=""></a>
                    <a href="category.php?category=batterie"><img src="assets/images/BODY/roll_over_batterie.png" alt=""></a>
                    <a href="category.php?category=piano"><img src="assets/images/BODY/roll_over_piano.png" alt=""></a>
                    <a href="category.php?category=saxo"><img src="assets/images/BODY/roll_over_saxo.png" alt=""></a>
                    <a href="category.php?category=cases"><img src="assets/images/BODY/roll_over_cases.png" alt=""></a>
                    <a href="category.php?category=micro"><img src="assets/images/BODY/roll_over_micro.png" alt=""></a>
                    <a href="category.php?category=access"><img src="assets/images/BODY/roll_over_access.png" alt=""></a>
                    <a href="category.php?category=sono"><img src="assets/images/BODY/roll_over_sono.png" alt=""></a>
                </div>

            </div>

            <div class="best-products">

                <h1 class="titre">Nos meilleures ventes :</h1>
                <div class="products-line">
                    <img src="assets/images/BODY/top_ventes_guitare.png" alt="">
                    <img src="assets/images/BODY/top_ventes_roll-over_guitare.png" alt="">
                    <img src="assets/images/BODY/top_ventes_piano.png" alt="">
                    <img src="assets/images/BODY/top_ventes_roll-over_piano.png" alt="">
                    <img src="assets/images/BODY/top_ventes_saxo.png" alt="">
                    <img src="assets/images/BODY/top_ventes_roll-over_saxo.png" alt="">
                </div>

            </div>

        </section>

    </div>

    <?php include 'footer.php'; ?>


    <script src="assets/js/script.js"></script>

</body>

</html>