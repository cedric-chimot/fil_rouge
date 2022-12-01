<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php include 'user_header.php' ?>

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
                    <a href="category.php?categorie=Guitare"><img src="assets/images/BODY/roll_over_guitare.png" alt=""></a>
                    <a href="category.php?categorie=Batterie"><img src="assets/images/BODY/roll_over_batterie.png" alt=""></a>
                    <a href="category.php?categorie=Piano"><img src="assets/images/BODY/roll_over_piano.png" alt=""></a>
                    <a href="category.php?categorie=Trompette"><img src="assets/images/BODY/roll_over_saxo.png" alt=""></a>
                    <a href="category.php?categorie=Case"><img src="assets/images/BODY/roll_over_cases.png" alt=""></a>
                    <a href="category.php?categorie=Micro"><img src="assets/images/BODY/roll_over_micro.png" alt=""></a>
                    <a href="category.php?categorie=Accessoires"><img src="assets/images/BODY/roll_over_access.png" alt=""></a>
                    <a href="category.php?categorie=Sono"><img src="assets/images/BODY/roll_over_sono.png" alt=""></a>
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

    <?php include 'footer.php' ?>


    <script src="assets/js/script.js"></script>

</body>

</html>