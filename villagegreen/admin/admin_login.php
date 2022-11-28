<?php

//on se connecte à la BDD
include '../components/connect.php';

//lancement de la session
session_start();

//à l'appui du bouton se connecter
if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    // 'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
    $name = htmlspecialchars($name);
    $password = htmlspecialchars(md5($_POST['password']));

    // connection à la table 'admins' dans la BDD
    $select_admin = $conn->prepare("SELECT * FROM `admin`
        WHERE nom = ? AND mdp = ?");
    $select_admin->execute([$name, $password]);
    // 'fetch' : Récupère la ligne suivante d'un jeu de résultats PDO
    $row = $select_admin->fetch(PDO::FETCH_ASSOC);

    // 'rowcount' : Retourne le nombre de lignes affectées par le dernier appel à la fonction PDOStatement::execute()
    if ($select_admin->rowCount() > 0) {
        //  lorsque l'admin est connecté correctement on le renvoie vers le dashboard
        $_SESSION['admin_id'] = $row['admin_id'];
        header('location:dashboard.php');
        $message = "Connection réussie !";
    } else {
        // sinon un message d'erreur s'affiche
        $message[] = 'Utilisateur ou mot de passe incorrect !';
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