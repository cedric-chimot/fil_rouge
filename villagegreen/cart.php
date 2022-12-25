<?php

//connexion à la BDD
include 'components/connect.php';

//début de la session
session_start();

//si l'ulisateur est connecté on renvoie ses identifiants
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   //sinon on le renvoie vers la page de login
   $user_id = '';
   header('location:user_login.php');
};

//fonction de suppression d'un article du panier
if (isset($_POST['delete'])) {
   $cart_id = $_POST['cart_id'];
   //on se connecte à la table 'cart' et on prend l'ID correspondant au produit
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

//fonction de suppression de tous les articles du panier
if (isset($_GET['delete_all'])) {
   //on se connecte à la table 'cart' et on supprime les articles par rapport à l'ID de l'utilisateur
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   //on le renvoie ensuite au panier
   header('location:cart.php');
}

//fonction de mise à jour de la quantité d'un produit dans le panier
if (isset($_POST['update_qty'])) {
   //on va chercher l'input lié à l'ID de la ligne du panier
   $cart_id = $_POST['cart_id'];
   //on va chercher la quantité
   $qty = $_POST['qty'];
   //'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
   $qty = htmlspecialchars($qty);
   //MAJ du panier par la quantité en rapport avec l'ID de la ligne
   $update_qty = $conn->prepare("UPDATE `cart` SET quantite = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   //une fois la MAJ faite le message correspondant s'affiche
   $message[] = 'Quantité modifiée !';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Panier</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="products shopping-cart">

      <h3 class="heading">Votre panier</h3>

      <div class="box-container">

         <?php
         //on paramètre la variable 'total' de base égale à 0
         $total = 0;
         //on se connecte à la table panier en sélectionnant l'ID de l'utilisateur
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         // Retourne le nombre de lignes affectées par le dernier appel à la fonction
         if ($select_cart->rowCount() > 0) {
            // Récupère la ligne suivante d'un ensemble de résultats PDO
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
         ?>
         <!-- si des données existent le formulaire suivant s'affiche -->
               <form action="" method="post" class="box">
                  <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                  <img src="assets/images/BODY/<?= $fetch_cart['image']; ?>" alt="">
                  <div class="name"><?= $fetch_cart['libelle']; ?></div>
                  <div class="flex">
                     <div class="price"><?= $fetch_cart['prix']; ?> €</div>
                     <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantite']; ?>">
                     <button type="submit" class="fas fa-edit" name="update_qty"></button>
                  </div>
                  <div class="sub-total">
                     <!-- on crée une variable Sous-total correspondant au prix multiplié par la quantité -->
                     Sous-total : <span><?= $sous_total = ($fetch_cart['prix'] * $fetch_cart['quantite']); ?> €</span>
                  </div>
                  <input type="submit" value="Supprimer" onclick="return confirm('Supprimer cet article ?');" class="delete-btn" name="delete">
               </form>
         <?php
            //la varible 'total' est alors égale à l'addition des différents sous-totaux
               $total += $sous_total;
            }
         } else {
            //sinon on affiche ce message
            echo '<p class="empty">Votre panier est vide !</p>';
         }
         ?>
      </div>

      <div class="cart-total">
         <!-- on affiche le total à payer -->
         <p>Total à payer : <span><?= $total; ?> €</span></p>
         <a href="shop.php" class="option-btn">Continuer vos achats</a>
         <!-- 'disabled' : si le panier est vide les boutons sont inactifs -->
         <a href="cart.php?delete_all" class="delete-btn <?= ($total > 1)?'':'disabled'; ?>" onclick="return confirm('Vider votre panier ?');">Vider le panier</a>
         <a href="checkout.php" class="btn <?= ($total > 1)?'':'disabled'; ?>">Passer la commande</a>
      </div>

   </section>


   <?php include 'components/footer.php'; ?>

   <script src="assets/js/script.js"></script>

</body>

</html>