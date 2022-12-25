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

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Commandes</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

   <!-- on inclut le header du site -->
   <?php include 'components/user_header.php'; ?>

   <section class="orders">

      <h1 class="heading">Commandes effectuées</h1>

      <div class="box-container">

         <?php
         //si l'utilisateur n'est pas connecté ce message s'affiche
         if ($user_id == '') {
            echo '<p class="empty">Veuillez vous connecter pour voir vos commandes passées !</p>';
         } else {
            //sinon on se connecte à la table 'orders' par rapport à l'ID de l'utilisateur
            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
            $select_orders->execute([$user_id]);
            if ($select_orders->rowCount() > 0) {
               //association par un fetch pour retourner les données de la table 'orders'
               while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
         ?>
                  <!-- si une commande existe on l'affiche -->
                  <div class="box">
                     <p>Numéro de commande : <span><?= $fetch_orders['id']; ?></span></p>
                     <p>Date de la commande : <span><?= $fetch_orders['date_commande']; ?></span></p>
                     <p>Votre commande : <span><?= $fetch_orders['total_produits']; ?></span></p>
                     <p>Montant total : <span><?= $fetch_orders['prixTTC']; ?> €</span></p>
                     <!-- suivant le statut de la commande la couleur change -->
                     <p>Statut de la commande :
                        <span style="color:<?php if ($fetch_orders['statut_commande'] == 'en attente') {
                                                echo 'blue';
                                             } elseif ($fetch_orders['statut_commande'] == 'terminee') {
                                                echo 'green';
                                             } elseif ($fetch_orders['statut_commande'] == 'retard') {
                                                echo 'violet';
                                             } elseif ($fetch_orders['statut_commande'] == 'annulee') {
                                                echo 'red';
                                             }; ?>"><?= $fetch_orders['statut_commande']; ?>
                        </span>
                     </p>
                     <!-- le bouton d'accès aux commentaires est inactif si le statut de la commande est autre que 'terminée' -->
                     <a href="reviews.php" class="option-btn
                        <?= ($fetch_orders['statut_commande'] == 'terminee')?'':'disabled'; ?>
                        <?= ($fetch_orders['statut_commande'] == 'en attente' ||
                              $fetch_orders['statut_commande'] == 'annulee' ||
                              $fetch_orders['statut_commande'] == 'retard')?'':'enabled'; ?>">
                        Donner votre avis
                     </a>
                  </div>
         <?php
               }
            } else {
               //si aucune commandes n'a été passée on affiche ce message
               echo '<p class="empty">Aucune commandes !</p>';
            }
         }
         ?>

      </div>

   </section>

   <!-- on inclut le footer du site -->
   <?php include 'components/footer.php'; ?>

   <script src="assets/js/script.js"></script>

</body>

</html>