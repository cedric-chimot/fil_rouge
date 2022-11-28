<?php

//connexion à la base de données
include 'admins/config.php';

//ouverture de la session
session_start();

if (isset($_POST['submit'])) {
    //déclaration des variables
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, md5($_POST['password']));

    //connexion à la table 'utilisateur'
    $select_vendeur = mysqli_query($con, "SELECT * FROM `vendeur`
        WHERE email = '$email' AND password = '$password'")
        //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');

    //on vérifie si l'utilisateur existe
    if (mysqli_num_rows($select_vendeur) > 0) {
        $row = mysqli_fetch_assoc($select_vendeur);

        //si c'est un admin il est redirigé vers le tableau de bord
        if ($row['type_user'] == 'vendeur') {
            $_SESSION['vendeur_nom'] = $row['nom'];
            $_SESSION['vendeur_email'] = $row['email'];
            $_SESSION['vendeur_id'] = $row['idvendeur'];
            header('location:board_vendeur.php');
        }
        } else {
            //message affiché si le mot de passe est incorrect
            $message[] = 'Email ou mot de passe incorrect';
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
    <link rel="stylesheet" href="../css/style.css">
    <title>Se connecter</title>
</head>

<body>

    <?php
    //variable message avec option de suppression qui s'affiche en cas d'action spécifique
    //ajout d'une annonce, modification d'une commande, suppression d'utilisateurs etc...
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
            <div class="message">
                <span>' . $message . '</span>
                <i class="fa fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        ';
        }
    }

    ?>

    <!-- formulaire de connexion -->
    <div class="form-container">

        <form action="" method="post">
            <h3>Se connecter</h3>
            <input type="email" name="email" placeholder="Email" class="box" required>
            <input type="password" name="password" placeholder="Saisissez votre mot de passe" class="box" required>
            <input type="submit" name="submit" value="Se connecter" class="btn">
            <button class="delete-btn"><a href="home.php">Annuler</a></button>
            <p>Vous n'êtes pas encore inscrit ? <a href="inscrire_vendeur.php">S'inscrire</a></p>
        </form>

    </div>


</body>

</html>