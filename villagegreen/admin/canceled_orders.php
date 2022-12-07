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

//paramétrage de la fonction 'update' pour le statut de la commande
if (isset($_POST['update_statut'])) {
   $order_id = $_POST['order_id'];
   $statut_commande = $_POST['statut_commande'];
   $statut_commande = htmlspecialchars($statut_commande);
   //requête de modification du statut de commande par rapport à l'ID
   $update_statut = $conn->prepare("UPDATE `orders` SET statut_commande = ? WHERE id = ?");
   $update_statut->execute([$statut_commande, $order_id]);
   //message de confirmation de MAJ
   $message[] = 'Commande mise à jour !';
}

//paramétrage de la fonction 'delete' pour les commandes
if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   //requête de suppression avec lien vers la table 'orders' par l'ID
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   //une fois supprimée, on renvoie sur la page d'administration des commandes
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Commandes</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="orders">

      <h1 class="heading">Commandes annulées</h1>

      <div class="box-container">

         <?php
         //connexion à la table 'orders' dans la BDD
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE statut_commande = ?");
         //affichage des commandes annulées
         $select_orders->execute((['annulee']));
         if ($select_orders->rowCount() > 0) {
            //association par un fetch pour récupérer les données de la table 'orders' dans la BDD
            while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <!-- pour chaques commandes passées on renvoie les données correspondantes -->
               <div class="box">
                  <p> Date commande : <span><?= $fetch_orders['date_commande']; ?></span> </p>
                  <p> Nom : <span><?= $fetch_orders['nom']; ?></span> </p>
                  <p> Prenom : <span><?= $fetch_orders['prenom']; ?></span> </p>
                  <p> Adresse : <span><?= $fetch_orders['adresse']; ?></span> </p>
                  <p> CP : <span><?= $fetch_orders['cp']; ?></span> </p>
                  <p> Ville : <span><?= $fetch_orders['ville']; ?></span> </p>
                  <p> Prix TTC : <span><?= $fetch_orders['prixTTC']; ?> €</span> </p>
                  <!-- suivant le statut de la commande, la couleur change -->
                  <p> Statut commande :
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
                  <!-- formulaire pour actualiser le statut de la commande -->
                  <form action="" method="post">
                     <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                     <!-- liste déroulante pour le statut de commande -->
                     <select name="statut_commande" class="select">
                        <option selected disabled><?= $fetch_orders['statut_commande']; ?></option>
                        <option value="en attente">en attente</option>
                        <option value="terminee">terminee</option>
                        <option value="retard">retard</option>
                        <option value="annulee">annulee</option>
                     </select>
                     <!-- boutons de modification et suppression des commandes -->
                     <div class="flex-btn">
                        <input type="submit" value="Modifier" class="option-btn" name="update_statut">
                        <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Supprimer cette commande ?');">Supprimer</a>
                     </div>
                  </form>
               </div>
         <?php
            }
         } else {
            // s'il n'y a aucune commandes on affiche ce message
            echo '<p class="empty">Aucune commandes !</p>';
         }
         ?>

      </div>

   </section>

   </section>

   <script src="assets/js/admin_script.js"></script>

</body>

</html>