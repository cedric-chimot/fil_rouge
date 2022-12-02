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

//paramétrage de la fonction de modification
if (isset($_POST['submit'])) {

   //déclaration des variables
   $pseudo = $_POST['pseudo'];
   $pseudo = htmlspecialchars($pseudo);
   $email = $_POST['email'];
   $email = htmlspecialchars($email);

   //connexion à la table 'users' et préparation de l'update par rapport à l'ID
   $update_profile = $conn->prepare("UPDATE `users` SET pseudo = ?, email = ? WHERE id = ?");
   $update_profile->execute([$pseudo, $email, $user_id]);

   /* '$empty_pass' : mot de passe fictif pour vérifier que le champ de l'ancien
      mot de passe n'est pas vide */
   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];
   //'sha1' : hachage du mot de passe
   //'htmlspecialchars' : convertit les caractères spéciaux en entité HTML
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = htmlspecialchars($old_pass);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = htmlspecialchars($new_pass);
   $cpass = sha1($_POST['cpass']);
   $cpass = htmlspecialchars($cpass);

   //vérification de l'ancien mot de passe
   if ($old_pass == $empty_pass) {
      //si le champs est vide on renvoie ce message
      $message[] = 'Veuillez entrer l\'ancien mot de passe !';
   } elseif ($old_pass != $prev_pass) {
      //si la vérification échoue on renvoie ce message
      $message[] = 'Le mot de passe est erronné !';
   } elseif ($new_pass != $cpass) {
      //si la confirmation échoue on renvoie ce message
      $message[] = 'Les mots de passe ne correspondent pas !';
   } else {
      //si la vérification est correcte on se connecte à la table 'users'
      if ($new_pass != $empty_pass) {
         $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$cpass, $user_id]);
         //quand la modification est effective on renvoie ce message
         $message[] = 'Mot de passe modifié avec succès !';
      } else {
         //sinon ce message s'affiche
         $message[] = 'Veuillez entrer un nouveau mot de passe !';
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
   <title>Modifier</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="form-container">

   <!-- formulaire de modification -->
      <form action="" method="post">
         <h3>Modifier le mot de passe</h3>
         <!-- input type 'hidden' pour lier le mot de passe actuel -->
         <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
         <!-- on affiche les données de l'utilisateur connecté -->
         <input type="text" name="pseudo" required placeholder="votre pseudo" maxlength="20"
            class="box" value="<?= $fetch_profile["pseudo"]; ?>">
         <!-- 'this.value.replace(/\s/g, '')' : regex pour supprimer les espaces dans le champs -->
         <input type="email" name="email" required placeholder="votre email" maxlength="50"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">
         <input type="password" name="old_pass" placeholder="entrer votre mot de passe" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="new_pass" placeholder="entrer le nouveau mot de passe" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" placeholder="confirmer le nouveau mot de passe" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="Modifier" class="option-btn" name="submit">
      </form>

   </section>

   <?php include 'components/footer.php'; ?>

   <script src="assets/js/script.js"></script>

</body>

</html>