<?php

//connexion à la BDD
include '../components/connect.php';

//début de la session
session_start();

//fonction de login de l'admin
if (isset($_POST['submit'])) {

   //déclaration des variables
   $nom = $_POST['nom'];
   //'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
   $nom = htmlspecialchars($nom);
   //'sha1' : calcul du hachage du mot de passe
   $password = sha1($_POST['password']);
   $password = htmlspecialchars($password);

   //connexion à la table 'admins' dans la BDD
   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE nom = ? AND password = ?");
   $select_admin->execute([$nom, $password]);
   //association par fetch pour extraire les données
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if ($select_admin->rowCount() > 0) {
      //si l'admin est connecté correctement on le renvoie sur le tableau de bord
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');
   } else {
      //sinon on renvoie un message d'erreur
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
   <title>login</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

   <?php
   //fonction d'affichage des différents messages(login, ajout au panier, informations diverses etc...)
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   ?>

   <!-- formulaire de login -->
   <section class="form-container">

      <form action="" method="post">
         <h3>Se connecter</h3>
         <p>Utilisateur par défaut = <span>admin</span> & password = <span>111</span></p>
         <input type="text" name="nom" required placeholder="Nom d'utilisateur" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="password" required placeholder="Mot de passe" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="Se connecter" class="option-btn" name="submit">
      </form>

   </section>

</body>

</html>