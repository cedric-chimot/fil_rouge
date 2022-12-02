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

//paramétrage de la fonction 'update'
if (isset($_POST['update'])) {

   //déclaration des variables
   $pid = $_POST['pid'];
   $libelle = $_POST['libelle'];
   //'htmlspecialchars' : Convertit les caractères spéciaux en entités HTML
   $libelle = htmlspecialchars($libelle);
   $details = $_POST['details'];
   $details = htmlspecialchars($details);
   $prix = $_POST['prix'];
   $prix = htmlspecialchars($prix);
   $categorie = $_POST['categorie'];
   $categorie = htmlspecialchars($categorie);

   //on va chercher la table 'products' en intégrant la requête de modification
   $update_product = $conn->prepare("UPDATE `products` SET libelle = ?, details = ?, prix = ?, categorie = ? WHERE id = ?");
   $update_product->execute([$libelle, $details, $prix, $categorie, $pid]);

   //lorsque la modification est réussie on affiche ce message
   $message[] = 'Produit modifié avec succès !';

   //paramétrage de la modification de l'image
   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = htmlspecialchars($image);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'assets/images/' . $image;

   //si l'input 'image' n'est pas vide on vérifie la taill de l'image
   if (!empty($image)) {
      //si la taille de l'image est trop grande on renvoie un message d'erreur
      if ($image_size > 2000000) {
         $message[] = 'La taille de l\'image est trop grande !';
      } else {
         //sinon on modifie l'image de l'annonce
         $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);
         //'move_uploaded_file' : pour déplacer un fichier du dossier temporaire au dossier images
         move_uploaded_file($image_tmp_name, $image_folder);
         //'unlink' : on supprime l'ancienne image dans le dossier
         unlink('assets/images/' . $old_image);
         $message[] = 'Image modifiée !';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Modifier un produit</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/admin_style.css">
</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="update-product">

      <h1 class="heading">Modifier un produit</h1>

      <?php
      //on va chercher le 'name' du bouton sur la fiche produit
      $update_id = $_GET['update'];
      //on prend le produit correspondant à l'ID associé au bouton
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);
      if ($select_products->rowCount() > 0) {
         //on associe par un fetch la table 'products' pour ressortir les données
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <!-- formulaire de modification du produit pré-rempli -->
            <form action="" method="post" enctype="multipart/form-data">
               <!-- input type 'hidden' pour lier l'ID et l'image du produit aux variables -->
               <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
               <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
               <div class="image-container">
                  <div class="main-image">
                     <img src="assets/images/<?= $fetch_products['image']; ?>" alt="">
                  </div>
               </div>
               <span>Modifier le libellé</span>
               <input type="text" name="libelle" required class="box" maxlength="100" placeholder="Libellé" value="<?= $fetch_products['libelle']; ?>">
               <span>Modifier le prix</span>
               <input type="number" name="prix" required class="box" min="0" max="9999999999" placeholder="Prix" value="<?= $fetch_products['prix']; ?>">
               <span>Modifier la description</span>
               <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
               <span>Modifier l'image</span>
               <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
               <span>Modifier la catégorie</span>
               <input type="text" name="categorie" class="box" value="<?= $fetch_products['categorie']; ?>">
               <div class="flex-btn">
                  <input type="submit" name="update" class="option-btn" value="Modifier">
                  <a href="products.php" class="delete-btn">Retour</a>
               </div>
            </form>

      <?php
         }
      } else {
         //s'il n'y a pas de produits on affiche ce message
         echo '<p class="empty">Aucun produits !</p>';
      }
      ?>

   </section>

   <script src="assets/js/admin_script.js"></script>

</body>

</html>