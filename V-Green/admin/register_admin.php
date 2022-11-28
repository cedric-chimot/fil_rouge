<?php

//connexion à la base de données
include '../components/connect.php';

if (isset($_POST['submit'])) {

    //déclaration des variables en rapport avec les inputs
    $nom = mysqli_real_escape_string($con, $_POST['name']);
    $password = mysqli_real_escape_string($con, md5($_POST['password']));       //"Md5" calcul le hachage de la chaine de caractère
    $cpassword = mysqli_real_escape_string($con, md5($_POST['cpassword']));

    //connexion à la table 'admin' de la BDD
    $select_user = mysqli_query($con, "SELECT * FROM `admin`
        WHERE mdp = '$password'")
        //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');

    //on vérifie si l'utilisateur existe ou pas
    if (mysqli_num_rows($select_user) > 0) {
        $message[] = 'admin existant';
    } else {
        //ensuite on vérifie que les mots de passe correspondent
        if ($password != $cpassword) {
            $message[] = 'Les mots de passe ne correspondent pas !';
        } else {
            //enfin on insère les données dans la table
            mysqli_query($con, "INSERT INTO `admin`(nom, mdp) VALUES ('$nom', '$password')")
                or exit('Echec de la requête');
            //le messge de confirmation s'inscrit
            $message[] = 'Inscription réussie';
            //redirection vers la page de login
            header('location:dashboard.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>s'inscrire</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

    <section class="form-container">

        <form action="" method="POST">
            <h3>Inscrivez-vous</h3>
            <input type="text" class="box" name="name" placeholder="entrer votre nom" required>
            <input type="password" class="box" name="password" placeholder="entrer votre mot de passe" required>
            <input type="password" class="box" name="cpassword" placeholder="confirmer votre mot de passe" required>
            <input type="submit" class="btn" name="submit" value="S'inscrire">
            <button class="delete-btn"><a href="home.php"></a>Annuler</button>
            <p>Vous possédez déjà un compte ? <a href="admin_login.php">Se connecter</a></p>
        </form>

    </section>


</body>

</html>