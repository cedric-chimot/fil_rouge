<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

//on inclut la fonction d'ajout au panier
include 'components/ajout_panier.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Categories</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

   <?php include 'user_header.php'; ?>

   <section class="products">

      <h1 class="heading">Catégories</h1>

      <div class="box-container">
         <?php
         $category = $_GET["categorie"];
         // on fait correspondre l'image dans la page d'accueil avec la catégorie dans la BDD
         $select_products = $conn->prepare("SELECT * FROM `produits` WHERE categorie LIKE '%{$category}%'");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            //à l'aide d'une boucle on associe les produits de la BDD
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <form action="" class="box">
                  <input type="hidden" name="idproduit" value="<?php $fetch_products['idproduit']; ?>">
                  <input type="hidden" name="libelle" value="<?php $fetch_products['libelle']; ?>">
                  <input type="hidden" name="description" value="<?php $fetch_products['description']; ?>">
                  <input type="hidden" name="prix" value="<?php $fetch_products['prix']; ?>">
                  <input type="hidden" name="categorie" value="<?php $fetch_products['categorie']; ?>">
                  <input type="hidden" name="image" value="<?php $fetch_products['image']; ?>">
                  <img src="assets/images/BODY/<?= $fetch_products['image']; ?>" alt="">
                  <div class="name"><?= $fetch_products['libelle']; ?></div>
                  <div class="flex">
                     <div class="price"><?= $fetch_products['prix']; ?><span> €</span></div>
                     <!-- on paramètre la qunatité de base à '1', sinon on renvoie false -->
                     <input type="number" name="qte" class="qte" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                  </div>
                  <input type="submit" value="Ajouter au panier" class="option-btn" name="ajout_panier">
               </form>
         <?php
            }
         } else {
            echo '<p class="empty">Aucun produit trouvé !</p>';
         }
         ?>
      </div>

   </section>


   <?php include 'footer.php'; ?>


   <script src="assets/js/script.js"></script>

</body>

</html>