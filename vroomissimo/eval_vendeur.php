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
    <title>Avis client</title>
</head>

<body>

    <!-- Inclure le header commun aux pages du site -->
    <?php include 'header.php'; ?>

    <div class="eval_vendeur">
        <h3 class="titre">Nos vendeurs</h3>
        <p> <a href="home.php">Accueil</a> / Evaluations </p>
    </div>

    <section class="afficher_eval">
        
        <h3 class="titre">La liste de nos vendeurs</h3>

        <div class="box-container">

            <?php
            //on va chercher les données de la table'avis'
                $select_eval = "SELECT * FROM avis";
                //on fait une requête avec Alias sur la table 'avis'
                //'ROUND(AVG(),1)' : On fait une moyenne des notes arrondie à 1 chiffre après la virgule
                $select_eval = mysqli_query($con, "SELECT nom_vendeur AS vendeur, ROUND(AVG(note),1)
                    AS note_moyenne, COUNT(*) AS total_avis, avis AS commentaire
                    FROM avis WHERE idvendeur = 1")
                    or exit("Echec de la requête");
                // Récupère la ligne suivante d'un ensemble de résultats sous forme de tableau associatif
                $fetchAverage = mysqli_fetch_assoc($select_eval);
            ?>

                <div class="box">
                    <?php
                        echo "<h3>$fetchAverage[vendeur]</h3>";
                    ?>

                    <div class="note">
                        <?php
                        //'Switch case' sur la note moyenne pour attribuer le nombre d'étoile correspondant
                            switch ($_SERVER["REQUEST_METHOD"] == "POST"){
                                case "0":
                                    if($fetchAverage['note_moyenne'] >= 0 && $fetchAverage['note_moyenne'] < 1){
                                        echo '<i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }

                                case "1":
                                    if ($fetchAverage['note_moyenne'] >= 1 && $fetchAverage['note_moyenne'] < 2){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }

                                case "2":
                                    if ($fetchAverage['note_moyenne'] >= 2 && $fetchAverage['note_moyenne'] < 3){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }
                                
                                case "3":
                                    if ($fetchAverage['note_moyenne'] >= 3 && $fetchAverage['note_moyenne'] < 4){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }

                                case "4":
                                    if ($fetchAverage['note_moyenne'] >= 4 && $fetchAverage['note_moyenne'] < 5){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>';
                                    }

                                case "5":
                                    if ($fetchAverage['note_moyenne'] == 5){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>';
                                    }
                                }
                        ?>
                    </div>
                    <?php
                    //affichage de la moyenne, du meilleur commentaire et du nombre d'évaluations
                        echo "<h3>Moyenne : </h3>" . "<p class='moyenne'>$fetchAverage[note_moyenne]</p>
                            <p class='eval'>(sur un total de $fetchAverage[total_avis] évaluation(s))</p>" .
                            "\n" . "<h3>Meilleur commentaire : </h3>" .
                            "<p class='commentaire'>$fetchAverage[commentaire]</p>" . "<br />"; 
                    ?>
                </div>

            <?php
                $select_eval2 = "SELECT * FROM avis";
                $select_eval2 = mysqli_query($con, "SELECT nom_vendeur AS vendeur, ROUND(AVG(note),1)
                    AS note_moyenne, COUNT(*) AS total_avis, avis AS commentaire
                    FROM avis WHERE idvendeur = 2")
                    or exit("Echec de la requête");
                $fetchAverage2 = mysqli_fetch_assoc($select_eval2);
            ?>

                <div class="box">                        
                    <?php
                        echo "<h3>$fetchAverage2[vendeur]</h3>";
                    ?>

                    <div class="note">
                        <?php 
                            switch ($_SERVER["REQUEST_METHOD"] == "POST"){
                                case "0":
                                    if($fetchAverage2['note_moyenne'] >= 0 && $fetchAverage2['note_moyenne'] < 1){
                                        echo '<i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }

                                case "1":
                                    if ($fetchAverage2['note_moyenne'] >= 1 && $fetchAverage2['note_moyenne'] < 2){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }

                                case "2":
                                    if ($fetchAverage2['note_moyenne'] >= 2 && $fetchAverage2['note_moyenne'] < 3){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }
                                
                                case "3":
                                    if ($fetchAverage2['note_moyenne'] >= 3 && $fetchAverage2['note_moyenne'] < 4){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }

                                case "4":
                                    if ($fetchAverage2['note_moyenne'] >= 4 && $fetchAverage2['note_moyenne'] < 5){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>';
                                    }

                                case "5":
                                    if ($fetchAverage2['note_moyenne'] == 5){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>';
                                    }
                                }
                        ?>
                    </div>
                    <?php
                        echo "<h3>Moyenne : </h3>" . "<p class='moyenne'>$fetchAverage2[note_moyenne]</p>
                            <p class='eval'>(sur un total de $fetchAverage2[total_avis] évaluation(s))</p>" . 
                            "\n" . "<h3>Meilleur commentaire : </h3>" .
                            "<p class='commentaire'>$fetchAverage2[commentaire]</p>" . "<br />"; 
                    ?>
                </div>   

            <?php
                $select_eval3 = "SELECT * FROM avis";
                $select_eval3 = mysqli_query($con, "SELECT nom_vendeur AS vendeur, ROUND(AVG(note),1)
                    AS note_moyenne, COUNT(*) AS total_avis, avis AS commentaire
                    FROM avis WHERE idvendeur = 3")
                    or exit("Echec de la requête");
                $fetchAverage3 = mysqli_fetch_assoc($select_eval3);
            ?>

                <div class="box">                        
                    <?php
                        echo "<h3>$fetchAverage3[vendeur]</h3>";
                    ?>

                    <div class="note">
                        <?php 
                            switch ($_SERVER["REQUEST_METHOD"] == "POST"){
                                case "0":
                                    if($fetchAverage3['note_moyenne'] >= 0 && $fetchAverage3['note_moyenne'] < 1){
                                        echo '<i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }

                                case "1":
                                    if ($fetchAverage3['note_moyenne'] >= 1 && $fetchAverage3['note_moyenne'] < 2){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }

                                case "2":
                                    if ($fetchAverage3['note_moyenne'] >= 2 && $fetchAverage3['note_moyenne'] < 3){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }
                                
                                case "3":
                                    if ($fetchAverage3['note_moyenne'] >= 3 && $fetchAverage3['note_moyenne'] < 4){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>
                                            <i class="fa-regular fa-star" style="color: black;"></i>';
                                        }

                                case "4":
                                    if ($fetchAverage3['note_moyenne'] >= 4 && $fetchAverage3['note_moyenne'] < 5){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star-half-alt" style="color: goldenrod;"></i>';
                                    }

                                case "5":
                                    if ($fetchAverage3['note_moyenne'] == 5){
                                        echo '<i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>
                                            <i class="fa fa-star" style="color: goldenrod;"></i>';
                                    }
                                }
                        ?>
                    </div>
                    <?php
                        echo "<h3>Moyenne : </h3>" . "<p class='moyenne'>$fetchAverage3[note_moyenne]</p>
                            <p class='eval'>(sur un total de $fetchAverage3[total_avis] évaluation(s))</p>" .
                            "\n" . "<h3>Meilleur commentaire : </h3>" .
                            "<p class='commentaire'>$fetchAverage3[commentaire]</p>" . "<br />"; 
                    ?>
                </div>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>