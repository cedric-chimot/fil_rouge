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

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Rechercher</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="search-form">
      <form action="" method="post">
         <input type="text" name="search_box" placeholder="Rechercher..." maxlength="100" class="box" required>
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>
   </section>

   <section class="products" style="padding-top: 0; min-height:100vh;">

      <div class="box-container">

         <?php
         //fonction sur le clique de l'input ou du bouton de recherche
         if (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
            $search_box = $_POST['search_box'];
            // on va chercher les données de la table produits correspondantes à la recherche
            $select_products = $conn->prepare("SELECT * FROM `products`
               WHERE libelle LIKE '%{$search_box}%'
               OR categorie LIKE '%{$search_box}%'");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
               //à l'aide d'une boucle on associe les produits de la BDD
               while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
         ?>
                  <!-- si le produit recherché existe dans la table on renvoie ce formulaire -->
                  <form action="" method="post" class="box">
                     <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                     <input type="hidden" name="name" value="<?= $fetch_product['libelle']; ?>">
                     <input type="hidden" name="price" value="<?= $fetch_product['prix']; ?>">
                     <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">
                     <img src="assets/images/BODY/<?= $fetch_product['image']; ?>" alt="">
                     <div class="name"><?= $fetch_product['libelle']; ?></div>
                     <div class="flex">
                        <div class="price"><span><?= $fetch_product['prix'] . ' €'; ?><span></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" value="1">
                     </div>
                     <input type="submit" value="Ajouter au panier" class="option-btn" name="add_to_cart">
                  </form>
         <?php
               }
            } else {
               //s'il aucun produit n'est trouvé ce message s'affiche
               echo '<p class="empty">Aucun produit ne correspond à votre recherche !</p>';
            }
         }
         ?>

      </div>

   </section>

   <?php include 'components/footer.php'; ?>

   <script src="assets/js/script.js"></script>

</body>

</html>