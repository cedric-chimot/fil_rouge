<?php

//connexion à la base de données
include 'components/connect.php';

if (isset($_POST['submit'])) {

    //déclaration des variables en rapport avec les inputs
    $nom = mysqli_real_escape_string($con, $_POST['nom']);
    $prenom = mysqli_real_escape_string($con, $_POST['prenom']);
    $adresse = mysqli_real_escape_string($con, $_POST['adresse']);
    $cp = mysqli_real_escape_string($con, $_POST['cp']);
    $ville = mysqli_real_escape_string($con, $_POST['ville']);
    $telephone = mysqli_real_escape_string($con, $_POST['telephone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, md5($_POST['password']));       //"Md5" calcul le hachage de la chaine de caractère
    $cpassword = mysqli_real_escape_string($con, md5($_POST['cpassword']));

    //connexion à la table 'utilisateur' de la BDD
    $select_user = mysqli_query($con, "SELECT * FROM `client`
        WHERE email = '$email' AND mdp = '$password'")
        //'or exit' Affiche un message et termine le script courant
        or exit('Echec de la requête');

    //on vérifie si l'utilisateur existe ou pas
    if (mysqli_num_rows($select_user) > 0) {
        $message[] = 'Utilisateur existant';
    } else {
        //ensuite on vérifie que les mots de passe correspondent
        if ($password != $cpassword) {
            $message[] = 'Les mots de passe ne correspondent pas !';
        } else {
            //enfin on insère les données dans la table
            mysqli_query($con, "INSERT INTO `client`(nom, prenom, adresse, cp, ville, telephone, email, mdp)
                VALUES ('$nom', '$prenom', '$adresse', '$cp', '$ville', '$telephone', '$email', '$password')")
                or exit('Echec de la requête');
            //le messge de confirmation s'inscrit
            $message[] = 'Inscription réussie';
            //redirection vers la page d'accueil
            header('location:home.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <title>S'inscrire</title>
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
            <h3>S'inscrire</h3>
            <input type="text" name="nom" placeholder="Nom" class="box" required>
            <input type="text" name="prenom" placeholder="prenom" class="box" required>
            <input type="text" name="adresse" placeholder="Adresse" class="box" required>
            <input type="text" name="cp" placeholder="Code Postal" class="box" required>
            <input type="text" name="ville" placeholder="Ville" class="box" required>
            <input type="text" name="telephone" placeholder="Telephone" class="box" required>
            <input type="email" name="email" placeholder="Email" class="box" required>
            <input type="password" name="password" placeholder="Choisissez votre mot de passe" class="box" required>
            <input type="password" name="cpassword" placeholder="Confirmer votre mot de passe" class="box" required>
            <input type="submit" name="submit" value="S'inscrire" class="btn">
            <button class="delete-btn"><a href="home.php">Annuler</a></button>
            <p>Vous êtes déjà client ? <a href="user_login.php">Se connecter</a></p>
        </form>

    </div>

    <script src="assets/js/script.js"></script>

</body>

</html>