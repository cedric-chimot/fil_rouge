<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

if (isset($_POST['envoyer'])) {

   $nom = $_POST['nom'];
   $nom = htmlspecialchars($nom);
   $prenom = $_POST['prenom'];
   $prenom = htmlspecialchars($prenom);
   $email = $_POST['email'];
   $email = filter_var($email);
   $telephone = $_POST['telephone'];
   $telephone = filter_var($telephone);
   $msg = $_POST['msg'];
   $msg = filter_var($msg);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE nom = ? AND prenom = ? AND email = ? AND telephone = ? AND message = ?");
   $select_message->execute([$nom, $prenom, $email, $telephone, $msg]);

   if ($select_message->rowCount() > 0) {
      $message[] = 'already sent message!';
   } else {

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, nom, prenom, email, telephone, message)
         VALUES(?,?,?,?,?,?)");
      $insert_message->execute([$user_id, $nom, $prenom, $email, $telephone, $msg]);

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

   <?php include 'components/user_header.php'; ?>

   <section class="contact">

      <h3 class="heading">Contactez-nous !</h3>

      <form action="" method="post">

         <input type="text" name="nom" placeholder="entrer votre nom" required maxlength="20" class="box">
         <input type="text" name="prenom" placeholder="entrer votre prénom" required maxlength="20" class="box">
         <input type="email" name="email" placeholder="entrer votre email" required maxlength="50" class="box">
         <input type="number" name="telephone" min="0" max="9999999999" placeholder="enter votre numéro de téléphone" required class="box">
         <textarea name="msg" class="box" placeholder="entrer votre message" cols="30" rows="10"></textarea>
         <input type="submit" value="Envoyer" name="envoyer" class="btn">
      </form>

   </section>

   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>