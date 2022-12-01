<?php

//on se connecte à la BDD
include '../components/connect.php';

//lancement de la session
session_start();

// si l'admin est connecté le dashboard s'affiche
$admin_id = $_SESSION['admin_id'];

// s'il n'est pas connecté il est renvoyé sur le formulaire de login
if(isset($admin_id)){
    header('location:admin_login.php');
}

//lorsque l'on appuie sur le bouton 'submit'
if(isset($_POST['submit'])){

    //déclaration des variables
    $name = $_POST['name'];
    //'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
    $name = htmlspecialchars($name);
    $password = htmlspecialchars(md5($_POST['password']));       //"Md5" calcul le hachage de la chaine de caractère
    $cpassword = htmlspecialchars(md5($_POST['cpassword']));

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE nom = ?");
    $select_admin->execute([$name]);

    //si l'admin existe déjà on renvoie un message d'erreur
    if($select_admin->rowCount() > 0){
        $message[] = 'Utilisateur existant !';
    }else{
        //on vérifie si les mdp sont identiques
        if($password != $cpassword){
            //si non, message d'erreur
            $message[] = 'Les mots de passe ne correspondent pas !';
        }else{
            //si oui on insère les données dans la BDD
            $insert_admin = $conn->prepare("INSERT INTO `admin`(nom, mdp) VALUES(?,?)");
            $insert_admin->execute([$name, $cpassword]);
            $message[] = 'Inscription réussie !';
            //renvoie sur le tableau de bord
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