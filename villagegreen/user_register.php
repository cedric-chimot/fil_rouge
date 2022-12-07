<?php

//connexion à la BDD
include 'components/connect.php';

//début de la session
session_start();

//si l'ulisateur est connecté on renvoie ses identifiants sinon ça reste vide
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

//fonction pour soumettre le formulaire d'inscription
if (isset($_POST['submit'])) {

   //déclaration des variables
   $pseudo = $_POST['pseudo'];
   $pseudo = htmlspecialchars($pseudo);
   $email = $_POST['email'];
   $email = htmlspecialchars($email);
   //'sha1' : calcul du hachage du mot de passe
   $password = sha1($_POST['password']);
   $password = htmlspecialchars($password);
   $cpassword = sha1($_POST['cpassword']);
   $cpassword = htmlspecialchars($cpassword);

   //connexion à la table 'users' dans la BDD
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($select_user->rowCount() > 0) {
      //si un mail identique est présent dans la BDD ce message d'erreur s'affiche
      $message[] = 'Cet email existe déjà';
   } else {
      //si les mots de passe ne correspondent pas on renvoie une erreur
      if ($password != $cpassword) {
         $message[] = 'Les mots de passe ne correspondent pas !';
      } else {
         //si tout est correct on insère les données dans la BDD
         $insert_user = $conn->prepare("INSERT INTO `users`(pseudo, email, password) VALUES(?,?,?)");
         $insert_user->execute([$pseudo, $email, $cpassword]);
         $message[] = 'Inscription réussie, veuillez vous connecter !';
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
   <title>Inscription</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

   <!-- on inclue le header du site -->
   <?php include 'components/user_header.php'; ?>

   <!-- formulaire d'inscription -->
   <section class="form-container">

      <form action="" method="post" id="register">
         <h3>Inscrivez-vous !</h3>
         <!-- 'this.value.replace(/\s/g, '')' : regex pour supprimer les espaces dans le champs -->
         <input type="text" name="pseudo" required placeholder="entrer votre pseudo" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="email" name="email" required placeholder="entrer votre email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="password" required placeholder="entre votre mot de passe" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpassword" required placeholder="confirmer le mot de passe" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="S'inscrire" class="btn" name="submit">
         <p>Vous êtes déjà inscrit ?</p>
         <a href="user_login.php" class="option-btn">Se connecter</a>
      </form>

   </section>

   <!--  on inclue le footer -->
   <?php include 'components/footer.php'; ?>

   <script src="assets/js/script.js"></script>

</body>

</html>