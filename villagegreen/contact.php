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
   header('location:user_login.php');
};

//paramétrage de la fonction d'envoi du message
if (isset($_POST['envoyer'])) {

   //déclaration des variables
   $nom = $_POST['nom'];
   //'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
   $nom = htmlspecialchars($nom);
   $prenom = $_POST['prenom'];
   $prenom = htmlspecialchars($prenom);
   $email = $_POST['email'];
   $email = htmlspecialchars($email);
   $telephone = $_POST['telephone'];
   $telephone = htmlspecialchars($telephone);
   $msg = $_POST['msg'];
   $msg = htmlspecialchars($msg);

   //connexion à la table 'messages' dans la BDD
   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE nom = ? AND prenom = ? AND email = ? AND telephone = ? AND message = ?");
   $select_message->execute([$nom, $prenom, $email, $telephone, $msg]);

   //si le message a déjà été envoyé on renvoie un erreur
   if ($select_message->rowCount() > 0) {
      $message[] = 'Message déjà envoyé !';
   } else {

      //sinon on insère les données dans la table
      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, nom, prenom, email, telephone, message)
         VALUES(?,?,?,?,?,?)");
      $insert_message->execute([$user_id, $nom, $prenom, $email, $telephone, $msg]);

      //et on renvoie ce message de confirmation
      $message[] = 'Message envoyé !';
   }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

   <!-- on inclut le header du site -->
   <?php include 'components/user_header.php'; ?>

   <!-- formulaire de contact -->
   <section class="contact">

      <h3 class="heading">Contactez-nous !</h3>

      <form action="" method="post">

         <input type="text" name="nom" placeholder="entrer votre nom" required maxlength="20" class="box">
         <input type="text" name="prenom" placeholder="entrer votre prénom" required maxlength="20" class="box">
         <input type="email" name="email" placeholder="entrer votre email" required maxlength="50" class="box">
         <input type="number" name="telephone" min="0" max="9999999999" placeholder="enter votre numéro de téléphone" required class="box">
         <textarea name="msg" class="box" placeholder="entrer votre message" cols="30" rows="10"></textarea>
         <input type="submit" value="Envoyer" name="envoyer" class="option-btn">
      </form>

   </section>

   <!-- on inclut le footer -->
   <?php include 'components/footer.php'; ?>

   <script src="assets/js/script.js"></script>

</body>

</html>