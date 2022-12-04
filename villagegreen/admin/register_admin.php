<?php

//connexion à la BDD
include '../components/connect.php';

//début de la session
session_start();

// si l'admin est connecté le dashboard s'affiche
$admin_id = $_SESSION['admin_id'];

// s'il n'est pas connecté il est renvoyé sur le formulaire de login
if (!isset($admin_id)) {
   header('location:admin_login.php');
}

//paramétrage de la fonction d'enregistrement
if (isset($_POST['submit'])) {

   //déclaration des variables
   $name = $_POST['name'];
   // 'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
   $name = htmlspecialchars($name);
   //'sha1' : hachage du mot de passe
   $pass = sha1($_POST['pass']);
   $pass = htmlspecialchars($pass);
   $cpass = sha1($_POST['cpass']);
   $cpass = htmlspecialchars($cpass);

   //connexion à la table 'admins'
   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE nom = ?");
   $select_admin->execute([$name]);

   if ($select_admin->rowCount() > 0) {
      //si le nom de l'admin existe déjà on renvoie ce message
      $message[] = 'Cet admin existe déjà !';
   } else {
      if ($pass != $cpass) {
         //si la vérification de mot de passe échoue on revoie ce message
         $message[] = 'Les mots de passe ne correspondent pas !';
      } else {
         //sinon on insère les données dans la table 'admins'
         $insert_admin = $conn->prepare("INSERT INTO `admins`(nom, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'Nouvel admin enregistré !';
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
   <title>Inscription admin</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <!-- formulaire d'enregistrement -->
   <section class="form-container">

      <form action="" method="post">
         <h3>Inscription</h3>
         <!-- 'this.value.replace(/\s/g, '')' : regex pour supprimer les espaces dans le champs -->
         <input type="text" name="name" required placeholder="entrer votre nom" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="entrer votre mot de passe" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" required placeholder="confirmer votre mot de passe" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="S'inscrire" class="option-btn" name="submit">
      </form>

   </section>

   <script src="assets/js/admin_script.js"></script>

</body>

</html>