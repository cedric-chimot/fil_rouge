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

//paramétrage de la fonction 'delete'
if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   //on supprime le compte d'admin par rapport à l'ID
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   //on renvoie ensuite vers la page de login
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Compte d'admin</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="accounts">

      <h1 class="heading">Compte d'administrateur</h1>

      <div class="box-container">

         <div class="box">
            <p>Ajouter un admin</p>
            <a href="register_admin.php" class="option-btn">Créer</a>
         </div>

         <?php
         //connexion à la table 'admins' dans la BDD
         $select_accounts = $conn->prepare("SELECT * FROM `admins`");
         $select_accounts->execute();
         if ($select_accounts->rowCount() > 0) {
            // création par un fetch d'un tableau associatif pour récupérer les données de la table 'users'
            while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <div class="box">
                  <!-- on retourne l'ID et le nom des admins -->
                  <p>  ID admin : <span><?= $fetch_accounts['id']; ?></span> </p>
                  <p> Nom : <span><?= $fetch_accounts['nom']; ?></span> </p>
                  <div class="flex-btn">
                     <!-- bouton de suppresion du compte d'administrateur -->
                     <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Supprimer ce compte ?')"
                        class="delete-btn">Supprimer</a>
                     <?php
                     //l'admin connecté a accès au formulaire de modification de son compte
                     if ($fetch_accounts['id'] == $admin_id) {
                        echo '<a href="update_profile.php" class="option-btn">Modifier</a>';
                     }
                     ?>
                  </div>
               </div>
         <?php
            }
         } else {
            // s'il n'y a aucun admin inscrit on renvoie ce message
            echo '<p class="empty">Aucun compte d\'administrateur</p>';
         }
         ?>

      </div>

   </section>

   <script src="assets/js/admin_script.js"></script>

</body>

</html>