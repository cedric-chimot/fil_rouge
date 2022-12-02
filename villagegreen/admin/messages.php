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
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

   <!-- lien du header du tableau de bord -->
   <?php include '../components/admin_header.php'; ?>

   <section class="contacts">

      <h1 class="heading">Messages</h1>

      <div class="box-container">

         <?php
         // connexion à la table 'messages'
         $select_messages = $conn->prepare("SELECT * FROM `messages`");
         $select_messages->execute();
         if ($select_messages->rowCount() > 0) {
            //par association on récupère les données de la table 'messages'
            while ($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <!-- s'il y a un message on l'affiche sur la page -->
               <div class="box">
                  <p> user id : <span><?= $fetch_message['user_id']; ?></span></p>
                  <p> Nom : <span><?= $fetch_message['nom']; ?></span></p>
                  <p> Prenom : <span><?= $fetch_message['prenom']; ?></span></p>
                  <p> Email : <span><?= $fetch_message['email']; ?></span></p>
                  <p> Telephone : <span><?= $fetch_message['telephone']; ?></span></p>
                  <p> Message : <span><?= $fetch_message['message']; ?></span></p>
                  <a href="messages.php??delete=<?= $fetch_message['id']; ?>" onclick="return confirm('Supprimer ce message ?');" class="delete-btn">Supprimer</a>
               </div>
         <?php
            }
         } else {
            // s'il n'y a pas de message cette phrase s'affiche
            echo '<p class="empty">Vous n\'avez pas de messages</p>';
         }
         ?>

      </div>

   </section>

   <script src="assets/js/admin_script.js"></script>

</body>

</html>