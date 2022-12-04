<?php

//on se connecte à la BDD
include '../components/connect.php';

//lancement de la session
session_start();

// si l'admin est connecté le dashboard s'affiche
$admin_id = $_SESSION['admin_id'];

// s'il n'est pas connecté il est renvoyé sur le formulaire de login
if (!isset($admin_id)) {
   header('location:admin_login.php');
}

//paramétrage de la fonction 'delete'
if (isset($_GET['delete'])) {
   //déclaration des variables
   //on va supprimer dans chaque table les informations relatives à l'utilisateur sélectionné
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   //on renvoie ensuite sur la page de gestion des utilisateurs
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Comptes d'utilisateurs</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="accounts">

      <h1 class="heading">Comptes d'utilisateurs</h1>

      <div class="box-container">

         <?php
         //connexion à la table 'users'
         $select_accounts = $conn->prepare("SELECT * FROM `users`");
         $select_accounts->execute();
         if ($select_accounts->rowCount() > 0) {
            // création par un fetch d'un tableau associatif pour récupérer les données de la table 'users'
            while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <div class="box">
                  <!-- affichage des données de l'utilisateur -->
                  <p> Id : <span><?= $fetch_accounts['id']; ?></span> </p>
                  <p> Pseudo : <span><?= $fetch_accounts['pseudo']; ?></span> </p>
                  <p> Email : <span><?= $fetch_accounts['email']; ?></span> </p>
                  <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>"
                     onclick="return confirm('Supprimer ce compte ? Toutes les informations concernant cet utilisateur seront aussi supprimées !')"
                     class="delete-btn">Supprimer
                  </a>
               </div>
         <?php
            }
         } else {
            //s'il n'y a aucun utilisateur on affiche cette phrase
            echo '<p class="empty">Aucun utilisateur inscrit !</p>';
         }
         ?>

      </div>

   </section>

   <script src="assets/js/admin_script.js"></script>

</body>

</html>