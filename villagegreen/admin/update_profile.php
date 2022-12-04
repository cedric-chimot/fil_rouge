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

//paramétrage de la fonction de modification
if (isset($_POST['submit'])) {

   //déclaration des variables
   $nom = $_POST['nom'];
   $nom = htmlspecialchars($nom);

   //connexion à la table 'admins' et préparation de l'update par rapport à l'ID
   $update_profile_name = $conn->prepare("UPDATE `admins` SET nom = ? WHERE id = ?");
   $update_profile_name->execute([$nom, $admin_id]);

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
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = htmlspecialchars($confirm_pass);

   //vérification de l'ancien mot de passe
   if ($old_pass == $empty_pass) {
      //si le champs est vide on renvoie ce message
      $message[] = 'Entrer l\'ancien mot de passe !';
   } elseif ($old_pass != $prev_pass) {
      //si la vérification échoue on renvoie ce message
      $message[] = 'Les mots de passe ne correspondent pas !';
   } elseif ($new_pass != $confirm_pass) {
      //si la confirmation échoue on renvoie ce message
      $message[] = 'Veuillez entrer des mots de passe identiques !';
   } else {
      //si la vérification est correcte on se connecte à la table 'admins'
      if ($new_pass != $empty_pass) {
         $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$confirm_pass, $admin_id]);
         //quand la modification est effective on renvoie ce message
         $message[] = 'Mot de passe mis à jour !';
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
   <title>Modifier le profil</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <!-- formulaire de modification -->
   <section class="form-container">

      <form action="" method="post">
         <h3>Modifier le profil</h3>
         <!-- input type 'hidden' pour lier le mot de passe actuel -->
         <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
         <!-- on affiche les données de l'admin connecté -->
         <input type="text" name="name" value="<?= $fetch_profile['nom']; ?>" required placeholder="entrer le nom" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <!-- 'this.value.replace(/\s/g, '')' : regex pour supprimer les espaces dans le champs -->
         <input type="password" name="old_pass" placeholder="entrer l'ancien mot de passe" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="new_pass" placeholder="entrer le nouveau mot de passe" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="confirm_pass" placeholder="confirmer le nouveau mot de passe" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="Modifier" class="option-btn" name="submit">
      </form>

   </section>

   <script src="assets/js/admin_script.js"></script>

</body>

</html>