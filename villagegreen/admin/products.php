<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
};

if (isset($_POST['add_product'])) {

   $libelle = $_POST['libelle'];
   $libelle = htmlspecialchars($libelle);
   $details = $_POST['details'];
   $details = htmlspecialchars($details);
   $prix = $_POST['prix'];
   $prix = htmlspecialchars($prix);
   $categorie = $_POST['categorie'];
   $categorie = htmlspecialchars($categorie);

   $image = $_FILES['image']['name'];
   $image = htmlspecialchars($image);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'assets/images/BODY/' . $image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if ($select_products->rowCount() > 0) {
      $message[] = 'product name already exist!';
   } else {

      $insert_products = $conn->prepare("INSERT INTO `products`(libelle, details, prix, image, categorie) VALUES(?,?,?,?,?)");
      $insert_products->execute([$libelle, $details, $prix, $image, $categorie]);

      if ($insert_products) {
         if ($image_size > 2000000) {
            $message[] = 'image size is too large!';
         } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'new product added!';
         }
      }
   }
};

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/' . $fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="add-products">

      <h1 class="heading">add product</h1>

      <form action="" method="post" enctype="multipart/form-data">
         <div class="flex">
            <div class="inputBox">
               <span>Libellé</span>
               <input type="text" class="box" required maxlength="100" placeholder="Libellé du produit" name="libelle">
            </div>
            <div class="inputBox">
               <span>Prix</span>
               <input type="number" min="0" class="box" required max="9999999999" placeholder="Prix" onkeypress="if(this.value.length == 10) return false;" name="prix">
            </div>
            <div class="inputBox">
               <span>Image</span>
               <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
               <span>Description</span>
               <input type="text" name="details" placeholder="Description du produit" class="box" required></inp>
            </div>
            <div class="inputBox">
               <span>Categorie</span>
               <input type="text" name="categorie" placeholder="Catégorie du produit" class="box" required></inp>
            </div>
         </div>

         <input type="submit" value="add product" class="btn" name="add_product">
      </form>

   </section>

   <section class="show-products">

      <h1 class="heading">products added</h1>

      <div class="box-container">

         <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <div class="box">
                  <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                  <div class="name"><?= $fetch_products['name']; ?></div>
                  <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
                  <div class="details"><span><?= $fetch_products['details']; ?></span></div>
                  <div class="flex-btn">
                     <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
                     <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
                  </div>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>

      </div>

   </section>

   <script src="assets/js/admin_script.js"></script>

</body>

</html>