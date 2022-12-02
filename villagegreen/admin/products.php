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

//validation du formulaire pour ajouter des produits
//à l'appui du bouton on ajoute le produit
if (isset($_POST['add_product'])) {

   //déclaration des variables
   $libelle = $_POST['libelle'];
   //'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
   $libelle = htmlspecialchars($libelle);
   $details = $_POST['details'];
   $details = htmlspecialchars($details);
   $prix = $_POST['prix'];
   $prix = htmlspecialchars($prix);
   $categorie = $_POST['categorie'];
   $categorie = htmlspecialchars($categorie);

   //téléchargement de l'image
   $image = $_FILES['image']['name'];
   $image = htmlspecialchars($image);
   $image_size = $_FILES['image']['size'];
   //création d'un fichier temporaire
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'assets/images/' . $image;

   //connexion à la table produit de la BDD
   $select_produits = $conn->prepare("SELECT * FROM `products` WHERE libelle = ?");
   $select_produits->execute([$libelle]);

   //si le produit existe déjà on renvoie un message d'erreur
   if ($select_produits->rowCount() > 0) {
      $message[] = 'Ce produit existe déjà !';
   } else {
      //sinon on insert les données dans la table 'products' dans la BDD
      $insert_produits = $conn->prepare("INSERT INTO `products`(libelle, details, prix, image, categorie) VALUES(?,?,?,?,?)");
      $insert_produits->execute([$libelle, $details, $prix, $image, $categorie]);

      //vérification de la taille de l'image
      if ($insert_produits) {
         if ($image_size > 2000000) {
            //si l'image est trop grande on affiche ce message
            $message[] = 'La taille de l\'image est trop grande';
         } else {
            //déplacement de l'image du dossier temporaire au dossier images
            move_uploaded_file($image_tmp_name, $image_folder);
            //message de confirmation d'ajout du produit
            $message[] = 'Produit ajouté avec succès !';
         }
      }
   }
}

//fonction de suppression des produits
if (isset($_GET['delete'])) {
   //association avec le bouton de suppression
   $delete_idproduit = $_GET['delete'];
   //lien avec la table produits par rapport à l'ID
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id= ?");
   $delete_product_image->execute([$delete_idproduit]);
   //suppression du produit dans la table
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_idproduit]);
   //suppression du produit dans le panier
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart->execute([$delete_idproduit]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Produits</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php' ?>

   <!-- Formulaire d'ajout de produits -->

   <section class="add-products">

      <h1 class="heading">Ajouter un produit</h1>

      <form action="" method="post" enctype="multipart/form-data">
         <div class="flex">
            <div class="inputbox">
               <label class="title">Image</label>
               <input type="file" name="image" class="box" accept="image.png, image.jpeg, image.jpg" required>
            </div>

            <div class="inputbox">
               <label class="title">Libellé</label>
               <input type="text" name="libelle" class="box" placeholder="Libellé du produit" required>
            </div>

            <div class="inputbox">
               <label class="title">Description</label>
               <input type="text" name="details" class="box" placeholder="Description" required>
            </div>

            <div class="inputbox">
               <label class="title">Prix</label>
               <input type="number" name="prix" class="box" placeholder="Prix" required>
            </div>

            <div class="inputbox">
               <label class="title">Catégorie</label>
               <input type="text" name="categorie" class="box" placeholder="Catégorie" required>
            </div>

            <input type="submit" value="Ajouter un produit" class="option-btn" name="add_product">
         </div>
      </form>

   </section>

   <!-- Affichage des produits -->

   <section class="show-products">

      <h1 class="heading">Produits ajoutés</h1>

      <div class="box-container">

         <?php
         //on va chercher la table produits
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         //par association on récupère les données de la table 'products'
         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <!-- On les affiche ensuite dans le HTML -->
               <div class="box">
                  <img src="assets/images/<?= $fetch_products['image']; ?>" alt="">
                  <h3>Libellé</h3>
                  <div class="libelle"><?= $fetch_products['libelle']; ?></div>
                  <h3>Description</h3>
                  <div class="description"><span><?= $fetch_products['details']; ?></span></div>
                  <h3>Prix</h3>
                  <div class="prix"><span><?= $fetch_products['prix'] . ' €'; ?></span></div>
                  <h3>Catégorie</h3>
                  <div class="categorie"><span><?= $fetch_products['categorie']; ?></span></div>
                  <div class="flex-btn">
                     <!-- bouton pour modifier et supprimer le produit -->
                     <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Modifier</a>
                     <a href="produits.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Voulez-vous supprimer ce produit ?');">Supprimer</a>
                  </div>
               </div>
         <?php
            }
         } else {
            // s'il n'y a aucun produit ce message s'affiche
            echo '<p class="empty">Aucun produit ajouté !</p>';
         }
         ?>

      </div>

   </section>


   <script src="assets/js/admin_script.js"></script>

</body>

</html>