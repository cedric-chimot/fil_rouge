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

//lien de la fonction d'ajout au panier
include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Produits</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="products">

      <h1 class="heading">Nos produits</h1>

      <div class="box-container">

         <?php
         //connexion à la table 'products' dans la BDD
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            //on créé un tableau associatif par un fetch pour renvoyer les données de la table 'products'
            while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
         ?>
            <!-- si des produits existent on affiche le formulaire -->
               <form action="" method="post" class="box">
                  <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                  <input type="hidden" name="name" value="<?= $fetch_product['libelle']; ?>">
                  <input type="hidden" name="price" value="<?= $fetch_product['prix']; ?>">
                  <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">
                  <img src="assets/images/BODY/<?= $fetch_product['image']; ?>" alt="">
                  <div class="name"><?= $fetch_product['libelle']; ?></div>
                  <div class="flex">
                     <div class="price"><span><?= $fetch_product['prix']; ?> €<span></div>
                     <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                  </div>
                  <input type="submit" value="Ajouter au panier" class="option-btn" name="add_to_cart">
               </form>
         <?php
            }
         } else {
            //sinon on affiche cette phrase
            echo '<p class="empty">Aucun produits trouvés !</p>';
         }
         ?>

      </div>

   </section>

   <?php include 'components/footer.php'; ?>

   <script src="assets/js/script.js"></script>

</body>

</html>