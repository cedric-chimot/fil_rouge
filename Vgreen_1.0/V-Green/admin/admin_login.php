<?php

//connexion à la base de données
include '../components/connect.php';

//ouverture de la session
session_start();

if (isset($_POST['submit'])) {
    //déclaration des variables
    $password = mysqli_real_escape_string($con, md5($_POST['password']));

    //connexion à la table 'utilisateur'
    $select_user = mysqli_query($con, "SELECT * FROM `admin`
        WHERE mdp = '$password'")
        //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');

    //on vérifie si l'utilisateur existe
    if (mysqli_num_rows($select_user) > 0) {
        $row = mysqli_fetch_assoc($select_user);

        //si c'est un admin il est redirigé vers le tableau de bord
        if ($row['type_user'] == 'admin') {
            $_SESSION['admin_nom'] = $row['nom'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:dashboard.php');
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
    <title>login_admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

    <?php
        if(isset($message)){
            foreach($message as $message){
                echo '
                    <div class="message">
                        <span>' .$message. '</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>';
            }
        }
    ?>

    <section class="form-container">

        <form action="" method="post">
            <h3>Connectez-vous</h3>
            <p>Utilisateur par défaut = <span>admin</span> & password = <span>111</span></p>
            <!-- 'oninput' : La valeur d'un élément change ou le contenu d'un élément avec l'attribut contenteditable est modifié. -->
            <input type="text" name="name" required placeholder="entrer votre nom" maxlength="20"
                class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="password" required placeholder="entrer votre mot de passe" maxlength="20"
                class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Se connecter" class="btn" name="submit">
            <p>Vous n'avez pas encore de compte ? <a href="register_admin.php">S'inscrire</a></p>
        </form>

    </section>

</body>

</html>